<?php 
session_start();
include 'config/koneksi.php';

// ================= PROTEKSI =================
if (!isset($_SESSION['nis'])) {
    header("Location: login_siswa.php");
    exit;
}

$nis = $_SESSION['nis'];

// ================= PAGINATION =================
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// ================= TOTAL DATA =================
$qTotal = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM input_aspirasi
    WHERE nis = '$nis'
");
$totalData = mysqli_fetch_assoc($qTotal)['total'];
$totalPage = ceil($totalData / $limit);

// ================= QUERY DATA =================
$query = mysqli_query($conn, "
    SELECT p.*, k.ket_kategori
    FROM input_aspirasi p
    JOIN kategori k ON p.id_kategori = k.id_kategori
    WHERE p.nis = '$nis'
    ORDER BY p.id_pelaporan DESC
    LIMIT $limit OFFSET $offset
");

// ================= HITUNG STATUS =================
$qStatus = mysqli_query($conn, "
    SELECT status, COUNT(*) AS total
    FROM input_aspirasi
    WHERE nis = '$nis'
    GROUP BY status
");

$menunggu = $proses = $selesai = 0;
while ($s = mysqli_fetch_assoc($qStatus)) {
    if ($s['status'] == 'Menunggu') $menunggu = $s['total'];
    if ($s['status'] == 'Proses')   $proses   = $s['total'];
    if ($s['status'] == 'Selesai')  $selesai  = $s['total'];
}
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Histori Pengaduan</title>
<link rel="icon" type="image/x-icon" href="image/school.ico">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
.sidebar a.active{ background: #2563eb; }
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
.status-box{
    border-radius: 15px;
    padding: 20px;
    text-align: center;
}
.status-menunggu{ background: #facc15; color:#000; }
.status-proses{ background: #38bdf8; color:#000; }
.status-selesai{ background: #22c55e; color:#fff; }
.badge-status{
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
}
table img{
    width: 70px;
    border-radius: 8px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h5>🏫 Aplikasi Pengaduan</h5>
    <a href="input_pengaduan.php">📋 Input Pengaduan</a>
    <a href="histori.php" class="active">📋 Histori</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
<div class="card-custom">

<h4 class="mb-4">📋 Histori Aspirasi Saya</h4>

<!-- STATUS -->
<div class="row mb-4 text-center">
    <div class="col-md-4">
        <div class="status-box status-menunggu">
            <i class="bi bi-hourglass-split fs-3"></i>
            <strong>Menunggu</strong>
            <div><?= $menunggu ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="status-box status-proses">
            <i class="bi bi-arrow-repeat fs-3"></i>
            <strong>Diproses</strong>
            <div><?= $proses ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="status-box status-selesai">
            <i class="bi bi-check-circle-fill fs-3"></i>
            <strong>Selesai</strong>
            <div><?= $selesai ?></div>
        </div>
    </div>
</div>

<a href="input_pengaduan.php" class="btn btn-primary mb-3">
    ← Kembali ke Form Input
</a>

<!-- TABLE -->
<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead class="table-primary text-center">
<tr>
    <th>No</th>
    <th>Kategori</th>
    <th>Aspirasi</th>
    <th>Status</th>
    <th>Foto</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php
$no = $offset + 1;
if (mysqli_num_rows($query) > 0) {
while ($d = mysqli_fetch_assoc($query)) {
?>
<tr>
<td class="text-center"><?= $no++ ?></td>
<td><?= $d['ket_kategori'] ?></td>
<td><?= $d['ket'] ?></td>
<td class="text-center">
    <span class="badge-status status-<?= strtolower($d['status']) ?>">
        <?= $d['status'] ?>
    </span>

    <?php if (!empty($d['feedback'])) { ?>
        <div class="mt-1 small text-muted">
            <i class="bi bi-chat-left-text"></i>
            <?= htmlspecialchars($d['feedback']) ?>
        </div>
    <?php } ?>
</td>
<td class="text-center">
<?= ($d['foto']) ? "<img src='uploads/$d[foto]'>" : "-" ?>
</td>
<td class="text-center">
<?php if ($d['status']=="Menunggu") { ?>
<a href="siswa_edit_pengaduan.php?id=<?= $d['id_pelaporan'] ?>" class="btn btn-warning btn-sm">
<i class="bi bi-pencil"></i>
</a>
<a href="siswa_hapus_pengaduan.php?id=<?= $d['id_pelaporan'] ?>"
   onclick="return confirm('Yakin hapus data ini?')"
   class="btn btn-danger btn-sm">
<i class="bi bi-trash"></i>
</a>
<?php } else { echo "-"; } ?>
</td>
</tr>
<?php }} else { ?>
<tr><td colspan="6" class="text-center">Belum ada data</td></tr>
<?php } ?>
</tbody>
</table>
</div>

<!-- SHOW ENTRIES -->
<div class="d-flex justify-content-between align-items-center mt-3">
<form method="GET">
    <label class="text-dark">
        Tampilkan
        <select name="limit" class="form-select d-inline w-auto" onchange="this.form.submit()">
            <?php foreach ([10,20,50,100] as $l) { ?>
                <option value="<?= $l ?>" <?= ($limit==$l)?'selected':'' ?>>
                    <?= $l ?>
                </option>
            <?php } ?>
        </select>
        data
    </label>
    <input type="hidden" name="page" value="1">
</form>

<div class="text-dark">
    Total data: <strong><?= $totalData ?></strong>
</div>
</div>

<!-- PAGINATION -->
<nav class="mt-3">
<ul class="pagination justify-content-end">
<?php if ($page > 1) { ?>
<li class="page-item">
    <a class="page-link" href="?page=<?= $page-1 ?>&limit=<?= $limit ?>">Previous</a>
</li>
<?php } ?>

<?php for ($i=1; $i<=$totalPage; $i++) { ?>
<li class="page-item <?= ($page==$i)?'active':'' ?>">
    <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
</li>
<?php } ?>

<?php if ($page < $totalPage) { ?>
<li class="page-item">
    <a class="page-link" href="?page=<?= $page+1 ?>&limit=<?= $limit ?>">Next</a>
</li>
<?php } ?>
</ul>
</nav>

</div>
</div>

</body>
</html>
