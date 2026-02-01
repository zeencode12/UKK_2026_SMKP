<?php
session_start();
include 'config/koneksi.php';

// ===== SEARCH =====
$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// ===== PAGINATION =====
$limit = 5; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// total data
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total 
                                   FROM kategori 
                                   WHERE ket_kategori LIKE '%$keyword%'");
$totalData = mysqli_fetch_assoc($totalQuery)['total'];
$totalPage = ceil($totalData / $limit);

// query data
$query = mysqli_query($conn, "SELECT * FROM kategori
                              WHERE ket_kategori LIKE '%$keyword%'
                              ORDER BY id_kategori ASC
                              LIMIT $limit OFFSET $offset");
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Input Kategori</title>
<link rel="icon" type="image/x-icon" href="image/school.ico">
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

    <!-- ===== FORM INPUT ===== -->
    <div class="card-custom">
        <h4 class="mb-4">🏷️ Input Kategori</h4>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="ket_kategori" class="form-control"
                       placeholder="Contoh: Laboratorium" required>
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

    <!-- ===== TABEL DATA ===== -->
    <div class="card-custom">
        <h4 class="mb-3">📄 Daftar Kategori</h4>

        <!-- SEARCH -->
        <form method="GET" class="mb-3 d-flex">
            <input type="text" name="search" class="form-control me-2"
                   placeholder="Cari kategori..."
                   value="<?= htmlspecialchars($keyword) ?>">
            <button class="btn btn-primary w-100">🔍 Cari</button>
        <div class="col-md-4">
            <a href="input_kategori.php" class="btn btn-secondary w-100">Reset</a>
        </div>
        </form>

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
            $no = $offset + 1;
            if(mysqli_num_rows($query) > 0){
                while($d = mysqli_fetch_assoc($query)){
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
            }else{
                echo "<tr>
                    <td colspan='3' class='text-center text-muted'>
                        Data tidak ditemukan
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
        </div>

        <!-- PAGINATION -->
        <nav>
        <ul class="pagination justify-content-center mt-3">

        <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= $keyword ?>">«</a>
            </li>
        <?php endif; ?>

        <?php for($i=1; $i<=$totalPage; $i++): ?>
            <li class="page-item <?= ($i==$page)?'active':'' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= $keyword ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>

        <?php if($page < $totalPage): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= $keyword ?>">»</a>
            </li>
        <?php endif; ?>

        </ul>
        </nav>
    </div>

</div>
</body>
</html>
