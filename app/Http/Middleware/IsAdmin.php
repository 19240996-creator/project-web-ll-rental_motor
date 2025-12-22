<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * IsAdmin Middleware - Middleware untuk proteksi akses admin-only routes
 * 
 * Fungsi:
 * - Memverifikasi bahwa user yang login adalah ADMIN
 * - Jika bukan admin atau belum login, redirect ke home dengan error message
 * - Digunakan untuk melindungi rute yang hanya boleh diakses admin
 * 
 * Contoh penggunaan di route:
 * Route::middleware('admin')->group(function () {
 *     Route::resource('motor', MotorController::class);
 *     Route::resource('admin', AdminController::class);
 * });
 */
class IsAdmin
{
    /**
     * Handle middleware - Cek apakah user adalah admin
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response - Response object
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek: apakah user sudah login dan role-nya adalah 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Jika ya, lanjutkan request ke route berikutnya
            return $next($request);
        }

        // Jika tidak, redirect ke home dengan error message
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
}
