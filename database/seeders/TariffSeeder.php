<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tariff;

class TariffSeeder extends Seeder
{
    public function run(): void
    {
        Tariff::updateOrCreate(
            ['vehicle_type' => 'Motor'],
            [
                'hourly_rate' => 2000,
                'daily_max_rate' => 20000,
                'is_active' => true,
            ]
        );

        Tariff::updateOrCreate(
            ['vehicle_type' => 'Mobil'],
            [
                'hourly_rate' => 5000,
                'daily_max_rate' => 50000,
                'is_active' => true,
            ]
        );
    }
}
