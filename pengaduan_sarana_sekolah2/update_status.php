<?php
include 'config/koneksi.php';
mysqli_query($conn,"UPDATE input_aspirasi SET status='$_GET[s]' WHERE id_pelaporan='$_GET[id]'");
header("Location: dashboard_admin.php");
?>