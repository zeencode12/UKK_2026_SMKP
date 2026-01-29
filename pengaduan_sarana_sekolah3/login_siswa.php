<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #7b1e1e, #3d0f0f);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: #fff;
            padding: 30px;
            width: 320px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #7b1e1e;
        }

        label {
            font-weight: bold;
            font-size: 14px;
        }

        .form-control {
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #7b1e1e;
            box-shadow: 0 0 0 2px rgba(123,30,30,0.2);
        }

        /* Tombol Login */
        .btn-login {
            background: linear-gradient(135deg, #7b1e1e, #4a0f0f);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #8f2424, #5a1414);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(123,30,30,0.4);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px rgba(123,30,30,0.3);
        }

        .input-group-text {
            background: #fff;
            cursor: pointer;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Siswa</h2>

    <form method="post" action="proses_login_siswa.php">

        <div class="mb-3">
            <label>NIS</label>
            <input type="text" name="nis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="input-group-text" onclick="togglePassword()">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-login w-100">Login</button>
    </form>

    <div class="text-center mt-2">
        <a href="register_siswa.php">Belum punya akun? Daftar</a>
    </div>

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-outline-danger btn-sm">Kembali</a>
    </div>

    <div class="footer">
        © 2026 Aplikasi Pengaduan Sekolah
    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    if (password.type === "password") {
        password.type = "text";
        eyeIcon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        password.type = "password";
        eyeIcon.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>

</body>
</html>
