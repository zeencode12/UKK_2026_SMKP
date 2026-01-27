<?php
session_start();
include 'config/koneksi.php';
 // sesuaikan lokasi file

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = mysqli_query($conn, 
    "SELECT * FROM admin 
     WHERE username='$username' 
     AND password='$password'"
);

$data = mysqli_fetch_assoc($query);

if ($data) {

    $_SESSION['login'] = true;
    $_SESSION['level'] = 'admin';
    $_SESSION['admin'] = $data['username'];

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
            text: 'Selamat datang Admin ".$data['username']." 👋',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        }).then(() => {
            window.location = 'dashboard_admin.php';
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