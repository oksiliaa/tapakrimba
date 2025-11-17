<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$aktif = $conn->query("SELECT COUNT(*) AS total FROM devices WHERE status='Aktif'")->fetch_assoc()['total'];
$nonaktif = $conn->query("SELECT COUNT(*) AS total FROM devices WHERE status='Nonaktif'")->fetch_assoc()['total'];
$maint = $conn->query("SELECT COUNT(*) AS total FROM devices WHERE status='Maintenance'")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grafik Status Perangkat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        body {
            background: linear-gradient(270deg, #6a11cb, #2575fc, #00c6ff, #6a11cb);
            background-size: 800% 800%;
            animation: gradientMove 12s ease infinite;
            color: white;
            min-height: 100vh;
            font-family: 'Didot', Rufina;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* =======================
           Dikecilkan untuk desktop
           ======================= */
        .container {
            max-width: 700px;      /* Diperkecil dari standar Bootstrap */
        }

        h2 {
            font-size: 1.7rem;     /* Judul diperkecil */
        }

        .card-glass {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            border-radius: 18px;
            padding: 18px;         /* diperkecil */
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }

        canvas {
            max-width: 330px !important;   /* grafik diperkecil */
            margin: 0 auto;
        }

        .btn-back {
            font-size: 0.9rem;     /* tombol diperkecil */
            padding: 8px 18px;
            border-radius: 12px !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark p-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="asset/foto.png" alt="Logo" width="39" height="40">
                <span class="navbar-brand">Inventaris Hardware</span> 
            </div>
            <div>
                <a href="add_device.php" class="btn btn-light btn-sm me-2">
                    <i class="bi bi-plus-circle"></i> Tambah Perangkat
                </a>

                <!-- TOMBOL GRAFIK STATUS DIUBAH MENJADI BERANDA -->
                <a href="index.php" class="btn btn-info btn-sm me-2">
                    <i class="bi bi-house"></i> Beranda
                </a>

                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <h2 class="text-center mb-3">Grafik Status Perangkat</h2>

        <div class="card-glass text-center">
            <canvas id="statusChart"></canvas>
        </div>

        <div class="text-center mt-3">
            <a href="index.php" 
               class="btn btn-light btn-back"
               style="backdrop-filter: blur(8px); 
                      background: rgba(255,255,255,0.25); 
                      color: white; 
                      border: none;
                      font-weight: 600;">
                ⟵ Kembali ke Dashboard
            </a>
        </div>
    </div>

<script>
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Aktif', 'Nonaktif', 'Maintenance'],
        datasets: [{
            data: [<?= $aktif ?>, <?= $nonaktif ?>, <?= $maint ?>],
            borderWidth: 2,
            hoverOffset: 10
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: { 
                    color: 'white', 
                    font: { size: 12 } /* legend diperkecil */
                }
            }
        }
    }
});
</script>

</body>
</html>