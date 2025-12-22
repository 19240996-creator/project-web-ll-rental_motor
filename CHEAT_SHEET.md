# 🚀 CHEAT SHEET - PENJELASAN CEPAT

File ini untuk mempercepat penjelasan saat ada pertanyaan mendadak.

---

## ⚡ 1-MINUTE EXPLANATIONS

### Authentication & Authorization
```
🔐 LOGIN SYSTEM
└─ Customer/Admin input email & password
└─ Sistem cek di database
└─ Jika benar → buat session login
└─ Redirect ke dashboard masing-masing

🛡️ PROTEKSI ROUTES
└─ Middleware 'auth' = harus login dulu
└─ Middleware 'admin' = harus login + role admin
└─ Middleware 'customer' = harus login + role customer
```

### Database Structure
```
📦 TABEL UTAMA
├─ users → nama, email, password, role
├─ motor → merk, warna, harga, status
└─ transaksi → user_id, motor_id, tanggal, status

🔗 RELATIONSHIP (Foreign Key)
├─ User → banyak Transaksi
├─ Motor → banyak Transaksi
└─ Transaksi → satu Pengembalian
```

### Status Motor
```
🏍️ SIKLUS STATUS MOTOR
Tersedia (awal)
    ↓ (customer booking)
Disewa (sedang disewa)
    ↓ (motor dikembalikan)
Tersedia (kembali bisa disewa)
    ↓ (atau maintenance)
Rusak/Maintenance
    ↓ (selesai perbaikan)
Tersedia
```

### Status Transaksi
```
📝 SIKLUS STATUS TRANSAKSI
Proses (tunggu approval)
    ↓ (admin approve)
Aktif (sedang disewa)
    ↓ (motor dikembalikan)
Selesai (transaksi selesai)
    ↓ (atau customer batalkan)
Batal (transaksi dibatalkan)
```

---

## 🎯 KEY FEATURES EXPLANATION

### 1. BOOKING MOTOR
```
Customer pilih motor → Isi tanggal sewa/kembali → Pilih pembayaran
→ Submit → Sistem hitung biaya → Simpan transaksi (status Proses)
→ Update motor status jadi Disewa → Success!
```

**Rumus Biaya:**
```
Total = Harga_motor/hari × (Tanggal_Kembali - Tanggal_Sewa + 1)

Contoh:
Motor Beat Rp 50.000/hari, sewa 22-25 Desember
= 50.000 × (25-22+1) = 50.000 × 4 = Rp 200.000
```

### 2. ADMIN APPROVE BOOKING
```
Admin lihat list transaksi → Cari yang status "Proses"
→ Klik edit → Ubah status jadi "Aktif" → Update
→ Customer bisa ambil motornya
```

### 3. RETURN MOTOR
```
Customer bawa motor ke tempat rental → Serah ke admin
→ Admin buka halaman Pengembalian → Masukkan tanggal kembali sebenarnya
→ Sistem hitung denda (jika terlambat) → Update status transaksi jadi "Selesai"
→ Update motor status jadi "Tersedia"
```

**Rumus Denda:**
```
Denda = (Hari Terlambat) × (Harga Motor/hari)

Contoh:
Seharusnya kembali 25 Desember, ternyata 27 Desember
= (27-25) × 50.000 = 2 × 50.000 = Rp 100.000
```

### 4. CANCEL BOOKING
```
CUSTOMER ONLY:
- Customer buka transaksi status "Proses"
- Klik tombol "Batalkan"
- Transaksi berubah status jadi "Batal"
- Motor status kembali jadi "Tersedia"

ADMIN:
- Admin bisa delete transaksi apapun
- Motor otomatis kembali "Tersedia"
```

---

## 🔑 CRITICAL CODE CONCEPTS

