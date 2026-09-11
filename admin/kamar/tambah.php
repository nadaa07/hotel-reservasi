<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

if (isset($_POST['simpan'])) {
    $nomor_kamar     = mysqli_real_escape_string($conn, $_POST['nomor_kamar']);
    $tipe_kamar      = $_POST['tipe_kamar'];
    $harga_per_malam = $_POST['harga_per_malam'];
    $kapasitas       = $_POST['kapasitas'];
    $fasilitas       = mysqli_real_escape_string($conn, $_POST['fasilitas']);
    $status_kamar    = $_POST['status_kamar'];
    
    $foto_kamar = 'default_kamar.jpg'; // Nilai default

    // Proses Upload Foto
    if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != '') {
        $nama_file = $_FILES['foto']['name'];
        $tmp_file  = $_FILES['foto']['tmp_name'];
        $ext_boleh = array('png', 'jpg', 'jpeg');
        $x         = explode('.', $nama_file);
        $ekstensi  = strtolower(end($x));
        $nama_baru = "kamar_" . time() . "." . $ekstensi;
        
        if (in_array($ekstensi, $ext_boleh) === true) {
            $dir = "../../assets/uploads/foto_kamar/";
            move_uploaded_file($tmp_file, $dir . $nama_baru);
            $foto_kamar = $nama_baru;
        } else {
            echo "<script>alert('Ekstensi gambar hanya boleh JPG/PNG!'); window.location='tambah.php';</script>";
            exit;
        }
    }

    $query = "INSERT INTO kamar (nomor_kamar, tipe_kamar, harga_per_malam, kapasitas, fasilitas, foto_kamar, status_kamar) 
              VALUES ('$nomor_kamar', '$tipe_kamar', '$harga_per_malam', '$kapasitas', '$fasilitas', '$foto_kamar', '$status_kamar')";
              
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data kamar berhasil ditambahkan!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
}

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-ocean p-4">
            <h4 class="fw-bold mb-4 border-bottom pb-2">Tambah Data Kamar Baru</h4>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Nomor Kamar</label>
                        <input type="text" name="nomor_kamar" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Tipe Kamar</label>
                        <select name="tipe_kamar" class="form-select" required>
                            <option value="Standard">Standard</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Suite">Suite</option>
                            <option value="Vip">Vip</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Harga Per Malam (Rp)</label>
                        <input type="number" name="harga_per_malam" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Kapasitas (Orang)</label>
                        <input type="number" name="kapasitas" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small">Fasilitas</label>
                    <textarea name="fasilitas" class="form-control" rows="3" required placeholder="Pisahkan dengan koma (Contoh: AC, TV, WiFi)"></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Status Kamar</label>
                        <select name="status_kamar" class="form-select" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold small">Upload Foto Kamar</label>
                        <input type="file" name="foto" class="form-control" accept=".jpg, .jpeg, .png">
                        <small class="text-muted">Abaikan jika menggunakan foto default.</small>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-outline-secondary px-4">Batal</a>
                    <button type="submit" name="simpan" class="btn btn-ocean px-5">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../templates/footer.php'; ?>