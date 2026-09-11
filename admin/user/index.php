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
                    <i class="fa-solid fa-gauge me-2"></i>
                    Dashboard
                </a>

                <a href="../kamar/index.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-bed me-2"></i>
                    Kelola Data Kamar
                </a>

                <a href="../tamu/index.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-users me-2"></i>
                    Kelola Data Tamu
                </a>

                <a href="../reservasi/index.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-calendar-check me-2"></i>
                    Kelola Reservasi
                </a>

                <a href="../pembayaran/index.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-money-bill-wave me-2"></i>
                    Kelola Pembayaran
                </a>

                <a href="index.php"
                class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1">
                    <i class="fa-solid fa-user me-2"></i>
                    Kelola User
                </a>

            </div>

        </div>
    </div>

    <!-- Konten -->
    <div class="col-md-9">

        <div class="card card-ocean p-4">

            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">

                <h4 class="fw-bold mb-0">
                    <i class="fa-solid fa-user me-2"></i>
                    Data User
                </h4>

                <a href="tambah.php" class="btn btn-success">
                    <i class="fa-solid fa-plus me-1"></i>
                    Tambah User
                </a>

            </div>

            <div class="table-responsive">

                <table id="tableUser"
                class="table table-hover table-striped align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    $query = mysqli_query($conn,"
                    SELECT *
                    FROM users
                    ORDER BY id_user DESC
                    ");

                    while($row = mysqli_fetch_assoc($query)):
                    ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td><?= $row['username']; ?></td>

                        <td>
                            <?php if($row['role'] == 'admin'): ?>

                                <span class="badge bg-danger">
                                    Admin
                                </span>

                            <?php elseif($row['role'] == 'resepsionis'): ?>

                                <span class="badge bg-warning text-dark">
                                    Resepsionis
                                </span>

                            <?php else: ?>

                                <span class="badge bg-primary">
                                    Tamu
                                </span>

                            <?php endif; ?>
                        </td>

                        <td>
                            <?= date('d-m-Y H:i', strtotime($row['created_at'])); ?>
                        </td>

                        <td>

                            <a href="edit.php?id=<?= $row['id_user']; ?>"
                            class="btn btn-warning btn-sm">

                                <i class="fa-solid fa-pen"></i>

                            </a>

                            <a href="hapus.php?id=<?= $row['id_user']; ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus user ini?')">

                                <i class="fa-solid fa-trash"></i>

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
    $('#tableUser').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        }
    });
});
</script>

<?php include '../../templates/footer.php'; ?>