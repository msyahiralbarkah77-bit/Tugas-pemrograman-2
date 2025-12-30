<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) header("Location: ../login.php");
$menu = mysqli_query($koneksi, "SELECT * FROM menu");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kelola Menu - stetoskos coffee</title>
  <link rel="stylesheet" href="../assets/css/menu.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>☕ Kelola Menu</h1>
      <p>
        <a href="tambah_menu.php" class="btn-add">+ Tambah Menu</a>
        <a href="dashboard.php" class="btn-back">← Kembali</a>
      </p>
    </header>

    <table class="menu-table">
      <thead>
        <tr>
          <th>Nama Menu</th>
          <th>Harga</th>
          <th>Kategori</th>
          <th>Gambar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($menu)): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama_menu']) ?></td>
          <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
          <td><?= htmlspecialchars($row['kategori']) ?></td>
          <td><img src="../assets/img/<?= $row['gambar'] ?>" alt="gambar menu" class="menu-img"></td>
          <td>
            <a href="edit_menu.php?id=<?= $row['id_menu'] ?>" class="btn-edit">Edit</a>
            <a href="hapus_menu.php?id=<?= $row['id_menu'] ?>" class="btn-delete" onclick="return confirm('Hapus menu ini?')">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
