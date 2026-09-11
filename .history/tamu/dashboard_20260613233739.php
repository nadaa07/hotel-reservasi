<?php
require_once '../config/database.php';
require_once '../config/config.php';
cek_akses('tamu');

// Cari tahu ID profil tamu berdasarkan user ID yang login saat ini
$id_user    = $_SESSION['id_user'];
$tamu_query = mysqli_query($conn, "SELECT * FROM tamu WHERE id_user = '$id_user'");
$data_tamu  = mysqli_fetch_assoc($tamu_query);

include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">
            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary" style="font-size: 0.85rem; letter-spacing: 1px;">Layanan Tamu</h5>
            <div class="list-group list-group-flush">
                <a href="dashboard.php" class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1"><i class="fa-solid fa-user-circle me-2"></i> Akun Saya</a>
                <a href="kamar.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-images me-2"></i> Lihat Brosur Kamar</a>
                <a href="reservasi.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-clipboard-list me-2"></i> Booking Kamar</a>
                <a href="riwayat.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-history me-2"></i> Riwayat Pemesanan</a>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card card-ocean p-4 mb-4">
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Selamat Datang, <?= $data_tamu['nama_lengkap'] ?? $_SESSION['username']; ?>!</h4>
            <p class="text-muted small m-0">Nikmati pengalaman menginap berkelas dengan pemandangan laut yang spektakuler langsung dari jendela kamar Anda.</p>
        </div>

        <div class="card bg-white p-4 border shadow-sm rounded-3">
            <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fa-solid fa-id-card me-2 text-muted"></i>Detail Profil Terdaftar</h5>
            <table class="table table-sm table-borderless m-0 text-muted small">
                <tr>
                    <td width="200" class="fw-bold py-2">No. Identitas KTP (NIK)</td>
                    <td class="py-2">: <?= $data_tamu['nik'] ?? '-'; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold py-2">Nomor Telepon aktif</td>
                    <td class="py-2">: <?= $data_tamu['no_hp'] ?? '-'; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold py-2">Alamat Surel (Email)</td>
                    <td class="py-2">: <?= $data_tamu['email'] ?? '-'; ?></td>
                </tr>
                <tr>
                    <td class="fw-bold py-2">Alamat Domisili</td>
                    <td class="py-2">: <?= $data_tamu['alamat'] ?? '-'; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>