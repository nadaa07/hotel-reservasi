<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

if(isset($_POST['simpan']))
{
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    mysqli_query($conn,"
    INSERT INTO users(username,password,role)
    VALUES('$username','$password','$role')
    ");

    echo "
    <script>
        alert('User berhasil ditambahkan!');
        window.location='index.php';
    </script>
    ";
}

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">

            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary"
            style="font-size:0.85rem;letter-spacing:1px;">
                Navigasi Admin
            </h5>

            <div class="list-group list-group-flush">

                <a href="../dashboard.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-gauge me-2"></i>
                    Dashboard
                </a>

                <a href="index.php"
                class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-user me-2"></i>
                    Kelola User
                </a>

            </div>

        </div>
    </div>

    <!-- Konten -->
    <div class="col-md-9">

        <div class="card card-ocean p-4">

            <div class="border-bottom pb-3 mb-4">
                <h4 class="fw-bold">
                    <i class="fa-solid fa-user-plus me-2"></i>
                    Tambah User
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
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">
                        Role
                    </label>

                    <select name="role"
                            class="form-select"
                            required>

                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="resepsionis">Resepsionis</option>
                        <option value="tamu">Tamu</option>

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

                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

<?php include '../../templates/footer.php'; ?>