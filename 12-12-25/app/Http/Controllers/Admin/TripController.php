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
        $query = Trip::with(['truck','driver'])->where('isDelete', 0);

        if ($request->filled('from_date')) {
            $query->whereDate('trip_date', '>=', $request->from_date);
        }

        // To Date
        if ($request->filled('to_date')) {
            $query->whereDate('trip_date', '<=', $request->to_date);
        }

        // Truck
        if ($request->filled('truck_id')) {
            $query->where('truck_id', $request->truck_id);
        }

        /*if ($request->trip_date) {
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
        }*/

     $trips = $query->orderBy('trip_date', 'desc')->paginate(20);

     $trucks = Truck::select('truck_id','truck_name')->get();

        return view('admin.trip.index', compact('trips','trucks'));
    }

 public function ExportTripData($FromDate="",$ToDate="",$TruckId="")
    {
        try{
            $query = Trip::with(['truck','driver'])->where('isDelete', 0);

            if ($FromDate) {
                $query->whereDate('trip_date', '>=', $FromDate);
            }

            // To Date
            if ($ToDate) {
                $query->whereDate('trip_date', '<=', $ToDate);
            }

            // Truck
            if ($TruckId) {
                $query->where('truck_id', $TruckId);
            }
            $trips = $query->orderBy('trip_date', 'desc')->get();

            return view('admin.trip.ExportTripData', compact('trips'));
        } catch (\Exception $e) {

            report($e);
     
            return false;
        }

    }

    private function normalizeWeight($value)
    {
        $v = strtolower(trim($value));

        // Extract numeric part
        preg_match('/([0-9]*\.?[0-9]+)/', $v, $match);
        $num = isset($match[1]) ? (float)$match[1] : 0;

        // Detect TON (ton, tonne, t)
        if (str_contains($v, 'ton') || str_contains($v, 'tonne') || str_contains($v, ' t ')) {
            return $num * 1000; // convert tons to KG
        }

        // Detect kg
        if (str_contains($v, 'kg')) {
            return $num; // already in KG
        }

        // No unit → assume KG
        return $num;
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


        $normalizedWeight = $this->normalizeWeight($request->weight);

        // Create record safely
        Trip::create([
            'trip_date'   => $request->trip_date,
            'truck_id'    => $request->truck_id,
            'driver_id'   => $request->driver_id,
            'product'     => $request->product,
            'source'      => $request->source,
            'destination' => $request->destination,
            'no_of_bags'  => $request->no_of_bags,
            'weight'      => $request->weight,   // always in KG
            'total_weight' => $normalizedWeight,   // always in KG
        ]);


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
                'no_of_bags'  => 'required|numeric',
                'weight'      => 'required|max:100',
            ]);

            // Normalize weight (KG or TON)
            $normalizedWeight = $this->normalizeWeight($request->weight);

            // Update safely (NO mass assignment risks)
            $trip->update([
                'trip_date'   => $request->trip_date,
                'truck_id'    => $request->truck_id,
                'driver_id'   => $request->driver_id,
                'product'     => $request->product,
                'source'      => $request->source,
                'destination' => $request->destination,
                'no_of_bags'  => $request->no_of_bags,
                'weight'      => $request->weight,   // stored only in KG
                'total_weight'      => $normalizedWeight,   // stored only in KG
            ]);

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
