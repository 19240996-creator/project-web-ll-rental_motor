<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengembalian extends Model
{
    use HasFactory;
    
    protected $table = 'pengembalian';
    protected $primaryKey = 'Id_pengembalian';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Id_pengembalian',
        'Id_transaksi',
        'Tanggal_pengembalian',
        'Tanggal_kembali_sebenarnya',
        'Biaya_keterlambatan',
        'Status_pengembalian',
        'Catatan'
    ];

    protected $casts = [
        'Tanggal_pengembalian' => 'date',
        'Tanggal_kembali_sebenarnya' => 'date',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'Id_transaksi', 'Id_transaksi');
    }
    
    /**
     * Calculate denda based on late return
     */
    public function calculateDenda()
    {
        if (!$this->Tanggal_kembali_sebenarnya || !$this->transaksi) {
            return 0;
        }
        
        $plannedDate = Carbon::parse($this->transaksi->Tanggal_kembali);
        $actualDate = Carbon::parse($this->Tanggal_kembali_sebenarnya);
        
        if ($actualDate->greaterThan($plannedDate)) {
            $daysLate = $actualDate->diffInDays($plannedDate);
            // Assuming motor has daily rate - adjust based on your schema
            $dailyRate = $this->transaksi->motor->Harga_sewa ?? 0;
            return $daysLate * $dailyRate;
        }
        
        return 0;
    }
    
    /**
     * Get formatted denda
     */
    public function getDendaAttribute()
    {
        if ($this->Biaya_keterlambatan) {
            return $this->Biaya_keterlambatan;
        }
        return $this->calculateDenda();
    }
}

