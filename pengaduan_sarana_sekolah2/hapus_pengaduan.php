<?php
session_start();
include 'config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,"
    DELETE FROM input_aspirasi 
    WHERE id='$id' 
    AND nis='$_SESSION[nis]' 
    AND status='Menunggu'
");