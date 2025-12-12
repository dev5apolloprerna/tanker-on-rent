<?php

namespace App\Services;

use App\Models\DailyOrder;
use App\Models\DailyOrderLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LedgerService
{
    /** Add a DEBIT entry for an order (customer owes money). */
    public function addDebitForOrder(DailyOrder $order, string $comment = 'Order debit'): DailyOrderLedger
    {
        $cid = (int) ($order->customer_id ?? 0); // ✅ guard
        return $this->append($cid, [
            'daily_order_id' => $order->daily_order_id,
            'entry_date'     => Carbon::parse($order->rent_date)->toDateString(),
            'comment'        => $comment,
            'debit_bl'       => number_format((float)$order->total_amount, 2, '.', ''),
            'credit_bl'      => 0,
            'iStatus'        => 1,
            'isDelete'       => 0,
        ]);
    }

    /** Add a CREDIT entry (payment received). */
    public function addCreditPayment(
        int $customerId,
        float $amount,
        string $comment = 'Payment received',
        ?string $entryDate = null,
        ?int $dailyOrderId = null
    ): DailyOrderLedger {
        $cid = (int) $customerId; // ✅ normalize
        return $this->append($cid, [
            'daily_order_id' => $dailyOrderId,
            'entry_date'     => $entryDate ? Carbon::parse($entryDate)->toDateString() : now()->toDateString(),
            'comment'        => $comment,
            'debit_bl'       => 0,
            'credit_bl'      => number_format((float)$amount, 2, '.', ''),
            'iStatus'        => 1,
            'isDelete'       => 0,
        ]);
    }

    /**
     * Adjust by delta (used when order amount changes).
     * Positive delta -> DEBIT; Negative delta -> CREDIT.
     */
    public function adjustForOrderDelta(DailyOrder $order, int $delta): ?DailyOrderLedger
    {
        if ($delta === 0) return null;

        $cid = (int) ($order->customer_id ?? 0); // ✅ guard
        if ($delta > 0) {
            return $this->append($cid, [
                'daily_order_id' => $order->daily_order_id,
                'entry_date'     => now()->toDateString(),
                'comment'        => 'Order amount increased',
                'debit_bl'       => number_format($delta, 2, '.', ''),
                'credit_bl'      => 0,
                'iStatus'        => 1,
                'isDelete'       => 0,
            ]);
        }

        return $this->append($cid, [
            'daily_order_id' => $order->daily_order_id,
            'entry_date'     => now()->toDateString(),
            'comment'        => 'Order amount decreased',
            'debit_bl'       => 0,
            'credit_bl'      => number_format(abs($delta), 2, '.', ''),
            'iStatus'        => 1,
            'isDelete'       => 0,
        ]);
    }

    /** Mark order reversal on delete (credit back full amount). */
    public function reverseOrder(DailyOrder $order, string $comment = 'Order reversed'): DailyOrderLedger
    {
        $cid = (int) ($order->customer_id ?? 0); // ✅ guard
        return $this->append($cid, [
            'daily_order_id' => $order->daily_order_id,
            'entry_date'     => now()->toDateString(),
            'comment'        => $comment,
            'debit_bl'       => 0,
            'credit_bl'      => number_format((float)$order->total_amount, 2, '.', ''),
            'iStatus'        => 1,
            'isDelete'       => 0,
        ]);
    }

    /**
     * Core appender with running balance (uses SELECT ... FOR UPDATE).
     * Accepts nullable id and normalizes to 0 to avoid type errors.
     */

protected function append(?int $customerId, array $payload): DailyOrderLedger
{
    $customerId = (int) ($customerId ?? 0);

    return DB::transaction(function () use ($customerId, $payload) {
        $orderId = (int) ($payload['daily_order_id'] ?? 0);

        $debit  = (float) ($payload['debit_bl']  ?? 0);
        $credit = (float) ($payload['credit_bl'] ?? 0);

        // ---------- PER-ORDER CLOSING (customer_id + daily_order_id) ----------
        if ($orderId > 0) {
            // Lock all existing rows for this (customer, order) to build a safe running balance
            $sum = DailyOrderLedger::query()
                ->where('customer_id', $customerId)
                ->where('daily_order_id', $orderId)
                ->where('isDelete', 0)
                ->where('iStatus', 1)
                ->lockForUpdate()
                ->selectRaw('COALESCE(SUM(debit_bl),0) AS deb, COALESCE(SUM(credit_bl),0) AS cred')
                ->first();

            $prevOrderBal = ((float)$sum->deb - (float)$sum->cred);
            // New closing for THIS order; clamp tiny negatives to 0 (fully paid)
            $closing = max(0, round($prevOrderBal + $debit - $credit, 2));
        }
        // ---------- FALLBACK: CUSTOMER-LEVEL CLOSING (no order_id given) ----------
        else {
            $last = DailyOrderLedger::where('customer_id', $customerId)
                ->orderByDesc('entry_date')
                ->orderByDesc('ledger_id')
                ->lockForUpdate()
                ->first();

            $prevClosing = $last ? (float) $last->closing_bl : 0.0;
            $closing = round($prevClosing + $debit - $credit, 2);
        }

        $row = new DailyOrderLedger(array_merge($payload, [
            'customer_id' => $customerId,
            'closing_bl'  => number_format($closing, 2, '.', ''),
        ]));

        $row->save();
        return $row;
    });
}

}
