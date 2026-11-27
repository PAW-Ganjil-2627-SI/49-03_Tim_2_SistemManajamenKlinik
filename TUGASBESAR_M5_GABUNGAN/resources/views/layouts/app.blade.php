<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Klinik Rawat Jalan</title>
    <!-- File CSS dan gambar diletakkan di folder public/ -->
    <link rel="stylesheet" href="{{ asset('css/cssRS.css') }}">
    @stack('styles')
</head>
<body>

    <!-- Bagian Header -->
    <div class="header">
        <h1>
            <img src="{{ asset('gambar/rumahSakit.jpeg') }}" alt="Logo" height="60px" align="middle" class="logo">
            Sistem Informasi Klinik Rawat Jalan
        </h1>
    </div>

    <!-- Bagian Navigasi -->
    <div class="nav">
        <ul>
            <li><a href="{{ route('beranda') }}">Beranda</a></li>
            <li><a href="{{ route('pasien.index') }}">Manajemen Pasien</a></li>
            <li><a href="{{ route('dokters.index') }}">Data Dokter</a></li>
            <li><a href="{{ asset('farmasi.html') }}">Katalog Farmasi</a></li>
            <li><a href="{{ route('poli.index') }}">Ruang Poliklinik</a></li>

            {{-- Sisi kanan navigasi: status login --}}
            @auth
                <li class="nav-kanan">
                    <span>Halo, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="form-logout">
                        @csrf
                        <button type="submit">Keluar</button>
                    </form>
                </li>
            @else
                <li class="nav-kanan"><a href="{{ route('login') }}">Masuk</a></li>
            @endauth
        </ul>
    </div>

    @yield('content')

</body>
</html>
