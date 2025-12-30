<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['admin'])) header("Location: ../login.php");
if (!isset($_GET['id'])) { header("Location: menu.php"); exit; }
$id = (int)$_GET['id'];
// optionally delete file image here
mysqli_query($koneksi, "DELETE FROM menu WHERE id_menu=$id");
header("Location: menu.php");
exit;
?>
