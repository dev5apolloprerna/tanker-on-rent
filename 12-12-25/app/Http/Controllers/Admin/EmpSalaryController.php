<?php
// app/Http/Controllers/Admin/EmpSalaryController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmpSalary;
use App\Models\EmployeeMaster;
use App\Models\EmployeeExtraWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EmpSalaryController extends Controller
{
    
    public function index(Request $request)
    {
        $q        = $request->input('q');            // employee name/mobile/email
        $from     = $request->input('from');         // YYYY-MM-DD
        $to       = $request->input('to');           // YYYY-MM-DD
        $empId    = $request->input('emp_id');       // filter by employee
        $status   = $request->input('status');       // 1/0

        $employees = EmployeeMaster::orderBy('name')->get(['emp_id','name']);

        $rows = EmpSalary::query()
            ->with('employee')
            ->when($empId, fn($q2) => $q2->where('emp_id', $empId))
            ->when(in_array($status, ['0','1'], true), fn($q2) => $q2->where('iStatus', $status))
            ->when($from, fn($q2) => $q2->whereDate('salary_date', '>=', $from))
            ->when($to,   fn($q2) => $q2->whereDate('salary_date', '<=', $to))
            ->when($q, function ($q2) use ($q) {
                $q2->whereHas('employee', function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('mobile', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('emp_salary_id')
            ->paginate(15)
            ->withQueryString();

        // totals for current filter
        $totals = EmpSalary::query()
            ->when($empId, fn($q2) => $q2->where('emp_id', $empId))
            ->when(in_array($status, ['0','1'], true), fn($q2) => $q2->where('iStatus', $status))
            ->when($from, fn($q2) => $q2->whereDate('salary_date', '>=', $from))
            ->when($to,   fn($q2) => $q2->whereDate('salary_date', '<=', $to))
            ->sum('salary_amount');

        return view('admin.emp_salary.index', compact('rows','employees','q','from','to','empId','status','totals'));
    }
    
    public function lastRange(Request $req)
    {
        $req->validate(['emp_id' => 'required|integer|exists:employee_master,emp_id']);
        $empId = (int) $req->emp_id;

        $lastTo = DB::table('emp_salary')
            ->where('isDelete', 0)
            ->where('emp_id', $empId)
            ->max('last_date'); // last_date is DATE; fallback to DATE(salary_date) if null-only history
        if (!$lastTo) {
            $lastTo = DB::table('emp_salary')
                ->where('isDelete', 0)
                ->where('emp_id', $empId)
                ->orderByDesc('salary_date')->value(DB::raw('DATE(salary_date)'));
        }

        if ($lastTo) {
            $fromDefault = Carbon::parse($lastTo)->addDay()->toDateString();
        } else {
            $fromDefault = Carbon::now()->toDateString();
        }
        $toDefault = Carbon::now()->toDateString();

        return response()->json([
            'ok' => true,
            'last_date'    => $lastTo,
            'from_default' => $fromDefault,
            'to_default'   => $toDefault,
        ]);
    }

    // Attendance-based quotation
    // GET /admin/emp-salaries/quote-attendance?emp_id=..&salary_date=YYYY-MM-DD&last_date=YYYY-MM-DD
    public function quoteFromAttendance(Request $req)
    {
        $v = Validator::make($req->all(), [
            'emp_id'      => 'required|integer|exists:employee_master,emp_id',
            'salary_date' => 'required|date', // FROM
            'last_date'   => 'required|date', // TO
        ]);
        if ($v->fails()) return response()->json(['ok' => false, 'errors' => $v->errors()], 422);

        $empId = (int) $req->emp_id;
        $from  = Carbon::parse($req->salary_date)->startOfDay();
        $to    = Carbon::parse($req->last_date)->endOfDay();
        if ($to->lt($from)) $to = $from->copy()->endOfDay();

        $emp = DB::table('employee_master')->where('emp_id', $empId)->first();
        if (!$emp) return response()->json(['ok' => false, 'msg' => 'Employee not found'], 404);

        $dailyWages = (int) ($emp->daily_wages ?? 0);

        $att = DB::table('emp_attendance_master')
            ->select('status', DB::raw('COUNT(*) as cnt'))
            ->where('emp_id', $empId)
            ->where('isDelete', 0)
            ->whereBetween('attendance_date', [$from->toDateString(), $to->toDateString()])
            ->groupBy('status')
            ->pluck('cnt', 'status');

        $P = (int) ($att['P'] ?? 0);
        $H = (int) ($att['H'] ?? 0);
        $A = (int) ($att['A'] ?? 0);

        $units  = $P + 0.5 * $H;
        $amount = (int) round($dailyWages * $units);
        
        $withdrawals = DB::table('employee_extra_withdrawal')
        ->where(['emp_id'=>$empId,'isActive'=>1])
        ->where('remaining_amount', '>', 0)
        ->first();

        return response()->json([
            'ok'          => true,
            'daily_wages' => $emp->daily_wages,
            'emi_amount' => $withdrawals->emi_amount ?? 0,
            'withdrawal_id' => $withdrawals->withdrawal_id ?? 0,
            'mobile'      => 50,
            'counts'      => ['P' => $P, 'H' => $H, 'A' => $A],
            'units'       => $units,
            'amount'      => $amount,
            'note'        => "{$P}P + {$H}H = {$units} day(s) × ₹{$dailyWages}",
        ]);
    }

    // Store (Add)


    public function store(Request $req)
    {
        /*$v = Validator::make($req->all(), [
            'emp_id'        => 'required|integer|exists:employee_master,emp_id',
            'salary_date'   => 'required|date',
            'last_date'     => 'required|date',
            'salary_amount' => 'nullable|integer|min:0',
            'iStatus'       => 'nullable|integer|in:0,1',
        ])->validate();
*/

        $v = Validator::make($req->all(), [
            'emp_id'            => ['required','integer'],
            'salary_date'       => ['required','date'],
            'last_date'         => ['required','date','after_or_equal:salary_date'],
            'salary_amount'     => ['required','numeric','min:0'],
            'mobile_recharge'   => ['nullable','numeric','min:0'],
            'withdrawal_deducted'=> ['nullable','numeric','min:0'],
        ]);

        $v->after(function($v) use ($req) {
            $gross = (float)$req->salary_amount + (float)$req->mobile_recharge;
            if ((float)$req->withdrawal_deducted > $gross) {
                $v->errors()->add('withdrawal_deducted',
                    'Withdrawal cannot exceed gross (salary + mobile recharge).');
            }
        });

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }



        $empId = (int) $req->emp_id;
        $from  = Carbon::parse($req->salary_date)->startOfDay();
        $to    = Carbon::parse($req->last_date)->endOfDay();
        if ($to->lt($from)) $to = $from->copy()->endOfDay();

        // Step 1️⃣: Calculate salary based on attendance
        $amount = (int) ($req->salary_amount ?? 0);
        
        if ($amount <= 0) 
        {
            $emp = DB::table('employee_master')->where('emp_id', $empId)->first();
            $dailyWages = (int) ($emp->daily_wages ?? 0);

            $att = DB::table('emp_attendance_master')
                ->select('status', DB::raw('COUNT(*) as cnt'))
                ->where('emp_id', $empId)
                ->where('isDelete', 0)
                ->whereBetween('attendance_date', [$from->toDateString(), $to->toDateString()])
                ->groupBy('status')
                ->pluck('cnt', 'status');

            $P = (int) ($att['P'] ?? 0);
            $H = (int) ($att['H'] ?? 0);
            $units = $P + 0.5 * $H;
            $amount = (int) round($dailyWages * $units);
        }

        // Step 2️⃣: Deduct withdrawal EMIs

        $w = EmployeeExtraWithdrawal::where('emp_id', $empId)
            ->where('remaining_amount', '>=', 0)
            ->first();

        $totalWithdrawalDeducted = 0;

        //foreach ($withdrawals as $w) {
            $emi = (float) ($req->withdrawal_deducted ?? $w->emi_amount);

            if ($emi > 0) 
            {
                $deduct = min($emi, $w->remaining_amount);
                $w->remaining_amount = max(0, $w->remaining_amount - $deduct);
                $w->save(); // ✅ Eloquent method
                $totalWithdrawalDeducted += $deduct;
                /*if($w->remaining_amount == 0)
                {
                    $w->isActive=0;
                    $w->save();

                    $wactive = EmployeeExtraWithdrawal::where('emp_id', $w->emp_id)
                        ->where('remaining_amount', '!=', 0)->orderBy('withdrawal_id','asc')
                        ->first();
                        if(!empty($wactive))
                        {
                            $wactive->isActive=1;
                            $wactive->save();
                        }


                }*/
            }
        // }


        $mobileRecharge = (float) ($req->mobile_recharge ?? 0);
        $netSalary = $amount - $totalWithdrawalDeducted + $mobileRecharge;
        if ($netSalary < 0) $netSalary = 0;

        // Step 4️⃣: Save salary record
        DB::table('emp_salary')->insert([
            'emp_id'        => $empId,
            'salary_date'   => $from->toDateString(),
            'last_date'     => $to->toDateString(),
            'daily_wages' => $req->daily_wages,
            'salary_amount' => $netSalary,
            'withdrawal_deducted' => $totalWithdrawalDeducted, // add this column if you want tracking
            'withdrawal_id'     => $req->withdrawal_id, // add this column if you want tracking
            'mobile_recharge'     => $mobileRecharge,
            'iStatus'       => (int) ($req->iStatus ?? 1),
            'isDelete'      => 0,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return back()->with('success', "Salary added. Base ₹$amount - Withdrawal ₹$totalWithdrawalDeducted = ₹$netSalary");
    }


    // Update (Edit)
    public function update(Request $req, $id)
    {

        $v = Validator::make($req->all(), [
            'emp_id'        => 'required|integer|exists:employee_master,emp_id',
            'salary_date'   => 'required|date', // FROM
            'last_date'     => 'required|date', // TO
            'salary_amount' => 'nullable|integer|min:0',
            'iStatus'       => 'nullable|integer|in:0,1',
        ])->validate();

        $empId = (int) $req->emp_id;
        $from  = Carbon::parse($req->salary_date)->startOfDay();
        $to    = Carbon::parse($req->last_date)->endOfDay();
        if ($to->lt($from)) $to = $from->copy()->endOfDay();

 
        $amount = (int) ($req->salary_amount ?? 0);
        if ($amount <= 0) {
            $emp = DB::table('employee_master')->where('emp_id', $empId)->first();
            $dailyWages = (int) ($emp->daily_wages ?? 0);

            $att = DB::table('emp_attendance_master')
                ->select('status', DB::raw('COUNT(*) as cnt'))
                ->where('emp_id', $empId)
                ->where('isDelete', 0)
                ->whereBetween('attendance_date', [$from->toDateString(), $to->toDateString()])
                ->groupBy('status')
                ->pluck('cnt', 'status');

            $P = (int) ($att['P'] ?? 0);
            $H = (int) ($att['H'] ?? 0);
            $units  = $P + 0.5 * $H;
            $amount = (int) round($dailyWages * $units);
        }


        $withdrawals = EmployeeExtraWithdrawal::where('emp_id', $empId)
            ->where('remaining_amount', '>=', 0)
            ->get();

        $totalWithdrawalDeducted = 0;

        foreach ($withdrawals as $w) 
        {
        
            $emi = (float) ($req->withdrawal_deducted);

            if ($emi > 0) {
                $deduct = min($emi, $w->remaining_amount);
                $w->remaining_amount = max(0, $w->remaining_amount - $deduct);
                $w->save(); // ✅ Eloquent method
                $totalWithdrawalDeducted += $deduct;
            }
        }


        $mobileRecharge = (float) ($req->mobile_recharge ?? 0);
        $netSalary = $amount - $totalWithdrawalDeducted + $mobileRecharge;
        if ($netSalary < 0) $netSalary = 0;


        DB::table('emp_salary')->where('emp_salary_id', (int)$id)->update([
            'emp_id'        => $empId,
            'salary_date'   => $from->toDateString(),
            'last_date'     => $to->toDateString(),
            'daily_wages' => $req->daily_wages,
            'salary_amount' => $amount,
            'withdrawal_deducted' => $totalWithdrawalDeducted, // add this column if you want tracking
            'mobile_recharge'     => $mobileRecharge,
            'iStatus'       => (int) ($req->iStatus ?? 1),
            'updated_at'    => now(),
        ]);

        return back()->with('success', 'Salary updated successfully.');
    }

        public function destroy(EmpSalary $emp_salary)
        {
            DB::transaction(function () use ($emp_salary) {

                $empId   = (int) $emp_salary->emp_id;
                $wid     = (int) ($emp_salary->withdrawal_id ?? 0);
                $refund  = (float) ($emp_salary->withdrawal_deducted ?? 0);

                if ($wid) {
                    // Lock the specific withdrawal row we need to fix
                    $w = EmployeeExtraWithdrawal::where('withdrawal_id', $wid)
                        ->where('emp_id', $empId)
                        ->lockForUpdate()
                        ->first();

                    if ($w) {
                        // ✅ Add back what this salary deducted (capped to original total if available)
                        $original = $w->total_amount ?? $w->amount ?? $w->withdrawal_amount ?? null;
                        if ($refund > 0) {
                            if ($original !== null) {
                                $headroom = max(0, (float)$original - (float)$w->remaining_amount);
                                $addBack  = min($refund, $headroom);
                            } else {
                                $addBack  = $refund;
                            }
                            $w->remaining_amount = round((float)$w->remaining_amount + $addBack, 2);
                        }

                        // ✅ Ensure this is the single active withdrawal
                        $w->isActive = 1;
                        $w->save();

                        EmployeeExtraWithdrawal::where('emp_id', $empId)
                                ->where('withdrawal_id', '!=', $w->withdrawal_id)
                            ->update(['isActive' => 0]);
                    }
                }

                // finally remove the salary row
                $emp_salary->delete();
            });

            return back()->with('success', 'Salary deleted. Withdrawal reverted and activated; other withdrawals set inactive.');
        }


}
