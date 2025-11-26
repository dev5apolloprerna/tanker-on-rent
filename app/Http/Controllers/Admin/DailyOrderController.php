<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DailyOrder;
use App\Models\DailyOrderLedger;
use App\Models\Customer;
use App\Models\RentPrice;
use App\Services\LedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // top of file

use Illuminate\Validation\Rule;
use Carbon\Carbon;

class DailyOrderController extends Controller
{

    public function __construct(private LedgerService $ledger) {}

    public function index()
        {
            $rows = DailyOrder::where('isDelete', 0)
                ->orderByDesc('daily_order_id')
                ->paginate(20);
            
            $dailyrate=RentPrice::select('amount')->where(['rent_type'=>'Daily'])->first();
            $rate = $dailyrate->amount; // ₹/day default

            // running totals for footer
            $totals = [
                'days'   => 0,
                'base'   => 0.0,
                'extra'  => 0.0,
                'stored' => 0.0,   // total_amount from DB
                'grand'  => 0.0,   // stored + extra
                'paid'   => 0.0,
                'due'    => 0.0,
            ];

            $rows->getCollection()->transform(function ($r) use (&$totals, $rate) 
            {
                // dates
                $placed   = $r->rent_date; // start
                $received = $r->received_at;                   // end (if received)

                $start = $placed   ? Carbon::parse($placed)->startOfDay()   : null;
                $end   = $received ? Carbon::parse($received)->startOfDay() : now()->startOfDay();

                // NOT inclusive: 25->27 = 2
                $days  = $start ? max(0, $start->diffInDays($end)) : 0;

                // base/extra/total (base = first day)
                $base  = $days >= 1 ? $rate : 0;
                $extra = max(0, $days - 1) * $rate;

                // stored total from DB (may be 0/null)
                $stored = (float) ($r->total_amount ?? 0);

                // grand = stored total + runtime extra
                $grand = round($stored + $extra, 2);

                // paid from ledger (credits)
                $paid = (float) DailyOrderLedger::where('daily_order_id', $r->daily_order_id)
                            ->where('iStatus', 1)->where('isDelete', 0)
                            ->sum('credit_bl');

                // due against GRAND (as requested)
                $due = max(0, $grand - $paid);

                // attach for blade
                $r->calc_days   = $days;
                $r->calc_base   = round($base, 2);
                $r->calc_extra  = round($extra, 2);
                $r->calc_stored = round($stored, 2);
                $r->calc_grand  = round($grand, 2);
                $r->calc_paid   = round($paid, 2);
                $r->calc_due    = round($due, 2);

                // accumulate totals
                $totals['days']   += $days;
                $totals['base']   += $r->calc_base;
                $totals['extra']  += $r->calc_extra;
                $totals['stored'] += $r->calc_stored;
                $totals['grand']  += $r->calc_grand;
                $totals['paid']   += $r->calc_paid;
                $totals['due']    += $r->calc_due;

                return $r;
            });

            return view('admin.daily_orders.index', compact('rows', 'rate', 'totals'));
        }
        /*public function index(Request $request)
        {
            $customers = Customer::select('customer_id','customer_name','customer_mobile')
                ->orderBy('customer_name')
                ->get();

            // Add a subquery "paid_sum" = sum of credits tied to this order
            $rows = DailyOrder::query()
                ->where('isDelete', 0)
                ->select('daily_order.*')
                ->selectSub(function($q){
                    $q->from('daily_order_ledger as l')
                      ->selectRaw('COALESCE(SUM(l.credit_bl),0)')
                      ->whereColumn('l.daily_order_id','daily_order.daily_order_id')
                      ->where('l.isDelete', 0)
                      ->where('l.iStatus', 1);
                }, 'paid_sum')
                ->orderByDesc('daily_order_id')
                ->paginate(12);

            // Page totals (for the rows shown on current page)
            $coll = $rows->getCollection();
            $page_total_amount = (float) $coll->sum('total_amount');
            $page_total_paid   = (float) $coll->sum('paid_sum');
            $page_total_due    = $page_total_amount - $page_total_paid;

            return view('admin.daily_orders.index', compact(
                'customers', 'rows',
                'page_total_amount', 'page_total_paid', 'page_total_due'
            ));
        }*/

    public function create() {
        $customers = Customer::orderBy('customer_name')->get(['customer_id','customer_name','customer_mobile']);
        $recent = DailyOrder::latest('rent_date')->limit(8)->get();
        return view('admin.daily_orders.add-edit', compact('customers','recent'));
    }

    public function edit($id) {
        $order = DailyOrder::findOrFail($id);
        $customers = Customer::orderBy('customer_name')->get(['customer_id','customer_name','customer_mobile']);
        $recent = DailyOrder::latest('rent_date')->limit(8)->get();
        return view('admin.daily_orders.add-edit', compact('order','customers','recent'));
    }

