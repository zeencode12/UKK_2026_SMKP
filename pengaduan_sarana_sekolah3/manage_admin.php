<?php
session_start();
include 'config/koneksi.php';

/* ================= PROTEKSI LOGIN ================= */
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

$adm = $_SESSION['admin'];

/* ambil level admin login */
$qLogin = mysqli_query($conn, "SELECT level FROM admin WHERE username='$adm'");
$dataLogin = mysqli_fetch_assoc($qLogin);
$level_login = $dataLogin['level'];

/* fitur pencarian */
$where = "";
if (!empty($_GET['cari'])) {
    $cari = mysqli_real_escape_string($conn, $_GET['cari']);
    $where = "WHERE username LIKE '%$cari%'";
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manage Admin</title>
<link rel="icon" href="image/school.ico">
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
</style>
</head>
<body>

<div class="sidebar">
    <h5>🏫 Aplikasi Pengaduan</h5>
    <a href="dashboard_admin.php">📋 Lihat Pengaduan</a>
    <a href="input_siswa.php">👨‍🎓 Input Siswa</a>
    <a href="input_kategori.php">🏷️ Input Kategori</a>
    <a href="manage_admin.php" class="active">🛠️ Manage Admin</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="content">

<!-- TAMBAH ADMIN (HANYA ADMIN UTAMA) -->
<?php if ($level_login === 'utama') { ?>
<div class="card-custom mb-4">
    <h4>➕ Tambah Admin</h4>
    <form action="admin_input_admin.php" method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Level Admin</label>
            <select name="level" class="form-control" required>
                <option value="">-- Pilih Level --</option>
                <option value="biasa">Admin Biasa</option>
                <option value="utama">Admin Utama</option>
            </select>
        </div>

        <button class="btn btn-primary">💾 Simpan</button>
    </form>
</div>
<?php } ?>

<!-- DAFTAR ADMIN -->
<div class="card-custom">
    <h4 class="mb-3">📋 Daftar Admin</h4>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="cari" class="form-control"
                   placeholder="Cari username..."
                   value="<?= htmlspecialchars($_GET['cari'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Cari</button>
        </div>
        <div class="col-md-2">
            <a href="manage_admin.php" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>
<?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'ditolak') { ?>
<div class="alert alert-danger">
    ⛔ Akses ditolak! Anda tidak punya izin.
</div>
<?php } ?>
    <table class="table table-bordered table-hover">
        <thead class="text-center">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        if ($level_login === 'utama') {
    // admin utama lihat semua
    $q = mysqli_query($conn, "
        SELECT username, level
        FROM admin
        $where
        ORDER BY 
            CASE level WHEN 'utama' THEN 0 ELSE 1 END,
            username ASC
    ");
} else {
    // admin biasa TIDAK lihat admin utama
    if ($where == "") {
        $where = "WHERE level != 'utama'";
    } else {
        $where .= " AND level != 'utama'";
    }

    $q = mysqli_query($conn, "
        SELECT username, level
        FROM admin
        $where
        ORDER BY username ASC
    ");
}


        while ($d = mysqli_fetch_assoc($q)) {
        ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['username']) ?></td>
            <td class="text-center"><?= strtoupper($d['level']) ?></td>
            <td class="text-center">
            <?php
            /* ADMIN UTAMA */
            if ($d['level'] === 'utama') {
                echo '
                <a href="edit_password_admin.php?username='.urlencode($d['username']).'"
                   class="btn btn-warning btn-sm">🔑 Edit Password</a>';
            }
            /* AKUN SENDIRI */
            elseif ($d['username'] === $adm) {
                echo '
                <a href="edit_password_admin.php?username='.urlencode($d['username']).'"
                   class="btn btn-warning btn-sm">🔑 Ganti Password</a>';
            }
            /* ADMIN UTAMA KE ADMIN LAIN */
            elseif ($level_login === 'utama') {
            ?>
                <a href="edit_password_admin.php?username=<?= urlencode($d['username']) ?>"
                   class="btn btn-warning btn-sm">🔑 Edit Password</a>

                <a href="hapus_admin.php?username=<?= urlencode($d['username']) ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus admin ini?')">
                   🗑 Hapus
                </a>
            <?php
            } else {
                echo '<button class="btn btn-secondary btn-sm" disabled>⛔ Tidak Ada Akses</button>';
            }
            ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</div>
</body>
</html>
