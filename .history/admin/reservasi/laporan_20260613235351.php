<?php
require_once '../../config/database.php';
require_once '../../config/config.php';
cek_akses('admin');

// Tangkap tanggal filter jika ada
$tgl_mulai  = $_GET['tgl_mulai'] ?? date('Y-m-01'); // Bawaan awal tanggal 1 bulan ini
$tgl_sampai = $_GET['tgl_sampai'] ?? date('Y-m-d');  // Bawaan awal hari ini

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="row d-print-none">
    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">
            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary" style="font-size: 0.85rem; letter-spacing: 1px;">Navigasi Admin</h5>
            <div class="list-group list-group-flush">
                <a href="../dashboard.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
                <a href="../kamar/index.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-bed me-2"></i> Kelola Data Kamar</a>
                <a href="../tamu/index.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-users me-2"></i> Kelola Data Tamu</a>
                <a href="index.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-calendar-check me-2"></i> Kelola Reservasi</a>
                <a href="../pembayaran/index.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-money-bill-wave me-2"></i> Kelola Pembayaran</a>
                <a href="../laporan/export_excel.php?tgl_mulai=<?= $tgl_mulai; ?>&tgl_sampai=<?= $tgl_sampai; ?>" class="btn btn-success w-100 mt-2"><i class="fa-solid fa-file-excel me-1"></i> Export Excel</a>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card card-ocean p-4 shadow-sm border-0 mb-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-filter me-2 text-secondary"></i>Filter Rentang Laporan</h5>
            <form action="" method="GET" class="row align-items-end">
                <div class="col-md-4 mb-2">
                    <label class="form-label small fw-bold">Dari Tanggal</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai; ?>" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label small fw-bold">Sampai Tanggal</label>
                    <input type="date" name="tgl_sampai" class="form-control" value="<?= $tgl_sampai; ?>" required>
                </div>
                <div class="col-md-4 mb-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100"><i class="fa-solid fa-sync me-1"></i> Tampilkan</button>
                    <button type="button" class="btn btn-ocean w-100" onclick="window.print()"><i class="fa-solid fa-print me-1"></i> Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 d-print-none"></div> <div class="col-md-9 col-sm-12">
        <div class="card p-4 border-0 shadow-sm" style="background-color: #fff; color: #000;">
            
            <div class="text-center mb-4 border-bottom pb-3">
                <h3 class="fw-bold text-uppercase m-0" style="font-family: 'Cinzel', serif;">Laporan Pendapatan Transaksi Hotel</h3>
                <p class="text-muted small m-1">Periode Transaksi: <strong><?= date('d M Y', strtotime($tgl_mulai)); ?></strong> s/d <strong><?= date('d M Y', strtotime($tgl_sampai)); ?></strong></p>
            </div>

            <table class="table table-bordered table-striped align-middle small">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Reservasi</th>
                        <th>Tanggal Lunas</th>
                        <th>Nama Tamu</th>
                        <th>Kamar</th>
                        <th>Metode</th>
                        <th class="text-end">Jumlah Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total_omset = 0;
                    
                    // Ambil transaksi reservasi yang sudah divalidasi pembayarannya
                    $query_lap = mysqli_query($conn, "
                        SELECT r.kode_reservasi, p.tgl_bayar, p.total_bayar, p.metode_pembayaran, t.nama_lengkap, k.nomor_kamar
                        FROM pembayaran p
                        JOIN reservasi r ON p.id_reservasi = r.id_reservasi
                        JOIN tamu t ON r.id_tamu = t.id_tamu
                        JOIN kamar k ON r.id_kamar = k.id_kamar
                        WHERE p.status_verifikasi = 'Valid' 
                        AND DATE(p.tgl_bayar) BETWEEN '$tgl_mulai' AND '$tgl_sampai'
                        ORDER BY p.tgl_bayar ASC
                    ");
                    
                    if(mysqli_num_rows($query_lap) == 0) :
                        echo '<tr><td colspan="7" class="text-center text-muted py-3">Tidak ada transaksi terverifikasi pada periode ini.</td></tr>';
                    else :
                        while($row = mysqli_fetch_assoc($query_lap)) :
                            $total_omset += $row['total_bayar'];
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-bold text-primary"><?= $row['kode_reservasi']; ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($row['tgl_bayar'])); ?></td>
                            <td><?= $row['nama_lengkap']; ?></td>
                            <td>No. <?= $row['nomor_kamar']; ?></td>
                            <td><?= $row['metode_pembayaran']; ?></td>
                            <td class="text-end fw-bold">Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php 
                        endwhile; 
                    endif;
                    ?>
                </tbody>
                <tfoot class="table-light fw-bold" style="font-size: 1.05rem;">
                    <tr>
                        <td colspan="6" class="text-end text-uppercase">Total Seluruh Pendapatan:</td>
                        <td class="text-end text-success bg-light">Rp <?= number_format($total_omset, 0, ',', '.'); ?></td>
                    </tr>
                </tfoot>
            </table>

            <div class="row mt-5 pt-3 d-none d-print-flex justify-content-end">
                <div class="col-4 text-center">
                    <p class="mb-5">Pidie, <?= date('d F Y'); ?><br>Mengetahui, Manajer Hotel</p>
                    <p class="fw-bold border-bottom d-inline-block px-4">_______________________</p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
@media print {
    body { background-color: #fff !important; font-size: 12px; }
    .card-ocean { background: none !important; border: none !important; box-shadow: none !important; }
    .table-dark { background-color: #000 !important; color: #fff !important; }
    tfoot tr td { background-color: #f5f5f5 !important; }
}
</style>

<?php include '../../templates/footer.php'; ?>