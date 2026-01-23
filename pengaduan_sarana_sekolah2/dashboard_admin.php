<?php
session_start();
include 'config/koneksi.php';

// ================= FILTER =================
$filter_kategori = $_GET['kategori'] ?? '';
$filter_nis      = $_GET['nis'] ?? '';
$filter_tgl      = $_GET['tgl'] ?? '';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pengaduan</title>

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

<!-- SIDEBAR -->
<div class="sidebar">
    <h5>🏫 Aplikasi Pengaduan</h5>
    <a href="#" class="active">📋 Data Pengaduan</a>
    <a href="input_siswa.php">👨‍🎓 Input Siswa</a>
    <a href="import_siswa_excel.php">📥 Import siswa Excel</a>
    <a href="input_kategori.php">🏷️ Input Kategori</a>
    <a href="index.php" class="text-danger">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
<div class="card-custom">

<h4 class="mb-4">📋 Data Pengaduan Sarana Sekolah</h4>

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

    <div class="col-md-4">
        <label class="form-label">NIS</label>
        <input type="text" name="nis" class="form-control"
               value="<?= $filter_nis ?>" placeholder="Masukkan NIS">
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Pengaduan</label>
        <input type="date" name="tgl" class="form-control"
               value="<?= $filter_tgl ?>">
    </div>

    <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">🔍</button>
    </div>
</form>

<!-- TABLE -->
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
$q = mysqli_query($conn, $sql);

while($d = mysqli_fetch_array($q)){
?>
<tr>
    <td class="text-center"><?= $d['tgl_pengaduan']; ?></td>
    <td class="text-center"><?= $d['nis']; ?></td>
    <td><?= $d['ket_kategori']; ?></td>
    <td><?= $d['lokasi']; ?></td>
    <td><?= $d['ket']; ?></td>
    <td class="text-center">
        <span class="badge-status status-<?= $d['status']; ?>">
            <?= $d['status']; ?>
        </span>
    </td>
    <td class="text-center">
        <img src="uploads/<?= $d['foto']; ?>" width="60">
    </td>
    <td class="text-center">
        <a class="btn btn-info btn-sm"
           href="update_status.php?id=<?= $d['id_pelaporan']; ?>&s=Proses">
           Proses
        </a>
        <a class="btn btn-success btn-sm"
           href="update_status.php?id=<?= $d['id_pelaporan']; ?>&s=Selesai">
           Selesai
        </a>
    </td>
</tr>
<?php } ?>

</tbody>
</table>
</div>

</div>
</div>

</body>
</html>
