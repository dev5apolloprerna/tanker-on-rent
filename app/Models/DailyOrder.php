<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyOrder extends Model
{
    protected $table = 'daily_order';
    protected $primaryKey = 'daily_order_id';
    public $incrementing = true;
    protected $keyType = 'int';

        protected $fillable = [
          'customer_id', 'customer_name', 'mobile', 'location', 'rent_date', 'placed_the_tanker', 'empty_the_tanker', 'filled_the_tanker', 'extra_amount', 'total_amount','isPaid','iStatus'
        ];


    protected $casts = [
        'rent_date' => 'date',
        'iStatus'   => 'integer',
        'isDelete'  => 'integer',
        'total_amount'    => 'integer',
    ];

    public function ledgers() {
        return $this->hasMany(DailyOrderLedger::class, 'daily_order_id', 'daily_order_id');
    }
}
