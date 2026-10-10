-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 16, 2026 at 05:35 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_dudul`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int NOT NULL,
  `no_anggota` varchar(30) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_hp` int NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `no_anggota`, `nama`, `kelas`, `alamat`, `no_hp`, `tanggal_daftar`, `status`, `id_user`) VALUES
(9, 'AGT173054', 'gogon', 'XII RPL', 'kp lambu', 812321324, '2026-04-16', 'aktif', 13),
(10, 'AGT173438', 'tatang', 'XII RPL', 'kp bagbagan', 812412412, '2026-04-16', 'aktif', 14);

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int NOT NULL,
  `foto` text NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` int NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `lokasi_rak` varchar(30) NOT NULL,
  `stok_total` int NOT NULL,
  `stok_tersedia` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `foto`, `isbn`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `kategori`, `lokasi_rak`, `stok_total`, `stok_tersedia`) VALUES
(3, '1774938958.webp', '9789792701166', 'naruto shipuden', ' Masashi Kishimoto', ' Shueisha', 1998, 'Komik', 'D4', 5, 5),
(4, '1775104900.webp', '9789792735741', 'One Piece', 'Eiichiro Oda', 'Shueisha (Weekly Shonen Jump)', 1997, 'Komik', 'D4', 5, 5),
(5, '1775105066.webp', '9786020215709', 'Attack on Titan', 'Hajime Isayama', 'Kodansha (Bessatsu Shonen Mag.)', 2026, 'Komik', 'D4', 5, 5),
(6, '1775105171.webp', '9786230304910', 'oishi no ko', 'Aka Akasaka & Mengo Yokoyari', 'Shueisha (Weekly Young Jump)', 2026, 'Komik', 'D4', 5, 5),
(7, '1775105875.webp', '9789795532132', 'dragon ball', 'Akira Toriyama', 'Shueisha (Weekly Shonen Jump)', 1984, 'Komik', 'D4', 5, 5),
(8, '1775105956.webp', '9786230022180', 'Jujutsu Kaisen', 'Gege Akutami', 'Shueisha (Weekly Shonen Jump)', 2018, 'Komik', 'D4', 5, 5),
(9, '1776358472.webp', '9789791227002', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 'Novel', 'A1', 5, 5),
(10, '1776358554.webp', '9789799731234', 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Lentera Dipantara', 2005, 'Novel', 'A1', 5, 5),
(11, '1776358792.webp', '9786028811613', 'Filosofi Kopi', 'Dewi Lestari', 'GagasMedia', 2006, 'Novel', 'A1', 5, 5),
(12, '1776358956.webp', '9786020312583', 'Cantik Itu Luka', 'Eka Kurniawan', ' Gramedia Pustaka Utama', 2026, 'Novel', 'A1', 5, 5),
(13, '1776359051.webp', '9786020822129', 'pulang', 'Tere Liye', 'Republika', 2012, 'Novel', 'A1', 5, 5),
(14, '1776359192.webp', '9786024246938', 'Laut Bercerita', 'Leila S. Chudori', 'KPG', 2017, 'Novel', 'A1', 5, 5),
(15, '1776359263.webp', '9786024125189', 'Filosofi Teras', 'Henry Manampiring', 'Kompas', 2018, 'Novel', 'A1', 5, 5),
(16, '1776359370.webp', '9789792963502', 'Dasar Dasar RPL', 'Patwiyanto, dkk', 'Andi Offset', 2018, 'Pelajaran', 'B2', 5, 5),
(17, '1776359458.webp', '9786021514481', 'Pemrograman Web PHP & MySQL', 'Betha Sidik', 'Informatika', 2014, 'Pelajaran', 'B2', 5, 5),
(18, '1776359570.webp', '9780132350884', 'Clean Code', 'Robert C. Martin', 'Pearson', 2008, 'Pelajaran', 'B2', 5, 5),
(19, '1776359669.webp', '9789792209044', 'A Brief History of Time', 'Stephen Hawking', 'Gramedia', 2014, 'Sains', 'C3', 5, 5),
(20, '1776359753.webp', '9786024243616', 'Sapiens', 'Yuval Noah Harari', 'KPG', 2017, 'Sains', 'C3', 5, 5),
(21, '1776359838.webp', '9786020633176', 'Atomic Habits', 'James Clear', 'Gramedia', 2019, 'Sains', 'C3', 5, 5),
(22, '1776359920.webp', '9780393609394', 'Astrophysics for People in a Hurry', 'Neil deGrasse Tyson', 'W. W. Norton', 2017, 'Sains', 'C3', 5, 5),
(23, '1776360073.webp', '9786230018596', 'Demon Slayer', 'Koyoharu Gotouge', 'Elex Media', 2020, 'Komik', 'D4', 5, 5),
(24, '1776360154.webp', '9786230019289', 'Spy x Family', 'Tatsuya Endo', 'Elex Media', 2020, 'Komik', 'D4', 5, 5),
(25, '1776360234.webp', '9786230030581', 'Blue Lock', 'Muneyuki Kaneshiro', 'Elex Media', 2022, 'Komik', 'D4', 5, 5),
(26, '1776360351.webp', '9786020323244', 'Kosmos', 'Carl Sagan', 'Gramedia', 2016, 'Komik', 'D4', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id_detail` int NOT NULL,
  `id_pinjam` int NOT NULL,
  `id_buku` int NOT NULL,
  `Qty` int NOT NULL,
  `status_item` enum('dipinjam','dikembalikan','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int NOT NULL,
  `id_anggota` int NOT NULL,
  `id_user` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `status_pinjam` enum('dipinjam','selesai','terlambat','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_kembali` int NOT NULL,
  `id_pinjam` int NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `denda_total` int NOT NULL,
  `catatan` varchar(200) NOT NULL,
  `status_kembali` enum('selesai','pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','user','petugas') NOT NULL,
  `status_aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `email`, `role`, `status_aktif`) VALUES
(11, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 'emailadmin@gmail.com', 'admin', 1),
(13, 'gogon', 'gogon', 'bcd724d15cde8c47650fda962968f102', 'emailsiswa@gmail.com', 'user', 1),
(14, 'tatang', 'tatang', 'bcd724d15cde8c47650fda962968f102', 'emailsiswa@gmail.com', 'user', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pinjam` (`id_pinjam`,`id_buku`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_anggota` (`id_anggota`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_kembali`),
  ADD KEY `id_pinjam` (`id_pinjam`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_kembali` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `detail_peminjaman_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_peminjaman_ibfk_2` FOREIGN KEY (`id_pinjam`) REFERENCES `peminjaman` (`id_pinjam`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_pinjam`) REFERENCES `peminjaman` (`id_pinjam`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
