<?php
require_once '../config/database.php';
require_once '../config/config.php';
cek_akses('resepsionis');

// Hitung status real-time kamar untuk resepsionis
$kamar_ready = mysqli_query($conn, "SELECT COUNT(*) as total FROM kamar WHERE status_kamar = 'Tersedia'");
$ready_data  = mysqli_fetch_assoc($kamar_ready);

$kamar_full  = mysqli_query($conn, "SELECT COUNT(*) as total FROM kamar WHERE status_kamar = 'Terisi'");
$full_data   = mysqli_fetch_assoc($kamar_full);

include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">
            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary" style="font-size: 0.85rem; letter-spacing: 1px;">Menu Resepsionis</h5>
            <div class="list-group list-group-flush">
                <a href="dashboard.php" class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1"><i class="fa-solid fa-desktop me-2"></i> Front Desk</a>
                <a href="checkin.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-sign-in-alt me-2"></i> Proses Check In</a>
                <a href="checkout.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-sign-out-alt me-2"></i> Proses Check Out</a>
                <a href="pembayaran.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-receipt me-2"></i> Kasir Pembayaran</a>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card card-ocean p-4 mb-4">
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);"><i class="fa-solid fa-bell-concierge me-2"></i>Resepsionis Workspace</h4>
            <p class="text-muted small m-0">Kelola proses kedatangan, kepulangan, serta transaksi langsung di meja kasir depan secara efisien.</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card p-3 border-0 bg-success text-white shadow-sm">
                    <small class="text-uppercase fw-bold opacity-75 d-block mb-1">Kamar Siap Huni</small>
                    <h2 class="fw-bold m-0"><?= $ready_data['total']; ?> <span class="fs-5 fw-normal">Kosong</span></h2>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card p-3 border-0 bg-danger text-white shadow-sm">
                    <small class="text-uppercase fw-bold opacity-75 d-block mb-1">Kamar Sedang Digunakan</small>
                    <h2 class="fw-bold m-0"><?= $full_data['total']; ?> <span class="fs-5 fw-normal">Terisi</span></h2>
                </div>
            </div>
        </div>

        <h5 class="fw-bold mb-3"><i class="fa-solid fa-circle-info text-secondary me-2"></i>Panduan Cepat Layanan</h5>
        <div class="row text-center small">
            <div class="col-sm-4 mb-3">
                <div class="p-3 bg-white border rounded-3 h-100 shadow-xs">
                    <i class="fa-solid fa-user-check fa-2x text-success mb-2"></i>
                    <h6 class="fw-bold">Tamu Mau Check-In?</h6>
                    <p class="text-muted small">Validasi identitas fisik, berikan kunci kamar, lalu tekan tombol proses.</p>
                    <a href="checkin.php" class="btn btn-xs btn-outline-success rounded-pill px-3">Buka Daftar</a>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="p-3 bg-white border rounded-3 h-100 shadow-xs">
                    <i class="fa-solid fa-door-open fa-2x text-danger mb-2"></i>
                    <h6 class="fw-bold">Tamu Mau Pulang?</h6>
                    <p class="text-muted small">Terima pengembalian kunci kamar, cek fasilitas, lalu konfirmasi keluar.</p>
                    <a href="checkout.php" class="btn btn-xs btn-outline-danger rounded-pill px-3">Buka Daftar</a>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="p-3 bg-white border rounded-3 h-100 shadow-xs">
                    <i class="fa-solid fa-wallet fa-2x text-warning mb-2"></i>
                    <h6 class="fw-bold">Bayar Cash di Tempat?</h6>
                    <p class="text-muted small">Gunakan menu kasir untuk pelunasan manual tanpa via upload struk online.</p>
                    <a href="pembayaran.php" class="btn btn-xs btn-outline-warning text-dark rounded-pill px-3">Buka Kasir</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>