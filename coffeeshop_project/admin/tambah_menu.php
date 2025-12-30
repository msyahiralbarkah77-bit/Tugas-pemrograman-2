<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) header("Location: ../login.php");

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $harga = (int)$_POST['harga'];
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);

    $gambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar = time() . '.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../assets/img/' . $gambar);
    }

    mysqli_query($koneksi, "INSERT INTO menu (nama_menu, harga, kategori, gambar) VALUES ('$nama','$harga','$kategori','$gambar')");
    header("Location: menu.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Tambah Menu - stetoskos coffee</title>
  <link rel="stylesheet" href="../assets/css/tambah_menu.css">
</head>
<body>
  <div class="container">
    <h1>Tambah Menu</h1>

    <form method="POST" enctype="multipart/form-data" class="form-box">
      <div class="form-group">
        <label>Nama Menu</label>
        <input type="text" name="nama_menu" required>
      </div>

      <div class="form-group">
        <label>Harga</label>
        <input type="number" name="harga" required>
      </div>

      <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="kategori">
      </div>

      <div class="form-group">
        <label>Gambar</label>
        <input type="file" name="gambar">
      </div>

      <button type="submit" name="simpan" class="btn">💾 Simpan</button>
      <a href="menu.php" class="back-link">← Kembali</a>
    </form>
  </div>
</body>
</html>
