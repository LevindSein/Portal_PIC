-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2022 at 09:37 AM
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
-- Database: `db_epasar`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL,
  `stand` int(11) NOT NULL,
  `daya` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id`, `code`, `name`, `level`, `stand`, `daya`, `status`, `updated_at`, `created_at`) VALUES
(1, '2460700084482461220', 'H109288127462', 1, 325, 900, 1, '2022-06-04 14:22:13', '2022-06-04 14:22:13'),
(2, '2460700084519605760', 'H2H1JAD6241216', 1, 99984, 10500, 1, '2022-06-04 14:22:49', '2022-06-04 14:22:49'),
(3, '2460700084540422230', 'H2736DA88271', 1, 230, 450, 1, '2022-06-04 14:23:08', '2022-06-04 14:23:08'),
(4, '2460700084562725459', 'KV273618827', 2, 284, NULL, 1, '2022-06-04 14:23:30', '2022-06-04 14:23:30'),
(5, '2460700084582895588', 'YWTQ26645261', 2, 99993, NULL, 1, '2022-06-04 14:23:49', '2022-06-04 14:23:49'),
(6, '2460700084594172807', '64281KVDSAADJHG', 2, 2538, NULL, 1, '2022-06-04 14:24:00', '2022-06-04 14:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `authentication_log`
--

CREATE TABLE `authentication_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `authenticatable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authenticatable_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_at` timestamp NULL DEFAULT NULL,
  `login_successful` tinyint(1) NOT NULL DEFAULT 0,
  `logout_at` timestamp NULL DEFAULT NULL,
  `cleared_by_user` tinyint(1) NOT NULL DEFAULT 0,
  `location` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`location`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `changelogs`
--

CREATE TABLE `changelogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `times` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nicename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blok` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `nicename`, `blok`, `nomor`, `data`, `updated_at`, `created_at`) VALUES
(1, 'A-1', 'A1', 'A', '1', '[\"1\",\"2\",\"2A\",\"2B\",\"3\",\"4\",\"5\",\"6\",\"7\"]', '2022-06-04 14:36:13', '2022-06-04 14:36:13'),
(2, 'A-2', 'A2', 'A', '2', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"21\",\"24\",\"31\",\"32\",\"42\",\"124\",\"324\",\"432\",\"SD\"]', '2022-06-04 14:36:35', '2022-06-04 14:36:27');

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
(5, '2022_05_19_135832_create_groups', 1),
(6, '2022_05_19_160120_create_authentication_log_table', 1),
(7, '2022_05_23_111757_create_activity_log_table', 1),
(8, '2022_05_25_181657_create_changelogs', 1),
(9, '2022_05_28_161953_create_tarif', 1),
(10, '2022_05_30_145350_create_alat', 1),
(11, '2022_05_31_131542_create_periode', 1),
(12, '2022_06_01_081536_create_tempat', 1);

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
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nicename` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new` date NOT NULL,
  `due` date NOT NULL,
  `year` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faktur` int(11) NOT NULL DEFAULT 1,
  `surat` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id`, `name`, `nicename`, `new`, `due`, `year`, `faktur`, `surat`, `status`, `updated_at`, `created_at`) VALUES
