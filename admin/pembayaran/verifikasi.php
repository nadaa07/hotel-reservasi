<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

$id = $_GET['id'];

// Ambil data pembayaran
$query = mysqli_query($conn,"
SELECT pembayaran.*,
       reservasi.kode_reservasi,
       tamu.nama_lengkap
FROM pembayaran
JOIN reservasi ON pembayaran.id_reservasi = reservasi.id_reservasi
JOIN tamu ON reservasi.id_tamu = tamu.id_tamu
WHERE pembayaran.id_pembayaran='$id'
");

$data = mysqli_fetch_assoc($query);

// Proses update status
if(isset($_POST['simpan']))
{
    $status = $_POST['status_verifikasi'];

    mysqli_query($conn,"
    UPDATE pembayaran
    SET status_verifikasi='$status'
    WHERE id_pembayaran='$id'
    ");

    echo "
    <script>
    alert('Status pembayaran berhasil diperbarui!');
    window.location='index.php';
    </script>
    ";
}

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="row">

    <div class="col-md-3"></div>

    <div class="col-md-6">

        <div class="card card-ocean p-4">

            <h4 class="fw-bold mb-4">
                <i class="fa-solid fa-check-circle me-2"></i>
                Verifikasi Pembayaran
            </h4>

            <table class="table">

                <tr>
                    <th>Kode Reservasi</th>
                    <td><?= $data['kode_reservasi']; ?></td>
                </tr>

                <tr>
                    <th>Nama Tamu</th>
                    <td><?= $data['nama_lengkap']; ?></td>
                </tr>

                <tr>
                    <th>Metode Pembayaran</th>
                    <td><?= $data['metode_pembayaran']; ?></td>
                </tr>

                <tr>
                    <th>Total Bayar</th>
                    <td>
                        Rp <?= number_format($data['total_bayar'],0,',','.'); ?>
                    </td>
                </tr>

                <tr>
                    <th>Bukti Pembayaran</th>
                    <td>
                        <img src="../../assets/uploads/<?= $data['bukti_pembayaran']; ?>"
                             class="img-fluid rounded border"
                             width="300">
                    </td>
                </tr>

            </table>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Status Verifikasi
                    </label>

                    <select name="status_verifikasi"
                            class="form-select"
                            required>

                        <option value="Menunggu"
                        <?= ($data['status_verifikasi']=='Menunggu') ? 'selected' : ''; ?>>
                            Menunggu
                        </option>

                        <option value="Valid"
                        <?= ($data['status_verifikasi']=='Valid') ? 'selected' : ''; ?>>
                            Valid
                        </option>

                        <option value="Ditolak"
                        <?= ($data['status_verifikasi']=='Ditolak') ? 'selected' : ''; ?>>
                            Ditolak
                        </option>

                    </select>
                </div>

                <button type="submit"
                        name="simpan"
                        class="btn btn-success">
                    <i class="fa-solid fa-save me-1"></i>
                    Simpan
                </button>

                <a href="index.php"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>

<?php include '../../templates/footer.php'; ?>