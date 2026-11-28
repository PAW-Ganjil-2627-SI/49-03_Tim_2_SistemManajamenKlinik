@extends('layouts.app')

@section('title', $obat->exists ? 'Edit Obat' : 'Tambah Obat')

@push('styles')
<style>
    select { width: 100%; padding: 10px; margin: 8px 0 20px 0; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; }
    .btn-simpan { background-color: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
    .btn-batal { background-color: #95a5a6; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-size: 16px; font-weight: bold; margin-left: 8px; }
</style>
@endpush

@section('content')
    @php
        $isEdit   = $obat->exists;
        $kategori = ['Analgesik & Antipiretik', 'Antibiotik', 'Vitamin & Suplemen'];
        $sediaan  = ['Tablet', 'Kapsul', 'Sirup', 'Bubuk'];
        $pabrikan = ['Kimia Farma', 'Kalbe Farma', 'Dexa Medica', 'Unknown'];
    @endphp

    <h2>{{ $isEdit ? 'Edit Data Obat' : 'Tambah Obat Baru' }}</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $isEdit ? route('obat.update', $obat) : route('obat.store') }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <label for="nama_obat">Nama Obat:</label>
        <input type="text" id="nama_obat" name="nama_obat" placeholder="Contoh: Paracetamol 500mg"
               value="{{ old('nama_obat', $obat->nama_obat) }}" required>

        <label for="kategori">Kategori Obat:</label>
        <select id="kategori" name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategori as $k)
                <option value="{{ $k }}" @selected(old('kategori', $obat->kategori) == $k)>{{ $k }}</option>
            @endforeach
        </select>

        <label for="sediaan">Sediaan:</label>
        <select id="sediaan" name="sediaan" required>
            <option value="">-- Pilih Sediaan --</option>
            @foreach ($sediaan as $s)
                <option value="{{ $s }}" @selected(old('sediaan', $obat->sediaan) == $s)>{{ $s }}</option>
            @endforeach
        </select>

        <label for="pabrikan">Pabrikan:</label>
        <select id="pabrikan" name="pabrikan" required>
            <option value="">-- Pilih Pabrikan --</option>
            @foreach ($pabrikan as $p)
                <option value="{{ $p }}" @selected(old('pabrikan', $obat->pabrikan) == $p)>{{ $p }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn-simpan">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Data' }}</button>
        <a href="{{ route('obat.index') }}" class="btn-batal">Batal</a>
    </form>
@endsection
