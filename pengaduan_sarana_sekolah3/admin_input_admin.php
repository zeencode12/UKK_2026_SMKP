<?php
session_start();
include 'config/koneksi.php';

// pastikan form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ambil data & amankan
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // hash password dengan md5
    $password_md5 = md5($password);

    // cek apakah username sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
                alert('Username sudah digunakan!');
                window.location='manage_admin.php';
              </script>";
        exit;
    }

    // insert ke database
    $insert = mysqli_query($conn, 
        "INSERT INTO admin (username, password) 
         VALUES ('$username', '$password_md5')"
    );

    if ($insert) {
        echo "<script>
                alert('Admin berhasil ditambahkan!');
                window.location='manage_admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan admin!');
                window.location='manage_admin.php';
              </script>";
    }

} else {
    header("Location: manage_admin.php");
}
?>
