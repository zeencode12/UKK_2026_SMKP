<?php
include "config/koneksi.php";

$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$password = md5($_POST['password']); // 🔑 MD5

// cek NIS
$cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('NIS sudah terdaftar!');
        window.location='register_siswa.php';
    </script>";
    exit;
}

$query = mysqli_query($conn, "
    INSERT INTO siswa (nis, password, nama, kelas)
    VALUES ('$nis', '$password', '$nama', '$kelas')
");

if ($query) {
    echo "<script>
        alert('Registrasi berhasil, silakan login');
        window.location='login_siswa.php';
    </script>";
} else {
    echo "<script>
        alert('Registrasi gagal');
        window.location='register_siswa.php';
    </script>";
}
?>
