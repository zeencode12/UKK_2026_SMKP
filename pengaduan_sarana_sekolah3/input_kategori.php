<?php 
session_start();
include 'config/koneksi.php';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Input Kategori</title>

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
    margin-bottom: 30px;
}
</style>
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <h5>🏫 Aplikasi Pengaduan</h5>
    <a href="dashboard_admin.php">📋 Lihat Pengaduan</a>
    <a href="input_siswa.php">👨‍🎓 Input Siswa</a>
    <a href="input_kategori.php" class="active">🏷️ Input Kategori</a>
    <a href="manage_admin.php">🛠️ Manage Admin</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="content">

    <!-- FORM INPUT KATEGORI -->
    <div class="card-custom">
        <h4 class="mb-4">🏷️ Input Kategori</h4>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="ket_kategori" class="form-control" placeholder="Contoh: Laboratorium" required>
            </div>
            <button name="simpan" class="btn btn-primary">💾 Simpan</button>
        </form>

        <?php
        if(isset($_POST['simpan'])){
            $ket = mysqli_real_escape_string($conn, $_POST['ket_kategori']);
            mysqli_query($conn, "INSERT INTO kategori (ket_kategori) VALUES ('$ket')");
            echo "<script>alert('Kategori berhasil ditambahkan');location='input_kategori.php';</script>";
        }
        ?>
    </div>

    <!-- TABEL KATEGORI -->
    <div class="card-custom">
        <h4 class="mb-3">📄 Daftar Kategori</h4>

        <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $q = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");
            while($d = mysqli_fetch_assoc($q)){
                echo "<tr>
                    <td class='text-center'>$no</td>
                    <td>{$d['ket_kategori']}</td>
                    <td class='text-center'>
                        <a href='hapus_kategori.php?id={$d['id_kategori']}'
                           class='btn btn-danger btn-sm'
                           onclick=\"return confirm('Yakin hapus kategori ini?')\">
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
