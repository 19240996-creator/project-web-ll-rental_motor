<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Transaksi Model - Model untuk tabel 'transaksi'
 * 
 * Merepresentasikan data penyewaan motor
 * Menyimpan informasi: siapa yang sewa, motor apa, berapa hari, berapa biaya, status sewa
 */
class Transaksi extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'transaksi';
    
    // Primary key bukan 'id' tetapi 'Id_transaksi' (string)
    protected $primaryKey = 'Id_transaksi';
    
    // Primary key tidak auto increment
    public $incrementing = false;
    
    // Tipe primary key adalah string, bukan integer
    protected $keyType = 'string';

    // Kolom yang boleh di-mass assign (diisi langsung via create/update)
    protected $fillable = [
        'Id_transaksi',      // ID unik transaksi (format: TRX-XXXXXX)
        'user_id',           // ID customer yang menyewa
        'Id_motor',          // ID motor yang disewa
        'Id_admin_rental_motor', // ID admin yang menangani
        'Tanggal_sewa',      // Tanggal mulai sewa
        'Tanggal_kembali',   // Tanggal target pengembalian
        'Status_sewa',       // Status: Proses, Aktif, Selesai, Batal
        'Total_biaya',       // Total biaya sewa (Rp)
        'metode_pembayaran', // Metode: cash, qr, bank
        'bank_tujuan',       // Pilihan bank tujuan transfer
        'qr_code',           // QR Code untuk pembayaran
        'created_at',        // Waktu buat record
        'updated_at'         // Waktu update terakhir
    ];

    /**
     * Relationship: user() - Ambil data customer yang sewa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: motor() - Ambil data motor yang disewa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function motor()
    {
        return $this->belongsTo(Motor::class, 'Id_motor', 'Id_motor');
    }

    /**
     * Relationship: admin() - Ambil data admin yang menangani sewa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'Id_admin_rental_motor');
    }

    /**
     * Relationship: pengembalian() - Ambil data pengembalian untuk transaksi ini
     * Satu transaksi bisa punya satu record pengembalian
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'Id_transaksi', 'Id_transaksi');
    }
}
