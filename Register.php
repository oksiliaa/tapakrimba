<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // Validasi password cocok
    if ($password !== $confirm) {
        $error = "⚠️ Password dan Konfirmasi tidak cocok!";
    } else {
        // Cek apakah username sudah ada
        $check = "SELECT * FROM admins WHERE username='$username'";
        $result = mysqli_query($conn, $check);

        if (mysqli_num_rows($result) > 0) {
            $error = "⚠️ Username sudah digunakan!";
        } else {
            // Hash password
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = "INSERT INTO admins (username, password) VALUES ('$username', '$hashed')";
            if (mysqli_query($conn, $insert)) {
                $success = "✅ Registrasi berhasil! Silakan login.";
                header("refresh:2;url=login.php");
            } else {
                $error = "❌ Terjadi kesalahan, coba lagi!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin - Website Jaringan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at top, #0a192f, #000);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
        }

        @keyframes fadeSlideIn {
            from {opacity: 0; transform: translateY(-30px);}
            to {opacity: 1; transform: translateY(0);}
        }

        @keyframes glowing {
            0% { box-shadow: 0 0 5px #00bfff, 0 0 10px #00bfff; }
            50% { box-shadow: 0 0 20px #00d1ff, 0 0 40px #00d1ff; }
            100% { box-shadow: 0 0 5px #00bfff, 0 0 10px #00bfff; }
        }

        .register-card {
            background: rgba(20, 20, 30, 0.95);
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 0 30px rgba(0,255,255,0.1);
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(5px);
            animation: fadeSlideIn 1s ease forwards;
        }

        .register-card h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: bold;
            color: #00d1ff;
            text-shadow: 0 0 10px rgba(0,209,255,0.6);
        }

        .form-control {
            background-color: #0d1b2a;
            color: #fff;
            border: 1px solid #00d1ff;
        }
        .form-control:focus {
            border-color: #00bfff;
            box-shadow: 0 0 8px #00bfff;
        }

        .btn-register {
            width: 100%;
            background: linear-gradient(90deg, #00bfff, #0077ff);
            border: none;
            padding: 10px;
            font-weight: bold;
            border-radius: 8px;
            color: white;
            animation: glowing 2s infinite ease-in-out;
            transition: 0.3s;
        }
        .btn-register:hover {
            transform: scale(1.03);
        }

        .alert {
            text-align: center;
            background-color: rgba(255, 50, 50, 0.1);
            border: 1px solid #ff4c4c;
            color: #ff7b7b;
        }
        .alert-success {
            text-align: center;
            background-color: rgba(0, 255, 100, 0.1);
            border: 1px solid #00ff99;
            color: #00ff99;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9em;
            color: #aaa;
            animation: fadeSlideIn 2s ease forwards;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(0, 209, 255, 0.15);
            animation: float 10s infinite ease-in-out;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); opacity: 0.8; }
            50% { transform: translateY(-20px); opacity: 0.3; }
        }
    </style>
</head>
<body>

    <!-- Partikel latar -->
    <div class="circle" style="width:60px; height:60px; top:20%; left:15%;"></div>
    <div class="circle" style="width:100px; height:100px; bottom:10%; right:10%; animation-delay:1s;"></div>
    <div class="circle" style="width:80px; height:80px; top:60%; left:60%; animation-delay:2s;"></div>

    <div class="register-card">
        <h3>📝 Register Admin</h3>

        <?php if (isset($error)): ?>
            <div class="alert py-2"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert-success py-2"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="confirm" class="form-control" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn btn-register">Daftar</button>
        </form>

        <div class="footer-text">
            Sudah punya akun? <a href="login.php"> Login </a>
        </div>
    </div>

</body>
</html>
