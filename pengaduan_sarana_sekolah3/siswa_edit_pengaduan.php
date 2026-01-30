<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['nis'])) {
    header("Location: login_siswa.php");
    exit;
}

$nis = $_SESSION['nis'];
$id  = $_GET['id'];

/* Ambil data aspirasi */
$q = mysqli_query($conn, "
    SELECT * FROM input_aspirasi
    WHERE id_pelaporan='$id'
    AND nis='$nis'
    AND status='Menunggu'
");

$data = mysqli_fetch_assoc($q);
if (!$data) {
    header("Location: histori.php");
    exit;
}

/* Ambil kategori */
$qKategori = mysqli_query($conn, "SELECT * FROM kategori");

/* PROSES UPDATE */
if (isset($_POST['simpan'])) {
    $id_kategori = $_POST['id_kategori'];
    $ket         = mysqli_real_escape_string($conn, $_POST['ket']);
    $foto_lama   = $data['foto'];

    $foto = $foto_lama;

    /* Jika upload foto baru */
    if (!empty($_FILES['foto']['name'])) {
        $ext  = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = time()."_".$nis.".".$ext;

        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$foto);

        /* hapus foto lama */
        if ($foto_lama && file_exists("uploads/".$foto_lama)) {
            unlink("uploads/".$foto_lama);
        }
    }

    mysqli_query($conn, "
        UPDATE input_aspirasi SET
        id_kategori='$id_kategori',
        ket='$ket',
        foto='$foto'
        WHERE id_pelaporan='$id'
        AND nis='$nis'
    ");

    header("Location: histori.php");
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Aspirasi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<div class="card shadow p-4">
<h4 class="mb-3">✏️ Edit Aspirasi</h4>

<form method="post" enctype="multipart/form-data">

<!-- KATEGORI -->
<div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="id_kategori" class="form-select" required>
        <?php while ($k = mysqli_fetch_assoc($qKategori)) { ?>
        <option value="<?= $k['id_kategori'] ?>"
            <?= ($k['id_kategori']==$data['id_kategori'])?'selected':'' ?>>
            <?= $k['ket_kategori'] ?>
        </option>
        <?php } ?>
    </select>
</div>

<!-- ISI ASPIRASI -->
<div class="mb-3">
    <label class="form-label">Isi Aspirasi</label>
    <textarea name="ket" class="form-control" rows="4" required><?= $data['ket'] ?></textarea>
</div>

<!-- FOTO -->
<div class="mb-3">
    <label class="form-label">Foto (opsional)</label><br>
    <?php if ($data['foto']) { ?>
        <img src="uploads/<?= $data['foto'] ?>" width="120" class="mb-2 rounded"><br>
    <?php } ?>
    <input type="file" name="foto" class="form-control">
    <small class="text-muted">Kosongkan jika tidak diganti</small>
</div>

<!-- BUTTON -->
<button type="submit" name="simpan" class="btn btn-primary">
    💾 Simpan Perubahan
</button>
<a href="histori.php" class="btn btn-secondary">Batal</a>

</form>
</div>
</div>

</body>
</html>
