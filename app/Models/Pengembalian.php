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

    /**
     * Check if return is late and auto-update status
     */
    public function checkAndUpdateLateness()
    {
        if (!$this->Tanggal_kembali_sebenarnya || !$this->transaksi) {
            return false;
        }

        $plannedDate = Carbon::parse($this->transaksi->Tanggal_kembali);
        $actualDate = Carbon::parse($this->Tanggal_kembali_sebenarnya);

        $isLate = $actualDate->greaterThan($plannedDate);

        if ($isLate) {
            // Calculate and save denda otomatis jika belum ada
            if (!$this->Biaya_keterlambatan || $this->Biaya_keterlambatan == 0) {
                $daysLate = $actualDate->diffInDays($plannedDate);
                $dailyRate = $this->transaksi->motor->Harga ?? 0;
                $this->Biaya_keterlambatan = $daysLate * $dailyRate;
            }

            // Update status ke terlambat
            $this->Status_pengembalian = 'Dikembalikan_Terlambat';
            $this->save();

            return true;
        } else {
            // Jika tepat waktu, set status dikembalikan
            if ($this->Status_pengembalian !== 'Dikembalikan') {
                $this->Status_pengembalian = 'Dikembalikan';
                $this->save();
            }
        }

        return false;
    }

    /**
     * Get status badge color
     */
    public function getStatusColor()
    {
        return match($this->Status_pengembalian) {
            'Dikembalikan_Terlambat' => 'danger',
            'Dikembalikan' => 'success',
            'Diproses' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Get status badge text
     */
    public function getStatusText()
    {
        return match($this->Status_pengembalian) {
            'Dikembalikan_Terlambat' => 'Terlambat',
            'Dikembalikan' => 'Dikembalikan',
            'Diproses' => 'Diproses',
            default => $this->Status_pengembalian
        };
    }
}

