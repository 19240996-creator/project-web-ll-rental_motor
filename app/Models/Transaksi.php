<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'Id_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Id_transaksi',
        'user_id',
        'Id_motor',
        'Id_admin_rental_motor',
        'Tanggal_sewa',
        'Tanggal_kembali',
        'Status_sewa',
        'Total_biaya',
        'metode_pembayaran',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function motor()
    {
        return $this->belongsTo(Motor::class, 'Id_motor', 'Id_motor');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'Id_admin_rental_motor');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'Id_transaksi', 'Id_transaksi');
    }
}
