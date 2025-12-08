<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with('transaksi')->get();
        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        $transaksis = Transaksi::where('Status_sewa', 'Aktif')->get();
        return view('pengembalian.create', compact('transaksis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_pengembalian' => 'required|unique:pengembalian,Id_pengembalian',
            'Id_transaksi' => 'required',
            'Tanggal_pengembalian' => 'required|date',
            'Biaya_keterlambatan' => 'numeric|min:0',
        ]);

        Pengembalian::create($request->all());

        // Update status transaksi menjadi Selesai
        $transaksi = Transaksi::find($request->Id_transaksi);
        $transaksi->update(['Status_sewa' => 'Selesai']);
        
        // Update status motor kembali ke Tersedia
        $motor = $transaksi->motor;
        $motor->update(['Status_motor' => 'Tersedia']);

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil dicatat');
    }

    public function show(Pengembalian $pengembalian)
    {
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $transaksi = Transaksi::find($pengembalian->Id_transaksi);
        $transaksi->update(['Status_sewa' => 'Aktif']);
        
        $pengembalian->delete();

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil dihapus');
    }
}
