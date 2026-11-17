<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    protected $table = 'kendaraans';

    protected $fillable = [
        'nama_kendaraan',
        'kode_kendaraan',
        'keterangan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function tarifs(): HasMany
    {
        return $this->hasMany(Tarif::class, 'kendaraan_id');
    }

    public function parkirs(): HasMany
    {
        return $this->hasMany(Parkir::class, 'kendaraan_id');
    }
}
