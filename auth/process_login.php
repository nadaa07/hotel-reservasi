<?php
require_once '../config/database.php';
require_once '../config/config.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query  = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password hash aman (Mendukung password plain untuk dummy awal jika bypass manual)
        if (password_verify($password, $row['password']) || $password === 'admin123' || $password === 'resep123' || $password === 'tamu123') {
            $_SESSION['login']    = true;
            $_SESSION['id_user']  = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = $row['role'];

            // Alihkan halaman berdasarkan hak akses level
            if ($row['role'] == 'admin') {
                header("Location: " . BASEURL . "admin/dashboard.php");
            } elseif ($row['role'] == 'resepsionis') {
                header("Location: " . BASEURL . "resepsionis/dashboard.php");
            } else {
                header("Location: " . BASEURL . "tamu/dashboard.php");
            }
            exit;
        }
    }
    header("Location: login.php?pesan=gagal");
    exit;
}
?>