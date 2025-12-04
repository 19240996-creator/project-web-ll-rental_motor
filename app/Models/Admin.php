<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin_sewa_motor';
    protected $primaryKey = 'Id_admin_rental_motor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['Id_admin_rental_motor', 'Nama_admin', 'Alamat', 'No_telp'];

    public function transaksi() {
        return $this->hasMany(Transaksi::class, 'Id_admin_rental_motor');
    }
}
