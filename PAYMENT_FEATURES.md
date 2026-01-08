# Fitur Pembayaran Terbaru

## Ringkasan Perubahan

Telah ditambahkan fitur-fitur pembayaran yang lebih lengkap pada sistem rental motor:

### 1. **Pilihan Bank untuk Transfer** 
   - Customer bisa memilih bank tujuan saat memilih metode pembayaran "Transfer Bank"
   - Pilihan bank: BCA, Mandiri, BRI, BNI, Lainnya
   - Informasi bank tersimpan di database

### 2. **QR Code untuk Pembayaran**
   - QR code otomatis di-generate saat customer memilih metode "QR Code"
   - QR code menampilkan total biaya dan referensi transaksi
   - QR code ditampilkan di detail booking dan riwayat sewa

---

## Perubahan Database

### File Migrasi Baru
`database/migrations/2026_01_08_000001_add_bank_and_qr_to_transaksi_table.php`

### Kolom yang Ditambahkan ke Tabel `transaksi`
1. **bank_tujuan** (enum: BCA, Mandiri, BRI, BNI, Lainnya) - Nullable
2. **qr_code** (longText) - Nullable, menyimpan URL gambar QR code

---

## Perubahan Model

### File: `app/Models/Transaksi.php`
- Tambahan fillable: `bank_tujuan`, `qr_code`

---

## Perubahan Controller

### File: `app/Http/Controllers/TransaksiController.php`
- Method `store()` diupdate untuk:
  - Validasi `bank_tujuan` jika metode pembayaran adalah 'bank'
  - Generate QR code otomatis jika metode pembayaran adalah 'qr'
  - Menyimpan `bank_tujuan` dan `qr_code` ke database

---

## Perubahan View

### 1. **resources/views/transaksi/customer-create.blade.php**
   - Tambahan form untuk pilih bank (dengan kondisi show/hide)
   - Tambahan display QR code preview (dengan kondisi show/hide)
   - JavaScript function: `togglePaymentOptions()` untuk show/hide payment options
   - JavaScript function: `generateQRCode()` untuk generate QR code

### 2. **resources/views/transaksi/show.blade.php**
   - Tampilkan bank tujuan jika metode adalah 'bank'
   - Tampilkan QR code jika metode adalah 'qr'

### 3. **resources/views/transaksi/customer-index.blade.php**
   - Update badge metode pembayaran untuk menampilkan nama bank
   - Preview QR code di list booking

### 4. **resources/views/customer-transactions.blade.php**
   - Tampilkan bank tujuan di riwayat sewa
   - Preview QR code di riwayat sewa

---

## Flow Penggunaan

### Jika Customer Memilih "Transfer Bank":
1. Form akan menampilkan dropdown pilihan bank
2. Customer memilih bank tujuan
3. Bank tujuan disimpan ke database
4. Di halaman detail/riwayat, akan ditampilkan bank yang dipilih
5. Admin dapat melihat dan mengirimkan no. rekening tujuan

### Jika Customer Memilih "QR Code":
1. Form akan menampilkan preview QR code
2. QR code di-generate dengan info total biaya & referensi
3. QR code disimpan sebagai URL API ke database
4. Di halaman detail/riwayat, QR code dapat di-scan untuk pembayaran

### Jika Customer Memilih "Cash":
1. Tidak ada pilihan tambahan
2. Pembayaran dilakukan saat pengambilan motor

---

## Testing Checklist

- [ ] Migrasi berhasil dijalankan
- [ ] Form pemesanan menampilkan pilihan bank saat dipilih
- [ ] QR code ditampilkan saat dipilih metode QR
- [ ] Data bank_tujuan tersimpan di database
- [ ] Data qr_code tersimpan di database
- [ ] Detail booking menampilkan bank & QR code
- [ ] Riwayat sewa menampilkan bank & QR code
- [ ] Validasi bank tidak kosong saat memilih "Transfer Bank"

---

## API Eksternal

QR Code di-generate menggunakan:
- **API**: https://api.qrserver.com/v1/create-qr-code/
- **Metode**: GET request dengan parameter `data` dan `size`
- **Contoh**: `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=...`

---

## File yang Dimodifikasi

1. Database:
   - ✅ `database/migrations/2026_01_08_000001_add_bank_and_qr_to_transaksi_table.php` (baru)

2. Models:
   - ✅ `app/Models/Transaksi.php`

3. Controllers:
   - ✅ `app/Http/Controllers/TransaksiController.php`

4. Views:
   - ✅ `resources/views/transaksi/customer-create.blade.php`
   - ✅ `resources/views/transaksi/show.blade.php`
   - ✅ `resources/views/transaksi/customer-index.blade.php`
   - ✅ `resources/views/customer-transactions.blade.php`

---

## Catatan Penting

- QR code menggunakan API eksternal, pastikan internet tersambung saat membuat transaksi
- Jika API QR code down, QR code tidak akan ditampilkan (graceful degradation)
- Bank yang tersedia bisa ditambah di enum migration jika diperlukan
- Total biaya dihitung otomatis dalam QR code generator

