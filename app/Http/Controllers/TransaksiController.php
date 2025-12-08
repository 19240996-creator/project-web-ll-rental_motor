<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Motor;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        // Jika customer, hanya lihat transaksi mereka sendiri
        if (Auth::user()->role === 'customer') {
            $transaksis = Transaksi::where('user_id', Auth::id())
                ->with('user', 'motor', 'admin')
                ->orderBy('created_at', 'desc')
                ->get();
            return view('transaksi.customer-index', compact('transaksis'));
        }
        
        // Admin lihat semua transaksi
        $transaksis = Transaksi::with('user', 'motor', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create(Request $request)
    {
        // Jika customer, tampilkan form booking sederhana
        if (Auth::user()->role === 'customer') {
            $motor_id = $request->query('motor_id');
            $motor = null;
            
            if ($motor_id) {
                $motor = Motor::where('Id_motor', $motor_id)
                    ->where('Status_motor', 'Tersedia')
                    ->firstOrFail();
            }
            
            return view('transaksi.customer-create', compact('motor'));
        }
        
        // Admin form
        $motors = Motor::where('Status_motor', 'Tersedia')->get();
        $admins = Admin::all();
        return view('transaksi.create', compact('motors', 'admins'));
    }

    public function store(Request $request)
    {
        // Validasi
        $rules = [
            'Id_motor' => 'required|exists:motor,Id_motor',
            'Tanggal_sewa' => 'required|date_format:Y-m-d|after_or_equal:today',
            'Tanggal_kembali' => 'required|date_format:Y-m-d|after_or_equal:Tanggal_sewa',
        ];
        
        // Jika admin, butuh Id_admin_rental_motor
        if (Auth::user()->role === 'admin') {
            $rules['Id_admin_rental_motor'] = 'required|exists:admin_sewa_motor,Id_admin_rental_motor';
        }
        
        $request->validate($rules);

        // Hitung total biaya
        $motor = Motor::findOrFail($request->Id_motor);
        
        // Cek motor tersedia
        if ($motor->Status_motor !== 'Tersedia') {
            return back()->with('error', 'Motor tidak tersedia untuk disewa');
        }
        
        $tanggal_sewa = new \DateTime($request->Tanggal_sewa);
        $tanggal_kembali = new \DateTime($request->Tanggal_kembali);
        $hari = $tanggal_kembali->diff($tanggal_sewa)->days + 1;
        $total_biaya = $motor->Harga * $hari;

        // Get admin otomatis atau dari request
        $admin_id = $request->Id_admin_rental_motor ?? Admin::first()->Id_admin_rental_motor;

        Transaksi::create([
            'Id_transaksi' => 'TRX-' . Str::random(10),
            'user_id' => auth()->id(),
            'Id_motor' => $request->Id_motor,
            'Id_admin_rental_motor' => $admin_id,
            'Tanggal_sewa' => $request->Tanggal_sewa,
            'Tanggal_kembali' => $request->Tanggal_kembali,
            'Status_sewa' => 'Proses',
            'Total_biaya' => $total_biaya,
        ]);

        // Update status motor
        $motor->update(['Status_motor' => 'Disewa']);

        $redirectRoute = Auth::user()->role === 'customer' ? 'transaksi.index' : 'transaksi.index';
        return redirect()->route($redirectRoute)->with('success', 'Pemesanan berhasil dibuat! Status: Menunggu Persetujuan Admin');
    }

    public function show(Transaksi $transaksi)
    {
        // Customer hanya bisa lihat transaksi mereka sendiri
        if (Auth::user()->role === 'customer' && $transaksi->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        // Customer tidak bisa edit
        if (Auth::user()->role === 'customer') {
            abort(403);
        }
        
        $motors = Motor::all();
        $admins = Admin::all();
        return view('transaksi.edit', compact('transaksi', 'motors', 'admins'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        // Customer tidak bisa update
        if (Auth::user()->role === 'customer') {
            abort(403);
        }
        
        $request->validate([
            'Status_sewa' => 'required|in:Proses,Aktif,Selesai,Batal',
        ]);

        // Jika status diubah ke Batal, kembalikan motor ke Tersedia
        if ($request->Status_sewa === 'Batal' && $transaksi->Status_sewa !== 'Batal') {
            $motor = Motor::find($transaksi->Id_motor);
            $motor->update(['Status_motor' => 'Tersedia']);
        }
        
        // Jika status diubah ke Selesai, kembalikan motor ke Tersedia
        if ($request->Status_sewa === 'Selesai' && $transaksi->Status_sewa !== 'Selesai') {
            $motor = Motor::find($transaksi->Id_motor);
            $motor->update(['Status_motor' => 'Tersedia']);
        }

        $transaksi->update($request->all());

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaksi $transaksi)
    {
        // Customer hanya bisa cancel jika status Proses dan transaksi mereka
        if (Auth::user()->role === 'customer') {
            if ($transaksi->user_id !== Auth::id()) {
                abort(403);
            }
            if ($transaksi->Status_sewa !== 'Proses') {
                return back()->with('error', 'Hanya pemesanan dengan status "Proses" yang bisa dibatalkan');
            }
        }
        
        // Admin bisa delete transaksi apapun
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'customer') {
            abort(403);
        }
        
        // Update status motor kembali ke tersedia
        $motor = Motor::find($transaksi->Id_motor);
        if ($motor) {
            $motor->update(['Status_motor' => 'Tersedia']);
        }

        $transaksi->delete();

        $message = Auth::user()->role === 'customer' ? 'Pemesanan berhasil dibatalkan' : 'Transaksi berhasil dihapus';
        return redirect()->route('transaksi.index')->with('success', $message);
    }
}

