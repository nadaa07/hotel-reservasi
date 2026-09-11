
<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

$id_kamar = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = mysqli_query($conn, "SELECT * FROM kamar WHERE id_kamar='$id_kamar'");
$kamar = mysqli_fetch_assoc($query);

if (!$kamar) {
    echo "<script>
            alert('Data kamar tidak ditemukan!');
            window.location='index.php';
          </script>";
    exit;
}

if (isset($_POST['update'])) {

    $nomor_kamar     = $_POST['nomor_kamar'];
$tipe_kamar      = $_POST['tipe_kamar'];
$harga_per_malam = $_POST['harga_per_malam'];
$kapasitas       = $_POST['kapasitas'];
$fasilitas       = mysqli_real_escape_string($conn, $_POST['fasilitas']);
$status_kamar    = $_POST['status_kamar'];

    // upload foto baru
    if ($_FILES['foto_kamar']['name'] != '') {

        $foto_lama = "../../assets/uploads/foto_kamar/" . $kamar['foto_kamar'];

        if (file_exists($foto_lama)) {
            unlink($foto_lama);
        }

        $foto_kamar = time() . "_" . $_FILES['foto_kamar']['name'];

        move_uploaded_file(
            $_FILES['foto_kamar']['tmp_name'],
            "../../assets/uploads/foto_kamar/" . $foto_kamar
        );

    } else {

        $foto_kamar = $kamar['foto_kamar'];

    }

    mysqli_query($conn, "
    UPDATE kamar SET
        nomor_kamar='$nomor_kamar',
        tipe_kamar='$tipe_kamar',
        harga_per_malam='$harga_per_malam',
        kapasitas='$kapasitas',
        fasilitas='$fasilitas',
        status_kamar='$status_kamar',
        foto_kamar='$foto_kamar'
    WHERE id_kamar='$id_kamar'
");

    echo "<script>
            alert('Data kamar berhasil diperbarui!');
            window.location='index.php';
          </script>";
}

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="row">

    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">
            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary">
                Navigasi Admin
            </h5>

            <div class="list-group list-group-flush">
                <a href="../dashboard.php" class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-gauge me-2"></i> Dashboard
                </a>

                <a href="index.php" class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1">
                    <i class="fa-solid fa-bed me-2"></i> Kelola Data Kamar
                </a>
            </div>
        </div>
    </div>


    <div class="col-md-9">

        <div class="card card-ocean p-4">

            <div class="border-bottom pb-3 mb-4">
                <h4 class="fw-bold m-0">
                    <i class="fa-solid fa-pen-to-square me-2"></i>
                    Edit Kamar
                </h4>
            </div>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Nomor Kamar</label>
                    <input type="text"
                           name="nomor_kamar"
                           class="form-control"
                           value="<?= $kamar['nomor_kamar']; ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe Kamar</label>
                    <input type="text"
                           name="tipe_kamar"
                           class="form-control"
                           value="<?= $kamar['tipe_kamar']; ?>"
                           required>
                </div>

            
                <div class="mb-3">
                    <label class="form-label">Harga per Malam</label>
                    <input type="number"
                           name="harga_per_malam"
                           class="form-control"
                           value="<?= $kamar['harga_per_malam']; ?>"
                           required>
                </div>
                
                <div class="mb-3">
    <label class="form-label">Kapasitas</label>
    <input type="number"
           name="kapasitas"
           class="form-control"
           value="<?= $kamar['kapasitas']; ?>"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Fasilitas</label>
    <textarea name="fasilitas"
              class="form-control"
              rows="3"
              required><?= $kamar['fasilitas']; ?></textarea>
</div>

                <div class="mb-3">
                    <label class="form-label">Status Kamar</label>

                    <select name="status_kamar" class="form-select">

                        <option value="Tersedia"
                        <?= ($kamar['status_kamar']=='Tersedia') ? 'selected' : ''; ?>>
                            Tersedia
                        </option>

                        <option value="Terisi"
                        <?= ($kamar['status_kamar']=='Terisi') ? 'selected' : ''; ?>>
                            Terisi
                        </option>

                        <option value="Dipesan"
                        <?= ($kamar['status_kamar']=='Dipesan') ? 'selected' : ''; ?>>
                            Dipesan
                        </option>

                        <option value="Maintenance"
                        <?= ($kamar['status_kamar']=='Maintenance') ? 'selected' : ''; ?>>
                            Maintenance
                        </option>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Kamar Saat Ini</label><br>

                    <img src="<?= BASEURL; ?>assets/uploads/foto_kamar/<?= $kamar['foto_kamar']; ?>"
                         class="img-thumbnail"
                         width="200">
                </div>

                <div class="mb-4">
                    <label class="form-label">Ganti Foto Kamar</label>
                    <input type="file" name="foto_kamar" class="form-control">
                </div>

                <button type="submit"
                        name="update"
                        class="btn btn-warning rounded-pill px-4">

                    <i class="fa-solid fa-floppy-disk me-1"></i>
                    Simpan Perubahan

                </button>

                <a href="index.php"
                   class="btn btn-secondary rounded-pill px-4">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

<?php include '../../templates/footer.php'; ?>