### Protecting Routes
```php
// HANYA ADMIN bisa akses
Route::middleware('admin')->group(function () {
    Route::resource('motor', MotorController::class);
});

// HANYA CUSTOMER bisa akses
Route::middleware('customer')->group(function () {
    Route::get('/customer/dashboard', ...);
});

// HANYA LOGIN bisa akses
Route::middleware('auth')->group(function () {
    // routes di sini
});
```

### Checking User Role
```php
// Di controller atau view
if (auth()->user()->role === 'admin') {
    // admin actions
}

if (auth()->user()->role === 'customer') {
    // customer actions
}

if (auth()->check()) {
    // user sudah login
}
```

### Query Contoh
```php
// Ambil motor tersedia
$motors = Motor::where('Status_motor', 'Tersedia')->get();

// Ambil transaksi user
$transaksi = Transaksi::where('user_id', Auth::id())->get();

// Ambil dengan relasi
$transaksi = Transaksi::with(['motor', 'user'])->get();

// Urutkan
$transaksi = Transaksi::orderBy('created_at', 'desc')->get();
```

---

## 🎤 QUICK ANSWERS

### "Gimana caranya user tidak bisa akses halaman admin?"
→ **Middleware 'admin'** di route akan cek role. Jika bukan admin → reject

### "Gimana motor tidak kebooking 2 orang bersamaan?"
→ **Update status motor ke 'Disewa'** saat booking. Jadi motor hilang dari list tersedia.

### "Gimana denda dihitung otomatis?"
→ Saat return motor, **sistem compare tanggal kembali plan vs actual**. Jika terlambat → hitung denda

### "Kenapa ada 2 form login (admin vs customer)?"
→ **UX lebih baik** - design form bisa sesuai kebutuhan masing-masing role

### "Apakah customer bisa edit transaksi orang lain?"
→ **Tidak** - controller check `if ($transaksi->user_id !== Auth::id()) abort(403)`

### "Bagaimana jika customer cancel booking?"
→ Status transaksi → "Batal", Motor status → "Tersedia" lagi

### "Data apa yang disimpan di session login?"
→ User ID, name, email, role, dan semua field di table users

### "Apakah password di-encrypt?"
→ **Ya, di-hash dengan bcrypt**. Password original tidak tersimpan di database

---

## 📊 TABLE CHEAT SHEET

### USERS TABLE
```
id          | INT (auto increment)
name        | VARCHAR(255) - nama user
email       | VARCHAR(255) - email unik
password    | VARCHAR(255) - hashed password
role        | ENUM('admin', 'customer')
no_telepon  | VARCHAR(20)
alamat      | TEXT
no_identitas| VARCHAR(20) - KTP/SIM/Paspor
tipe_identitas| ENUM('KTP','SIM','Paspor')
created_at  | TIMESTAMP
updated_at  | TIMESTAMP
```

### MOTOR TABLE
```
Id_motor       | VARCHAR(20) - primary key
Merk_motor     | VARCHAR(50) - Honda, Yamaha, dll
Nama_motor     | VARCHAR(50) - Beat, Vario, dll
Warna_motor    | VARCHAR(50)
Harga          | INT - harga per hari
Status_motor   | ENUM('Tersedia','Disewa','Rusak','Maintenance')
created_at     | TIMESTAMP
updated_at     | TIMESTAMP
```

### TRANSAKSI TABLE
```
Id_transaksi               | VARCHAR(20) - primary key, format TRX-XXXXX
user_id                    | INT - foreign key ke users
Id_motor                   | VARCHAR(20) - foreign key ke motor
Id_admin_rental_motor      | VARCHAR(20) - foreign key ke admin
Tanggal_sewa               | DATE
Tanggal_kembali            | DATE (rencana)
Status_sewa                | ENUM('Proses','Aktif','Selesai','Batal')
Total_biaya                | INT
metode_pembayaran          | ENUM('cash','qr','bank')
created_at                 | TIMESTAMP
updated_at                 | TIMESTAMP
```

