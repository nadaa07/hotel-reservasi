<?php
require_once 'config/config.php';
require_once 'config/database.php';
include 'templates/header.php';
include 'templates/navbar.php';
?>

<!-- Custom CSS Khusus untuk Landing Page -->
<style>
    html{
        scroll-behavior: smooth;
    }
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
    
    .section-title{
    font-family:'Cinzel',serif;
    color:var(--navy-dark);
    font-size:38px;
    font-weight:700;
    margin-bottom:15px;
}

.facility-card{

    background:#fff;

    border-radius:20px;

    padding:40px 25px;

    text-align:center;

    transition:.35s;

    box-shadow:0 10px 25px rgba(0,0,0,.08);

    height:100%;
}

.facility-card:hover{

    transform:translateY(-8px);

    box-shadow:0 20px 40px rgba(0,0,0,.12);

}

.facility-card i{

    font-size:48px;

    color:var(--primary-brown);

    margin-bottom:20px;

}

.facility-card h4{

    font-weight:700;

    margin-bottom:15px;

    color:var(--navy-dark);

}

.facility-card p{

    color:#666;

    line-height:1.7;

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

   .hotel-about{
    width:100%;
    height:420px;
    object-fit:cover;
    border-radius:20px;
    transition:.4s;
}

.about-Text{
    font-size:17px;
    line-height:1.9;
    color:#666;
    margin-bottom:18px;
}

.hotel-about:hover{
    transform:scale(1.02);
    box-shadow:0 20px 50px rgba(0,0,0,.2);
}

.about-info{
    background:#fff;
    width:85%;
    margin:-45px auto 0;
    padding:20px;
    border-radius:18px;
    box-shadow:0 12px 30px rgba(0,0,0,.12);
    position:relative;
    z-index:10;
}

.about-info .row{
    row-gap:15px;
}

.about-info small{
    font-size:15px;
    color:#555;
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

    /* Premium Divider */
.section-divider{
    width:90px;
    height:4px;
    background:linear-gradient(to right,#d4b483,#1d2a3a,#d4b483);
    margin:0 auto 25px;
    border-radius:50px;
}

.about-stat{

    background:white;

    border-radius:18px;

    padding:20px;

    text-align:center;

    box-shadow:0 8px 20px rgba(0,0,0,.08);

    transition:.3s;
}

.about-stat:hover{

    transform:translateY(-6px);

}

.about-stat h3{

    color:var(--primary-brown);

    font-size:36px;

    font-weight:700;
}

/* Background Cream */
.bg-soft{
    background:#f8f6f2;
}

/* Hover Card Kamar */
.room-card{
    overflow:hidden;
    transition:.4s;
}

.room-card:hover{
    transform:translateY(-10px);
    box-shadow:0 20px 45px rgba(0,0,0,.15);
}

.room-card img{
    transition:.5s;
}

.room-card:hover img{
    transform:scale(1.08);
}

/* =========================
   Navbar Ocean Hotel
========================= */

.navbar-ocean{
    padding:16px 30px;
}

.btn-ocean{
    transition:.3s ease;
}

.btn-ocean:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(180,148,93,.3);
}

.navbar-nav .nav-link{
    position:relative;
    color:var(--navy-dark);
    font-weight:500;
    font-size:17px;
    margin:0 12px;
    transition:all .3s ease;
}

/* Garis bawah */
.navbar-nav .nav-link::after{
    content:"";
    position:absolute;
    left:50%;
    bottom:-6px;
    width:0;
    height:3px;
    background:linear-gradient(to right,#d4b483,#b8945d);
    border-radius:20px;
    transform:translateX(-50%);
    transition:.35s ease;
}

/* Hover */
.navbar-nav .nav-link:hover{
    color:var(--primary-brown);
}

.navbar-nav .nav-link:hover::after{
    width:70%;
}
</style>

<!-- ================= HERO ================= -->

<section id="home" class="hero-section mx-2">

<div class="container hero-content">

<div class="d-flex justify-content-center mb-4">
<div class="logo-badge" style="transform:scale(1.5);"></div>
</div>

<h1 class="hero-title">
OCEAN <span>HOTEL</span>
</h1>

<p class="hero-subtitle">
Tinggalkan sejenak rutinitas Anda.
Rasakan pengalaman menginap dengan kemewahan,
ketenangan dan panorama laut yang memukau.
</p>


<div class="mt-4">

<?php if(isset($_SESSION['login'])) : ?>

<a href="<?= BASEURL; ?>index.php"
class="btn btn-ocean btn-lg rounded-pill px-5 py-3 fw-bold shadow">

Dashboard

</a>

<?php else : ?>

<a href="<?= BASEURL; ?>auth/register.php"
class="btn btn-ocean btn-lg rounded-pill px-5 py-3 fw-bold shadow me-3">

Booking Sekarang

</a>

<a href="<?= BASEURL; ?>auth/login.php"
class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 fw-bold">

Masuk

</a>

<?php endif; ?>

</div>

</div>

</section>

<!-- ================= TENTANG ================= -->

<section id="tentang" class="container py-5">

    <div class="row align-items-center">

        <!-- Kiri -->
        <div class="col-lg-6">

            <div class="section-divider"></div>

            <h2 class="fw-bold mb-4"
                style="font-family:'Cinzel',serif;color:var(--navy-dark);">

                Tentang Ocean Hotel

            </h2>

            <p class="about-Text">
                Ocean Hotel merupakan hotel modern yang menghadirkan
                kenyamanan, kemewahan, serta pelayanan terbaik untuk
                memberikan pengalaman menginap yang tak terlupakan.
            </p>

            <p class="about-Text">
                Kami menyediakan berbagai tipe kamar, restoran premium,
                infinity pool, luxury spa, fitness center,
                serta pelayanan profesional 24 jam yang siap memenuhi
                kebutuhan setiap tamu.
            </p>

            <div class="row mt-4">

                <div class="col-6 mb-3">
                   <div class="about-stat">
                        <h3>5★</h3>
                        <small class="text-muted">Hotel Bintang 5</small>
                    </div>
                </div>

                <div class="col-6 mb-3">
                    <div class="about-stat">
                        <h3>24/7</h3>
                        <small class="text-muted">Pelayanan</small>
                    </div>
                </div>

                <div class="col-6">
                    <div class="about-stat">
                        <h3>100+</h3>
                        <small class="text-muted">Kamar Premium</small>
                    </div>
                </div>

                <div class="col-6">
                    <div class="about-stat">
                        <h3> 5000+</h3>
                        <small class="text-muted">Tamu Puas</small>
                    </div>
                </div>

            </div>

        </div>

        <!-- Kanan -->
        <div class="col-lg-6">

            <img
                src="<?= BASEURL; ?>assets/img/hotel/hotelpantai.jpeg"
                class="img-fluid rounded-4 shadow-lg hotel-about">

            <div class="about-info">

    <div class="about-info text-center">

    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">
        ⭐ Luxury Beach Resort
    </span>

    <h5 class="fw-bold mb-2">
        Ocean Hotel
    </h5>

    <p class="text-muted mb-0">
        Ocean View • Infinity Pool • Fine Dining
    </p>

</div>

            </div>

        </div>

    </div>

</section>

<!-- ================= FASILITAS ================= -->

<section id="fasilitas" class="py-5 bg-soft">
<div class="container">
<div class="text-center mb-5">

<h2 class="section-title">
    <div class="section-divider"></div>
Fasilitas Kelas Dunia
</h2>

<p class="text-muted">
Nikmati berbagai fasilitas premium yang dirancang untuk memberikan pengalaman menginap terbaik.
</p>

</div>

<div class="row g-4">

<!-- Card -->
<div class="col-md-4">
<div class="facility-card">

<i class="fa-solid fa-water-ladder"></i>

<h4>Infinity Pool</h4>

<p>
Kolam renang dengan panorama laut yang menenangkan.
</p>

</div>
</div>

<!-- Card -->
<div class="col-md-4">
<div class="facility-card">

<i class="fa-solid fa-utensils"></i>

<h4>Restaurant</h4>

<p>
Menu lokal dan internasional dari chef profesional.
</p>

</div>
</div>

<!-- Card -->
<div class="col-md-4">
<div class="facility-card">

<i class="fa-solid fa-spa"></i>

<h4>Luxury Spa</h4>

<p>
Spa eksklusif untuk relaksasi tubuh dan pikiran.
</p>

</div>
</div>

<!-- Card -->
<div class="col-md-4">
<div class="facility-card">

<i class="fa-solid fa-dumbbell"></i>

<h4>Fitness Center</h4>

<p>
Gym modern yang buka selama 24 jam.
</p>

</div>
</div>

<!-- Card -->
<div class="col-md-4">
<div class="facility-card">

<i class="fa-solid fa-square-parking"></i>

<h4>Free Parking</h4>

<p>
Area parkir luas dengan keamanan selama 24 jam.
</p>

</div>
</div>

<!-- Card -->
<div class="col-md-4">
<div class="facility-card">

<i class="fa-solid fa-wifi"></i>

<h4>High Speed WiFi</h4>

<p>
Internet cepat tersedia di seluruh area hotel.
</p>

</div>
</div>

</div>
</div>

</section>

<!-- ================= KAMAR ================= -->


<section id="kamar" class="container py-5">

    <div class="text-center mb-5">

        <div class="section-divider"></div>

        <h2 class="fw-bold"
            style="font-family:'Cinzel',serif;color:var(--navy-dark);">
            Pilihan Kamar
        </h2>

        <p class="text-muted">
            Temukan berbagai tipe kamar terbaik yang kami sediakan.
        </p>

    </div>

    <div class="row">

    <?php

    $queryKamar = mysqli_query($conn,"
    SELECT *
    FROM kamar k1
    WHERE id_kamar = (
        SELECT MIN(id_kamar)
        FROM kamar k2
        WHERE k2.tipe_kamar = k1.tipe_kamar
    )
    ORDER BY id_kamar ASC
    ");

    while($kamar = mysqli_fetch_assoc($queryKamar)) :

    ?>

    <div class="col-md-4 mb-4">

        <div class="card border-0 shadow rounded-4 h-100 room-card">

            <?php if(!empty($kamar['foto_kamar'])) : ?>

                <img
                src="<?= BASEURL; ?>assets/uploads/foto_kamar/<?= $kamar['foto_kamar']; ?>"
                class="card-img-top"
                style="height:230px;object-fit:cover;">

            <?php else : ?>

                <div class="d-flex justify-content-center align-items-center bg-light"
                style="height:230px;">

                    <i class="fa-solid fa-image fa-3x text-secondary"></i>

                </div>

            <?php endif; ?>

            <div class="card-body p-4">

                <span class="badge bg-dark mb-2">
                    <?= $kamar['tipe_kamar']; ?>
                </span>

                <h5 class="fw-bold mb-3">
                    <?= $kamar['tipe_kamar']; ?> Room
                </h5>

                <p class="text-muted small mb-4">
                    <?= $kamar['fasilitas']; ?>
                </p>

                <h4 class="fw-bold text-success mb-3">
                    Rp <?= number_format($kamar['harga_per_malam'],0,',','.'); ?>
                    <span class="fs-6 text-muted">/ malam</span>
                </h4>

                <?php if(isset($_SESSION['login'])) : ?>

                    <a href="<?= BASEURL; ?>user/reservasi.php"
                       class="btn btn-ocean w-100 rounded-pill fw-bold py-2">
                        Booking Sekarang
                    </a>

                <?php else : ?>

                    <a href="<?= BASEURL; ?>auth/register.php"
                       class="btn btn-ocean w-100 rounded-pill fw-bold py-2">
                        Booking Sekarang
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <?php endwhile; ?>

    </div>

</section>

<!-- kontak -->
 <section id="kontak" class="py-5 bg-soft">

<div class="container">

    <div class="text-center mb-5">
        <h2 class="section-title">Hubungi Kami</h2>
        <div class="section-divider"></div>
        <p class="text-muted">
            Kami siap membantu kebutuhan reservasi Anda kapan saja.
        </p>
    </div>

    <div class="row">

        <!-- Informasi Kontak -->
        <div class="col-lg-5">

            <div class="contact-card">

                <h3>Ocean Hotel</h3>

                <hr>

                <p>
                    <i class="fa-solid fa-location-dot me-2"></i>
                    Jl. Pantai Indah No.123, Bali
                </p>

                <p>
                    <i class="fa-solid fa-phone me-2"></i>
                    +62 831-7969-4152
                </p>

                <p>
                    <i class="fa-solid fa-envelope me-2"></i>
                    info@oceanhotel.com
                </p>

                <p>
                    <i class="fa-solid fa-clock me-2"></i>
                    Buka 24 Jam
                </p>

                <a href="https://wa.me/6283179694152"
                   class="btn btn-success rounded-pill mt-3">
                    <i class="fa-brands fa-whatsapp"></i>
                    Chat WhatsApp
                </a>

            </div>

        </div>

        <!-- Google Maps -->
        <div class="col-lg-7">

            <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow">

                <iframe
                src="https://www.google.com/maps?q=Bali&output=embed"
                loading="lazy"
                allowfullscreen>
                </iframe>

            </div>

        </div>

    </div>
</div>

</section>
<!-- ================= CTA ================= -->

<div class="card mx-2 mb-4 border-0 rounded-4"
style="background:var(--primary-brown);color:white;">

<div class="card-body p-5 text-center">

<h3 class="fw-bold">

Siap Merasakan Liburan Terbaik?

</h3>

<p>

Daftar sekarang dan nikmati pengalaman menginap terbaik di Ocean Hotel.

</p>

<a href="<?= BASEURL; ?>auth/register.php"
class="btn btn-light rounded-pill px-5">

Mulai Registrasi

</a>

</div>

</div>
<?php include 'templates/footer.php'; ?>