<?php
session_start();
include 'config/koneksi.php';

    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

mysqli_query($conn,"INSERT INTO siswa(nis,nama,kelas) VALUES('$nis','$nama','$kelas')");
echo "<script>alert('Data siswa berhasil ditambahkan');</script>";
echo "<script>window.location='input_siswa.php';</script>";
?>