<?php
include 'db.php';

// Ganti username dan password sesuai keinginan kamu
$username = "admin";
$password = password_hash("123456", PASSWORD_DEFAULT);

$sql = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "Akun admin berhasil dibuat!<br>";
    echo "Username: admin<br>Password: 123456";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
