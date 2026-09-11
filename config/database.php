<?php
$host = "sql307.infinityfree.com";
$user = "if0_42852125";
$pass = "sAjqSaLheW";
$db   = "if0_42852125_hotel_reservasi";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>