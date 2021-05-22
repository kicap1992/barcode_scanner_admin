-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2021 at 03:53 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barcode_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id_absensi` int(4) NOT NULL,
  `bulan` varchar(2) DEFAULT NULL,
  `tahun` varchar(4) DEFAULT NULL,
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_absensi`
--

INSERT INTO `tb_absensi` (`id_absensi`, `bulan`, `tahun`, `detail`) VALUES
(7, '04', '2021', '[{\"tanggal\":\"29\",\"absensi\":[{\"nik_karyawan\":\"56465456465465\",\"jam_masuk\":\"23:25:16\",\"jam_keluar\":\"-\"}]}]'),
(9, '05', '2021', '[{\"tanggal\":\"01\",\"absensi\":[{\"nik_karyawan\":\"56465456465465\",\"jam_masuk\":\"10:11:34\",\"jam_keluar\":\"10:11:49\"}]},{\"tanggal\":\"02\",\"absensi\":[{\"nik_karyawan\":\"56465456465465\",\"jam_masuk\":\"00:00:58\",\"jam_keluar\":\"00:01:10\"},{\"nik_karyawan\":\"23213123123123\",\"jam_masuk\":\"00:04:18\",\"jam_keluar\":\"00:04:28\"},{\"nik_karyawan\":\"45454545545454\",\"jam_masuk\":\"00:05:17\",\"jam_keluar\":\"00:05:32\"}]},{\"tanggal\":\"07\",\"absensi\":[{\"nik_karyawan\":\"56465456465465\",\"jam_masuk\":\"00:23:08\",\"jam_keluar\":\"00:23:17\"}]}]');

-- --------------------------------------------------------

--
-- Table structure for table `tb_karyawan`
--

CREATE TABLE `tb_karyawan` (
  `nik_karyawan` varchar(14) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jk` varchar(10) NOT NULL,
  `agama` varchar(20) NOT NULL,
  `status` varchar(15) NOT NULL,
  `pendidikan` varchar(3) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `jabatan` varchar(225) NOT NULL,
  `tanggal_daftar` date DEFAULT current_timestamp(),
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detail`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_karyawan`
--

INSERT INTO `tb_karyawan` (`nik_karyawan`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jk`, `agama`, `status`, `pendidikan`, `alamat`, `jabatan`, `tanggal_daftar`, `detail`) VALUES
('45454545545454', 'Kicap Karan 1', '', '0000-00-00', '', '', '', '', '', '', '2021-04-06', '[{\"tanggal\":\"2021-05-07\",\"ket\":\"asdasdasd\"},{\"tanggal\":\"2021-05-08\",\"ket\":\"asdasdasd\"}]'),
('56465456465465', 'asdasdas', 'asdasd', '1992-08-30', 'Laki-laki', 'Kristen Protestan', 'Belum Menikah', 'S1', 'asdasd', 'asdasd', '2021-04-06', NULL),
('65656566666665', 'Percobaan2', 'asdasdsads1', '1992-08-30', 'Laki-laki', 'Kristen Protestan', 'Belum Menikah', 'S1', 'Tawau', 'asdasdasds1', '2021-05-08', NULL),
('87484654848486', 'asdasdsadas1', 'asdasdsads1', '1992-08-30', 'Perempuan', 'Kristen Protestan', 'Belum Menikah', 'D3', 'asdasd', 'asdasdasds1', '2021-05-19', '[{\"tanggal\":\"2021-05-19\",\"ket\":\"asdasdad\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `tb_login`
--

CREATE TABLE `tb_login` (
  `id_login` int(3) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `nik_karyawan` varchar(14) DEFAULT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_login`
--

INSERT INTO `tb_login` (`id_login`, `username`, `password`, `nik_karyawan`, `level`) VALUES
(1, 'admin absensi', '584c60ea9b41500d26f446a2543d8a98', NULL, 'admin'),
(4, 'admin petugas', '77c10df6c2867dddbe812c3c950b0a73', NULL, 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `tb_notifikasi`
--

CREATE TABLE `tb_notifikasi` (
  `no_telpon` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_notifikasi`
--

INSERT INTO `tb_notifikasi` (`no_telpon`) VALUES
('2342342342343');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD PRIMARY KEY (`nik_karyawan`);

--
-- Indexes for table `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`id_login`),
  ADD KEY `nik_karyawan` (`nik_karyawan`);

--
-- Indexes for table `tb_notifikasi`
--
ALTER TABLE `tb_notifikasi`
  ADD PRIMARY KEY (`no_telpon`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id_absensi` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_login`
--
ALTER TABLE `tb_login`
  MODIFY `id_login` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_login`
--
ALTER TABLE `tb_login`
  ADD CONSTRAINT `tb_login_ibfk_1` FOREIGN KEY (`nik_karyawan`) REFERENCES `tb_karyawan` (`nik_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
