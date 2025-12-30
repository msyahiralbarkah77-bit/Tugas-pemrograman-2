<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['tambah'])) {
    $id = (int)$_POST['id_menu'];
    $_SESSION['keranjang'][$id] = isset($_SESSION['keranjang'][$id]) ? $_SESSION['keranjang'][$id] + 1 : 1;
    header("Location: keranjang.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    unset($_SESSION['keranjang'][$id]);
    header("Location: keranjang.php");
    exit;
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Keranjang - stetoskos coffee</title>
    <link rel="stylesheet" href="../assets/css/keranjang.css">
</head>
<body>
    <header>
        <h1>🛒 Keranjang Pesanan</h1>
    </header>

    <div class="container">
        <div class="nav-links">
            <a href="../index.php">← Kembali</a> |
            <a href="checkout.php">Lanjut ke Checkout</a>
        </div>

        <table>
            <tr>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>

            <?php
            if (!empty($_SESSION['keranjang'])):
                foreach ($_SESSION['keranjang'] as $id => $jumlah):
                    $id = (int)$id;
                    $menu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu=$id"));
                    $subtotal = $menu['harga'] * $jumlah;
                    $total += $subtotal;
            ?>
            <tr>
                <td><?= $menu['nama_menu'] ?></td>
                <td><?= $jumlah ?></td>
                <td>Rp <?= number_format($menu['harga']) ?></td>
                <td>Rp <?= number_format($subtotal) ?></td>
                <td><a class="hapus-btn" href="?hapus=<?= $id ?>">Hapus</a></td>
            </tr>
            <?php endforeach; endif; ?>

            <tr class="total-row">
                <th colspan="3">Total</th>
                <th colspan="2">Rp <?= number_format($total) ?></th>
            </tr>
        </table>
    </div>
</body>
</html>
