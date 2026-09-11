<?php
session_start();

require_once '../config/database.php';
require_once '../config/config.php';

cek_akses('resepsionis');

/* =========================
   PROSES CHECK OUT
========================= */

if(isset($_GET['checkout']))
{
    $id_reservasi = (int)$_GET['checkout'];

    // Ambil id kamar
    $qKamar = mysqli_query($conn,"
    SELECT id_kamar
    FROM reservasi
    WHERE id_reservasi='$id_reservasi'
    ");

    $dataKamar = mysqli_fetch_assoc($qKamar);
    $id_kamar = $dataKamar['id_kamar'];

    mysqli_begin_transaction($conn);

    try
    {
        // Ubah status reservasi
        mysqli_query($conn,"
        UPDATE reservasi
        SET status_reservasi='Selesai'
        WHERE id_reservasi='$id_reservasi'
        ");

        // Kamar tersedia lagi
        mysqli_query($conn,"
        UPDATE kamar
        SET status_kamar='Tersedia'
        WHERE id_kamar='$id_kamar'
        ");

        mysqli_commit($conn);

        echo "
        <script>
        alert('Check-Out berhasil');
        window.location='checkout.php';
        </script>
        ";
    }
    catch(Exception $e)
    {
        mysqli_rollback($conn);

        echo "
        <script>
        alert('Check-Out gagal');
        </script>
        ";
    }
}

/* =========================
   DATA CHECK OUT
========================= */

$query = mysqli_query($conn,"
SELECT
reservasi.*,
tamu.nama_lengkap,
kamar.nomor_kamar,
kamar.tipe_kamar
FROM reservasi
JOIN tamu
ON reservasi.id_tamu=tamu.id_tamu
JOIN kamar
ON reservasi.id_kamar=kamar.id_kamar
WHERE reservasi.status_reservasi='Check In'
ORDER BY reservasi.tgl_checkin ASC
");

include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="container">

    <div class="card shadow p-4">

        <h3 class="mb-4">
            Data Check-Out Tamu
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
                $no = 1;

                while($row = mysqli_fetch_assoc($query)):
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
                            href="?checkout=<?= $row['id_reservasi']; ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin check-out tamu ini?')">

                                Check-Out

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