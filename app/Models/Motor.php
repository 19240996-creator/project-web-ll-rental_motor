<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Motor Model - Model untuk tabel 'motor'
 * 
 * Merepresentasikan data motor yang tersedia untuk disewa
 * Menyimpan: merk, warna, nama, harga per hari, dan status ketersediaan
 */
class Motor extends Model
{
    use HasFactory;
    
    // Nama tabel di database
    protected $table = 'motor';
    
    // Primary key adalah 'Id_motor' (string, bukan 'id')
    protected $primaryKey = 'Id_motor';
    
    // Primary key tidak auto increment
    public $incrementing = false;
    
    // Tipe primary key adalah string
    protected $keyType = 'string';

    // Kolom yang boleh di-mass assign
    protected $fillable = [
        'Id_motor',        // ID unik motor (string)
        'Warna_motor',     // Warna motor
        'Merk_motor',      // Merk motor (Honda, Yamaha, Suzuki, dll)
        'Nama_motor',      // Nama tipe motor (Beat, Vario, Jupiter, dll)
        'Harga',           // Harga sewa per hari (Rp)
        'Plat_nomor',      // Nomor plat motor
        'Tahun_motor',     // Tahun produksi motor
        'Status_motor'     // Status: Tersedia, Disewa, Rusak, Maintenance
    ];

    /**
     * Relationship: transaksi() - Ambil semua transaksi untuk motor ini
     * Satu motor bisa punya banyak transaksi penyewaan
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'Id_motor', 'Id_motor');
    }
    
    /**
     * Accessor: getHargaSewaAttribute() - Alternatif nama untuk kolom Harga
     * Memungkinkan akses via $motor->Harga_sewa (tapi simpan di kolom Harga)
     * Kompatibilitas dengan kode lama yang menggunakan Harga_sewa
     * 
     * @return mixed - Nilai kolom Harga
     */
    public function getHargaSewaAttribute()
    {
        return $this->Harga;
    }
}

