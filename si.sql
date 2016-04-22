-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 22 Apr 2016 pada 08.49
-- Versi Server: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `si`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id` int(5) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `tersedia` int(11) NOT NULL,
  `batas_minimum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bahan_baku`
--

INSERT INTO `bahan_baku` (`id`, `nama`, `tersedia`, `batas_minimum`) VALUES
(1, 'Beras', 30, 5),
(2, 'Gandum', 34, 5),
(3, 'Jagung', 4, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `komposisi`
--

CREATE TABLE `komposisi` (
  `id_produk` int(5) NOT NULL,
  `id_bahan` int(5) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `komposisi`
--

INSERT INTO `komposisi` (`id_produk`, `id_bahan`, `jumlah`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_operasional`
--

CREATE TABLE `pegawai_operasional` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(70) NOT NULL,
  `email` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pegawai_operasional`
--

INSERT INTO `pegawai_operasional` (`username`, `password`, `nama`, `email`) VALUES
('iafir', 'password', 'Wiwit Rifa''i', 'wiwitrifai@gmail.com'),
('wiwit', 'password', 'Wiwit Rifa''i', 'wiwitrifai@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_pengadaan`
--

CREATE TABLE `pegawai_pengadaan` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(70) NOT NULL,
  `email` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pegawai_pengadaan`
--

INSERT INTO `pegawai_pengadaan` (`username`, `password`, `nama`, `email`) VALUES
('ada1', 'password', 'ada', 'ada@ada.com'),
('ada2', 'password', 'ada', 'ada@ada.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(5) NOT NULL,
  `username` varchar(32) NOT NULL,
  `id_produk` int(5) NOT NULL,
  `tanggal` date NOT NULL,
  `harga_terjual` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id`, `username`, `id_produk`, `tanggal`, `harga_terjual`) VALUES
(1, 'wiwit', 1, '2016-03-03', 5000),
(4, 'wiwit', 3, '2015-01-01', 30000),
(5, 'iafir', 2, '2016-01-01', 3000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_bahan`
--

CREATE TABLE `pesanan_bahan` (
  `id` int(5) NOT NULL,
  `username` varchar(32) NOT NULL,
  `tanggal` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pesanan_bahan`
--

INSERT INTO `pesanan_bahan` (`id`, `username`, `tanggal`, `status`) VALUES
(1, 'ada1', '2016-04-20', 1),
(2, 'ada1', '2016-04-20', 1),
(3, 'ada1', '2016-04-20', 1),
(4, 'ada1', '2016-04-20', 1),
(5, 'ada1', '2016-04-21', 1),
(6, 'ada1', '2016-04-20', 1),
(7, 'ada1', '2016-04-21', 1),
(8, 'ada1', '2016-04-21', 1),
(9, 'ada1', '2016-04-21', 1),
(10, 'ada1', '2016-04-20', 1),
(11, 'ada1', '2016-04-21', 1),
(12, 'ada1', '2016-04-20', 1),
(13, 'ada1', '2016-04-21', 1),
(14, 'ada1', '2016-04-21', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `porsi_pesan`
--

CREATE TABLE `porsi_pesan` (
  `id_pesan` int(5) NOT NULL,
  `id_bahan` int(5) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `porsi_pesan`
--

INSERT INTO `porsi_pesan` (`id_pesan`, `id_bahan`, `jumlah`) VALUES
(0, 1, 5),
(0, 2, 0),
(12, 1, 4),
(12, 2, 5),
(13, 1, 3),
(13, 2, 2),
(14, 1, 3),
(14, 2, 2),
(14, 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(5) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `jenis` varchar(32) NOT NULL DEFAULT 'makanan',
  `harga` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `jenis`, `harga`) VALUES
(1, 'Nasi', 'makanan', 5000),
(2, 'Air Mineral', 'minuman', 2000),
(3, 'Es Teh', 'minuman', 3500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komposisi`
--
ALTER TABLE `komposisi`
  ADD PRIMARY KEY (`id_produk`,`id_bahan`);

--
-- Indexes for table `pegawai_operasional`
--
ALTER TABLE `pegawai_operasional`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pegawai_pengadaan`
--
ALTER TABLE `pegawai_pengadaan`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan_bahan`
--
ALTER TABLE `pesanan_bahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `porsi_pesan`
--
ALTER TABLE `porsi_pesan`
  ADD PRIMARY KEY (`id_pesan`,`id_bahan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pesanan_bahan`
--
ALTER TABLE `pesanan_bahan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
