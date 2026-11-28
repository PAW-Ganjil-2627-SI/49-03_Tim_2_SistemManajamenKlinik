<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    // Nama tabel di database adalah "obat" (bukan "obats") dan tidak memakai created_at/updated_at.
    protected $table = 'obat';

    public $timestamps = false;

    protected $fillable = [
        'nama_obat',
        'kategori',
        'sediaan',
        'pabrikan',
    ];
}
