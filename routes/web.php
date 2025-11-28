<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\TankerController;
use App\Http\Controllers\Admin\TruckController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\EmployeeMasterController;
use App\Http\Controllers\Admin\GodownMasterController;
use App\Http\Controllers\Admin\VendorMasterController;
use App\Http\Controllers\Admin\OrderMasterController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RentPriceController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\EmpSalaryController;
use App\Http\Controllers\Admin\DailyExpenceTypeController;
use App\Http\Controllers\Admin\DailyExpenceController;
use App\Http\Controllers\Admin\IsconDailyExpenceController;
use App\Http\Controllers\Admin\AttendanceReportController;

use App\Http\Controllers\Admin\DailyOrderController;
use App\Http\Controllers\Admin\CollectionReportController;
use App\Http\Controllers\Admin\TripController;


Route::fallback(function () {
     return view('errors.404');
});

Route::get('/login', function () {
    return redirect()->route('login');
});


Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::get('/edit', [HomeController::class, 'EditProfile'])->name('EditProfile');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');

});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users
Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{id?}', [UserController::class, 'edit'])->name('edit');
    Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
    Route::post('/password-update/{Id?}', [UserController::class, 'passwordupdate'])->name('passwordupdate');
    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');
    Route::get('export/', [UserController::class, 'export'])->name('export');
});


//customer master 
Route::prefix('admin')->group(function () {
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::post('customer/delete', [CustomerController::class, 'delete'])->name('customer.delete');
    Route::post('customer/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('customer.bulkDelete');
});

/// tanker master 
Route::prefix('admin')->group(function () {
    Route::get('tanker', [TankerController::class, 'index'])->name('tanker.index');
    Route::post('tanker/store', [TankerController::class, 'store'])->name('tanker.store');
    Route::get('tanker/edit/{id}', [TankerController::class, 'edit'])->name('tanker.edit');
    Route::post('tanker/update/{tanker}', [TankerController::class, 'update'])->name('tanker.update');
    Route::post('tanker/delete/{tanker?}', [TankerController::class, 'delete'])->name('tanker.delete');
    Route::post('tanker/bulk-delete', [TankerController::class, 'bulkDelete'])->name('tanker.bulkDelete');
    Route::get('tanker/names', [TankerController::class, 'names'])->name('tankers.names');
    Route::get('tankers/in-godown', [TankerController::class, 'inGodown'])->name('tankers.in-godown');
});


// Employee Master
Route::prefix('admin')->group(function () {
    Route::resource('employee', EmployeeMasterController::class);
    Route::post('employee/bulk-delete', [EmployeeMasterController::class, 'bulkDelete'])->name('employee.bulk-delete');
    Route::post('employee/change-status/{id}', [EmployeeMasterController::class, 'changeStatus'])->name('employee.change-status');
});

// godown master


Route::prefix('admin')->group(function () {
    Route::get('godown',            [GodownMasterController::class, 'index'])->name('godown.index');
    Route::post('godown',           [GodownMasterController::class, 'store'])->name('godown.store');
    Route::put('godown/{id}',       [GodownMasterController::class, 'update'])->name('godown.update');

    // Soft delete (single) & bulk delete
    Route::delete('godown/{id}',    [GodownMasterController::class, 'destroy'])->name('godown.destroy');
    Route::post('godown/bulk-delete', [GodownMasterController::class, 'bulkDelete'])->name('godown.bulk-delete');

    // Status toggle
    Route::post('godown/change-status/{id}', [GodownMasterController::class, 'changeStatus'])->name('godown.change-status');

    // Edit (fetch JSON for modal)
    Route::get('godown/{id}', [GodownMasterController::class, 'show'])->name('godown.show'); // returns JSON for modal
});

// vendor master
Route::prefix('admin')->group(function () {
    Route::get('vendor',               [VendorMasterController::class, 'index'])->name('vendor.index');
    Route::get('vendor/create',        [VendorMasterController::class, 'create'])->name('vendor.create');
    Route::post('vendor',              [VendorMasterController::class, 'store'])->name('vendor.store');
    Route::get('vendor/{id}/edit',     [VendorMasterController::class, 'edit'])->name('vendor.edit');
    Route::put('vendor/{id}',          [VendorMasterController::class, 'update'])->name('vendor.update');

    // single hard delete + bulk delete
    Route::delete('vendor/{id}',       [VendorMasterController::class, 'destroy'])->name('vendor.destroy');
    Route::post('vendor/bulk-delete',  [VendorMasterController::class, 'bulkDelete'])->name('vendor.bulk-delete');

    // status toggle
    Route::post('vendor/change-status/{id}', [VendorMasterController::class, 'changeStatus'])->name('vendor.change-status');
});


Route::prefix('admin')->group(function () {
    Route::get('orders',               [OrderMasterController::class, 'index'])->name('orders.index');
    Route::get('orders/create',        [OrderMasterController::class, 'create'])->name('orders.create');
    Route::post('orders',              [OrderMasterController::class, 'store'])->name('orders.store');
    Route::get('orders/{id}/edit',     [OrderMasterController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{id}',          [OrderMasterController::class, 'update'])->name('orders.update');
    Route::get('/orders/{order}/tanker-details', [OrderMasterController::class, 'tankerDetails'])
     ->name('orders.tanker-details');

    Route::delete('orders/{id}',       [OrderMasterController::class, 'destroy'])->name('orders.destroy');
    Route::post('orders/bulk-delete',  [OrderMasterController::class, 'bulkDelete'])->name('orders.bulk-delete');
    Route::post('orders/change-status/{id}', [OrderMasterController::class, 'changeStatus'])->name('orders.change-status');
    Route::get('orders/{id}/toggle-receive', [OrderMasterController::class, 'toggleReceive'])->name('orders.toggle-receive');
    Route::post('/orders/{order}/mark-received', action: [OrderMasterController::class, 'markReceived'])
        ->name('orders.mark-received');
    Route::get('/orders/{id}/orders-summary', [OrderMasterController::class, 'customerOrdersSummary'])
        ->name('orders.orders-summary');


    });

Route::post('payments/store', [PaymentController::class, 'store'])->name('payments.store');
Route::get('orders/{order}/payments/history', [PaymentController::class, 'history'])
        ->name('payments.history');


Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::resource('rent-prices', RentPriceController::class)
             ->only(['index','store','update','destroy']);

        // point to a method, and use correct ->name('...')
        Route::get('ajax/rent-price', [RentPriceController::class, 'getRentPrice'])
             ->name('ajax.rent-price');
    });


Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('attendance',  [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/names', [AttendanceController::class, 'names'])
        ->name('attendance.names');
    Route::get('/attendance/employee/{emp}', [AttendanceController::class, 'employeeAttendance'])->name('attendance.employee');

});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('emp-salaries', EmpSalaryController::class)->only(['index','store','update','destroy']);
    Route::get('/emp-salaries/last-range',        [EmpSalaryController::class, 'lastRange'])->name('emp-salaries.last-range');
    Route::get('/emp-salaries/quote-attendance',  [EmpSalaryController::class, 'quoteFromAttendance'])->name('emp-salaries.quote-attendance');

    Route::post('/emp-salaries', [EmpSalaryController::class, 'store'])->name('emp-salaries.store');

});


