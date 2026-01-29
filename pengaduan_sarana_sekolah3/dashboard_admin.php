<?php
session_start();
include 'config/koneksi.php';

// ================= JUMLAH STATUS =================
$qStatus = mysqli_query($conn, "
    SELECT status, COUNT(*) AS total
    FROM input_aspirasi
    GROUP BY status
");

$jumlah = [
    'Menunggu' => 0,
    'Proses'   => 0,
    'Selesai'  => 0
];

while($s = mysqli_fetch_assoc($qStatus)){
    $jumlah[$s['status']] = $s['total'];
}

// ================= FILTER =================
$filter_kategori = $_GET['kategori'] ?? '';
$filter_nis      = $_GET['nis'] ?? '';
$filter_tgl      = $_GET['tgl'] ?? '';

// ================= PAGINATION =================
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

// 0 = tampilkan semua data
$limit = in_array($limit, [0,5,10,25,50]) ? $limit : 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;

$offset = ($page - 1) * $limit;


// ================= TOTAL DATA =================
$sqlCount = "SELECT COUNT(*) AS total
             FROM input_aspirasi a
             WHERE 1=1";

if($filter_kategori != ''){
    $sqlCount .= " AND a.id_kategori = '$filter_kategori'";
}
if($filter_nis != ''){
    $sqlCount .= " AND a.nis LIKE '%$filter_nis%'";
}
if($filter_tgl != ''){
    $sqlCount .= " AND a.tgl_pengaduan = '$filter_tgl'";
}

$qCount    = mysqli_query($conn, $sqlCount);
$totalRow  = mysqli_fetch_assoc($qCount)['total'];
if ($limit == 0) {
    // tampil semua → pagination dimatikan
    $totalPage = 1;
    $page = 1;
    $offset = 0;
} else {
    $totalPage = ceil($totalRow / $limit);
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pengaduan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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

<div class="sidebar">
    <h5>🏫 Aplikasi Pengaduan</h5>
    <a href="dashboard_admin.php" class="active">📋 Data Pengaduan</a>
    <a href="input_siswa.php">👨‍🎓 Input Siswa</a>
    <a href="input_kategori.php">🏷️ Input Kategori</a>
    <a href="manage_admin.php">🛠️ Manage Admin</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<div class="content">
<div class="card-custom">

<h4 class="mb-4">📋 Data Pengaduan Sarana Sekolah</h4>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                <h6 class="mt-2">Menunggu</h6>
                <h4><?= $jumlah['Menunggu']; ?></h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-gear-fill fs-1 text-info"></i>
                <h6 class="mt-2">Diproses</h6>
                <h4><?= $jumlah['Proses']; ?></h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="bi bi-check-circle-fill fs-1 text-success"></i>
                <h6 class="mt-2">Selesai</h6>
                <h4><?= $jumlah['Selesai']; ?></h4>
            </div>
        </div>
    </div>
</div>


<!-- FILTER -->
<form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <label class="form-label">Kategori</label>
        <select name="kategori" class="form-select">
            <option value="">-- Semua Kategori --</option>
            <?php
            $kat = mysqli_query($conn, "SELECT * FROM kategori");
            while($k = mysqli_fetch_array($kat)){
                $sel = ($filter_kategori == $k['id_kategori']) ? 'selected' : '';
                echo "<option value='$k[id_kategori]' $sel>$k[ket_kategori]</option>";
            }
            ?>
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">NIS</label>
        <input type="text" name="nis" class="form-control"
               value="<?= $filter_nis ?>" placeholder="Masukkan NIS">
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Pengaduan</label>
        <input type="date" name="tgl" class="form-control"
               value="<?= $filter_tgl ?>">
    </div>

    <div class="col-md-1">
        <label class="form-label">Limit</label>
    <select name="limit" class="form-select" onchange="this.form.submit()">
    <option value="0" <?= ($limit==0)?'selected':'' ?>>Semua</option>
    <?php foreach([5,10,25,50] as $l): ?>
        <option value="<?= $l ?>" <?= ($limit==$l)?'selected':'' ?>>
            <?= $l ?>
        </option>
    <?php endforeach; ?>
    </select>

    </div>

    <div class="col-md-1 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">🔍</button>
    </div>
</form>


<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
<thead>
<tr>
    <th>Tanggal</th>
    <th>NIS</th>
    <th>Kategori</th>
    <th>Lokasi</th>
    <th>Keterangan</th>
    <th>Status</th>
    <th>Foto</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>

<?php
$sql = "SELECT a.*, k.ket_kategori
        FROM input_aspirasi a
        LEFT JOIN kategori k ON a.id_kategori = k.id_kategori
        WHERE 1=1";

if($filter_kategori != ''){
    $sql .= " AND a.id_kategori = '$filter_kategori'";
}
if($filter_nis != ''){
    $sql .= " AND a.nis LIKE '%$filter_nis%'";
}
if($filter_tgl != ''){
    $sql .= " AND a.tgl_pengaduan = '$filter_tgl'";
}

$sql .= " ORDER BY a.id_pelaporan DESC";

if($limit != 0){
    $sql .= " LIMIT $limit OFFSET $offset";
}

$q = mysqli_query($conn, $sql);

while($d = mysqli_fetch_assoc($q)){
?>
<tr>
    <td><?= $d['tgl_pengaduan'] ?></td>
    <td><?= $d['nis'] ?></td>
    <td><?= $d['ket_kategori'] ?></td>
    <td><?= $d['lokasi'] ?></td>
    <td><?= $d['ket'] ?></td>
    <td><span class="badge-status status-<?= $d['status'] ?>"><?= $d['status'] ?></span></td>
    <td><img src="uploads/<?= $d['foto'] ?>" width="60"></td>
    <td>
        <a class="btn btn-info btn-sm" href="update_status.php?id=<?= $d['id_pelaporan'] ?>&s=Proses">Proses</a>
        <a class="btn btn-success btn-sm" href="update_status.php?id=<?= $d['id_pelaporan'] ?>&s=Selesai">Selesai</a>
    </td>
</tr>
<?php } ?>

</tbody>
</table>
</div>

<?php if($totalPage > 1): ?>
<nav>
<ul class="pagination justify-content-center">
<?php for($i=1;$i<=$totalPage;$i++): ?>
<li class="page-item <?= ($i==$page)?'active':'' ?>">
<a class="page-link"
   href="?page=<?= $i ?>&limit=<?= $limit ?>&kategori=<?= $filter_kategori ?>&nis=<?= $filter_nis ?>&tgl=<?= $filter_tgl ?>">
   <?= $i ?>
</a>
</li>
<?php endfor; ?>
</ul>
</nav>
<?php endif; ?>

</div>
</div>

</body>
</html>
