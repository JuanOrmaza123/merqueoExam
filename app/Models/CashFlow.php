<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class CashFlow
 * @package App\Models
 */
class CashFlow extends Model
{
    /**
     * @var string
     */
    protected $table = 'cash_flow';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'denomination',
        'value',
        'count',
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

    /**
     * @return BelongsToMany
     */
    public function logs(): BelongsToMany
    {
        return $this->belongsToMany(Log::class)->withPivot('cash_flow_count');
    }
}
