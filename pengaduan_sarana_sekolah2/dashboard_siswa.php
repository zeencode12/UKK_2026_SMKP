<?php session_start(); if(!isset($_SESSION['nis'])) header("Location: login_siswa.php"); ?>
<!doctype html>
<html><head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<h4>Dashboard Siswa</h4>
<a class="btn btn-success" href="input_pengaduan.php">Buat Pengaduan</a>
<a class="btn btn-danger" href="logout.php">Logout</a>
</body></html>