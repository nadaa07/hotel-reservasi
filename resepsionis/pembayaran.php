<?php
session_start();

require_once '../config/database.php';
require_once '../config/config.php';

cek_akses('resepsionis');

/* ========================
   VERIFIKASI PEMBAYARAN
======================== */

if(isset($_GET['verifikasi']))
{
    $id_pembayaran = (int)$_GET['verifikasi'];

    // Ambil id reservasi
    $q = mysqli_query($conn,"
    SELECT id_reservasi
    FROM pembayaran
    WHERE id_pembayaran='$id_pembayaran'
    ");

    $data = mysqli_fetch_assoc($q);
    $id_reservasi = $data['id_reservasi'];

    mysqli_begin_transaction($conn);

    try
    {
        // Update status pembayaran
        mysqli_query($conn,"
        UPDATE pembayaran
        SET status_verifikasi='valid'
        WHERE id_pembayaran='$id_pembayaran'
        ");

        // Update status reservasi
        mysqli_query($conn,"
        UPDATE reservasi
        SET status_reservasi='Dikonfirmasi'
        WHERE id_reservasi='$id_reservasi'
        ");

        mysqli_commit($conn);

        echo "
        <script>
        alert('Pembayaran berhasil diverifikasi');
        window.location='pembayaran.php';
        </script>
        ";
    }
    catch(Exception $e)
    {
        mysqli_rollback($conn);

        echo "
        <script>
        alert('Verifikasi gagal');
        </script>
        ";
    }
}

/* ========================
   DATA PEMBAYARAN
======================== */

$query = mysqli_query($conn,"
SELECT
pembayaran.*,
reservasi.kode_reservasi,
tamu.nama_lengkap
FROM pembayaran
JOIN reservasi
ON pembayaran.id_reservasi = reservasi.id_reservasi
JOIN tamu
ON reservasi.id_tamu = tamu.id_tamu
ORDER BY pembayaran.id_pembayaran DESC
");

include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="container">

    <div class="card shadow p-4">

        <h3 class="mb-4">
            Data Pembayaran
        </h3>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>Kode Pembayaran</th>
                        <th>Nama Tamu</th>
                        <th>Kode Reservasi</th>
                        <th>Total Bayar</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Bukti</th>
                        <th>Status</th>
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

                        <td><?= $row['kode_pembayaran']; ?></td>

                        <td><?= $row['nama_lengkap']; ?></td>

                        <td><?= $row['kode_reservasi']; ?></td>

                        <td>
                            Rp <?= number_format($row['total_bayar'],0,',','.'); ?>
                        </td>

                        <td><?= $row['metode_pembayaran']; ?></td>

                        <td><?= $row['tgl_bayar']; ?></td>

                        <td>

                           <a href="<?= BASEURL; ?>assets/uploads/bukti_pembayaran/<?= $row['bukti_pembayaran']; ?>"
   target="_blank"
   class="btn btn-info btn-sm">
    Lihat
</a>

                        </td>

                        <td>

                            <?php
                            if(
$row['status_verifikasi']=="Menunggu Verifikasi" ||
empty($row['status_verifikasi']))
{
    echo '<span class="badge bg-warning text-dark">Pending</span>';
}
else
{
    echo '<span class="badge bg-success">Valid</span>';
}
                            ?>

                        </td>

                        <td>

                            <?php if(
$row['status_verifikasi']=="Menunggu Verifikasi" ||
empty($row['status_verifikasi'])
): ?>
                                <a
                                href="?verifikasi=<?= $row['id_pembayaran']; ?>"
                                class="btn btn-success btn-sm"
                                onclick="return confirm('Verifikasi pembayaran ini?')">

                                    Verifikasi

                                </a>

                            <?php else: ?>

                                <span class="text-success">
                                    Selesai
                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include '../templates/footer.php'; ?>