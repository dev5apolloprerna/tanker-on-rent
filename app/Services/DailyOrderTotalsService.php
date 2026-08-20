<?php

namespace App\Services;

use App\Models\DailyOrderLedger;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DailyOrderTotalsService
{
    /**
     * Calculate the amounts shown by the Daily Orders listing.
     *
     * Only active, non-deleted ledger credits attached to a non-deleted order
     * count as received payments.
     */
    public function calculate(Collection $orders, float $rate, bool $attachToOrders = false): array
    {
        $totals = [
            'days' => 0,
            'base' => 0.0,
            'extra' => 0.0,
            'stored' => 0.0,
            'grand' => 0.0,
            'paid' => 0.0,
            'due' => 0.0,
        ];

        $credits = DailyOrderLedger::query()
            ->whereIn('daily_order_id', $orders->pluck('daily_order_id')->filter())
            ->where('iStatus', 1)
            ->where('isDelete', 0)
            ->selectRaw('daily_order_id, SUM(credit_bl) as paid')
            ->groupBy('daily_order_id')
            ->pluck('paid', 'daily_order_id');

        foreach ($orders as $order) {
            $start = $order->rent_date
                ? Carbon::parse($order->rent_date)->startOfDay()
                : null;
            $end = $order->received_at
                ? Carbon::parse($order->received_at)->startOfDay()
                : now()->startOfDay();
            $days = $start ? max(0, $start->diffInDays($end)) : 0;
            $base = $days >= 1 ? $rate : 0.0;
            $extra = max(0, $days - 1) * $rate;
            $stored = (float) ($order->total_amount ?? 0);
            $grand = round($stored + $extra, 2);
            $paid = round((float) ($credits[$order->daily_order_id] ?? 0), 2);
            $due = max(0, $grand - $paid);

            if ($attachToOrders) {
                $order->calc_days = $days;
                $order->calc_base = round($base, 2);
                $order->calc_extra = round($extra, 2);
                $order->calc_stored = round($stored, 2);
                $order->calc_grand = $grand;
                $order->calc_paid = $paid;
                $order->calc_due = round($due, 2);
            }

            $totals['days'] += $days;
            $totals['base'] += $base;
            $totals['extra'] += $extra;
            $totals['stored'] += $stored;
            $totals['grand'] += $grand;
            $totals['paid'] += $paid;
            $totals['due'] += $due;
        }

        return $totals;
    }
}
