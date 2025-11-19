<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM devices WHERE id='$id'");
$data = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $ip = $_POST['ip_address'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $date = $_POST['installed_date'];

    $update = "UPDATE devices SET name='$name', brand='$brand', ip_address='$ip', location='$location', 
               type='$type', status='$status', installed_date='$date' WHERE id='$id'";
    if ($conn->query($update)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Perangkat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="asset/foto.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(270deg, #6a11cb, #2575fc, #00c6ff, #6a11cb);
            background-size: 800% 800%;
            animation: gradientMove 12s ease infinite;
            min-height: 100vh;
            font-family: "Didot", Rufina;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card-form {
            width: 100%;
            max-width: 550px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            animation: fadeIn 0.8s ease;
        }

        .form-control {
            background: rgba(255,255,255,0.15);
            border: none;
            color: white;
            border-radius: 10px;
        }

        .form-control::placeholder {
            color: #dcdcdc;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.25);
            box-shadow: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            border: none;
            border-radius: 10px;
        }

        .btn-success:hover {
            transform: scale(1.03);
            transition: 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        a {
            color: #ffebcd;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card-form">
        <h3 class="text-center mb-4">
            <i class="bi bi-pencil-square me-2"></i>Ubah Perangkat
        </h3>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="name" value="<?= $data['name'] ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="text" name="brand" value="<?= $data['brand'] ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="text" name="ip_address" value="<?= $data['ip_address'] ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="text" name="location" value="<?= $data['location'] ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="text" name="type" value="<?= $data['type'] ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <select name="status" class="form-control" required>
                    <option value="Aktif" <?= $data['status']=='Aktif'?'selected':'' ?>>Aktif</option>
                    <option value="Nonaktif" <?= $data['status']=='Nonaktif'?'selected':'' ?>>Nonaktif</option>
                    <option value="Maintenance" <?= $data['status']=='Maintenance'?'selected':'' ?>>Maintenance</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="date" name="installed_date" value="<?= $data['installed_date'] ?>" class="form-control" required>
            </div>
            <button type="submit" name="update" class="btn btn-success w-100">Perbarui</button>
            <div class="text-center mt-3">
                <a href="index.php" class="text-white text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left-circle me-1"></i>Kembali ke Dashboard
                </a>
            </div>
        </form>
    </div>
</body>
</html>
