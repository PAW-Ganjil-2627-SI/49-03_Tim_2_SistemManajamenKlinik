<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PoliController;
use Illuminate\Support\Facades\Route;

// ---------- Autentikasi ----------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- Halaman aplikasi (wajib login) ----------
Route::middleware('cek.login')->group(function () {

    Route::view('/', 'beranda')->name('beranda');

    // Data Dokter: semua pengguna yang login boleh MELIHAT
    Route::resource('dokters', DokterController::class)->only('index');

    // Hanya admin: tambah / ubah / hapus
    Route::middleware('role:admin')->group(function () {
        Route::resource('pasien', PasienController::class)->except(['create', 'show']);
        Route::resource('dokters', DokterController::class)->except(['index', 'show']);
    });

    // Ruang Poliklinik (menampilkan data)
    Route::get('/poli-klinik', [PoliController::class, 'index'])->name('poli.index');
});