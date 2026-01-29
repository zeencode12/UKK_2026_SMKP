<?php
session_start();
include 'config/koneksi.php';

/* ===============================
   SEARCH + PAGINATION
================================ */
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

$limit = 10; // jumlah data per halaman
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

$where = "";
if ($search != "") {
    $where = "WHERE nis LIKE '%$search%' 
              OR nama LIKE '%$search%' 
              OR kelas LIKE '%$search%'";
}

$totalData = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM siswa $where")
);
$totalPage = ceil($totalData / $limit);

$q = mysqli_query(
    $conn,
    "SELECT * FROM siswa $where ORDER BY nama ASC LIMIT $limit OFFSET $offset"
);
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
    margin-bottom: 30px;
}
thead{
    background: #1e40af;
    color: #fff;
}
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

    <!-- ===== FORM INPUT SISWA ===== -->
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
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary">💾 Simpan</button>
            <a href="import_siswa_excel.php" class="btn btn-success">📥 Import Excel</a>
        </form>
    </div>

    <!-- ===== TABEL SISWA ===== -->
    <div class="card-custom">
        <h4 class="mb-3">📄 Daftar Siswa</h4>

        <!-- SEARCH -->
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                       placeholder="🔍 Cari NIS / Nama / Kelas..."
                       value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary w-100">Cari</button>
            </div>
            <div class="col-md-2 d-grid">
                <a href="input_siswa.php" class="btn btn-secondary w-100">Reset</a>
            </div>
            
        </form>

        <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="text-center">
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
            $no = $offset + 1;
            while($d = mysqli_fetch_assoc($q)){
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $d['nis'] ?></td>
                    <td><?= $d['nama'] ?></td>
                    <td class="text-center"><?= $d['kelas'] ?></td>
                    <td class="text-center">
                        <a href="hapus_siswa.php?nis=<?= $d['nis'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus siswa ini?')">
                           🗑 Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>

            <?php if($totalData == 0): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Data siswa tidak ditemukan
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        </div>

        <!-- PAGINATION -->
        <?php if($totalPage > 1): ?>
        <nav>
        <ul class="pagination justify-content-center mt-3">

            <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link"
                   href="?page=<?= $page-1 ?>&search=<?= $search ?>">«</a>
            </li>
            <?php endif; ?>

            <?php for($i=1; $i<=$totalPage; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link"
                   href="?page=<?= $i ?>&search=<?= $search ?>">
                   <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>

            <?php if($page < $totalPage): ?>
            <li class="page-item">
                <a class="page-link"
                   href="?page=<?= $page+1 ?>&search=<?= $search ?>">»</a>
            </li>
            <?php endif; ?>

        </ul>
        </nav>
        <?php endif; ?>

    </div>

</div>
</body>
</html>
