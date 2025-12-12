<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'driver_master';
    protected $primaryKey = 'driver_id';
    public $timestamps = false;  // because table uses custom datetime fields

    protected $fillable = [
        'driver_name',
        'iStatus',
        'isDelete',
        'created_at',
        'updated_at',
    ];

    // Auto-manage created_at / updated_at manually if required
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = now();
            $model->updated_at = now();
        });

        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }

    // Relationship: Driver has many trips
    public function trips()
    {
        return $this->hasMany(Trip::class, 'driver_id', 'driver_id');
    }
}
