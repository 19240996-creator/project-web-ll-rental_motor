<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * User Model - Model untuk tabel 'users'
 * 
 * Extends dari Authenticatable untuk fitur login/autentikasi
 * User bisa berperan sebagai CUSTOMER atau ADMIN
 * Menyimpan: nama, email, password, kontak, identitas, dan role
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom yang boleh di-mass assign (diisi via create/update)
     * @var array<int, string>
     */
    protected $fillable = [
        'name',              // Nama user
        'email',             // Email (unique, untuk login)
        'password',          // Password (di-hash dengan bcrypt)
        'no_telepon',        // Nomor telepon customer
        'alamat',            // Alamat customer
        'no_identitas',      // Nomor KTP/SIM/Paspor
        'tipe_identitas',    // Tipe: KTP, SIM, atau Paspor
        'role',              // Role: customer atau admin
    ];

    /**
     * Kolom yang disembunyikan saat serialize ke JSON
     * Password dan remember_token tidak ditampilkan di response API
     * @var array<int, string>
     */
    protected $hidden = [
        'password',          // Hash password disembunyikan
        'remember_token',    // Token "Remember Me" disembunyikan
    ];

    /**
     * Casting tipe data
     * Mengkonversi string menjadi object DateTime
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Waktu email diverifikasi
    ];

    /**
     * Relationship: transaksi() - Ambil semua transaksi milik user ini
     * Satu customer bisa punya banyak transaksi penyewaan
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
}
