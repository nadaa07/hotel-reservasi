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

                <a href="../reservasi/index.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-calendar-check me-2"></i> Kelola Reservasi
                </a>

                <a href="index.php"
                class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1">
                    <i class="fa-solid fa-money-bill-wave me-2"></i> Kelola Pembayaran
                </a>

            </div>

        </div>
    </div>

    <!-- Konten -->
    <div class="col-md-9">

        <div class="card card-ocean p-4">

            <div class="border-bottom pb-3 mb-4">
                <h4 class="fw-bold">
                    <i class="fa-solid fa-money-bill-wave me-2"></i>
                    Data Pembayaran
                </h4>
            </div>

            <div class="table-responsive">

                <table id="tablePembayaran"
                class="table table-hover table-striped align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Reservasi</th>
                            <th>Nama Tamu</th>
                            <th>Tanggal Bayar</th>
                            <th>Metode</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    $query = mysqli_query($conn,"
                    SELECT pembayaran.*,
                           reservasi.kode_reservasi,
                           tamu.nama_lengkap
                    FROM pembayaran
                    JOIN reservasi
                        ON pembayaran.id_reservasi = reservasi.id_reservasi
                    JOIN tamu
                        ON reservasi.id_tamu = tamu.id_tamu
                    ORDER BY pembayaran.id_pembayaran DESC
                    ");

                    while($row = mysqli_fetch_assoc($query)):
                    ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td><?= $row['kode_reservasi']; ?></td>

                        <td><?= $row['nama_lengkap']; ?></td>

                        <td><?= $row['tgl_bayar']; ?></td>

                        <td><?= $row['metode_pembayaran']; ?></td>

                        <td>
                            Rp <?= number_format($row['total_bayar'],0,',','.'); ?>
                        </td>

                        <td>
                            <?php if($row['status_verifikasi'] == 'Valid'): ?>

                                <span class="badge bg-success">
                                    Valid
                                </span>

                            <?php elseif($row['status_verifikasi'] == 'Ditolak'): ?>

                                <span class="badge bg-danger">
                                    Ditolak
                                </span>

                            <?php else: ?>

                                <span class="badge bg-warning text-dark">
                                    Menunggu
                                </span>

                            <?php endif; ?>
                        </td>

                        <td>
    <a href="<?= BASEURL; ?>assets/uploads/bukti_pembayaran/<?= $row['bukti_pembayaran']; ?>"
       target="_blank"
       class="btn btn-info btn-sm text-white">

        <i class="fa-solid fa-image"></i>

    </a>
</td>

                        <td>
                            <a href="verifikasi.php?id=<?= $row['id_pembayaran']; ?>"
                            class="btn btn-warning btn-sm">

                                <i class="fa-solid fa-check"></i>

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
    $('#tablePembayaran').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        }
    });
});
</script>

<?php include '../../templates/footer.php'; ?>