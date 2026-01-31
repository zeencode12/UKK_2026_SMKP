<?php
session_start(); 
include 'config/koneksi.php';

if(isset($_POST['kirim'])){
    $foto = $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$foto);

    mysqli_query($conn,"INSERT INTO input_aspirasi(nis,id_kategori,lokasi,ket,foto,tgl_pengaduan)
    VALUES('$_SESSION[nis]','$_POST[kategori]','$_POST[lokasi]','$_POST[ket]','$foto',CURDATE())");

    echo "<script>
            alert('Pengaduan terkirim');
            window.location='input_pengaduan.php';
          </script>";
}

$kat = mysqli_query($conn,"SELECT * FROM kategori");
?>
<!doctype html>
<html>
<head>
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

<script>
function batalPengaduan() {
    if (confirm("Apakah anda yakin ingin membatalkan input pengaduan?")) {
        window.location = "index.php";
    }
    // jika Cancel → tidak melakukan apa-apa
}
</script>

</head>

<!-- SIDEBAR -->
<div class="sidebar">
    <h5>🏫 Aplikasi Pengaduan</h5>
    <a href="input_pengaduan.php">📋 Input Pengaduan</a>
    <a href="histori.php">📋 Histori</a>
    <a href="logout.php" class="text-danger">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
<div class="card-custom">

<h4 class="mb-4">📋Input Pengaduan</h4>

<body class="mb-4">
<h4>Form Pengaduan</h4>
 <label>kategori tempat</label>
<form method="post" enctype="multipart/form-data">
    <select class="form-control mb-2" name="kategori" required>
        <?php while($k=mysqli_fetch_array($kat)){ ?>
            <option value="<?=$k['id_kategori']?>"><?=$k['ket_kategori']?></option>
        <?php } ?>
    </select>

    <label>Lokasi</label>
    <input class="form-control mb-2" name="lokasi" placeholder="Lokasi" required>

    <label>Keterangan</label>
    <textarea class="form-control mb-2" name="ket" placeholder="Keterangan" required></textarea>

    <label>Foto</label>
    <input class="form-control mb-3" type="file" name="foto">
    <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">

    <button class="btn btn-primary" name="kirim">Kirim</button>
</form>

</body>
</html>

