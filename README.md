# 🏍️ Aplikasi Rental Motor

Aplikasi manajemen rental motor lengkap dengan fitur booking, tracking, dan pengembalian motor. Dibangun menggunakan **Laravel 10**, **Bootstrap 5**, dan **MySQL**.

## 🎯 Fitur Utama

- ✅ **Authentication** - Register & Login user
- ✅ **Dashboard** - Statistik real-time (motor tersedia, disewa, transaksi aktif)
- ✅ **Manajemen Motor** - CRUD data motor dengan status tracking
- ✅ **Manajemen Admin** - CRUD data admin rental
- ✅ **Transaksi Sewa** - Booking motor dengan perhitungan biaya otomatis
- ✅ **Pengembalian Motor** - Pencatatan pengembalian dengan biaya keterlambatan
- ✅ **Responsive Design** - UI responsif untuk desktop dan mobile
- ✅ **Modern UI** - Bootstrap 5 dengan custom CSS styling

## 💻 Teknologi yang Digunakan

- **Backend:** Laravel 10
- **Frontend:** Bootstrap 5, HTML5, CSS3, JavaScript
- **Database:** MySQL 8.0+
- **PHP:** 8.1+
- **Icons:** Font Awesome 6

## 📦 Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- MySQL Server
- Git (opsional)

### Langkah-langkah Setup

1. **Clone atau download project:**
   ```bash
   git clone <repository-url>
   cd project-web-ll-rental_motor
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Generate APP_KEY:**
   ```bash
   php artisan key:generate
   ```

4. **Setup Database:**
   
   **Opsi A - Menggunakan File SQL (Recommended):**
   - Buka MySQL command line atau MySQL Workbench
   - Jalankan: `SOURCE database/db_rental_motor.sql;`
   
   **Opsi B - Windows Batch Script:**
   - Double-click `setup_database.bat`
   - Ikuti instruksi di layar

5. **Configure .env:**
   ```env
   APP_NAME="Rental Motor"
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_rental_motor
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Jalankan aplikasi:**
   ```bash
   php artisan serve
   ```

7. **Akses aplikasi:**
   - Browser: `http://localhost:8000`
   - Register: `http://localhost:8000/register`
   - Login: `http://localhost:8000/login`

## 📊 Struktur Database

### Database Name: `db_rental_motor`

**Tabel:**
1. **users** - Data user/customer
2. **motor** - Data motor rental
3. **admin_sewa_motor** - Data admin
4. **transaksi** - Transaksi sewa motor
5. **pengembalian** - Data pengembalian motor

**Plus:** password_reset_tokens, failed_jobs, personal_access_tokens

## 🗂️ Struktur Folder Project

```
project-web-ll-rental_motor/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Auth Controllers
│   │   │   ├── MotorController.php      # Motor CRUD
│   │   │   ├── AdminController.php      # Admin CRUD
│   │   │   ├── TransaksiController.php  # Transaksi
│   │   │   └── PengembalianController.php
│   │   └── Requests/
│   └── Models/
│       ├── User.php
│       ├── Motor.php
│       ├── Admin.php
│       ├── Transaksi.php
│       └── Pengembalian.php
├── database/
│   ├── migrations/        # Database migrations
│   └── db_rental_motor.sql # SQL file untuk setup
├── resources/
│   ├── views/
│   │   ├── auth/         # Auth pages (login, register)
│   │   ├── layouts/      # Layout template
│   │   ├── motor/        # Motor views
│   │   ├── admin/        # Admin views
│   │   ├── transaksi/    # Transaksi views
│   │   └── pengembalian/ # Pengembalian views
│   └── css/
│       └── custom.css    # Custom styling
├── routes/
│   ├── web.php          # Web routes
│   └── auth.php         # Auth routes
├── .env                 # Environment configuration
├── setup_database.bat   # Windows batch setup script
└── DATABASE_SETUP.md    # Database setup documentation
```

## 📝 Data Sample

Database sudah dilengkapi dengan data sample:

