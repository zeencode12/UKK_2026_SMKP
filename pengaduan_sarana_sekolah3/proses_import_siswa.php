<?php
require 'config/koneksi.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import'])) {

    $file = $_FILES['file_excel']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    for ($i = 1; $i < count($data); $i++) {

        $nis   = $data[$i][0];
        $pass = md5($data[$i][1]);
        $nama  = $data[$i][2];
        $kelas = $data[$i][3];

        if ($nis != "") {

            $sql = "INSERT INTO siswa (nis, password, nama, kelas)
                    VALUES ('$nis', '$pass', '$nama', '$kelas')";

            mysqli_query($conn, $sql);
        }
    }

    echo "<script>
        alert('Data siswa berhasil diimport!');
        window.location='input_siswa.php';
    </script>";
}
?>
