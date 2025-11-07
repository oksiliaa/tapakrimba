<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // Validasi password cocok
    if ($password !== $confirm) {
        $error = "⚠️ Password dan Konfirmasi tidak cocok!";
    } else {
        // Cek username
        $check = "SELECT * FROM admins WHERE username='$username'";
        $result = mysqli_query($conn, $check);

        if (mysqli_num_rows($result) > 0) {
            $error = "⚠️ Username sudah digunakan!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = "INSERT INTO admins (username, password) VALUES ('$username', '$hashed')";

            if (mysqli_query($conn, $insert)) {
                $success = "✅ Registrasi berhasil! Mengarahkan ke halaman login...";
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
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Poppins", sans-serif;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            animation: fadeIn 0.6s ease-in-out;
        }

        h3 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        .form-control::placeholder {
            color: #e0e0e0;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: none;
            outline: none;
            color: white;
        }

        .btn-register {
            background-color: #6a11cb;
            background-image: linear-gradient(315deg, #6a11cb 0%, #2575fc 74%);
            border: none;
            width: 100%;
            padding: 0.6rem;
            font-weight: 500;
            color: white;
            transition: 0.3s ease;
            border-radius: 8px;
        }

        .btn-register:hover {
            background-image: linear-gradient(315deg, #2575fc 0%, #6a11cb 74%);
        }

        .footer-text {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .footer-text a {
            color: #fff;
            text-decoration: underline;
        }

        .alert {
            background: rgba(255, 0, 0, 0.2);
            color: #ffb3b3;
            border: none;
            text-align: center;
            border-radius: 8px;
        }

        .alert-success {
            background: rgba(0, 255, 0, 0.2);
            color: #b3ffb3;
            border: none;
            text-align: center;
            border-radius: 8px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h3>Register Admin</h3>

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
            Sudah punya akun? <a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>
