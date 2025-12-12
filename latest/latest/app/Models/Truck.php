<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Truck extends Model
{
    protected $table = 'truck_master';
    protected $primaryKey = 'truck_id';

    protected $fillable = [
        'truck_name',
        'truck_number',
        'slug',       // ← add slug
        'status',
        'iStatus',
        'isDelete',
    ];

    public function order()
    {
        return $this->hasOne( OrderMaster::class, 'truck_id', 'truck_id')
                    ->where('isDelete', operator: 0);
    }
     public function godown()
    {
        return $this->hasOne( GodownMaster::class, 'godown_id', 'godown_id')
                    ->where('isDelete', operator: 0);
    }
    protected static function booted()
    {
        // On create: set slug if empty
        static::creating(function (Truck $model) {
            if (empty($model->slug)) {
                $model->slug = static::makeUniqueSlug($model->truck_name);
            }
        });

        // On update: if name changed, refresh slug
        static::updating(function (Truck $model) {
            if ($model->isDirty('truck_name')) {
                $model->slug = static::makeUniqueSlug($model->truck_name, $model->getKey());
            }
        });
    }

    public static function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        if ($base === '') {
            $base = 'truck';
        }

        $slug = $base;
        $i = 2;

        while (
            static::query()
                ->where('slug', $slug)
                ->where('isDelete', 0)
                ->when($ignoreId, fn ($q) => $q->where('truck_id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
