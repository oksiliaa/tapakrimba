<?php
session_start();
include 'config.php';

// Pastikan admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Simpan data perangkat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $ip_address = $_POST['ip_address'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $installed_date = $_POST['installed_date'];

    $query = "INSERT INTO devices (name, brand, ip_address, location, type, status, installed_date)
              VALUES ('$name', '$brand', '$ip_address', '$location', '$type', '$status', '$installed_date')";
    
    if ($conn->query($query)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Perangkat - Website Jaringan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-primary p-3 shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <span class="navbar-brand">📡 Website Jaringan</span>
        <a href="index.php" class="btn btn-light btn-sm">← Kembali</a>
    </div>
</nav>

<!-- Konten -->
<div class="container mt-5">
    <div class="card p-4">
        <h3 class="mb-4 text-primary">➕ Tambah Perangkat Jaringan</h3>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Perangkat</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Merek</label>
                <input type="text" name="brand" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">IP Address</label>
                <input type="text" name="ip_address" class="form-control" placeholder="192.168.1.1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="location" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis</label>
                <select name="type" class="form-select" required>
                    <option value="Router">Router</option>
                    <option value="Switch">Switch</option>
                    <option value="Access Point">Access Point</option>
                    <option value="Server">Server</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                    <option value="Maintenance">Maintenance</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Tanggal Pasang</label>
                <input type="date" name="installed_date" class="form-control" required>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-2">💾 Simpan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
