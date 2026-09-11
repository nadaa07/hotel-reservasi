<?php
session_start();

require_once '../config/database.php';
require_once '../config/config.php';

cek_akses('tamu');

/* ==========================
   AMBIL DATA TAMU LOGIN
========================== */

$id_user = $_SESSION['id_user'];

$qTamu = mysqli_query($conn,"
SELECT *
FROM tamu
WHERE id_user='$id_user'
");

if(mysqli_num_rows($qTamu) == 0)
{
    die("Data tamu tidak ditemukan.");
}

$dataTamu = mysqli_fetch_assoc($qTamu);
$id_tamu = $dataTamu['id_tamu'];

/* ==========================
   VALIDASI KAMAR
========================== */

if(!isset($_GET['pilih_kamar']))
{
    echo "
    <script>
    alert('Silakan pilih kamar terlebih dahulu');
    window.location='kamar.php';
    </script>
    ";
    exit;
}

$id_kamar = (int)$_GET['pilih_kamar'];

$qKamar = mysqli_query($conn,"
SELECT *
FROM kamar
WHERE id_kamar='$id_kamar'
");

if(mysqli_num_rows($qKamar) == 0)
{
    echo "
    <script>
    alert('Kamar tidak ditemukan');
    window.location='kamar.php';
    </script>
    ";
    exit;
}

$kamar = mysqli_fetch_assoc($qKamar);

/* ==========================
   PROSES BOOKING
========================== */

if(isset($_POST['booking']))
{
    $tgl_checkin  = $_POST['tgl_checkin'];
    $tgl_checkout = $_POST['tgl_checkout'];

    $checkin  = new DateTime($tgl_checkin);
    $checkout = new DateTime($tgl_checkout);

    $jumlah_malam = $checkout->diff($checkin)->days;

    if($jumlah_malam <= 0)
    {
        echo "
        <script>
        alert('Tanggal checkout harus setelah checkin');
        </script>
        ";
    }
    else
    {
        $total_harga =
        $jumlah_malam *
        $kamar['harga_per_malam'];

        $kode_reservasi =
        'RSV-' .
        date('YmdHis');

        mysqli_begin_transaction($conn);

        try
        {
            mysqli_query($conn,"
            INSERT INTO reservasi
            (
                kode_reservasi,
                id_tamu,
                id_kamar,
                tgl_checkin,
                tgl_checkout,
                jumlah_malam,
                total_harga,
                status_reservasi
            )
            VALUES
            (
                '$kode_reservasi',
                '$id_tamu',
                '$id_kamar',
                '$tgl_checkin',
                '$tgl_checkout',
                '$jumlah_malam',
                '$total_harga',
                'Pending'
            )
            ");

            mysqli_query($conn,"
            UPDATE kamar
            SET status_kamar='Dipesan'
            WHERE id_kamar='$id_kamar'
            ");

            mysqli_commit($conn);

            echo "
            <script>
            alert('Reservasi berhasil dibuat');
            window.location='riwayat.php';
            </script>
            ";
            exit;
        }
        catch(Exception $e)
        {
            mysqli_rollback($conn);

            echo "
            <script>
            alert('Reservasi gagal');
            </script>
            ";
        }
    }
}

include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="row">

    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">
            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary"
                style="font-size:0.85rem;letter-spacing:1px;">
                Layanan Tamu
            </h5>

            <div class="list-group list-group-flush">
                <a href="dashboard.php"
                   class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-user-circle me-2"></i>
                    Akun Saya
                </a>

                <a href="kamar.php"
                   class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-images me-2"></i>
                    Lihat Brosur Kamar
                </a>

                <a href="#"
                   class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1">
                    <i class="fa-solid fa-clipboard-list me-2"></i>
                    Booking Kamar
                </a>

                <a href="riwayat.php"
                   class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-history me-2"></i>
                    Riwayat Pemesanan
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-9">

        <div class="card card-ocean p-4">

            <h4 class="fw-bold mb-4">
                Reservasi Kamar
            </h4>

            <form method="POST">

                <input type="hidden"
                       id="harga_kamar"
                       value="<?= $kamar['harga_per_malam']; ?>">

                <div class="card border shadow-sm rounded-3 overflow-hidden mb-4">

                   <?php if(!empty($kamar['foto_kamar'])): ?>

    <img src="../assets/uploads/foto_kamar/<?= $kamar['foto_kamar']; ?>"
         style="height:220px;object-fit:cover;"
         class="card-img-top"
         alt="Foto Kamar <?= $kamar['nomor_kamar']; ?>">

<?php else: ?>

    <div class="d-flex justify-content-center align-items-center bg-light"
         style="height:220px;">
        <i class="fa-solid fa-image fa-2x text-muted"></i>
    </div>

<?php endif; ?>

                    <div class="card-body">

                        <span class="badge bg-dark mb-2">
                            <?= $kamar['tipe_kamar']; ?>
                        </span>

                        <h5 class="fw-bold">
                            Kamar <?= $kamar['nomor_kamar']; ?>
                        </h5>

                        <div class="text-success fw-bold mb-2">
                            Rp <?= number_format($kamar['harga_per_malam'],0,',','.'); ?>
                            <span class="text-muted fw-normal">/malam</span>
                        </div>

                        <p class="text-muted small mb-0">
                            <?= $kamar['fasilitas']; ?>
                        </p>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Check In
                        </label>

                        <input type="date"
                               name="tgl_checkin"
                               id="tgl_checkin"
                               class="form-control"
                               min="<?= date('Y-m-d'); ?>"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Check Out
                        </label>

                        <input type="date"
                               name="tgl_checkout"
                               id="tgl_checkout"
                               class="form-control"
                               min="<?= date('Y-m-d'); ?>"
                               required>
                    </div>

                </div>

                <div class="card bg-light p-3 mb-4">

                    <div class="d-flex justify-content-between">
                        <span>Durasi Menginap</span>
                        <strong id="durasi">0 Malam</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Total Biaya</span>
                        <h4 id="total_harga">Rp 0</h4>
                    </div>

                </div>

                <button type="submit"
                        name="booking"
                        class="btn btn-dark rounded-3 px-4">

                    <i class="fa-solid fa-paper-plane me-1"></i>
                    Reservasi Sekarang

                </button>

            </form>

        </div>

    </div>

</div>

<script>

const harga =
parseInt(
document.getElementById('harga_kamar').value
);

const checkin =
document.getElementById('tgl_checkin');

const checkout =
document.getElementById('tgl_checkout');

function hitungTotal()
{
    let tgl1 = new Date(checkin.value);
    let tgl2 = new Date(checkout.value);

    if(checkin.value && checkout.value && tgl2 > tgl1)
    {
        let malam =
        Math.ceil(
        (tgl2 - tgl1)
        /
        (1000 * 60 * 60 * 24)
        );

        let total =
        malam * harga;

        document.getElementById('durasi').innerHTML =
        malam + ' Malam';

        document.getElementById('total_harga').innerHTML =
        'Rp ' +
        total.toLocaleString('id-ID');
    }
    else
    {
        document.getElementById('durasi').innerHTML =
        '0 Malam';

        document.getElementById('total_harga').innerHTML =
        'Rp 0';
    }
}

checkin.addEventListener('change', hitungTotal);
checkout.addEventListener('change', hitungTotal);

</script>

<?php include '../templates/footer.php'; ?>