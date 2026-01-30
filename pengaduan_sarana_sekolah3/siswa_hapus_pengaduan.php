<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['nis'])) {
    header("Location: login_siswa.php");
    exit;
}

$id  = $_GET['id'];
$nis = $_SESSION['nis'];

$q = mysqli_query($conn, "
    SELECT foto FROM input_aspirasi
    WHERE id_pelaporan='$id'
    AND nis='$nis'
    AND status='Menunggu'
");

$data = mysqli_fetch_assoc($q);

if ($data) {
    if ($data['foto'] && file_exists("uploads/".$data['foto'])) {
        unlink("uploads/".$data['foto']);
    }
    mysqli_query($conn, "
        DELETE FROM input_aspirasi
        WHERE id_pelaporan='$id'
        AND nis='$nis'
    ");
}

header("Location: histori.php");
exit;
