<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login Siswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg, #7b1e1e, #3d0f0f);
    min-height: 100vh;
    display: flex;
    align-items: center;
}
.card{
    border-radius: 15px;
}
.form-control{
    border-radius: 10px;
}
.btn{
    border-radius: 10px;
}
.btn-login{
    background-color: #7b1e1e;
    border: none;
}
.btn-login:hover{
    background-color: #5a1414;
}
</style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-body p-4">

                    <h4 class="text-center mb-4 fw-bold">Login Siswa</h4>

                    <form method="post">
                        <input type="text" name="nis" class="form-control mb-3" placeholder="Masukkan NIS" required>
                        <input type="text" name="kelas" class="form-control mb-3" placeholder="Masukkan Kelas" required>

                        <button name="login" class="btn btn-login text-white w-100">Login</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="index.php" class="btn btn-outline-danger btn-sm">Kembali</a>
                    </div>

                    <?php
                    session_start();
                    
                    include 'config/koneksi.php';

                    if(isset($_POST['login'])){
                        $n = $_POST['nis'];
                        $k = $_POST['kelas'];

                        $q = mysqli_query($conn,"SELECT * FROM siswa WHERE nis='$n' AND kelas='$k'");
                        if(mysqli_num_rows($q) > 0){
                            $_SESSION['nis'] = $n;
                            header("Location: input_pengaduan.php");
                        } else {
                            echo "<div class='alert alert-danger mt-3 text-center'>Login gagal</div>";
                        }
                    }
                    ?>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
