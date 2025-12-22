<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * IsCustomer Middleware - Middleware untuk proteksi akses customer-only routes
 * 
 * Fungsi:
 * - Memverifikasi bahwa user yang login adalah CUSTOMER
 * - Jika bukan customer atau belum login, redirect ke home dengan error message
 * - Digunakan untuk melindungi rute yang hanya boleh diakses customer
 * 
 * Contoh penggunaan di route:
 * Route::middleware('customer')->group(function () {
 *     Route::get('/customer/dashboard', ...);
 * });
 */
class IsCustomer
{
    /**
     * Handle middleware - Cek apakah user adalah customer
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response - Response object
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek: apakah user sudah login dan role-nya adalah 'customer'
        if (auth()->check() && auth()->user()->role === 'customer') {
            // Jika ya, lanjutkan request ke route berikutnya
            return $next($request);
        }

        // Jika tidak, redirect ke home dengan error message
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
}
