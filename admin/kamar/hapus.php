
<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

$id_kamar = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data kamar
$query = mysqli_query($conn, "SELECT * FROM kamar WHERE id_kamar='$id_kamar'");
$kamar = mysqli_fetch_assoc($query);

if (!$kamar) {
    echo "<script>
            alert('Data kamar tidak ditemukan!');
            window.location='index.php';
          </script>";
    exit;
}

// Hapus foto jika ada
if (!empty($kamar['foto_kamar'])) {

    $path_foto = "../../assets/uploads/foto_kamar/" . $kamar['foto_kamar'];

    if (file_exists($path_foto)) {
        unlink($path_foto);
    }
}

// Hapus data kamar dari database
mysqli_query($conn, "DELETE FROM kamar WHERE id_kamar='$id_kamar'");

echo "<script>
        alert('Data kamar berhasil dihapus!');
        window.location='index.php';
      </script>";
?>

