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
    <title>Login Admin - Website Jaringan</title>
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

        .login-card {
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

        .btn-login {
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

        .btn-login:hover {
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

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h3>Login Admin</h3>

        <?php if (isset($error)): ?>
            <div class="alert py-2"><?= $error ?></div>
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

            <button type="submit" class="btn btn-login">Masuk</button>
        </form>

        <div class="footer-text">
            Belum punya akun? <a href="Register.php">Register</a>
        </div>
    </div>
</body>
</html>
