<?php

namespace App\Entities\Logs;

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
}
