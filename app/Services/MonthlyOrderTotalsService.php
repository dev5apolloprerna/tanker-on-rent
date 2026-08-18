<?php

namespace App\Services;

use App\Models\OrderPayment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MonthlyOrderTotalsService
{
    /**
     * Calculate the paid, discount and unpaid totals shown for monthly orders.
     *
     * Customer-level payments (rows with order_id = 0) are applied once per
     * customer, after the order-specific ledger amounts have been calculated.
     */
    public function calculate(Collection $orders): array
    {
        $totals = [
            'total' => 0.0,
            'paid' => 0.0,
            'discount' => 0.0,
            'unpaid' => 0.0,
        ];
        $customerIds = [];

        foreach ($orders as $order) {
            $snapshot = $order->dueSnapshot();
            $totals['total'] += (float) ($snapshot['total_due'] ?? 0);
            $totals['paid'] += (float) ($snapshot['paid_sum'] ?? 0);
            $totals['discount'] += (float) ($snapshot['discount_sum'] ?? 0);
            $totals['unpaid'] += (float) ($snapshot['unpaid'] ?? 0);
            $customerIds[] = (int) $order->customer_id;
        }

        $customerIds = array_values(array_unique($customerIds));
        if ($customerIds === []) {
            return $totals;
        }

        $overallPayments = OrderPayment::query()
            ->whereIn('customer_id', $customerIds)
            ->where('order_id', 0)
            ->where('isDelete', 0)
            ->select(
                'customer_id',
                DB::raw('SUM(paid_amount) as total_paid'),
                DB::raw('SUM(COALESCE(discount_amount, 0)) as total_discount')
            )
            ->groupBy('customer_id')
            ->get();

        foreach ($overallPayments as $payment) {
            $paid = (float) ($payment->total_paid ?? 0);
            $discount = (float) ($payment->total_discount ?? 0);

            $totals['paid'] += $paid;
            $totals['discount'] += $discount;
            $totals['unpaid'] = max(0, $totals['unpaid'] - $paid - $discount);
        }

        return $totals;
    }
}
