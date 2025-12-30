<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) header("Location: ../login.php");

$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

$query = "
    SELECT 
        p.*, 
        GROUP_CONCAT(m.nama_menu SEPARATOR ',') AS menu,
        GROUP_CONCAT(dp.jumlah SEPARATOR ',') AS jumlah,
        GROUP_CONCAT(m.harga SEPARATOR ',') AS harga
    FROM pesanan p
    JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
    JOIN menu m ON dp.id_menu = m.id_menu
";
if ($tanggal != '') {
    $query .= " WHERE DATE(p.tanggal) = '$tanggal'";
}
$query .= " GROUP BY p.id_pesanan ORDER BY p.tanggal DESC";
$laporan = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Laporan Pesanan - stetoskos coffee</title>
  <link rel="stylesheet" href="../assets/css/laporan.css">
  <style>
    /* tambahan khusus */
    .harga-list {
      min-width: 120px;
      text-align: right;
      white-space: pre-line;
    }
    .status.diproses {
      background-color: #007bff;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <a href="dashboard.php" class="back-link">← Kembali</a>
      <h1>🧾 Laporan Pesanan</h1>
    </div>

    <form method="GET" class="filter-form">
      <label for="tanggal">📅 Pilih Tanggal:</label>
      <input type="date" name="tanggal" id="tanggal" value="<?= htmlspecialchars($tanggal) ?>">
      <button type="submit" class="btn-filter">Tampilkan</button>
      <button type="button" class="btn-cetak" onclick="window.print()">🖨️ Cetak Laporan</button>
    </form>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Meja</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($laporan) > 0): ?>
            <?php while($p = mysqli_fetch_assoc($laporan)): ?>
              <?php
                $menuArr = explode(',', $p['menu']);
                $jumlahArr = explode(',', $p['jumlah']);
                $hargaArr = explode(',', $p['harga']);
                $hargaList = "";
                $menuTotal = 0;
                for ($i = 0; $i < count($menuArr); $i++) {
                    $jml = (int)$jumlahArr[$i];
                    $harga = (int)$hargaArr[$i];
                    $subtotal = $jml * $harga;
                    $hargaList .= "Rp " . number_format($subtotal, 0, ',', '.') . "\n";
                    $menuTotal += $subtotal;
                }
              ?>
              <tr>
                <td><?= $p['id_pesanan'] ?></td>
                <td><?= htmlspecialchars($p['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($p['meja']) ?></td>
                <td class="menu-list"><?= nl2br(htmlspecialchars(implode("\n", $menuArr))) ?></td>
                <td class="jumlah-list"><?= nl2br(htmlspecialchars(implode("\n", $jumlahArr))) ?></td>
                <td class="harga-list"><?= nl2br(htmlspecialchars($hargaList)) ?></td>
                <td>Rp <?= number_format($menuTotal, 0, ',', '.') ?></td>
                <td class="status <?= strtolower($p['status']) ?>"><?= htmlspecialchars($p['status']) ?></td>
                <td><?= $p['tanggal'] ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="9" style="text-align:center; color:#888;">Tidak ada data untuk tanggal ini.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
