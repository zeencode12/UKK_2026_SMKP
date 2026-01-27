<?php
session_start();
include 'config/koneksi.php';

if (!isset($_GET['username'])) {
    header("Location: manage_admin.php");
    exit;
}

$username = mysqli_real_escape_string($conn, $_GET['username']);

// get oldest admin
$oldest = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT username FROM admin ORDER BY username ASC LIMIT 1")
);

if ($username === $oldest['username']) {
    echo "<script>
        alert('Admin terlama tidak boleh dihapus!');
        window.location='manage_admin.php';
    </script>";
    exit;
}

$delete = mysqli_query($conn, "DELETE FROM admin WHERE username = '$username'");

if ($delete) {
    echo "<script>
        alert('Admin berhasil dihapus');
        window.location='manage_admin.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus admin');
        history.back();
    </script>";
}
