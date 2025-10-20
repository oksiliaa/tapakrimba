<?php
session_start();
include 'config.php';

// Cek login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM devices WHERE id = $id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $ip_address = $_POST['ip_address'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $installed_date = $_POST['installed_date'];

    $query = "UPDATE devices 
              SET name='$name', brand='$brand', ip_address='$ip_address', location='$location',
                  type='$type', status='$status', installed_date='$installed_date' 
              WHERE id=$id";

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
    <title>Edit Perangkat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary p-3">
    <div class="container-fluid">
        <span class="navbar-brand">✏️ Edit Perangkat</span>
        <a href="dashboard.php" class="btn btn-light btn-sm">← Kembali</a>
    </div>
</nav>

<div class="container mt-4">
    <form method="POST">
        <div class="mb-3">
            <label>Nama Perangkat</label>
            <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Merek</label>
            <input type="text" name="brand" class="form-control" value="<?= $row['brand'] ?>" required>
        </div>

        <div class="mb-3">
            <label>IP Address</label>
            <input type="text" name="ip_address" class="form-control" value="<?= $row['ip_address'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="location" class="form-control" value="<?= $row['location'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Jenis</label>
            <select name="type" class="form-select" required>
                <option <?= $row['type'] == 'Router' ? 'selected' : '' ?>>Router</option>
                <option <?= $row['type'] == 'Switch' ? 'selected' : '' ?>>Switch</option>
                <option <?= $row['type'] == 'Access Point' ? 'selected' : '' ?>>Access Point</option>
                <option <?= $row['type'] == 'Server' ? 'selected' : '' ?>>Server</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option <?= $row['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                <option <?= $row['status'] == 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                <option <?= $row['status'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Pasang</label>
            <input type="date" name="installed_date" class="form-control" value="<?= $row['installed_date'] ?>" required>
        </div>

        <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

</body>
</html>