**Admin:**
- ADM001 - Ahmad Nur Harry (kp.telar)
- ADM002 - Ajril Al Baihaqi (kp.munjul)

**Motor:**
- MTR001 - Honda CB150R (150rb/hari)
- MTR002 - Yamaha Vixion (180rb/hari)
- MTR003 - Suzuki GSX (200rb/hari)
- MTR004 - Kawasaki Ninja (250rb/hari)
- MTR005 - Honda PCX (120rb/hari)

## 🚀 Cara Penggunaan

### User/Customer:
1. Register akun baru
2. Login dengan email dan password
3. Lihat motor yang tersedia di dashboard
4. Buat transaksi/booking motor
5. Melakukan pengembalian motor

### Admin:
1. Login ke sistem
2. Akses menu Master Data untuk kelola motor dan admin
3. Kelola transaksi sewa dan pengembalian
4. Lihat statistik di dashboard

## 🎨 Fitur UI/UX

- **Responsive Design** - Support desktop, tablet, mobile
- **Modern Color Scheme** - Primary: #ff6b35, Secondary: #004e89
- **Gradient Backgrounds** - Navbar dan footer dengan gradient
- **Interactive Cards** - Hover effects pada card dan button
- **Form Validation** - Client & server side validation
- **Alert Messages** - Success, error, dan warning messages

## 🔐 Security

- Password hashing dengan bcrypt
- CSRF protection di semua form
- Input validation dan sanitization
- SQL injection prevention (Prepared statements)

## 📚 API Endpoints

### Authentication
- `GET /register` - Halaman register
- `POST /register` - Proses registrasi
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `POST /logout` - Logout

### Dashboard
- `GET /dashboard` - Dashboard utama

### Motor (Authenticated)
- `GET /motor` - Daftar motor
- `GET /motor/create` - Form tambah motor
- `POST /motor` - Simpan motor
- `GET /motor/{id}/edit` - Form edit motor
- `PUT /motor/{id}` - Update motor
- `DELETE /motor/{id}` - Hapus motor

### Admin (Authenticated)
- `GET /admin` - Daftar admin
- `GET /admin/create` - Form tambah admin
- `POST /admin` - Simpan admin
- `GET /admin/{id}/edit` - Form edit admin
- `PUT /admin/{id}` - Update admin
- `DELETE /admin/{id}` - Hapus admin

### Transaksi (Authenticated)
- `GET /transaksi` - Daftar transaksi
- `GET /transaksi/create` - Form buat transaksi
- `POST /transaksi` - Simpan transaksi
- `GET /transaksi/{id}/edit` - Form edit transaksi
- `PUT /transaksi/{id}` - Update transaksi
- `DELETE /transaksi/{id}` - Hapus transaksi

### Pengembalian (Authenticated)
- `GET /pengembalian` - Daftar pengembalian
- `GET /pengembalian/create` - Form catat pengembalian
- `POST /pengembalian` - Simpan pengembalian
- `DELETE /pengembalian/{id}` - Hapus pengembalian

## 🐛 Troubleshooting

### Error: "SQLSTATE[HY000]: General error: 1030"
- Pastikan MySQL service berjalan
- Check disk space MySQL

### Error: "Access denied for user 'root'@'localhost'"
- Update .env dengan username/password yang benar
- Jalankan: `php artisan config:clear`

### Error saat migration
- Jalankan: `php artisan migrate:fresh --seed`
- Atau gunakan file SQL: `SOURCE database/db_rental_motor.sql;`

### CSS/JS tidak loading
- Jalankan: `php artisan optimize:clear`
- Clear browser cache

## 📞 Support & Contact

Untuk pertanyaan atau bug report:
- Email: support@rentalmotor.com
- Hubungi: +62-812-3456-7890

## 📄 License

MIT License - Bebas untuk digunakan, dimodifikasi, dan didistribusikan.

## 👨‍💻 Developer

Aplikasi ini dibuat untuk project akhir web II dengan teknologi Laravel terkini.

---

**Happy Renting! 🏍️**

