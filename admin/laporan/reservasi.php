<?php
session_start();

require_once '../../config/database.php';
require_once '../../config/config.php';

cek_akses('admin');

$query = mysqli_query($conn,"
SELECT
reservasi.*,
tamu.nama_lengkap,
kamar.nomor_kamar,
kamar.tipe_kamar
FROM reservasi
JOIN tamu
ON reservasi.id_tamu = tamu.id_tamu
JOIN kamar
ON reservasi.id_kamar = kamar.id_kamar
ORDER BY reservasi.id_reservasi DESC
");

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container mt-4">

    <div class="card shadow p-4">

        <h3 class="mb-4">
            Laporan Reservasi
        </h3>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>Kode Reservasi</th>
                        <th>Nama Tamu</th>
                        <th>No Kamar</th>
                        <th>Tipe Kamar</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Jumlah Malam</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while($row = mysqli_fetch_assoc($query)):
                ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= $row['kode_reservasi']; ?></td>

                    <td><?= $row['nama_lengkap']; ?></td>

                    <td><?= $row['nomor_kamar']; ?></td>

                    <td><?= $row['tipe_kamar']; ?></td>

                    <td>
                        <?= date('d-m-Y', strtotime($row['tgl_checkin'])); ?>
                    </td>

                    <td>
                        <?= date('d-m-Y', strtotime($row['tgl_checkout'])); ?>
                    </td>

                    <td>
                        <?= $row['jumlah_malam']; ?> malam
                    </td>

                    <td>
                        Rp <?= number_format($row['total_harga'],0,',','.'); ?>
                    </td>

                    <td>

                        <?php
                        if($row['status_reservasi']=="Pending")
                        {
                            echo '<span class="badge bg-warning text-dark">Pending</span>';
                        }
                        elseif($row['status_reservasi']=="Dikonfirmasi")
                        {
                            echo '<span class="badge bg-success">Dikonfirmasi</span>';
                        }
                        elseif($row['status_reservasi']=="Check In")
                        {
                            echo '<span class="badge bg-primary">Check In</span>';
                        }
                        elseif($row['status_reservasi']=="Check Out")
                        {
                            echo '<span class="badge bg-secondary">Check Out</span>';
                        }
                        else
                        {
                            echo '<span class="badge bg-danger">'.$row['status_reservasi'].'</span>';
                        }
                        ?>

                    </td>

                </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include '../../templates/footer.php'; ?>