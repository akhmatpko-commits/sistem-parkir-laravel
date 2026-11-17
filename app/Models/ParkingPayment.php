<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParkingPayment extends Model
{
    protected $fillable = [
        'parking_transaction_id',
        'user_id',
        'amount',
        'amount_received',
        'change_amount',
        'method',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'amount_received' => 'decimal:2',
            'change_amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(
            ParkingTransaction::class,
            'parking_transaction_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parkingPayments(): HasMany
{
    return $this->hasMany(ParkingPayment::class);
}
}
