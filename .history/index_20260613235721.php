<?php
require_once 'config/config.php';
include 'templates/header.php';
include 'templates/navbar.php';
?>

<!-- Custom CSS Khusus untuk Landing Page -->
<style>
    .hero-section {
        background: linear-gradient(135deg, var(--navy-dark) 0%, #2c3e50 100%);
        color: var(--white);
        padding: 100px 20px;
        text-align: center;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(29, 42, 58, 0.15);
        position: relative;
        overflow: hidden;
    }
    
    /* Dekorasi Ombak/Gelombang di Background Hero */
    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(163,138,95,0.05) 0%, transparent 60%);
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-family: 'Cinzel', 'Georgia', serif;
        font-size: 3.5rem;
        font-weight: 700;
        letter-spacing: 2px;
        margin-bottom: 15px;
        color: var(--white);
    }
    
    .hero-title span {
        color: var(--primary-brown);
    }

    .hero-subtitle {
        font-size: 1.1rem;
        font-weight: 300;
        margin-bottom: 40px;
        opacity: 0.9;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .feature-icon-wrapper {
        width: 80px;
        height: 80px;
        background-color: var(--bg-krem);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        border: 2px solid #EFECE6;
        transition: all 0.3s ease;
    }

    .feature-icon-wrapper i {
        font-size: 2rem;
        color: var(--primary-brown);
    }

    .feature-card:hover .feature-icon-wrapper {
        background-color: var(--primary-brown);
        border-color: var(--primary-brown);
    }

    .feature-card:hover .feature-icon-wrapper i {
        color: var(--white);
    }
</style>

<div class="hero-section mt-2 mx-2">
    <div class="container hero-content">
        <!-- Logo Icon Center -->
        <div class="d-flex justify-content-center mb-4">
            <div class="logo-badge" style="transform: scale(1.5);"></div>
        </div>
        
        <h1 class="hero-title">OCEAN <span>HOTEL</span></h1>
        <p class="hero-subtitle">Tinggalkan sejenak rutinitas Anda. Rasakan pengalaman menginap dengan kemewahan, ketenangan, dan pemandangan samudra yang memukau.</p>
        
        <div class="mt-4">
            <?php if(isset($_SESSION['login'])) : ?>
                <!-- Jika User Sudah Login -->
                <a href="<?= BASEURL; ?>index.php" class="btn btn-ocean btn-lg rounded-pill px-5 py-3 fw-bold shadow"><i class="fa-solid fa-gauge me-2"></i> Kembali ke Dashboard</a>
            <?php else : ?>
                <!-- Jika User Belum Login -->
                <a href="<?= BASEURL; ?>auth/register.php" class="btn btn-ocean btn-lg rounded-pill px-5 py-3 fw-bold shadow me-3 mb-2"><i class="fa-solid fa-calendar-check me-2"></i> Booking Sekarang</a>
                <a href="<?= BASEURL; ?>auth/login.php" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 fw-bold shadow mb-2">Masuk</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container mt-5 pt-5 mb-5">
    <div class="text-center mb-5 pb-3">
        <h2 class="fw-bold" style="font-family: 'Cinzel', serif; color: var(--navy-dark);">Fasilitas Kelas Dunia</h2>
        <div class="mx-auto mt-3" style="width: 80px; height: 3px; background-color: var(--primary-brown);"></div>
        <p class="text-muted mt-3">Layanan premium yang kami sediakan khusus untuk menemani masa liburan Anda.</p>
    </div>
    
    <div class="row g-4 text-center">
        <!-- Fitur 1 -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 feature-card" style="background-color: #fff;">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-bed"></i>
                </div>
                <h5 class="fw-bold text-dark">Kamar Eksklusif</h5>
                <p class="text-muted small mt-2 m-0">Desain interior modern dan elegan dilengkapi dengan fasilitas berstandar internasional untuk menjamin kualitas istirahat Anda.</p>
            </div>
        </div>
        
        <!-- Fitur 2 -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 feature-card" style="background-color: #fff;">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <h5 class="fw-bold text-dark">Restoran Premium</h5>
                <p class="text-muted small mt-2 m-0">Nikmati hidangan laut segar dan kuliner mancanegara yang disiapkan langsung oleh koki profesional kami kapan saja Anda mau.</p>
            </div>
        </div>
        
        <!-- Fitur 3 -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 feature-card" style="background-color: #fff;">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-spa"></i>
                </div>
                <h5 class="fw-bold text-dark">Pusat Relaksasi</h5>
                <p class="text-muted small mt-2 m-0">Segarkan tubuh dan pikiran Anda dengan layanan spa premium, kolam renang infinity, dan pusat kebugaran 24 jam.</p>
            </div>
        </div>
    </div>
</div>

<div class="card mx-2 mb-4 border-0 rounded-4" style="background-color: var(--primary-brown); color: var(--white);">
    <div class="card-body p-5 text-center">
        <h3 class="fw-bold" style="font-family: 'Cinzel', serif;">Siap untuk Merasakan Liburan Terbaik Anda?</h3>
        <p class="mb-4 opacity-75">Daftar sekarang dan dapatkan kemudahan reservasi kapan saja.</p>
        <a href="<?= BASEURL; ?>auth/register.php" class="btn btn-light text-dark fw-bold rounded-pill px-5 py-2">Mulai Registrasi Tamu</a>
    </div>
</div>

<?php include 'templates/footer.php'; ?>