<?php
require_once '../config/database.php';
require_once '../config/config.php';
cek_akses('tamu');

// Ambil semua data kamar dari database
$kamar_query = mysqli_query($conn, "SELECT * FROM kamar ORDER BY harga_per_malam ASC");

include '../templates/header.php';
include '../templates/navbar.php';
?>

<div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card card-ocean p-3">
            <h5 class="fw-bold mb-3 border-bottom pb-2 text-uppercase text-secondary" style="font-size: 0.85rem; letter-spacing: 1px;">Layanan Tamu</h5>
            <div class="list-group list-group-flush">
                <a href="dashboard.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-user-circle me-2"></i> Akun Saya</a>
                <a href="kamar.php" class="list-group-item list-group-item-action active bg-dark border-0 rounded-3 mb-1"><i class="fa-solid fa-images me-2"></i> Lihat Brosur Kamar</a>
                <a href="reservasi.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-clipboard-list me-2"></i> Booking Kamar</a>
                <a href="riwayat.php" class="list-group-item list-group-item-action rounded-3 mb-1"><i class="fa-solid fa-history me-2"></i> Riwayat Pemesanan</a>
            </div>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="col-md-9">
        <!-- Header -->
        <div class="card card-ocean p-4 mb-4">
            <h4 class="fw-bold mb-1" style="color: var(--navy-dark);">Brosur Kamar</h4>
            <p class="text-muted small m-0">Temukan kamar yang paling sesuai dengan kebutuhan Anda. Setiap kamar dirancang untuk memberikan kenyamanan maksimal dengan pemandangan laut yang memukau.</p>
        </div>

        <!-- Filter & Search -->
        <div class="card bg-white p-3 border shadow-sm rounded-3 mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-search text-muted"></i></span>
                        <input type="text" id="searchKamar" class="form-control border-start-0 bg-light" placeholder="Cari nomor atau tipe kamar...">
                    </div>
                </div>
                <div class="col-md-6">
                    <select id="filterTipe" class="form-select form-select-sm bg-light">
                        <option value="">Semua Tipe Kamar</option>
                        <option value="Standard">Standard</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Daftar Kamar -->
        <div class="row g-3" id="kamarList">
            <?php if (mysqli_num_rows($kamar_query) > 0): ?>
                <?php while ($kamar = mysqli_fetch_assoc($kamar_query)): ?>
                    <?php
                        $harga_format = 'Rp ' . number_format($kamar['harga_per_malam'], 0, ',', '.');
                    ?>
                    <div class="col-md-6 kamar-item"
                         data-nama="<?= strtolower($kamar['nomor_kamar'] . ' ' . $kamar['tipe_kamar']); ?>"
                         data-tipe="<?= $kamar['tipe_kamar']; ?>">
                        <div class="card border shadow-sm rounded-3 h-100 overflow-hidden kamar-card">
                            <!-- Gambar Kamar -->
                            <div class="position-relative">
                                <?php if (!empty($kamar['foto_kamar'])): ?>
    <img src="../assets/uploads/foto_kamar/<?= $kamar['foto_kamar']; ?>"
         class="card-img-top"
         alt="Foto Kamar <?= $kamar['nomor_kamar']; ?>"
         style="height: 190px; object-fit: cover;">
<?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height: 190px;">
                                        <i class="fa-solid fa-image fa-2x"></i>
                                    </div>
                                <?php endif; ?>
                                <!-- Badge Tipe -->
                                <span class="badge bg-dark position-absolute top-0 start-0 m-2" style="font-size: 0.7rem;">
                                    <?= $kamar['tipe_kamar']; ?>
                                </span>
                            </div>

                            <!-- Isi Card -->
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0" style="color: var(--navy-dark);">Kamar <?= $kamar['nomor_kamar']; ?></h6>
                                    <span class="text-success fw-bold small"><?= $harga_format; ?><span class="text-muted fw-normal">/malam</span></span>
                                </div>

                                <!-- Fasilitas -->
                                <p class="text-muted small mb-2" style="line-height: 1.5;">
                                    <?= !empty($kamar['fasilitas']) ? $kamar['fasilitas'] : 'Fasilitas lengkap tersedia.'; ?>
                                </p>

                                <!-- Kapasitas & No Kamar -->
                                <div class="d-flex gap-3 text-muted small mb-3">
                                    <span><i class="fa-solid fa-door-open me-1"></i> No. <?= $kamar['nomor_kamar']; ?></span>
                                    <?php if (!empty($kamar['kapasitas'])): ?>
                                        <span><i class="fa-solid fa-user-group me-1"></i> <?= $kamar['kapasitas']; ?> Tamu</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Tombol Aksi -->
                               <a href="reservasi.php?pilih_kamar=<?= $kamar['id_kamar']; ?>"
   class="btn btn-dark btn-sm w-100 rounded-3">
    <i class="fa-solid fa-clipboard-list me-1"></i> Pesan Sekarang
</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center text-muted py-5">
                        <i class="fa-solid fa-bed fa-3x mb-3 d-block" style="color: #cdd3d8;"></i>
                        <p class="mb-0">Belum ada data kamar yang tersedia saat ini.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Empty state ketika filter tidak menemukan hasil -->
        <div id="emptyFilter" class="text-center text-muted py-5 d-none">
            <i class="fa-solid fa-magnifying-glass fa-2x mb-3 d-block" style="color: #cdd3d8;"></i>
            <p class="mb-0">Tidak ada kamar yang cocok dengan pencarian Anda.</p>
        </div>
    </div>
</div>

<!-- Style Tambahan -->
<style>
    .kamar-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kamar-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1) !important;
    }
</style>

<!-- Script Filter & Search -->
<script>
    function filterKamar() {
        const search = document.getElementById('searchKamar').value.toLowerCase();
        const tipe   = document.getElementById('filterTipe').value;
        const items  = document.querySelectorAll('.kamar-item');

        let visible = 0;
        items.forEach(item => {
            const namaCocok = item.dataset.nama.includes(search);
            const tipeCocok = tipe === '' || item.dataset.tipe === tipe;

            if (namaCocok && tipeCocok) {
                item.style.display = '';
                visible++;
            } else {
                item.style.display = 'none';
            }
        });

        document.getElementById('emptyFilter').classList.toggle('d-none', visible > 0);
    }

    document.getElementById('searchKamar').addEventListener('input',  filterKamar);
    document.getElementById('filterTipe').addEventListener('change',  filterKamar);
</script>

<?php include '../templates/footer.php'; ?>