(1, '2022-06', 'Juni 2022', '2022-06-23', '2022-06-15', '2022', 1, 1, 1, '2022-06-04 14:20:17', '2022-06-04 14:20:17'),
(2, '2022-05', 'Mei 2022', '2022-05-23', '2022-05-15', '2022', 1, 1, 1, '2022-06-04 14:20:26', '2022-06-04 14:20:26'),
(3, '2022-07', 'Juli 2022', '2022-07-23', '2022-07-15', '2022', 1, 1, 1, '2022-06-04 14:20:34', '2022-06-04 14:20:34');

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
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id`, `name`, `level`, `data`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Listrik 1', 1, '{\"Tarif_Rekmin\":\"0\",\"Tarif_Beban\":\"50\",\"Tarif_Blok_1\":\"0\",\"Tarif_Blok_2\":\"2404\",\"Standar_Operasional\":\"0\",\"PJU\":\"18\",\"Denda_1\":\"50000\",\"Denda_2\":\"3\",\"PPN\":\"11\",\"Tarif_Pasang\":\"3000\"}', 1, '2022-06-04 14:24:29', '2022-06-04 14:24:29'),
(2, 'Air Bersih 1', 2, '{\"Tarif_1\":\"6000\",\"Tarif_2\":\"7500\",\"Tarif_Pemeliharaan\":\"25000\",\"Tarif_Beban\":\"15000\",\"Tarif_Air_Kotor\":\"30\",\"Denda\":\"50000\",\"PPN\":\"11\",\"Tarif_Pasang\":\"1000000\"}', 1, '2022-06-04 14:25:38', '2022-06-04 14:25:38'),
(3, 'Keamanan IPK 1', 3, '{\"Tarif\":\"120000\",\"Persen_Keamanan\":\"65\",\"Persen_IPK\":\"35\"}', 2, '2022-06-04 14:26:29', '2022-06-04 14:26:29'),
(4, 'Keamanan IPK 2', 3, '{\"Tarif\":\"160000\",\"Persen_Keamanan\":\"75\",\"Persen_IPK\":\"25\"}', 2, '2022-06-04 14:30:03', '2022-06-04 14:30:03'),
(5, 'Kebersihan 1', 4, '{\"Tarif\":\"200000\"}', 2, '2022-06-04 14:30:24', '2022-06-04 14:30:24'),
(6, 'Kebersihan 2', 4, '{\"Tarif\":\"220000\"}', 2, '2022-06-04 14:30:36', '2022-06-04 14:30:36'),
(7, 'Arkot 1', 5, '{\"Tarif\":\"300000\"}', 1, '2022-06-04 14:30:55', '2022-06-04 14:30:55'),
(8, 'Arkot 2', 5, '{\"Tarif\":\"3000000\"}', 1, '2022-06-04 14:31:04', '2022-06-04 14:31:04'),
(9, 'Parkir 1', 6, '{\"Tarif\":\"20000\"}', 1, '2022-06-04 14:31:39', '2022-06-04 14:31:21'),
(10, 'Parkir 2', 6, '{\"Tarif\":\"2000\"}', 2, '2022-06-04 14:31:31', '2022-06-04 14:31:31');

-- --------------------------------------------------------

--
-- Table structure for table `tempat`
--

CREATE TABLE `tempat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nicename` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `los` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`los`)),
  `jml_los` int(11) NOT NULL,
  `pengguna_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pemilik_id` bigint(20) UNSIGNED DEFAULT NULL,
  `alat_listrik_id` bigint(20) UNSIGNED DEFAULT NULL,
  `alat_airbersih_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trf_listrik_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trf_airbersih_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trf_keamananipk_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trf_kebersihan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trf_airkotor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `trf_lainnya_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`trf_lainnya_id`)),
  `diskon` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`diskon`)),
  `ket` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ktp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` tinyint(4) NOT NULL,
  `otoritas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`otoritas`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `phone`, `member`, `ktp`, `npwp`, `address`, `email`, `email_verified_at`, `password`, `remember_token`, `level`, `otoritas`, `status`, `updated_at`, `created_at`) VALUES
(1, 'super_admin', 'Super Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$argon2id$v=19$m=65536,t=4,p=1$U000aHVtdDMxZWppUjhtQQ$P34WAf8taIFyk1LsnyG9PCwnyFShD3R+2sf3KRejN88', NULL, 1, NULL, 1, '2022-06-04 14:19:41', '2022-06-04 14:19:29'),
(2, 'ahmadjumha', 'Ahmad Jumhari', NULL, '3690182783373985958', '1111111111111111', NULL, NULL, NULL, NULL, '$argon2id$v=19$m=65536,t=4,p=1$TzczYWd3YlRLN1ZjOTh1MA$tHTE93Wu9mrXdQU3rQqEt29q3ISUcvkLLcDCox7WNis', NULL, 6, NULL, 1, '2022-06-04 14:32:04', '2022-06-04 14:32:04'),
(3, 'ahmadsaefu', 'Ahmad Saeful', NULL, '3690182783385625862', '2222222222222222', NULL, NULL, NULL, NULL, '$argon2id$v=19$m=65536,t=4,p=1$eWhObnpCL3dQOXZuNkxITQ$GxKh3LrbyXvGNn4NbOQoQamkJEjX9ZoyphJKhWc6uhQ', NULL, 6, NULL, 1, '2022-06-04 14:32:15', '2022-06-04 14:32:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alat_code_unique` (`code`),
  ADD UNIQUE KEY `alat_name_unique` (`name`);

