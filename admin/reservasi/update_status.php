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

/* ==============================
   UPDATE STATUS
============================== */
if(isset($_POST['update']))
{
    $status = mysqli_real_escape_string($conn,$_POST['status_reservasi']);

    mysqli_query($conn,"
    UPDATE reservasi
    SET status_reservasi='$status'
    WHERE id_reservasi='$id_reservasi'
    ");

    echo "
    <script>
    alert('Status reservasi berhasil diperbarui');
    window.location='update_status.php?id=$id_reservasi';
    </script>";
    exit;
}

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
$status = $data['status_reservasi'];

switch($status){

    case "Pending":
        echo "<span class='badge bg-warning'>Pending</span>";
    break;

    case "Menunggu Pembayaran":
        echo "<span class='badge bg-info'>Menunggu Pembayaran</span>";
    break;

    case "Dikonfirmasi":
        echo "<span class='badge bg-primary'>Dikonfirmasi</span>";
    break;

    case "Check In":
        echo "<span class='badge bg-success'>Check In</span>";
    break;

    case "Check Out":
        echo "<span class='badge bg-secondary'>Check Out</span>";
    break;

    case "Selesai":
        echo "<span class='badge bg-dark'>Selesai</span>";
    break;

    default:
        echo "<span class='badge bg-danger'>Dibatalkan</span>";

}
?>

    </td>
</tr>

</table>

<hr>

<form method="POST">

<div class="mb-3">

<label class="form-label fw-bold">
Ubah Status Reservasi
</label>

<select
name="status_reservasi"
class="form-select">

<option value="Pending"
<?= $status=="Pending" ? "selected" : ""; ?>>
Pending
</option>

<option value="Menunggu Pembayaran"
<?= $status=="Menunggu Pembayaran" ? "selected" : ""; ?>>
Menunggu Pembayaran
</option>

<option value="Dikonfirmasi"
<?= $status=="Dikonfirmasi" ? "selected" : ""; ?>>
Dikonfirmasi
</option>

<option value="Check In"
<?= $status=="Check In" ? "selected" : ""; ?>>
Check In
</option>

<option value="Check Out"
<?= $status=="Check Out" ? "selected" : ""; ?>>
Check Out
</option>

<option value="Selesai"
<?= $status=="Selesai" ? "selected" : ""; ?>>
Selesai
</option>

<option value="Dibatalkan"
<?= $status=="Dibatalkan" ? "selected" : ""; ?>>
Dibatalkan
</option>

</select>

</div>

<button
type="submit"
name="update"
class="btn btn-primary rounded-pill">

<i class="fa-solid fa-floppy-disk me-1"></i>

Simpan Status

</button>

<a href="index.php"
class="btn btn-secondary rounded-pill">

<i class="fa-solid fa-arrow-left me-1"></i>

Kembali

</a>

</form>

</div>

</div>

<?php include '../../templates/footer.php'; ?>