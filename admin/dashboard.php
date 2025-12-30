<?php
session_start();
if (!isset($_SESSION['admin'])) header("Location: ../login.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard Admin - stetoskop coffee</title>
  <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
  <header class="navbar">
    <div class="logo">
      ☕ stetoskop <span>coffee</span>
    </div>
    <div class="user-info">
      Halo, <b><?php echo htmlspecialchars($_SESSION['admin']); ?></b> | 
      <a href="../logout.php" class="logout-btn">Logout</a>
    </div>
  </header>

  <nav class="menu-bar">
    <a href="menu.php">Kelola Menu</a>
    <a href="pesanan.php">Lihat Pesanan</a>
    <a href="laporan.php">Laporan</a>
  </nav>

  <main class="content">
    <div class="welcome-card">
      <h2>Selamat Datang di Dashboard Admin ☕</h2>
      <p>Kelola menu, pesanan, dan laporan dengan mudah melalui panel ini.</p>
    </div>

    <div class="cards-container">
      <div class="card">
        <h3>📋 Kelola Menu</h3>
        <p>Tambah, ubah, atau hapus daftar menu yang tersedia di stetoskop coffee.</p>
        <a href="menu.php" class="btn">Buka</a>
      </div>
      <div class="card">
        <h3>🧾 Lihat Pesanan</h3>
        <p>Periksa dan kelola pesanan pelanggan secara real-time.</p>
        <a href="pesanan.php" class="btn">Buka</a>
      </div>
      <div class="card">
        <h3>📊 Laporan</h3>
        <p>Lihat laporan transaksi dan performa penjualan harian.</p>
        <a href="laporan.php" class="btn">Buka</a>
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 stetoskop coffee | Admin Panel</p>
  </footer>
</body>
</html>
