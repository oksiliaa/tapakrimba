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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <style>
        body {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            min-height: 100vh;
            font-family: "Poppins", sans-serif;
            color: white;
        }

        .navbar {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.2rem;
        }

        .btn-light, .btn-danger {
            font-weight: 500;
        }

        .card-table {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            animation: fadeIn 0.6s ease-in-out;
        }

       table {
    border-collapse: collapse; /* agar border tidak dobel */
    width: 100%;
  }

  table, th, td {
    border: 1px solid #000; /* border tipis warna hitam */
  }

  th, td {
    padding: 8px;
    text-align: left;
  }

        thead {
            background: rgba(255, 255, 255, 0.1);
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-sm {
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f7971e, #ffd200);
            border: none;
            color: black;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #ffd200, #f7971e);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e52d27, #b31217);
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #b31217, #e52d27);
        }

        h3 {
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        @media (max-width: 768px) {
            table {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark p-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="asset/logo.png" alt="Logo" width="45" height="35" class="me-2">
            <span class="navbar-brand mb-0 h5">Inventaris Hardware</span>
        </div>
        <div>
            <a href="add_device.php" class="btn btn-light btn-sm me-2">
                <i class="bi bi-plus-circle me-1"></i> Tambah Perangkat
            </a>
            <a href="logout.php" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
        </div>
    </div>
</nav>


<div class="container my-5">
    <div class="card-table">
        <h3 class="text-center mb-4">Daftar Perangkat Jaringan</h3>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
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
    $no = 1; // mulai nomor dari 1
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['name']}</td>
                <td>{$row['brand']}</td>
                <td>{$row['ip_address']}</td>
                <td>{$row['location']}</td>
                <td>{$row['type']}</td>
                <td>{$row['status']}</td>
                <td>{$row['installed_date']}</td>
                <td>
        <a href='edit_device.php?id={$row['id']}' class='btn btn-warning btn-sm me-1 text-white'>
            <i class='bi bi-pencil-square me-1'></i>Edit
        </a>
        <a href='delete_device.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus perangkat ini?')\">
            <i class='bi bi-trash me-1'></i>Hapus
        </a>
    </td>
              </tr>";
        $no++;
    }
?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
