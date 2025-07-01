-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 01:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kookiez`
--

-- --------------------------------------------------------

--
-- Table structure for table `nadira_detail_pesanan`
--

CREATE TABLE `nadira_detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(5) NOT NULL,
  `harga_satuan` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nadira_detail_pesanan`
--

INSERT INTO `nadira_detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah`, `harga_satuan`) VALUES
(3, 2, 3, 1, 50000.00),
(4, 3, 3, 1, 50000.00),
(5, 4, 7, 5, 70000.00),
(6, 5, 5, 1, 20000.00),
(7, 5, 7, 1, 70000.00),
(8, 6, 2, 1, 45000.00);

-- --------------------------------------------------------

--
-- Table structure for table `nadira_kategori`
--

CREATE TABLE `nadira_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nadira_kategori`
--

INSERT INTO `nadira_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Drop Cookies'),
(2, 'Bar Cookies '),
(3, 'Moulded Cookies'),
(4, 'Piped Cookies'),
(5, 'Pressed Cookies'),
(6, 'Rolled Cookies'),
(7, 'Refrigerator Cookies'),
(8, 'Sandwich Cookies');

-- --------------------------------------------------------

--
-- Table structure for table `nadira_pengguna`
--

CREATE TABLE `nadira_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `peran` enum('admin','pelanggan') NOT NULL DEFAULT 'pelanggan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nadira_pengguna`
--

INSERT INTO `nadira_pengguna` (`id_pengguna`, `nama_lengkap`, `email`, `password`, `alamat`, `peran`) VALUES
(3, 'Joko tingkir', 'jokotingkir@gmail.com', '$2y$10$GkuLyOQzjCmS6OtnAIXHy.aTgWVhhxtkBQFjGlcnqqrFU5uYzZ5aK', 'jawa tengah', 'pelanggan'),
(4, 'Nadira', 'nadiraadmin@gmail.com', '$2y$10$By8wuEm/sjMt6yco7bfQ/.NhkIG/hkjCJe8Qr7BmlQCxdtCQ5Uc/m', 'Di atas bumi', 'admin'),
(5, 'Nadira putri rahayu', 'andinnnyy00@gmail.com', '$2y$10$VUlhLHzus4CI.zMdOh9Qk.Rv.7h2I.PNRHOS1b8TkgP46g1cuzeF2', 'padang', 'pelanggan'),
(7, 'dirga', 'faa@gmail.com', '$2y$10$BaLykAPyKumldvfpeypUwu/DMPZKJVs1UUTWkSnTLwESr/JGOcQoW', 'padang\r\n', 'pelanggan'),
(8, 'dirga', 'dirga@gmail.com', '$2y$10$z6TzMxQ3DOcukc6iDDWv/Ok8nypLG1CU4cBrisQFlXJboVytxNR/m', 'lubuk alung', 'pelanggan'),
(10, 'yuli elmita', 'yuli@gmail.com', '$2y$10$Hzud2gTWteDmLtigN8pDA.IJnHA8UmdMp9JtXZFZvU8oD/nO5oRLS', 'naras pariaman', 'pelanggan'),
(11, 'zicka am', 'am@gmail.com', '$2y$10$mc87.PpCuM7IX2jb7fGEoO/rd/v5GD77USYWWKy2ooRf13e18S5p.', 'taplau', 'pelanggan');

-- --------------------------------------------------------

--
-- Table structure for table `nadira_pesanan`
--

CREATE TABLE `nadira_pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `tanggal_pesanan` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_harga` decimal(10,2) NOT NULL,
  `status_pesanan` enum('pending','processing','shipped','completed','cancelled') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nadira_pesanan`
--

INSERT INTO `nadira_pesanan` (`id_pesanan`, `id_pengguna`, `tanggal_pesanan`, `total_harga`, `status_pesanan`) VALUES
(2, 5, '2025-06-24 17:18:58', 50000.00, 'pending'),
(3, 7, '2025-06-24 17:21:02', 50000.00, 'pending'),
(4, 10, '2025-06-26 05:22:29', 350000.00, 'pending'),
(5, 4, '2025-06-28 14:20:29', 90000.00, 'pending'),
(6, 11, '2025-06-29 23:07:22', 45000.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `nadira_produk`
--

CREATE TABLE `nadira_produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(5) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nadira_produk`
--

INSERT INTO `nadira_produk` (`id_produk`, `id_kategori`, `nama_produk`, `deskripsi`, `harga`, `stok`, `gambar`) VALUES
(2, 1, 'Cokelat Drop Cookies', 'Cookies praktis yang dibuat dengan hanya menjatuhkan adonan ke loyang, menghasilkan bentuk yang rustic dan rasa yang lezat.', 45000.00, 28, 'Cokelat Drop Cookies.jpg'),
(3, 2, 'M&M Bar Cookies', 'Cookies yang dipanggang dalam loyang lalu dipotong menjadi persegi, cocok untuk cemilan padat dan memuaskan dengan tambahan kacang M&M di dalamnya.', 50000.00, 13, 'M&M Bar Cookies.jpeg'),
(5, 3, '(DISKON!!!!)matcha series', 'kolaborasi rumput+susu+tepung', 20000.00, 99, 'matcha.jpeg'),
(6, 6, 'redvelvet', 'sangat enak bagi penggemar redvelvet\r\ndibuat dengan bahan premium', 50000.00, 50, 'redvelvet.jpeg'),
(7, 8, 'sweety cetak', 'kolaborasi roti dan iput padang.. menjadikan sandwit ini paling diminati', 70000.00, 99, 'putri padang.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nadira_detail_pesanan`
--
ALTER TABLE `nadira_detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `nadira_kategori`
--
ALTER TABLE `nadira_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `nadira_pengguna`
--
ALTER TABLE `nadira_pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `nadira_pesanan`
--
ALTER TABLE `nadira_pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `nadira_produk`
--
ALTER TABLE `nadira_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nadira_detail_pesanan`
--
ALTER TABLE `nadira_detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `nadira_kategori`
--
ALTER TABLE `nadira_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nadira_pengguna`
--
ALTER TABLE `nadira_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nadira_pesanan`
--
ALTER TABLE `nadira_pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nadira_produk`
--
ALTER TABLE `nadira_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nadira_detail_pesanan`
--
ALTER TABLE `nadira_detail_pesanan`
  ADD CONSTRAINT `nadira_detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `nadira_pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nadira_detail_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `nadira_produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nadira_pesanan`
--
ALTER TABLE `nadira_pesanan`
  ADD CONSTRAINT `nadira_pesanan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `nadira_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nadira_produk`
--
ALTER TABLE `nadira_produk`
  ADD CONSTRAINT `nadira_produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `nadira_kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
