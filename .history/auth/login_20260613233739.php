<?php 
require_once '../config/config.php';
include '../templates/header.php'; 
?>

<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="col-md-4">
        <div class="card card-ocean p-4 shadow-sm">
            <div class="text-center mb-4">
                <div class="logo-badge mx-auto mb-2"></div>
                <h4 class="logo-title">OCEAN HOTEL</h4>
                <p class="text-muted small">Masuk ke Sistem Reservasi</p>
            </div>

            <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
                <div class="alert alert-danger text-center py-2 small" role="alert">Username atau password salah!</div>
            <?php endif; ?>

            <form action="process_login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" name="login" class="btn btn-ocean w-100 py-2 rounded-3 mb-3">Sign In</button>
            </form>
            <div class="text-center">
                <small class="text-muted">Belum punya akun? <a href="register.php" class="text-decoration-none" style="color: var(--primary-brown);">Daftar di sini</a></small>
            </div>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>