-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2022 at 05:58 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spatolacake`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_dasarkue`
--

CREATE TABLE `t_dasarkue` (
  `id_dasarkue` int(11) NOT NULL,
  `id_kue` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_dasarkue`
--

INSERT INTO `t_dasarkue` (`id_dasarkue`, `id_kue`, `nama`) VALUES
(69, 'K001', 'Lapis Surabaya'),
(70, 'K001', 'Vanilla Sponge Cake'),
(71, 'K001', 'Chocolate Sponge Cake'),
(72, 'K002', 'Pondan Sponge Cake'),
(73, 'K002', 'Vanilla Sponge Cake'),
(74, 'K002', 'Double Chocolate'),
(88, 'K003', 'Pondan Sponge Cake'),
(89, 'K003', 'Double Chocolate'),
(90, 'K003', 'Cotton Cake');

-- --------------------------------------------------------

--
-- Table structure for table `t_detailkeranjang`
--

CREATE TABLE `t_detailkeranjang` (
  `id_detail` int(11) NOT NULL,
  `id_keranjang` varchar(100) NOT NULL,
  `id_kue` varchar(100) NOT NULL,
  `id_dasarkue` int(11) DEFAULT 0,
  `id_ukurankue` int(11) DEFAULT 0,
  `jumlah` int(11) DEFAULT 0,
  `sub_total` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_detailkeranjang`
--

INSERT INTO `t_detailkeranjang` (`id_detail`, `id_keranjang`, `id_kue`, `id_dasarkue`, `id_ukurankue`, `jumlah`, `sub_total`) VALUES
(131, 'SHPCRT001', 'K001', 0, 83, 1, 180000);

-- --------------------------------------------------------

--
-- Table structure for table `t_diskon`
--

CREATE TABLE `t_diskon` (
  `id_diskon` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `potongan` int(11) NOT NULL,
  `tanggal_dibuat` date NOT NULL,
  `tanggal_berakhir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_diskon`
--

INSERT INTO `t_diskon` (`id_diskon`, `nama`, `potongan`, `tanggal_dibuat`, `tanggal_berakhir`) VALUES
(24, 'cobaspatola', 10000, '2022-11-02', '2022-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `t_formulirpemesanan`
--

CREATE TABLE `t_formulirpemesanan` (
  `id_formulir` int(11) NOT NULL,
  `id_pemesanan` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_formulirpemesanan`
--

INSERT INTO `t_formulirpemesanan` (`id_formulir`, `id_pemesanan`, `nama`, `no_telp`, `email`, `alamat`) VALUES
(54, 'ORDR001', 'Deffin AD', '085721350359', 'deffinjr890@gmail.com', 'Pajajaran, Bandung');

-- --------------------------------------------------------

--
-- Table structure for table `t_kategori`
--

CREATE TABLE `t_kategori` (
  `id_kategori` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_kategori`
--

INSERT INTO `t_kategori` (`id_kategori`, `nama`, `gambar`) VALUES
('KT01', 'Whole Cake', 'contoh7.png'),
('KT02', 'Kue Ulang Tahun', 'contoh19.png'),
('KT03', 'Dessert Box', 'contoh14.png'),
('KT04', 'Kue Kering & Roti', 'contoh4.png');

-- --------------------------------------------------------

--
-- Table structure for table `t_keranjang`
--

CREATE TABLE `t_keranjang` (
  `id_keranjang` varchar(100) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `total` int(11) DEFAULT 0,
  `catatan` text DEFAULT NULL,
  `diskon` int(11) DEFAULT 0,
  `biaya_pengiriman` int(11) DEFAULT NULL,
  `status_aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_keranjang`
--

INSERT INTO `t_keranjang` (`id_keranjang`, `id_user`, `total`, `catatan`, `diskon`, `biaya_pengiriman`, `status_aktif`) VALUES
('SHPCRT001', '114296107908236623288', 180000, 'testing 1', 0, 25000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_kontak`
--

CREATE TABLE `t_kontak` (
  `id_kontak` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_kontak`
--

INSERT INTO `t_kontak` (`id_kontak`, `nama`, `no_telp`, `email`, `pesan`) VALUES
(38, 'Deffin AD', '085721350359', 'deffinjr890@gmail.com', 'Masukan dari saya kurang fitur notifikasi sehingga jika ada pemberitahuan, customer mengetahui akan adanya konfirmasi status'),
(39, 'Deffin AD', '085721350359', 'deffinjr890@gmail.com', 'testing'),
(40, 'Deffin AD', '085721350359', 'deffinjr890@gmail.com', 'testing');

-- --------------------------------------------------------

--
-- Table structure for table `t_kue`
--

CREATE TABLE `t_kue` (
  `id_kue` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `id_kategori` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `informasi` text NOT NULL,
  `status_aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_kue`
--

INSERT INTO `t_kue` (`id_kue`, `nama`, `gambar`, `id_kategori`, `deskripsi`, `informasi`, `status_aktif`) VALUES
('K001', 'Dalgona Cake', '1664707892_094056eb2d91221a2f5b.png', 'KT01', 'Dalgona deskripsi', 'Dalgona informasi', 1),
('K002', 'Numeric Cake with Edible Flower', '1664708139_51c27f7459ee9a9f1d88.png', 'KT02', 'Numeric Cake with Edible Flower Deskripsi', 'Numeric Cake with Edible Flower Informasi', 1),
('K003', 'Nastar Crumble Cake', '1664708230_6ed5a3448a406c30301d.png', 'KT01', 'Nastar Crumble Cake Deskripsi', 'Nastar Crumble Cake Informasi', 1),
('K004', 'Brownies', '1664708381_985ee6f4be98cd1fd263.png', 'KT03', 'Brownies Deskripsi', 'Brownies Informasi', 1),
('K006', 'Donat', '1664708506_70882aad313b071efd8f.png', 'KT04', 'Donat Deskripsi', 'Donat Informasi', 1),
('K007', '', '', 'KT01', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_pembayaran`
--

CREATE TABLE `t_pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemesanan` varchar(100) NOT NULL,
  `no_pembayaran` varchar(100) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipe_pembayaran` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `status_file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_pembayaran`
--

INSERT INTO `t_pembayaran` (`id_pembayaran`, `id_pemesanan`, `no_pembayaran`, `tanggal`, `tipe_pembayaran`, `status`, `status_file`) VALUES
(20, 'ORDR001', 'ORDR001-1710650325', '2022-10-28 12:59:42', 'bank_transfer', 'settlement', 'https://app.sandbox.midtrans.com/snap/v1/transactions/afe18550-629d-4413-89f0-47be65e81850/pdf');

-- --------------------------------------------------------

--
-- Table structure for table `t_pemesanan`
--

CREATE TABLE `t_pemesanan` (
  `id_pemesanan` varchar(100) NOT NULL,
  `id_user` varchar(100) NOT NULL,
  `id_keranjang` varchar(100) NOT NULL,
  `tgl_pemesanan` date NOT NULL,
  `tgl_perkiraanselesai` date NOT NULL,
  `konfirmasi_status` varchar(100) NOT NULL,
  `total_pembayaran` int(11) NOT NULL,
  `status_aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_pemesanan`
--

INSERT INTO `t_pemesanan` (`id_pemesanan`, `id_user`, `id_keranjang`, `tgl_pemesanan`, `tgl_perkiraanselesai`, `konfirmasi_status`, `total_pembayaran`, `status_aktif`) VALUES
('ORDR001', '114296107908236623288', 'SHPCRT001', '2022-10-28', '2022-11-05', 'Pesanan Sedang Diproses', 205000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_pengembalian`
--

CREATE TABLE `t_pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alasan` text NOT NULL,
  `buktiGambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_pengembalian`
--

INSERT INTO `t_pengembalian` (`id_pengembalian`, `nama`, `no_telp`, `email`, `alasan`, `buktiGambar`) VALUES
(2, 'Deffin AD', '085721350359', 'deffinjr890@gmail.com', 'halloww', '1667404598_5518313c0a35f8e06ec7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `t_ukurankue`
--

CREATE TABLE `t_ukurankue` (
  `id_ukurankue` int(11) NOT NULL,
  `id_kue` varchar(100) NOT NULL,
  `ukuran` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_ukurankue`
--

INSERT INTO `t_ukurankue` (`id_ukurankue`, `id_kue`, `ukuran`, `harga`) VALUES
(83, 'K001', '18cm', 180000),
(84, 'K001', '20cm', 190000),
(85, 'K002', '20cm', 250000),
(86, 'K003', '18cm', 150000),
(90, 'K004', '0cm', 150000),
(100, 'K006', '0cm', 200000);

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id_user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `no_telp` varchar(100) NOT NULL DEFAULT '',
  `alamat` text NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL DEFAULT '',
  `dibuat_pada` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `diedit_pada` timestamp NULL DEFAULT NULL,
  `status_aktif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id_user`, `email`, `nama`, `password`, `no_telp`, `alamat`, `jabatan`, `jenis_kelamin`, `dibuat_pada`, `diedit_pada`, `status_aktif`) VALUES
('029389437914632024148', 'azisfaisal@gmail.com', 'Azis Faisal', '123', '085721350359', '', 'Admin', 'Laki-Laki', '2022-11-02 16:53:44', '2022-11-02 04:53:44', 1),
('086216445936030207807', 'irenandargt@gmail.com', 'Irenanda Regitha', '123', '085721350359', '', 'Admin', 'Perempuan', '2022-10-10 13:59:12', '2022-10-10 01:59:12', 1),
('093184141445321355966', 'andinrizkii@gmail.com', 'Andinira', '1234', '085721350359', '', 'Admin', 'Perempuan', '2022-10-10 15:44:22', '2022-10-08 05:56:54', 1),
('109920216825867687014', 'deffin@upi.edu', 'Deffin AD', '', '085xx', 'Bandung, Jawa Barat', 'Customer', 'Laki-Laki', '2022-10-10 15:44:59', NULL, 1),
('114296107908236623288', 'deffinjr890@gmail.com', 'Deffin AD', '', '085721350359', 'Pajajaran, Bandung', 'Customer', '', '2022-11-02 16:50:35', '2022-11-02 04:50:35', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_dasarkue`
--
ALTER TABLE `t_dasarkue`
  ADD PRIMARY KEY (`id_dasarkue`),
  ADD KEY `id_kue` (`id_kue`);

--
-- Indexes for table `t_detailkeranjang`
--
ALTER TABLE `t_detailkeranjang`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_kue` (`id_kue`),
  ADD KEY `id_keranjang` (`id_keranjang`);

--
-- Indexes for table `t_diskon`
--
ALTER TABLE `t_diskon`
  ADD PRIMARY KEY (`id_diskon`);

--
-- Indexes for table `t_formulirpemesanan`
--
ALTER TABLE `t_formulirpemesanan`
  ADD PRIMARY KEY (`id_formulir`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `t_kategori`
--
ALTER TABLE `t_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `t_keranjang`
--
ALTER TABLE `t_keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `t_kontak`
--
ALTER TABLE `t_kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `t_kue`
--
ALTER TABLE `t_kue`
  ADD PRIMARY KEY (`id_kue`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `t_pembayaran`
--
ALTER TABLE `t_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `t_pembayaran_ibfk_1` (`id_pemesanan`);

--
-- Indexes for table `t_pemesanan`
--
ALTER TABLE `t_pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_keranjang` (`id_keranjang`);

--
-- Indexes for table `t_pengembalian`
--
ALTER TABLE `t_pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`);

--
-- Indexes for table `t_ukurankue`
--
ALTER TABLE `t_ukurankue`
  ADD PRIMARY KEY (`id_ukurankue`),
  ADD KEY `id_kue` (`id_kue`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_dasarkue`
--
ALTER TABLE `t_dasarkue`
  MODIFY `id_dasarkue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `t_detailkeranjang`
--
ALTER TABLE `t_detailkeranjang`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `t_diskon`
--
ALTER TABLE `t_diskon`
  MODIFY `id_diskon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `t_formulirpemesanan`
--
ALTER TABLE `t_formulirpemesanan`
  MODIFY `id_formulir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `t_kontak`
--
ALTER TABLE `t_kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `t_pembayaran`
--
ALTER TABLE `t_pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `t_pengembalian`
--
ALTER TABLE `t_pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_ukurankue`
--
ALTER TABLE `t_ukurankue`
  MODIFY `id_ukurankue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_dasarkue`
--
ALTER TABLE `t_dasarkue`
  ADD CONSTRAINT `t_dasarkue_ibfk_1` FOREIGN KEY (`id_kue`) REFERENCES `t_kue` (`id_kue`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_detailkeranjang`
--
ALTER TABLE `t_detailkeranjang`
  ADD CONSTRAINT `t_detailkeranjang_ibfk_1` FOREIGN KEY (`id_kue`) REFERENCES `t_kue` (`id_kue`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_detailkeranjang_ibfk_2` FOREIGN KEY (`id_keranjang`) REFERENCES `t_keranjang` (`id_keranjang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_formulirpemesanan`
--
ALTER TABLE `t_formulirpemesanan`
  ADD CONSTRAINT `t_formulirpemesanan_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `t_pemesanan` (`id_pemesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_keranjang`
--
ALTER TABLE `t_keranjang`
  ADD CONSTRAINT `t_keranjang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `t_user` (`id_user`);

--
-- Constraints for table `t_kue`
--
ALTER TABLE `t_kue`
  ADD CONSTRAINT `t_kue_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `t_kategori` (`id_kategori`);

--
-- Constraints for table `t_pembayaran`
--
ALTER TABLE `t_pembayaran`
  ADD CONSTRAINT `t_pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `t_pemesanan` (`id_pemesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_pemesanan`
--
ALTER TABLE `t_pemesanan`
  ADD CONSTRAINT `t_pemesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `t_user` (`id_user`),
  ADD CONSTRAINT `t_pemesanan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `t_user` (`id_user`),
  ADD CONSTRAINT `t_pemesanan_ibfk_3` FOREIGN KEY (`id_keranjang`) REFERENCES `t_keranjang` (`id_keranjang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `t_ukurankue`
--
ALTER TABLE `t_ukurankue`
  ADD CONSTRAINT `t_ukurankue_ibfk_1` FOREIGN KEY (`id_kue`) REFERENCES `t_kue` (`id_kue`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
