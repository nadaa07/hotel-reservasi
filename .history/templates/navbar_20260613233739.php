<nav class="navbar navbar-expand-lg navbar-ocean sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand ocean-logo-container" href="<?= BASEURL; ?>">
            <div class="logo-badge"></div>
            <div class="logo-text-wrapper">
                <span class="logo-title">Ocean</span>
                <span class="logo-subtitle">✦ Hotel ✦</span>
            </div>
        </a>
        
        <button class="navbar-toggler" type="text/javascript" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <?php if(isset($_SESSION['login'])) : ?>
                    <li class="nav-item">
                        <span class="nav-link text-dark me-3"><i class="fa-solid fa-user-circle me-1"></i> Halo, <strong><?= $_SESSION['username']; ?></strong> (<?= ucfirst($_SESSION['role']); ?>)</span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger btn-sm rounded-pill px-3" href="<?= BASEURL; ?>auth/logout.php"><i class="fa-solid fa-sign-out-alt me-1"></i> Keluar</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark me-2" href="<?= BASEURL; ?>auth/login.php">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-ocean rounded-pill px-4" href="<?= BASEURL; ?>auth/register.php">Daftar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container my-4">