<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kendaraan;
use App\Models\Tarif;

class TarifSeeder extends Seeder
{
    public function run(): void
    {
        $motor = Kendaraan::where(
            'kode_kendaraan', 'MTR'
        )->firstOrFail();

        $mobil = Kendaraan::where(
            'kode_kendaraan', 'MBL'
        )->firstOrFail();

        Tarif::updateOrCreate(
            ['kendaraan_id' => $motor->id],
            [
                'tarif_per_jam' => 2000,
                'tarif_maksimal' => 20000,
                'tarif_menginap' => 10000,
            ]
        );

        Tarif::updateOrCreate(
            ['kendaraan_id' => $mobil->id],
            [
                'tarif_per_jam' => 5000,
                'tarif_maksimal' => 50000,
                'tarif_menginap' => 25000,
            ]
        );
    }
}
