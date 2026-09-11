
<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

if (isset($_POST['simpan'])) {

    $nik            = $_POST['nik'];
    $nama_lengkap   = $_POST['nama_lengkap'];
    $jenis_kelamin  = $_POST['jenis_kelamin'];
    $no_hp          = $_POST['no_hp'];
    $email          = $_POST['email'];
    $alamat         = $_POST['alamat'];

    mysqli_query($conn, "
        INSERT INTO tamu
        (
            nik,
            nama_lengkap,
            jenis_kelamin,
            no_hp,
            email,
            alamat
        )
        VALUES
        (
            '$nik',
            '$nama_lengkap',
            '$jenis_kelamin',
            '$no_hp',
            '$email',
            '$alamat'
        )
    ");

    echo "
    <script>
        alert('Data tamu berhasil ditambahkan!');
        window.location='index.php';
    </script>";
}

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">

            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary">
                Navigasi Admin
            </h5>

            <div class="list-group list-group-flush">

                <a href="../dashboard.php"
                   class="list-group-item list-group-item-action rounded-3 mb-1">
                    <i class="fa-solid fa-gauge me-2"></i>
                    Dashboard
                </a>

                <a href="index.php"
                   class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1">
                    <i class="fa-solid fa-users me-2"></i>
                    Kelola Data Tamu
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
                    Tambah Data Tamu
                </h4>
            </div>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text"
                           name="nik"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text"
                           name="nama_lengkap"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>

                    <select name="jenis_kelamin"
                            class="form-select"
                            required>

                        <option value="">-- Pilih Jenis Kelamin --</option>

                        <option value="Laki-laki">
                            Laki-laki
                        </option>

                        <option value="Perempuan">
                            Perempuan
                        </option>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text"
                           name="no_hp"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Alamat</label>

                    <textarea name="alamat"
                              rows="4"
                              class="form-control"></textarea>
                </div>

                <button type="submit"
                        name="simpan"
                        class="btn btn-success rounded-pill px-4">

                    <i class="fa-solid fa-floppy-disk me-1"></i>
                    Simpan

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

