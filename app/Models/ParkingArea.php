<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParkingArea extends Model
{
    protected $fillable = [
        'area_code',
        'area_name',
        'vehicle_type',
        'capacity',
        'status',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(
            ParkingTransaction::class,
            'parking_area_id'
        );
    }

    public function getOccupiedAttribute(): int
    {
        return $this->transactions()
            ->where('status', 'masuk')
            ->count();
    }

    public function getAvailableAttribute(): int
    {
        return max(0, $this->capacity - $this->occupied);
    }
}
