<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'max_usage',
        'used',
        'expired_at',
        'status',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'status' => 'boolean',
    ];
}