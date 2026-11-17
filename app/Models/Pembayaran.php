<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $fillable = [
        'parkir_id',
        'user_id',
        'jumlah_bayar',
        'uang_diterima',
        'kembalian',
        'metode',
        'tanggal_bayar',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'decimal:2',
            'uang_diterima' => 'decimal:2',
            'kembalian' => 'decimal:2',
            'tanggal_bayar' => 'datetime',
        ];
    }

    public function parkir(): BelongsTo
    {
        return $this->belongsTo(Parkir::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
