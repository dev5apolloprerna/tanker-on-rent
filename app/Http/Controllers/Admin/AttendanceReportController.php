<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmpAttendance;
use App\Models\EmployeeMaster;
use Carbon\Carbon;
use DB;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->format('Y-m-d');

        $from = $request->input('from_date', $today);
        $to   = $request->input('to_date', $today);

        // If no filter, default to today
        $query = EmpAttendance::with('employee')
            ->whereBetween('attendance_date', [$from, $to])
            ->orderBy('attendance_date', 'desc');

        $records = $query->get();

        // ✅ Summary per employee (considering H = 0.5)
        $summary = EmpAttendance::select(
                'emp_id',
                DB::raw("SUM(CASE WHEN status = 'P' THEN 1 WHEN status = 'H' THEN 0.5 ELSE 0 END) as present_days"),
                DB::raw("SUM(CASE WHEN status = 'A' THEN 1 ELSE 0 END) as absent_days"),
                DB::raw("SUM(CASE WHEN status = 'H' THEN 1 ELSE 0 END) as half_days")
            )
            ->whereBetween('attendance_date', [$from, $to])
            ->groupBy('emp_id')
            ->with('employee')
            ->get()
            ->map(function ($item) {
                $item->employee_name = $item->employee->name ?? '-';
                $item->daily_wages   = $item->employee->daily_wages ?? 0;
                $item->payment       = round($item->present_days * $item->daily_wages, 2);
                return $item;
            });

        $grandTotal = $summary->sum('payment');

        return view('admin.reports.attendance_report', compact('records', 'summary', 'from', 'to', 'grandTotal'));
    }
     public function employeeDetail(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'from' => 'nullable|date',
            'to'   => 'nullable|date',
        ]);

        $from = $request->input('from') ?: now()->startOfMonth()->toDateString();
        $to   = $request->input('to')   ?: now()->endOfMonth()->toDateString();

        $employee = EmployeeMaster::findOrFail($request->employee_id);

        $records = EmpAttendance::with('employee')
            ->where('emp_id', $employee->emp_id)
            ->whereBetween('attendance_date', [$from, $to])
            ->orderBy('attendance_date', 'asc')
            ->get();

        $present = $records->where('status', 'P')->count();
        $absent  = $records->where('status', 'A')->count();
        $half    = $records->where('status', 'H')->count();

        $wage    = (float) ($employee->daily_wages ?? 0);
        $payment = ($present * $wage) + ($half * ($wage / 2));

        return view('admin.reports._employee_detail', [
            'employee' => $employee,
            'from'     => $from,
            'to'       => $to,
            'records'  => $records,
            'present'  => $present,
            'absent'   => $absent,
            'half'     => $half,
            'wage'     => $wage,
            'payment'  => $payment,
        ]);
    }
}
