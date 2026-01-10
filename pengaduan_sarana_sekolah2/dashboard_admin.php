<?php session_start(); include 'config/koneksi.php'; ?> 
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pengaduan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body{
        background: linear-gradient(135deg, #1f2933, #111827);
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
        color: #fff;
    }

    .card-custom{
        background: #ffffff;
        color: #333;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,.25);
        margin-top: 30px;
    }

    h4{
        font-weight: 600;
        margin-bottom: 20px;
    }

    table{
        border-radius: 10px;
        overflow: hidden;
    }

    thead{
        background: #1e40af;
        color: #fff;
    }

    table th{
        text-align: center;
        vertical-align: middle;
    }

    table td{
        vertical-align: middle;
    }

    table img{
        border-radius: 8px;
        box-shadow: 0 3px 8px rgba(0,0,0,.3);
    }

    .badge-status{
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
    }

    .status-Menunggu{ background: #facc15; color: #000; }
    .status-Proses{ background: #38bdf8; color: #000; }
    .status-Selesai{ background: #22c55e; color: #fff; }

    .btn-action{
        padding: 5px 10px;
        font-size: 0.85rem;
        border-radius: 8px;
    }

    .btn-back{
        margin-top: 30px;
        border-radius: 25px;
        padding: 10px 25px;
        font-weight: 500;
    }
</style>
</head>

<body>
<div class="container">
    <div class="card-custom">
        <h4>📋 Data Pengaduan Sarana Sekolah</h4>

        <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $q = mysqli_query($conn,"SELECT * FROM input_aspirasi");
            while($d = mysqli_fetch_array($q)){
                echo "<tr>
                    <td class='text-center'>$d[nis]</td>
                    <td>$d[lokasi]</td>
                    <td class='text-center'>
                        <span class='badge-status status-$d[status]'>$d[status]</span>
                    </td>
                    <td class='text-center'>
                        <img src='uploads/$d[foto]' width='60'>
                    </td>
                    <td class='text-center'>
                        <a class='btn btn-info btn-action'
                           href='update_status.php?id=$d[id_pelaporan]&s=Proses'>Proses</a>
                        <a class='btn btn-success btn-action'
                           href='update_status.php?id=$d[id_pelaporan]&s=Selesai'>Selesai</a>
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
        </div>

        <button class="btn btn-danger btn-back" onclick="window.location='index.php'">
            ⬅ Kembali
        </button>
    </div>
</div>
</body>
</html>
