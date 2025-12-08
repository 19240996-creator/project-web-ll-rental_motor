<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $motors = Motor::where('Status_motor', 'Tersedia')->get();
        
        return view('customer-dashboard', compact('motors'));
    }
    
    public function transactions()
    {
        $userId = Auth::id();
        
        // Get customer's transaksi history dengan relationship ke pengembalian
        $transactions = \App\Models\Transaksi::where('user_id', $userId)
            ->with(['motor', 'pengembalian'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($transaksi) {
                // Calculate denda if pengembalian exists dan terlambat
                if ($transaksi->pengembalian && $transaksi->pengembalian->Tanggal_kembali_sebenarnya) {
                    $actualDate = \Carbon\Carbon::parse($transaksi->pengembalian->Tanggal_kembali_sebenarnya);
                    $plannedDate = \Carbon\Carbon::parse($transaksi->Tanggal_kembali);
                    
                    if ($actualDate->greaterThan($plannedDate)) {
                        $daysLate = $actualDate->diffInDays($plannedDate);
                        $dailyRate = $transaksi->motor->Harga ?? 0;
                        $transaksi->denda = $daysLate * $dailyRate;
                        $transaksi->daysLate = $daysLate;
                    } else {
                        $transaksi->denda = 0;
                    }
                }
                return $transaksi;
            });
        
        return view('customer-transactions', compact('transactions'));
    }
}
