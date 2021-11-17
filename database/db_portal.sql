-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2021 at 06:40 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `blok`
--

CREATE TABLE `blok` (
  `id` int(11) NOT NULL,
  `nama` varchar(10) DEFAULT NULL,
  `keterangan` longtext DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blok`
--

INSERT INTO `blok` (`id`, `nama`, `keterangan`, `updated_at`, `created_at`) VALUES
(1, 'A-1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'A-2', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'B-1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'B-2', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'B-3', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'B-4', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'C-1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'D-1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'E-0', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'E-1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'E-2', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'E-3', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'E-4', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'E-5', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'E-6', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'E-7', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'E-8', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'E-9', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'E10', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'F-0', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'F-1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'FIB', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'H-1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'H-2', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'K5', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'L-0', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'M-1', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'MCK', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'P-O', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'POM', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'WC', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'TLK', NULL, '2020-11-16 04:06:27', '2020-11-16 04:06:27'),
(36, 'GARDU', NULL, '2020-12-23 18:01:06', '2020-12-23 18:01:06'),
(37, 'M-2', NULL, '2021-04-22 06:15:43', '2021-04-22 06:15:43');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_data`
--

CREATE TABLE `login_data` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `stt_aktif` tinyint(1) DEFAULT NULL,
  `platform` longtext DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_data`
--

INSERT INTO `login_data` (`id`, `username`, `nama`, `level`, `stt_aktif`, `platform`, `status`, `updated_at`, `created_at`) VALUES
(1, 'super_admin', 'Fahni Amsyari', 1, 1, 'Windows 10.0 Chrome 95.0.4638.69', 1, '2021-11-17 17:36:31', '2021-11-17 17:36:31');

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
(5, '2021_02_01_000005_create_short_urls_table', 2);

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'storage/users/user.jpg',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT 3,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `anggota` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ktp` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otoritas` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stt_aktif` tinyint(1) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nonaktif` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_aktivasi` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `foto`, `username`, `name`, `level`, `phone`, `email`, `email_verified_at`, `anggota`, `ktp`, `npwp`, `alamat`, `otoritas`, `stt_aktif`, `password`, `remember_token`, `nonaktif`, `kode_aktivasi`, `created_at`, `updated_at`) VALUES
(1, 'storage/users/1.png', 'super_admin', 'Fahni Amsyari', 1, '895337845511', 'levindsein@gmail.com', NULL, 'BP3C11111111', '3215130101990003', NULL, 'Perum Villa Permata Cikampek Blok EG 2 no.27', NULL, 1, '$2y$10$IXdR6okRwL0spFxa.nidZ.znCidchYpvA2a1b60Q1I0kq.xUGUhhe', NULL, NULL, NULL, '2021-11-09 16:22:51', '2021-11-17 16:55:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blok`
--
ALTER TABLE `blok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `login_data`
--
ALTER TABLE `login_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `telephone` (`phone`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blok`
--
ALTER TABLE `blok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_data`
--
ALTER TABLE `login_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
