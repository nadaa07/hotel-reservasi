<?php
session_start();

require_once '../config/database.php';
require_once '../config/config.php';

cek_akses('tamu');

if(!isset($_GET['id_reservasi']))
{
    echo "
    <script>
    alert('Data reservasi tidak ditemukan');
    window.location='riwayat.php';
    </script>
    ";
    exit;
}

$id_reservasi = (int)$_GET['id_reservasi'];

$query = mysqli_query($conn,"
SELECT reservasi.*, kamar.nomor_kamar, kamar.tipe_kamar
FROM reservasi
JOIN kamar ON reservasi.id_kamar=kamar.id_kamar
WHERE reservasi.id_reservasi='$id_reservasi'
");

if(mysqli_num_rows($query)==0)
{
    echo "
    <script>
    alert('Reservasi tidak ditemukan');
    window.location='riwayat.php';
    </script>
    ";
    exit;
}

$data = mysqli_fetch_assoc($query);

if(isset($_POST['bayar']))
{
    $kode_pembayaran = "PAY-".date('YmdHis');
    $total_bayar = $data['total_harga'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $tgl_bayar = date('Y-m-d');

   $nama_file = $_FILES['bukti_pembayaran']['name'];
$tmp_file = $_FILES['bukti_pembayaran']['tmp_name'];

if(move_uploaded_file(
    $tmp_file,
    "../assets/uploads/bukti_pembayaran/".$nama_file
))
{
    mysqli_query($conn,"
    INSERT INTO pembayaran
    (
        kode_pembayaran,
        id_reservasi,
        total_bayar,
        metode_pembayaran,
        tgl_bayar,
        bukti_pembayaran,
        status_verifikasi
    )
    VALUES
    (
        '$kode_pembayaran',
        '$id_reservasi',
        '$total_bayar',
        '$metode_pembayaran',
        '$tgl_bayar',
        '$nama_file',
        'menunggu verifikasi'
    )
    ");
}
else
{
    echo "<script>alert('Upload bukti pembayaran gagal!');</script>";
}

    echo "
    <script>
    alert('Pembayaran berhasil dikirim');
    window.location='riwayat.php';
    </script>
    ";
}
?>

<?php include '../templates/header.php'; ?>
<?php include '../templates/navbar.php'; ?>

<div class="container">

    <div class="card shadow p-4">

        <h3 class="mb-4">
            Pembayaran Reservasi
        </h3>

        <table class="table">

            <tr>
                <th>Kode Reservasi</th>
                <td><?= $data['kode_reservasi']; ?></td>
            </tr>

            <tr>
                <th>Tipe Kamar</th>
                <td><?= $data['tipe_kamar']; ?></td>
            </tr>

            <tr>
                <th>Total Pembayaran</th>
                <td class="text-success fw-bold">
                    Rp <?= number_format($data['total_harga'],0,',','.'); ?>
                </td>
            </tr>

        </table>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">

    <label class="form-label fw-bold">
        Metode Pembayaran
    </label>

    <select
    name="metode_pembayaran"
    id="metode_pembayaran"
    class="form-select"
    required>

    <option value="">
        -- Pilih Metode Pembayaran --
    </option>

    <optgroup label="E-Wallet">
        <option value="DANA">DANA</option>
        <option value="OVO">OVO</option>
        <option value="GoPay">GoPay</option>
        <option value="ShopeePay">ShopeePay</option>
    </optgroup>

    <optgroup label="Transfer Bank">
        <option value="Bank BCA">Bank BCA</option>
        <option value="Bank BRI">Bank BRI</option>
        <option value="Bank Mandiri">Bank Mandiri</option>
        <option value="Bank BNI">Bank BNI</option>
    </optgroup>

    <optgroup label="Cash">
        <option value="Bayar di Hotel">Bayar di Hotel</option>
    </optgroup>

</select>

    <div id="infoPembayaran" class="mt-3" style="display:none;">
</div>

<small class="text-muted">
    Pilih metode pembayaran terlebih dahulu.
</small>

</div>

            <div class="mb-3">

                <label class="form-label">
                    Upload Bukti Pembayaran
                </label>

                <input
                    type="file"
                    name="bukti_pembayaran"
                    class="form-control"
                    required>

            </div>

            <button
                type="submit"
                name="bayar"
                class="btn btn-dark">

                Kirim Pembayaran

            </button>

        </form>

    </div>

</div>

<script>

const infoPembayaran = document.getElementById("infoPembayaran");

document.getElementById("metode_pembayaran").addEventListener("change", function(){

    let html = "";

    switch(this.value){

        case "DANA":
            html = `
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h6>💳 DANA</h6>
                    <h5 id="nomor">081234567890</h5>
                    <small>A/N OCEAN HOTEL</small><br>
                    <button type="button"
                    class="btn btn-success btn-sm mt-2"
                    onclick="copyText('081234567890')">
                    Copy Nomor
                    </button>
                </div>
            </div>`;
        break;

        case "OVO":
            html = `
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h6>💳 OVO</h6>
                    <h5>081234567890</h5>
                    <small>A/N OCEAN HOTEL</small><br>
                    <button type="button"
                    class="btn btn-success btn-sm mt-2"
                    onclick="copyText('081234567890')">
                    Copy Nomor
                    </button>
                </div>
            </div>`;
        break;

        case "GoPay":
            html = `
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h6>💳 GoPay</h6>
                    <h5>081234567890</h5>
                    <small>A/N OCEAN HOTEL</small><br>
                    <button type="button"
                    class="btn btn-success btn-sm mt-2"
                    onclick="copyText('081234567890')">
                    Copy Nomor
                    </button>
                </div>
            </div>`;
        break;

        case "ShopeePay":
            html = `
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h6>💳 ShopeePay</h6>
                    <h5>081234567890</h5>
                    <small>A/N OCEAN HOTEL</small><br>
                    <button type="button"
                    class="btn btn-success btn-sm mt-2"
                    onclick="copyText('081234567890')">
                    Copy Nomor
                    </button>
                </div>
            </div>`;
        break;

        case "Bank BCA":
            html = `
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h6>🏦 Bank BCA</h6>
                    <p class="mb-1">No. Rekening</p>
                    <h5>1234567890</h5>
                    <small>A/N OCEAN HOTEL</small><br>
                    <button type="button"
                    class="btn btn-primary btn-sm mt-2"
                    onclick="copyText('1234567890')">
                    Copy Rekening
                    </button>
                </div>
            </div>`;
        break;

        case "Bank BRI":
            html = `
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h6>🏦 Bank BRI</h6>
                    <h5>9876543210</h5>
                    <small>A/N OCEAN HOTEL</small><br>
                    <button type="button"
                    class="btn btn-primary btn-sm mt-2"
                    onclick="copyText('9876543210')">
                    Copy Rekening
                    </button>
                </div>
            </div>`;
        break;

        case "Bank Mandiri":
            html = `
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h6>🏦 Bank Mandiri</h6>
                    <h5>1122334455</h5>
                    <small>A/N OCEAN HOTEL</small><br>
                    <button type="button"
                    class="btn btn-primary btn-sm mt-2"
                    onclick="copyText('1122334455')">
                    Copy Rekening
                    </button>
                </div>
            </div>`;
        break;

        case "Bank BNI":
            html = `
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h6>🏦 Bank BNI</h6>
                    <h5>5566778899</h5>
                    <small>A/N OCEAN HOTEL</small><br>
                    <button type="button"
                    class="btn btn-primary btn-sm mt-2"
                    onclick="copyText('5566778899')">
                    Copy Rekening
                    </button>
                </div>
            </div>`;
        break;

        case "Bayar di Hotel":
            html = `
            <div class="alert alert-warning">
                Pembayaran dilakukan langsung di hotel saat check-in.
            </div>`;
        break;

        default:
            html = "";
    }

    if(html==""){
        infoPembayaran.style.display="none";
    }else{
        infoPembayaran.style.display="block";
        infoPembayaran.innerHTML=html;
    }

});

function copyText(text){
    navigator.clipboard.writeText(text);
    alert("Berhasil disalin.");
}

</script>

<?php include '../templates/footer.php'; ?>