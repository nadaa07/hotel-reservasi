
<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

$id = $_GET['id'];

// Cegah admin menghapus akun sendiri
if($id == $_SESSION['id_user'])
{
    echo "
    <script>
        alert('Anda tidak dapat menghapus akun yang sedang digunakan!');
        window.location='index.php';
    </script>
    ";
    exit;
}

// Hapus data user
mysqli_query($conn,"
DELETE FROM users
WHERE id_user='$id'
");

echo "
<script>
    alert('Data user berhasil dihapus!');
    window.location='index.php';
</script>
";
?>

