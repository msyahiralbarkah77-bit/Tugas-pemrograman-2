<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) header("Location: ../login.php");

// Aksi update status
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $aksi = $_GET['aksi'];
    if ($aksi == 'proses') {
        mysqli_query($koneksi, "UPDATE pesanan SET status='Diproses' WHERE id_pesanan=$id");
    } elseif ($aksi == 'selesai') {
        mysqli_query($koneksi, "UPDATE pesanan SET status='Selesai' WHERE id_pesanan=$id");
    }
    header("Location: pesanan.php");
    exit;
}

// Ambil data pesanan termasuk kolom catatan
$query = "
    SELECT 
        p.*,
        GROUP_CONCAT(m.nama_menu SEPARATOR ', ') AS menu,
        GROUP_CONCAT(dp.jumlah SEPARATOR ', ') AS jumlah,
        GROUP_CONCAT(CONCAT('Rp ', FORMAT(m.harga,0)) SEPARATOR ', ') AS harga
    FROM pesanan p
    JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
    JOIN menu m ON dp.id_menu = m.id_menu
    GROUP BY p.id_pesanan
    ORDER BY p.tanggal DESC
";
$pesanan = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Pesanan – Stetoskos Coffee</title>
  <link rel="stylesheet" href="../assets/css/pesanan.css">
</head>
<body>
  <div class="container">
    <div class="header">
      <a href="dashboard.php" class="back-link">← Kembali ke Dashboard</a>
      <h1>☕ Daftar Pesanan</h1>
    </div>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Meja</th>
            <th>Total</th>
            <th>Catatan</th> <!-- kolom catatan ditambahkan -->
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($p = mysqli_fetch_assoc($pesanan)): ?>
          <tr>
            <td><?= $p['id_pesanan'] ?></td>
            <td><?= htmlspecialchars($p['nama_pelanggan']) ?></td>
            <td><?= htmlspecialchars($p['meja']) ?></td>
            <td>Rp <?= number_format($p['total_harga']) ?></td>
            <td><?= nl2br(htmlspecialchars($p['catatan'] ?: '-')) ?></td> <!-- tampil catatan -->
            <td class="status <?= strtolower($p['status']) ?>">
              <?= htmlspecialchars($p['status']) ?>
            </td>
            <td><?= $p['tanggal'] ?></td>
            <td>
              <button class="btn-detail" onclick="showDetail('<?= htmlspecialchars($p['menu'], ENT_QUOTES) ?>','<?= htmlspecialchars($p['jumlah'], ENT_QUOTES) ?>','<?= htmlspecialchars($p['harga'], ENT_QUOTES) ?>')">👁 Detail</button>
              <?php if ($p['status']=='Menunggu'): ?>
                <a href="?aksi=proses&id=<?= $p['id_pesanan'] ?>" class="btn-proses">Proses</a>
              <?php elseif ($p['status']=='Diproses'): ?>
                <a href="?aksi=selesai&id=<?= $p['id_pesanan'] ?>" class="btn-selesai">Selesai</a>
              <?php else: ?>
                <span class="done">✓</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div id="modalDetail" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>🧾 Detail Pesanan</h2>
      <div id="detailContainer"></div>
    </div>
  </div>

  <script>
    function showDetail(menu, jumlah, harga) {
      const m = menu.split(', ');
      const j = jumlah.split(', ');
      const h = harga.split(', ');
      let detail = "<table class='modal-table'><tr><th>Menu</th><th>Jumlah</th><th>Harga</th></tr>";
      for (let i = 0; i < m.length; i++) {
        detail += `<tr><td>${m[i]}</td><td>${j[i]}</td><td>${h[i]}</td></tr>`;
      }
      detail += "</table>";
      document.getElementById('detailContainer').innerHTML = detail;
      document.getElementById('modalDetail').style.display = 'flex';
    }

    function closeModal() {
      document.getElementById('modalDetail').style.display = 'none';
    }

    window.onclick = function(e) {
      const modal = document.getElementById('modalDetail');
      if (e.target == modal) modal.style.display = 'none';
    }
  </script>
</body>
</html>
