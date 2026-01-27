<?php
session_start();
include 'config/koneksi.php';

// get OLDEST admin (protected)
$oldest = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT username FROM admin ORDER BY username ASC LIMIT 1")
);
$oldest_username = $oldest['username'];
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manage Admin</title>
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

</style>
</head>
<body>

<div class="sidebar">
    <h5>🏫 Aplikasi Pengaduan</h5>
    <a href="dashboard_admin.php">📋 Lihat Pengaduan</a>
    <a href="input_siswa.php">👨‍🎓 Input Siswa</a>
    <a href="input_kategori.php">🏷️ Input Kategori</a>
    <a href="manage_admin.php" class="active">🛠️ Manage Admin</a>
    <a href="index.php" class="text-danger">🚪 Logout</a>
</div>

<div class="content">

<div class="card-custom">
    <h4 class="mb-4">👨 Manajemen Admin</h4>
    <form action="admin_input_admin.php" method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">💾 Simpan</button>
    </form>
</div>
</div>
<div class="content">
<div class="card-custom">
    <h4 class="mb-3">👨‍🎓 Daftar Admin</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-primary text-center">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Password</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $q = mysqli_query($conn, "SELECT * FROM admin");
        while($d = mysqli_fetch_assoc($q)){
        ?>
        <tr>
            <td class="text-center"><?= $no++; ?></td>
            <td><?= htmlspecialchars($d['username']); ?></td>
            <td class="text-center text-muted">•••••••• (hashed)</td>
            <td class="text-center">
            <?php if ($d['username'] === $oldest_username) { ?>
                <button class="btn btn-secondary btn-sm" disabled>
                    🔒 Admin Terlama
                </button>
            <?php } else { ?>
                <a href="hapus_admin.php?username=<?= urlencode($d['username']); ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus admin ini?')">
                   🗑 Hapus
                </a>
            <?php } ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</div>
</body>
</html>
