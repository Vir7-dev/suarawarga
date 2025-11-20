-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2025 pada 08.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suarawarga`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kandidat`
--

CREATE TABLE `kandidat` (
  `id_kandidat` bigint(20) UNSIGNED NOT NULL,
  `id_periode` bigint(20) UNSIGNED NOT NULL,
  `pengguna_id` bigint(20) UNSIGNED NOT NULL,
  `no_kandidat` int(11) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kandidat`
--

INSERT INTO `kandidat` (`id_kandidat`, `id_periode`, `pengguna_id`, `no_kandidat`, `foto_profil`, `jabatan`, `visi`, `misi`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, 'RT', 'Mewujudkan organisasi yang unggul dan berintegritas.', '1. Transparansi.\n2. Inovasi.\n3. Kolaborasi.\n4. Pengembangan SDM.', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(2, 1, 2, 2, NULL, 'RT', 'Mewujudkan organisasi yang unggul dan berintegritas.', '1. Transparansi.\n2. Inovasi.\n3. Kolaborasi.\n4. Pengembangan SDM.', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(3, 1, 3, 3, NULL, 'RT', 'Mewujudkan organisasi yang unggul dan berintegritas.', '1. Transparansi.\n2. Inovasi.\n3. Kolaborasi.\n4. Pengembangan SDM.', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(4, 1, 4, 4, NULL, 'RT', 'Mewujudkan organisasi yang unggul dan berintegritas.', '1. Transparansi.\n2. Inovasi.\n3. Kolaborasi.\n4. Pengembangan SDM.', '2025-11-14 00:41:52', '2025-11-14 00:41:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_11_14_070747_penguna', 1),
(2, '2025_11_14_070937_periode', 1),
(3, '2025_11_14_071043_kandidat', 1),
(4, '2025_11_14_071103_token', 1),
(5, '2025_11_14_071137_suara', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `pendidikan` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `agama` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_ambil` enum('sudah','belum') NOT NULL DEFAULT 'belum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `pendidikan`, `pekerjaan`, `alamat`, `agama`, `role`, `password`, `status_ambil`, `created_at`, `updated_at`) VALUES
(1, '2959769609904171', 'Intan Tami Palastri', 'Bitung', '2005-03-25', 'L', 'D3', 'Tukang Batu', 'Ki. Moch. Toha No. 652, Tanjung Pinang 22255, Kalteng', 'Islam', 'kandidat', '$2y$12$K/YigHq9ener8WYoGOhVoONotKBquvGH2iluzVSHm0BICeUyD/2OW', 'belum', '2025-11-14 00:41:32', '2025-11-14 00:41:32'),
(2, '1171097312449000', 'Citra Karimah Nasyiah S.Gz', 'Pasuruan', '1974-06-09', 'L', 'SMA', 'Peternak', 'Jln. Imam Bonjol No. 816, Kendari 93154, Riau', 'Hindu', 'kandidat', '$2y$12$9gmeLEIfuPAbsUv9Mm0bren3hzQUuviGNc.HGhu371OeTnGGX3n5.', 'belum', '2025-11-14 00:41:32', '2025-11-14 00:41:32'),
(3, '6062707338631402', 'Wardi Sidiq Prakasa S.T.', 'Subulussalam', '1983-01-17', 'P', 'SMA', 'Buruh Tani / Perkebunan', 'Jln. Ir. H. Juanda No. 985, Ambon 63744, Maluku', 'Katolik', 'kandidat', '$2y$12$i2DB.HMVIovvpn0Wz1JDNeA08OvWqWqYs5TDCAwobYTw6VSiYkMFO', 'belum', '2025-11-14 00:41:32', '2025-11-14 00:41:32'),
(4, '7575721722661301', 'Patricia Winarsih', 'Tangerang Selatan', '1980-12-30', 'P', 'S1', 'Satpam', 'Jln. Gatot Subroto No. 981, Metro 63659, DIY', 'Hindu', 'kandidat', '$2y$12$mBAkBhcuswOcivEuC70bv.cmsz2j897x6212VPU/uU4lQJVFqMa7y', 'belum', '2025-11-14 00:41:33', '2025-11-14 00:41:33'),
(5, '3776772356214785', 'Gawati Latika Hassanah S.H.', 'Bitung', '2007-04-14', 'P', 'SMA', 'Wartawan', 'Jr. Diponegoro No. 703, Samarinda 25660, Kalsel', 'Hindu', 'warga', '$2y$12$4GxBAAwXFoKCysoin46/MefzkIpdy56RCKTHeuC.T30AgqlWjv4XW', 'belum', '2025-11-14 00:41:33', '2025-11-14 00:41:33'),
(6, '2179555174010531', 'Kezia Aryani', 'Lubuklinggau', '1972-04-19', 'L', 'S1', 'Sopir', 'Dk. Cemara No. 317, Langsa 97913, Sumsel', 'Katolik', 'warga', '$2y$12$PFsuLAxIRhL6jF5hf9IBPunzgz9LqKn/9tozwYk9a2Nkaw6uYUuPm', 'sudah', '2025-11-14 00:41:34', '2025-11-14 00:41:34'),
(7, '4391633722974702', 'Puji Rahmi Mardhiyah S.E.I', 'Kupang', '2012-01-01', 'L', 'S1', 'Tentara Nasional Indonesia (TNI)', 'Dk. Sukabumi No. 773, Banjarbaru 69541, Bengkulu', 'Buddha', 'warga', '$2y$12$DqyEIj1EnFTecJ0Ard2Fiu78oSxdpYzeGiM5qPAXxvIPE61HHFALi', 'belum', '2025-11-14 00:41:34', '2025-11-14 00:41:34'),
(8, '6986668719659136', 'Emong Hardiansyah', 'Mataram', '2013-10-31', 'P', 'S1', 'Mekanik', 'Ki. Bakau Griya Utama No. 337, Bandar Lampung 39988, DIY', 'Islam', 'warga', '$2y$12$kdsR2DiV4vSm6n3PdxcR6Oruw8b8Nh3mczAeCfBkcXWBXz5Bj5tlm', 'belum', '2025-11-14 00:41:34', '2025-11-14 00:41:34'),
(9, '3857433310598975', 'Farah Usamah', 'Serang', '2016-12-11', 'P', 'S1', 'Mengurus Rumah Tangga', 'Jr. Wahid No. 36, Administrasi Jakarta Timur 52244, Sulbar', 'Buddha', 'warga', '$2y$12$GzpHhF7fo8yEyvVIqCeUh.syDEeGhvKSwjI9H9OkR4C1GdRxTSGXG', 'sudah', '2025-11-14 00:41:35', '2025-11-14 00:41:35'),
(10, '9747357187183432', 'Cakrawala Narpati', 'Tangerang Selatan', '1986-10-25', 'P', 'S2', 'Nelayan / Perikanan', 'Jr. Yos No. 638, Sorong 51258, Sulsel', 'Hindu', 'warga', '$2y$12$8TRhDZ1Vr66SZx9aP/CHYuHo/1ABZFvpiyDFGMgd7jQNV0w37BRd2', 'sudah', '2025-11-14 00:41:35', '2025-11-14 00:41:35'),
(11, '5281019475866808', 'Vera Uyainah', 'Surakarta', '2016-06-08', 'P', 'D3', 'Pastor', 'Kpg. Raden No. 465, Sorong 50347, Kaltim', 'Hindu', 'warga', '$2y$12$U3EUAV95r5YXYiFtA1gRuOPLLjGWh3yJCZH./DJ8/SAZPMAtQeNp.', 'belum', '2025-11-14 00:41:36', '2025-11-14 00:41:36'),
(12, '1624212137339494', 'Yono Pangestu', 'Binjai', '2025-10-29', 'L', 'S1', 'Tukang Batu', 'Jln. Yosodipuro No. 456, Blitar 85613, Sumbar', 'Kristen', 'warga', '$2y$12$wuHc4VoMFkIrDrLgCYb1m.RR6ywYIiFmEQC6JW3vPnjr/67FYHeI6', 'sudah', '2025-11-14 00:41:36', '2025-11-14 00:41:36'),
(13, '1238656915313556', 'Mursita Sihombing', 'Tasikmalaya', '2022-12-01', 'P', 'S1', 'Wartawan', 'Gg. Sadang Serang No. 833, Blitar 23538, Kaltim', 'Kristen', 'warga', '$2y$12$M5zNrvNyAyR8pe1boqKa1O3/E76/K1RrLKmNz9AblkPTD85A2I93K', 'belum', '2025-11-14 00:41:36', '2025-11-14 00:41:36'),
(14, '4853961495903309', 'Siska Sudiati', 'Solok', '1973-01-01', 'P', 'S1', 'Konstruksi', 'Gg. Suharso No. 681, Sabang 56851, Lampung', 'Kristen', 'warga', '$2y$12$ldbDPDnFy2ukoFE0q.aucuZ7uaW//iIcV5SvcIwj0e6Sa0t1AvfPW', 'belum', '2025-11-14 00:41:37', '2025-11-14 00:41:37'),
(15, '1348635819805425', 'Kamaria Yolanda', 'Samarinda', '1978-02-28', 'L', 'D3', 'Wartawan', 'Ki. Suharso No. 831, Pematangsiantar 96616, Sumbar', 'Buddha', 'warga', '$2y$12$NVYzbJ0qFGckm9vLGKtan.dFxVCer8YTIFfnksUHwHLhjLyF3601u', 'sudah', '2025-11-14 00:41:37', '2025-11-14 00:41:37'),
(16, '1796466765152246', 'Salsabila Widiastuti', 'Padang', '2004-11-15', 'L', 'SMA', 'Pemandu Wisata', 'Dk. Basoka Raya No. 790, Mojokerto 17170, NTT', 'Hindu', 'warga', '$2y$12$pgfeh8ZWGncVZWEHy1cVLOAEBVYstKrjE.dfmPSUmtEU2YEZgW3Ne', 'sudah', '2025-11-14 00:41:38', '2025-11-14 00:41:38'),
(17, '9849601576136711', 'Darmanto Hardi Ramadan', 'Sungai Penuh', '1995-06-18', 'L', 'S1', 'Konsultan', 'Psr. Villa No. 297, Bima 82991, Kalsel', 'Kristen', 'warga', '$2y$12$id9udvVPCMzaWZJoPvbVcOXUyWQuFrKA5n1jI3azHZs9YcGop1/yK', 'belum', '2025-11-14 00:41:38', '2025-11-14 00:41:38'),
(18, '1299889702608558', 'Galar Pradipta', 'Bitung', '2001-10-13', 'L', 'D3', 'Penambang', 'Jr. Bayam No. 970, Sawahlunto 37156, Sulteng', 'Islam', 'warga', '$2y$12$ehTAsCEzinWz28KablJdWuU9fRAFW4ri07uVgbbwRZ6mnNeNIBu1u', 'sudah', '2025-11-14 00:41:38', '2025-11-14 00:41:38'),
(19, '9561281369335068', 'Cinthia Yuniar M.Ak', 'Bengkulu', '1991-04-10', 'L', 'D3', 'Karyawan BUMD', 'Gg. Kali No. 722, Bau-Bau 17590, Jatim', 'Islam', 'warga', '$2y$12$bmHpJl25s.Wyq/82VR2eCu2lkLLQ2pJUIVW3GouFEvFgbcbjOhiwy', 'belum', '2025-11-14 00:41:39', '2025-11-14 00:41:39'),
(20, '6388732140022810', 'Tira Mala Yuliarti M.Pd', 'Malang', '2003-02-06', 'P', 'S1', 'Wakil Presiden', 'Gg. Bata Putih No. 871, Pontianak 80535, NTT', 'Buddha', 'warga', '$2y$12$rqk3F0LpWXbKP9pEJIC.pe4tL80zuZPphZT02SSF7rb99oKQuoZMW', 'sudah', '2025-11-14 00:41:39', '2025-11-14 00:41:39'),
(21, '4585762014845763', 'Garang Hakim', 'Padangsidempuan', '1980-02-25', 'L', 'S2', 'Tukang Gigi', 'Jr. HOS. Cjokroaminoto (Pasirkaliki) No. 633, Gorontalo 81929, Bengkulu', 'Kristen', 'warga', '$2y$12$uiw2yFzHYhopd7aTIISlQuzrhBJPvpvOl2HkRIWCNs7ZbcNjztkdq', 'sudah', '2025-11-14 00:41:40', '2025-11-14 00:41:40'),
(22, '8234134830842362', 'Tedi Cawisono Saefullah M.Farm', 'Tangerang Selatan', '1990-12-31', 'P', 'S1', 'Tukang Kayu', 'Kpg. Yos No. 373, Bima 63747, Sumsel', 'Katolik', 'warga', '$2y$12$w0ITTYETvLnaQ3ou2BeaMOzYV42myj1Z3CqNqkq94u5.BOirpVlwq', 'belum', '2025-11-14 00:41:40', '2025-11-14 00:41:40'),
(23, '4791871319276893', 'Eli Pudjiastuti', 'Jambi', '2002-03-30', 'P', 'D3', 'Karyawan Honorer', 'Dk. Baranang Siang Indah No. 632, Mataram 57279, Bali', 'Kristen', 'warga', '$2y$12$y69YfkcxtL.7MIrQXL0eP.WBaipUyBr4zdA2GBlBxvSFmMhdYCTxa', 'sudah', '2025-11-14 00:41:40', '2025-11-14 00:41:40'),
(24, '5372622851472783', 'Salimah Padmasari S.E.I', 'Sawahlunto', '2008-02-22', 'P', 'D3', 'Kondektur', 'Ki. Yos No. 645, Palu 17160, Sumut', 'Islam', 'warga', '$2y$12$z5aVFI671P00c/u.bu/WfesrDQsLVLLH4g9AHT9emCOXFYWSz40fG', 'belum', '2025-11-14 00:41:41', '2025-11-14 00:41:41'),
(25, '0989939718228936', 'Jessica Kezia Lestari', 'Batam', '1973-03-26', 'P', 'S2', 'Jaksa', 'Jln. Yoga No. 646, Palangka Raya 98169, Pabar', 'Buddha', 'warga', '$2y$12$UEo5PnQ5Qvx/DPvzTXmeeezqp3e96Qx5FWXiy8Jdm.Ax1zSlL12gC', 'belum', '2025-11-14 00:41:41', '2025-11-14 00:41:41'),
(26, '8194588248526061', 'Endra Situmorang', 'Tebing Tinggi', '1970-04-22', 'L', 'S2', 'Mekanik', 'Jln. Baladewa No. 908, Palangka Raya 38357, Sulbar', 'Katolik', 'warga', '$2y$12$OXGqQvkFX1tpji3xXVIMJOLt1lpW84kOX5ebx20TVe3ygRn0tr/46', 'sudah', '2025-11-14 00:41:42', '2025-11-14 00:41:42'),
(27, '7752296390861038', 'Erik Hardi Saptono S.E.I', 'Denpasar', '1980-07-24', 'L', 'SMA', 'Transportasi', 'Gg. Bara No. 182, Serang 62369, Pabar', 'Hindu', 'warga', '$2y$12$/yp2CwSSzAnLV72p1bWLuOwWzrqpl3K96OgkrWHXJ3gd2xh61m8GW', 'sudah', '2025-11-14 00:41:42', '2025-11-14 00:41:42'),
(28, '4921668859085815', 'Harimurti Wibisono S.I.Kom', 'Sungai Penuh', '2021-09-23', 'P', 'S2', 'Arsitek', 'Jln. Baing No. 830, Tanjungbalai 28349, DIY', 'Islam', 'warga', '$2y$12$xQphhsk/JsiEOVdfZt81KOvg4cB6heK.Wp/lafrnMqlI1iuGqG6vy', 'belum', '2025-11-14 00:41:42', '2025-11-14 00:41:42'),
(29, '6801071894119240', 'Uli Rahmi Namaga S.T.', 'Kendari', '1977-08-01', 'L', 'S2', 'Dokter', 'Jr. Orang No. 92, Langsa 15137, Sulteng', 'Kristen', 'warga', '$2y$12$ZQrKkspGxYoRKhwgSEo3Me16d56ZzVQOxv4qexjamWIto/LjcJoo.', 'belum', '2025-11-14 00:41:43', '2025-11-14 00:41:43'),
(30, '1734745337487332', 'Ratih Putri Fujiati M.Farm', 'Bogor', '1970-03-18', 'L', 'D3', 'Penerjemah', 'Jr. Bazuka Raya No. 960, Gorontalo 30958, Lampung', 'Katolik', 'warga', '$2y$12$SlIylr9PlHaYINHNAdght.MEobzwU.dn8jS8UIzoq.4PpI.b84hlS', 'sudah', '2025-11-14 00:41:43', '2025-11-14 00:41:43'),
(31, '3607561659170160', 'Wadi Pradipta', 'Pagar Alam', '2006-07-07', 'L', 'D3', 'Dosen', 'Gg. Eka No. 819, Semarang 54232, Riau', 'Buddha', 'warga', '$2y$12$5ZNzET029gpmsbPuVcBTvuN1OfsSQGRFo1HtQwLfpImLxdYaA8tyO', 'belum', '2025-11-14 00:41:44', '2025-11-14 00:41:44'),
(32, '7016538458636753', 'Raisa Lestari', 'Dumai', '1979-08-29', 'P', 'SMA', 'Penulis', 'Dk. Gedebage Selatan No. 187, Bitung 31834, Pabar', 'Katolik', 'warga', '$2y$12$gg5rrjdlJ9asf1YO.XJN4.nCOTznIA/KzcW7cLAnNSk3KwpClPena', 'sudah', '2025-11-14 00:41:44', '2025-11-14 00:41:44'),
(33, '8679915978101867', 'Purwadi Bagya Najmudin', 'Sorong', '1997-10-03', 'L', 'D3', 'Tentara Nasional Indonesia (TNI)', 'Dk. Pattimura No. 873, Prabumulih 50798, Bali', 'Hindu', 'warga', '$2y$12$oD0oTZpVeiaTj69yWMMTnetExfhsxoh71OPectdMEbdnnDxgvaDTG', 'belum', '2025-11-14 00:41:44', '2025-11-14 00:41:44'),
(34, '0081940686841184', 'Elvina Humaira Halimah S.Pt', 'Sibolga', '1993-08-04', 'P', 'D3', 'Presiden', 'Ds. Padma No. 235, Sabang 16155, Bengkulu', 'Kristen', 'warga', '$2y$12$AoJizr.RN/.mcSkD56VX9.XKBxZnCvnynhh4P0JgJOEt9niYyC5GK', 'belum', '2025-11-14 00:41:45', '2025-11-14 00:41:45'),
(35, '7353165197970402', 'Lili Halimah', 'Cimahi', '1983-03-16', 'P', 'S1', 'Penyiar Radio', 'Ki. Rumah Sakit No. 814, Semarang 84072, Kalsel', 'Kristen', 'warga', '$2y$12$CtpEV6YQvftw/CRhqn0TneOtuwUcmfERVw6HablW8UvS0hvTyrlkG', 'sudah', '2025-11-14 00:41:45', '2025-11-14 00:41:45'),
(36, '2576568005617574', 'Agnes Kartika Laksmiwati', 'Bau-Bau', '2012-05-20', 'P', 'S2', 'Peternak', 'Ki. Jend. A. Yani No. 701, Denpasar 26361, Kepri', 'Hindu', 'warga', '$2y$12$3zyIJnwk8qrmP.LyQDeYd.uYVqK1BdQtIJ7U3yjKWpS0A.rLokRTW', 'sudah', '2025-11-14 00:41:46', '2025-11-14 00:41:46'),
(37, '9550992756488174', 'Victoria Anita Hartati M.Pd', 'Blitar', '2003-05-18', 'L', 'D3', 'Arsitek', 'Gg. Jambu No. 326, Kotamobagu 24073, Kalsel', 'Islam', 'warga', '$2y$12$fF1kZao5ZwO6kn0HOQar7uEIuQuguUmuBwvf1AEzDRevp7iAS4kdK', 'belum', '2025-11-14 00:41:46', '2025-11-14 00:41:46'),
(38, '6242956012603751', 'Hani Permata', 'Tangerang Selatan', '1973-04-13', 'P', 'S2', 'Penyiar Televisi', 'Kpg. Imam Bonjol No. 463, Tomohon 85561, NTB', 'Islam', 'warga', '$2y$12$INarXFQ51KGdhEeYO6UVTOhr.ZKx5k7iHJJ4iWNCePwswc2hq2wD2', 'belum', '2025-11-14 00:41:46', '2025-11-14 00:41:46'),
(39, '2215266280770950', 'Ikhsan Kardi Wibisono', 'Pekalongan', '2009-02-05', 'P', 'SMA', 'Penata Busana', 'Ki. Ahmad Dahlan No. 864, Tasikmalaya 23287, Banten', 'Islam', 'warga', '$2y$12$SRhksr3bfdR117guigXlBuNTf8p7smiRZH2KsttDJiE8dT5IAkol6', 'sudah', '2025-11-14 00:41:47', '2025-11-14 00:41:47'),
(40, '0824827447399753', 'Pia Bella Rahimah S.T.', 'Batu', '1978-01-23', 'P', 'S1', 'Konstruksi', 'Kpg. Tubagus Ismail No. 105, Makassar 36089, Banten', 'Islam', 'warga', '$2y$12$kHnAWSKCJkPDU7EPtP/Vo.kTLBnnLx2FVOz9CIBln.RAR8hGLeKxS', 'sudah', '2025-11-14 00:41:47', '2025-11-14 00:41:47'),
(41, '2277678714093676', 'Paris Nuraini', 'Jayapura', '2018-01-28', 'P', 'D3', 'Seniman', 'Ki. Abdul. Muis No. 528, Probolinggo 29229, Kalteng', 'Islam', 'warga', '$2y$12$9DQR8QNUhqw8dA0c.aIDCOqETbHqXvBWzkdLoAZYkJ4BbDMlbFJx.', 'sudah', '2025-11-14 00:41:48', '2025-11-14 00:41:48'),
(42, '7647485609610406', 'Vera Titin Permata', 'Pangkal Pinang', '1970-05-16', 'P', 'S1', 'Buruh Harian Lepas', 'Jr. Jagakarsa No. 932, Tasikmalaya 25227, Gorontalo', 'Buddha', 'warga', '$2y$12$5anbAtgdPZ0O9NELOIv4seVPluCZlw/taYmGe2/yXfqKjIkx8.w86', 'sudah', '2025-11-14 00:41:48', '2025-11-14 00:41:48'),
(43, '2239982113936059', 'Kiandra Farida', 'Administrasi Jakarta Selatan', '1999-09-16', 'P', 'S1', 'Hakim', 'Gg. Yosodipuro No. 684, Bontang 65451, NTB', 'Kristen', 'warga', '$2y$12$02a5xEAveoprgZ0HABzXAeEpnFpd8hBdyORpibHJMTCnJ/ezuONby', 'belum', '2025-11-14 00:41:49', '2025-11-14 00:41:49'),
(44, '3816666442284908', 'Gadang Rajasa', 'Bandung', '2018-09-06', 'P', 'SMA', 'Peneliti', 'Jr. Elang No. 456, Sibolga 81124, Bali', 'Katolik', 'warga', '$2y$12$N9CfgpUucPqOEdjQftODTeD5vaZLZKv/D5QOsnFj.PLPRuklkmFrq', 'sudah', '2025-11-14 00:41:49', '2025-11-14 00:41:49'),
(45, '3391489504454123', 'Ana Astuti M.TI.', 'Bau-Bau', '2006-01-10', 'L', 'SMA', 'Mekanik', 'Jln. Jayawijaya No. 303, Tanjungbalai 54280, DIY', 'Hindu', 'panitia', '$2y$12$rFwSN5ur9d8OA6b.amGBIewswLPw57U7Lm1U5/o0HqPcYowz07aWG', 'sudah', '2025-11-14 00:41:50', '2025-11-14 00:41:50'),
(46, '5339214384003783', 'Luthfi Galih Pradipta', 'Binjai', '2010-08-25', 'P', 'S2', 'Konsultan', 'Gg. Padang No. 862, Pariaman 89164, Sumut', 'Islam', 'panitia', '$2y$12$WInZgr3tg9d5ba4CnQUEL.HqoFY322rYwKdU5U.qNORpbIA/s/GLm', 'sudah', '2025-11-14 00:41:50', '2025-11-14 00:41:50'),
(47, '5193592388494545', 'Gasti Yessi Kusmawati', 'Padangpanjang', '1984-01-18', 'P', 'D3', 'Konsultan', 'Jr. Ters. Pasir Koja No. 830, Bima 64014, Bali', 'Buddha', 'panitia', '$2y$12$.ftvnAXyiZCxX3nL0TWf8OtuV5YHc/JE6yRLPiR4LdPUcYx43lhzi', 'sudah', '2025-11-14 00:41:50', '2025-11-14 00:41:50'),
(48, '7964315160587610', 'Koko Halim', 'Padangpanjang', '2002-10-06', 'L', 'S1', 'Karyawan BUMD', 'Kpg. Jambu No. 99, Sungai Penuh 58670, DIY', 'Islam', 'panitia', '$2y$12$kj/BPXno4m96DpXdrt/ZIOsmxJh0g5OiB6mKvwB0xu4/K8rQs1h6q', 'sudah', '2025-11-14 00:41:51', '2025-11-14 00:41:51'),
(49, '6250609419054283', 'Melinda Mayasari', 'Singkawang', '2013-07-16', 'L', 'SMA', 'Bidan', 'Dk. Ters. Pasir Koja No. 882, Semarang 83807, Jabar', 'Hindu', 'panitia', '$2y$12$bPtfJoMUxJVtXihr/97/BO.JfY/E1yoRvKFYurh7Xh.eZDuEM8T4y', 'sudah', '2025-11-14 00:41:51', '2025-11-14 00:41:51'),
(50, '8042028548460050', 'Yulia Aryani', 'Administrasi Jakarta Timur', '1995-09-12', 'L', 'S1', 'Karyawan Honorer', 'Dk. Madiun No. 605, Tomohon 82752, Lampung', 'Kristen', 'panitia', '$2y$12$aqh3nvq/GmvzTezPyynXFeuqH4Y.nKdO1PsMt.0.D9eclpopKncSS', 'sudah', '2025-11-14 00:41:52', '2025-11-14 00:41:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode`
--

CREATE TABLE `periode` (
  `id_periode` bigint(20) UNSIGNED NOT NULL,
  `nama_periode` varchar(255) NOT NULL,
  `mulai` date NOT NULL,
  `selesai` date NOT NULL,
  `status_periode` enum('aktif','tidak_aktif') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `periode`
--

INSERT INTO `periode` (`id_periode`, `nama_periode`, `mulai`, `selesai`, `status_periode`, `created_at`, `updated_at`) VALUES
(1, 'Pemilihan Ketua 2025', '2025-01-01', '2025-12-31', 'aktif', '2025-11-14 00:41:31', '2025-11-14 00:41:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suara`
--

CREATE TABLE `suara` (
  `id_suara` bigint(20) UNSIGNED NOT NULL,
  `kandidat_id` bigint(20) UNSIGNED NOT NULL,
  `token_id` bigint(20) UNSIGNED NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `token`
--

CREATE TABLE `token` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `token_unik` varchar(255) NOT NULL,
  `status_pengambilan` enum('belum','sudah') NOT NULL DEFAULT 'belum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `token`
--

INSERT INTO `token` (`id`, `token_unik`, `status_pengambilan`, `created_at`, `updated_at`) VALUES
(1, 'qHjuXp', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(2, 'W1noDx', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(3, 'di0rww', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(4, 'ZplT3w', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(5, 'McAFL6', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(6, 'Oiq0Wp', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(7, 'VUaLnQ', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(8, 'cF3m6f', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(9, '3k5cHk', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(10, 'zDd4qF', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(11, 'fLep2O', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(12, 'UnVZAb', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(13, 'Va6TJy', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(14, 'rqnIyZ', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(15, 'Xr8E10', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(16, 'P5iTsD', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(17, 'l2sJ9c', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(18, 'POMStS', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(19, 'qinVy0', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(20, '3K5LYa', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(21, 'zPSKKq', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(22, 'L4ekEm', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(23, 'kKl2dk', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(24, '7GVFVD', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(25, 'HkGn71', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(26, 'cF8Is5', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(27, 'v67Ylk', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(28, 'VinaCq', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(29, 'sV0zDy', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(30, 'XlNrZx', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(31, 'kKuKUF', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(32, 'hK4YjS', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(33, 'aBIrGy', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(34, 'gsyPZx', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(35, 'Dwsv8Q', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(36, 'ljiK0C', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(37, '3IHE77', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(38, 'hPh7sN', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(39, 'FP5rZX', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(40, '1jrpee', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(41, 'Eh2mAY', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(42, 'Ry23AS', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(43, 'v70k2r', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(44, '6Dvd2F', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(45, 'Gh1Er8', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(46, 'tVL961', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(47, '6eF6LO', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(48, 'aj5sVa', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(49, 'NCJqjU', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(50, 'VhtGHX', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(51, 'DAaoyh', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(52, 'jJ15NF', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(53, 'grUYr9', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(54, 'AtCGSe', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(55, 'c0XvRr', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(56, 'AXmabt', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(57, 'S9HX4V', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(58, 'wQ36AP', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(59, 'IL2Pxu', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52'),
(60, 'KGWwsY', 'belum', '2025-11-14 00:41:52', '2025-11-14 00:41:52');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  ADD PRIMARY KEY (`id_kandidat`),
  ADD KEY `kandidat_id_periode_foreign` (`id_periode`),
  ADD KEY `kandidat_pengguna_id_foreign` (`pengguna_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengguna_nik_unique` (`nik`);

--
-- Indeks untuk tabel `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indeks untuk tabel `suara`
--
ALTER TABLE `suara`
  ADD PRIMARY KEY (`id_suara`),
  ADD KEY `suara_kandidat_id_foreign` (`kandidat_id`),
  ADD KEY `suara_token_id_foreign` (`token_id`);

--
-- Indeks untuk tabel `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_token_unik_unique` (`token_unik`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  MODIFY `id_kandidat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `suara`
--
ALTER TABLE `suara`
  MODIFY `id_suara` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `token`
--
ALTER TABLE `token`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  ADD CONSTRAINT `kandidat_id_periode_foreign` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE,
  ADD CONSTRAINT `kandidat_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `suara`
--
ALTER TABLE `suara`
  ADD CONSTRAINT `suara_kandidat_id_foreign` FOREIGN KEY (`kandidat_id`) REFERENCES `kandidat` (`id_kandidat`) ON DELETE CASCADE,
  ADD CONSTRAINT `suara_token_id_foreign` FOREIGN KEY (`token_id`) REFERENCES `token` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
