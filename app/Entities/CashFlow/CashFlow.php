<?php

namespace App\Entities\CashFlow;

use App\Entities\Logs\Log;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Payments\Payment;

class CashFlow extends Model
{
    protected $table = 'payments';

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
        return $this->belongsToMany(Payment::class);
    }

    public function logs()
    {
        return $this->belongsToMany(Log::class);
    }
}
