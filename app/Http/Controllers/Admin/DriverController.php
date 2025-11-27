<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::where('isDelete', 0)
                    ->orderBy('driver_id', 'DESC')
                    ->get();

        return view('admin.driver.index', compact('drivers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_name' => 'required|max:200'
        ]);

        Driver::create([
            'driver_name' => $request->driver_name,
            'iStatus'     => 1,
            'isDelete'    => 0,
        ]);

        return back()->with('success', 'Driver added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'driver_name' => 'required|max:200'
        ]);

        $driver = Driver::where('driver_id', $id)
                        ->where('isDelete', 0)
                        ->firstOrFail();

        $driver->update([
            'driver_name' => $request->driver_name,
        ]);

        return back()->with('success', 'Driver updated successfully.');
    }

    public function delete(Request $request)
    {
        if (!$request->id) {
            return response()->json(['success' => false]);
        }

        Driver::where('driver_id', $request->id)->update([
            'isDelete' => 1
        ]);

        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        if (!is_array($request->ids) || count($request->ids) == 0) {
            return response()->json(['success' => false]);
        }

        Driver::whereIn('driver_id', $request->ids)
              ->update(['isDelete' => 1]);

        return response()->json(['success' => true]);
    }
}
