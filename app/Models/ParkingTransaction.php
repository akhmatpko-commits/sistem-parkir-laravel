<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ParkingTransaction extends Model
{
    protected $fillable = [
        'parking_area_id',
        'ticket_code',
        'plate_number',
        'vehicle_type',
        'entry_time',
        'exit_time',
        'parking_fee',
        'status',
        'user_id',
    ];

    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
        'parking_fee' => 'decimal:2',
    ];

    public function parkingArea()
    {
        return $this->belongsTo(
            ParkingArea::class,
            'parking_area_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): HasOne
{
    return $this->hasOne(
        ParkingPayment::class,
        'parking_transaction_id'
    );
}
}
