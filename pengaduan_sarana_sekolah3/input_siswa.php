<?php
session_start();
include 'config/koneksi.php';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Input Siswa</title>

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
thead{
    background: #1e40af;
    color: #fff;
}
.badge-status{
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
}
.status-Menunggu{ background: #facc15; color:#000; }
.status-Proses{ background: #38bdf8; color:#000; }
.status-Selesai{ background: #22c55e; color:#fff; }
table img{ border-radius: 8px; }
</style>
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <h5>🏫 Aplikasi Pengaduan</h5>
    <a href="dashboard_admin.php">📋 Lihat Pengaduan</a>
    <a href="input_siswa.php" class="active">👨‍🎓 Input Siswa</a>
    <a href="input_kategori.php">🏷️ Input Kategori</a>
    <a href="manage_admin.php">🛠️ Manage Admin</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="content">

    <!-- FORM INPUT -->
    <div class="card-custom">
        <h4 class="mb-4">👨‍🎓 Input Data Siswa</h4>

        <form action="admin_input_siswa.php" method="POST">
            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary">💾 Simpan</button>
            <a href="import_siswa_excel.php" class="btn btn-success">
                📥 Import dari Excel</a>
        </form>
    </div>

    <!-- TABEL SISWA -->
    <div class="card-custom">
        <h4 class="mb-3">📄 Daftar Siswa</h4>

        <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $q = mysqli_query($conn, "SELECT * FROM siswa");
            while($d = mysqli_fetch_assoc($q)){
                echo "<tr>
                    <td class='text-center'>$no</td>
                    <td>{$d['nis']}</td>
                    <td>{$d['nama']}</td>
                    <td class='text-center'>{$d['kelas']}</td>
                    <td class='text-center'>
                        <a href='hapus_siswa.php?nis={$d['nis']}'
                           class='btn btn-danger btn-sm'
                           onclick=\"return confirm('Yakin hapus siswa ini?')\">
                           🗑 Hapus
                        </a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>

</div>
</body>
</html>
