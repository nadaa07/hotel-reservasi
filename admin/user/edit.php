
<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

$id = $_GET['id'];

$query = mysqli_query($conn,"
SELECT *
FROM users
WHERE id_user='$id'
");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update']))
{
    $username = htmlspecialchars($_POST['username']);
    $role     = $_POST['role'];
    $password = $_POST['password'];

    // Jika password diisi
    if(!empty($password))
    {
        $password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn,"
        UPDATE users
        SET username='$username',
            password='$password',
            role='$role'
        WHERE id_user='$id'
        ");
    }
    else
    {
        mysqli_query($conn,"
        UPDATE users
        SET username='$username',
            role='$role'
        WHERE id_user='$id'
        ");
    }

    echo "
    <script>
        alert('Data user berhasil diperbarui!');
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

            <div class="border-bottom pb-3 mb-4">
                <h4 class="fw-bold">
                    <i class="fa-solid fa-user-pen me-2"></i>
                    Edit User
                </h4>
            </div>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Username
                    </label>

                    <input type="text"
                           name="username"
                           class="form-control"
                           value="<?= $data['username']; ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Password Baru
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control">

                    <small class="text-muted">
                        Kosongkan jika password tidak ingin diubah.
                    </small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        Role
                    </label>

                    <select name="role" class="form-select">

                        <option value="admin"
                        <?= ($data['role']=='admin') ? 'selected' : ''; ?>>
                            Admin
                        </option>

                        <option value="resepsionis"
                        <?= ($data['role']=='resepsionis') ? 'selected' : ''; ?>>
                            Resepsionis
                        </option>

                        <option value="tamu"
                        <?= ($data['role']=='tamu') ? 'selected' : ''; ?>>
                            Tamu
                        </option>

                    </select>
                </div>

                <button type="submit"
                        name="update"
                        class="btn btn-success">
                    <i class="fa-solid fa-save me-1"></i>
                    Simpan Perubahan
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
