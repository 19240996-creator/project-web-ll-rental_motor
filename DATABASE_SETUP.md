# 🏍️ Aplikasi Rental Motor - Setup Database

## 📋 Informasi Database

- **Nama Database:** `db_rental_motor`
- **Database Engine:** MySQL
- **Character Set:** UTF8MB4

## 🚀 Cara Setup Database

### Opsi 1: Menggunakan File SQL (Recommended)

1. **Buka MySQL Command Line atau MySQL Workbench**

2. **Jalankan file SQL yang sudah disediakan:**
   ```sql
   SOURCE database/db_rental_motor.sql;
   ```
   
   Atau copy-paste isi file `database/db_rental_motor.sql` ke MySQL Workbench dan jalankan.

3. **Verifikasi database sudah terbuat:**
   ```sql
   SHOW DATABASES;
   USE db_rental_motor;
   SHOW TABLES;
   ```

### Opsi 2: Menggunakan Laravel Migration (Alternative)

1. **Update file `.env`:**
   ```
   DB_DATABASE=db_rental_motor
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. **Jalankan command:**
   ```powershell
   php artisan migrate --seed
   ```

### Opsi 3: Manual Setup dengan MySQL

1. **Buka Command Prompt/PowerShell dan akses MySQL:**
   ```powershell
   mysql -u root -p
   ```

2. **Copy-paste script di bawah ini:**
   ```sql
   CREATE DATABASE db_rental_motor;
   USE db_rental_motor;
   
   -- Kemudian jalankan query dari file db_rental_motor.sql
   ```

## 📊 Struktur Database

### Tabel yang Dibuat:

1. **users** - Tabel user/customer
   - id, name, email, password
   - no_telepon, alamat, no_identitas, tipe_identitas

2. **motor** - Data motor yang tersedia
   - Id_motor (Primary Key)
   - Merk_motor, Warna_motor, Harga
   - Plat_nomor, Tahun_motor, Status_motor

3. **admin_sewa_motor** - Data admin rental
   - Id_admin_rental_motor (Primary Key)
   - Nama_admin, Alamat, No_telp

4. **transaksi** - Transaksi sewa motor
   - Id_transaksi (Primary Key)
   - user_id, Id_motor, Id_admin_rental_motor
   - Tanggal_sewa, Tanggal_kembali, Status_sewa, Total_biaya

5. **pengembalian** - Data pengembalian motor
   - Id_pengembalian (Primary Key)
   - Id_transaksi (Foreign Key)
   - Tanggal_pengembalian, Biaya_keterlambatan, Catatan

6. **password_reset_tokens** - Token reset password
7. **failed_jobs** - Log job yang gagal
8. **personal_access_tokens** - Token akses API

## 📝 Sample Data

Database sudah dilengkapi dengan sample data:

- **3 Admin** dengan ID ADM001, ADM002, ADM003
- **5 Motor** dengan ID MTR001 hingga MTR005

## ⚙️ Konfigurasi

File `.env` sudah di-update dengan:
```
APP_NAME=Rental Motor
DB_DATABASE=db_rental_motor
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password sesuai konfigurasi MySQL Anda.

## ✅ Verifikasi Setup

Setelah setup database, verifikasi dengan:

1. **Check database exists:**
   ```sql
   SHOW DATABASES LIKE 'db_rental_motor';
   ```

2. **Check tables:**
   ```sql
   USE db_rental_motor;
   SHOW TABLES;
   ```

3. **Check sample data:**
   ```sql
   SELECT * FROM admin_sewa_motor;
   SELECT * FROM motor;
   ```

## 🔧 Troubleshooting

### Error: "Access denied for user 'root'@'localhost'"
- Pastikan MySQL service sudah berjalan
- Periksa username dan password di `.env`

### Error: "Unknown database 'db_rental_motor'"
- Jalankan file SQL terlebih dahulu
- Atau gunakan command: `php artisan migrate`

### Error saat migration
- Pastikan `.env` sudah benar
- Jalankan: `php artisan migrate --fresh` untuk reset

## 📞 Support

Jika ada masalah, check:
1. `.env` configuration
2. MySQL connection
3. Database permissions
4. File `database/db_rental_motor.sql`

---

**Aplikasi siap digunakan setelah setup database!** 🎉
