<?php
require_once 'config/config.php';

// Jika sudah masuk/login, arahkan ke dashboard masing-masing secara otomatis
if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } elseif ($_SESSION['role'] == 'resepsionis') {
        header("Location: resepsionis/dashboard.php");
    } else {
        header("Location: tamu/dashboard.php");
    }
    exit;
} else {
    // Jika belum login, paksa ke halaman login
    header("Location: auth/login.php");
    exit;
}
?>