 public function store(Request $request)
    {
        $validated = $this->validatePayload($request);

        if ($validated['customer_type'] === 'retail') {
            $customerId   = 0;
            $customerName = $validated['customer_name'];
            $mobile       = $validated['mobile'];
        } else {
            $customerId = (int) $request->input('customer_id');
            $cust       = Customer::find($customerId);
            $customerName = $request->input('customer_name') ?: ($cust->customer_name ?? '');
            $mobile       = $request->input('mobile') ?: ($cust->customer_mobile ?? '');
        }

        DB::transaction(function () use ($request, $customerId, $customerName, $mobile) {
            $order = DailyOrder::create([
                'customer_id'   => $customerId,
                'customer_name' => $customerName,
                'mobile'        => $mobile,
                'location'      => $request->input('location'),
                'rent_date'     => $request->input('rent_date'),
                'placed_the_tanker'  => $request->input('placed_the_tanker'),
                'empty_the_tanker'  => $request->input('empty_the_tanker'),
                'filled_the_tanker'  => $request->input('filled_the_tanker'),
                'total_amount'        => (float)$request->input('total_amount'),
                'isPaid'       => (int)$request->input('isPaid', 1),
                            ]);

            // Ledger: add a DEBIT for this order
            $this->ledger->addDebitForOrder($order, 'Order debit');
        });

        return redirect()->route('daily-orders.index')->with('success','Order saved.');
    }

    public function update(Request $request, DailyOrder $daily_order)
    {
        $validated  = $this->validatePayload($request);

        $isRetail   = $validated['customer_type'] === 'retail';
        $customerId = $isRetail ? 0 : (int) $request->input('customer_id');
        $cust       = $isRetail ? null : Customer::find($customerId);

        $customerName = $request->input('customer_name') ?: ($cust->customer_name ?? '');
        $mobile       = $request->input('mobile')        ?: ($cust->customer_mobile ?? '');

        DB::transaction(function () use ($request, $daily_order, $customerId, $customerName, $mobile) {
            $oldAmount = (float) ($daily_order->total_amount ?? 0);
            $newAmount = (float) $request->input('total_amount', 0); // ✅ match form field 'amount'

            // ✅ Direct assignment avoids $fillable issues; ensures customer_id is set (never null)
            $daily_order->customer_id       = (int) $customerId;
            $daily_order->customer_name     = $customerName;
            $daily_order->mobile            = $mobile;
            $daily_order->location          = $request->input('location');
            $daily_order->rent_date         = $request->input('rent_date');
            $daily_order->placed_the_tanker = $request->input('placed_the_tanker');
            $daily_order->empty_the_tanker  = $request->input('empty_the_tanker');
            $daily_order->filled_the_tanker = $request->input('filled_the_tanker');
            $daily_order->total_amount      = $newAmount;
            $daily_order->isPaid            = (int) $request->input('isPaid', 1);
            $daily_order->save();

            // ✅ Safe delta
            $delta = $newAmount - $oldAmount;
            if (abs($delta) > 0.0001) {
                $this->ledger->adjustForOrderDelta($daily_order, (int) round($delta));
            }
        });

        return redirect()->route('daily-orders.index')->with('success','Order updated.');
    }


        public function orderPayments(int $order)
        {
            // Order header
            $o = DB::table('daily_order')
                ->where('daily_order_id', $order)
                ->where('isDelete', 0)
                ->first();

            if (!$o) {
                return response()->view('admin.daily_orders._order_payments', [
                    'order' => null,
                    'rows'  => collect(),
                    'paid'  => 0.00,
                    'due'   => 0.00,
                ]);
            }

            // Only ledger rows tied to this order (payments only)
            $rows = DB::table('daily_order_ledger')
                ->where('daily_order_id', $order)
                ->where('isDelete', 0)
                ->where('iStatus', 1)
                ->where('credit_bl', '>', 0) // payments
                ->orderByDesc('entry_date')
                ->orderByDesc('ledger_id')
                ->get();

            $paid = (float) $rows->sum('credit_bl');
            $due  = max(0, (float)$o->total_amount - $paid);

            return view('admin.daily_orders._payments', [
                'order' => $o,
                'rows'  => $rows,
                'paid'  => $paid,
                'due'   => $due,
            ]);
        }


