<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

$login = $_SESSION['admin'];
$target = $_GET['username'] ?? '';

/* data login */
$q1 = mysqli_query($conn,"SELECT level FROM admin WHERE username='$login'");
$l = mysqli_fetch_assoc($q1);

/* data target */
$q2 = mysqli_query($conn,"SELECT level FROM admin WHERE username='$target'");
$t = mysqli_fetch_assoc($q2);

if (!$t) die("Admin tidak ditemukan.");
if ($t['level'] === 'utama') die("Admin utama tidak boleh dihapus.");
if ($login === $target) die("Tidak boleh menghapus akun sendiri.");
if ($l['level'] !== 'utama') die("Tidak punya hak akses.");

mysqli_query($conn,"DELETE FROM admin WHERE username='$target'");
header("Location: manage_admin.php");
