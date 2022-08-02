-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 02, 2022 at 04:06 PM
-- Server version: 10.5.16-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id19360432_koperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_06_21_154947_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2022-06-21 16:04:49', '2022-06-21 16:04:49'),
(2, 'kasir', 'web', '2022-06-21 16:04:49', '2022-06-21 16:04:49'),
(3, 'pengurus', 'web', '2022-06-21 16:04:49', '2022-06-21 16:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggota`
--

CREATE TABLE `tbl_anggota` (
  `id` int(11) NOT NULL,
  `nama_anggota` varchar(50) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` bigint(20) DEFAULT NULL,
  `jk` enum('Laki - Laki','Perempuan') DEFAULT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `id_divisi` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id`, `nama_anggota`, `alamat`, `no_hp`, `jk`, `id_jabatan`, `id_divisi`, `created_at`, `updated_at`, `status`) VALUES
(7220337, 'ridwan nurjaman', '-', 89696307914, 'Laki - Laki', 1, 1, '2022-07-26 16:57:07', '2022-07-26 16:57:07', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id` varchar(11) NOT NULL,
  `no_barcode` varchar(20) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `kategori_barang` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stock` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('1','0') DEFAULT NULL,
  `jenis_unit` enum('Pcs','Btl','Sct','Pkt','Dus','Bks') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id`, `no_barcode`, `nama_barang`, `kategori_barang`, `harga`, `stock`, `created_at`, `updated_at`, `status`, `jenis_unit`) VALUES
('K0001', '89686010013', 'MIE SEDAP GORENG', NULL, 1500, 93, '2022-08-01 20:41:00', '2022-08-01 21:07:20', '1', 'Pcs'),
('K0002', '89686010014', 'Teh Gelas', NULL, 5000, 70, '2022-08-01 20:41:00', '2022-08-01 20:41:00', '1', 'Pcs');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_bayar`
--

CREATE TABLE `tbl_detail_bayar` (
  `id` int(11) NOT NULL,
  `id_detail_pinjam` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_pinjaman`
--

CREATE TABLE `tbl_detail_pinjaman` (
  `id_pinjam` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `total` int(11) DEFAULT NULL,
  `sisa` int(11) DEFAULT NULL,
  `jenis` enum('kredit','debit') DEFAULT 'debit',
  `tanggal` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('Lunas','Belum Lunas') DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_retur`
--

CREATE TABLE `tbl_detail_retur` (
  `id` int(11) NOT NULL,
  `id_retur` int(11) DEFAULT NULL,
  `id_barang` varchar(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `total_peritem` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_transaksi`
--

CREATE TABLE `tbl_detail_transaksi` (
  `id` int(11) NOT NULL,
  `id_transaksi` varchar(50) DEFAULT NULL,
  `id_barang` varchar(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `total_peritem` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_retur` enum('1','0') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_divisi`
--

CREATE TABLE `tbl_divisi` (
  `id` int(11) NOT NULL,
  `nama_divisi` varchar(100) DEFAULT NULL,
  `status` enum('1','0') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_divisi`
--

INSERT INTO `tbl_divisi` (`id`, `nama_divisi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Management', '1', '2022-06-23 19:12:49', '2022-06-23 19:12:51'),
(4, 'KabagRakit  Lokal', '1', NULL, NULL),
(5, 'Admin Rakit Lokal', '1', NULL, NULL),
(6, 'Admin Logistik', '1', NULL, NULL),
(7, 'Admin ', '1', NULL, NULL),
(8, 'Kabag Logistik', '1', NULL, NULL),
(9, 'Kabag Gudang', '1', NULL, NULL),
(10, 'Kabag Injection', '1', NULL, NULL),
(11, 'Kabag Rakit Import', '1', NULL, NULL),
(12, 'Admin Gudang', '1', NULL, NULL),
(14, 'Admin Logistik', '1', NULL, NULL),
(15, 'Admin PPIC', '1', NULL, NULL),
(16, 'Gudang', '1', NULL, NULL),
(17, 'HRD + Umum', '1', NULL, NULL),
(18, 'Import', '1', NULL, NULL),
(19, 'Injection', '1', NULL, NULL),
(20, 'Logistik', '1', NULL, NULL),
(21, 'Packing  Import', '1', NULL, NULL),
(22, 'Pad Print', '1', NULL, NULL),
(23, 'Painting', '1', NULL, NULL),
(24, 'Rakit Import', '1', NULL, NULL),
(25, 'Pengawas Rakit Lokal', '1', NULL, NULL),
(26, 'Pengawas Rakit Import', '1', NULL, NULL),
(27, 'Rakit Import', '1', NULL, NULL),
(28, 'Security', '1', NULL, NULL),
(29, 'Rakit Lokal', '1', NULL, NULL),
(30, 'Staff HRD', '1', NULL, NULL),
(31, 'Umum', '1', NULL, NULL),
(32, 'Rakit Lokal', '1', NULL, NULL),
(33, 'Kepala PPIC', '1', NULL, NULL),
(34, 'Admin Injection', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `id` int(11) NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `status` enum('1','0') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id`, `jabatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Anggota', '1', '2022-06-23 19:05:48', '2022-07-26 13:50:21'),
(2, 'Manager', '1', '2022-07-19 13:47:05', '2022-07-19 15:53:59'),
(3, 'PIC', '1', '2022-07-23 04:58:37', '2022-07-23 04:58:37'),
(11, 'Ketua', '1', NULL, NULL),
(12, 'Pembina', '1', NULL, NULL),
(13, 'Pengawas', '1', NULL, NULL),
(14, 'Wakil Ketua', '1', NULL, NULL),
(15, 'Bendahara I', '1', NULL, NULL),
(16, 'Bendahara II', '1', NULL, NULL),
(17, 'Sekretaris', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('1','0') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id`, `nama_kategori`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Makanan', '2022-07-21 04:45:24', '2022-07-21 04:46:33', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembelian_barang`
--

CREATE TABLE `tbl_pembelian_barang` (
  `id` int(11) NOT NULL,
  `id_barang` varchar(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tgl_beli` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pembelian_barang`
--

INSERT INTO `tbl_pembelian_barang` (`id`, `id_barang`, `harga`, `qty`, `created_at`, `updated_at`, `tgl_beli`) VALUES
(32, 'K0001', 1300, 100, '2022-08-01 20:41:00', '2022-08-01 20:41:00', '2022-07-27'),
(33, 'K0002', 1500, 70, '2022-08-01 20:41:00', '2022-08-01 20:41:00', '2022-07-27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pinjaman`
--

CREATE TABLE `tbl_pinjaman` (
  `id` int(11) NOT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `total_debit` int(11) DEFAULT NULL,
  `total_kredit` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retur`
--

CREATE TABLE `tbl_retur` (
  `id` int(11) NOT NULL,
  `id_transaksi` varchar(50) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `tgl_retur` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retur_barang`
--

CREATE TABLE `tbl_retur_barang` (
  `id` int(11) NOT NULL,
  `id_barang` varchar(50) DEFAULT NULL,
  `tgl_retur` datetime DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_retur_barang`
--

INSERT INTO `tbl_retur_barang` (`id`, `id_barang`, `tgl_retur`, `qty`, `created_at`, `updated_at`) VALUES
(2, 'K0001', '2022-08-01 21:07:20', 7, '2022-08-01 21:07:20', '2022-08-01 21:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id` varchar(50) NOT NULL,
  `total` int(11) DEFAULT NULL,
  `status` enum('Cash','Kredit') DEFAULT NULL,
  `tgl_transaksi` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `id_anggota` int(11) DEFAULT NULL,
  `bayar` int(11) NOT NULL,
  `kembali` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@test.com', NULL, '$2y$10$dEud6xpXUtvDn15DxMAOVux1KENYULx1EQKTQklgtHe2GmuRbn1by', NULL, '2022-06-21 16:04:49', '2022-06-21 16:04:49'),
(2, 'kasir', 'kasir@test.com', NULL, '$2y$10$/m0maCR4XGRBUF3PEQ2tru9XXf2Jo.u2BVZL0wA5/Uifrl/Eo0V2S', NULL, '2022-06-21 16:04:50', '2022-06-21 16:04:50'),
(3, 'pengurus', 'pengurus@test.com', NULL, '$2y$10$aHUo3TDNFuCkIoyCOshzBOvraTLksEttAIKTcHQ1KDJj15Bwu0J4G', NULL, '2022-06-21 16:04:50', '2022-06-21 16:04:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`id_divisi`),
  ADD KEY `relasi_divisi` (`id_divisi`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relasi_kategori` (`kategori_barang`);

--
-- Indexes for table `tbl_detail_bayar`
--
ALTER TABLE `tbl_detail_bayar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relasi_bayar` (`id_detail_pinjam`);

--
-- Indexes for table `tbl_detail_pinjaman`
--
ALTER TABLE `tbl_detail_pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pinjam` (`id_pinjam`);

--
-- Indexes for table `tbl_detail_retur`
--
ALTER TABLE `tbl_detail_retur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_detail_retur` (`id_retur`),
  ADD KEY `id_detail_retur_barang` (`id_barang`);

--
-- Indexes for table `tbl_detail_transaksi`
--
ALTER TABLE `tbl_detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relasi_barang` (`id_barang`) USING BTREE,
  ADD KEY `relasi_detail_transaksi` (`id_transaksi`);

--
-- Indexes for table `tbl_divisi`
--
ALTER TABLE `tbl_divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pembelian_barang`
--
ALTER TABLE `tbl_pembelian_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relasi_pembelian_barang` (`id_barang`);

--
-- Indexes for table `tbl_pinjaman`
--
ALTER TABLE `tbl_pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_anggota_simpan` (`id_anggota`);

--
-- Indexes for table `tbl_retur`
--
ALTER TABLE `tbl_retur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retur` (`id_transaksi`);

--
-- Indexes for table `tbl_retur_barang`
--
ALTER TABLE `tbl_retur_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retur_barang` (`id_barang`);

--
-- Indexes for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relasi_transaksi)_anggota` (`id_anggota`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12200337;

--
-- AUTO_INCREMENT for table `tbl_detail_bayar`
--
ALTER TABLE `tbl_detail_bayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_detail_pinjaman`
--
ALTER TABLE `tbl_detail_pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_detail_retur`
--
ALTER TABLE `tbl_detail_retur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_detail_transaksi`
--
ALTER TABLE `tbl_detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_divisi`
--
ALTER TABLE `tbl_divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_pembelian_barang`
--
ALTER TABLE `tbl_pembelian_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_pinjaman`
--
ALTER TABLE `tbl_pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_retur`
--
ALTER TABLE `tbl_retur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_retur_barang`
--
ALTER TABLE `tbl_retur_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD CONSTRAINT `relasi_divisi` FOREIGN KEY (`id_divisi`) REFERENCES `tbl_divisi` (`id`),
  ADD CONSTRAINT `relasi_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id`);

--
-- Constraints for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD CONSTRAINT `relasi_kategori` FOREIGN KEY (`kategori_barang`) REFERENCES `tbl_kategori` (`id`);

--
-- Constraints for table `tbl_detail_bayar`
--
ALTER TABLE `tbl_detail_bayar`
  ADD CONSTRAINT `relasi_bayar` FOREIGN KEY (`id_detail_pinjam`) REFERENCES `tbl_detail_pinjaman` (`id`);

--
-- Constraints for table `tbl_detail_pinjaman`
--
ALTER TABLE `tbl_detail_pinjaman`
  ADD CONSTRAINT `id_pinjam` FOREIGN KEY (`id_pinjam`) REFERENCES `tbl_pinjaman` (`id`);

--
-- Constraints for table `tbl_detail_retur`
--
ALTER TABLE `tbl_detail_retur`
  ADD CONSTRAINT `id_detail_retur` FOREIGN KEY (`id_retur`) REFERENCES `tbl_retur` (`id`),
  ADD CONSTRAINT `id_detail_retur_barang` FOREIGN KEY (`id_barang`) REFERENCES `tbl_barang` (`id`);

--
-- Constraints for table `tbl_detail_transaksi`
--
ALTER TABLE `tbl_detail_transaksi`
  ADD CONSTRAINT `relasi_detail_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id`),
  ADD CONSTRAINT `relasi_transaksi_barang` FOREIGN KEY (`id_barang`) REFERENCES `tbl_barang` (`id`);

--
-- Constraints for table `tbl_pembelian_barang`
--
ALTER TABLE `tbl_pembelian_barang`
  ADD CONSTRAINT `relasi_pembelian_barang` FOREIGN KEY (`id_barang`) REFERENCES `tbl_barang` (`id`);

--
-- Constraints for table `tbl_pinjaman`
--
ALTER TABLE `tbl_pinjaman`
  ADD CONSTRAINT `relasi_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `tbl_anggota` (`id`);

--
-- Constraints for table `tbl_retur`
--
ALTER TABLE `tbl_retur`
  ADD CONSTRAINT `retur` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id`);

--
-- Constraints for table `tbl_retur_barang`
--
ALTER TABLE `tbl_retur_barang`
  ADD CONSTRAINT `retur_barang` FOREIGN KEY (`id_barang`) REFERENCES `tbl_barang` (`id`);

--
-- Constraints for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD CONSTRAINT `relasi_transaksi)_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `tbl_anggota` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
