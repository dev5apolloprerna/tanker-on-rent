<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Truck;
use App\Models\GodownMaster;
use Illuminate\Validation\Rule;

use DB;

class TruckController extends Controller
{
    public function index()
    {
        $trucks =Truck::with('godown')
            ->where('isDelete', 0)
            ->orderBy('truck_id','DESC')
            ->paginate(env('PER_PAGE_COUNT'));
        $godown=GodownMaster::where(['iStatus'=>1,'isDelete'=>0])->orderBy('Name')->get();

        return view('admin.truck.index', compact('trucks','godown'));
    }

    public function store(Request $request)
    {
        DB::table('truck_master')->insert([
            'truck_name'   => $request->truck_name,
            'slug'         => Str::slug($request->truck_name),
            'truck_number' => $request->truck_number,
            'godown_id' => $request->godown_id,
            'status' => $request->status,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return back()->with('success', 'Truck added successfully.');
    }

    public function update(Request $request, $id)
    {
        DB::table('truck_master')->where('truck_id', $id)->update([
            'truck_name'   => $request->truck_name,
            'godown_id'   => $request->godown_id,
            'slug'         => Str::slug($request->truck_name),
            'truck_number' => $request->truck_number,
            'status' => $request->status,
            'updated_at'   => now()
        ]);

        return back()->with('success', 'Truck updated.');
    }

    public function destroy(Request $request)
    {
        DB::table('truck_master')->where('truck_id', $request->id)->update(['isDelete' => 1]);
        return response()->json(['success' => true]);
    }

 public function bulkDelete(Request $request)
    {
        if ($request->ids) {
            foreach ($request->ids as $id) {
                $tanker = Truck::find($id);
                if ($tanker) {
                    if ($tanker->getConnection()->getSchemaBuilder()->hasColumn('tanker_master', 'isDelete')) {
                        $tanker->update(['isDelete' => 1]);
                    } else {
                        $tanker->delete();
                    }
                }
            }
        }

        return back()->with('success', 'Selected Truck Deleted Successfully.');
    }
   
}
