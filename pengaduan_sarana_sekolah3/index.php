<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Aplikasi Pengaduan Sarana Sekolah</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* ===== BACKGROUND ===== */
    body {
      background-image: url('image/cool.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      min-height: 100vh;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      background-color: #5a1414 !important;
    }

    /* ===== FOOTER ===== */
    footer {
      color: #f1f1f1;
    }

    /* ===== ANIMASI MASUK ===== */
    .fade-up {
      opacity: 0;
      transform: translateY(30px);
      animation: fadeUp 0.8s ease forwards;
    }

    .fade-left {
      opacity: 0;
      transform: translateX(-40px);
      animation: fadeLeft 0.8s ease forwards;
    }

    .fade-right {
      opacity: 0;
      transform: translateX(40px);
      animation: fadeRight 0.8s ease forwards;
    }

    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeLeft {
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeRight {
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* ===== CARD INTERAKTIF ===== */
    .card {
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.35);
    }

    /* ===== BUTTON ===== */
    .btn {
      transition: all 0.3s ease;
    }

    .btn:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <span class="navbar-brand">Pengaduan Sarana Sekolah</span>
    </div>
  </nav>

  <!-- CONTENT -->
  <div class="container mt-5">
    <!-- JUDUL -->
    <div class="text-center mb-4 text-white fade-up">
      <h2>Sistem Pengaduan Sarana & Prasarana Sekolah</h2>
      <p>Laporkan kerusakan fasilitas sekolah dengan mudah dan cepat</p>
    </div>

    <!-- CARD LOGIN -->
    <div class="row justify-content-center">

      <!-- LOGIN SISWA -->
      <div class="col-md-4 mb-3 fade-left" style="animation-delay: 0.3s;">
        <div class="card shadow text-center">
          <div class="card-body">
            <img src="image/siswa.png" style="width:200px; height:200px;" alt="Siswa">
            <h5 class="card-title mt-3">Login Siswa</h5>
            <p class="card-text">Untuk menyampaikan pengaduan sarana sekolah</p>
            <a href="login_siswa.php" class="btn btn-success w-100">Masuk Siswa</a>
          </div>
        </div>
      </div>

      <!-- LOGIN ADMIN -->
      <div class="col-md-4 mb-3 fade-right" style="animation-delay: 0.5s;">
        <div class="card shadow text-center">
          <div class="card-body">
            <img src="image/admin.png" style="width:200px; height:200px;" alt="Admin">
            <h5 class="card-title mt-3">Login Admin</h5>
            <p class="card-text">Untuk mengelola dan menindaklanjuti pengaduan</p>
            <a href="login_admin.php" class="btn btn-primary w-100">Masuk Admin</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- FOOTER -->
  <footer class="text-center mt-5">
    <hr class="text-white">
    <p>© 2026 Pengaduan Sarana Sekolah | SMK Pembangunan Pacitan</p>
  </footer>

</body>
</html>
