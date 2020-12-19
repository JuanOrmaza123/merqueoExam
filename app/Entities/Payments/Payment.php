<?php

namespace App\Entities\Payments;

use App\Entities\CashFlow\CashFlow;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'id',
        'total_customer',
        'purchase_total',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $dates  = [
        'created_at',
        'updated_at',
    ];

    public function cashFlow()
    {
        return $this->belongsToMany(CashFlow::class)->withPivot('cash_flow_count');
    }
}