Route::middleware(['web','auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('daily-expences', [DailyExpenceController::class, 'index'])->name('daily-expences.index');
    Route::post('daily-expences', [DailyExpenceController::class, 'store'])->name('daily-expences.store');
    Route::get('daily-expences/{id}', [DailyExpenceController::class, 'show'])->name('daily-expences.show'); // JSON for edit modal
    Route::put('daily-expences/{id}', [DailyExpenceController::class, 'update'])->name('daily-expences.update');
    Route::delete('daily-expences/{id}', [DailyExpenceController::class, 'destroy'])->name('daily-expences.destroy');

    Route::post('daily-expences/bulk-delete', [DailyExpenceController::class, 'bulkDelete'])->name('daily-expences.bulk-delete');
    Route::post('daily-expences/{id}/toggle', [DailyExpenceController::class, 'toggleStatus'])->name('daily-expences.toggle');
});


Route::middleware(['web','auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get   ('daily-expence-types',          [DailyExpenceTypeController::class, 'index'])->name('daily-expence-types.index');
    Route::post  ('daily-expence-types',          [DailyExpenceTypeController::class, 'store'])->name('daily-expence-types.store');
    Route::get   ('daily-expence-types/{id}',     [DailyExpenceTypeController::class, 'show'])->name('daily-expence-types.show'); // JSON for modal
    Route::put   ('daily-expence-types/{id}',     [DailyExpenceTypeController::class, 'update'])->name('daily-expence-types.update');
    Route::delete('daily-expence-types/{id}',     [DailyExpenceTypeController::class, 'destroy'])->name('daily-expence-types.destroy');

    Route::post  ('daily-expence-types/bulk-delete', [DailyExpenceTypeController::class, 'bulkDelete'])->name('daily-expence-types.bulk-delete');
    Route::post  ('daily-expence-types/{id}/toggle', [DailyExpenceTypeController::class, 'toggleStatus'])->name('daily-expence-types.toggle');
});


