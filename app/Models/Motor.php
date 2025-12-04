<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    protected $table = 'motor';
    protected $primaryKey = 'Id_motor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['Id_motor', 'Warna_motor', 'Merk_motor', 'Harga'];

    public function transaksi() {
        return $this->hasMany(Transaksi::class, 'Id_motor');
    }
}
