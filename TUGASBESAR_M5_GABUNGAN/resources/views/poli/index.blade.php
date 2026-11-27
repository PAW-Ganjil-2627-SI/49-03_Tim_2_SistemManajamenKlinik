@extends('layouts.app')

@section('title', 'Pengecekan Ruang Poliklinik')

@push('styles')
<style>
    .container { padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background-color: #f2f2f2; }
    .badge { background-color: #e7f3fe; color: #31708f; padding: 5px 10px; border-radius: 5px; font-size: 14px; }
    .btn-edit { background-color: #4CAF50; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
    .btn-delete { background-color: #f44336; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; border: none; cursor: pointer; font-size: inherit; font-family: inherit; }
    .form-hapus { display: inline; padding: 0; margin: 0; border: none; box-shadow: none; background: none; }
</style>
@endpush

@section('content')
    <div class="container">
        <h2>Katalog &amp; Pengecekan Ruang Poliklinik</h2>
        <p>Berikut adalah data master ruangan poli, lokasi gedung, dan inventaris alat medis yang tersedia.</p>
        @if (session('sukses'))
            <p style="color: green; font-weight: bold;">{{ session('sukses') }}</p>
        @endif

        @if (Auth::user()->role === 'admin')
            <a href="{{ route('poli.create') }}" class="btn-edit">+ Tambah Ruang</a>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Kode Ruangan</th>
                    <th>Nama Poli</th>
                    <th>Lokasi Gedung / Lantai</th>
                    <th>Inventaris Alat Medis</th>
                    @if (Auth::user()->role === 'admin')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($polis as $poli)
                    <tr>
                        <td><strong>{{ $poli->kode_ruangan }}</strong></td>
                        <td><span class="badge">{{ $poli->nama_poli }}</span></td>
                        <td>{{ $poli->lokasi_gedung }}</td>
                        <td>{{ $poli->inventaris_alat ?: '-' }}</td>
                        @if (Auth::user()->role === 'admin')
                            <td>
                                <a href="{{ route('poli.edit', $poli) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('poli.destroy', $poli) }}" method="POST" class="form-hapus"
                                      onsubmit="return confirm('Yakin ingin menghapus ruang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                       <td colspan="{{ Auth::user()->role === 'admin' ? 5 : 4 }}"
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
