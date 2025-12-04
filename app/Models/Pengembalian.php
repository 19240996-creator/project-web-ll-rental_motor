<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'Id_pengembalian';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['Id_pengembalian', 'Tanggal_pengembalian'];

    public function transaksi() {
        return $this->hasMany(Transaksi::class, 'id_pengembalian');
    }
}
