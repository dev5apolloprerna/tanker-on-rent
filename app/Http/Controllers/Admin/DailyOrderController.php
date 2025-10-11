<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DailyOrder;
use App\Models\DailyOrderLedger;
use App\Models\Customer;
use App\Services\LedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // top of file

use Illuminate\Validation\Rule;

class DailyOrderController extends Controller
{

    public function __construct(private LedgerService $ledger) {}


        public function index(Request $request)
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
        }

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

}
