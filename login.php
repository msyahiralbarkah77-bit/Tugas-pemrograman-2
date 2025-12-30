<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);
    $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$user' AND password='$pass'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['admin'] = $user;
        header("Location: admin/dashboard.php");
        exit;
    } else {
        echo "<script>alert('Login gagal! Username atau password salah.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login Admin - stetoskos coffee</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h1>☕ Login Admin</h1>
        <form method="POST" class="login-form">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" name="login" class="btn-main">Login</button>

            <!-- Tombol kembali ke beranda -->
            <a href="index.php" class="btn-main btn-back">Kembali ke Beranda</a>
        </form>
    </div>
</body>
</html>
