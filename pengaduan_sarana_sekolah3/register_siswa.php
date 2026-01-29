<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #7b1e1e, #3d0f0f);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box {
            background: #fff;
            padding: 30px;
            width: 350px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        }
        h2 {
            text-align: center;
            color: #7b1e1e;
            margin-bottom: 20px;
        }
        button {
            background: #7b1e1e;
            color: white;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Registrasi Siswa</h2>

    <form method="post" action="proses_register_siswa.php">
        <div class="mb-3">
            <label>NIS</label>
            <input type="number" name="nis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <input type="text" name="kelas" class="form-control">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn w-100">Daftar</button>
    </form>

    <div class="text-center mt-3">
        <a href="login_siswa.php">Sudah punya akun? Login</a>
    </div>
</div>

</body>
</html>
