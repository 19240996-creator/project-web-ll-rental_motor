<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Motor;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

/**
 * TransaksiController - Controller untuk mengelola transaksi penyewaan motor
 * 
 * Menangani CRUD (Create, Read, Update, Delete) transaksi dengan logika berbeda
 * untuk admin dan customer, serta perhitungan biaya sewa dan pengelolaan status motor
 */
class TransaksiController extends Controller
{
    /**
     * index() - Menampilkan daftar semua transaksi
     * 
     * - Jika user adalah CUSTOMER: hanya menampilkan transaksi miliknya sendiri
     * - Jika user adalah ADMIN: menampilkan semua transaksi dari semua customer
     * 
     * @return \Illuminate\View\View - View dengan data transaksi yang sudah diurutkan
     */
    public function index()
    {
        // Cek apakah user yang login adalah customer
        if (Auth::user()->role === 'customer') {
            // Ambil transaksi hanya milik customer yang login dengan relasi user, motor, dan admin
            $transaksis = Transaksi::where('user_id', Auth::id())
                ->with('user', 'motor', 'admin')
                ->orderBy('created_at', 'desc') // Urutkan dari transaksi terbaru
                ->get();
            return view('transaksi.customer-index', compact('transaksis'));
        }
        
        // Jika user adalah admin, tampilkan semua transaksi
        $transaksis = Transaksi::with('user', 'motor', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * create() - Menampilkan form untuk membuat transaksi baru
     * 
     * - CUSTOMER: form pemesanan motor (simple, hanya perlu pilih motor & tanggal)
     * - ADMIN: form transaksi lengkap dengan pilihan admin penangani
     * 
     * @param \Illuminate\Http\Request $request - Request yang mungkin berisi motor_id dari query
     * @return \Illuminate\View\View - Form create untuk customer atau admin
     */
    public function create(Request $request)
    {
        // Cek jika user adalah customer
        if (Auth::user()->role === 'customer') {
            // Ambil motor_id dari URL query string (jika ada)
            $motor_id = $request->query('motor_id');
            $motor = null;
            
            // Jika ada motor_id, ambil detail motor yang dipilih
            if ($motor_id) {
                $motor = Motor::where('Id_motor', $motor_id)
                    ->where('Status_motor', 'Tersedia') // Pastikan motor tersedia
                    ->firstOrFail(); // Jika tidak ditemukan, throw error 404
            }
            
            // Ambil semua motor yang status nya "Tersedia" untuk dropdown
            $motors = Motor::where('Status_motor', 'Tersedia')->get();
            
            return view('transaksi.customer-create', compact('motor', 'motors'));
        }
        
        // Jika user adalah admin, tampilkan form admin dengan pilihan motor dan admin
        $motors = Motor::where('Status_motor', 'Tersedia')->get();
        $admins = Admin::all(); // Ambil semua admin untuk di-assign ke transaksi
        return view('transaksi.create', compact('motors', 'admins'));
    }

    /**
     * store() - Menyimpan data transaksi baru ke database
     * 
     * Proses:
     * 1. Validasi input (motor, tanggal, metode pembayaran untuk customer)
     * 2. Hitung total biaya berdasarkan harga motor dan jumlah hari sewa
     * 3. Buat record transaksi baru dengan ID unik
     * 4. Update status motor menjadi "Disewa" agar tidak bisa disewa lagi
     * 5. Redirect dengan pesan sukses
     * 
     * @param \Illuminate\Http\Request $request - Data dari form create
     * @return \Illuminate\Http\RedirectResponse - Redirect ke halaman transaksi
     */
    public function store(Request $request)
    {
        // Aturan validasi dasar untuk semua user
        $rules = [
            'Id_motor' => 'required|exists:motor,Id_motor', // Motor harus ada di database
            'Tanggal_sewa' => 'required|date_format:Y-m-d|after_or_equal:today', // Tanggal minimal hari ini
            'Tanggal_kembali' => 'required|date_format:Y-m-d|after_or_equal:Tanggal_sewa', // Tanggal kembali >= tanggal sewa
        ];
        
        // Jika customer, tambahkan validasi metode pembayaran
        if (Auth::user()->role === 'customer') {
            $rules['metode_pembayaran'] = 'required|in:cash,qr,bank'; // Pilihan pembayaran terbatas
            
            // Validasi bank tujuan jika metode pembayaran adalah bank
            if ($request->metode_pembayaran === 'bank') {
                $rules['bank_tujuan'] = 'required|in:BCA,Mandiri,BRI,BNI,Lainnya';
            }
        }
        
        // Jika admin, harus pilih admin yang menangani transaksi
        if (Auth::user()->role === 'admin') {
            $rules['Id_admin_rental_motor'] = 'required|exists:admin_sewa_motor,Id_admin_rental_motor';
        }
        
        // Jalankan validasi, jika error akan redirect back dengan error message
        $request->validate($rules);

        // Ambil data motor untuk mendapatkan harga sewa per hari
        $motor = Motor::findOrFail($request->Id_motor);
        
        // Cek apakah status motor masih tersedia
        if ($motor->Status_motor !== 'Tersedia') {
            return back()->with('error', 'Motor tidak tersedia untuk disewa');
        }
        
        // Hitung jumlah hari sewa
        $tanggal_sewa = new \DateTime($request->Tanggal_sewa);
        $tanggal_kembali = new \DateTime($request->Tanggal_kembali);
        $hari = $tanggal_kembali->diff($tanggal_sewa)->days + 1; // +1 karena perhitungan inklusif
        
        // Hitung total biaya = harga per hari × jumlah hari
        $total_biaya = $motor->Harga * $hari;

        // Tentukan admin yang menangani (dari request atau admin pertama di database)
        $admin_id = $request->Id_admin_rental_motor ?? Admin::first()->Id_admin_rental_motor;

        // Generate QR code untuk metode pembayaran QR
        $qr_code = null;
        if ($request->metode_pembayaran === 'qr') {
            $qrText = 'https://payment.rental-motor.test?amount=' . $total_biaya . '&ref=TRX-' . Str::random(10);
            $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($qrText);
        }

        // Buat record transaksi baru dengan status "Proses" (menunggu persetujuan admin)
        Transaksi::create([
            'Id_transaksi' => 'TRX-' . Str::random(10), // Generate ID unik
            'user_id' => auth()->id(), // User yang login adalah penyewa
            'Id_motor' => $request->Id_motor,
            'Id_admin_rental_motor' => $admin_id,
            'Tanggal_sewa' => $request->Tanggal_sewa,
            'Tanggal_kembali' => $request->Tanggal_kembali,
            'Status_sewa' => 'Proses', // Status awal: menunggu persetujuan
            'Total_biaya' => $total_biaya,
            'metode_pembayaran' => $request->metode_pembayaran ?? null,
            'bank_tujuan' => $request->bank_tujuan ?? null, // Simpan pilihan bank
            'qr_code' => $qr_code, // Simpan QR code URL
        ]);

        // Update status motor menjadi "Disewa" agar tidak bisa disewa orang lain
        $motor->update(['Status_motor' => 'Disewa']);

        // Tentukan rute redirect berdasarkan role (keduanya ke transaksi.index)
        $redirectRoute = Auth::user()->role === 'customer' ? 'transaksi.index' : 'transaksi.index';
        return redirect()->route($redirectRoute)->with('success', 'Pemesanan berhasil dibuat! Status: Menunggu Persetujuan Admin');
    }

    /**
     * show() - Menampilkan detail satu transaksi
     * 
     * - CUSTOMER: hanya bisa lihat transaksi miliknya sendiri
     * - ADMIN: bisa lihat semua transaksi
     * 
     * @param \App\Models\Transaksi $transaksi - Model transaksi yang di-inject otomatis
     * @return \Illuminate\View\View - Halaman detail transaksi
     * @throws \Illuminate\Http\Exceptions\HttpResponseException - Error 403 jika customer akses transaksi orang lain
     */
    public function show(Transaksi $transaksi)
    {
        // Cek apakah customer mencoba mengakses transaksi orang lain
        if (Auth::user()->role === 'customer' && $transaksi->user_id !== Auth::id()) {
            abort(403); // Forbidden - tolak akses
        }
        
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * edit() - Menampilkan form edit transaksi
     * 
     * HANYA untuk ADMIN - customer tidak bisa edit transaksi
     * Menampilkan dropdown motor dan admin untuk mengubah data transaksi
     * 
     * @param \App\Models\Transaksi $transaksi - Model transaksi yang akan diedit
     * @return \Illuminate\View\View - Form edit transaksi
     * @throws \Illuminate\Http\Exceptions\HttpResponseException - Error 403 jika customer akses
     */
    public function edit(Transaksi $transaksi)
    {
        // Customer tidak diizinkan edit transaksi
        if (Auth::user()->role === 'customer') {
            abort(403); // Forbidden - tolak akses
        }
        
        // Ambil data motor dan admin untuk dropdown di form
        $motors = Motor::all();
        $admins = Admin::all();
        return view('transaksi.edit', compact('transaksi', 'motors', 'admins'));
    }

    /**
     * update() - Mengupdate data transaksi
     * 
     * HANYA untuk ADMIN - perubahan status transaksi
     * Logika khusus:
     * - Jika status diubah ke "Batal" atau "Selesai" → motor kembali ke "Tersedia"
     * 
     * @param \Illuminate\Http\Request $request - Data status baru
     * @param \App\Models\Transaksi $transaksi - Model transaksi yang akan diupdate
     * @return \Illuminate\Http\RedirectResponse - Redirect ke halaman transaksi
     * @throws \Illuminate\Http\Exceptions\HttpResponseException - Error 403 jika customer akses
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        // Customer tidak diizinkan update transaksi
        if (Auth::user()->role === 'customer') {
            abort(403); // Forbidden
        }
        
        // Validasi status harus salah satu dari: Proses, Aktif, Selesai, Batal
        $request->validate([
            'Status_sewa' => 'required|in:Proses,Aktif,Selesai,Batal',
        ]);

        // Jika status diubah ke "Batal" dan belum batal sebelumnya, kembalikan motor ke "Tersedia"
        if ($request->Status_sewa === 'Batal' && $transaksi->Status_sewa !== 'Batal') {
            $motor = Motor::find($transaksi->Id_motor);
            $motor->update(['Status_motor' => 'Tersedia']); // Motor bisa disewa lagi
        }
        
        // Jika status diubah ke "Selesai" dan belum selesai sebelumnya, kembalikan motor ke "Tersedia"
        if ($request->Status_sewa === 'Selesai' && $transaksi->Status_sewa !== 'Selesai') {
            $motor = Motor::find($transaksi->Id_motor);
            $motor->update(['Status_motor' => 'Tersedia']); // Motor bisa disewa lagi
        }

        // Update transaksi dengan semua data dari request
        $transaksi->update($request->all());

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    /**
     * destroy() - Menghapus/membatalkan transaksi
     * 
     * CUSTOMER: hanya bisa membatalkan transaksi dengan status "Proses" miliknya sendiri
     * ADMIN: bisa menghapus transaksi apapun
     * 
     * Ketika dibatalkan, motor otomatis kembali ke status "Tersedia"
     * 
     * @param \App\Models\Transaksi $transaksi - Model transaksi yang akan dihapus
     * @return \Illuminate\Http\RedirectResponse - Redirect ke halaman transaksi
     * @throws \Illuminate\Http\Exceptions\HttpResponseException - Error 403 jika tidak authorized
     */
    public function destroy(Transaksi $transaksi)
    {
        // Cek jika customer mencoba membatalkan transaksi
        if (Auth::user()->role === 'customer') {
            // Customer hanya bisa batalkan transaksi miliknya sendiri
            if ($transaksi->user_id !== Auth::id()) {
                abort(403); // Forbidden
            }
            
            // Customer hanya bisa batalkan yang status "Proses"
            if ($transaksi->Status_sewa !== 'Proses') {
                return back()->with('error', 'Hanya pemesanan dengan status "Proses" yang bisa dibatalkan');
            }
        }
        
        // Cek jika user bukan admin dan bukan customer (role tidak valid)
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'customer') {
            abort(403); // Forbidden
        }
        
        // Ambil motor yang di-sewa untuk dikembalikan statusnya
        $motor = Motor::find($transaksi->Id_motor);
        if ($motor) {
            // Update motor kembali ke status "Tersedia" agar bisa disewa lagi
            $motor->update(['Status_motor' => 'Tersedia']);
        }

        // Hapus transaksi dari database
        $transaksi->delete();

        // Tentukan pesan berdasarkan role user
        $message = Auth::user()->role === 'customer' ? 'Pemesanan berhasil dibatalkan' : 'Transaksi berhasil dihapus';
        return redirect()->route('transaksi.index')->with('success', $message);
    }
}