--
-- Indexes for table `authentication_log`
--
ALTER TABLE `authentication_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authentication_log_authenticatable_type_authenticatable_id_index` (`authenticatable_type`,`authenticatable_id`);

--
-- Indexes for table `changelogs`
--
ALTER TABLE `changelogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `changelogs_code_unique` (`code`),
  ADD KEY `changelogs_causer_id_foreign` (`causer_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_name_unique` (`name`),
  ADD UNIQUE KEY `groups_nicename_unique` (`nicename`);

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
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periode_name_unique` (`name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tarif_name_unique` (`name`);

--
-- Indexes for table `tempat`
--
ALTER TABLE `tempat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tempat_group_id_foreign` (`group_id`),
  ADD KEY `tempat_pengguna_id_foreign` (`pengguna_id`),
  ADD KEY `tempat_pemilik_id_foreign` (`pemilik_id`),
  ADD KEY `tempat_alat_listrik_id_foreign` (`alat_listrik_id`),
  ADD KEY `tempat_alat_airbersih_id_foreign` (`alat_airbersih_id`),
  ADD KEY `tempat_trf_listrik_id_foreign` (`trf_listrik_id`),
  ADD KEY `tempat_trf_airbersih_id_foreign` (`trf_airbersih_id`),
  ADD KEY `tempat_trf_keamananipk_id_foreign` (`trf_keamananipk_id`),
  ADD KEY `tempat_trf_kebersihan_id_foreign` (`trf_kebersihan_id`),
  ADD KEY `tempat_trf_airkotor_id_foreign` (`trf_airkotor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_member_unique` (`member`),
  ADD UNIQUE KEY `users_ktp_unique` (`ktp`),
  ADD UNIQUE KEY `users_npwp_unique` (`npwp`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `authentication_log`
--
ALTER TABLE `authentication_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `changelogs`
--
ALTER TABLE `changelogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tempat`
--
ALTER TABLE `tempat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `changelogs`
--
ALTER TABLE `changelogs`
  ADD CONSTRAINT `changelogs_causer_id_foreign` FOREIGN KEY (`causer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tempat`
--
ALTER TABLE `tempat`
  ADD CONSTRAINT `tempat_alat_airbersih_id_foreign` FOREIGN KEY (`alat_airbersih_id`) REFERENCES `alat` (`id`),
  ADD CONSTRAINT `tempat_alat_listrik_id_foreign` FOREIGN KEY (`alat_listrik_id`) REFERENCES `alat` (`id`),
  ADD CONSTRAINT `tempat_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `tempat_pemilik_id_foreign` FOREIGN KEY (`pemilik_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tempat_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tempat_trf_airbersih_id_foreign` FOREIGN KEY (`trf_airbersih_id`) REFERENCES `tarif` (`id`),
  ADD CONSTRAINT `tempat_trf_airkotor_id_foreign` FOREIGN KEY (`trf_airkotor_id`) REFERENCES `tarif` (`id`),
  ADD CONSTRAINT `tempat_trf_keamananipk_id_foreign` FOREIGN KEY (`trf_keamananipk_id`) REFERENCES `tarif` (`id`),
  ADD CONSTRAINT `tempat_trf_kebersihan_id_foreign` FOREIGN KEY (`trf_kebersihan_id`) REFERENCES `tarif` (`id`),
  ADD CONSTRAINT `tempat_trf_listrik_id_foreign` FOREIGN KEY (`trf_listrik_id`) REFERENCES `tarif` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
