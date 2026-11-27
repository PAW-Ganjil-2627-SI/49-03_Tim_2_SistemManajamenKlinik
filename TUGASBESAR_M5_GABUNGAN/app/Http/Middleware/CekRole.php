<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    // $roles berisi peran yang diizinkan, mis. role:admin atau role:admin,petugas
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }

        // Peran pengguna tidak ada di daftar yang diizinkan: tolak
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Anda tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}