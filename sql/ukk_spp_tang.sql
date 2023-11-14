-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2023 at 04:33 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukk_spp_tang`
--

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(10) DEFAULT NULL,
  `kompetensi_keahlian` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `kompetensi_keahlian`) VALUES
(1, 'XII', 'Rekayasa Perangkat Lunak'),
(2, 'X', 'Teknik Komputer dan Jaringan'),
(4, 'XI', 'Teknik Komputer dan Jaringan'),
(6, 'XI', 'Multimedia');

--
-- Triggers `kelas`
--
DELIMITER $$
CREATE TRIGGER `deleteKELAS` BEFORE DELETE ON `kelas` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("KELAS DELETE WHERE id_kelas=", old.id_kelas, ", nama_kelas=", old.nama_kelas, ", kompetensi_keahlian=", old.kompetensi_keahlian), NOW());

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertKELAS` AFTER INSERT ON `kelas` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("KELAS INSERT nama_kelas=", new.nama_kelas, ", kompetensi_keahlian=", new.kompetensi_keahlian), NOW());

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `pesan` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `pesan`, `tanggal`) VALUES
(1, 'KELAS INSERT nama_kelas=XII, kompetensi_keahlian=Teknik Komputer dan Jaringan', '2023-11-09'),
(2, 'KELAS DELETE WHERE id_kelas=38, nama_kelas=XII, kompetensi_keahlian=Teknik Komputer dan Jaringan', '2023-11-09'),
(3, 'SISWA INSERT nisn=1234918231, nis=0913, nama=DIIAMORA, id_kelas=6, alamat=abababababbabababbabaabbababbaba, no_telp=2983091283012, password=202cb962ac59075b964b07152d234b70', '2023-11-09'),
(4, 'SISWA DELETE WHERE nisn=1234918231, nis=0913, nama=DIIAMORA, id_kelas=6, alamat=abababababbabababbabaabbababbaba, no_telp=2983091283012, password=202cb962ac59075b964b07152d234b70', '2023-11-09'),
(5, 'PETUGAS INSERT nama_petugas=Achmad Arditio, username=bababoi, level=admin, password=202cb962ac59075b964b07152d234b70', '2023-11-09'),
(6, 'PETUGAS DELETE WHERE id_petugas=9, nama_petugas=Achmad Arditio, username=bababoi, level=admin, password=202cb962ac59075b964b07152d234b70', '2023-11-09'),
(7, 'SPP INSERT tahun=3030, nominal=200000', '2023-11-09'),
(8, 'SPP DELETE WHERE id_spp=17, tahun=3030, nominal=200000', '2023-11-09'),
(9, 'PEMBAYARAN INSERT id_petugas=1, nisn=8765412345, tgl_bayar=2023-11-09, bulan_bayar=November, tahun_dibayar=2023, id_spp=9, jumlah_bayar=500000', '2023-11-09'),
(10, 'PEMBAYARAN DELETE WHERE id_pembayaran=27, id_petugas=1, nisn=8765412345, tgl_bayar=2023-11-09, bulan_bayar=November, tahun_dibayar=2023, id_spp=9, jumlah_bayar=500000', '2023-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `nisn` char(10) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `bulan_bayar` varchar(10) DEFAULT NULL,
  `tahun_dibayar` varchar(4) DEFAULT NULL,
  `id_spp` int(11) DEFAULT NULL,
  `jumlah_bayar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_petugas`, `nisn`, `tgl_bayar`, `bulan_bayar`, `tahun_dibayar`, `id_spp`, `jumlah_bayar`) VALUES
(4, 1, '1872361828', '2023-09-29', 'November', '2023', 4, 200000),
(5, 1, '8765412345', '2023-10-25', 'October', '2023', 3, 900000),
(6, 1, '8765412345', '2023-10-27', 'October', '2023', 5, 400000),
(9, 2, '8765412345', '2023-10-27', 'October', '2023', 4, 400000),
(10, 2, '2834927398', '2023-10-28', 'October', '2023', 5, 500000),
(11, 2, '1234567892', '2023-10-28', 'October', '2023', 3, 400000),
(12, 2, '8765412345', '2023-10-29', 'October', '2023', 4, 800000),
(13, 1, '7720232342', '2023-10-29', 'October', '2023', 5, 1499999),
(14, 1, '7720232342', '2023-10-29', 'October', '2023', 4, 1100000),
(16, 1, '7720232342', '2023-10-29', 'October', '2023', 3, 899999),
(17, 1, '7720232342', '2023-10-29', 'October', '2023', 1, 299999),
(18, 1, '7720232342', '2023-10-29', 'October', '2023', 5, 1),
(19, 1, '8765412345', '2023-10-31', 'October', '2023', 5, 100000),
(20, 1, '8765412345', '2023-10-31', 'October', '2023', 5, 1),
(21, 1, '8765412345', '2023-10-31', 'October', '2023', 5, 999),
(22, 1, '8765412345', '2023-11-06', 'November', '2023', 10, 1000000),
(23, 2, '1872361828', '2023-11-09', 'November', '2023', 4, 100001),
(24, 2, '1872361828', '2023-11-09', 'November', '2023', 4, 500000);

