<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeExtraWithdrawal;
use App\Models\EmployeeMaster;
use Illuminate\Validation\Rule;

class EmployeeExtraWithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $q = EmployeeExtraWithdrawal::with('employee');

        if ($request->filled('search')) {
            $s = trim($request->search);
            $q->whereHas('employee', fn($x) => 
                $x->where('name', 'like', "%{$s}%")
            )->orWhere('reason', 'like', "%{$s}%");
        }

        $withdrawals = $q->orderByDesc('withdrawal_date')->paginate(10)->withQueryString();
        $employees = EmployeeMaster::select('emp_id', 'name')->orderBy('name')->get();

        return view('admin.emp_withdrawal.index', compact('withdrawals', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'emp_id' => ['required', 'exists:employee_master,emp_id'],
            'withdrawal_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:1'],
            'reason' => ['nullable', 'string', 'max:255'],
            'emi_amount' => ['nullable', 'integer', 'min:0'],
            'remarks' => ['nullable', 'string'],
        ]);

        // Set remaining_amount = amount when created
        $validated['remaining_amount'] = $validated['amount'];

        EmployeeExtraWithdrawal::create($validated);

        return back()->with('success', 'Withdrawal added successfully.');
    }
    public function edit($id)
    {
        return response()->json(EmployeeExtraWithdrawal::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $data = EmployeeExtraWithdrawal::findOrFail($id);

        $validated = $request->validate([
            'emp_id' => ['required', 'exists:employee_master,emp_id'],
            'withdrawal_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:1'],
            'reason' => ['nullable', 'string', 'max:255'],
            'emi_amount' => ['nullable', 'integer', 'min:0'],
            'remaining_amount' => ['nullable', 'integer', 'min:0'],
            'remarks' => ['nullable', 'string'],
        ]);

        $data->update($validated);
        return back()->with('success', 'Withdrawal updated successfully.');
    }
    public function employeeDetail(Request $request)
    {
        $request->validate(['emp_id' => 'required|integer']);
        $empId = (int) $request->emp_id;

        // Basic employee info (assumes employees.emp_id, employees.name)
        $employee = DB::table('employee_master')->where('emp_id', $empId)->first();

        // All withdrawals for this employee
        $withdrawals = DB::table('employee_extra_withdrawal')
            ->select('withdrawal_date','amount','reason','emi_amount','remaining_amount')
            ->where('emp_id', $empId)
            ->orderByDesc('withdrawal_date')
            ->get();

        // All salary rows (returns/deductions) for this employee
        $returns = DB::table('emp_salary')
            ->select('salary_date','last_date','daily_wages','salary_amount','withdrawal_deducted','mobile_recharge')
            ->where('emp_id', $empId)
            ->orderByDesc('salary_date')
            ->get();

        // Totals
        $withdrawTotal = (float) $withdrawals->sum('amount');
        $returnTotal   = (float) $returns->sum('withdrawal_deducted'); // treating this as "paid/returned"
        $rechargeTotal = (float) $returns->sum('mobile_recharge');     // shown separately
        $netOutstanding = $withdrawTotal - $returnTotal;

        return view('admin.emp_withdrawal._employee_detail', compact(
            'employee','withdrawals','returns','withdrawTotal','returnTotal','rechargeTotal','netOutstanding'
        ));
    }
    public function destroy(Request $request)
    {
        $ids = $request->ids ?? [];
        if (count($ids)) {
            EmployeeExtraWithdrawal::whereIn('withdrawal_id', $ids)->delete();
        }
        return back()->with('success', 'Selected records deleted.');
    }
}
