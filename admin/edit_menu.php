<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) header("Location: ../login.php");

if (!isset($_GET['id'])) { header("Location: menu.php"); exit; }
$id = (int)$_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu=$id"));

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $harga = (int)$_POST['harga'];
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);

    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar = time() . '.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../assets/img/' . $gambar);
        mysqli_query($koneksi, "UPDATE menu SET nama_menu='$nama', harga='$harga', kategori='$kategori', gambar='$gambar' WHERE id_menu=$id");
    } else {
        mysqli_query($koneksi, "UPDATE menu SET nama_menu='$nama', harga='$harga', kategori='$kategori' WHERE id_menu=$id");
    }
    header("Location: menu.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Edit Menu - stetoskos coffee</title>
  <link rel="stylesheet" href="../assets/css/edit_menu.css">
</head>
<body>
  <div class="container">
    <h1>Edit Menu</h1>

    <form method="POST" enctype="multipart/form-data" class="form-box">
      <div class="form-group">
        <label>Nama Menu</label>
        <input type="text" name="nama_menu" value="<?= htmlspecialchars($data['nama_menu']) ?>" required>
      </div>

      <div class="form-group">
        <label>Harga</label>
        <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
      </div>

      <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']) ?>">
      </div>

      <div class="form-group">
        <label>Gambar (biarkan jika tidak ingin ganti)</label>
        <input type="file" name="gambar">
      </div>

      <button type="submit" name="update" class="btn">✏️ Update</button>
      <a href="menu.php" class="back-link">← Kembali</a>
    </form>
  </div>
</body>
</html>