--
-- Triggers `pembayaran`
--
DELIMITER $$
CREATE TRIGGER `deleteBAYAR` BEFORE DELETE ON `pembayaran` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("PEMBAYARAN DELETE WHERE id_pembayaran=", old.id_pembayaran, ", id_petugas=", old.id_petugas, ", nisn=", old.nisn, ", tgl_bayar=", old.tgl_bayar, ", bulan_bayar=", old.bulan_bayar, ", tahun_dibayar=", old.tahun_dibayar, ", id_spp=", old.id_spp, ", jumlah_bayar=", old.jumlah_bayar), NOW());

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertBAYAR` AFTER INSERT ON `pembayaran` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("PEMBAYARAN INSERT id_petugas=", new.id_petugas, ", nisn=", new.nisn, ", tgl_bayar=", new.tgl_bayar, ", bulan_bayar=", new.bulan_bayar, ", tahun_dibayar=", new.tahun_dibayar, ", id_spp=", new.id_spp, ", jumlah_bayar=", new.jumlah_bayar), NOW());

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `nama_petugas` varchar(35) DEFAULT NULL,
  `level` enum('admin','petugas') DEFAULT NULL,
  `foto_petugas` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`, `foto_petugas`) VALUES
(1, 'saya_admin', '202cb962ac59075b964b07152d234b70', 'Ganjar Agung', 'admin', '487427070_team-1.jpg'),
(2, 'saya_petugas', '202cb962ac59075b964b07152d234b70', 'BUAH PEPAYA', 'petugas', '');

--
-- Triggers `petugas`
--
DELIMITER $$
CREATE TRIGGER `deletePETUGAS` BEFORE DELETE ON `petugas` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("PETUGAS DELETE WHERE id_petugas=", old.id_petugas, ", nama_petugas=", old.nama_petugas, ", username=", old.username, ", level=", old.level, ", password=", old.password), NOW());

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertPETUGAS` AFTER INSERT ON `petugas` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("PETUGAS INSERT nama_petugas=", new.nama_petugas, ", username=", new.username, ", level=", new.level, ", password=", new.password), NOW());

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nisn` char(10) NOT NULL,
  `nis` char(8) DEFAULT NULL,
  `nama` varchar(35) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(13) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `foto` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `id_kelas`, `alamat`, `no_telp`, `password`, `foto`) VALUES
('1231241411', '3313', 'WELL', 2, '123123123123', '1231231231231', '202cb962ac59075b964b07152d234b70', NULL),
('1234283468', '4321', 'Banyu Biru', 1, 'bd 20', '0867543145678', '202cb962ac59075b964b07152d234b70', '1529787495_team-3.jpg'),
('1234567892', '1111', 'Gagar Duatama', 4, 'hashim', '081672637381', '202cb962ac59075b964b07152d234b70', ''),
('1872361828', '8934', 'Gilang Tuwaga', 1, 'kirei', '0818268126312', '202cb962ac59075b964b07152d234b70', ''),
('2834927398', '2349', 'Krating Deng', 4, 'JL. Juariah Tegar, RT.05/RW.05, Kemali Abung, metro, Lampung, sumatra selatan, Indonesia, Asia tenggara, Asia, Bumi, Planet Bumi', '0818278172873', '202cb962ac59075b964b07152d234b70', ''),
('7720232342', '7723', 'Unyab', 4, 'c', '082177480705', '202cb962ac59075b964b07152d234b70', '745066705_home-decor-1.jpg'),
('8765412345', '6666', 'Bintang Prasetyo', 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaeaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '081672637995', '202cb962ac59075b964b07152d234b70', '1368786505_product-2.jpg');

--
-- Triggers `siswa`
--
DELIMITER $$
CREATE TRIGGER `deleteSISWA` BEFORE DELETE ON `siswa` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("SISWA DELETE WHERE nisn=", old.nisn, ", nis=", old.nis, ", nama=", old.nama, ", id_kelas=", old.id_kelas, ", alamat=", old.alamat, ", no_telp=", old.no_telp, ", password=", old.password), NOW());

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertSISWA` AFTER INSERT ON `siswa` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("SISWA INSERT nisn=", new.nisn, ", nis=", new.nis, ", nama=", new.nama, ", id_kelas=", new.id_kelas, ", alamat=", new.alamat, ", no_telp=", new.no_telp, ", password=", new.password), NOW());

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `spp`
--

CREATE TABLE `spp` (
  `id_spp` int(11) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spp`
--

INSERT INTO `spp` (`id_spp`, `tahun`, `nominal`) VALUES
(1, 2019, 300000),
(3, 2020, 900000),
(4, 2021, 1200000),
(5, 2022, 1500000),
(9, 2023, 900000),
(10, 2024, 1000000),
(12, 2025, 400000);

--
-- Triggers `spp`
--
DELIMITER $$
CREATE TRIGGER `deleteSPP` BEFORE DELETE ON `spp` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("SPP DELETE WHERE id_spp=", old.id_spp, ", tahun=", old.tahun, ", nominal=", old.nominal), NOW());

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertSPP` AFTER INSERT ON `spp` FOR EACH ROW BEGIN

INSERT INTO logs VALUES (null, CONCAT("SPP INSERT tahun=", new.tahun, ", nominal=", new.nominal), NOW());

END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_petugas` (`id_petugas`,`nisn`,`id_spp`),
  ADD KEY `nisn` (`nisn`),
  ADD KEY `id_spp` (`id_spp`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nisn`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `spp`
--
ALTER TABLE `spp`
  ADD PRIMARY KEY (`id_spp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `spp`
--
ALTER TABLE `spp`
  MODIFY `id_spp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`nisn`) REFERENCES `siswa` (`nisn`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_spp`) REFERENCES `spp` (`id_spp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
