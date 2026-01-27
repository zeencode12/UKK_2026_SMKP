<?php
session_start();
include 'config/koneksi.php';

// proteksi halaman
if (!isset($_SESSION['nis'])) {
    header("Location: login_siswa.php");
    exit;
}

$nis = $_SESSION['nis'];

$query = mysqli_query($conn, "
    SELECT p.*, k.ket_kategori
    FROM input_aspirasi p
    JOIN kategori k ON p.id_kategori = k.id_kategori
    JOIN siswa s ON p.nis = s.nis
    WHERE s.nis = '$nis'
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Histori Aspirasi Saya</title>

    <!-- CSS LANGSUNG -->
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            margin: 0;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            min-height: 100vh;
            padding: 30px;
        }

        .container-histori {
            max-width: 1100px;
            margin: auto;
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        h3 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #2c3e50;
        }

        h3::after {
            content: '';
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, #4e73df, #1cc88a);
            display: block;
            margin-top: 8px;
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 14px;
            font-size: 14px;
            text-align: center;
        }

        td {
            padding: 12px;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        tr:hover {
            background-color: #f8f9fc;
        }

        td:first-child {
            text-align: center;
            font-weight: bold;
        }

        /* BADGE STATUS */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }

        .badge-menunggu {
            background: #f6c23e;
            color: #fff;
        }

        .badge-proses {
            background: #36b9cc;
            color: #fff;
        }

        .badge-selesai {
            background: #1cc88a;
            color: #fff;
        }

        /* FOTO */
        img {
            width: 80px;
            border-radius: 8px;
            border: 2px solid #ddd;
            object-fit: cover;
            transition: 0.3s;
        }

        img:hover {
            transform: scale(1.1);
        }

        .kosong {
            text-align: center;
            color: #888;
            font-style: italic;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            th, td {
                font-size: 12px;
                padding: 10px;
            }

            img {
                width: 60px;
            }
        }
        .btn-kembali {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 18px;
    background: #4e73df;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-kembali:hover {
    background: #2e59d9;
}

    </style>
</head>
<body>

<div class="container-histori">
    <h3>Histori Aspirasi Saya</h3>

    <table>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Isi Aspirasi</th>
            <th>Status</th>
            <th>Foto</th>
        </tr>

        <?php
        $no = 1;
        if (mysqli_num_rows($query) > 0) {
            while ($data = mysqli_fetch_array($query)) {
                $status = strtolower($data['status']);
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['ket_kategori']; ?></td>
            <td><?= $data['ket']; ?></td>
            <td align="center">
                <span class="badge badge-<?= $status; ?>">
                    <?= $data['status']; ?>
                </span>
            </td>
            <td align="center">
                <?php if ($data['foto'] != '') { ?>
                    <img src="uploads/<?= $data['foto']; ?>">
                <?php } else { echo '-'; } ?>
            </td>
        </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='5' class='kosong'>Belum ada aspirasi</td></tr>";
        }
        ?>
    </table>
    <a href="input_pengaduan.php" class="btn-kembali">
    ← Kembali ke Form Pengaduan
</div>

</a>
</body>
</html>
