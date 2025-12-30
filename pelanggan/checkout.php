<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    header("Location: keranjang.php");
    exit;
}

if (isset($_POST['checkout'])) {
    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $meja  = mysqli_real_escape_string($koneksi, $_POST['meja']);
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']); // ambil catatan

    // Hitung total
    $total = 0;
    foreach ($_SESSION['keranjang'] as $id => $jumlah) {
        $id = (int)$id;
        $queryMenu = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = $id");
        if (!$queryMenu) {
            die("Query error: " . mysqli_error($koneksi));
        }
        $menu = mysqli_fetch_assoc($queryMenu);
        $subtotal = $menu['harga'] * $jumlah;
        $total += $subtotal;
    }

    // Simpan ke tabel pesanan
    // Pastikan kolom di tabel ‘pesanan’ adalah: nama_pelanggan, meja, total_harga, catatan
    $queryInsertPesanan = "
        INSERT INTO pesanan (nama_pelanggan, meja, total_harga, catatan)
        VALUES ('$nama', '$meja', '$total', '$catatan')
    ";
    if (!mysqli_query($koneksi, $queryInsertPesanan)) {
        die("Insert pesanan failed: " . mysqli_error($koneksi));
    }

    $id_pesanan = mysqli_insert_id($koneksi); // mendapatkan id auto‐increment dari pesanan :contentReference[oaicite:0]{index=0}

    // Simpan detail per menu
    foreach ($_SESSION['keranjang'] as $id => $jumlah) {
        $id = (int)$id;
        // Jika kamu ingin menyimpan catatan per item, pakai kolom catatan juga di detail_pesanan
        $queryInsertDetail = "
            INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, catatan)
            VALUES ('$id_pesanan', '$id', '$jumlah', '$catatan')
        ";
        if (!mysqli_query($koneksi, $queryInsertDetail)) {
            die("Insert detail_pesanan failed: " . mysqli_error($koneksi));
        }
    }

    // Bersihkan keranjang
    unset($_SESSION['keranjang']);

    // Redirect ke halaman selesai
    header("Location: selesai.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Checkout – Stetoskos Coffee</title>
    <link rel="stylesheet" href="../assets/css/checkout.css">
</head>
<body>
    <div class="checkout-container">
        <h1>☕ Checkout Pesanan</h1>

        <form method="POST" class="checkout-form">
            <div class="form-group">
                <label for="nama">Nama Pelanggan:</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="meja">No Meja:</label>
                <input type="text" id="meja" name="meja" required>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan untuk pesanan:</label>
                <textarea id="catatan" name="catatan" rows="3" style="width:100%;"
                    placeholder="Contoh: tanpa gula, es sedikit, dll"></textarea>
            </div>

            <button type="submit" name="checkout" class="btn-submit">Kirim Pesanan</button>
        </form>

        <div class="back-link">
            <a href="keranjang.php">← Kembali ke Keranjang</a>
        </div>
    </div>
</body>
</html>
