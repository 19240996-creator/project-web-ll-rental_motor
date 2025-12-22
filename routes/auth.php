<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes - Rute Autentikasi
|--------------------------------------------------------------------------
|
| Rute untuk login, register, password reset, dan manajemen akun
| Middleware 'guest' = route hanya bisa akses user yang BELUM login
*/

/**
 * Route Group dengan Middleware 'guest'
 * Semua route di bawah ini HANYA bisa diakses user yang BELUM login
 * Contoh: jika sudah login dan akses /register, akan redirect ke home
 */
Route::middleware('guest')->group(function () {
    
    /**
     * REGISTER - Pendaftaran Akun Baru
     * GET  /register  → Tampilkan form register
     * POST /register  → Simpan data user baru ke database
     */
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    /**
     * ADMIN LOGIN - Form Login Admin
     * GET  /login     → Tampilkan form login admin
     * POST /login     → Verifikasi email & password, buat session login
     */
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    /**
     * CUSTOMER LOGIN - Form Login Customer (Terpisah dari Admin)
     * GET  /login/customer     → Tampilkan form login customer (UI berbeda)
     * POST /login/customer     → Verifikasi email & password, buat session login
     * 
     * Catatan: Keduanya menggunakan controller yang sama,
     * tapi form/view berbeda untuk user experience lebih baik
     */
    Route::get('login/customer', function() {
        return view('auth.customer-login'); // View customer login dengan style berbeda
    })->name('customer.login');

    Route::post('login/customer', [AuthenticatedSessionController::class, 'store'])
                ->name('customer.login.post');

    /**
     * FORGOT PASSWORD - Reset Password
     * GET  /forgot-password → Form input email untuk reset password
     * POST /forgot-password → Kirim email link reset password
     */
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    /**
     * RESET PASSWORD - Form dan Proses Reset
     * GET  /reset-password/{token} → Form input password baru
     * POST /reset-password          → Simpan password baru, update di database
     */
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

/**
 * Route Group dengan Middleware 'auth'
 * Semua route di bawah HANYA bisa diakses user yang SUDAH login
 */
Route::middleware('auth')->group(function () {
    
    /**
     * EMAIL VERIFICATION - Verifikasi Email
     * GET  /verify-email                    → Halaman yang minta verifikasi email
     * GET  /verify-email/{id}/{hash}        → Link verifikasi email (dari email user)
     * POST /email/verification-notification → Kirim ulang email verifikasi
     */
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    /**
     * CONFIRM PASSWORD - Konfirmasi Password (untuk aksi sensitif)
     * GET  /confirm-password → Form input password (untuk verifikasi)
     * POST /confirm-password → Verifikasi password sebelum hapus akun dll
     */
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    /**
     * PROFILE MANAGEMENT - Manajemen Profil User
     * GET   /profile      → Edit form profil (nama, email, telepon, alamat, dll)
     * PATCH /profile      → Update data profil
     * DELETE /profile     → Hapus akun (destructive action)
     */
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * LOGOUT - Keluar dari akun
     * POST /logout → Hapus session login, redirect ke halaman login
     */
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
