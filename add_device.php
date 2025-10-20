<?php
session_start();
include 'config.php';

// Pastikan admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$success_message = "";

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
        // Setelah disimpan, redirect ke dashboard
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
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary p-3">
    <div class="container-fluid">
        <span class="navbar-brand">📡 Website Jaringan</span>
        <a href="dashboard.php" class="btn btn-light btn-sm">← Kembali</a>
    </div>
</nav>

<div class="container mt-4">
    <h3>Tambah Perangkat Jaringan</h3>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label>Nama Perangkat</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Merek</label>
            <input type="text" name="brand" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>IP Address</label>
            <input type="text" name="ip_address" class="form-control" placeholder="192.168.1.1" required>
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis</label>
            <select name="type" class="form-select" required>
                <option value="Router">Router</option>
                <option value="Switch">Switch</option>
                <option value="Access Point">Access Point</option>
                <option value="Server">Server</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
                <option value="Maintenance">Maintenance</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Pasang</label>
            <input type="date" name="installed_date" class="form-control" required>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

</body>
</html>
