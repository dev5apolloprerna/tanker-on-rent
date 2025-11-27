<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table = "trip_master";
    protected $primaryKey = "trip_id";

    protected $fillable = [
        'trip_date', 'truck_id', 'driver_id', 'product',
        'source', 'destination', 'weight',
        'iStatus', 'isDelete'
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class, 'truck_id', 'truck_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'driver_id');
    }
}
