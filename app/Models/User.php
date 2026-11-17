<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELASI LAMA
    public function parkirs(): HasMany
    {
        return $this->hasMany(Parkir::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    // RELASI TRANSAKSI PARKIR
    public function parkingTransactions(): HasMany
    {
        return $this->hasMany(ParkingTransaction::class);
    }

    // RELASI PEMBAYARAN PARKIR
    public function parkingPayments(): HasMany
    {
        return $this->hasMany(ParkingPayment::class);
    }

    // CEK ROLE OWNER
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    // CEK ROLE ADMIN
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // CEK ROLE PETUGAS
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }
}
