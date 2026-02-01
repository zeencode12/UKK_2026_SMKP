<?php
session_start();
include 'config/koneksi.php';

$id = $_GET['id'] ?? '';

$data = mysqli_query($conn, "
    SELECT id_pelaporan, feedback, status
    FROM input_aspirasi
    WHERE id_pelaporan = '$id'
");

$d = mysqli_fetch_assoc($data);

if (!$d || $d['status'] != 'Selesai') {
    header("Location: dashboard_admin.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    mysqli_query($conn, "
        UPDATE input_aspirasi
        SET feedback = '$feedback'
        WHERE id_pelaporan = '$id'
    ");

    header("Location: dashboard_admin.php");
    exit;
}
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Feedback Pengaduan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
<div class="card shadow">
<div class="card-body">

<h5 class="mb-3">✍️ Feedback Pengaduan</h5>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Feedback</label>
        <textarea name="feedback"
                  class="form-control"
                  rows="4"
                  required><?= htmlspecialchars($d['feedback'] ?? '') ?>
</textarea>
    </div>

    <button type="submit" name="simpan" class="btn btn-primary">
        💾 Simpan
    </button>
    <a href="dashboard_admin.php" class="btn btn-secondary">
        ⬅️ Kembali
    </a>
</form>

</div>
</div>
</div>

</body>
</html>
