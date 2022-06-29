-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2022 at 10:54 AM
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

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `causer_type`, `causer_id`, `properties`, `created_at`, `updated_at`) VALUES
(1, 'users', 'created', 'App\\Models\\User', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"username\":\"dedisupria\",\"name\":\"Dedi Supriadi\",\"phone\":\"85233879827\",\"member\":\"3690185052267603991\",\"ktp\":\"3215130101990003\",\"npwp\":\"99120039948853\",\"address\":null,\"email\":\"fahniamsyari1999@gmail.com\",\"level\":6,\"status\":1}}', '2022-06-29 08:35:10', '2022-06-29 08:35:10'),
(2, 'users', 'created', 'App\\Models\\User', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"username\":\"ginanjarsu\",\"name\":\"Ginanjar Subaiki\",\"phone\":\"82188928832\",\"member\":\"3690185052324521458\",\"ktp\":\"3215130101990002\",\"npwp\":\"9821192883727712\",\"address\":null,\"email\":\"fahniamsyari1998@gmail.com\",\"level\":6,\"status\":1}}', '2022-06-29 08:36:04', '2022-06-29 08:36:04'),
(3, 'tarif', 'created', 'App\\Models\\Tarif', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Listrik 1\",\"level\":1,\"data.Tarif\":null,\"status\":\"per-Kontrol\"}}', '2022-06-29 08:37:30', '2022-06-29 08:37:30'),
(4, 'tarif', 'created', 'App\\Models\\Tarif', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Air Bersih\",\"level\":2,\"data.Tarif\":null,\"status\":\"per-Kontrol\"}}', '2022-06-29 08:38:19', '2022-06-29 08:38:19'),
(5, 'tarif', 'created', 'App\\Models\\Tarif', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Keamanan IPK 1\",\"level\":3,\"data.Tarif\":\"120000\",\"status\":\"per-Los\"}}', '2022-06-29 08:38:39', '2022-06-29 08:38:39'),
(6, 'tarif', 'created', 'App\\Models\\Tarif', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Keamanan IPK 2\",\"level\":3,\"data.Tarif\":\"220000\",\"status\":\"per-Los\"}}', '2022-06-29 08:38:54', '2022-06-29 08:38:54'),
(7, 'tarif', 'created', 'App\\Models\\Tarif', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Kebersihan 1\",\"level\":4,\"data.Tarif\":\"145000\",\"status\":\"per-Los\"}}', '2022-06-29 08:39:15', '2022-06-29 08:39:15'),
(8, 'tarif', 'created', 'App\\Models\\Tarif', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Kebersihan 2\",\"level\":4,\"data.Tarif\":\"195000\",\"status\":\"per-Los\"}}', '2022-06-29 08:39:35', '2022-06-29 08:39:35'),
(9, 'tarif', 'created', 'App\\Models\\Tarif', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Air Kotor\",\"level\":5,\"data.Tarif\":\"3000000\",\"status\":\"per-Kontrol\"}}', '2022-06-29 08:40:15', '2022-06-29 08:40:15'),
(10, 'tarif', 'updated', 'App\\Models\\Tarif', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Air Kotor 1\",\"level\":5,\"data.Tarif\":\"3000000\",\"status\":\"per-Kontrol\"},\"old\":{\"name\":\"Air Kotor\",\"level\":5,\"data.Tarif\":\"3000000\",\"status\":\"per-Kontrol\"}}', '2022-06-29 08:40:27', '2022-06-29 08:40:27'),
(11, 'tarif', 'created', 'App\\Models\\Tarif', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Air Kotor 2\",\"level\":5,\"data.Tarif\":\"200000\",\"status\":\"per-Los\"}}', '2022-06-29 08:40:46', '2022-06-29 08:40:46'),
(12, 'tarif', 'created', 'App\\Models\\Tarif', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Parkir\",\"level\":6,\"data.Tarif\":\"10000\",\"status\":\"per-Kontrol\"}}', '2022-06-29 08:41:17', '2022-06-29 08:41:17'),
(13, 'tarif', 'created', 'App\\Models\\Tarif', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Parkir Los\",\"level\":6,\"data.Tarif\":\"2000\",\"status\":\"per-Los\"}}', '2022-06-29 08:41:34', '2022-06-29 08:41:34'),
(14, 'periode', 'created', 'App\\Models\\Periode', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"2022-06\",\"nicename\":\"Juni 2022\",\"new\":\"2022-06-23\",\"due\":\"2022-06-15\",\"year\":\"2022\",\"faktur\":1,\"surat\":1,\"status\":1}}', '2022-06-29 08:41:48', '2022-06-29 08:41:48'),
(15, 'periode', 'created', 'App\\Models\\Periode', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"2022-07\",\"nicename\":\"Juli 2022\",\"new\":\"2022-07-23\",\"due\":\"2022-07-15\",\"year\":\"2022\",\"faktur\":1,\"surat\":1,\"status\":1}}', '2022-06-29 08:41:55', '2022-06-29 08:41:55'),
(16, 'periode', 'created', 'App\\Models\\Periode', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"2022-05\",\"nicename\":\"Mei 2022\",\"new\":\"2022-05-23\",\"due\":\"2022-05-15\",\"year\":\"2022\",\"faktur\":1,\"surat\":1,\"status\":1}}', '2022-06-29 08:42:03', '2022-06-29 08:42:03'),
(17, 'periode', 'created', 'App\\Models\\Periode', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"2022-04\",\"nicename\":\"April 2022\",\"new\":\"2022-04-23\",\"due\":\"2022-04-15\",\"year\":\"2022\",\"faktur\":1,\"surat\":1,\"status\":1}}', '2022-06-29 08:42:09', '2022-06-29 08:42:09'),
(18, 'alat', 'created', 'App\\Models\\Alat', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"code\":\"2460702354459521195\",\"name\":\"007826612\",\"level\":1,\"stand\":432,\"daya\":450,\"status\":\"Tersedia\"}}', '2022-06-29 08:42:32', '2022-06-29 08:42:32'),
(19, 'alat', 'created', 'App\\Models\\Alat', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"code\":\"2460702354481682073\",\"name\":\"998217736\",\"level\":1,\"stand\":9987,\"daya\":900,\"status\":\"Tersedia\"}}', '2022-06-29 08:42:53', '2022-06-29 08:42:53'),
(20, 'alat', 'created', 'App\\Models\\Alat', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"code\":\"2460702354495590108\",\"name\":\"002718842\",\"level\":1,\"stand\":789,\"daya\":10500,\"status\":\"Tersedia\"}}', '2022-06-29 08:43:06', '2022-06-29 08:43:06'),
(21, 'alat', 'created', 'App\\Models\\Alat', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"code\":\"2460702354522362649\",\"name\":\"H1277SJAY2\",\"level\":2,\"stand\":112,\"daya\":null,\"status\":\"Tersedia\"}}', '2022-06-29 08:43:32', '2022-06-29 08:43:32'),
(22, 'alat', 'created', 'App\\Models\\Alat', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"code\":\"2460702354533657913\",\"name\":\"H26155255A55\",\"level\":2,\"stand\":653,\"daya\":null,\"status\":\"Tersedia\"}}', '2022-06-29 08:43:43', '2022-06-29 08:43:43'),
(23, 'alat', 'created', 'App\\Models\\Alat', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"code\":\"2460702354548065838\",\"name\":\"H123YY4162553\",\"level\":2,\"stand\":899,\"daya\":null,\"status\":\"Tersedia\"}}', '2022-06-29 08:43:56', '2022-06-29 08:43:56');

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
  `old` int(11) DEFAULT NULL,
  `daya` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id`, `code`, `name`, `level`, `stand`, `old`, `daya`, `status`, `updated_at`, `created_at`) VALUES
(1, '2460702354459521195', '007826612', 1, 432, NULL, 450, 1, '2022-06-29 15:42:32', '2022-06-29 15:42:32'),
(2, '2460702354481682073', '998217736', 1, 9987, NULL, 900, 1, '2022-06-29 15:42:53', '2022-06-29 15:42:53'),
(3, '2460702354495590108', '002718842', 1, 789, NULL, 10500, 1, '2022-06-29 15:43:06', '2022-06-29 15:43:06'),
(4, '2460702354522362649', 'H1277SJAY2', 2, 112, NULL, NULL, 1, '2022-06-29 15:43:32', '2022-06-29 15:43:32'),
(5, '2460702354533657913', 'H26155255A55', 2, 653, NULL, NULL, 1, '2022-06-29 15:43:43', '2022-06-29 15:43:43'),
(6, '2460702354548065838', 'H123YY4162553', 2, 899, NULL, NULL, 1, '2022-06-29 15:43:56', '2022-06-29 15:43:56');

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

--
-- Dumping data for table `authentication_log`
--

INSERT INTO `authentication_log` (`id`, `authenticatable_type`, `authenticatable_id`, `ip_address`, `user_agent`, `login_at`, `login_successful`, `logout_at`, `cleared_by_user`, `location`) VALUES
(1, 'App\\Models\\User', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', '2022-06-29 08:33:22', 1, NULL, 0, '{\"ip\":\"127.0.0.0\",\"iso_code\":\"US\",\"country\":\"United States\",\"city\":\"New Haven\",\"state\":\"CT\",\"state_name\":\"Connecticut\",\"postal_code\":\"06510\",\"lat\":41.31,\"lon\":-72.92,\"timezone\":\"America\\/New_York\",\"continent\":\"NA\",\"currency\":\"USD\",\"default\":true,\"cached\":false}');

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
(1, 'A-1', 'A1', 'A', '1', '[\"1\",\"2\",\"2A\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\"]', '2022-06-29 15:51:50', '2022-06-29 15:51:50'),
(2, 'E-10', 'E10', 'E', '10', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\"]', '2022-06-29 15:52:11', '2022-06-29 15:52:11'),
(3, 'E-8', 'E8', 'E', '8', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\"]', '2022-06-29 15:52:38', '2022-06-29 15:52:38');

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
(12, '2022_06_01_081536_create_tempat', 1),
(13, '2022_06_07_115804_create_tagihan', 1),
(14, '2022_06_28_140134_create_payments', 1);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nicename` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `los` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`los`)),
  `jml_los` int(11) NOT NULL,
  `pengguna_id` bigint(20) UNSIGNED NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tagihan_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tagihan_ids`)),
  `tagihan` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
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
(1, '2022-06', 'Juni 2022', '2022-06-23', '2022-06-15', '2022', 1, 1, 1, '2022-06-29 15:41:48', '2022-06-29 15:41:48'),
(2, '2022-07', 'Juli 2022', '2022-07-23', '2022-07-15', '2022', 1, 1, 1, '2022-06-29 15:41:55', '2022-06-29 15:41:55'),
(3, '2022-05', 'Mei 2022', '2022-05-23', '2022-05-15', '2022', 1, 1, 1, '2022-06-29 15:42:03', '2022-06-29 15:42:03'),
(4, '2022-04', 'April 2022', '2022-04-23', '2022-04-15', '2022', 1, 1, 1, '2022-06-29 15:42:09', '2022-06-29 15:42:09');

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
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode_id` bigint(20) UNSIGNED NOT NULL,
  `stt_publish` tinyint(4) NOT NULL DEFAULT 0,
  `stt_lunas` tinyint(4) NOT NULL DEFAULT 0,
  `tempat_id` bigint(20) UNSIGNED NOT NULL,
  `pengguna_id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `los` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`los`)),
  `jml_los` int(11) NOT NULL,
  `listrik` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`listrik`)),
  `airbersih` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`airbersih`)),
  `keamananipk` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`keamananipk`)),
  `kebersihan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`kebersihan`)),
  `airkotor` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`airkotor`)),
  `lainnya` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lainnya`)),
  `tagihan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`tagihan`)),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
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
(1, 'Listrik 1', 1, '{\"Tarif_Rekmin\":\"0\",\"Tarif_Beban\":\"50\",\"Tarif_Blok_1\":\"0\",\"Tarif_Blok_2\":\"2404\",\"Standar_Operasional\":\"0\",\"PJU\":\"18\",\"Denda_1\":\"50000\",\"Denda_2\":\"3\",\"PPN\":\"11\",\"Tarif_Pasang\":\"30000\"}', 1, '2022-06-29 15:37:30', '2022-06-29 15:37:30'),
(2, 'Air Bersih', 2, '{\"Tarif_1\":\"6000\",\"Tarif_2\":\"7500\",\"Tarif_Pemeliharaan\":\"25000\",\"Tarif_Beban\":\"15000\",\"Tarif_Air_Kotor\":\"30\",\"Denda\":\"50000\",\"PPN\":\"11\",\"Tarif_Pasang\":\"2000000\"}', 1, '2022-06-29 15:38:19', '2022-06-29 15:38:19'),
(3, 'Keamanan IPK 1', 3, '{\"Tarif\":\"120000\",\"Persen_Keamanan\":\"65\",\"Persen_IPK\":\"35\"}', 2, '2022-06-29 15:38:39', '2022-06-29 15:38:39'),
(4, 'Keamanan IPK 2', 3, '{\"Tarif\":\"220000\",\"Persen_Keamanan\":\"67\",\"Persen_IPK\":\"33\"}', 2, '2022-06-29 15:38:54', '2022-06-29 15:38:54'),
(5, 'Kebersihan 1', 4, '{\"Tarif\":\"145000\"}', 2, '2022-06-29 15:39:15', '2022-06-29 15:39:15'),
(6, 'Kebersihan 2', 4, '{\"Tarif\":\"195000\"}', 2, '2022-06-29 15:39:35', '2022-06-29 15:39:35'),
(7, 'Air Kotor 1', 5, '{\"Tarif\":\"3000000\"}', 1, '2022-06-29 15:40:27', '2022-06-29 15:40:15'),
(8, 'Air Kotor 2', 5, '{\"Tarif\":\"200000\"}', 2, '2022-06-29 15:40:46', '2022-06-29 15:40:46'),
(9, 'Parkir', 6, '{\"Tarif\":\"10000\"}', 1, '2022-06-29 15:41:16', '2022-06-29 15:41:16'),
(10, 'Parkir Los', 6, '{\"Tarif\":\"2000\"}', 2, '2022-06-29 15:41:34', '2022-06-29 15:41:34');

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
(1, 'super_admin', 'Super Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$argon2id$v=19$m=65536,t=4,p=1$dUh2bC56RDJWZkEwYmoueA$QpcOza8BLo9V8bRx2obh5Aa1TUUimJtOXoLw17eddT8', NULL, 1, NULL, 1, '2022-06-29 15:33:22', '2022-06-29 15:29:27'),
(2, 'dedisupria', 'Dedi Supriadi', '85233879827', '3690185052267603991', '3215130101990003', '99120039948853', NULL, 'fahniamsyari1999@gmail.com', NULL, '$argon2id$v=19$m=65536,t=4,p=1$M2tBU280dmplSWozY25ySQ$/H8kpM+OSc6w1ZEWbwBllpI78zDtv4BrjgusypLcHv0', NULL, 6, NULL, 1, '2022-06-29 15:35:10', '2022-06-29 15:35:10'),
(3, 'ginanjarsu', 'Ginanjar Subaiki', '82188928832', '3690185052324521458', '3215130101990002', '9821192883727712', NULL, 'fahniamsyari1998@gmail.com', NULL, '$argon2id$v=19$m=65536,t=4,p=1$QUNjMXpTRkk4WmRBaEdkeg$HDq24E46gDa5+y1zcsIRfhsoMDEaP280wtoy64UTKb4', NULL, 6, NULL, 1, '2022-06-29 15:36:04', '2022-06-29 15:36:04');

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_pengguna_id_foreign` (`pengguna_id`);

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
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tagihan_code_unique` (`code`),
  ADD KEY `tagihan_periode_id_foreign` (`periode_id`),
  ADD KEY `tagihan_tempat_id_foreign` (`tempat_id`),
  ADD KEY `tagihan_pengguna_id_foreign` (`pengguna_id`),
  ADD KEY `tagihan_group_id_foreign` (`group_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `authentication_log`
--
ALTER TABLE `authentication_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
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
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `tagihan_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tagihan_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periode` (`id`),
  ADD CONSTRAINT `tagihan_tempat_id_foreign` FOREIGN KEY (`tempat_id`) REFERENCES `tempat` (`id`);

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
