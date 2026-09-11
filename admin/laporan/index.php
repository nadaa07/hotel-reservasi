<?php
session_start();

require_once '../../config/database.php';
require_once '../../config/config.php';

cek_akses('admin');

include '../../templates/header.php';
include '../../templates/navbar.php';
?>

<div class="container mt-4">

    <h3 class="mb-4">
        Laporan Hotel
    </h3>

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <h4>📋</h4>

                    <h5>Laporan Reservasi</h5>

                    <p class="text-muted">
                        Melihat seluruh data reservasi tamu.
                    </p>

                    <a href="reservasi.php"
                       class="btn btn-primary">

                        Buka

                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <h4>💰</h4>

                    <h5>Laporan Pendapatan</h5>

                    <p class="text-muted">
                        Melihat total pemasukan hotel.
                    </p>

                    <a href="pendapatan.php"
                       class="btn btn-success">

                        Buka

                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <h4>📊</h4>

                    <h5>Export Excel</h5>

                    <p class="text-muted">
                        Unduh laporan dalam format Excel.
                    </p>

                    <a href="export_excel.php"
                       class="btn btn-warning">

                        Export

                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <h4>📄</h4>

                    <h5>Export PDF</h5>

                    <p class="text-muted">
                        Cetak laporan dalam format PDF.
                    </p>

                    <a href="export_pdf.php"
                       class="btn btn-danger">

                        Export

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include '../../templates/footer.php'; ?>