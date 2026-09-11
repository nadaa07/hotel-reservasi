<?php
require_once '../config/database.php';
require_once '../config/config.php';
cek_akses('admin');

// Statistik
$total_kamar = mysqli_query($conn, "SELECT COUNT(*) as total FROM kamar");
$kamar_data = mysqli_fetch_assoc($total_kamar);

$total_tamu = mysqli_query($conn, "SELECT COUNT(*) as total FROM tamu");
$tamu_data = mysqli_fetch_assoc($total_tamu);

$total_reservasi = mysqli_query($conn, "SELECT COUNT(*) as total FROM reservasi");
$reservasi_data = mysqli_fetch_assoc($total_reservasi);

$total_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$user_data = mysqli_fetch_assoc($total_user);

include '../templates/header.php';
include '../templates/navbar.php';
?>
<div class="container my-4">
<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">
            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary"
                style="font-size:0.85rem; letter-spacing:1px;">
                Menu Admin
            </h5>

            <div class="list-group list-group-flush">
                <a href="dashboard.php"
                   class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1">
                    <i class="fa-solid fa-chart-line me-2"></i> Dashboard
                </a>

                <a href="kamar/index.php"
class="list-group-item list-group-item-action rounded-3 mb-1">
    <i class="fa-solid fa-bed me-2"></i> Data Kamar
</a>

<a href="tamu/index.php"
class="list-group-item list-group-item-action rounded-3 mb-1">
    <i class="fa-solid fa-users me-2"></i> Data Tamu
</a>

<a href="reservasi/index.php"
class="list-group-item list-group-item-action rounded-3 mb-1">
    <i class="fa-solid fa-calendar-check me-2"></i> Data Reservasi
</a>

<a href="pembayaran/index.php"
class="list-group-item list-group-item-action rounded-3 mb-1">
    <i class="fa-solid fa-money-bill-wave me-2"></i> Data Pembayaran
</a>

<a href="user/index.php"
class="list-group-item list-group-item-action rounded-3 mb-1">
    <i class="fa-solid fa-user-gear me-2"></i> Kelola User
</a>

<a href="laporan/index.php"
class="list-group-item list-group-item-action rounded-3 mb-1">
    <i class="fa-solid fa-file-lines me-2"></i> Laporan
</a>
</div>
            </div>
        </div>
    


    <!-- Konten -->
    <div class="col-md-9">

        <!-- Header -->
        <div class="card card-ocean p-4 mb-4">
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">
                <i class="fa-solid fa-user-shield me-2"></i>
                Admin Workspace
            </h4>

            <p class="text-muted small m-0">
                Kelola seluruh data hotel, kamar, reservasi, pembayaran, dan pengguna sistem secara efisien.
            </p>
        </div>


        <!-- Statistik -->
        <div class="row mb-4">

            <div class="col-md-6 mb-3">
                <div class="card p-3 border-0 bg-primary text-white shadow-sm">
                    <small class="text-uppercase fw-bold opacity-75 d-block mb-1">
                        Total Kamar
                    </small>

                    <h2 class="fw-bold m-0">
                        <?= $kamar_data['total']; ?>
                    </h2>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card p-3 border-0 bg-success text-white shadow-sm">
                    <small class="text-uppercase fw-bold opacity-75 d-block mb-1">
                        Total Tamu
                    </small>

                    <h2 class="fw-bold m-0">
                        <?= $tamu_data['total']; ?>
                    </h2>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card p-3 border-0 bg-warning text-dark shadow-sm">
                    <small class="text-uppercase fw-bold opacity-75 d-block mb-1">
                        Total Reservasi
                    </small>

                    <h2 class="fw-bold m-0">
                        <?= $reservasi_data['total']; ?>
                    </h2>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card p-3 border-0 bg-danger text-white shadow-sm">
                    <small class="text-uppercase fw-bold opacity-75 d-block mb-1">
                        Total User Sistem
                    </small>

                    <h2 class="fw-bold m-0">
                        <?= $user_data['total']; ?>
                    </h2>
                </div>
            </div>

        </div>


        <!-- Panduan Cepat -->
        <h5 class="fw-bold mb-3">
            <i class="fa-solid fa-circle-info text-secondary me-2"></i>
            Panduan Cepat Admin
        </h5>

        <div class="row text-center small">

            <div class="col-sm-4 mb-3">
                <div class="p-3 bg-white border rounded-3 h-100 shadow-xs">

                    <i class="fa-solid fa-bed fa-2x text-primary mb-2"></i>

                    <h6 class="fw-bold">Kelola Kamar</h6>

                    <p class="text-muted small">
                        Tambah, edit, dan hapus data kamar hotel beserta fasilitasnya.
                    </p>

                    <a href="kamar/index.php"
class="btn btn-outline-primary rounded-pill px-3">
    Buka Data
</a>
                </div>
            </div>


            <div class="col-sm-4 mb-3">
                <div class="p-3 bg-white border rounded-3 h-100 shadow-xs">

                    <i class="fa-solid fa-calendar-check fa-2x text-success mb-2"></i>

                    <h6 class="fw-bold">Kelola Reservasi</h6>

                    <p class="text-muted small">
                        Pantau seluruh transaksi pemesanan kamar dari pelanggan.
                    </p>

                    <a href="reservasi/index.php"
class="btn btn-outline-success rounded-pill px-3">
    Buka Data
</a>

                </div>
            </div>


            <div class="col-sm-4 mb-3">
                <div class="p-3 bg-white border rounded-3 h-100 shadow-xs">

                    <i class="fa-solid fa-user-gear fa-2x text-danger mb-2"></i>

                    <h6 class="fw-bold">Kelola User</h6>

                    <p class="text-muted small">
                        Atur akun admin, resepsionis, dan tamu yang menggunakan sistem.
                    </p>

                   <a href="user/index.php"
class="btn btn-outline-danger rounded-pill px-3">
    Buka Data
</a>
                </div>
            </div>

        </div>

    </div>

</div>

<?php include '../templates/footer.php'; ?>