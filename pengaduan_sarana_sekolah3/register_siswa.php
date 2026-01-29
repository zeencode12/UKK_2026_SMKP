<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Siswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
        button.btn {
    background: linear-gradient(135deg, #7b1e1e, #4a0f0f);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    padding: 10px;
    transition: all 0.3s ease;
}

button.btn:hover {
    background: linear-gradient(135deg, #8f2424, #5a1414);
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(123, 30, 30, 0.4);
}

button.btn:active {
    transform: translateY(0);
    box-shadow: 0 4px 8px rgba(123, 30, 30, 0.3);
}
        .input-group-text {
            background: #fff;
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
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn w-100">Daftar</button>
    </form>

    <div class="text-center mt-3">
        <a href="login_siswa.php">Sudah punya akun? Login</a>
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
