<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * CustomerDashboardController - Controller untuk halaman customer
 * 
 * Menampilkan dashboard customer dengan daftar motor tersedia
 * dan riwayat transaksi/penyewaan dengan perhitungan denda otomatis
 */
class CustomerDashboardController extends Controller
{
    /**
     * index() - Menampilkan halaman dashboard customer
     * 
     * Menampilkan:
     * - Welcome message
     * - Motor yang tersedia untuk disewa
     * - Link ke booking dan riwayat transaksi
     * 
     * @return \Illuminate\View\View - Halaman customer-dashboard
     */
    public function index()
    {
        // Ambil semua motor yang status-nya "Tersedia" (belum disewa)
        $motors = Motor::where('Status_motor', 'Tersedia')->get();
        
        return view('customer-dashboard', compact('motors'));
    }
    
    /**
     * transactions() - Menampilkan riwayat transaksi customer
     * 
     * Menampilkan:
     * - Semua transaksi milik customer yang login
     * - Untuk setiap transaksi, hitung denda jika terlambat
     * 
     * Logika Denda:
     * - Jika tanggal kembali sebenarnya > tanggal kembali rencana
     * - Denda = (hari terlambat) × (harga motor per hari)
     * 
     * @return \Illuminate\View\View - Halaman customer-transactions
     */
    public function transactions()
    {
        // Ambil ID customer yang sedang login
        $userId = Auth::id();
        
        // Query semua transaksi milik customer ini dengan relasi motor & pengembalian
        $transactions = \App\Models\Transaksi::where('user_id', $userId)
            ->with(['motor', 'pengembalian']) // Eager load untuk performa
            ->orderBy('created_at', 'desc')   // Urutan: transaksi terbaru di atas
            ->get()
            ->map(function($transaksi) {
                // Loop setiap transaksi untuk menghitung denda (jika ada)
                
                // Cek apakah transaksi ini sudah ada data pengembalian (motor sudah dikembalikan)
                if ($transaksi->pengembalian && $transaksi->pengembalian->Tanggal_kembali_sebenarnya) {
                    // Parse tanggal dari string ke object DateTime
                    $actualDate = \Carbon\Carbon::parse($transaksi->pengembalian->Tanggal_kembali_sebenarnya);
                    $plannedDate = \Carbon\Carbon::parse($transaksi->Tanggal_kembali);
                    
                    // Cek apakah pengembali TERLAMBAT (tanggal kembali sebenarnya > rencana)
                    if ($actualDate->greaterThan($plannedDate)) {
                        // Hitung selisih hari terlambat
                        $daysLate = $actualDate->diffInDays($plannedDate);
                        
                        // Ambil harga motor per hari untuk perhitungan denda
                        $dailyRate = $transaksi->motor->Harga ?? 0;
                        
                        // Hitung total denda = jumlah hari terlambat × harga per hari
                        $transaksi->denda = $daysLate * $dailyRate;
                        
                        // Simpan info hari terlambat untuk ditampilkan di view
                        $transaksi->daysLate = $daysLate;
                    } else {
                        // Jika tepat waktu, denda = 0
                        $transaksi->denda = 0;
                    }
                }
                return $transaksi;
            });
        
        return view('customer-transactions', compact('transactions'));
    }
}
