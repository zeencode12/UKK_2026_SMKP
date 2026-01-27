<?php
require 'config/koneksi.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import'])) {

    $file = $_FILES['file_excel']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    // Mulai dari baris ke-2 (skip header)
    for ($i = 1; $i < count($data); $i++) {

        $nis   = $data[$i][0];
        $nama  = $data[$i][1];
        $kelas = $data[$i][2];

        if ($nis != "") {
            mysqli_query($conn, "
                INSERT INTO siswa (nis, nama, kelas)
                VALUES ('$nis', '$nama', '$kelas')
            ");
        }
    }

    echo "
    <script>
        alert('Data siswa berhasil diimport!');
        window.location='input_siswa.php';
    </script>
    ";
}
?>
