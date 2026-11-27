<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::all();
        return view('dokters.index', compact('dokters'));
    }

    public function create()
    {
        return view('dokters.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokter'  => 'required',
            'spesialisasi' => 'required',
            'no_telepon'   => 'nullable',
        ]);

        Dokter::create($request->only(['nama_dokter', 'spesialisasi', 'no_telepon']));

        return redirect()->route('dokters.index')
            ->with('sukses', 'Data dokter berhasil ditambahkan!');
    }

    public function edit(Dokter $dokter)
    {
        return view('dokters.form', compact('dokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama_dokter'  => 'required',
            'spesialisasi' => 'required',
            'no_telepon'   => 'nullable',
        ]);

        $dokter->update($request->only(['nama_dokter', 'spesialisasi', 'no_telepon']));

        return redirect()->route('dokters.index')
            ->with('sukses', 'Data dokter berhasil diperbarui!');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();

        return redirect()->route('dokters.index')
            ->with('sukses', 'Data dokter berhasil dihapus!');
    }
}