<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'vehicle_type',
        'hourly_rate',
        'daily_max_rate',
        'is_active',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'daily_max_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
