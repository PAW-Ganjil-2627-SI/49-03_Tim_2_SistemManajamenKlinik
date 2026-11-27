@extends('layouts.app')

@section('title', 'Data Dokter')

@push('styles')
<style>
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .btn-edit { background-color: #4CAF50; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
    .btn-delete { background-color: #f44336; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; border: none; cursor: pointer; font-size: inherit; font-family: inherit; }
    .form-hapus { display: inline; padding: 0; margin: 0; border: none; box-shadow: none; background: none; }
</style>
@endpush

@section('content')
    <h2>Data Dokter</h2>

    @if (session('sukses'))
        <p style="color: green; font-weight: bold;">{{ session('sukses') }}</p>
    @endif

    @if (Auth::user()->role === 'admin')
        <a href="{{ route('dokters.create') }}" class="btn-edit">+ Tambah Dokter</a>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Dokter</th>
                <th>Spesialisasi</th>
                <th>No. Telepon</th>
                @if (Auth::user()->role === 'admin')
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($dokters as $dokter)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dokter->nama_dokter }}</td>
                    <td>{{ $dokter->spesialisasi }}</td>
                    <td>{{ $dokter->no_telepon }}</td>
                    @if (Auth::user()->role === 'admin')
                        <td>
                            <a href="{{ route('dokters.edit', $dokter) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('dokters.destroy', $dokter) }}" method="POST" class="form-hapus"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ Auth::user()->role === 'admin' ? 5 : 4 }}" style="text-align: center;">Belum ada data dokter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection