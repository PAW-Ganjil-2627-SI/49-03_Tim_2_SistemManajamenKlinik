<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        // Data contoh. Nilai kategori/sediaan/pabrikan harus sama dengan pilihan di ObatController.
        $data = [
            ['nama_obat' => 'Paracetamol 500mg', 'kategori' => 'Analgesik & Antipiretik', 'sediaan' => 'Tablet', 'pabrikan' => 'Kimia Farma'],
            ['nama_obat' => 'Paracetamol Sirup', 'kategori' => 'Analgesik & Antipiretik', 'sediaan' => 'Sirup',  'pabrikan' => 'Kalbe Farma'],
            ['nama_obat' => 'Amoxicillin 500mg', 'kategori' => 'Antibiotik',              'sediaan' => 'Kapsul', 'pabrikan' => 'Kalbe Farma'],
            ['nama_obat' => 'Vitamin C 500mg',   'kategori' => 'Vitamin & Suplemen',      'sediaan' => 'Tablet', 'pabrikan' => 'Dexa Medica'],
        ];

        foreach ($data as $row) {
            Obat::updateOrCreate(['nama_obat' => $row['nama_obat']], $row);
        }
    }
}
