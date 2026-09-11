<?php
session_start();

require_once '../config/database.php';
require_once '../config/config.php';

cek_akses('tamu');

/* ==========================
   AMBIL DATA TAMU LOGIN
========================== */

$id_user = $_SESSION['id_user'];

$qTamu = mysqli_query($conn,"
SELECT *
FROM tamu
WHERE id_user='$id_user'
");

if(mysqli_num_rows($qTamu) == 0)
{
    die("Data tamu tidak ditemukan.");
}

$dataTamu = mysqli_fetch_assoc($qTamu);
$id_tamu = $dataTamu['id_tamu'];

/* ==========================
   AMBIL DATA RESERVASI
========================== */

$qReservasi = mysqli_query($conn,"
SELECT
reservasi.*,
kamar.nomor_kamar,
kamar.tipe_kamar,
kamar.foto_kamar
FROM reservasi
JOIN kamar
ON reservasi.id_kamar = kamar.id_kamar
WHERE reservasi.id_tamu='$id_tamu'
ORDER BY reservasi.id_reservasi DESC
");

include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 mb-4">

        <div class="card card-ocean p-3">

            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary"
                style="font-size:0.85rem;letter-spacing:1px;">

                Layanan Tamu

            </h5>

            <div class="list-group list-group-flush">

                <a href="dashboard.php"
                   class="list-group-item list-group-item-action rounded-3 mb-1">

                    <i class="fa-solid fa-user-circle me-2"></i>
                    Akun Saya

                </a>

                <a href="kamar.php"
                   class="list-group-item list-group-item-action rounded-3 mb-1">

                    <i class="fa-solid fa-images me-2"></i>
                    Lihat Brosur Kamar

                </a>

                <a href="kamar.php"
                   class="list-group-item list-group-item-action rounded-3 mb-1">

                    <i class="fa-solid fa-clipboard-list me-2"></i>
                    Booking Kamar

                </a>

                <a href="#"
                   class="list-group-item list-group-item-action active bg-dark border-0 rounded-3">

                    <i class="fa-solid fa-history me-2"></i>
                    Riwayat Pemesanan

                </a>

            </div>

        </div>

    </div>

    <!-- Konten -->
    <div class="col-md-9">

        <div class="card card-ocean p-4">

            <h4 class="fw-bold mb-4">
                Riwayat Reservasi
            </h4>

            <?php if(mysqli_num_rows($qReservasi) > 0): ?>

                <?php while($row = mysqli_fetch_assoc($qReservasi)): ?>

                    <div class="card shadow-sm mb-4">

                        <?php if(!empty($row['foto_kamar'])): ?>

    <img src="../assets/uploads/foto_kamar/<?= $row['foto_kamar']; ?>"
         class="card-img-top"
         style="height:220px;object-fit:cover;"
         alt="Foto Kamar">

<?php else: ?>

    <div class="d-flex justify-content-center align-items-center bg-light"
         style="height:220px;">
        <i class="fa-solid fa-image fa-2x text-muted"></i>
    </div>

<?php endif; ?>

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <span class="badge bg-dark mb-2">
                                        <?= $row['tipe_kamar']; ?>
                                    </span>

                                    <h5 class="fw-bold">
                                        Kamar <?= $row['nomor_kamar']; ?>
                                    </h5>

                                </div>

                                <div>

                                    <?php
                                    if($row['status_reservasi']=="Pending")
                                    {
                                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                                    }
                                    elseif($row['status_reservasi']=="Dikonfirmasi")
                                    {
                                        echo '<span class="badge bg-success">Dikonfirmasi</span>';
                                    }
                                    elseif($row['status_reservasi']=="Selesai")
                                    {
                                        echo '<span class="badge bg-primary">Selesai</span>';
                                    }
                                    else
                                    {
                                        echo '<span class="badge bg-danger">'.$row['status_reservasi'].'</span>';
                                    }
                                    ?>

                                </div>

                            </div>

                            <hr>

                            <div class="row">

                                <div class="col-md-6">

                                    <p>
                                        <strong>Kode Reservasi</strong><br>
                                        <?= $row['kode_reservasi']; ?>
                                    </p>

                                    <p>
                                        <strong>Check In</strong><br>
                                        <?= date('d-m-Y',strtotime($row['tgl_checkin'])); ?>
                                    </p>

                                </div>

                                <div class="col-md-6">

                                    <p>
                                        <strong>Check Out</strong><br>
                                        <?= date('d-m-Y',strtotime($row['tgl_checkout'])); ?>
                                    </p>

                                    <p>
                                        <strong>Jumlah Malam</strong><br>
                                        <?= $row['jumlah_malam']; ?> malam
                                    </p>

                                </div>

                            </div>

                            <hr>

                            <h5 class="text-success fw-bold">

                                Rp <?= number_format($row['total_harga'],0,',','.'); ?>

                            </h5>
                            <a href="pembayaran.php?id_reservasi=<?= $row['id_reservasi']; ?>"
class="btn btn-success mt-3">
    Bayar Sekarang
</a>
                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="alert alert-info">

                    Belum ada riwayat reservasi.

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php include '../templates/footer.php'; ?>