   public function destroy(string $id, LedgerService $ledger)
    {
        try {
            // Fetch by primary key (works even if implicit binding is misconfigured)
            $order = DailyOrder::whereKey($id)->firstOrFail();

            DB::transaction(function () use ($order, $ledger) {
                $amount     = (float) ($order->total_amount ?? 0);
                $customerId = (int)   ($order->customer_id ?? 0);

                // 1) Add reversal CREDIT WITHOUT tying to the order (avoids FK blocks)
                if ($amount > 0) {
                    $ledger->addCreditPayment(
                        $customerId,
                        $amount,
                        'Order reversed (Order#'.$order->daily_order_id.')',
                        now()->toDateString(),
                        null // ← do NOT link to the order
                    );
                }

                // 2) Detach any ledger rows pointing to this order (safe even w/o FK)
                DailyOrderLedger::where('daily_order_id', $order->daily_order_id)
                    ->update(['daily_order_id' => null]);

                // 3) Delete the order
                $order->delete();
            });

            return redirect()->route('daily-orders.index')->with('success', 'Order deleted.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Delete failed: '.$e->getMessage());
        }
    }


    /**
     * NEW: Receive a payment (credit) against an order (partial or full).
     */
    public function receivePayment(Request $request, DailyOrder $daily_order)
    {
        $request->validate([
            'total_amount'     => ['required','numeric','min:0.01'],
            'entry_date' => ['nullable','date'],
            'comment'    => ['nullable','string','max:255'],
        ]);

        $amount  = (float) $request->input('total_amount');
        $comment = $request->input('comment', 'Payment received');
        $date    = $request->input('entry_date'); // nullable -> defaults to today in service

        $this->ledger->addCreditPayment(
            customerId:   (int) $daily_order->customer_id,
            amount:       $amount,
            comment:      $comment ?: 'Payment received',
            entryDate:    $date,
            dailyOrderId: $daily_order->daily_order_id
        );

        return redirect()->route('daily-orders.index')->with('success','Payment recorded.');
    }

    protected function validatePayload(Request $request): array
    {
        $rules = [
            'customer_type' => ['required', Rule::in(['recurring','retail'])],
            'customer_id'   => ['nullable','integer','required_if:customer_type,recurring'],
            'customer_name' => ['required_if:customer_type,retail','nullable','string','max:100'],
            'mobile'        => ['required_if:customer_type,retail','nullable','regex:/^[0-9]{10,15}$/'],
            'location'      => ['required','string','max:255'],
            'rent_date'     => ['required','date'],
            'placed_the_tanker'  => ['nullable','int'],
            'empty_the_tanker'  => ['nullable','int'],
            'filled_the_tanker'  => ['nullable','int'],
            'total_amount'        => ['required','numeric','min:0'],
            'isPaid'       => ['nullable','integer','in:0,1'],
        ];

        $messages = [
            'customer_id.required_if'   => 'Please select a Recurring customer.',
            'customer_name.required_if' => 'Customer name is required for Retail.',
            'mobile.required_if'        => 'Mobile is required for Retail.',
            'mobile.regex'              => 'Mobile must be 10–15 digits.',
        ];

        return $request->validate($rules, $messages);
    }
        public function receive(Request $request, int $id)
    {
        $order = DailyOrder::where('isDelete', 0)->findOrFail($id);

        // Resolve dates
        $placed = $order->rent_date;
        if (!$placed) {
            return back()->with('error', 'Placed date is missing; cannot compute days.');
        }

        $placedAt   = Carbon::parse($placed)->startOfDay();
        $receivedAt = $request->filled('received_date')
                        ? Carbon::parse($request->input('received_date'))->startOfDay()
                        : now()->startOfDay();

        // Rate (default 200)
        $rate  = (float) ($request->input('rate', 200));
        if ($rate <= 0) $rate = 200;

        // Compute days & amount (25 -> 27 = 2 days)
        $days   = max(0, $placedAt->diffInDays($receivedAt));
        $amount = $days * $rate;

        // Persist as "received"
        $order->received_at = $receivedAt->toDateString();    // using empty_the_tanker as the "received" date
        $order->extra_amount     = $amount;                         // store computed total
        $order->extra_duration     = $days;                         // store computed total
        $order->save();

        // Optional: if you maintain a ledger, you could append/adjust here.
        // app(LedgerService::class)->addCreditPayment($order->customer_id, $amount, 'Daily Order received', $receivedAt->toDateString(), $order->daily_order_id);

        return back()->with('success', "Tanker marked received. Days: {$days}, Rate: ₹{$rate}, Total: ₹{$amount}");
    }

    /**
     * Mark tanker as NOT received (clear received date & reset computed amount).
     */
    public function unreceive(int $id)
    {
        $order = DailyOrder::where('isDelete', 0)->findOrFail($id);

        $order->received_at = null;
        // If you want to keep any manual total, remove next line.
        $order->extra_amount = 0;
        $order->extra_duration = 0;
        $order->save();

        return back()->with('success', 'Tanker marked as not received.');
    }

   

}
