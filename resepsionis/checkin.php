<?php
session_start();

require_once '../config/database.php';
require_once '../config/config.php';

cek_akses('resepsionis');

/* ======================
   PROSES CHECK IN
====================== */

if(isset($_GET['checkin']))
{
    $id_reservasi = (int)$_GET['checkin'];

    mysqli_query($conn,"
    UPDATE reservasi
    SET status_reservasi='Check In'
    WHERE id_reservasi='$id_reservasi'
    ");

    echo "
    <script>
    alert('Tamu berhasil check-in');
    window.location='checkin.php';
    </script>
    ";
}

/* ======================
   DATA RESERVASI
====================== */

$query = mysqli_query($conn,"
SELECT
reservasi.*,
tamu.nama_lengkap,
kamar.nomor_kamar,
kamar.tipe_kamar,
pembayaran.status_verifikasi
FROM reservasi
JOIN tamu
ON reservasi.id_tamu=tamu.id_tamu
JOIN kamar
ON reservasi.id_kamar=kamar.id_kamar
JOIN pembayaran
ON reservasi.id_reservasi=pembayaran.id_reservasi
WHERE pembayaran.status_verifikasi='valid'
AND reservasi.status_reservasi='Dikonfirmasi'
ORDER BY reservasi.tgl_checkin ASC
");

include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="container">

    <div class="card shadow p-4">

        <h3 class="mb-4">
            Data Check-In Tamu
        </h3>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>Kode Reservasi</th>
                        <th>Nama Tamu</th>
                        <th>Kamar</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no=1;

                while($row=mysqli_fetch_assoc($query)):
                ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td>
                            <?= $row['kode_reservasi']; ?>
                        </td>

                        <td>
                            <?= $row['nama_lengkap']; ?>
                        </td>

                        <td>
                            <?= $row['tipe_kamar']; ?>
                            <br>
                            Kamar <?= $row['nomor_kamar']; ?>
                        </td>

                        <td>
                            <?= date('d-m-Y',strtotime($row['tgl_checkin'])); ?>
                        </td>

                        <td>
                            <?= date('d-m-Y',strtotime($row['tgl_checkout'])); ?>
                        </td>

                        <td>

                            <a
                            href="?checkin=<?= $row['id_reservasi']; ?>"
                            class="btn btn-success btn-sm"
                            onclick="return confirm('Check-in tamu ini?')">

                            Check-In

                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include '../templates/footer.php'; ?>