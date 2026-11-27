<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_dokter' => 'dr. Contoh Satu', 'spesialisasi' => 'Umum', 'no_telepon' => '081200000001'],
            ['nama_dokter' => 'drg. Contoh Dua', 'spesialisasi' => 'Gigi',  'no_telepon' => '081200000002'],
        ];

        foreach ($data as $row) {
            Dokter::updateOrCreate(['nama_dokter' => $row['nama_dokter']], $row);
        }
    }
}