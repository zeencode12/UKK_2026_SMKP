<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

$login = $_SESSION['admin'];
$target = $_GET['username'] ?? '';

/* ambil data login */
$qLogin = mysqli_query($conn, "SELECT level FROM admin WHERE username='$login'");
$dLogin = mysqli_fetch_assoc($qLogin);
$level_login = $dLogin['level'];

/* ambil data target */
$qTarget = mysqli_query($conn, "SELECT username FROM admin WHERE username='$target'");
$dTarget = mysqli_fetch_assoc($qTarget);

if (!$dTarget) {
    die("Admin tidak ditemukan");
}

/* aturan akses */
/* aturan akses */
if ($login !== $target && $level_login !== 'utama') {
    header("Location: manage_admin.php?pesan=ditolak");
    exit;
}


/* proses update */
if (isset($_POST['simpan'])) {
    $password = md5($_POST['password']);

    mysqli_query($conn, "
        UPDATE admin 
        SET password='$password' 
        WHERE username='$target'
    ");

    header("Location: manage_admin.php");
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Password Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{
    background:#0f172a;
    color:#fff;
    font-family:'Segoe UI',sans-serif;
}
.card{
    max-width:400px;
    margin:100px auto;
    border-radius:15px;
}
</style>
</head>
<body>

<div class="card p-4">
    <h4 class="text-center mb-3">🔑 Edit Password</h4>

    <form method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($target) ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button name="simpan" class="btn btn-primary w-100">💾 Simpan</button>
        <a href="manage_admin.php" class="btn btn-secondary w-100 mt-2">↩ Kembali</a>
    </form>
</div>

</body>
</html>
