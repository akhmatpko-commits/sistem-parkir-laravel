<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tarif extends Model
{
    protected $table = 'tarifs';

    protected $fillable = [
        'kendaraan_id',
        'tarif_per_jam',
        'tarif_maksimal',
        'tarif_menginap',
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function parkirs(): HasMany
    {
        return $this->hasMany(Parkir::class, 'tarif_id');
    }
}
