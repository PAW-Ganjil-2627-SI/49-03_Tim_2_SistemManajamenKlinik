<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    private function rules(): array
    {
        return [
            'nama_obat' => 'required|string|max:255',
            'kategori'  => 'required|in:Analgesik & Antipiretik,Antibiotik,Vitamin & Suplemen',
            'sediaan'   => 'required|in:Tablet,Kapsul,Sirup,Bubuk',
            'pabrikan'  => 'required|in:Kimia Farma,Kalbe Farma,Dexa Medica,Unknown',
        ];
    }

    // [READ] Tampilkan katalog obat (semua pengguna yang login)
    public function index()
    {
        $obat = Obat::all();

        return view('obat.index', compact('obat'));
    }

    // [CREATE] Tampilkan form tambah (admin)
    public function create()
    {
        return view('obat.form', ['obat' => new Obat()]);
    }

    // [CREATE] Simpan data baru (admin)
    public function store(Request $request)
    {
        Obat::create($request->validate($this->rules()));

        return redirect()->route('obat.index')
            ->with('sukses', 'Data obat berhasil ditambahkan!');
    }

    // [UPDATE] Tampilkan form edit (admin)
    public function edit(Obat $obat)
    {
        return view('obat.form', compact('obat'));
    }

    // [UPDATE] Simpan perubahan (admin)
    public function update(Request $request, Obat $obat)
    {
        $obat->update($request->validate($this->rules()));

        return redirect()->route('obat.index')
            ->with('sukses', 'Data obat berhasil diperbarui!');
    }

    // [DELETE] Hapus data (admin)
    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('sukses', 'Data obat berhasil dihapus!');
    }
}