### PENGEMBALIAN TABLE
```
Id_pengembalian                | INT
Id_transaksi                   | VARCHAR(20)
Tanggal_kembali_sebenarnya     | DATE - tanggal kembali actual
Kondisi_motor                  | VARCHAR(50) - rusak atau normal
Denda                          | INT (dihitung otomatis dari daysLate)
created_at                     | TIMESTAMP
updated_at                     | TIMESTAMP
```

---

## 🧮 CALCULATION CHEAT SHEET

### BIAYA SEWA
```
Total Biaya = Harga_motor × Jumlah_Hari

Jumlah_Hari = (Tanggal_Kembali - Tanggal_Sewa) + 1

Contoh:
- Harga: Rp 50.000/hari
- Sewa: 22 Desember
- Kembali: 25 Desember
- Jumlah hari: (25-22) + 1 = 4 hari
- Biaya: 50.000 × 4 = Rp 200.000
```

### DENDA KETERLAMBATAN
```
Denda = Hari_Terlambat × Harga_motor

Hari_Terlambat = Tanggal_Kembali_Actual - Tanggal_Kembali_Plan

Contoh:
- Plan: 25 Desember
- Actual: 27 Desember
- Terlambat: 27-25 = 2 hari
- Denda: 2 × 50.000 = Rp 100.000
```

---

## 🎯 METHOD QUICK REFERENCE

```
TransaksiController:
├─ index()     = List semua transaksi (atau milik customer)
├─ create()    = Form booking/input transaksi
├─ store()     = Simpan transaksi baru + hitung biaya
├─ show()      = Lihat detail 1 transaksi
├─ edit()      = Edit form (admin only)
├─ update()    = Update status transaksi
└─ destroy()   = Batalkan/hapus transaksi

CustomerDashboardController:
├─ index()     = Dashboard + motor tersedia
└─ transactions() = Riwayat transaksi + hitung denda

MotorController:
├─ index()     = List semua motor
├─ create()    = Form tambah motor
├─ store()     = Simpan motor baru
├─ show()      = Detail motor
├─ edit()      = Edit form
├─ update()    = Update motor
└─ destroy()   = Hapus motor
```

---

## 🚨 COMMON ERRORS & SOLUTIONS

```
❌ "Anda tidak memiliki akses ke halaman ini"
✅ Solusi: Cek role user. Akses route yang tidak sesuai.

❌ "Motor tidak tersedia untuk disewa"
✅ Solusi: Motor sudah punya status 'Disewa'. Pilih motor lain.

❌ "404 Not Found"
✅ Solusi: Route tidak ada atau typo di URL.

❌ "SQLSTATE Validation Exception"
✅ Solusi: Input tidak sesuai validasi. Check form input.

❌ "Undefined variable"
✅ Solusi: Controller lupa pass variable ke view. Check compact().

❌ "Unauthorized (403)"
✅ Solusi: Middleware block akses. Cek role atau middleware.
```

---

## 📝 UNTUK JAWAB PERTANYAAN CEPAT

**Q: Apa itu middleware?**
A: Middleware adalah "penjaga pintu" yang cek sebelum request masuk. Contoh: middleware 'admin' cek apakah user adalah admin sebelum biarkan akses route.

**Q: Apa perbedaan 'auth' vs 'admin' vs 'customer' middleware?**
A: 
- auth = harus login
- admin = harus login DAN role = admin
- customer = harus login DAN role = customer

**Q: Bagaimana bisa tau siapa user yang login?**
A: Gunakan `Auth::user()` atau `auth()->user()` di controller/view

**Q: Bagaimana kalau customer lupa password?**
A: Ada route /forgot-password untuk reset password via email

**Q: Apakah aplikasi sudah production-ready?**
A: Sudah cukup untuk tugas akhir, tapi bisa ditambah: email notification, SMS OTP, payment gateway integration, dll

---

Simpan file ini dan buka saat presentasi untuk jawab cepat! 🎯
