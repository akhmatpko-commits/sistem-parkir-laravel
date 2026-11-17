<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@parkir.com'],
            [
                'name' => 'Administrator',
                'password' => 'AdminParkir123!',
                'role' => 'admin',
            ]
        );

        // Akun Petugas
        User::updateOrCreate(
            ['email' => 'petugas@parkir.com'],
            [
                'name' => 'Petugas Parkir',
                'password' => 'PetugasParkir123!',
                'role' => 'petugas',
            ]
        );
    }
}
