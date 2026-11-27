@extends('layouts.app')

@section('title', 'Login')

@push('styles')
<style>
    .login-box { max-width: 420px; margin: 0 auto; }
    .login-box input[type="email"],
    .login-box input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 8px 0 20px 0;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-family: inherit;
    }
    .login-box .ingat { font-weight: normal; }
    .btn-login {
        width: 100%;
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }
    .btn-login:hover { background-color: #2980b9; }
</style>
@endpush

@section('content')
    <div class="login-box">
        <h2>Login Petugas Klinik</h2>

        {{-- Pesan sukses (mis. setelah logout) --}}
        @if (session('sukses'))
            <p style="color: green; font-weight: bold;">{{ session('sukses') }}</p>
        @endif

        {{-- Pesan dari middleware: harus login dulu --}}
        @if (session('pesan'))
            <p style="color: #c0392b; font-weight: bold;">{{ session('pesan') }}</p>
        @endif

        {{-- Pesan error validasi / login gagal --}}
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.proses') }}">
            @csrf

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" placeholder="contoh@klinik.com" value="{{ old('email') }}" required autofocus><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required><br>

            <label class="ingat">
                <input type="checkbox" name="remember" value="1"> Ingat saya
            </label>
            <br><br>

            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>
@endsection
