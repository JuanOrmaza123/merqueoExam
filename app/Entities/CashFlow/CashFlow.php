<?php

namespace App\Entities\CashFlow;

use App\Entities\Logs\Log;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Payments\Payment;

class CashFlow extends Model
{
    protected $table = 'cash_flow';

    protected $fillable = [
        'id',
        'denomination',
        'value',
        'count',
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

    public function payments()
    {
        return $this->belongsToMany(Payment::class)->withPivot('cash_flow_count');
    }

    public function logs()
    {
        return $this->belongsToMany(Log::class)->withPivot('cash_flow_count');
    }
}
