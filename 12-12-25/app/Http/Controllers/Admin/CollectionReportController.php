<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->query('from');
        $to   = $request->query('to');

        // Default to current month if not provided
        if (!$from || !$to) {
            $from = now()->startOfMonth()->toDateString();
            $to   = now()->endOfMonth()->toDateString();
        }

        // ---- Daily Order payments (credits) ----
        $daily = DB::table('daily_order_ledger as l')
            ->selectRaw('l.entry_date as tx_date, SUM(l.credit_bl) as amount, COUNT(*) as entries')
            ->where('l.iStatus', 1)
            ->where('l.isDelete', 0)
            ->where('l.credit_bl', '>', 0)
            ->whereBetween('l.entry_date', [$from, $to])
            ->whereNotNull('daily_order_id')
            ->groupBy('l.entry_date');

        // ---- Order payments (adjust table/columns if your schema differs) ----
        // Table: order_payment_master; amount: paid_amount; date: payment_date (fallback created_at)
        $dateExpr = DB::raw('COALESCE(DATE(p.payment_date), DATE(p.created_at))');

        $orders = DB::table('order_payment_master as p')
            ->selectRaw(''.$dateExpr.' as tx_date, SUM(p.paid_amount) as amount, COUNT(*) as entries')
            ->where('p.iStatus', 1)   // <— uses iStatus=1
            ->where('p.isDelete', 0)  // <— uses isDelete=0
            ->whereBetween($dateExpr, [$from, $to])
            ->groupBy($dateExpr);

        // Union both sources by date, then aggregate
        $rows = DB::query()
            ->fromSub($daily->unionAll($orders), 'u')
            ->selectRaw('u.tx_date, SUM(u.amount) as total_amount, SUM(u.entries) as total_entries')
            ->groupBy('u.tx_date')
            ->orderByDesc('u.tx_date')
            ->get();

        $grand_total   = (float) $rows->sum('total_amount');
        $grand_entries = (int)   $rows->sum('total_entries');

        return view('admin.reports.collection', compact('rows', 'from', 'to', 'grand_total', 'grand_entries'));
    }

    /**
     * Per-day detail view (all collection lines for one date).
     */
    public function day(string $date, Request $request)
    {
        // Daily Order credit lines
        $dql = DB::table('daily_order_ledger as l')
            ->leftJoin('daily_order as d', 'd.daily_order_id', '=', 'l.daily_order_id')
            ->leftJoin('customer_master as c', 'c.customer_id', '=', 'l.customer_id') // adjust table name if different
            ->where('l.iStatus', 1)
            ->where('l.isDelete', 0)
            ->where('l.credit_bl', '>', 0)
            ->whereDate('l.entry_date', $date)
            ->selectRaw("
                'daily' as src,
                l.ledger_id      as id,
                l.credit_bl      as amount,
                l.entry_date     as tx_date,
                l.created_at     as tx_time,
                l.daily_order_id as ref_id,
                c.customer_name  as customer_name
            ");

        // Order payments
        $oql = DB::table('order_payment_master as p')
            ->leftJoin('order_master as o', 'o.order_id', '=', 'p.order_id')
            ->leftJoin('customer_master as c', 'c.customer_id', '=', 'o.customer_id')
            ->where('p.iStatus', 1)
            ->where('p.isDelete', 0)
            ->whereDate(DB::raw('COALESCE(DATE(p.payment_date), DATE(p.created_at))'), $date)
            ->selectRaw("
                'order' as src,
                p.payment_id     as id,
                p.paid_amount    as amount,
                COALESCE(DATE(p.payment_date), DATE(p.created_at)) as tx_date,
                COALESCE(p.payment_date, p.created_at) as tx_time,
                p.order_id       as ref_id,
                c.customer_name  as customer_name
            ");

        $rows = DB::query()->fromSub($dql->unionAll($oql), 'x')
            ->orderBy('x.tx_time')
            ->get();

        $total_amount   = (float) $rows->sum('amount');
        $count          = (int)   $rows->count();
        $daily_subtotal = (float) $rows->where('src','daily')->sum('amount');
        $order_subtotal = (float) $rows->where('src','order')->sum('amount');

        return view('admin.reports.collection_day', compact('date','rows','total_amount','count','daily_subtotal','order_subtotal'));
    }

    /**
     * Full-detail view for the selected range (defaults to current month).
     */
    public function range(Request $request)
    {
        $from = $request->query('from');
        $to   = $request->query('to');
        if (!$from || !$to) {
            $from = now()->startOfMonth()->toDateString();
            $to   = now()->endOfMonth()->toDateString();
        }

        $dql = DB::table('daily_order_ledger as l')
            ->leftJoin('daily_order as d', 'd.daily_order_id', '=', 'l.daily_order_id')
            ->leftJoin('customer_master as c', 'c.customer_id', '=', 'l.customer_id')
            ->where('l.iStatus', 1)
            ->where('l.isDelete', 0)
            ->where('l.credit_bl', '>', 0)
            ->whereBetween('l.entry_date', [$from, $to])
            ->selectRaw("
                'daily' as src,
                l.ledger_id      as id,
                l.credit_bl      as amount, 
                l.entry_date     as tx_date,
                l.created_at     as tx_time,
                l.daily_order_id as ref_id,
                c.customer_name  as customer_name
            ");

        $dateExpr = DB::raw('COALESCE(DATE(p.payment_date), DATE(p.created_at))');

        $oql = DB::table('order_payment_master as p')
            ->leftJoin('order_master as o', 'o.order_id', '=', 'p.order_id')
            ->leftJoin('customer_master as c', 'c.customer_id', '=', 'o.customer_id')
            ->where('p.iStatus', 1)
            ->where('p.isDelete', 0)
            ->whereBetween($dateExpr, [$from, $to])
            ->selectRaw("
                'order' as src,
                p.payment_id     as id,
                p.paid_amount    as amount,
                ".$dateExpr." as tx_date,
                COALESCE(p.payment_date, p.created_at) as tx_time,
                p.order_id       as ref_id,
                c.customer_name  as customer_name
            ");

        $rows = DB::query()->fromSub($dql->unionAll($oql), 'x')
            ->orderBy('x.tx_date')->orderBy('x.tx_time')
            ->get();

        $total_amount   = (float) $rows->sum('amount');
        $count          = (int)   $rows->count();
        $daily_subtotal = (float) $rows->where('src','daily')->sum('amount');
        $order_subtotal = (float) $rows->where('src','order')->sum('amount');

        return view('admin.reports.collection_range', compact('rows','from','to','total_amount','count','daily_subtotal','order_subtotal'));
    }
}
