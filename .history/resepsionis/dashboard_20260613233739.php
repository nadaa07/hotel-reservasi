<?php
require_once '../config/database.php';
require_once '../config/config.php';
cek_akses('resepsionis');

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
        <div class="card card-ocean p-4 mb-4 text-center">
            <div class="logo-badge mx-auto mb-3"></div>
            <h2 class="fw-bold" style="font-family: 'Cinzel', serif;">FRONT DESK WORKSPACE</h2>
            <p class="text-muted">Selamat bertugas, <strong><?= $_SESSION['username']; ?></strong>. Pantau dan layani kedatangan tamu dengan ramah dan cepat.</p>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="card p-4 h-100 bg-white border shadow-sm rounded-3">
                    <h5 class="fw-bold text-success"><i class="fa-solid fa-bell me-2"></i>Kedatangan Hari Ini</h5>
                    <p class="text-muted small">Kelola tamu yang telah melakukan pemesanan online dan siap melakukan klaim kamar di loket.</p>
                    <a href="checkin.php" class="btn btn-sm btn-success mt-auto align-self-start px-3 rounded-pill">Buka Check In</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 h-100 bg-white border shadow-sm rounded-3">
                    <h5 class="fw-bold text-danger"><i class="fa-solid fa-key me-2"></i>Pembebasan Kamar</h5>
                    <p class="text-muted small">Proses penyelesaian pengembalian kunci kamar, kalkulasi tambahan durasi, serta cetak invoice transaksi.</p>
                    <a href="checkout.php" class="btn btn-sm btn-danger mt-auto align-self-start px-3 rounded-pill">Buka Check Out</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>