<?php
session_start();
include 'config.php';

// Cek login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM devices WHERE id = $id");
}

header("Location: dashboard.php");
exit();
?>
