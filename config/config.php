<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Base URL (Sesuaikan dengan nama folder proyek Anda di htdocs)
define('BASEURL', 'https://hoteloce.free.je/');

// Helper untuk proteksi halaman berdasarkan role
function cek_akses($role_wajib) {
    if (!isset($_SESSION['login'])) {
        header("Location: " . BASEURL . "auth/login.php");
        exit;
    }
    if ($_SESSION['role'] !== $role_wajib) {
        header("Location: " . BASEURL . "index.php?pesan=denied");
        exit;
    }
}
?>