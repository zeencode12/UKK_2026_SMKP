<?php
session_start();
include 'config/koneksi.php';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Import Siswa Excel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg, #1f2933, #111827);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    color: #fff;
}
.sidebar{
    width: 240px;
    background: #020617;
    min-height: 100vh;
    position: fixed;
    padding: 20px;
}
.sidebar h5{
    text-align: center;
    margin-bottom: 30px;
    font-weight: 600;
}
.sidebar a{
    display: block;
    padding: 12px 15px;
    color: #e5e7eb;
    text-decoration: none;
    border-radius: 10px;
    margin-bottom: 10px;
}
.sidebar a:hover{ background: #1e40af; }
.sidebar a.active{
    background: #2563eb;
    font-weight: 600;
}
.content{
    margin-left: 260px;
    padding: 30px;
}
.card-custom{
    background: #ffffff;
    color: #333;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,.25);
}
</style>
</head>

<body>

<!-- ===== SIDEBAR (TETAP) ===== -->
<div class="sidebar">
    <h5>🏫 Aplikasi Pengaduan</h5>
    <a href="dashboard_admin.php">📋 Lihat Pengaduan</a>
    <a href="input_siswa.php">👨‍🎓 Input Siswa</a>
    <a href="import_siswa_excel.php" class="active">📥 Import Siswa Excel</a>
    <a href="input_kategori.php">🏷️ Input Kategori</a>
    <a href="index.php" class="text-danger">🚪 Logout</a>
</div>

<!-- ===== KONTEN DIGANTI ===== -->
<div class="content">

    <div class="card-custom">
        <h4 class="mb-4">📥 Import Data Siswa dari Excel</h4>

        <form method="POST" action="proses_import_siswa.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Pilih File Excel</label>
                <input type="file" name="file_excel" class="form-control" accept=".xls,.xlsx" required>
            </div>

            <button type="submit" name="import" class="btn btn-primary">
                🚀 Import Data
            </button>

            <a href="input_siswa.php" class="btn btn-secondary ms-2">
                ⬅ Kembali
            </a>
        </form>

        <hr>

        <p class="text-muted mb-0">
            📌 <strong>Format Excel:</strong> NIS | Nama | Kelas (baris pertama sebagai header)
        </p>
    </div>

</div>

</body>
</html>
