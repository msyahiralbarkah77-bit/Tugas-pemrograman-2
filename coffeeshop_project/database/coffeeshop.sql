-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 01:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeeshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'sair', '1d9083f3b1d79068cbd0d581481beeac');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_menu`, `jumlah`, `catatan`) VALUES
(1, 1, 5, 1, NULL),
(2, 1, 8, 1, NULL),
(3, 1, 13, 1, NULL),
(4, 2, 3, 1, NULL),
(5, 2, 12, 1, NULL),
(6, 2, 14, 1, NULL),
(7, 3, 8, 1, NULL),
(8, 3, 9, 1, NULL),
(9, 4, 13, 2, NULL),
(10, 4, 11, 1, NULL),
(11, 4, 10, 1, NULL),
(12, 5, 2, 1, NULL),
(13, 5, 3, 1, NULL),
(14, 5, 7, 1, NULL),
(15, 5, 8, 1, NULL),
(16, 5, 15, 1, NULL),
(17, 5, 11, 3, NULL),
(18, 5, 10, 1, NULL),
(19, 6, 3, 2, 'indomie goreng, gula untuk kopsus dikit aja'),
(20, 6, 8, 1, 'indomie goreng, gula untuk kopsus dikit aja'),
(21, 6, 9, 1, 'indomie goreng, gula untuk kopsus dikit aja'),
(22, 7, 8, 2, 'latte tolong ditambahkan gula sedikit'),
(23, 7, 3, 1, 'latte tolong ditambahkan gula sedikit'),
(24, 7, 14, 1, 'latte tolong ditambahkan gula sedikit'),
(25, 8, 10, 1, 'kaka baristanya manis banget deh'),
(26, 8, 5, 1, 'kaka baristanya manis banget deh'),
(27, 8, 13, 2, 'kaka baristanya manis banget deh'),
(28, 9, 3, 2, 'Gula jangan terlalu banyak'),
(29, 9, 14, 1, 'Gula jangan terlalu banyak'),
(30, 10, 2, 1, 'less sugar'),
(31, 10, 14, 1, 'less sugar'),
(32, 10, 9, 1, 'less sugar'),
(33, 10, 10, 1, 'less sugar'),
(34, 11, 13, 1, ''),
(35, 11, 15, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `kategori`, `gambar`) VALUES
(2, 'Cappuccino', 18000, 'Minuman', '1761476860.jpg'),
(3, 'Latte', 19000, 'Minuman', '1761476870.jpg'),
(4, 'Kentang Goreng', 20000, 'Makanan', '1761544378.png'),
(5, 'Roti Bakar', 20000, 'Makanan', '1761544391.jpg'),
(6, 'Dimsum', 20000, 'Makanan', '1761544420.png'),
(7, 'Americano', 16000, 'Minuman', '1761544432.jpg'),
(8, 'Kopsus Gula Aren', 20000, 'Minuman', '1761544443.png'),
(9, 'Indomie Goreng + Telur', 18000, 'Makanan', '1761538872.jpg'),
(10, 'Nasi Goreng + Telur', 25000, 'Makanan', '1761478718.jpg'),
(11, 'Mie Tek-Tek', 25000, 'Makanan', '1761478747.jpg'),
(12, 'Red Velvet', 20000, 'Minuman', '1761544469.jpg'),
(13, 'Lemon Tea', 20000, 'Minuman', '1761544483.jpg'),
(14, 'Lychee Tea', 20000, 'Minuman', '1761479198.jpg'),
(15, 'Pempek Goreng', 20000, 'Makanan', '1761479554.jpg'),
(16, 'Espresso', 12000, 'Minuman', '1761544499.jpg'),
(18, 'Indomie Rebus + Telur', 18000, 'Makanan', '1761538902.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `meja` varchar(10) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `status` enum('Menunggu','Diproses','Selesai') DEFAULT 'Menunggu',
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `nama_pelanggan`, `meja`, `total_harga`, `status`, `tanggal`, `catatan`) VALUES
(1, 'Rayan', '3', 60000, 'Selesai', '2025-10-26 11:59:41', NULL),
(2, 'sair', '1', 59000, 'Selesai', '2025-10-26 12:05:31', NULL),
(3, 'Aldi', '6', 38000, 'Selesai', '2025-10-26 13:02:56', NULL),
(4, 'ogoy', '1', 90000, 'Selesai', '2025-10-26 13:28:49', NULL),
(5, 'pace', '12', 193000, 'Selesai', '2025-10-26 13:41:55', NULL),
(6, 'julpa', '2', 76000, 'Selesai', '2025-10-27 04:02:15', 'indomie goreng, gula untuk kopsus dikit aja'),
(7, 'noval', '7', 79000, 'Selesai', '2025-10-27 04:10:49', 'latte tolong ditambahkan gula sedikit'),
(8, 'fauzan', '15', 85000, 'Selesai', '2025-10-27 04:26:28', 'kaka baristanya manis banget deh'),
(9, 'Siti', '9', 58000, 'Selesai', '2025-10-27 04:54:39', 'Gula jangan terlalu banyak'),
(10, 'sera', '3', 81000, 'Selesai', '2025-12-05 08:22:51', 'less sugar'),
(11, 'putra', '5', 40000, 'Menunggu', '2025-12-30 12:53:09', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
