<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = md5($_POST['password']); // MD5
$level    = $_POST['level'];

/* validasi level */
if (!in_array($level, ['utama','biasa'])) {
    die("Level tidak valid");
}

/* simpan admin */
$query = mysqli_query($conn, "
    INSERT INTO admin (username, password, level)
    VALUES ('$username', '$password', '$level')
");

if ($query) {
    header("Location: manage_admin.php");
} else {
    echo "Gagal menambah admin";
}
?>
