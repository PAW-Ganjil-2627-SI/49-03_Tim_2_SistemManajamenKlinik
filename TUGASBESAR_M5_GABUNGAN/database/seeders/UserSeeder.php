<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@klinik.com'],
            ['name' => 'Admin Klinik', 'password' => 'password123', 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'damijosua@gmail.com'],
            ['name' => 'Petugas Klinik', 'password' => '@Damskuy123', 'role' => 'petugas']
        );
    }
}