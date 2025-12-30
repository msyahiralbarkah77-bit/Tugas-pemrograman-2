<?php
include 'config/koneksi.php';

// Ambil data minuman dan makanan secara terpisah
$minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE kategori='Minuman'");
$makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE kategori='Makanan'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>stetoskos coffee - Menu</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- ===== HEADER ===== -->
  <header>
    <div class="header-content">
      <h1>☕ stetoskop coffee</h1>
      <p class="tagline">Temani harimu dengan secangkir kebahagiaan</p>
    </div>
  </header>

  <!-- ===== NAVBAR ===== -->
  <nav>
    <a href="index.php">🏠 Beranda</a>
    <a href="pelanggan/keranjang.php">🛒 Keranjang</a>
    <a href="login.php">🔐 Admin</a>
  </nav>

  <!-- ===== MENU GRID: MINUMAN ===== -->
  <main>
    <h2 class="section-title">☕ Minuman</h2>
    <div class="menu-container">
      <?php while($row = mysqli_fetch_assoc($minuman)): ?>
        <div class="menu-item">
          <div class="menu-img">
            <img src="assets/img/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_menu']; ?>">
          </div>
          <div class="menu-info">
            <h3><?php echo $row['nama_menu']; ?></h3>
            <p class="price">Rp <?php echo number_format($row['harga']); ?></p>
            <form action="pelanggan/keranjang.php" method="POST">
              <input type="hidden" name="id_menu" value="<?php echo $row['id_menu']; ?>">
              <button type="submit" name="tambah" class="btn-primary">Tambah ke Keranjang</button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- ===== MENU GRID: MAKANAN ===== -->
    <h2 class="section-title">🍽️ Makanan</h2>
    <div class="menu-container">
      <?php while($row = mysqli_fetch_assoc($makanan)): ?>
        <div class="menu-item">
          <div class="menu-img">
            <img src="assets/img/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_menu']; ?>">
          </div>
          <div class="menu-info">
            <h3><?php echo $row['nama_menu']; ?></h3>
            <p class="price">Rp <?php echo number_format($row['harga']); ?></p>
            <form action="pelanggan/keranjang.php" method="POST">
              <input type="hidden" name="id_menu" value="<?php echo $row['id_menu']; ?>">
              <button type="submit" name="tambah" class="btn-primary">Tambah ke Keranjang</button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </main>

  <!-- ===== FOOTER ===== -->
  <footer>
    <p>© 2025 <strong>stetoskop coffee</strong> — dibuat oleh Muhammad Syahir Al Barkah</p>
  </footer>

</body>
</html>