// routes/web.php
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('payment-received-user', [App\Http\Controllers\Admin\PaymentReceivedUserController::class, 'index'])->name('payment-received-user.index');
    Route::post('payment-received-user/store', [App\Http\Controllers\Admin\PaymentReceivedUserController::class, 'store'])->name('payment-received-user.store');
    Route::get('payment-received-user/edit/{id}', [App\Http\Controllers\Admin\PaymentReceivedUserController::class, 'edit'])->name('payment-received-user.edit');
    Route::post('payment-received-user/update/{id}', [App\Http\Controllers\Admin\PaymentReceivedUserController::class, 'update'])->name('payment-received-user.update');
    Route::post('payment-received-user/delete', [App\Http\Controllers\Admin\PaymentReceivedUserController::class, 'destroy'])->name('payment-received-user.delete');
    Route::get('payment-received-user/toggle/{id}', [App\Http\Controllers\Admin\PaymentReceivedUserController::class, 'toggleStatus'])->name('payment-received-user.toggle');
});

/*------------- emp withdrawal  ----------------------------------*/

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('employee-extra-withdrawal', [App\Http\Controllers\Admin\EmployeeExtraWithdrawalController::class, 'index'])->name('employee-extra-withdrawal.index');
    Route::post('employee-extra-withdrawal/store', [App\Http\Controllers\Admin\EmployeeExtraWithdrawalController::class, 'store'])->name('employee-extra-withdrawal.store');
    Route::get('employee-extra-withdrawal/edit/{id}', [App\Http\Controllers\Admin\EmployeeExtraWithdrawalController::class, 'edit'])->name('employee-extra-withdrawal.edit');
    Route::post('employee-extra-withdrawal/update/{id}', [App\Http\Controllers\Admin\EmployeeExtraWithdrawalController::class, 'update'])->name('employee-extra-withdrawal.update');
    Route::post('employee-extra-withdrawal/delete', [App\Http\Controllers\Admin\EmployeeExtraWithdrawalController::class, 'destroy'])->name('employee-extra-withdrawal.delete');

    Route::get('admin/employee-extra-withdrawal/employee-detail',
    [App\Http\Controllers\Admin\EmployeeExtraWithdrawalController::class, 'employeeDetail'])->name('employee-extra-withdrawal.employee-detail')->middleware('auth');

});


/*-----------------reports -------------------------------------------*/
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('expence-report', [App\Http\Controllers\Admin\ExpenceReportController::class, 'index'])->name('admin.expence-report.index');
    Route::get('expence-report/{date}', [App\Http\Controllers\Admin\ExpenceReportController::class, 'show'])->name('admin.expence-report.show');
});


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::any('attendance-report', [AttendanceReportController::class, 'index'])
         ->name('admin.attendance-report.index');
Route::get('admin/attendance-report/employee-detail',[AttendanceReportController::class, 'employeeDetail'])->name('admin.attendance-report.employee-detail')->middleware('auth');

});


/*--------------------------------daily order controller--------------------------------------*/


