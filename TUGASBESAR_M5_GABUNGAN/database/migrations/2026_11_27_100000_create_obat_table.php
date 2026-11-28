<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->string('kategori');   // Analgesik & Antipiretik / Antibiotik / Vitamin & Suplemen
            $table->string('sediaan');    // Tablet / Kapsul / Sirup / Bubuk
            $table->string('pabrikan');   // Kimia Farma / Kalbe Farma / Dexa Medica / Unknown
            // tanpa timestamps(), karena model Obat memakai $timestamps = false
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
