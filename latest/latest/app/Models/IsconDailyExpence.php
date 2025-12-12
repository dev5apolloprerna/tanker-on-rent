<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsconDailyExpence extends Model
{
    protected $table = 'iscon_daily_expence_master';
    protected $primaryKey = 'expence_id';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'expence_type_id', 'amount','expence_date', 'comment', 'iStatus', 'isDelete',
    ];

    protected $casts = [
        'expence_type_id' => 'integer',
        'amount' => 'integer',
        'iStatus' => 'integer',
        'isDelete' => 'integer',
    ];

    /** Scope: only not-deleted rows */
    public function scopeAlive($q)
    {
        return $q->where('isDelete', 0);
    }
    public function scopeNotDeleted($q)
    {
        return $q->where('isDelete', 0);
    }
    
       public function types() { return $this->belongsTo(DailyExpenceType::class, 'expence_type_id', 'expence_type_id'); }

}
