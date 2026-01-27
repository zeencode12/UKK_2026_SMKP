<?php
session_start();
include 'config/koneksi.php';
 // sesuaikan lokasi file

$nis = $_POST['nis'];
$password = md5($_POST['password']);

$query = mysqli_query($conn, 
    "SELECT * FROM siswa
     WHERE nis='$nis' 
     AND password='$password'"
);

$data = mysqli_fetch_assoc($query);

if ($data) {

    $_SESSION['login'] = true;
    $_SESSION['level'] = 'siswa';
    $_SESSION['nis'] = $data['nis'];

    echo "
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil',
            text: 'Selamat datang ".$data['nama']." 👋',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        }).then(() => {
            window.location = 'input_pengaduan.php';
        });
        </script>
    </body>
    </html>";
    exit;

} else {
    echo "<script>
        alert('Login gagal! Username atau password salah');
        window.location='index.php';
    </script>";
}