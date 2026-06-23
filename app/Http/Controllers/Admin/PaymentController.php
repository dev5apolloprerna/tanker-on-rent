<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
use App\Models\OrderPayment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'    => ['required','integer','min:0'],
            'is_discount_amount' => ['nullable','boolean'],
            'paid_amount' => ['required_if:is_discount_amount,0','nullable','numeric','min:1'],
            'discount_amount' => ['required_if:is_discount_amount,1','nullable','numeric','min:1'],
            'payment_date' => ['required','date'],
            'payment_received_by' => ['required_unless:is_discount_amount,1','nullable','integer','exists:payment_received_user,received_id'],
            'customer_id' => ['nullable','integer'],
         ]);

        /** @var OrderMaster $order */
        $order = null;
        if ((int) $data['order_id'] > 0) {
            $order = OrderMaster::findOrFail((int) $data['order_id']);
        }

        $customerId = (int) ($data['customer_id'] ?? ($order->customer_id ?? 0));
        if ($customerId <= 0) {
            return back()->with('error', 'Customer is required for overall payment entry.');
        }

        $normalizeAmount = static function ($value): int {
            if (is_int($value) || is_float($value)) {
                return (int) round((float) $value);
            }

            return (int) round((float) preg_replace('/[^\d.-]/', '', (string) $value));
        };

        $isDiscount = (bool) ($data['is_discount_amount'] ?? false);
        $newPaid = $isDiscount ? 0 : $normalizeAmount($data['paid_amount'] ?? 0);
        $newDiscount = $isDiscount ? $normalizeAmount($data['discount_amount'] ?? 0) : 0;
        $appliedAmount = $newPaid + $newDiscount;


        $customerTotalDue = 0;
        $customerIds = $this->matchingCustomerIds($customerId, $order);
        $customerOrders = OrderMaster::notDeleted()
            ->whereIn('customer_id', $customerIds)
            ->get();
        $orderPaidSoFar = 0;

        foreach ($customerOrders as $customerOrder) {
            $customerSnap = $customerOrder->dueSnapshot();
            $customerTotalDue += $normalizeAmount($customerSnap['total_due'] ?? 0);
            $orderPaymentPaid = $normalizeAmount(
                $customerOrder->paymentMaster()
                    ->where('isDelete', 0)
                    ->sum('paid_amount')
            );
            $orderPaidSoFar += max($orderPaymentPaid, max(0, $normalizeAmount($customerOrder->advance_amount ?? 0)));

        }

        $overallPaidSoFar = $normalizeAmount(
            OrderPayment::whereIn('customer_id', $customerIds)
                ->where('order_id', 0)
                ->where('isDelete', 0)
                ->sum('paid_amount')
        );

        $paidGivenSoFar = $orderPaidSoFar + $overallPaidSoFar;

        $discountGivenSoFar = $normalizeAmount(
            OrderPayment::whereIn('customer_id', $customerIds)
                ->where('isDelete', 0)
                ->sum(DB::raw('COALESCE(discount_amount, 0)'))
        );
        $unpaidBefore = max(0, $customerTotalDue - $paidGivenSoFar - $discountGivenSoFar);
        $availableAmount = $unpaidBefore;

        if ($isDiscount && $unpaidBefore <= 0) {
            $availableAmount = $paidGivenSoFar;
        }

        if ($appliedAmount > $availableAmount) {
            return back()->with('error', ($isDiscount ? 'Discount amount' : 'Paid amount') . ' cannot exceed ' . ($isDiscount && $unpaidBefore <= 0 ? 'overall paid amount.' : 'current unpaid.'));
        }

        return DB::transaction(function () use ($customerId, $newPaid, $newDiscount, $appliedAmount, $unpaidBefore, $customerTotalDue, $request, $isDiscount) {
            $newUnpaid = max(0, $unpaidBefore - $appliedAmount);
                        
            OrderPayment::create([
                'customer_id'         => $customerId,
                // This endpoint records customer-level collection, not tanker-level payment.
                'order_id'            => 0,
                'total_amount'        => $isDiscount ? $customerTotalDue : $unpaidBefore,
                'paid_amount'         => $newPaid,
                'unpaid_amount'       => $newUnpaid,
                'is_discount_amount'  => $isDiscount ? 1 : 0,
                'discount_amount'     => $newDiscount,
                'payment_date'        => $request->payment_date,
                'payment_received_by' => $isDiscount ? null : $request->payment_received_by,
                'iStatus'             => 1,
                'isDelete'            => 0,
            ]);

            return back()->with('success', $isDiscount ? 'Discount recorded.' : 'Payment recorded.');
        });
    }
    public function history(Request $request, $orderId)
    {
        $order = OrderMaster::findOrFail($orderId);
        $customerId = (int) ($request->get('customer_id') ?: $order->customer_id);
        $customerIds = $this->matchingCustomerIds($customerId, $order);
        
        $payments = OrderPayment::with('PaymentReceivedUser')
            ->whereIn('customer_id', $customerIds)
            ->where('isDelete', 0)
            ->where(function ($q) use ($orderId) {
                $q->where('order_id', $orderId)->where('isDelete', 0)->orWhere('order_id', 0);
            })
            ->orderBy('payment_id', 'asc')
            ->get();
           

        $snap = $order->dueSnapshot(); // base, extra, total_due, paid_sum, unpaid, extra_days
        $overallPaid = (float) OrderPayment::whereIn('customer_id', $customerIds)
            ->where('order_id', 0)->where('isDelete', 0)
            ->sum('paid_amount');

        $overallDiscount = (float) OrderPayment::whereIn('customer_id', $customerIds)
            ->where('order_id', 0)->where('isDelete', 0)
            ->sum(DB::raw('COALESCE(discount_amount, 0)'));
        $overallApplied = $overallPaid + $overallDiscount;
        $customerOrders = OrderMaster::notDeleted()
            ->with(['tanker'])
            ->whereIn('customer_id', $customerIds)
            ->orderByDesc('order_id')
            ->get();

        $customerTotals = [
            'total_due' => 0,
            'paid' => 0,
            'discount' => 0,
            'unpaid' => 0,
        ];

        $remainingOverallPaid = $overallPaid;
        $remainingOverallDiscount = $overallDiscount;
        $remainingOverallApplied = $overallApplied;

        foreach ($customerOrders as $customerOrder) {
            $customerSnap = $customerOrder->dueSnapshot();
            $startingUnpaid = (float) ($customerSnap['unpaid'] ?? 0);
            $allocatedPaid = min($remainingOverallPaid, $startingUnpaid);
            $allocatedDiscount = min($remainingOverallDiscount, $startingUnpaid);
            $allocatedApplied = $allocatedPaid + $allocatedDiscount;
            $remainingOverallApplied = max(0, $remainingOverallApplied - $allocatedApplied);

            $remainingOverallPaid -= $allocatedPaid;
            $remainingOverallDiscount -= $allocatedDiscount;

            $customerSnap['paid_sum'] = (float) ($customerSnap['paid_sum'] ?? 0) + $allocatedPaid;
            $customerSnap['discount_sum'] = (float) ($customerSnap['discount_sum'] ?? 0) + $allocatedDiscount;
            $customerSnap['unpaid'] = max(0, $startingUnpaid - $allocatedApplied);

            $customerSnap['customer_paid_allocation'] = $allocatedPaid;
            $customerSnap['customer_discount_allocation'] = $allocatedDiscount;

            $customerOrder->customer_snapshot = $customerSnap;
            $customerTotals['total_due'] += (float) ($customerSnap['total_due'] ?? 0);
            $customerTotals['paid'] += (float) ($customerSnap['paid_sum'] ?? 0);
            $customerTotals['discount'] += (float) ($customerSnap['discount_sum'] ?? 0);
            $customerTotals['unpaid'] += (float) ($customerSnap['unpaid'] ?? 0);
        }

        
        return view('admin.payments._history', compact('order', 'payments', 'snap', 'customerOrders', 'customerTotals'));
    }
     private function matchingCustomerIds(int $customerId, ?OrderMaster $order = null): array
    {
        $customer = Customer::find($customerId);

        if (! $customer && $order) {
            $customer = $order->customer;
        }

        if (! $customer) {
            return [$customerId];
        }

        $name = trim((string) $customer->customer_name);
        $mobile = trim((string) $customer->customer_mobile);

        $ids = Customer::query()
            ->where(function ($query) use ($name, $mobile) {
                if ($name !== '') {
                    $query->where('customer_name', $name);
                }

                if ($mobile !== '') {
                    $method = $name !== '' ? 'orWhere' : 'where';
                    $query->{$method}('customer_mobile', $mobile);
                }
            })
            ->pluck('customer_id')
            ->map(fn ($id) => (int) $id)
            ->push($customerId)
            ->unique()
            ->values()
            ->all();

        return $ids ?: [$customerId];
    }

    public function destroy(Request $request, $paymentId)
    {

        $payment = OrderPayment::where('payment_id', $paymentId)
            ->where('isDelete', 0)
            ->first();

        if (! $payment) {
            $message = 'Payment record was already deleted or could not be found.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => $message], 404);
            }

            return back()->with('error', $message);
        }

        $payment->delete();
        
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'Payment deleted successfully.']);
        }

        return back()->with('success', 'Payment deleted successfully.');
    }
}