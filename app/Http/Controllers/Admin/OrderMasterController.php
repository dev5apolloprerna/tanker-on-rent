<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
use App\Models\Customer;
use App\Models\Tanker;
use App\Models\RentPrice;
use App\Models\OrderPayment;
use App\Models\GodownMaster;
use App\Models\PaymentReceivedUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;


class OrderMasterController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $q = OrderMaster::notDeleted()->withSum('paymentMaster', 'paid_amount')
            ->with(['customer', 'tanker','rentPrice']);

        // Search (default: order_type, rent_type, reference_name, reference_mobile_no, tanker_location)
        if ($request->filled('search')) {
            $s = trim($request->search);
            $q->where(function($x) use ($s) {
                $x
                    // ->where('order_type', 'like', "%{$s}%")
                  ->where('rent_type', 'like', "%{$s}%")
                  ->orWhere('reference_name', 'like', "%{$s}%")
                  ->orWhere('reference_mobile_no', 'like', "%{$s}%")
                  ->orWhere('tanker_location', 'like', "%{$s}%");
            });
        }

        // Optional status filter by querystring ?status=1/0
        if ($request->filled('status') && in_array($request->status, ['0','1'])) {
            $q->where('iStatus', (int) $request->status);
        }
        if ($request->filled('isReceive') && in_array($request->isReceive, ['0','1'])) {
            $q->where('isReceive', (int) $request->isReceive);
        }
        if ($request->filled('rent_type') && in_array($request->rent_type, ['daily','monthly'])) {
            $q->where('rent_type', $request->rent_type);
        }

           $q->where(function($sub) {
                $sub->where('isReceive', 1)
                    ->orWhereHas('paymentMaster', function($pm) {
                        // unpaid_amount > 0 means still pending, so keep those
                        $pm->where('unpaid_amount', '>', 0);
                    });
            })
            // exclude isReceive=0 with unpaid=0
            ->whereDoesntHave('paymentMaster', function($pm) {
                $pm->where('unpaid_amount', '=', 0)
                   ->whereHas('order', function($order) {
                       $order->where('isReceive', 0);
                   });
            });

     $orders = $q->orderByDesc('order_id')->paginate(10)->withQueryString();

        $customerIds = collect($orders->items())->pluck('customer_id')->map(fn ($id) => (int) $id)->unique()->values();
        $overallPaymentsByCustomer = [];
        if ($customerIds->isNotEmpty()) {
            $overallPaymentsByCustomer = OrderPayment::whereIn('customer_id', $customerIds)
                ->where('order_id', 0)
                ->select('customer_id', DB::raw('SUM(paid_amount) as total_paid'))
                ->groupBy('customer_id')
                ->pluck('total_paid', 'customer_id')
                ->map(fn ($v) => (float) $v)
                ->toArray();
        }


        $totalPaid = 0;
        $totalUnpaid = 0;
            
        $customerPaymentSummary = [];

        foreach ($orders as $o) {
            $snap = $o->dueSnapshot();
            $totalPaid += $snap['paid_sum'];
            $totalUnpaid += $snap['unpaid'];

            $customerId = (int) $o->customer_id;
            if (!isset($customerPaymentSummary[$customerId])) {
                $customerPaymentSummary[$customerId] = [
                    'paid' => 0,
                    'unpaid' => 0,
                ];
            }

            $customerPaymentSummary[$customerId]['paid'] += (float) ($snap['paid_sum'] ?? 0);
            $customerPaymentSummary[$customerId]['unpaid'] += (float) ($snap['unpaid'] ?? 0);

        }
        
        foreach ($customerPaymentSummary as $customerId => &$summary) {
            $overallPaid = (float) ($overallPaymentsByCustomer[$customerId] ?? 0);
            $summary['paid'] += $overallPaid;
            $summary['unpaid'] = max(0, (float) $summary['unpaid'] - $overallPaid);
            $totalPaid += $overallPaid;
            $totalUnpaid = max(0, $totalUnpaid - $overallPaid);
        }
        unset($summary);

            
        $godowns =GodownMaster::select('godown_id','Name')->where(['iStatus'=>1,'isDelete'=>0])->orderBy('Name')->get();
        $paymentUser = PaymentReceivedUser::notDeleted()
            ->where(['iStatus'=> 1,'isDelete'=> 0])
            ->select('received_id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.orders.index', compact('orders','totalPaid','totalUnpaid','godowns','paymentUser','customerPaymentSummary'));
    }

    // CREATE
    public function create()
    {
        $customers = Customer::where('iStatus', 1)->orderBy('customer_name', 'asc')->pluck('customer_name', 'customer_id');
        $tankers   = Tanker::where(['iStatus'=> 1,'status'=>0,'isDelete'=>0])->orderBy('tanker_code', 'asc')->pluck('tanker_code', 'tanker_id','tanker_name');
        $renttype = RentPrice::select('rent_price_id','rent_type','amount')->orderBy('rent_type')->get();

        return view('admin.orders.add-edit', compact('customers', 'tankers','renttype'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'          => 'required|integer',
            'tanker_id'            => 'required|integer',
            'rent_type'            => ['required','int'],
            'rent_start_date'      => 'required|date',
            'advance_amount'       => 'required|integer',
            'rent_amount'          => 'required|integer',
            'reference_name'       => 'nullable|string|max:100',
            'reference_mobile_no'  => 'nullable|numeric',
            'reference_address'    => 'nullable|string|max:200',
            'tanker_location'      => 'required|string|max:200',
            'iStatus'              => 'required|in:0,1',
        ]);

        $order = OrderMaster::create([
            'customer_id'         => $request->customer_id,
            'user_name'         => $request->user_name,
            'user_mobile'         => $request->user_mobile,
            'tanker_id'           => $request->tanker_id,
            'rent_type'           => $request->rent_type,
            'rent_start_date'     => $request->rent_start_date,
            'advance_amount'      => (int)$request->advance_amount,
            'rent_amount'         => (int)$request->rent_amount,
            'reference_name'      => $request->reference_name,
            'reference_mobile_no' => $request->reference_mobile_no,
            'reference_address'   => $request->reference_address,
            'tanker_location'     => $request->tanker_location,
            'contract_text'       => $request->contract_text,
            'iStatus'             => (int)$request->iStatus,
        ]);

        $this->syncTankerStatus((int)$order->tanker_id, (string)$order->tanker_location);

         return DB::transaction(function () use ($order) {
            /** @var OrderMaster $order */

            // Base = explicit rent_amount, fallback to rent_prices if empty
            $base = (int) ($order->rent_amount ?? 0);
            if ($base <= 0) {
                $base = (int) RentPrice::where('rent_type', $order->rent_type)->value('amount') ?? 0;
            }

            // Initial ledger row: record the advance as PAID
            $advance = (int) round($order->advance_amount ?? 0);
            $advance = max(0, min($advance, $base)); // cap to base

            OrderPayment::create([
                'customer_id'   => $order->customer_id,
                'order_id'      => $order->order_id,
                'total_amount'  => $base,                  // snapshot base at creation
                'paid_amount'   => $advance,               // ✅ record advance as paid
                'unpaid_amount' => max(0, $base - $advance),
                'iStatus'       => 1,
                'isDelete'      => 0,
            ]);
        return redirect()->route('orders.index')->with('success', 'Order added successfully.');
        });

    }

    // EDIT
    public function edit($id)
    {
        $order = OrderMaster::notDeleted()->findOrFail($id);
        $customers = Customer::where('iStatus', 1)->orderBy('customer_name', 'asc')->pluck('customer_name', 'customer_id');
        $tankers   = Tanker::where(['iStatus'=> 1])->orderBy('tanker_code', 'asc')->pluck('tanker_code', 'tanker_id');
        $renttype = RentPrice::select('rent_price_id','rent_type','amount')->orderBy('rent_type')->get();

        return view('admin.orders.add-edit', compact('order','customers','tankers','renttype'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $order = OrderMaster::notDeleted()->findOrFail($id);
        $oldTankerId       = (int)$order->tanker_id;
        $oldTankerLocation = (string)$order->tanker_location;


        $request->validate([
            'customer_id'          => 'required|integer',
            'tanker_id'            => 'required|integer',
            'rent_type'            => ['required','int'],
            'rent_start_date'      => 'required|date',
            'rent_amount'          => 'required|integer',
            'reference_name'       => 'nullable|string|max:100',
            'reference_mobile_no'  => 'nullable|numeric',
            'reference_address'    => 'nullable|string|max:200',
            'tanker_location'      => 'required|string|max:200',
            'iStatus'              => 'required|in:0,1',

        ]);

        $order->update([
            'customer_id'         => $request->customer_id,
            'user_name'         => $request->user_name,
            'user_mobile'         => $request->user_mobile,
            'tanker_id'           => $request->tanker_id,
            'rent_type'           => $request->rent_type,
            'rent_start_date'     => $request->rent_start_date,
//            'advance_amount'      => (int)$request->advance_amount,
            'rent_amount'         => (int)$request->rent_amount,
            'reference_name'      => $request->reference_name,
            'reference_mobile_no' => $request->reference_mobile_no,
            'reference_address'   => $request->reference_address,
            'tanker_location'     => $request->tanker_location,
            'contract_text'     => $request->contract_text,
            'iStatus'             => (int)$request->iStatus,
        ]);

        if ($oldTankerId !== (int)$order->tanker_id) {
            Tanker::where('tanker_id', $oldTankerId)->update(['status' => 0]);
            OrderMaster::where('tanker_id', $oldTankerId)->update(['isReceive' => 0]);
        }
        $this->syncTankerStatus((int)$order->tanker_id, (string)$order->tanker_location);

        return DB::transaction(function () use ($order) {
            // Update order first

            // Recompute base
            $base = (int) ($order->rent_amount ?? 0);
            if ($base <= 0) {
                $base = (int) RentPrice::where('rent_type', $order->rent_type)->value('amount') ?? 0;
            }

            // Ensure payments reflect requested advance:
            $paidSoFar = (int) $order->paymentMaster()->sum('paid_amount');
            $targetAdvance = (int) round($order->advance_amount ?? 0);
            $targetAdvance = max(0, min($targetAdvance, $base)); // cap to base

            if ($targetAdvance > $paidSoFar) {
                // User increased advance → add a delta payment row
                $delta = $targetAdvance - $paidSoFar;
                // Compute current snapshot to store unpaid correctly in the ledger row
                $snapTotal = $order->dueSnapshot()['total_due']; // base + extra as of now
                $newUnpaid = max(0, $snapTotal - ($paidSoFar + $delta));

                OrderPayment::create([
                    'customer_id'   => $order->customer_id,
                    'order_id'      => $order->order_id,
                    'total_amount'  => $snapTotal,
                    'paid_amount'   => $delta,
                    'unpaid_amount' => $newUnpaid,
                    'iStatus'       => 1,
                    'isDelete'      => 0,
                ]);
            }
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
        });
    }
    public function tankerDetails($id)
    {
        $order = OrderMaster::with(['tanker', 'customer'])->findOrFail($id);

        // If you already use this snapshot everywhere:
        $snap = method_exists($order, 'dueSnapshot') ? $order->dueSnapshot() : null;

        // Return a partial (works with AJAX or direct render)
        return view('admin.orders.tanker_details', compact('order', 'snap'));
    }


    // SOFT DELETE (set isDelete=1)
    public function destroy($id)
    {
        $order = OrderMaster::notDeleted()->findOrFail($id);
        $order->isDelete = 1;
        $order->save();

        Tanker::where('tanker_id', $order->tanker_id)->update(['status' => 0]);

        return response()->json(['status' => true, 'message' => 'Order deleted successfully.']);
    }

    // BULK SOFT DELETE
    public function bulkDelete(Request $request)
    {
        $ids = (array) $request->input('ids', []);
        if (!count($ids)) {
            return response()->json(['status' => false, 'message' => 'No IDs selected.']);
        }
        OrderMaster::whereIn('order_id', $ids)->update(['isDelete' => 1]);
        return response()->json(['status' => true, 'message' => 'Selected orders deleted successfully.']);
    }

    // Toggle Active/Inactive
    public function changeStatus($id)
    {
        $order = OrderMaster::notDeleted()->findOrFail($id);
        $order->iStatus = $order->iStatus ? 0 : 1;
        $order->save();

        return response()->json(['status' => true, 'new_status' => $order->iStatus]);
    }
    public function toggleReceive($id)
    {
        $order = OrderMaster::findOrFail($id);
        $order->isReceive = $order->isReceive == 1 ? 0 : 1;
        $order->received_at = null; 
        $order->save();

        Tanker::where('tanker_id', $order->tanker_id)->update(['status' => $order->isReceive ? 1 : 0]);


        return redirect()->back()->with('success', 'Receive status updated successfully.');
    }
    public function markReceived(Request $request, $id)
    {
        $request->validate([
            'godown_id' => 'required|integer',
        ]);

        $order = OrderMaster::findOrFail($id);
        $order->received_at = date('Y-m-d h:i:s');                   // 0 = Received (as per your current logic/UI)
        $order->extra_amount = intval(preg_replace('/[^\d]/', '', (string) $request->extra_amount));
        $order->extra_duration = $request->extra_day ? (int)$request->extra_day : null;
        $order->extraDM = $request->duration_text ?? null;
        $order->received_at = $request->received_at ?? null;
        $order->isReceive = 0;                   // 0 = Received (as per your current logic/UI)
        $order->save();

        $tanker = Tanker::findOrFail($order->tanker_id);

        // mark as RECEIVED
        $tanker->status = 0;                   // 0 = Received (as per your current logic/UI)
        $tanker->godown_id = $request->godown_id ?? null;  // ensure column exists (note below)
        $tanker->save();


        return back()->with('success', 'Marked as RECEIVED in the selected godown.');
    }

    private function syncTankerStatus(int $tankerId, string $tankerLocation): void
    {
        // outside => status = 1 ; anything else => 0
        $isOutside = strtolower(trim($tankerLocation)) !== null;
        Tanker::where('tanker_id', $tankerId)->update(['status' => $isOutside ? 1 : 0]);
        OrderMaster::where('tanker_id', $tankerId)->update(['isReceive' => $isOutside ? 1 : 0]);
    }
     public static function computeDueSnapshot(OrderModel $order): array
    {
        return $order->dueSnapshot(); // delegate to the model method above
    }
    public function customerOrdersSummary($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $orders = OrderMaster::with(['tanker'])
            ->where('customer_id', $customerId)
            ->where('isDelete', 0)
            ->latest('rent_start_date')
            ->get();

        $orderIds = $orders->pluck('order_id')->all();
       $customerPaymentHistory = \DB::table('order_payment_master as p')
            ->leftJoin('payment_received_user as pru', 'pru.received_id', '=', 'p.payment_received_by')
            ->select(
                'p.payment_id',
                'p.order_id',
                'p.total_amount',
                'p.paid_amount',
                'p.unpaid_amount',
                'p.payment_date',
                'p.created_at',
                'pru.name as payment_received_by_name'
            )
            ->where('p.customer_id', $customerId)
            ->where('p.isDelete', 0)
            ->orderBy('p.payment_id', 'asc')
            ->get();

        $payments = $customerPaymentHistory
            ->whereIn('order_id', $orderIds)
            ->groupBy('order_id');

        $totals = ['orders_count'=>0, 'total_due'=>0, 'paid'=>0, 'unpaid'=>0];
        $totals['orders_count'] = $orders->count();

        $dailyCount = 0; $monthlyCount = 0;
        $receivedCount = 0; $notReceivedCount = 0;

        foreach ($orders as $o) {
            $s = $o->dueSnapshot();
            $o->snap = $s;

            $totals['total_due'] += (float) ($s['total_due'] ?? 0);
            $totals['paid']      += (float) ($s['paid_sum']  ?? 0);
            $totals['unpaid']    += (float) ($s['unpaid']    ?? 0);

            if (($s['rent_basis'] ?? '') === 'daily') $dailyCount++; else $monthlyCount++;
            if ((int)$o->isReceive === 1) $notReceivedCount++; else $receivedCount++;
        }

        $overallPaid = (float) $customerPaymentHistory
            ->where('order_id', 0)
            ->sum('paid_amount');
        if ($overallPaid > 0) {
            $totals['paid'] += $overallPaid;
            $totals['unpaid'] = max(0, (float)$totals['unpaid'] - $overallPaid);
        }

        $meta = [
            'daily_count'       => $dailyCount,
            'monthly_count'     => $monthlyCount,
            'received_count'    => $receivedCount,     // isReceive == 0
            'not_received_count'=> $notReceivedCount,  // isReceive == 1
        ];

        return view('admin.orders.customer_orders_summary', [
            'customer' => $customer,
            'orders'   => $orders,
            'payments' => $payments,
            'customerPaymentHistory' => $customerPaymentHistory,
            'totals'   => $totals,
            'meta'     => $meta,
        ]);
    }
   public function monthlyPdf(Request $request)
    {
        $q = OrderMaster::notDeleted()->withSum('paymentMaster', 'paid_amount')->with(['customer', 'tanker', 'rentPrice']);

        if ($request->filled('search')) {
            $s = trim($request->search);
            $q->where(function ($x) use ($s) {
                $x->where('rent_type', 'like', "%{$s}%")
                  ->orWhere('reference_name', 'like', "%{$s}%")
                  ->orWhere('reference_mobile_no', 'like', "%{$s}%")
                  ->orWhere('tanker_location', 'like', "%{$s}%");
            });
        }

        if ($request->filled('isReceive') && in_array($request->isReceive, ['0', '1'])) {
            $q->where('isReceive', (int) $request->isReceive);
        }

        if ($request->filled('customer_id')) {
            $q->where('customer_id', (int) $request->customer_id);
        }

        // Monthly-only report
        $q->whereHas('rentPrice', function ($r) {
            $r->whereRaw('LOWER(rent_type) = ?', ['monthly']);
        });

        $orders = $q->orderBy('rent_start_date')->get();

        $reportRows = [];
        $grandTotal = 0;
        $grandPaid = 0;
        $grandUnpaid = 0;
        $customerSummary = [];

        foreach ($orders as $o) {
            $snap = $o->dueSnapshot();
            $months = max(1, (int) ($snap['months'] ?? 1));
            $start = \Carbon\Carbon::parse($o->rent_start_date);
            $schedule = [];
            for ($i = 0; $i < $months; $i++) {
                $schedule[] = $start->copy()->addMonthsNoOverflow($i)->format('d/m/Y');
            }

            $reportRows[] = [
                'order' => $o,
                'snap' => $snap,
                'schedule' => $schedule,
            ];

            $grandTotal += (float) $snap['total_due'];
            $grandPaid += (float) $snap['paid_sum'];
            $grandUnpaid += (float) $snap['unpaid'];

            $cid = (int) $o->customer_id;
            if (!isset($customerSummary[$cid])) {
                $customerSummary[$cid] = ['paid' => 0, 'unpaid' => 0];
            }
            $customerSummary[$cid]['paid'] += (float) ($snap['paid_sum'] ?? 0);
            $customerSummary[$cid]['unpaid'] += (float) ($snap['unpaid'] ?? 0);
        }

        if (!empty($customerSummary)) {
            $overallPaymentsByCustomer = OrderPayment::whereIn('customer_id', array_keys($customerSummary))
                ->where('order_id', 0)
                ->where('isDelete', 0)
                ->select('customer_id', DB::raw('SUM(paid_amount) as total_paid'))
                ->groupBy('customer_id')
                ->pluck('total_paid', 'customer_id')
                ->map(fn ($v) => (float) $v)
                ->toArray();

            foreach ($customerSummary as $customerId => $summary) {
                $overallPaid = (float) ($overallPaymentsByCustomer[$customerId] ?? 0);
                if ($overallPaid > 0) {
                    $grandPaid += $overallPaid;
                    $grandUnpaid = max(0, $grandUnpaid - $overallPaid);
                }
            }

        }

       $fontPath = $_SERVER['DOCUMENT_ROOT'] . '/tanker_on_rent/fonts/NotoSansGujarati-Regular.ttf';

        if (!file_exists($fontPath)) {
            dd('Font not found: ' . $fontPath);
        }

            $html = view('admin.orders.monthly_pdf', [
                    'reportRows' => $reportRows,
                    'grandTotal' => $grandTotal,
                    'grandPaid' => $grandPaid,
                    'grandUnpaid' => $grandUnpaid,
                    'generatedAt' => now(),
                ])->render();



                $mpdf = new Mpdf([
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'orientation' => 'P',
                    'autoScriptToLang' => true,
                    'autoLangToFont' => true,
                    'default_font' => 'freeserif',
                ]);

                $mpdf->WriteHTML($html);

                $fileNamePrefix = request()->filled('customer_id')
                    ? 'customer-monthly-orders-report'
                    : 'monthly-orders-report';

                return response($mpdf->Output($fileNamePrefix . '-' . now()->format('Ymd_His') . '.pdf', 'I'))
                    ->header('Content-Type', 'application/pdf');

    }
}
