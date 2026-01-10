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
    $_SESSION['admin'] = $data['username'];
    header("Location: dashboard_admin.php");
} else {
    echo "<script>
        alert('Login gagal!');
        window.location='login_admin.php';
    </script>";
}
