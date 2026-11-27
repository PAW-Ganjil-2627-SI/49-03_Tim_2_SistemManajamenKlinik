<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // [READ] Tampilkan halaman form login
    public function showLoginForm()
    {
        // Jika sudah login, tidak perlu melihat form login lagi
        if (Auth::check()) {
            return redirect()->route('beranda');
        }

        return view('auth.login');
    }

    // [PROSES] Cek email & password, lalu buat session login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Auth::attempt() mencocokkan email dan membandingkan password dengan hash di database.
        // Parameter ke-2 = fitur "Ingat saya" (memakai kolom remember_token di tabel users).
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Buat ulang ID session setelah login (mencegah session fixation)
            $request->session()->regenerate();

            // intended() = kembali ke halaman yang tadinya mau dibuka sebelum diarahkan ke login.
            // Jika tidak ada, arahkan ke beranda.
            return redirect()->intended(route('beranda'));
        }

        // Login gagal: kembali ke form, isi ulang email saja (password tidak dikembalikan)
        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    // [PROSES] Hapus session login
    public function logout(Request $request)
    {
        Auth::logout();

        // Matikan session lama dan buat token CSRF baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('sukses', 'Anda berhasil keluar.');
    }
}
