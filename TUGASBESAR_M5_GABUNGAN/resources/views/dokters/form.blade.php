@extends('layouts.app')

@section('title', isset($dokter) ? 'Edit Dokter' : 'Tambah Dokter')

@section('content')
    <h2>{{ isset($dokter) ? 'Form Edit Data Dokter' : 'Formulir Tambah Data Dokter' }}</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ isset($dokter) ? route('dokters.update', $dokter) : route('dokters.store') }}">
        @csrf
        @if (isset($dokter))
            @method('PUT')
        @endif

        <label for="nama_dokter">Nama Dokter:</label><br>
        <input type="text" id="nama_dokter" name="nama_dokter" value="{{ old('nama_dokter', $dokter->nama_dokter ?? '') }}" required><br><br>

        <label for="spesialisasi">Spesialisasi:</label><br>
        <input type="text" id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi', $dokter->spesialisasi ?? '') }}" required><br><br>

        <label for="no_telepon">No. Telepon:</label><br>
        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $dokter->no_telepon ?? '') }}"><br><br>

        <input type="submit" value="{{ isset($dokter) ? 'Update Data' : 'Simpan Data' }}">
        <a href="{{ route('dokters.index') }}"><button type="button">Batal</button></a>
    </form>
@endsection