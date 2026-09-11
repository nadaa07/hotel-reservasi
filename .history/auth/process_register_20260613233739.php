<?php
require_once '../config/database.php';
require_once '../config/config.php';

if (isset($_POST['register'])) {
    $username      = mysqli_real_escape_string($conn, $_POST['username']);
    $password      = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $nik           = mysqli_real_escape_string($conn, $_POST['nik']);
    $nama_lengkap  = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_hp         = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $email         = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat        = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Cek apakah username sudah terdaftar
    $cek_user = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.location='register.php';</script>";
        exit;
    }

    // Mulai Transaksi Database agar aman (jika salah satu gagal, dibatalkan semua)
    mysqli_begin_transaction($conn);

    try {
        // 1. Insert ke tabel users
        $query_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'tamu')";
        mysqli_query($conn, $query_user);
        $id_user = mysqli_insert_id($conn);

        // 2. Insert ke tabel tamu
        $query_tamu = "INSERT INTO tamu (id_user, nik, nama_lengkap, jenis_kelamin, no_hp, email, alamat) 
                       VALUES ('$id_user', '$nik', '$nama_lengkap', '$jenis_kelamin', '$no_hp', '$email', '$alamat')";
        mysqli_query($conn, $query_tamu);

        // Jika semua berhasil, simpan permanen
        mysqli_commit($conn);
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } catch (Exception $e) {
        // Jika ada error, batalkan semua perubahan data
        mysqli_rollback($conn);
        echo "<script>alert('Registrasi gagal, periksa kembali data Anda!'); window.location='register.php';</script>";
    }
}
?>

<?php
require_once '../config/database.php';
require_once '../config/config.php';
cek_akses('admin'); // Proteksi halaman

// --- Ambil Data Statistik untuk Dashboard ---
$total_kamar    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM kamar"))['total'];
$kamar_tersedia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM kamar WHERE status_kamar='Tersedia'"))['total'];
$kamar_terisi   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM kamar WHERE status_kamar='Terisi'"))['total'];
$total_tamu     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tamu"))['total'];
$total_reservasi= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM reservasi"))['total'];

// Hitung total pendapatan dari pembayaran yang valid
$pendapatan_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_bayar) as total FROM pembayaran WHERE status_verifikasi='Valid'"));
$pendapatan       = $pendapatan_query['total'] ?? 0;

include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">
            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary" style="font-size: 0.85rem; letter-spacing: 1px;">Navigasi Admin</h5>
            <div class="list-group list-group-flush">
                <a href="dashboard.php" class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
                <a href="kamar/index.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-bed me-2"></i> Kelola Data Kamar</a>
                <a href="tamu/index.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-users me-2"></i> Kelola Data Tamu</a>
                <a href="reservasi/index.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-calendar-check me-2"></i> Kelola Reservasi</a>
                <a href="pembayaran/index.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-money-bill-wave me-2"></i> Kelola Pembayaran</a>
                <a href="laporan/index.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-file-invoice me-2"></i> Laporan Transaksi</a>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold m-0 text-uppercase" style="font-family: 'Cinzel', serif;">Dashboard Utama</h3>
                <p class="text-muted small m-0">Selamat datang kembali di panel kendali administrasi Ocean Hotel.</p>
            </div>
            <span class="badge bg-dark px-3 py-2 rounded-pill"><?= date('d F Y'); ?></span>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-4">
                <div class="card p-3 shadow-sm border-0 bg-primary text-white h-100">
                    <small class="text-white-50 text-uppercase fw-bold">Total Kamar</small>
                    <h2 class="fw-bold my-1"><?= $total_kamar; ?></h2>
                    <small><i class="fa-solid fa-hotel me-1"></i> Terdaftar di sistem</small>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card p-3 shadow-sm border-0 bg-success text-white h-100">
                    <small class="text-white-50 text-uppercase fw-bold">Kamar Tersedia</small>
                    <h2 class="fw-bold my-1"><?= $kamar_tersedia; ?></h2>
                    <small><i class="fa-solid fa-door-open me-1"></i> Siap dipesan</small>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card p-3 shadow-sm border-0 bg-danger text-white h-100">
                    <small class="text-white-50 text-uppercase fw-bold">Kamar Terisi</small>
                    <h2 class="fw-bold my-1"><?= $kamar_terisi; ?></h2>
                    <small><i class="fa-solid fa-user-check me-1"></i> Tamu aktif aktif</small>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card p-3 shadow-sm border-0 bg-warning text-dark h-100">
                    <small class="text-dark-50 text-uppercase fw-bold">Total Pelanggan</small>
                    <h2 class="fw-bold my-1"><?= $total_tamu; ?></h2>
                    <small><i class="fa-solid fa-users me-1"></i> Tamu teregistrasi</small>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card p-3 shadow-sm border-0 bg-info text-dark h-100">
                    <small class="text-dark-50 text-uppercase fw-bold">Total Reservasi</small>
                    <h2 class="fw-bold my-1"><?= $total_reservasi; ?></h2>
                    <small><i class="fa-solid fa-book me-1"></i> Riwayat booking</small>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card p-3 shadow-sm border-0 text-white h-100" style="background-color: var(--navy-dark);">
                    <small class="text-white-50 text-uppercase fw-bold">Pendapatan Hotel</small>
                    <h4 class="fw-bold my-2">Rp <?= number_format($pendapatan, 0, ',', '.'); ?></h4>
                    <small><i class="fa-solid fa-wallet me-1"></i> Dana Terverifikasi</small>
                </div>
            </div>
        </div>

        <div class="card card-ocean p-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-circle-info me-2 text-warning"></i>Status Operasional</h5>
            <p class="m-0 small text-muted">Gunakan menu navigasi di sebelah kiri untuk mengonfigurasi komponen data hotel secara penuh. Semua perubahan log transaksi akan diperbarui secara langsung oleh sistem.</p>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>