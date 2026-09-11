<?php
session_start();

require_once '../../config/database.php';
require_once '../../config/config.php';

cek_akses('admin');

$query = mysqli_query($conn,"
SELECT
reservasi.*,
tamu.nama_lengkap,
kamar.nomor_kamar,
kamar.tipe_kamar
FROM reservasi
JOIN tamu ON reservasi.id_tamu = tamu.id_tamu
JOIN kamar ON reservasi.id_kamar = kamar.id_kamar
ORDER BY reservasi.id_reservasi DESC
");

$total_pendapatan = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Reservasi Hotel</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f6f9;
            padding:20px;
        }

        .header{
            background:#0d1b2a;
            color:white;
            padding:20px;
            border-radius:10px;
            text-align:center;
        }

        .header h2{
            margin:0;
            font-size:22px;
            letter-spacing:1px;
        }

        .header small{
            opacity:0.8;
        }

        .info-box{
            margin:15px 0;
            display:flex;
            justify-content:space-between;
            font-size:13px;
            color:#333;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:10px;
            overflow:hidden;
        }

        th{
            background:#1b263b;
            color:white;
            padding:10px;
            font-size:12px;
        }

        td{
            padding:10px;
            font-size:12px;
            border-bottom:1px solid #eee;
            text-align:center;
        }

        tr:hover{
            background:#f1f5f9;
        }

        .badge{
            padding:4px 8px;
            border-radius:6px;
            font-size:11px;
            color:white;
        }

        .pending{background:#f59e0b;}
        .konfirmasi{background:#10b981;}
        .selesai{background:#3b82f6;}

        .footer{
            margin-top:20px;
            display:flex;
            justify-content:space-between;
            font-size:12px;
            color:#555;
        }

        .total-box{
            margin-top:15px;
            background:#0d1b2a;
            color:white;
            padding:10px;
            border-radius:8px;
            text-align:right;
            font-weight:bold;
        }

        @media print{
            body{background:white;}
        }
    </style>
</head>

<body>

<!-- HEADER -->
<div class="header">

    <div style="display:flex;align-items:center;justify-content:center;gap:15px;">

        <!-- LOGO -->
        <div style="
            width:55px;
            height:55px;
            border-radius:50%;
            background:#1b263b;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
            color:white;
            font-weight:bold;
            border:2px solid #fff;
        ">
            H
        </div>

        <!-- TEXT -->
        <div>
            <h2 style="margin:0;">HOTEL OCEAN RESERVATION</h2>
            <small style="opacity:0.85;">
                Sistem Manajemen Reservasi Hotel
            </small>
        </div>

    </div>

</div>
<!-- INFO -->
<div class="info-box">
    <div>
        📅 Tanggal: <?= date('d-m-Y'); ?>
    </div>
    <div>
        👨‍💼 Admin: <?= $_SESSION['username'] ?? 'Admin'; ?>
    </div>
</div>

<!-- TABLE -->
<table>
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Nama Tamu</th>
        <th>Kamar</th>
        <th>Tipe</th>
        <th>Check In</th>
        <th>Check Out</th>
        <th>Malam</th>
        <th>Total</th>
        <th>Status</th>
    </tr>

<?php $no=1; while($row=mysqli_fetch_assoc($query)): ?>

<?php
$total_pendapatan += $row['total_harga'];

$status = $row['status_reservasi'];

if($status=="Pending") $badge="pending";
elseif($status=="Dikonfirmasi") $badge="konfirmasi";
else $badge="selesai";
?>

<tr>
    <td><?= $no++; ?></td>
    <td><?= $row['kode_reservasi']; ?></td>
    <td><?= $row['nama_lengkap']; ?></td>
    <td><?= $row['nomor_kamar']; ?></td>
    <td><?= $row['tipe_kamar']; ?></td>
    <td><?= $row['tgl_checkin']; ?></td>
    <td><?= $row['tgl_checkout']; ?></td>
    <td><?= $row['jumlah_malam']; ?></td>
    <td>Rp <?= number_format($row['total_harga'],0,',','.'); ?></td>
    <td>
        <span class="badge <?= $badge; ?>">
            <?= $status; ?>
        </span>
    </td>
</tr>

<?php endwhile; ?>

</table>

<!-- TOTAL -->
<div class="total-box">
    Total Pendapatan: Rp <?= number_format($total_pendapatan,0,',','.'); ?>
</div>

<!-- FOOTER -->
<div class="footer">
    <div>System Hotel Management</div>
    <div>Tanda Tangan Admin: __________</div>
</div>

<script>
window.print();
</script>

</body>
</html>