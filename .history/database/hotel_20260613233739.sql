CREATE DATABASE IF NOT EXISTS hotel_reservasi;
USE hotel_reservasi;

-- 1. Tabel Users (Untuk Autentikasi dan Akun)
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'resepsionis', 'tamu') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabel Kamar
CREATE TABLE kamar (
    id_kamar INT AUTO_INCREMENT PRIMARY KEY,
    nomor_kamar VARCHAR(10) NOT NULL UNIQUE,
    tipe_kamar ENUM('Standard', 'Deluxe', 'Suite') NOT NULL,
    harga_per_malam DECIMAL(10,2) NOT NULL,
    kapasitas INT NOT NULL,
    fasilitas TEXT,
    foto_kamar VARCHAR(255) DEFAULT 'default_kamar.jpg',
    status_kamar ENUM('Tersedia', 'Dipesan', 'Terisi', 'Maintenance') DEFAULT 'Tersedia'
) ENGINE=InnoDB;

-- 3. Tabel Tamu (Profil Lengkap Tamu)
CREATE TABLE tamu (
    id_tamu INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NULL,
    nik VARCHAR(16) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    no_hp VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    alamat TEXT,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 4. Tabel Reservasi
CREATE TABLE reservasi (
    id_reservasi INT AUTO_INCREMENT PRIMARY KEY,
    kode_reservasi VARCHAR(20) NOT NULL UNIQUE,
    id_tamu INT NOT NULL,
    id_kamar INT NOT NULL,
    tgl_checkin DATE NOT NULL,
    tgl_checkout DATE NOT NULL,
    jumlah_malam INT NOT NULL,
    total_harga DECIMAL(12,2) NOT NULL,
    status_reservasi ENUM('Pending', 'Menunggu Pembayaran', 'Dikonfirmasi', 'Check In', 'Check Out', 'Dibatalkan') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tamu) REFERENCES tamu(id_tamu) ON DELETE CASCADE,
    FOREIGN KEY (id_kamar) REFERENCES kamar(id_kamar) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. Tabel Pembayaran
CREATE TABLE pembayaran (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    kode_pembayaran VARCHAR(20) NOT NULL UNIQUE,
    id_reservasi INT NOT NULL,
    total_bayar DECIMAL(12,2) NOT NULL,
    metode_pembayaran VARCHAR(50) NOT NULL,
    tgl_bayar DATETIME DEFAULT CURRENT_TIMESTAMP,
    bukti_pembayaran VARCHAR(255) NOT NULL,
    status_verifikasi ENUM('Menunggu Verifikasi', 'Valid', 'Ditolak') DEFAULT 'Menunggu Verifikasi',
    FOREIGN KEY (id_reservasi) REFERENCES reservasi(id_reservasi) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ========================================================
-- DATA DUMMY AWAL (Password menggunakan password_hash BCRYPT)
-- ========================================================

-- Password untuk semuanya adalah 'admin123', 'resep123', 'tamu123' yang sudah di-hash
INSERT INTO users (id_user, username, password, role) VALUES
(1, 'admin', '$2y$10$wK6Q5Z81b0aVbY3Z98X6Oexh6YgD1xM2fB6zC3vD4eE5fF6gG7hHi', 'admin'),
(2, 'resep', '$2y$10$7vICl9o7XJ2bB5BvD6X7Oux9YgD1xM2fB6zC3vD4eE5fF6gG7hHi', 'resepsionis'),
(3, 'tamu1', '$2y$10$M7nRl0p9XJ2bB5BvD6X7Oux9YgD1xM2fB6zC3vD4eE5fF6gG7hHi', 'tamu');

INSERT INTO kamar (nomor_kamar, tipe_kamar, harga_per_malam, kapasitas, fasilitas, status_kamar) VALUES
('101', 'Standard', 300000.00, 2, 'Free WiFi, AC, TV, Kamar Mandi Dalam', 'Tersedia'),
('102', 'Standard', 300000.00, 2, 'Free WiFi, AC, TV, Kamar Mandi Dalam', 'Tersedia'),
('201', 'Deluxe', 500000.00, 2, 'Free WiFi, AC, Smart TV, Mini Bar, Balon', 'Tersedia'),
('202', 'Deluxe', 500000.00, 2, 'Free WiFi, AC, Smart TV, Mini Bar, Balon', 'Tersedia'),
('301', 'Suite', 800000.00, 4, 'Free WiFi, AC, Smart TV, Mini Bar, Bathtub, Ruang Tamu', 'Tersedia'),
('302', 'Suite', 800000.00, 4, 'Free WiFi, AC, Smart TV, Mini Bar, Bathtub, Ruang Tamu', 'Tersedia');

INSERT INTO tamu (id_tamu, id_user, nik, nama_lengkap, jenis_kelamin, no_hp, email, alamat) VALUES
(1, 3, '1234567890123456', 'Budi Santoso', 'Laki-laki', '081234567890', 'budi@mail.com', 'Jl. Merdeka No. 10');

-- TRIGGER: Mengubah status kamar otomatis saat Reservasi Check In / Check Out
DELIMITER $$
CREATE TRIGGER tg_status_kamar_checkin
AFTER UPDATE ON reservasi
FOR EACH ROW
BEGIN
    IF NEW.status_reservasi = 'Check In' THEN
        UPDATE kamar SET status_kamar = 'Terisi' WHERE id_kamar = NEW.id_kamar;
    ELSEIF NEW.status_reservasi = 'Check Out' THEN
        UPDATE kamar SET status_kamar = 'Tersedia' WHERE id_kamar = NEW.id_kamar;
    END IF;
END$$
DELIMITER ;