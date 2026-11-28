@extends('layouts.app')

@section('title', 'Katalog Farmasi')

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
    <h2>Katalog Farmasi</h2>
    <p>Master Data Obat, Kategori, Sediaan, dan Pabrikan</p>

    @if (session('sukses'))
        <p style="color: green; font-weight: bold;">{{ session('sukses') }}</p>
    @endif

    @if (Auth::user()->role === 'admin')
        <a href="{{ route('obat.create') }}" class="btn-edit">+ Tambah Obat Baru</a>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Kategori Obat</th>
                <th>Sediaan</th>
                <th>Pabrikan</th>
                @if (Auth::user()->role === 'admin')
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($obat as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_obat }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->sediaan }}</td>
                    <td>{{ $item->pabrikan }}</td>
                    @if (Auth::user()->role === 'admin')
                        <td>
                            <a href="{{ route('obat.edit', $item) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('obat.destroy', $item) }}" method="POST" class="form-hapus"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ Auth::user()->role === 'admin' ? 6 : 5 }}" style="text-align: center;">Belum ada data obat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
