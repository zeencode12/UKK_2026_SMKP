<?php
include 'config/koneksi.php';

$nis = $_GET['nis'];

mysqli_query($conn, "DELETE FROM siswa WHERE nis='$nis'");

header("location:input_siswa.php");
