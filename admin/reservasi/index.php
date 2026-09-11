<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">

            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary"
            style="font-size:0.85rem;letter-spacing:1px;">
                Navigasi Admin
            </h5>

            <div class="list-group list-group-flush">

                <a href="../dashboard.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-gauge me-2"></i> Dashboard
                </a>

                <a href="../kamar/index.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-bed me-2"></i> Kelola Data Kamar
                </a>

                <a href="../tamu/index.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-users me-2"></i> Kelola Data Tamu
                </a>

                <a href="index.php"
                class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1">
                    <i class="fa-solid fa-calendar-check me-2"></i> Kelola Reservasi
                </a>

            </div>
        </div>
    </div>

    <!-- Konten -->
    <div class="col-md-9">

        <div class="card card-ocean p-4">

           <div class="border-bottom pb-3 mb-4">
    <div class="d-flex justify-content-between align-items-center">

        <h4 class="fw-bold mb-0">
            <i class="fa-solid fa-calendar-check me-2"></i>
            Data Reservasi
        </h4>

        <a href="laporan.php" class="btn btn-success">
            <i class="fa-solid fa-file-lines me-2"></i>
            Laporan Reservasi
        </a>

    </div>
</div>

            

            <div class="table-responsive">

                <table id="tableReservasi"
                class="table table-hover table-striped align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Tamu</th>
                            <th>No Kamar</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    $query = mysqli_query($conn,"
                    SELECT reservasi.*,
                           tamu.nama_lengkap,
                           kamar.nomor_kamar
                    FROM reservasi
                    JOIN tamu ON reservasi.id_tamu = tamu.id_tamu
                    JOIN kamar ON reservasi.id_kamar = kamar.id_kamar
                    ORDER BY id_reservasi DESC
                    ");

                    while($row = mysqli_fetch_assoc($query)):
                    ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td><?= $row['nama_lengkap']; ?></td>

                        <td><?= $row['nomor_kamar']; ?></td>

                        <td><?= $row['tgl_checkin']; ?></td>

                        <td><?= $row['tgl_checkout']; ?></td>

                        <td>
                            Rp <?= number_format($row['total_harga'],0,',','.'); ?>
                        </td>

                        <td>
                            <span class="badge bg-primary">
                                <?= $row['status_reservasi']; ?>
                            </span>
                        </td>

                        <td>

                            <a href="detail.php?id=<?= $row['id_reservasi']; ?>"
                            class="btn btn-info btn-sm text-white">

                                <i class="fa-solid fa-eye"></i>

                            </a>

                            <a href="update_status.php?id=<?= $row['id_reservasi']; ?>"
                            class="btn btn-warning btn-sm">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#tableReservasi').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        }
    });
});
</script>

<?php include '../../templates/footer.php'; ?>