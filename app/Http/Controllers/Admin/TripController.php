<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Truck;
use App\Models\Driver;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::with(['truck', 'driver'])
                    ->where('isDelete', 0);

        if ($request->trip_date) {
            $query->where('trip_date', $request->trip_date);
        }
        if ($request->product) {
            $query->where('product', 'like', "%{$request->product}%");
        }
        if ($request->source) {
            $query->where('source', 'like', "%{$request->source}%");
        }
        if ($request->destination) {
            $query->where('destination', 'like', "%{$request->destination}%");
        }

        $trips = $query->orderBy('trip_id', 'DESC')->paginate(10);

        return view('admin.trip.index', compact('trips'));
    }

    public function create()
    {
        $trucks = Truck::where('isDelete', 0)->orderby('truck_name')->get();
        $drivers = Driver::where('isDelete', 0)->orderby('driver_name')->get();

        return view('admin.trip.form', [
            'trip' => null,
            'trucks' => $trucks,
            'drivers' => $drivers,
            'mode' => 'add'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'trip_date'   => 'required|date',
            'truck_id'    => 'required|integer',
            'driver_id'   => 'required|integer',
            'product'     => 'required|max:255',
            'source'      => 'required|max:255',
            'destination' => 'required|max:255',
            'weight'      => 'required|max:100',
        ]);

        Trip::create($request->all());

        return redirect()->route('trip.index')->with('success', 'Trip added successfully.');
    }

    public function edit($id)
    {
        $trip = Trip::findOrFail($id);
        $trucks = Truck::where('isDelete', 0)->orderby('truck_name')->get();
        $drivers = Driver::where('isDelete', 0)->orderby('driver_name')->get();

        return view('admin.trip.form', [
            'trip' => $trip,
            'trucks' => $trucks,
            'drivers' => $drivers,
            'mode' => 'edit'
        ]);
    }

    public function update(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        $request->validate([
            'trip_date'   => 'required|date',
            'truck_id'    => 'required|integer',
            'driver_id'   => 'required|integer',
            'product'     => 'required|max:255',
            'source'      => 'required|max:255',
            'destination' => 'required|max:255',
            'weight'      => 'required|max:100',
        ]);

        $trip->update($request->all());

        return redirect()->route('trip.index')->with('success', 'Trip updated successfully.');
    }

    public function delete(Request $request)
    {
        $dd=Trip::where('trip_id', $request->id)->delete();
        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        Trip::whereIn('trip_id', $request->ids)->update(['isDelete' => 1]);
        return response()->json(['success' => true]);
    }
}
