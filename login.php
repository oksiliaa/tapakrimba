<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $error = "❌ Password salah!";
        }
    } else {
        $error = "⚠️ Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="asset/foto.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        /* Background animasi */
        body {
            margin: 0;
            height: 100vh;
            font-family: "Poppins", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(270deg, #6a11cb, #2575fc, #00c6ff, #6a11cb);
            background-size: 800% 800%;
            animation: gradientMove 12s ease infinite;
            overflow: hidden;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Efek bokeh */
        .bokeh {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            animation: float 10s infinite ease-in-out;
        }

        .circle:nth-child(1) { width: 200px; height: 200px; top: 10%; left: 20%; animation-delay: 0s; }
        .circle:nth-child(2) { width: 150px; height: 150px; bottom: 20%; right: 15%; animation-delay: 3s; }
        .circle:nth-child(3) { width: 250px; height: 250px; top: 60%; left: 60%; animation-delay: 6s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
            50% { transform: translateY(-40px) scale(1.1); opacity: 0.9; }
        }

        /* Card login tengah */
        .login-card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            width: 360px;
            height: 460px;
            padding: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Logo + judul */
        .logo {
            width: 70px;
            height: 70px;
            margin-bottom: 0.5rem;
            animation: fadeDown 1s ease-in-out;
        }

        h3 {
            font-weight: 600;
            margin-bottom: 1.2rem;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
            animation: fadeDown 1.2s ease-in-out;
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
            background: rgba(255, 255, 255, 0.3);
            box-shadow: none;
            color: white;
        }

        .btn-login {
            background-image: linear-gradient(135deg, #6a11cb 0%, #2575fc 74%);
            border: none;
            width: 100%;
            padding: 0.6rem;
            font-weight: 500;
            color: white;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .btn-login:hover {
            transform: scale(1.05);
            background-image: linear-gradient(135deg, #2575fc 0%, #6a11cb 74%);
        }

        .alert {
            background: rgba(255, 0, 0, 0.25);
            color: #ffd6d6;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .text-small {
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .text-small a {
            color: #fff;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-10px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="bokeh">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="login-card">
        <!-- Logo -->
        <img src="asset/foto.png" alt="Logo" class="logo">
        <h3>INVENTARIS HARDWARE</h3>

        <?php if (isset($error)): ?>
            <div class="alert py-2 mb-3"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3 text-start">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-login mt-2">Masuk</button>
        </form>

        <div class="text-small">
            Belum punya akun? <a href="register.php">Daftar disini</a>
        </div>
    </div>
</body>
</html>
