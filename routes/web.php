<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PengembalianController;

/*
|--------------------------------------------------------------------------
| Web Routes - Route Aplikasi Rental Motor
|--------------------------------------------------------------------------
|
| Rute-rute untuk aplikasi web rental motor dengan sistem role-based access
| - CUSTOMER: Bisa browse motor, pesan sewa, lihat riwayat transaksi
| - ADMIN: Bisa manage motor, transaksi, pengembalian
|
*/

/**
 * Route GET / - Halaman beranda
 * 
 * Logic:
 * - Jika user sudah login & role ADMIN → redirect ke dashboard admin
 * - Jika user sudah login & role CUSTOMER → redirect ke dashboard customer
 * - Jika belum login → tampilkan halaman welcome (public)
 */
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }
    return view('welcome');
})->name('home');

/**
 * Route Group dengan Middleware 'auth'
 * Semua route di dalam grup ini HANYA bisa diakses user yang sudah login
 */
Route::middleware(['auth'])->group(function () {
    
    /**
     * ADMIN DASHBOARD
     * Route: GET /dashboard
     * Hanya admin yang bisa akses (middleware 'admin')
     * Menampilkan statistik dan overview admin
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('admin')
        ->name('dashboard');
    
    /**
     * CUSTOMER DASHBOARD
     * Route: GET /customer/dashboard
     * Hanya customer yang bisa akses (middleware 'customer')
     * Menampilkan motor tersedia dan info penyewaan
     */
    Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])
        ->middleware('customer')
        ->name('customer.dashboard');
    
    /**
     * TRANSAKSI RESOURCE
     * CRUD untuk transaksi (bisa diakses admin & customer dengan kontrol berbeda di controller)
     * 
     * Routes yang dibuat:
     * - GET    /transaksi           → index (list semua/milik saya)
     * - GET    /transaksi/create    → create (form booking)
     * - POST   /transaksi           → store (simpan transaksi baru)
     * - GET    /transaksi/{id}      → show (detail transaksi)
     * - GET    /transaksi/{id}/edit → edit (form edit - admin only)
     * - PUT    /transaksi/{id}      → update (update transaksi - admin only)
     * - DELETE /transaksi/{id}      → destroy (hapus/batalkan transaksi)
     */
    Route::resource('transaksi', TransaksiController::class);
    
    /**
     * ADMIN ONLY RESOURCES
     * Rute yang hanya bisa diakses admin (terlindungi middleware 'admin')
     */
    Route::middleware('admin')->group(function () {
        
        /**
         * MOTOR RESOURCE (Admin Only)
         * CRUD untuk mengelola motor: tambah, edit, hapus
         */
        Route::resource('motor', MotorController::class);
        
        /**
         * ADMIN RESOURCE (Admin Only)
         * CRUD untuk mengelola admin user: tambah, edit, hapus
         */
        Route::resource('admin', AdminController::class);
        
        /**
         * PENGEMBALIAN RESOURCE (Admin Only)
         * Untuk mencatat pengembalian motor dan menghitung denda
         */
        Route::resource('pengembalian', PengembalianController::class);
    });
    
    /**
     * CUSTOMER ONLY ROUTES
     * Rute yang hanya bisa diakses customer (terlindungi middleware 'customer')
     */
    Route::middleware('customer')->group(function () {
        
        /**
         * CUSTOMER TRANSACTIONS (Customer Only)
         * Route: GET /customer/transactions
         * Menampilkan riwayat transaksi customer
         */
        Route::get('/customer/transactions', [CustomerDashboardController::class, 'transactions'])
            ->name('customer.transactions');
    });
});

/**
 * ROUTE AUTHENTICATION
 * Import dari routes/auth.php
 * Berisi route login, register, password reset, logout, dll
 */
require __DIR__.'/auth.php';

