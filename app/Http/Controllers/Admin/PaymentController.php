<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
use App\Models\OrderPayment;
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
        $customerOrders = OrderMaster::notDeleted()
            ->where('customer_id', $customerId)
            ->get();

        foreach ($customerOrders as $customerOrder) {
            $customerSnap = $customerOrder->dueSnapshot();
            $customerUnpaid += $normalizeAmount($customerSnap['unpaid'] ?? 0);
        }

        $overallPaidSoFar = $normalizeAmount(
            OrderPayment::where('customer_id', $customerId)
                ->where('order_id', 0)
                ->sum('paid_amount')
        );

        $unpaidBefore = max(0, $customerUnpaid - $overallPaidSoFar);


        if ($newPaid > $unpaidBefore) {
            return back()->with('error', 'Paid amount cannot exceed current unpaid.');
        }

        return DB::transaction(function () use ($order, $customerId, $newPaid, $unpaidBefore, $request) {
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

        $payments = OrderPayment::with('PaymentReceivedUser')
            ->where('customer_id', $customerId)
            ->where(function ($q) use ($orderId) {
                $q->where('order_id', $orderId)->orWhere('order_id', 0);
            })
            ->orderBy('payment_id', 'asc')
            ->get();
           

        $snap = $order->dueSnapshot(); // base, extra, total_due, paid_sum, unpaid, extra_days
        $overallPaid = (float) OrderPayment::where('customer_id', $customerId)
            ->where('order_id', 0)
            ->sum('paid_amount');
        $customerOrders = OrderMaster::notDeleted()
            ->with(['tanker'])
            ->where('customer_id', $customerId)
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
}
