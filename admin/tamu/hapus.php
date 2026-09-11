<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

// Cek apakah id dikirim
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id_tamu = (int) $_GET['id'];

// Hapus data tamu
mysqli_query($conn, "DELETE FROM tamu WHERE id_tamu='$id_tamu'");

// Kembali ke halaman data tamu
echo "
<script>
    alert('Data tamu berhasil dihapus!');
    window.location='index.php';
</script>
";
?>