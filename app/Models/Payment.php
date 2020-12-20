<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Payment
 * @package App\Models
 */
class Payment extends Model
{
    /**
     * @var string
     */
    protected $table = 'payments';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'total_customer',
        'total_purchase',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var string[]
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
