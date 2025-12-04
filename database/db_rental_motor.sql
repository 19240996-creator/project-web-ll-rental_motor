-- =====================================================
-- SQL Database untuk Aplikasi Rental Motor
-- Database Name: db_rental_motor
-- =====================================================

-- Buat Database
CREATE DATABASE IF NOT EXISTS db_rental_motor;
USE db_rental_motor;

-- =====================================================
-- Table: users
-- =====================================================
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    no_telepon VARCHAR(20),
    alamat TEXT,
    no_identitas VARCHAR(50),
    tipe_identitas ENUM('KTP', 'SIM', 'Paspor'),
    remember_token VARCHAR(100),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: password_reset_tokens
-- =====================================================
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: failed_jobs
-- =====================================================
CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_uuid (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: personal_access_tokens
-- =====================================================
CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_tokenable_type_id (tokenable_type, tokenable_id),
    INDEX idx_token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: motor
-- =====================================================
CREATE TABLE motor (
    Id_motor VARCHAR(50) PRIMARY KEY,
    Merk_motor VARCHAR(100) NOT NULL,
    Warna_motor VARCHAR(50) NOT NULL,
    Harga INT NOT NULL,
    Plat_nomor VARCHAR(20) NOT NULL UNIQUE,
    Tahun_motor VARCHAR(4) NOT NULL,
    Status_motor ENUM('Tersedia', 'Disewa', 'Maintenance') DEFAULT 'Tersedia',
    Deskripsi TEXT,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (Status_motor),
    INDEX idx_plat_nomor (Plat_nomor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: admin_sewa_motor
-- =====================================================
CREATE TABLE admin_sewa_motor (
    Id_admin_rental_motor VARCHAR(50) PRIMARY KEY,
    Nama_admin VARCHAR(100) NOT NULL,
    Alamat TEXT NOT NULL,
    No_telp VARCHAR(20) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: transaksi
-- =====================================================
CREATE TABLE transaksi (
    Id_transaksi VARCHAR(50) PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    Id_motor VARCHAR(50) NOT NULL,
    Id_admin_rental_motor VARCHAR(50) NOT NULL,
    Tanggal_sewa DATE NOT NULL,
    Tanggal_kembali DATE NOT NULL,
    Status_sewa ENUM('Proses', 'Aktif', 'Selesai', 'Batal') DEFAULT 'Proses',
    Total_biaya INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (Id_motor) REFERENCES motor(Id_motor) ON DELETE CASCADE,
    FOREIGN KEY (Id_admin_rental_motor) REFERENCES admin_sewa_motor(Id_admin_rental_motor) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_motor_id (Id_motor),
    INDEX idx_admin_id (Id_admin_rental_motor),
    INDEX idx_status (Status_sewa),
    INDEX idx_tanggal (Tanggal_sewa, Tanggal_kembali)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: pengembalian
-- =====================================================
CREATE TABLE pengembalian (
    Id_pengembalian VARCHAR(50) PRIMARY KEY,
    Id_transaksi VARCHAR(50) NOT NULL,
    Tanggal_pengembalian DATE NOT NULL,
    Biaya_keterlambatan INT DEFAULT 0,
    Catatan TEXT,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (Id_transaksi) REFERENCES transaksi(Id_transaksi) ON DELETE CASCADE,
    INDEX idx_transaksi_id (Id_transaksi),
    INDEX idx_tanggal (Tanggal_pengembalian)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Sample Data
-- =====================================================

-- Insert Sample Admin
INSERT INTO admin_sewa_motor (Id_admin_rental_motor, Nama_admin, Alamat, No_telp) VALUES
('ADM001', 'Budi Santoso', 'Jl. Ahmad Yani No. 123, Jakarta', '081234567890'),
('ADM002', 'Siti Nurhaliza', 'Jl. Gatot Subroto No. 45, Bandung', '082345678901'),
('ADM003', 'Eka Wahyu', 'Jl. Diponegoro No. 78, Surabaya', '083456789012');

-- Insert Sample Motor
INSERT INTO motor (Id_motor, Merk_motor, Warna_motor, Harga, Plat_nomor, Tahun_motor, Status_motor, Deskripsi) VALUES
('MTR001', 'Honda CB150R', 'Merah', 150000, 'B 1234 ABC', '2023', 'Tersedia', 'Motor sport style, mesin 4 tak, 150cc'),
('MTR002', 'Yamaha Vixion', 'Hitam', 180000, 'B 5678 XYZ', '2022', 'Tersedia', 'Motor standar, mesin 4 tak, 155cc'),
('MTR003', 'Suzuki GSX', 'Biru', 200000, 'B 9012 DEF', '2023', 'Tersedia', 'Motor sport premium, mesin 4 tak, 150cc'),
('MTR004', 'Kawasaki Ninja', 'Hijau', 250000, 'B 3456 GHI', '2023', 'Tersedia', 'Motor sport racing, mesin 4 tak, 250cc'),
('MTR005', 'Honda PCX', 'Abu-abu', 120000, 'B 7890 JKL', '2022', 'Tersedia', 'Motor scooter, otomatis, 160cc');

-- =====================================================
-- End of Database Setup
-- =====================================================
