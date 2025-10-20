<?php
session_start();
include 'config.php';

// Cek login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data dari tabel devices
$result = $conn->query("SELECT * FROM devices ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Website Jaringan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary p-3">
    <div class="container-fluid">
        <span class="navbar-brand">📡 Website Jaringan</span>
        <div>
            <a href="add_device.php" class="btn btn-light btn-sm">+ Tambah Perangkat</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h3>Daftar Perangkat Jaringan</h3>
   <table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Merek</th>
            <th>IP Address</th>
            <th>Lokasi</th>
            <th>Jenis</th>
            <th>Status</th>
            <th>Tanggal Pasang</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM devices ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['brand']}</td>
                    <td>{$row['ip_address']}</td>
                    <td>{$row['location']}</td>
                    <td>{$row['type']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['installed_date']}</td>
                    <td>
                        <a href='edit_device.php?id={$row['id']}' class='btn btn-warning btn-sm'>✏️ Edit</a>
                        <a href='delete_device.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus perangkat ini?')\">🗑️ Hapus</a>
                    </td>
                </tr>";
        }
        ?>
    </tbody>
</table>
</div>

</body>
</html>
