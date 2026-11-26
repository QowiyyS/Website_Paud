<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = auth()->user();

        // Jika tidak ada peran spesifik yang ditentukan atau peran pengguna cocok
        if (empty($roles) || in_array($user->peran, $roles)) {
            return $next($request);
        }

        // Jika peran tidak cocok (misal: Wali Murid mencoba buka /admin)
        abort(403, 'Akses Ditolak: Halaman ini hanya untuk ' . implode(' / ', array_map('ucfirst', $roles)) . '. Akun Anda (' . ucfirst($user->peran) . ') tidak memiliki izin untuk membuka halaman ini.');
    }
}
