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
            'paid_amount' => ['required','numeric','min:1'],
            'payment_date' => ['required','date'],
            'payment_received_by' => ['required','integer','exists:payment_received_user,received_id'],
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

        $newPaid = $normalizeAmount($data['paid_amount']);

        $customerUnpaid = 0;
        $customerIds = $this->matchingCustomerIds($customerId, $order);
        $customerOrders = OrderMaster::notDeleted()
            ->whereIn('customer_id', $customerIds)
            ->get();

        foreach ($customerOrders as $customerOrder) {
            $customerSnap = $customerOrder->dueSnapshot();
            $customerUnpaid += $normalizeAmount($customerSnap['unpaid'] ?? 0);
        }

        $overallPaidSoFar = $normalizeAmount(
            OrderPayment::whereIn('customer_id', $customerIds)
                ->where('order_id', 0)->where('isDelete', 0)
                ->sum('paid_amount')
        );

        $unpaidBefore = max(0, $customerUnpaid - $overallPaidSoFar);


        if ($newPaid > $unpaidBefore) {
            return back()->with('error', 'Paid amount cannot exceed current unpaid.');
        }

        return DB::transaction(function () use ($customerId, $newPaid, $unpaidBefore, $request) {
        $newUnpaid = max(0, $unpaidBefore - $newPaid);
            
            OrderPayment::create([
                'customer_id'         => $customerId,
                // This endpoint records customer-level collection, not tanker-level payment.
                'order_id'            => 0,
                'total_amount'        => $unpaidBefore,
                'paid_amount'         => $newPaid,
                'unpaid_amount'       => $newUnpaid,
                'payment_date'        => $request->payment_date,
                'payment_received_by' => $request->payment_received_by,
                'iStatus'             => 1,
                'isDelete'            => 0,
            ]);

            return back()->with('success', 'Payment recorded.');
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
        $customerOrders = OrderMaster::notDeleted()
            ->with(['tanker'])
            ->whereIn('customer_id', $customerIds)
            ->orderByDesc('order_id')
            ->get();

        $customerTotals = [
            'paid' => 0,
            'unpaid' => 0,
        ];

        foreach ($customerOrders as $customerOrder) {
            $customerSnap = $customerOrder->dueSnapshot();
            $customerOrder->customer_snapshot = $customerSnap;
            $customerTotals['paid'] += (float) ($customerSnap['paid_sum'] ?? 0);
            $customerTotals['unpaid'] += (float) ($customerSnap['unpaid'] ?? 0);
        }

        $customerTotals['paid'] += $overallPaid;
        $customerTotals['unpaid'] = max(0, (float) $customerTotals['unpaid'] - $overallPaid);
        
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