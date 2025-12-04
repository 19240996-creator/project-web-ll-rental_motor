<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Motor;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('user', 'motor', 'admin')->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $motors = Motor::where('Status_motor', 'Tersedia')->get();
        $admins = Admin::all();
        return view('transaksi.create', compact('motors', 'admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_motor' => 'required',
            'Id_admin_rental_motor' => 'required',
            'Tanggal_sewa' => 'required|date',
            'Tanggal_kembali' => 'required|date|after:Tanggal_sewa',
        ]);

        // Hitung total biaya
        $motor = Motor::find($request->Id_motor);
        $tanggal_sewa = new \DateTime($request->Tanggal_sewa);
        $tanggal_kembali = new \DateTime($request->Tanggal_kembali);
        $hari = $tanggal_kembali->diff($tanggal_sewa)->days + 1;
        $total_biaya = $motor->Harga * $hari;

        Transaksi::create([
            'Id_transaksi' => 'TRX-' . Str::random(10),
            'user_id' => auth()->id(),
            'Id_motor' => $request->Id_motor,
            'Id_admin_rental_motor' => $request->Id_admin_rental_motor,
            'Tanggal_sewa' => $request->Tanggal_sewa,
            'Tanggal_kembali' => $request->Tanggal_kembali,
            'Status_sewa' => 'Proses',
            'Total_biaya' => $total_biaya,
        ]);

        // Update status motor
        $motor->update(['Status_motor' => 'Disewa']);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat');
    }

    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $motors = Motor::all();
        $admins = Admin::all();
        return view('transaksi.edit', compact('transaksi', 'motors', 'admins'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'Status_sewa' => 'required|in:Proses,Aktif,Selesai,Batal',
        ]);

        $transaksi->update($request->all());

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy(Transaksi $transaksi)
    {
        // Update status motor kembali ke tersedia
        $motor = Motor::find($transaksi->Id_motor);
        $motor->update(['Status_motor' => 'Tersedia']);

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
