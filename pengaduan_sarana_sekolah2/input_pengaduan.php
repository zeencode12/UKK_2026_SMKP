<?php
session_start(); 
include 'config/koneksi.php';

if(isset($_POST['kirim'])){
    $foto = $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$foto);

    mysqli_query($conn,"INSERT INTO input_aspirasi(nis,id_kategori,lokasi,ket,foto)
    VALUES('$_SESSION[nis]','$_POST[kategori]','$_POST[lokasi]','$_POST[ket]','$foto')");

    echo "<script>
            alert('Pengaduan terkirim');
            window.location='index.php';
          </script>";
}

$kat = mysqli_query($conn,"SELECT * FROM kategori");
?>
<!doctype html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script>
function batalPengaduan() {
    if (confirm("Apakah anda yakin ingin membatalkan input pengaduan?")) {
        window.location = "index.php";
    }
    // jika Cancel → tidak melakukan apa-apa
}
</script>
</head>

<body class="container mt-4">
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

    <button class="btn btn-primary" name="kirim">Kirim</button>
    <button type="button" class="btn btn-secondary ms-2" onclick="batalPengaduan()">Batal</button>
<button type="button" class="btn btn-info ms-2" onclick="window.location='histori.php'">
    Histori</button>
</form>

</body>
</html>
