<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kendaraan;

class KendaraanSeeder extends Seeder
{
    public function run(): void
    {
        Kendaraan::updateOrCreate(
            ['kode_kendaraan' => 'MTR'],
            [
                'nama_kendaraan' => 'Motor',
                'keterangan' => 'Kendaraan roda dua',
                'status' => true,
            ]
        );

        Kendaraan::updateOrCreate(
            ['kode_kendaraan' => 'MBL'],
            [
                'nama_kendaraan' => 'Mobil',
                'keterangan' => 'Kendaraan roda empat',
                'status' => true,
            ]
        );
    }
}
