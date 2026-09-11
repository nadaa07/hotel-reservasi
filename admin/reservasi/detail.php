<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

$id_reservasi = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = mysqli_query($conn,"
SELECT reservasi.*,
       tamu.nama_lengkap,
       tamu.no_hp,
       kamar.nomor_kamar,
       kamar.tipe_kamar
FROM reservasi
JOIN tamu ON reservasi.id_tamu=tamu.id_tamu
JOIN kamar ON reservasi.id_kamar=kamar.id_kamar
WHERE reservasi.id_reservasi='$id_reservasi'
");

$data = mysqli_fetch_assoc($query);

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container">

<div class="card card-ocean p-4">

<h4 class="fw-bold mb-4">
    <i class="fa-solid fa-circle-info me-2"></i>
    Detail Reservasi
</h4>

<table class="table">

<tr>
    <th width="30%">Nama Tamu</th>
    <td><?= $data['nama_lengkap']; ?></td>
</tr>

<tr>
    <th>No HP</th>
    <td><?= $data['no_hp']; ?></td>
</tr>

<tr>
    <th>Nomor Kamar</th>
    <td><?= $data['nomor_kamar']; ?></td>
</tr>

<tr>
    <th>Tipe Kamar</th>
    <td><?= $data['tipe_kamar']; ?></td>
</tr>

<tr>
    <th>Tanggal Check In</th>
    <td><?= $data['tgl_checkin']; ?></td>
</tr>

<tr>
    <th>Tanggal Check Out</th>
    <td><?= $data['tgl_checkout']; ?></td>
</tr>

<tr>
    <th>Total Harga</th>
    <td>
        Rp <?= number_format($data['total_harga'],0,',','.'); ?>
    </td>
</tr>

<tr>
    <th>Status Reservasi</th>
    <td>

<?php
echo $data['status_reservasi'];
?>

<?php
if($data['status_reservasi']=='Pending'){
    echo "<span class='badge bg-warning'>Pending</span>";
}
elseif($data['status_reservasi']=='Check In'){
    echo "<span class='badge bg-success'>Check In</span>";
}
elseif($data['status_reservasi']=='Check Out'){
    echo "<span class='badge bg-secondary'>Check Out</span>";
}
else{
    echo "<span class='badge bg-danger'>Dibatalkan</span>";
}
?>

    </td>
</tr>

</table>

<a href="index.php" class="btn btn-secondary rounded-pill">
    <i class="fa-solid fa-arrow-left me-1"></i>
    Kembali
</a>

</div>

</div>

<?php include '../../templates/footer.php'; ?>