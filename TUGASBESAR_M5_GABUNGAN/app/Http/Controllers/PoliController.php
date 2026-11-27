<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PoliController extends Controller
{
    // [READ] Tampilkan data ruangan poliklinik
    public function index()
    {
        $polis = Poli::orderBy('kode_ruangan')->get();

        return view('poli.index', compact('polis'));
    }
        /**
     * Aturan validasi, dipakai bersama oleh store() dan update().
     * Saat update, kode_ruangan milik data itu sendiri tidak dianggap "sudah dipakai".
     */
    private function rules(?Poli $poli = null): array
    {
        return [
            'kode_ruangan'    => ['required', 'string', 'max:50',
                                  Rule::unique('polis', 'kode_ruangan')->ignore($poli)],
            'nama_poli'       => ['required', 'string', 'max:50'],
            'lokasi_gedung'   => ['required', 'string', 'max:100'],
            'inventaris_alat' => ['nullable', 'string'],
        ];
    }

    // [CREATE] Tampilkan form tambah (admin)
    public function create()
    {
        return view('poli.form');
    }

    // [CREATE] Simpan data baru (admin)
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        // Kolom inventaris_alat di database tidak boleh NULL, jadi kosong disimpan sebagai teks kosong.
        $data['inventaris_alat'] = $data['inventaris_alat'] ?? '';

        Poli::create($data);

        return redirect()->route('poli.index')
            ->with('sukses', 'Ruang poliklinik berhasil ditambahkan!');
    }

    // [UPDATE] Tampilkan form edit (admin)
    public function edit(Poli $poli)
    {
        return view('poli.form', compact('poli'));
    }

    // [UPDATE] Simpan perubahan (admin)
    public function update(Request $request, Poli $poli)
    {
        $data = $request->validate($this->rules($poli));
        $data['inventaris_alat'] = $data['inventaris_alat'] ?? '';

        $poli->update($data);

        return redirect()->route('poli.index')
            ->with('sukses', 'Data ruang poliklinik berhasil diperbarui!');
    }

    // [DELETE] Hapus data (admin)
    public function destroy(Poli $poli)
    {
        $poli->delete();

        return redirect()->route('poli.index')
            ->with('sukses', 'Data ruang poliklinik berhasil dihapus!');
    }
}
