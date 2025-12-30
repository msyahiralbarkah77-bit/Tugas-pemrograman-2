<?php
$koneksi = mysqli_connect("localhost", "root", "", "coffeeshop");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>