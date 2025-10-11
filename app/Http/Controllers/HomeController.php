<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Tanker;
use App\Models\EmployeeMaster;
use App\Models\GodownMaster;
use App\Models\VendorMaster;
use App\Models\OrderMaster;
use App\Models\DailyExpence;
use App\Models\EmpAttendance;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try
        {
                $customerCount = Customer::where('iStatus', 1)->where('isDelete', 0)->count();
                $tankerCount = Tanker::where('iStatus', 1)->where('isDelete', 0)->count();
                $intankerCount = Tanker::where(['status'=>0,'iStatus'=>1,'isDelete'=> 0])->count();
                $outtankerCount = Tanker::where(['status'=>1,'iStatus'=>1,'isDelete'=> 0])->count();
                $employeeTotal  = EmployeeMaster::where(['iStatus'=>1,'isDelete'=> 0])->count();              // not deleted = all rows (hard delete)
                $godownTotal  = GodownMaster::where(['iStatus'=>1,'isDelete'=> 0])->count();
                $vendorCount = VendorMaster::where(['iStatus'=>1,'isDelete'=> 0])->count();
                $orderCount = OrderMaster::where(['isDelete' => 0, 'iStatus' => 1])->count();



        $today  = Carbon::today();
        $todayEnd    = Carbon::today()->endOfDay();
        $monthStart  = Carbon::now()->startOfMonth();
        $monthEnd    = Carbon::now()->endOfMonth();

        // Totals (₹) with flags
        $todayTotal = DailyExpence::alive()
            ->where('iStatus', 1)
            ->whereBetween('expence_date', [$today, $todayEnd])
            ->sum('amount');

        $monthTotal = DailyExpence::alive()
            ->where('iStatus', 1)
            ->whereBetween('expence_date', [$monthStart, $monthEnd])
            ->sum('amount');

        // (Optional) counts of entries
        $todayCount = DailyExpence::alive()
            ->where('iStatus', 1)
            ->whereBetween('expence_date', [$today, $todayEnd])
            ->count();

        $monthCount = DailyExpence::alive()
            ->where('iStatus', 1)
            ->whereBetween('expence_date', [$monthStart, $monthEnd])
            ->count();

        // (Optional) per-day series for current month (for charts)
        $monthDailySeries = DailyExpence::alive()
            ->where('iStatus', 1)
            ->whereBetween('expence_date', [$monthStart, $monthEnd])
            ->selectRaw('DATE(expence_date) as d, SUM(amount) as total')
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('total', 'd'); // ['2025-09-01' => 1200, ...]



        $presentCount = EmpAttendance::whereDate('attendance_date', $today)
            ->whereIN('status', ['P','H'])
            ->count();

        $absentCount = EmpAttendance::whereDate('attendance_date', $today)
            ->where('status', 'A')
            ->count();
            
            $orders = OrderMaster::notDeleted()->with(['customer', 'tanker'])->get();

            $totalPaid = 0;
            $totalUnpaid = 0;
            
            foreach ($orders as $o) {
                $snap = $o->dueSnapshot();
                $totalPaid += $snap['paid_sum'];
                $totalUnpaid += $snap['unpaid'];
            }

    // collection amount
            $todayDate       = now()->toDateString();
        $monthStart  = now()->startOfMonth()->toDateString();
        $monthEnd    = now()->endOfMonth()->toDateString();

        // For order payments, use paid_at if present, else created_at
        $orderDateExpr = DB::raw('COALESCE(DATE(p.payment_date), DATE(p.created_at))');

        // -------- TODAY --------
        $dailyToday = (float) DB::table('daily_order_ledger as l')
            ->where('l.iStatus', 1)->where('l.isDelete', 0)
            ->where('l.credit_bl', '>', 0)
            ->whereBetween('l.entry_date', [$todayDate, $todayDate])
            ->sum('l.credit_bl');

        $orderToday = (float) DB::table('order_payment_master as p')
            ->where('p.iStatus', 1)->where('p.isDelete', 0)
            ->whereBetween($orderDateExpr, [$todayDate, $todayDate])
            ->sum('p.paid_amount');

        $todayTotals = [
            'total'        => $dailyToday + $orderToday,
            'daily_orders' => $dailyToday,
            'orders'       => $orderToday,
        ];

        // -------- THIS MONTH --------
        $dailyMonth = (float) DB::table('daily_order_ledger as l')
            ->where('l.iStatus', 1)->where('l.isDelete', 0)
            ->where('l.credit_bl', '>', 0)
            ->whereBetween('l.entry_date', [$monthStart, $monthEnd])
            ->sum('l.credit_bl');

        $orderMonth = (float) DB::table('order_payment_master as p')
            ->where('p.iStatus', 1)->where('p.isDelete', 0)
            ->whereBetween($orderDateExpr, [$monthStart, $monthEnd])
            ->sum('p.paid_amount');

        $monthTotals = [
            'total'        => $dailyMonth + $orderMonth,
            'daily_orders' => $dailyMonth,
            'orders'       => $orderMonth,
        ];

        // -------- ALL TIME --------
        $dailyAll = (float) DB::table('daily_order_ledger as l')
            ->where('l.iStatus', 1)->where('l.isDelete', 0)
            ->where('l.credit_bl', '>', 0)
            ->sum('l.credit_bl');

        $orderAll = (float) DB::table('order_payment_master as p')
            ->where('p.iStatus', 1)->where('p.isDelete', 0)
            ->sum('p.paid_amount');

        $allTotals = [
            'total'        => $dailyAll + $orderAll,
            'daily_orders' => $dailyAll,
            'orders'       => $orderAll,
        ];
            $todayCollection    = $todayTotals;   // reuse existing key in your compact()
            $thisMonthCollection = $monthTotals;
            $allTimeCollection   = $allTotals;



                return view('home',compact('customerCount','tankerCount','intankerCount','outtankerCount','employeeTotal','godownTotal','vendorCount','orderCount','todayTotal', 'monthTotal', 'todayCount', 'monthCount', 'monthDailySeries','presentCount','absentCount','today', 'totalPaid', 'totalUnpaid','todayCollection','thisMonthCollection','allTimeCollection'));

        } catch (\Exception $e) {
        report($e);
        return false;
        }
    }

    /**
     * User Profile
     * @param Nill
     * @return View Profile
     * @author Shani Singh
     */
    public function getProfile()
    {
        try{
        $session = Auth::user()->id;
        // dd($session);
        $users = User::where('users.id',  $session)
            ->first();
        // dd($users);

        return view('profile', compact('users'));
        } catch (\Exception $e) {

        report($e);
 
        return false;
    }
    }


    public function EditProfile()
    {
        try{
        $roles = Role::where('id', '!=', '1')->get();

        return view('Editprofile', compact('roles'));
        } catch (\Exception $e) {

        report($e);
 
        return false;
    }
    }

    /**
     * Update Profile
     * @param $profileData
     * @return Boolean With Success Message
     * @author Shani Singh
     */
   public function updateProfile(Request $request)
    {
    
        #Validations
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'mobile_number' => 'required|numeric|digits:10',
        ]);

        try {
            DB::beginTransaction();

            #Update Profile Data
            User::whereId(auth()->user()->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
            ]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Profile Updated Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Change Password
     * @param Old Password, New Password, Confirm New Password
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function changePassword(Request $request)
    {
        try{
        $session = Auth::user()->id;

        $user = User::where('id', '=', $session)->where(['status' => 1])->first();

        if (Hash::check($request->current_password, $user->password)) 
        {
            $newpassword = $request->new_password;
            $confirmpassword = $request->new_confirm_password;

            if ($newpassword == $confirmpassword) {
                $Student = DB::table('users')
                    ->where(['status' => 1, 'id' => $session])
                    ->update([
                        'password' => Hash::make($confirmpassword),
                    ]);
                Auth::logout();
                return redirect()->route('login')->with('success', 'User Password Updated Successfully.');
            } else {
                return back()->with('error', 'password and confirm password does not match');
            }
        } else {
            return back()->with('error', 'Current Password does not match');
        }
        } catch (\Exception $e) {

        report($e);
 
        return false;
    }
    }
}
