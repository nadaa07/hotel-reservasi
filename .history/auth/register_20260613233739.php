<?php 
require_once '../config/config.php';
include '../templates/header.php'; 
?>

<div class="row justify-content-center my-5">
    <div class="col-md-6">
        <div class="card card-ocean p-4 shadow-sm">
            <div class="text-center mb-4">
                <div class="logo-badge mx-auto mb-2"></div>
                <h4 class="logo-title">REGISTRASI TAMU</h4>
                <p class="text-muted small">Buat akun baru untuk mulai reservasi</p>
            </div>

            <form action="process_register.php" method="POST">
                <h6 class="fw-bold border-bottom pb-2 mb-3 text-secondary"><i class="fa-solid fa-lock me-2"></i>Informasi Akun</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>

                <h6 class="fw-bold border-bottom pb-2 mb-3 text-secondary mt-3"><i class="fa-solid fa-user me-2"></i>Data Diri Lengkap</h6>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" name="nik" class="form-control" placeholder="16 Digit NIK" max-length="16" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama sesuai KTP" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" strict required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 0812345xxx" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="alamat@email.com" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Alamat Rumah</label>
                    <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap saat ini" required></textarea>
                </div>

                <button type="submit" name="register" class="btn btn-ocean w-100 py-2 rounded-3 mb-3">Daftar Sekarang</button>
            </form>
            <div class="text-center">
                <small class="text-muted">Sudah punya akun? <a href="login.php" class="text-decoration-none" style="color: var(--primary-brown);">Login di sini</a></small>
            </div>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>