Route::prefix('daily-orders')->group(function () {
    Route::get('/', [DailyOrderController::class, 'index'])->name('daily-orders.index');
    Route::get('daily-orders/create', [DailyOrderController::class, 'create'])->name('daily-orders.create');
    Route::post('/', [DailyOrderController::class, 'store'])->name('daily-orders.store');
    Route::get('daily-orders/edit/{id}', [DailyOrderController::class, 'edit'])->name('daily-orders.edit');
    Route::put('/{id}', [DailyOrderController::class, 'update'])->name('daily-orders.update');
    Route::delete('/{id}', [DailyOrderController::class, 'destroy'])->name('daily-orders.destroy');

    // Payments against a customer (optional daily_order_id can be passed)
    Route::post('daily-orders/{daily_order}/payment', [DailyOrderController::class, 'receivePayment'])
        ->name('daily-orders.payment');

    /*Route::get('/admin/customers/{customer}/payments', [DailyOrderController::class, 'customerPayments'])
     ->name('customers.payments');*/

Route::get('/admin/daily-orders/{order}/payments/view',[DailyOrderController::class, 'orderPayments'])->name('daily-orders.order-payments');
Route::put('/daily-orders/{id}/receive',  [DailyOrderController::class, 'receive'])->name('daily-orders.receive');
Route::put('/daily-orders/{id}/unreceive',[DailyOrderController::class, 'unreceive'])->name('daily-orders.unreceive');

Route::post('daily-orders/{id}/pay', [DailyOrderController::class, 'pay'])->name('daily-orders.pay');

});



// routes/web.php


Route::middleware(['auth'])->group(function () {
    Route::get('admin/collection-report',                [CollectionReportController::class, 'index'])->name('reports.collection');
    Route::get('admin/collection-report/day/{date}',     [CollectionReportController::class, 'day'])->where('date','\d{4}-\d{2}-\d{2}')->name('reports.collection.day');
    Route::get('admin/collection-report/details',        [CollectionReportController::class, 'range'])->name('reports.collection.range'); // full detail for range
});


/// Truck master 
Route::prefix('admin')->group(function () {
    Route::get('truck', [TruckController::class, 'index'])->name('truck.index');
    Route::post('truck/store', [TruckController::class, 'store'])->name('truck.store');
    Route::get('truck/edit/{id}', [TruckController::class, 'edit'])->name('truck.edit');
    Route::put('truck/update/{id}', [TruckController::class, 'update'])->name('truck.update');
    Route::post('truck/delete', [TruckController::class, 'destroy'])->name('truck.delete');
    Route::post('truck/bulk-delete', [TruckController::class, 'bulkDelete'])->name('truck.bulkDelete');
});


// driver master 
Route::prefix('admin')->group(function () {
    Route::get('driver', [DriverController::class, 'index'])->name('driver.index');
    Route::post('driver/store', [DriverController::class, 'store'])->name('driver.store');
    Route::put('driver/{id}', [DriverController::class, 'update'])->name('driver.update');
    Route::post('driver/delete', [DriverController::class, 'delete'])->name('driver.delete');
    Route::post('driver/bulk-delete', [DriverController::class, 'bulkDelete'])->name('driver.bulkDelete');

});


Route::middleware(['web','auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('iscon-daily-expences', [IsconDailyExpenceController::class, 'index'])->name('iscon-daily-expences.index');
    Route::post('iscon-daily-expences', [IsconDailyExpenceController::class, 'store'])->name('iscon-daily-expences.store');
    Route::get('iscon-daily-expences/{id}', [IsconDailyExpenceController::class, 'show'])->name('iscon-daily-expences.show'); // JSON for edit modal
    Route::put('iscon-daily-expences/{id}', [IsconDailyExpenceController::class, 'update'])->name('iscon-daily-expences.update');
    Route::delete('iscon-daily-expences/{id}', [IsconDailyExpenceController::class, 'destroy'])->name('iscon-daily-expences.destroy');

    Route::post('iscon-daily-expences/bulk-delete', [IsconDailyExpenceController::class, 'bulkDelete'])->name('iscon-daily-expences.bulk-delete');
    Route::post('iscon-daily-expences/{id}/toggle', [IsconDailyExpenceController::class, 'toggleStatus'])->name('iscon-daily-expences.toggle');
});


Route::prefix('admin')->group(function () {

    // LISTING PAGE
    Route::get('trip', [TripController::class, 'index'])->name('trip.index');
    Route::get('trip/create', [TripController::class, 'create'])->name('trip.create');
    Route::post('trip/store', [TripController::class, 'store'])->name('trip.store');
    Route::get('trip/{id}/edit', [TripController::class, 'edit'])->name('trip.edit');
    Route::post('trip/edit/{id}', [TripController::class, 'update'])->name('trip.update');
    Route::post('trip/delete', [TripController::class, 'delete'])->name('trip.delete');
    Route::post('trip/bulk-delete', [TripController::class, 'bulkDelete'])->name('trip.bulkDelete');
});
