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
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
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

Route::middleware(['auth'])->group(function () {
    // Admin Dashboard - admin only
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('admin')->name('dashboard');
    
    // Customer Dashboard - customer only
    Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->middleware('customer')->name('customer.dashboard');
    
    // Transaksi - both admin and customer can access (but with different views)
    Route::resource('transaksi', TransaksiController::class);
    
    // Admin only resources
    Route::middleware('admin')->group(function () {
        Route::resource('motor', MotorController::class);
        Route::resource('admin', AdminController::class);
        Route::resource('pengembalian', PengembalianController::class);
    });
    
    // Customer only routes
    Route::middleware('customer')->group(function () {
        Route::get('/customer/transactions', [CustomerDashboardController::class, 'transactions'])->name('customer.transactions');
    });
});

require __DIR__.'/auth.php';

