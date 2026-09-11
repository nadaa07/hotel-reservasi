
<?php
session_start();

require_once '../../config/database.php';
require_once '../../config/config.php';

cek_akses('admin');

$chart = mysqli_query($conn,"
SELECT DATE(tgl_bayar) as tanggal,
SUM(total_bayar) as total
FROM pembayaran
WHERE status_verifikasi='valid'
GROUP BY DATE(tgl_bayar)
ORDER BY tanggal ASC
");

$tanggal = [];
$total_bayar = [];

while($c = mysqli_fetch_assoc($chart))
{
    $tanggal[] = $c['tanggal'];
    $total_bayar[] = $c['total'];
}

/* ======================
   DATA GRAFIK BULANAN
====================== */

$chart_bulanan = mysqli_query($conn,"
SELECT
DATE_FORMAT(tgl_bayar,'%M %Y') AS bulan,
SUM(total_bayar) AS total
FROM pembayaran
WHERE status_verifikasi='valid'
GROUP BY YEAR(tgl_bayar), MONTH(tgl_bayar)
ORDER BY YEAR(tgl_bayar), MONTH(tgl_bayar)
");

$bulan = [];
$total_bulan = [];

while($b = mysqli_fetch_assoc($chart_bulanan))
{
    $bulan[] = $b['bulan'];
    $total_bulan[] = $b['total'];
}


/* ======================
   DATA PENDAPATAN
====================== */

$query = mysqli_query($conn,"
SELECT
pembayaran.*,
reservasi.kode_reservasi,
tamu.nama_lengkap
FROM pembayaran
JOIN reservasi
ON pembayaran.id_reservasi = reservasi.id_reservasi
JOIN tamu
ON reservasi.id_tamu = tamu.id_tamu
WHERE pembayaran.status_verifikasi='valid'
ORDER BY pembayaran.id_pembayaran DESC
");

/* ======================
   TOTAL PENDAPATAN
====================== */

$total = mysqli_query($conn,"
SELECT SUM(total_bayar) AS total_pendapatan
FROM pembayaran
WHERE status_verifikasi='valid'
");

$total_data = mysqli_fetch_assoc($total);

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<style>
.chart-card{
    height:320px;
}

.chart-card canvas{
    width:100% !important;
    height:240px !important;
}
</style>

<div class="container mt-4">

    <div class="card shadow p-4">

        <h3 class="mb-4">
            Laporan Pendapatan
        </h3>

        <!-- ======================
     TOGGLE GRAFIK BUTTON
====================== -->

<button class="btn btn-primary mb-3" onclick="toggleChart()">
    📊 Lihat Grafik Pendapatan
</button>

<!-- ======================
     CHART AREA (HIDDEN DEFAULT)
====================== -->

<div id="chartBox" style="display:none;" class="mb-4">

    <div class="row">

        <!-- Grafik Harian -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    📊 Pendapatan Harian
                </div>

                <div class="card-body">
                    <canvas id="pendapatanChart" height="220"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Bulanan -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    📈 Pendapatan Bulanan
                </div>

                <div class="card-body">
                    <canvas id="pendapatanBulanan" height="220"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>
        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>No</th>
                        <th>Kode Pembayaran</th>
                        <th>Nama Tamu</th>
                        <th>Kode Reservasi</th>
                        <th>Metode Pembayaran</th>
                        <th>Tanggal Bayar</th>
                        <th>Total Bayar</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while($row = mysqli_fetch_assoc($query)):
                ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td><?= $row['kode_pembayaran']; ?></td>

                        <td><?= $row['nama_lengkap']; ?></td>

                        <td><?= $row['kode_reservasi']; ?></td>

                        <td><?= $row['metode_pembayaran']; ?></td>

                        <td>
                            <?= date('d-m-Y', strtotime($row['tgl_bayar'])); ?>
                        </td>

                        <td class="text-success fw-bold">
                            Rp <?= number_format($row['total_bayar'],0,',','.'); ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

        <hr>

        <div class="text-end">

            <h4 class="fw-bold text-success">

                Total Pendapatan :
                Rp <?= number_format($total_data['total_pendapatan'],0,',','.'); ?>

            </h4>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('pendapatanChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($tanggal); ?>,
        datasets: [{
            label: 'Pendapatan Harian',
            data: <?= json_encode($total_bayar); ?>,
            backgroundColor: 'rgba(13,110,253,0.7)',
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const ctx2 = document.getElementById('pendapatanBulanan');

new Chart(ctx2, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulan); ?>,
        datasets: [{
            label: 'Pendapatan Bulanan',
            data: <?= json_encode($total_bulan); ?>,
            borderColor: 'green',
            backgroundColor: 'rgba(25,135,84,0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        scales:{
            y:{
                beginAtZero:true
            }
        }
    }
});

/* TOGGLE SHOW/HIDE */
function toggleChart()
{
    const box = document.getElementById('chartBox');

    if(box.style.display === "none")
    {
        box.style.display = "block";
    }
    else
    {
        box.style.display = "none";
    }
}
</script>
<?php include '../../templates/footer.php'; ?>