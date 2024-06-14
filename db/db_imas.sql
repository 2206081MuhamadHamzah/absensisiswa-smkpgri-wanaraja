-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Des 2023 pada 17.53
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_imas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `aktif` varchar(5) NOT NULL,
  `foto` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama_lengkap`, `username`, `password`, `aktif`, `foto`) VALUES
(1, 'muhamad hamzah', 'hamzahbaik9@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Y', 'admin.png'),
(2, 'muhamad hamzah', 'hamzahbaik', 'Hamzahmv20', 'aktif', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_guru`
--

CREATE TABLE `tb_guru` (
  `id_guru` int(11) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `nama_guru` varchar(120) NOT NULL,
  `email` varchar(65) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_guru`
--

INSERT INTO `tb_guru` (`id_guru`, `nip`, `nama_guru`, `email`, `password`, `foto`, `status`) VALUES
(10, '27', 'Yati Nurlatifah, S. Kom.', 'yatinurlatifah1@gmail.com', 'bc33ea4e26e5e1af1408321416956113a4658763', '27.jpg', 'Y'),
(11, '36', 'Gilang Ahmad Ismail, S.Pd', 'gilangahmadismail28@gmail.com', 'fc074d501302eb2b93e2554793fcaf50b3bf7291', '36.jpg', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kepsek`
--

CREATE TABLE `tb_kepsek` (
  `id_kepsek` int(11) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `nama_kepsek` varchar(120) NOT NULL,
  `email` varchar(65) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_kepsek`
--

INSERT INTO `tb_kepsek` (`id_kepsek`, `nip`, `nama_kepsek`, `email`, `password`, `foto`, `status`) VALUES
(1, '123456789011', 'Amiruddin Aziz M.Pd', 'amirudiin@gmail.com', '4ce8e48be6c978348e4a6f4754b050de5581be4b', 'kepala.png', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_master_mapel`
--

CREATE TABLE `tb_master_mapel` (
  `id_mapel` int(11) NOT NULL,
  `kode_mapel` varchar(40) NOT NULL,
  `mapel` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_master_mapel`
--

INSERT INTO `tb_master_mapel` (`id_mapel`, `kode_mapel`, `mapel`) VALUES
(1, 'MP-1561560093', 'Bahasa Indonesia'),
(2, 'MP-1561560129', 'Matematika'),
(6, 'MP-1561872026', 'Seni Budaya'),
(7, 'MP-1561872043', 'Bahasa Inggris'),
(8, 'MP-1615002340', 'Ilmu Pengetahuan Alam'),
(9, 'MP-1698921480', 'Simulasi Digital'),
(10, 'MP-1698921528', 'Pemrograman Dasar'),
(11, 'MP-1698921549', 'Pkk Teori'),
(12, 'MP-1698921567', 'Desain Multimedia Interaktif'),
(13, 'MP-1698921594', 'Pkk Praktek');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_mengajar`
--

CREATE TABLE `tb_mengajar` (
  `id_mengajar` int(11) NOT NULL,
  `kode_pelajaran` varchar(30) NOT NULL,
  `hari` varchar(40) NOT NULL,
  `jam_mengajar` varchar(60) NOT NULL,
  `jamke` varchar(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_mkelas` int(11) NOT NULL,
  `id_semester` int(11) NOT NULL,
  `id_thajaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_mengajar`
--

INSERT INTO `tb_mengajar` (`id_mengajar`, `kode_pelajaran`, `hari`, `jam_mengajar`, `jamke`, `id_guru`, `id_mapel`, `id_mkelas`, `id_semester`, `id_thajaran`) VALUES
(1, 'MPL-1614670924', 'Senin', '09.00-10.00', '1-2', 1, 1, 1, 1, 2),
(2, 'MPL-1614674537', 'Senin', '09.00-10.00', '1-2', 5, 1, 1, 1, 2),
(4, 'MPL-1615004563', 'Senin', '08.00-09.00', '1', 6, 2, 3, 2, 2),
(5, 'MPL-1616288498', 'Rabu', '09.00-10.00', '2', 8, 7, 1, 2, 2),
(6, 'MPL-1582242668', 'Senin', '08.00-09.00', '1', 5, 1, 1, 4, 8),
(8, 'MPL-1698597808', 'Senin', '10.00 - 12.00', '2', 9, 5, 5, 4, 8),
(10, 'MPL-1698927713', 'Senin', '08.00 - 10.00', '2', 5, 7, 0, 4, 8),
(11, 'MPL-1698927744', 'Senin', '08.00 - 10.00', '2', 5, 1, 5, 4, 8),
(12, 'MPL-1698927794', 'Senin', '08.00 - 10.00', '2', 5, 7, 5, 4, 8),
(16, 'MPL-1699028042', 'Senin', '08.00 - 10.00', '1', 5, 9, 0, 4, 9),
(18, 'MPL-1699028113', 'Senin', '08.00 - 10.00', '1', 10, 9, 0, 4, 9),
(19, 'MPL-1699028990', '', '', '', 0, 0, 0, 4, 9),
(22, 'MPL-1699733091', 'Senin', '08.00 - 10.00', '1', 11, 12, 7, 4, 9),
(23, 'MPL-1699736188', 'Senin', '08.00 - 10.00', '1', 11, 12, 0, 5, 9),
(24, 'MPL-1699796246', 'Selasa', '08.00 - 10.00', '1', 11, 9, 7, 4, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_mkelas`
--

CREATE TABLE `tb_mkelas` (
  `id_mkelas` int(11) NOT NULL,
  `kd_kelas` varchar(40) NOT NULL,
  `nama_kelas` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_mkelas`
--

INSERT INTO `tb_mkelas` (`id_mkelas`, `kd_kelas`, `nama_kelas`) VALUES
(5, 'KL-1616673105', 'X MM 1'),
(6, 'KL-1616673114', 'X MM 2'),
(7, 'KL-1616673120', 'XI MM 1'),
(8, 'KL-1698921716', 'XI MM 2'),
(9, 'KL-1698921736', 'XII MM 1'),
(10, 'KL-1698921754', 'XII MM 2'),
(11, 'KL-1698921766', 'XII MM 2'),
(12, 'KL-1698921926', 'XII RPL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_semester`
--

CREATE TABLE `tb_semester` (
  `id_semester` int(11) NOT NULL,
  `semester` varchar(45) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_semester`
--

INSERT INTO `tb_semester` (`id_semester`, `semester`, `status`) VALUES
(4, 'Ganjil', 1),
(5, 'Genap', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(60) NOT NULL,
  `nama_siswa` varchar(120) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jk` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL,
  `th_angkatan` year(4) NOT NULL,
  `id_mkelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `nis`, `nama_siswa`, `tempat_lahir`, `tgl_lahir`, `jk`, `alamat`, `password`, `foto`, `status`, `th_angkatan`, `id_mkelas`) VALUES
(9, '222310070', 'Adit Akbar Fauzi', '-', '0000-00-00', 'L', '-', 'b88b2f9a9257dbdaef344e11068937d629ced5d0', 'logo-removebg-preview.png', '1', 2022, 7),
(10, '222310071', 'Agista Sri Rahayu', '-', '0000-00-00', 'P', '-', '24ddee9a627e979a8b309463b53d6a9b88dd5789', 'logo-removebg-preview.png', '1', 2022, 7),
(11, '222310072', 'Andini Dwi Lestari', '-', '0000-00-00', 'P', '-', '43a0b767005aa98d167275268998e5863a6e2368', 'logo-removebg-preview.png', '1', 2022, 7),
(12, '222310073', 'Aris Sawaludin', '-', '0000-00-00', 'L', '-', 'a5fb008f7d1ab562c0d0a227a293e007b00946a2', 'logo-removebg-preview.png', '1', 2022, 7),
(13, '222310075', 'Asti Fuji Rahmawati', '-', '0000-00-00', 'P', '-', '43537ed9dc0d7a10a8fbf5300afa5a11f4f248d3', 'logo-removebg-preview.png', '1', 2022, 7),
(14, '222310076', 'Chikal Mega Juli Eldia', '-', '0000-00-00', 'P', '-', 'b5d10359b7df791fbb41699aaa99f613644aa75b', 'logo-removebg-preview.png', '1', 2022, 7),
(15, '222310077', 'Dina Agna Malika', '-', '0000-00-00', 'P', '-', 'f981d3090c727022fede44152f0b5a733b23f13c', 'logo-removebg-preview.png', '1', 2022, 7),
(16, '222310078', 'Dina Novianti', '-', '0000-00-00', 'P', '-', 'fcfc03d41d26a5c71dc26c4493e0879d0433591d', 'logo-removebg-preview.png', '1', 2022, 7),
(17, '222310079', 'Fazar Muhamad Shidiq', '-', '0000-00-00', 'L', '-', '357c4717170d39de2a59cb5d403e4928dc059278', 'logo-removebg-preview.png', '1', 2022, 7),
(18, '222310080', 'Fiqih Ikhsani', '-', '0000-00-00', 'L', '-', 'fade3cf86e8f39fc6b452f2f8e34c3df3f4c83f9', 'logo-removebg-preview.png', '1', 2022, 7),
(19, '222310081', 'Haila Gusprida', '-', '0000-00-00', 'P', '-', 'f44d05162567cb62be113deaa3bf68bdc38ff6bc', 'logo-removebg-preview.png', '1', 2022, 7),
(20, '222310082', 'Harwalah Qowiyah Azzahra', '-', '0000-00-00', 'P', '-', 'b12285033366165489ef57c5cfec51f1a96962e0', 'logo-removebg-preview.png', '1', 2022, 7),
(22, '222310083', 'Ilham Ramadan', '-', '0000-00-00', 'L', '-', '3cfcdfdb2121e3db0bd71831f23fb993df9f9b42', 'logo-removebg-preview.png', '1', 2022, 7),
(23, '222310084', 'Irsad Maulana Fikri', '-', '0000-00-00', 'L', '-', 'f7897bdd02669d6aed54fe6e355d684e65e554ef', 'logo-removebg-preview.png', '1', 2022, 7),
(24, '222310085', 'Lina Marlina', '-', '0000-00-00', 'P', '-', 'c509645d95376af1478a6213308c5329ba0e0623', 'logo-removebg-preview.png', '1', 2022, 7),
(25, '222310086', 'Mouja Kirana', '-', '0000-00-00', 'P', '-', '84422f9dc5a85aefbc72917e10845e27c85ef729', 'logo-removebg-preview.png', '1', 2022, 7),
(26, '222310087', 'Muhamad Aofa Hawary', '-', '0000-00-00', 'L', '-', 'c63f35f28c91959f7750c22f71109ff9a9532658', 'logo-removebg-preview.png', '1', 2022, 7),
(27, '222310088', 'Muhamad Jidan Apriliandi', '-', '0000-00-00', 'L', '-', '1e699962f1b1c2e86c5a12e9f31bde55cab9c2ed', 'logo-removebg-preview.png', '1', 2022, 7),
(28, '222310089', 'Muhamad Subhan Baehaki', '-', '0000-00-00', 'L', '-', 'd2fe738fc3d224f13f601273fbb3dcae19ce4f37', 'logo-removebg-preview.png', '1', 2022, 7),
(29, '222310090', 'Muhammad Fahril Alfarizi', '-', '0000-00-00', 'L', '-', '55c123bd0fc004e9769066174676170333a5ddda', 'logo-removebg-preview.png', '1', 2022, 7),
(30, '222310091', 'Nabila Putri', '-', '0000-00-00', 'P', '-', 'ab97c217f5e165be7085363361e7c730f4b81579', 'logo-removebg-preview.png', '1', 2022, 5),
(31, '222310092', 'Naura Ajeng Rukmana', '-', '0000-00-00', 'P', '-', 'c4ae58976d346074fe491fd1f02d6508249e6819', 'logo-removebg-preview.png', '1', 2022, 5),
(32, '222310093', 'Novita Sari ', '-', '0000-00-00', 'P', '-', 'a924fe1614dd8221d10a74e410181ac690ae8bd9', 'logo-removebg-preview.png', '1', 2022, 5),
(33, '222310094', 'Nurul Sintia', '-', '0000-00-00', 'P', '-', '1144e752e87c7961b3b8ba12c0e790b211f206c1', 'logo-removebg-preview.png', '1', 2022, 7),
(34, '222310095', 'Raisa Febrianti', '-', '0000-00-00', 'P', '-', '368b94a9bb52b960c7a5ecfce53578b5f87bdbcd', 'logo-removebg-preview.png', '1', 2022, 7),
(35, '222310096', 'Ramadhan Sayyid Abdillah', '-', '0000-00-00', 'L', '-', '6682ea49e03d1170a3e141fbb0a75ceca9cf76a2', 'logo-removebg-preview.png', '1', 2022, 7),
(36, '222310097', 'Rifal Rinaldi', '-', '0000-00-00', 'L', '-', 'f4649931a3de73086758b49231c7ca044dd9fa9f', 'logo-removebg-preview.png', '1', 2022, 7),
(37, '222310098', 'Rika Amalia Rusdy', '-', '0000-00-00', 'P', '-', 'ae66887dbd13523ef305a2f7047beda9ab87ac71', 'logo-removebg-preview.png', '1', 2022, 7),
(38, '222310099', 'Risma Rahmawati', '-', '0000-00-00', 'P', '-', '7831c37ed988539f15c784e4235d638b4b100c27', 'logo-removebg-preview.png', '1', 2022, 7),
(39, '222310100', 'Salwa Salsabila', '-', '0000-00-00', 'P', '-', '6feb6661e8a17fce0ecc8d27e05f360726f29832', 'logo-removebg-preview.png', '1', 2022, 7),
(40, '222310101', 'Sindi Padilah', '-', '0000-00-00', 'P', '-', '2787c85a8d66d952e08230b790a06e3c482a2005', 'logo-removebg-preview.png', '1', 2022, 7),
(41, '222310102', 'TB. Ahmad Taupik Ramdiansyah', '-', '0000-00-00', 'L', '-', '3939ef5c42f7185573a004aeee4e77214fe000ad', 'logo-removebg-preview.png', '1', 2022, 7),
(42, '222310103', 'Tegar Tri Ananda', '-', '0000-00-00', 'L', '-', '4c28043a30674fc099f8d1082841a3079b279639', 'logo-removebg-preview.png', '1', 2022, 7),
(43, '232410084', 'Airin Sri Anispa', '-', '0000-00-00', 'P', '-', '08cee5fa7fc4e7d4739536fa6c48e90d3c41c906', 'logo-removebg-preview.png', '1', 2023, 6),
(44, '232410085', 'Alpin Saputra', '-', '0000-00-00', 'L', '-', '48820145520af0e5908ee5ed7ee8e2b11264a5d4', 'logo-removebg-preview.png', '1', 2023, 6),
(45, '222310106', 'Aditya Alam Ihsan Islami', '-', '0000-00-00', 'L', '-', '16a010f0d4bed1252df14478fad404928f65559d', 'logo-removebg-preview.png', '1', 2022, 8),
(46, '222310107', 'Amelia', '-', '0000-00-00', 'P', '-', '71426aac8c561259d841494914698963a4f5b8cd', 'logo-removebg-preview.png', '1', 2022, 8),
(47, '222310108', 'Asti rahmawati', '-', '0000-00-00', 'L', '-', 'd11f4c30a5bcb42c4e6c39a2a8f66e8b8a29e10b', 'logo-removebg-preview.png', '1', 2022, 8),
(48, '222310109', 'Bian Septiansyah', '-', '0000-00-00', 'L', '-', '259baa0a7ca40128628e63f402ca1228501d7a30', 'logo-removebg-preview.png', '1', 2022, 8),
(49, '222310110', 'Clara Agustin', '-', '0000-00-00', 'L', '-', '579526e6140ecce5de6608d1c0fe5662218edf66', 'logo-removebg-preview.png', '1', 2023, 0),
(50, '222310110', 'Clara Agustin', '-', '0000-00-00', 'P', '-', '579526e6140ecce5de6608d1c0fe5662218edf66', 'logo-removebg-preview.png', '1', 2022, 8),
(51, '222310111', 'Desi', '-', '0000-00-00', 'P', '-', 'f5a56d84900b9898db3c83e94e2b97c45a9b1498', 'logo-removebg-preview.png', '1', 2022, 8),
(52, '222310112', 'Fitriya Suci Ramadani', '-', '0000-00-00', 'P', '-', 'c2b11aaafb11d434ee483023e02c294e26583251', 'logo-removebg-preview.png', '1', 2022, 8),
(53, '222310113', 'Imas Hasyifa', '-', '0000-00-00', 'P', '-', '2bd6a65f7ce2a3193c31a82461c6d7d3bf9ae2fa', 'logo-removebg-preview.png', '1', 2022, 8),
(54, '232410086', 'Aprilia Putri Maharani ', '-', '0000-00-00', 'P', '-', '8551146b934e913feafcb82dd9a07b3da8c9e2e8', 'logo-removebg-preview.png', '1', 2023, 6),
(55, '232410087', 'Ayu Anjani', '-', '0000-00-00', 'P', '-', '6bbb779501879046e41d87031b15907bc8a2f3f1', 'logo-removebg-preview.png', '1', 2023, 6),
(56, '232410088', 'Deni Permana Sidiq', '-', '0000-00-00', 'L', '-', '9ee5d91a3490370172cdf63ed628284d78cf1f1a', 'logo-removebg-preview.png', '1', 2023, 6),
(57, '232410089', 'Devia Oktovian', '-', '0000-00-00', 'P', '-', 'f1fb68875a4da67e67f1a77492bb0506773051ee', 'logo-removebg-preview.png', '1', 2023, 6),
(58, '232410090', 'Firzatullah Zahran', '-', '0000-00-00', 'P', '-', 'aca44ae984f9e0d51a7974fa25fbcda1504aab25', 'logo-removebg-preview.png', '1', 2023, 6),
(59, '232410091', 'Fuji Agustina', '-', '0000-00-00', 'P', '-', 'a4c9fb89639bf7e2a2e6ecaa341578a382e1eb2f', 'logo-removebg-preview.png', '1', 2023, 6),
(60, '232410092', 'Hilman Setiawan', '', '0000-00-00', 'L', '-', '1532690af1f9428524bb288a779fe0b3fd009438', 'logo-removebg-preview.png', '1', 2023, 6),
(61, '232410093', 'Jibril Aridho', '', '0000-00-00', 'L', '-', '8583c857715ce227d8467fdcb0e0dacfcc4d06ef', 'logo-removebg-preview.png', '1', 2023, 6),
(62, '232410094', 'Karisa Faujiah ', '-', '0000-00-00', 'P', '-', '18074459016127c289c96d31951edbceb2c7ba9c', 'logo-removebg-preview.png', '1', 2023, 6),
(63, '232410095', 'Keysa ', '-', '0000-00-00', 'P', '-', '46a148b83208c88e9e461d1778964b0ce1af042b', 'logo-removebg-preview.png', '1', 2023, 6),
(64, '232410096', 'Lhadika Ikhwan Mulya', '-', '0000-00-00', 'L', '-', '690566630d3a0649416c713e7051c6827cecae76', 'logo-removebg-preview.png', '1', 2023, 6),
(65, '232410097', 'Lilis Musannayah', '-', '0000-00-00', 'P', '-', '5e8bcf4d4267dc2470343f50b8872cdbfa2a25da', 'logo-removebg-preview.png', '1', 2023, 6),
(66, '232410098', 'Mira Rahmawati', '-', '0000-00-00', 'P', '-', '7cf81b1d7d83f7bd631cb7373d798e5cadd0acfc', 'logo-removebg-preview.png', '1', 2023, 6),
(67, '232410099', 'Muhammad Aprizal Setiawan ', '-', '0000-00-00', 'L', '-', 'a82aeffa960f3bf0bc76c862bfeaea9692ee0e3e', 'logo-removebg-preview.png', '1', 2023, 6),
(68, '232410100', 'Muhammad Husen ', '-', '0000-00-00', 'L', '-', '637a462e1dcdcd1511a79543a10c61efd0a8e45c', 'logo-removebg-preview.png', '1', 2023, 6),
(69, '232410101', 'Neng Winarti', '-', '0000-00-00', 'P', '-', 'ec90d6abd5d57d3293a4325aaf5e956d46180572', 'logo-removebg-preview.png', '1', 2023, 6),
(70, '232410102', 'Raga Mulya', '-', '0000-00-00', 'L', '-', '3b1f5b1842d77de6a91a8cd8ca64e4f005b9c2e8', 'logo-removebg-preview.png', '1', 2023, 6),
(71, '232410103', 'Ramdani', '-', '0000-00-00', 'L', '-', '8f0c1798622a0ba50efe4cdb05099dc0856e1c9d', 'logo-removebg-preview.png', '1', 2023, 6),
(72, '232410104', 'Rangga Syah Putra Gunawan', '-', '0000-00-00', 'L', '-', '657e403de7bcb3ac9abe945d7877473b87006274', 'logo-removebg-preview.png', '1', 2023, 6),
(73, '232410105', 'Ridwan Seprian Ramadhan', '-', '0000-00-00', 'L', '-', 'ebb61c09d0bb30d4203992ec9b5fa70c06ada886', 'logo-removebg-preview.png', '1', 2023, 6),
(74, '232410106', 'Sahrul Wahyudi', '-', '0000-00-00', 'L', '-', 'f5cd6c6e4330d074da6522a2187a40ac510a304b', 'logo-removebg-preview.png', '1', 2023, 6),
(75, '232410107', 'Saluna Haerani', '-', '0000-00-00', 'P', '-', '78c94a2f5ae7d364c6ef036962f56a97558462c0', 'logo-removebg-preview.png', '1', 2023, 6),
(76, '232410108', 'Sifa Nurul Aeni', '-', '0000-00-00', 'P', '-', '28da6f58f465d111559e0547944f6e7d2b94a456', 'logo-removebg-preview.png', '1', 2023, 6),
(77, '232410109', 'Soni Mulyadi Hermawan', '-', '0000-00-00', 'L', '-', '6bab173b15277664a69704e41b3a87937396990b', 'logo-removebg-preview.png', '1', 2023, 6),
(78, '232410110', 'Wildan Mahendra', '-', '0000-00-00', 'L', '-', '717d9d2981e01f1067be05ca4e4293f98e8d6d67', 'logo-removebg-preview.png', '1', 2023, 6),
(79, '232410111', 'Zaki Andika Pratama', '-', '0000-00-00', 'L', '-', '23eb881c4631a3d9e77426f16580bf2345fbc141', 'logo-removebg-preview.png', '1', 2023, 6),
(80, '222310104', 'Adhy Futra Yudhistira', '-', '0000-00-00', 'L', '-', '1b8e82de0d6c712c859268dbe5c550f6ea755af4', 'logo-removebg-preview.png', '1', 2022, 8),
(82, '222310105', 'Aditya Agustian Arifin', '-', '0000-00-00', 'L', '-', 'f0adb4d7555ecd9693886ec3268960cd9723c18e', 'logo-removebg-preview.png', '1', 2022, 8),
(83, '222310113', 'Imas Hasyifa', '-', '0000-00-00', 'P', '-', '2bd6a65f7ce2a3193c31a82461c6d7d3bf9ae2fa', 'logo-removebg-preview.png', '1', 2022, 8),
(84, '222310114', 'Indriyani Raisma Yanti', '-', '0000-00-00', 'P', '-', '0bcd9c802d3e9464be4d1d75862ed024a66f1bdf', 'logo-removebg-preview.png', '1', 2022, 8),
(85, '222310115', 'Inggit Agustina', '-', '0000-00-00', 'P', '-', '000bd64b5288345780cc82337f6d5c8ff3f2517f', 'logo-removebg-preview.png', '1', 2022, 8),
(86, '222310116', 'Kiki Muhamad Rizki Fauziah', '-', '0000-00-00', 'L', '-', '2fe832e5080e48e91923b9cdebd4f8e896b92ec4', 'logo-removebg-preview.png', '1', 2022, 8),
(87, '222310117', 'Marsya Amelia', '-', '0000-00-00', 'P', '-', '2e6e9d0024c09c40b4c64876e1bcc0aa244e4dcb', 'logo-removebg-preview.png', '1', 2022, 8),
(88, '222310118', 'Muhamad Reza', '-', '0000-00-00', 'L', '-', '48e387a35fcf9a45d2cb6d7b983f0485d815593c', 'logo-removebg-preview.png', '1', 2022, 8),
(89, '222310119', 'Muhammad Azyra Nursehah', '-', '0000-00-00', 'L', '-', '44b5b8cd57239b2f6021160cf8f4e0840b5a6739', 'logo-removebg-preview.png', '1', 2022, 8),
(90, '222310120', 'Nasya Anggi Fhirliansyah', '-', '0000-00-00', 'P', '-', '8df7237213b04ca72e8d3e545457a3d6b6bf0f10', 'logo-removebg-preview.png', '1', 2022, 8),
(91, '222310121', 'Nurul Aulia Putri', '-', '0000-00-00', 'P', '-', 'bae51e866987e22e007ee334a23a62cff3da26c4', 'logo-removebg-preview.png', '1', 2022, 8),
(92, '222310122', 'Rahma Huzaimah', '-', '0000-00-00', 'P', '-', '367f716c4d7fb840909c0a7e679efe86fca9a589', 'logo-removebg-preview.png', '1', 2022, 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_thajaran`
--

CREATE TABLE `tb_thajaran` (
  `id_thajaran` int(11) NOT NULL,
  `tahun_ajaran` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_thajaran`
--

INSERT INTO `tb_thajaran` (`id_thajaran`, `tahun_ajaran`, `status`) VALUES
(9, '2023/2024', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_walikelas`
--

CREATE TABLE `tb_walikelas` (
  `id_walikelas` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_mkelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_walikelas`
--

INSERT INTO `tb_walikelas` (`id_walikelas`, `id_guru`, `id_mkelas`) VALUES
(1, 2, 1),
(2, 1, 2),
(3, 5, 3),
(4, 6, 1),
(5, 8, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `_logabsensi`
--

CREATE TABLE `_logabsensi` (
  `id_presensi` int(11) NOT NULL,
  `id_mengajar` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tgl_absen` date DEFAULT NULL,
  `ket` enum('H','I','S','T','A','C') NOT NULL,
  `pertemuan_ke` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `_logabsensi`
--

INSERT INTO `_logabsensi` (`id_presensi`, `id_mengajar`, `id_siswa`, `tgl_absen`, `ket`, `pertemuan_ke`) VALUES
(574, 22, 9, '2023-11-12', 'H', '1'),
(575, 22, 10, '2023-11-12', 'A', '1'),
(576, 22, 11, '2023-11-12', 'H', '1'),
(577, 22, 12, '2023-11-12', 'H', '1'),
(578, 22, 13, '2023-11-12', 'H', '1'),
(579, 22, 14, '2023-11-12', 'H', '1'),
(580, 22, 15, '2023-11-12', 'H', '1'),
(581, 22, 16, '2023-11-12', 'H', '1'),
(582, 22, 17, '2023-11-12', 'H', '1'),
(583, 22, 18, '2023-11-12', 'H', '1'),
(584, 22, 19, '2023-11-12', 'H', '1'),
(585, 22, 20, '2023-11-12', 'H', '1'),
(586, 22, 22, '2023-11-12', 'H', '1'),
(587, 22, 23, '2023-11-12', 'H', '1'),
(588, 22, 24, '2023-11-12', 'H', '1'),
(589, 22, 25, '2023-11-12', 'H', '1'),
(590, 22, 26, '2023-11-12', 'H', '1'),
(591, 22, 27, '2023-11-12', 'H', '1'),
(592, 22, 28, '2023-11-12', 'H', '1'),
(593, 22, 29, '2023-11-12', 'H', '1'),
(594, 22, 33, '2023-11-12', 'H', '1'),
(595, 22, 34, '2023-11-12', 'H', '1'),
(596, 22, 35, '2023-11-12', 'H', '1'),
(597, 22, 36, '2023-11-12', 'H', '1'),
(598, 22, 37, '2023-11-12', 'H', '1'),
(599, 22, 38, '2023-11-12', 'H', '1'),
(600, 22, 39, '2023-11-12', 'H', '1'),
(601, 22, 40, '2023-11-12', 'H', '1'),
(602, 22, 41, '2023-11-12', 'S', '1'),
(603, 22, 42, '2023-11-12', 'H', '1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `tb_kepsek`
--
ALTER TABLE `tb_kepsek`
  ADD PRIMARY KEY (`id_kepsek`);

--
-- Indeks untuk tabel `tb_master_mapel`
--
ALTER TABLE `tb_master_mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `tb_mengajar`
--
ALTER TABLE `tb_mengajar`
  ADD PRIMARY KEY (`id_mengajar`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `tb_mkelas`
--
ALTER TABLE `tb_mkelas`
  ADD PRIMARY KEY (`id_mkelas`);

--
-- Indeks untuk tabel `tb_semester`
--
ALTER TABLE `tb_semester`
  ADD PRIMARY KEY (`id_semester`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indeks untuk tabel `tb_thajaran`
--
ALTER TABLE `tb_thajaran`
  ADD PRIMARY KEY (`id_thajaran`);

--
-- Indeks untuk tabel `tb_walikelas`
--
ALTER TABLE `tb_walikelas`
  ADD PRIMARY KEY (`id_walikelas`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `_logabsensi`
--
ALTER TABLE `_logabsensi`
  ADD PRIMARY KEY (`id_presensi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_kepsek`
--
ALTER TABLE `tb_kepsek`
  MODIFY `id_kepsek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_master_mapel`
--
ALTER TABLE `tb_master_mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_mengajar`
--
ALTER TABLE `tb_mengajar`
  MODIFY `id_mengajar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `tb_mkelas`
--
ALTER TABLE `tb_mkelas`
  MODIFY `id_mkelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_semester`
--
ALTER TABLE `tb_semester`
  MODIFY `id_semester` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT untuk tabel `tb_thajaran`
--
ALTER TABLE `tb_thajaran`
  MODIFY `id_thajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_walikelas`
--
ALTER TABLE `tb_walikelas`
  MODIFY `id_walikelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `_logabsensi`
--
ALTER TABLE `_logabsensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=604;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
