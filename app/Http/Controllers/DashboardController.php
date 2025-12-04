<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_motors = Motor::count();
        $motors_available = Motor::where('Status_motor', 'Tersedia')->count();
        $motors_rented = Motor::where('Status_motor', 'Disewa')->count();
        $total_transaksi = Transaksi::count();
        $transaksi_aktif = Transaksi::where('Status_sewa', 'Aktif')->count();
        
        return view('dashboard', compact(
            'total_motors',
            'motors_available', 
            'motors_rented',
            'total_transaksi',
            'transaksi_aktif'
        ));
    }
}
