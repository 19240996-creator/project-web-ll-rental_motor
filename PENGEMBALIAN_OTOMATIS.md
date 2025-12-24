# Fitur Otomatis Deteksi Pengembalian Terlambat

## Apa Yang Ditambahkan?

Sistem sekarang **otomatis mendeteksi dan mencatat pengembalian motor yang terlambat** dengan menghitung denda secara otomatis.

## Cara Kerja

### 1. **Otomatis saat Catat Pengembalian**
Ketika admin mencatat pengembalian, sistem akan:
- ✓ Membandingkan tanggal kembali sebenarnya dengan tanggal target pengembalian
- ✓ Otomatis menghitung denda keterlambatan
- ✓ Mengubah status menjadi "Terlambat" jika ada keterlambatan
- ✓ Menyimpan informasi lengkap

### 2. **View Admin Menampilkan Status Jelas**
Kolom baru di halaman Data Pengembalian:
- **Status**: Badge warna (hijau=tepat waktu, merah=terlambat)
- **Tanggal Kembali Sebenarnya**: Untuk referensi detail
- **Biaya Keterlambatan**: Ditampilkan merah jika ada denda

Baris yang terlambat akan **disorot warna merah** untuk mudah diidentifikasi.

### 3. **Otomatis Check Pengembalian (Scheduler)**
Sistem berjalan otomatis setiap hari jam 08:00 pagi untuk:
- Memeriksa semua pengembalian yang status belum ditentukan
- Otomatis update status berdasarkan tanggal kembali
- Menghitung dan menyimpan denda

## Cara Menggunakan

### Manual Check (Kapan Saja)
```bash
php artisan returns:check-late
```

### Force Check Semua Pengembalian
```bash
php artisan returns:check-late --force
```

## Status Pengembalian

| Status | Arti | Warna Badge |
|--------|------|-------------|
| **Dikembalikan** | Motor dikembalikan tepat waktu | Hijau ✓ |
| **Dikembalikan_Terlambat** | Motor dikembalikan terlambat | Merah ❌ |
| **Diproses** | Data belum selesai diproses | Orange ⏱️ |

## Database Updates

Kolom yang digunakan:
- `Tanggal_kembali_sebenarnya`: Tanggal motor benar-benar dikembalikan
- `Status_pengembalian`: Status pengembalian (Diproses/Dikembalikan/Dikembalikan_Terlambat)
- `Biaya_keterlambatan`: Denda keterlambatan (otomatis terhitung)

## Rumus Perhitungan Denda

```
Denda = Hari Terlambat × Harga Motor Per Hari
```

Contoh:
- Motor A: Rp 100.000/hari
- Terlambat 3 hari
- Denda = 3 × 100.000 = Rp 300.000

## Catatan Penting

⚠️ **Pastikan:**
1. **Tanggal Kembali Sebenarnya** selalu diisi saat mencatat pengembalian
2. **Harga Motor** sudah benar di master data motor
3. Scheduler Laravel berjalan (untuk otomasi harian)
   ```bash
   # Setup cron job ini di server:
   * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
   ```

---
**Fitur ini memastikan tidak ada pengembalian terlambat yang terlewatkan!** ✨
