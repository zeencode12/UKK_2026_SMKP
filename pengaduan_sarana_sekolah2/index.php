<!doctype html> 
<html lang="id">
<head>
<meta charset="utf-8">
<title>Aplikasi Pengaduan Sarana Sekolah</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    background-color: #7b1e1e; /* dark red */
  }
  .navbar {
    background-color: #5a1414 !important;
  }
  footer {
    color: #f1f1f1;
  }
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <span class="navbar-brand">Pengaduan Sarana Sekolah</span>
  </div>
</nav>

<div class="container mt-5">
  <div class="text-center mb-4 text-white">
    <h2>Sistem Pengaduan Sarana & Prasarana Sekolah</h2>
    <p>Laporkan kerusakan fasilitas sekolah dengan mudah dan cepat</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-4 mb-3">
      <div class="card shadow text-center">
        <div class="card-body">
          <h5 class="card-title">Login Siswa</h5>
          <p class="card-text">Untuk menyampaikan pengaduan sarana sekolah</p>
          <a href="login_siswa.php" class="btn btn-success w-100">Masuk Siswa</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-3">
      <div class="card shadow text-center">
        <div class="card-body">
          <h5 class="card-title">Login Admin</h5>
          <p class="card-text">Untuk mengelola dan menindaklanjuti pengaduan</p>
          <a href="login_admin.php" class="btn btn-primary w-100">Masuk Admin</a>
        </div>
      </div>
    </div>
  </div>
</div>

<footer class="text-center mt-5">
  <hr class="text-white">
  <p>© 2026 Pengaduan Sarana Sekolah | SMK Pembangunan Pacitan</p>
</footer>

</body>
</html>
