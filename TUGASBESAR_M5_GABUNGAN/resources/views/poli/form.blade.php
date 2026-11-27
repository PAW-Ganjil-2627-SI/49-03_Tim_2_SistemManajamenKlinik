@extends('layouts.app')

@section('title', isset($poli) ? 'Edit Ruang Poli' : 'Tambah Ruang Poli')

@push('styles')
<style>
    select { width: 100%; padding: 10px; margin: 8px 0 20px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; }
    .btn-simpan { background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
    .btn-batal { background-color: #95a5a6; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-size: 16px; font-weight: bold; margin-left: 8px; }
</style>
@endpush

@section('content')
    @php
        $jenisList = ['Poli Umum', 'Poli Gigi', 'Poli Anak', 'Poli Mata', 'Poli Penyakit Dalam', 'Poli Lainnya'];
        $nilaiPoli = old('nama_poli', $poli->nama_poli ?? '');
        // Jika data lama memakai nama poli di luar daftar, tetap tampilkan agar tidak hilang saat diedit.
        if ($nilaiPoli !== '' && ! in_array($nilaiPoli, $jenisList)) {
            $jenisList[] = $nilaiPoli;
        }
    @endphp

    <h2>{{ isset($poli) ? 'Edit Ruang Poliklinik' : 'Tambah Ruang Poliklinik' }}</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ isset($poli) ? route('poli.update', $poli) : route('poli.store') }}">
        @csrf
        @if (isset($poli))
            @method('PUT')
        @endif

        <label for="kode_ruangan">Kode Ruangan:</label>
        <input type="text" id="kode_ruangan" name="kode_ruangan" placeholder="Contoh: POLI-004"
               value="{{ old('kode_ruangan', $poli->kode_ruangan ?? '') }}" required>

        <label for="nama_poli">Nama / Jenis Poli:</label>
        <select id="nama_poli" name="nama_poli" required>
            <option value="">-- Pilih Jenis Poli --</option>
            @foreach ($jenisList as $jenis)
                <option value="{{ $jenis }}" @selected($nilaiPoli === $jenis)>{{ $jenis }}</option>
            @endforeach
        </select>

        <label for="lokasi_gedung">Lokasi Gedung / Lantai:</label>
        <input type="text" id="lokasi_gedung" name="lokasi_gedung" placeholder="Contoh: Gedung A, Lantai 1"
               value="{{ old('lokasi_gedung', $poli->lokasi_gedung ?? '') }}" required>

        <label for="inventaris_alat">Inventaris Alat Medis:</label>
        <textarea id="inventaris_alat" name="inventaris_alat" rows="4"
                  placeholder="Pisahkan dengan koma, contoh: Stetoskop, Tensimeter">{{ old('inventaris_alat', $poli->inventaris_alat ?? '') }}</textarea>

        <button type="submit" class="btn-simpan">{{ isset($poli) ? 'Simpan Perubahan' : 'Simpan Data' }}</button>
        <a href="{{ route('poli.index') }}" class="btn-batal">Batal</a>
    </form>
@endsection