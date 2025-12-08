<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;
    
    protected $table = 'motor';
    protected $primaryKey = 'Id_motor';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Id_motor',
        'Warna_motor',
        'Merk_motor',
        'Nama_motor',
        'Harga',
        'Status_motor'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'Id_motor', 'Id_motor');
    }
    
    /**
     * Accessor untuk kompatibilitas dengan Harga_sewa
     */
    public function getHargaSewaAttribute()
    {
        return $this->Harga;
    }
}

