<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $motors = Motor::where('Status_motor', 'Tersedia')->get();
        
        return view('customer-dashboard', compact('motors'));
    }
}
