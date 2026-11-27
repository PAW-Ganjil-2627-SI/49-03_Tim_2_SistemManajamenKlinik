<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login? Kirim ke halaman login
        if (!Auth::check()) {
            return redirect()->guest(route('login'))
                ->with('pesan', 'Silakan login terlebih dahulu.');
        }

        // Sudah login: lanjutkan ke halaman yang diminta
        return $next($request);
    }
}