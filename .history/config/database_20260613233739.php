<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "hotel_reservasi";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>