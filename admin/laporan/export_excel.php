<?php
session_start();

require_once '../../config/database.php';
require_once '../../config/config.php';

cek_akses('admin');

/* ======================
   HEADER EXCEL
====================== */

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Reservasi.xls");

/* ======================
   DATA RESERVASI
====================== */

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
?>

<h3>Laporan Reservasi Hotel</h3>

<table border="1">

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
        <?= date('d-m-Y',strtotime($row['tgl_checkin'])); ?>
    </td>

    <td>
        <?= date('d-m-Y',strtotime($row['tgl_checkout'])); ?>
    </td>

    <td>
        <?= $row['jumlah_malam']; ?>
    </td>

    <td>
        Rp <?= number_format($row['total_harga'],0,',','.'); ?>
    </td>

    <td>
        <?= $row['status_reservasi']; ?>
    </td>

</tr>

<?php endwhile; ?>

</table>