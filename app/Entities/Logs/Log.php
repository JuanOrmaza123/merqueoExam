<?php

namespace App\Entities\Logs;

use App\Entities\CashFlow\CashFlow;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'id',
        'type',
        'value',
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
