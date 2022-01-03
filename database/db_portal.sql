-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2022 at 04:43 PM
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
-- Table structure for table `activation_code`
--

CREATE TABLE `activation_code` (
  `id` bigint(20) NOT NULL,
  `code` varchar(6) NOT NULL,
  `available` timestamp NULL DEFAULT NULL,
  `submit` tinyint(1) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `id_period` int(11) DEFAULT NULL,
  `stt_publish` tinyint(1) DEFAULT NULL,
  `stt_lunas` tinyint(1) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `kd_kontrol` varchar(20) DEFAULT NULL,
  `nicename` varchar(50) DEFAULT NULL,
  `group` varchar(10) DEFAULT NULL,
  `no_los` text DEFAULT NULL,
  `jml_los` tinyint(4) DEFAULT NULL,
  `code_tlistrik` varchar(8) DEFAULT NULL,
  `code_tairbersih` varchar(8) DEFAULT NULL,
  `b_listrik` text DEFAULT NULL,
  `b_airbersih` text DEFAULT NULL,
  `b_keamananipk` text DEFAULT NULL,
  `b_kebersihan` text DEFAULT NULL,
  `b_airkotor` text DEFAULT NULL,
  `b_lain` text DEFAULT NULL,
  `b_tagihan` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `deleted` longtext DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `code`, `id_period`, `stt_publish`, `stt_lunas`, `name`, `kd_kontrol`, `nicename`, `group`, `no_los`, `jml_los`, `code_tlistrik`, `code_tairbersih`, `b_listrik`, `b_airbersih`, `b_keamananipk`, `b_kebersihan`, `b_airkotor`, `b_lain`, `b_tagihan`, `data`, `active`, `deleted`, `updated_at`, `created_at`) VALUES
(1, '6874971429', 2, 1, 1, 'Master Didi Kempot', 'A-1-001', 'A1001', 'A-1', '1', 1, NULL, NULL, '{\"lunas\":1,\"kasir\":\"Master Didi Kempot\",\"code\":\"PKSQZCLMXF\",\"tarif_id\":\"1\",\"tarif_nama\":\"Tarif 1\",\"daya\":\"900\",\"awal\":\"1300\",\"akhir\":\"1500\",\"reset\":null,\"pakai\":200,\"blok1\":0,\"blok2\":480800,\"beban\":45000,\"pju\":94644,\"ppn\":62045,\"jml_los\":1,\"sub_tagihan\":682489,\"denda\":0,\"denda_bulan\":null,\"diskon\":0,\"diskon_persen\":null,\"ttl_tagihan\":682489,\"rea_tagihan\":682489,\"sel_tagihan\":0,\"restored_by_id\":null,\"restored_by_name\":null,\"restored_time\":null}', NULL, NULL, NULL, NULL, NULL, '{\"lunas\":1,\"sub_tagihan\":682489,\"denda\":0,\"diskon\":0,\"ttl_tagihan\":682489,\"rea_tagihan\":682489,\"sel_tagihan\":0}', '{\"publish\":\"2022-01-03 22:25:46\",\"publish_by\":\"Master Didi Kempot\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2022-01-03 22:25:46\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2022-01-03 22:25:46\"}', 1, NULL, '2022-01-03 15:29:19', '2022-01-03 15:25:46'),
(2, '7331580106', 1, 1, 1, 'Master Didi Kempot', 'A-1-001', 'A1001', 'A-1', '1', 1, NULL, NULL, '{\"lunas\":1,\"kasir\":\"Master Didi Kempot\",\"code\":\"PKSQZCLMXF\",\"tarif_id\":\"1\",\"tarif_nama\":\"Tarif 1\",\"daya\":\"900\",\"awal\":\"1200\",\"akhir\":\"1300\",\"reset\":null,\"pakai\":100,\"blok1\":0,\"blok2\":240400,\"beban\":45000,\"pju\":51372,\"ppn\":33678,\"jml_los\":1,\"sub_tagihan\":370450,\"denda\":0,\"denda_bulan\":null,\"diskon\":0,\"diskon_persen\":null,\"ttl_tagihan\":370450,\"rea_tagihan\":370450,\"sel_tagihan\":0,\"restored_by_id\":null,\"restored_by_name\":null,\"restored_time\":null}', NULL, NULL, NULL, NULL, '[{\"lunas\":1,\"kasir\":\"Master Didi Kempot\",\"code\":\"WSANDUHYLW\",\"tarif_id\":\"2\",\"tarif_nama\":\"Parkir\",\"price\":2000,\"jml_los\":1,\"satuan_id\":2,\"satuan_nama\":\"per-Los\",\"sub_tagihan\":2000,\"ttl_tagihan\":2000,\"rea_tagihan\":2000,\"sel_tagihan\":0},{\"lunas\":1,\"kasir\":\"Master Didi Kempot\",\"code\":\"WSANDUHYLW\",\"tarif_id\":\"1\",\"tarif_nama\":\"Preman\",\"price\":100000,\"jml_los\":1,\"satuan_id\":1,\"satuan_nama\":\"per-Kontrol\",\"sub_tagihan\":100000,\"ttl_tagihan\":100000,\"rea_tagihan\":100000,\"sel_tagihan\":0}]', '{\"lunas\":1,\"sub_tagihan\":472450,\"denda\":0,\"diskon\":0,\"ttl_tagihan\":472450,\"rea_tagihan\":472450,\"sel_tagihan\":0}', '{\"publish\":\"2022-01-03 22:29:33\",\"publish_by\":\"Master Didi Kempot\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2022-01-03 22:26:15\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2022-01-03 22:29:33\"}', 1, NULL, '2022-01-03 15:43:16', '2022-01-03 15:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `change_logs`
--

CREATE TABLE `change_logs` (
  `id` bigint(20) NOT NULL,
  `release_date` varchar(20) DEFAULT NULL,
  `data` longtext DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `change_logs`
--

INSERT INTO `change_logs` (`id`, `release_date`, `data`, `updated_at`, `created_at`) VALUES
(1, '29-05-2021 14:14:29', '{\"title\":\"Add Feature\",\"data\":\"Tambah Detail Keuangan\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:15:07\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2022-01-03 19:20:10\",\"release\":\"2021-05-29T14:14:29\"}', '2022-01-03 12:20:10', '2021-12-27 07:15:07'),
(2, '28-04-2021 14:15:23', '{\"title\":\"Add Feature\",\"data\":\"1. Tambah Profile Settings.\\r\\n2. Tambah Kotak Saran\\r\\n3. Fixing Bugs\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:16:16\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:16:16\"}', '2021-12-27 07:16:16', '2021-12-27 07:16:16'),
(3, '27-04-2021 14:16:52', '{\"title\":\"Improve System\",\"data\":\"1. Perbaikan Arsiektur Database\\r\\n2. Detail Data Usaha\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:17:44\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:17:44\"}', '2021-12-27 07:17:44', '2021-12-27 07:17:44'),
(4, '22-04-2021 14:18:03', '{\"title\":\"Add Feature\",\"data\":\"1. Tambah laporan tunggakan\\r\\n2. Tambah generate laporan\\r\\n3. fixing bugs\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:19:02\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:19:02\"}', '2021-12-27 07:19:02', '2021-12-27 07:19:02'),
(5, '07-04-2021 14:19:15', '{\"title\":\"Add Feature\",\"data\":\"1. Tambah cetak struk susulan kasir\\r\\n2. notifikasi pembayaran kasir\\r\\n3. keuangan selesai.\\r\\n4. fixing bugs kelola tagihan\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:20:06\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:21:07\",\"release\":\"2021-04-07T14:19:15\"}', '2021-12-27 07:21:07', '2021-12-27 07:20:06'),
(6, '04-04-2021 14:21:14', '{\"title\":\"Update Caringin Version 2.0.1\",\"data\":\"1. Improve System\\r\\n2. Improve UI\\/UX\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:21:46\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:21:46\"}', '2021-12-27 07:21:46', '2021-12-27 07:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `commodities`
--

CREATE TABLE `commodities` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `data_login`
--

CREATE TABLE `data_login` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `platform` longtext DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_login`
--

INSERT INTO `data_login` (`id`, `uid`, `name`, `level`, `active`, `platform`, `status`, `updated_at`, `created_at`) VALUES
(1, 'super_admin', 'Master Didi Kempot', 1, 1, 'Windows 10.0 Chrome 96.0.4664.110 127.0.0.1', 1, '2022-01-03 10:05:12', '2022-01-03 10:05:12'),
(2, 'super_admin', 'Master Didi Kempot', 1, 1, 'Windows 10.0 Chrome 96.0.4664.110 127.0.0.1', 1, '2022-01-03 11:16:56', '2022-01-03 11:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `day_off`
--

CREATE TABLE `day_off` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `day_off`
--

INSERT INTO `day_off` (`id`, `date`, `data`, `updated_at`, `created_at`) VALUES
(1, '2022-04-15', '{\"desc\":\"Libur Nasional Wafat Isa Al Masih\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:41:16\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:41:16\"}', '2021-12-27 14:41:16', '2021-12-27 14:41:16'),
(2, '2022-05-15', '{\"desc\":\"Hari Minggu\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:44:14\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:44:14\"}', '2021-12-27 14:44:14', '2021-12-27 14:44:14');

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
  `id` int(11) NOT NULL,
  `name` varchar(10) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `data`, `updated_at`, `created_at`) VALUES
(1, 'A-1', '{\"data\":\"1,2,3,3A,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,43A\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-12-27 14:13:23\"}', '2021-12-27 07:13:23', '2020-11-16 04:06:27'),
(2, 'A-2', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:40:44', '2020-11-16 04:06:27'),
(3, 'B-1', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,32A,33,33A,34,35,36,37,38,39,40,41,42\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:40:48', '2020-11-16 04:06:27'),
(4, 'B-2', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 11:20:13', '2020-11-16 04:06:27'),
(5, 'B-3', '{\"data\":\"1,2,3,4,5,6,7,8,9,10\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:40:52', '2020-11-16 04:06:27'),
(6, 'B-4', '{\"data\":\"1,2,3,4,5,6,7,8,9,10\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:40:55', '2020-11-16 04:06:27'),
(7, 'C-1', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,21A,22,23,24,25,26,27,27A,27B,27C,28,29,30,31,32,33,34,35\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:01', '2020-11-16 04:06:27'),
(8, 'D-1', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:05', '2020-11-16 04:06:27'),
(9, 'E-0', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47A,47B,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,364,365,366,367,368,369,370,371,372,373,374,375,376,377,378,379,380\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:10', '2020-11-16 04:06:27'),
(10, 'E-1', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:13', '2020-11-16 04:06:27'),
(11, 'E-2', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37A,37B,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:42:02', '2020-11-16 04:06:27'),
(12, 'E-3', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:59', '2020-11-16 04:06:27'),
(13, 'E-4', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:56', '2020-11-16 04:06:27'),
(14, 'E-5', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:52', '2020-11-16 04:06:27'),
(15, 'E-6', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:48', '2020-11-16 04:06:27'),
(16, 'E-7', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:36', '2020-11-16 04:06:27'),
(17, 'E-8', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:29', '2020-11-16 04:06:27'),
(18, 'E-9', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:26', '2020-11-16 04:06:27'),
(19, 'E10', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:23', '2020-11-16 04:06:27'),
(20, 'F-0', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,203,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,364,365,366,367,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:41:19', '2020-11-16 04:06:27'),
(21, 'F-1', '{\"data\":\"88\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:42:10', '2020-11-16 04:06:27'),
(22, 'FIB', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:42:14', '2020-11-16 04:06:27'),
(23, 'H-1', '{\"data\":\"1,2,3,4,5,6,7,8,8A,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26A,26B,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114A,114B,115,116,117,118,119,120,121,122,123,124,125,126,127,128\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:42:24', '2020-11-16 04:06:27'),
(24, 'H-2', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:42:27', '2020-11-16 04:06:27'),
(25, 'K5', '{\"data\":\"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21\",\"created_by_id\":1598,\"created_by_name\":\"Super Admin\",\"created_at\":\"2021-04-04 21:18:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Super Admin\",\"updated_at\":\"2021-04-04  21:18:35\"}', '2021-12-02 22:42:31', '2020-11-16 04:06:27'),
(28, 'L-0', '{\"data\":null,\"user_create\":1598,\"username_create\":\"MASTER\",\"created_at\":\"2021-12-03 05:42:35\",\"user_update\":1598,\"username_update\":\"MASTER\",\"updated_at\":\"2021-12-03 05:42:35\"}', '2021-12-02 22:42:35', '2020-11-16 04:06:27'),
(29, 'M-1', '{\"data\":null,\"user_create\":1598,\"username_create\":\"MASTER\",\"created_at\":\"2021-12-03 05:42:39\",\"user_update\":1598,\"username_update\":\"MASTER\",\"updated_at\":\"2021-12-03 05:42:39\"}', '2021-12-02 22:42:39', '2020-11-16 04:06:27'),
(30, 'MCK', '{\"data\":null,\"user_create\":1598,\"username_create\":\"MASTER\",\"created_at\":\"2021-12-03 05:42:52\",\"user_update\":1598,\"username_update\":\"MASTER\",\"updated_at\":\"2021-12-03 05:42:52\"}', '2021-12-02 22:42:52', '2020-11-16 04:06:27'),
(31, 'P-O', '{\"data\":\"1B,1C\",\"user_create\":1598,\"username_create\":\"MASTER\",\"created_at\":\"2021-12-02 21:11:41\",\"user_update\":1598,\"username_update\":\"MASTER\",\"updated_at\":\"2021-12-03 05:42:58\"}', '2021-12-02 22:42:58', '2020-11-16 04:06:27'),
(32, 'POM', '{\"data\":\"1,2\",\"user_create\":1598,\"username_create\":\"MASTER\",\"created_at\":\"2021-12-02 21:12:20\",\"user_update\":1598,\"username_update\":\"MASTER\",\"updated_at\":\"2021-12-03 05:43:02\"}', '2021-12-02 22:43:02', '2020-11-16 04:06:27'),
(33, 'WC', '{\"data\":\"1,2,3,4,5,6,7,8,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27\",\"user_create\":1598,\"username_create\":\"MASTER\",\"created_at\":\"2021-12-02 21:13:38\",\"user_update\":1598,\"username_update\":\"MASTER\",\"updated_at\":\"2021-12-03 05:43:10\"}', '2021-12-02 22:43:10', '2020-11-16 04:06:27'),
(35, 'TLK', '{\"data\":\"1,2,3,4,5,6\",\"user_create\":1598,\"username_create\":\"MASTER\",\"created_at\":\"2021-12-02 21:12:43\",\"user_update\":1598,\"username_update\":\"MASTER\",\"updated_at\":\"2021-12-03 05:43:07\"}', '2021-12-02 22:43:07', '2020-11-16 04:06:27'),
(36, 'GRD', '{\"data\":\"1\",\"user_create\":1598,\"username_create\":\"MASTER\",\"created_at\":\"2021-12-02 21:04:37\",\"user_update\":1598,\"username_update\":\"MASTER\",\"updated_at\":\"2021-12-03 05:42:20\"}', '2021-12-02 22:42:20', '2020-12-23 18:01:06'),
(37, 'M-2', '{\"data\":null,\"user_create\":1598,\"username_create\":\"MASTER\",\"created_at\":\"2021-12-03 05:42:47\",\"user_update\":1598,\"username_update\":\"MASTER\",\"updated_at\":\"2021-12-03 05:42:47\"}', '2021-12-02 22:42:47', '2021-04-22 06:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `faktur` varchar(20) DEFAULT NULL,
  `id_period` int(11) DEFAULT NULL,
  `kd_kontrol` varchar(20) DEFAULT NULL,
  `nicename` varchar(20) DEFAULT NULL,
  `pengguna` varchar(255) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `ids_tagihan` text DEFAULT NULL,
  `tagihan` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `cetak` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`id`, `code`, `faktur`, `id_period`, `kd_kontrol`, `nicename`, `pengguna`, `info`, `ids_tagihan`, `tagihan`, `active`, `cetak`, `updated_at`, `created_at`) VALUES
(5, 'PKSQZCLMXF', '0010/2022/01/03', 2, 'A-1-001', 'A1001', 'Master Didi Kempot', NULL, '1,2', 1052939, 1, 0, '2022-01-03 16:38:53', '2022-01-02 16:29:19'),
(8, 'WSANDUHYLW', '0013/2022/01/03', 2, 'A-1-001', 'A1001', 'Master Didi Kempot', NULL, '2', 102000, 1, 0, '2022-01-03 15:43:16', '2022-01-03 15:43:16');

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
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `kd_kontrol` varchar(20) DEFAULT NULL,
  `nicename` varchar(20) DEFAULT NULL,
  `pengguna` varchar(255) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `ids_tagihan` text DEFAULT NULL,
  `tagihan` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `nicename` varchar(20) DEFAULT NULL,
  `new_period` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `faktur` int(11) NOT NULL DEFAULT 0,
  `surat` int(11) NOT NULL DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`id`, `name`, `nicename`, `new_period`, `due_date`, `year`, `faktur`, `surat`, `updated_at`, `created_at`) VALUES
(1, '2021-12', 'Desember 2021', '2021-12-23', '2021-12-15', '2021', 0, 0, '2022-01-01 12:00:35', '2022-01-01 12:00:35'),
(2, '2022-01', 'Januari 2022', '2022-01-23', '2022-01-15', '2022', 13, 0, '2022-01-03 15:43:16', '2022-01-03 11:17:18');

-- --------------------------------------------------------

--
-- Table structure for table `p_airbersih`
--

CREATE TABLE `p_airbersih` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_airbersih`
--

INSERT INTO `p_airbersih` (`id`, `name`, `data`, `updated_at`, `created_at`) VALUES
(1, 'Tarif 1', '{\"tarif1\":\"7000\",\"tarif2\":\"8500\",\"pemeliharaan\":\"15000\",\"beban\":\"25000\",\"airkotor\":\"30\",\"denda\":\"50000\",\"ppn\":\"10\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:49:11\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:49:11\"}', '2021-12-27 07:49:11', '2021-12-27 07:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `p_airkotor`
--

CREATE TABLE `p_airkotor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_airkotor`
--

INSERT INTO `p_airkotor` (`id`, `name`, `price`, `data`, `updated_at`, `created_at`) VALUES
(1, 'Tarif 1', 250000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:55:35\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:55:35\"}', '2021-12-27 07:55:35', '2021-12-27 07:55:35'),
(2, 'Tarif 2', 3000000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:55:44\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:55:44\"}', '2021-12-27 07:55:44', '2021-12-27 07:55:44');

-- --------------------------------------------------------

--
-- Table structure for table `p_keamananipk`
--

CREATE TABLE `p_keamananipk` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_keamananipk`
--

INSERT INTO `p_keamananipk` (`id`, `name`, `price`, `data`, `updated_at`, `created_at`) VALUES
(1, 'Tarif 1', 120000, '{\"keamanan\":\"67\",\"ipk\":\"33\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:49:41\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:49:41\"}', '2021-12-27 07:49:41', '2021-12-27 07:49:41'),
(2, 'Tarif 2', 130000, '{\"keamanan\":\"85\",\"ipk\":\"15\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:49:53\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:49:53\"}', '2021-12-27 07:49:53', '2021-12-27 07:49:53'),
(3, 'Tarif 3', 145000, '{\"keamanan\":\"74\",\"ipk\":\"26\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:50:10\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:50:10\"}', '2021-12-27 07:50:10', '2021-12-27 07:50:10'),
(4, 'Tarif 4', 165000, '{\"keamanan\":\"55\",\"ipk\":\"45\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:50:31\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:50:31\"}', '2021-12-27 07:50:31', '2021-12-27 07:50:31'),
(5, 'Tarif 5', 200000, '{\"keamanan\":\"73\",\"ipk\":\"27\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:50:55\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:50:55\"}', '2021-12-27 07:50:55', '2021-12-27 07:50:55'),
(6, 'Tarif 6', 500000, '{\"keamanan\":\"55\",\"ipk\":\"45\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:51:11\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:51:11\"}', '2021-12-27 07:51:11', '2021-12-27 07:51:11'),
(7, 'Tarif 7', 265000, '{\"keamanan\":\"55\",\"ipk\":\"45\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:51:31\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:51:31\"}', '2021-12-27 07:51:31', '2021-12-27 07:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `p_kebersihan`
--

CREATE TABLE `p_kebersihan` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_kebersihan`
--

INSERT INTO `p_kebersihan` (`id`, `name`, `price`, `data`, `updated_at`, `created_at`) VALUES
(1, 'Tarif 1', 120000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:53:11\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:53:11\"}', '2021-12-27 07:53:11', '2021-12-27 07:53:11'),
(2, 'Tarif 2', 130000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:53:26\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:53:26\"}', '2021-12-27 07:53:26', '2021-12-27 07:53:26'),
(3, 'Tarif 3', 140000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:53:36\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:53:36\"}', '2021-12-27 07:53:36', '2021-12-27 07:53:36'),
(4, 'Tarif 4', 150000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:53:44\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:53:44\"}', '2021-12-27 07:53:44', '2021-12-27 07:53:44'),
(5, 'Tarif 5', 155000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:53:52\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:53:52\"}', '2021-12-27 07:53:52', '2021-12-27 07:53:52'),
(6, 'Tarif 6', 156000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:54:04\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:54:04\"}', '2021-12-27 07:54:04', '2021-12-27 07:54:04'),
(7, 'Tarif 7', 195000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:54:22\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:54:22\"}', '2021-12-27 07:54:22', '2021-12-27 07:54:22'),
(8, 'Tarif 8', 235000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:54:43\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:54:43\"}', '2021-12-27 07:54:43', '2021-12-27 07:54:43'),
(9, 'Tarif 9', 780000, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:54:58\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:54:58\"}', '2021-12-27 07:54:58', '2021-12-27 07:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `p_lain`
--

CREATE TABLE `p_lain` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `satuan` tinyint(1) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_lain`
--

INSERT INTO `p_lain` (`id`, `name`, `price`, `satuan`, `data`, `updated_at`, `created_at`) VALUES
(1, 'Preman', 100000, 1, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 15:01:26\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 15:01:26\"}', '2021-12-27 08:01:26', '2021-12-27 08:01:26'),
(2, 'Parkir', 2000, 2, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 15:01:39\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 15:01:39\"}', '2021-12-27 08:01:39', '2021-12-27 08:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `p_listrik`
--

CREATE TABLE `p_listrik` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `p_listrik`
--

INSERT INTO `p_listrik` (`id`, `name`, `data`, `updated_at`, `created_at`) VALUES
(1, 'Tarif 1', '{\"beban\":\"50\",\"blok1\":\"0\",\"blok2\":\"2404\",\"standar\":\"0\",\"pju\":\"18\",\"denda1\":\"50000\",\"denda2\":\"3\",\"ppn\":\"10\",\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 14:48:32\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 14:48:32\"}', '2021-12-27 07:48:32', '2021-12-27 07:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) NOT NULL,
  `kd_kontrol` varchar(20) DEFAULT NULL,
  `nicename` varchar(20) DEFAULT NULL,
  `group` varchar(10) DEFAULT NULL,
  `no_los` text DEFAULT NULL,
  `jml_los` tinyint(4) DEFAULT NULL,
  `id_pengguna` bigint(20) DEFAULT NULL,
  `id_pemilik` bigint(20) DEFAULT NULL,
  `komoditi` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `info` text DEFAULT NULL,
  `id_tlistrik` int(11) DEFAULT NULL,
  `id_tairbersih` int(11) DEFAULT NULL,
  `fas_listrik` int(11) DEFAULT NULL,
  `fas_airbersih` int(11) DEFAULT NULL,
  `fas_keamananipk` int(11) DEFAULT NULL,
  `fas_kebersihan` int(11) DEFAULT NULL,
  `fas_airkotor` int(11) DEFAULT NULL,
  `fas_lain` text DEFAULT NULL,
  `data` mediumtext DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `kd_kontrol`, `nicename`, `group`, `no_los`, `jml_los`, `id_pengguna`, `id_pemilik`, `komoditi`, `status`, `ket`, `info`, `id_tlistrik`, `id_tairbersih`, `fas_listrik`, `fas_airbersih`, `fas_keamananipk`, `fas_kebersihan`, `fas_airkotor`, `fas_lain`, `data`, `updated_at`, `created_at`) VALUES
(2, 'A-1-001', 'A1001', 'A-1', '1', 1, 1598, 1598, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"diskon\":[],\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-28 14:22:04\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-31 17:17:13\"}', '2021-12-31 10:17:13', '2021-12-28 07:22:04'),
(3, 'A-1-002', 'A1002', 'A-1', '2', 1, 1598, 1598, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"diskon\":[],\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-28 14:22:21\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-28 14:22:21\"}', '2021-12-28 07:22:21', '2021-12-28 07:22:21'),
(4, 'A-1-003', 'A1003', 'A-1', '3,3A', 2, 1598, 1598, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"diskon\":[],\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-28 14:22:41\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-28 14:22:41\"}', '2021-12-28 07:22:41', '2021-12-28 07:22:41'),
(5, 'A-1-005', 'A1005', 'A-1', '5', 1, 1598, 1598, NULL, 1, NULL, 'Depan Toko', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"diskon\":[],\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-28 14:22:59\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-28 14:42:53\"}', '2021-12-28 07:42:53', '2021-12-28 07:22:59'),
(7, 'A-1-015', 'A1015', 'A-1', '15', 1, NULL, NULL, NULL, 1, NULL, 'hjhjhhjh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"diskon\":[],\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-31 17:37:49\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-31 17:37:49\"}', '2021-12-31 10:37:49', '2021-12-31 10:37:49');

-- --------------------------------------------------------

--
-- Table structure for table `t_airbersih`
--

CREATE TABLE `t_airbersih` (
  `id` int(11) NOT NULL,
  `code` varchar(8) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `meter` int(11) DEFAULT NULL,
  `stt_available` tinyint(1) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_airbersih`
--

INSERT INTO `t_airbersih` (`id`, `code`, `name`, `meter`, `stt_available`, `data`, `updated_at`, `created_at`) VALUES
(1, 'MA48718', 'AER', 21, 1, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 15:02:45\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 15:02:45\"}', '2021-12-27 09:00:39', '2021-12-27 08:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `t_listrik`
--

CREATE TABLE `t_listrik` (
  `id` int(11) NOT NULL,
  `code` varchar(8) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `meter` int(11) DEFAULT NULL,
  `power` int(11) DEFAULT NULL,
  `stt_available` tinyint(1) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_listrik`
--

INSERT INTO `t_listrik` (`id`, `code`, `name`, `meter`, `power`, `stt_available`, `data`, `updated_at`, `created_at`) VALUES
(1, 'ML69981', 'LISTRE', 9899, 10500, 1, '{\"created_by_id\":1598,\"created_by_name\":\"Master Didi Kempot\",\"created_at\":\"2021-12-27 15:02:21\",\"updated_by_id\":1598,\"updated_by_name\":\"Master Didi Kempot\",\"updated_at\":\"2021-12-27 15:02:21\"}', '2021-12-27 08:57:07', '2021-12-27 08:02:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'storage/users/user.jpg',
  `level` tinyint(1) NOT NULL DEFAULT 3,
  `country_id` smallint(6) DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `member` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ktp` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authority` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nonactive` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_code` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `uid`, `photo`, `level`, `country_id`, `phone`, `email`, `email_verified_at`, `member`, `ktp`, `npwp`, `address`, `authority`, `active`, `password`, `remember_token`, `nonactive`, `activation_code`, `available`, `created_at`, `updated_at`) VALUES
(1598, 'Master Didi Kempot', 'super_admin', 'storage/users/1598.png', 1, 100, '895337845511', 'levindsein@gmail.com', '2021-12-10 20:44:18', 'BP3C11111111', '1111111111111111', NULL, 'Dibawah langit berpijak pada bumi', NULL, 1, '$argon2id$v=19$m=1024,t=2,p=2$WTE0UHoyU0pGYlpIWDVOQQ$NY7eX/314e3aQ0go2uo27M2pvtPsRnuAbdp8yznkA1s', NULL, NULL, NULL, '2021-12-12 20:43:52', '2021-12-10 20:43:52', '2021-12-28 16:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) NOT NULL,
  `visit_per_day` int(11) DEFAULT NULL,
  `day_count` int(11) DEFAULT NULL,
  `visit_on_day` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `visit_per_day`, `day_count`, `visit_on_day`, `updated_at`, `created_at`) VALUES
(1, 0, 0, 35, '2022-01-03 11:16:56', '2021-12-27 08:00:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activation_code`
--
ALTER TABLE `activation_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`code`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `fk_period` (`id_period`);

--
-- Indexes for table `change_logs`
--
ALTER TABLE `change_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commodities`
--
ALTER TABLE `commodities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `iso` (`iso`),
  ADD UNIQUE KEY `iso3` (`iso3`);

--
-- Indexes for table `data_login`
--
ALTER TABLE `data_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `day_off`
--
ALTER TABLE `day_off`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_period1` (`id_period`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `p_airbersih`
--
ALTER TABLE `p_airbersih`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `p_airkotor`
--
ALTER TABLE `p_airkotor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `p_keamananipk`
--
ALTER TABLE `p_keamananipk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `p_kebersihan`
--
ALTER TABLE `p_kebersihan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `p_lain`
--
ALTER TABLE `p_lain`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `p_listrik`
--
ALTER TABLE `p_listrik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kd_kontrol` (`kd_kontrol`),
  ADD KEY `fk_pengguna` (`id_pengguna`),
  ADD KEY `fk_pemilik` (`id_pemilik`),
  ADD KEY `fk_tlistrik` (`id_tlistrik`),
  ADD KEY `fk_tairbersih` (`id_tairbersih`),
  ADD KEY `fk_plistrik` (`fas_listrik`),
  ADD KEY `fk_pairbersih` (`fas_airbersih`),
  ADD KEY `fk_pkeamananipk` (`fas_keamananipk`),
  ADD KEY `fk_pkebersihan` (`fas_kebersihan`),
  ADD KEY `fk_pairkotor` (`fas_airkotor`);

--
-- Indexes for table `t_airbersih`
--
ALTER TABLE `t_airbersih`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `t_listrik`
--
ALTER TABLE `t_listrik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`uid`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `telephone` (`phone`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `member` (`member`),
  ADD UNIQUE KEY `ktp` (`ktp`),
  ADD UNIQUE KEY `npwp` (`npwp`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activation_code`
--
ALTER TABLE `activation_code`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `change_logs`
--
ALTER TABLE `change_logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `commodities`
--
ALTER TABLE `commodities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `data_login`
--
ALTER TABLE `data_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `day_off`
--
ALTER TABLE `day_off`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `period`
--
ALTER TABLE `period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `p_airbersih`
--
ALTER TABLE `p_airbersih`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `p_airkotor`
--
ALTER TABLE `p_airkotor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `p_keamananipk`
--
ALTER TABLE `p_keamananipk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `p_kebersihan`
--
ALTER TABLE `p_kebersihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `p_lain`
--
ALTER TABLE `p_lain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `p_listrik`
--
ALTER TABLE `p_listrik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `t_airbersih`
--
ALTER TABLE `t_airbersih`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_listrik`
--
ALTER TABLE `t_listrik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1602;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `fk_period` FOREIGN KEY (`id_period`) REFERENCES `period` (`id`);

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `fk_period1` FOREIGN KEY (`id_period`) REFERENCES `period` (`id`);

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `fk_pairbersih` FOREIGN KEY (`fas_airbersih`) REFERENCES `p_airbersih` (`id`),
  ADD CONSTRAINT `fk_pairkotor` FOREIGN KEY (`fas_airkotor`) REFERENCES `p_airkotor` (`id`),
  ADD CONSTRAINT `fk_pemilik` FOREIGN KEY (`id_pemilik`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_pkeamananipk` FOREIGN KEY (`fas_keamananipk`) REFERENCES `p_keamananipk` (`id`),
  ADD CONSTRAINT `fk_pkebersihan` FOREIGN KEY (`fas_kebersihan`) REFERENCES `p_kebersihan` (`id`),
  ADD CONSTRAINT `fk_plistrik` FOREIGN KEY (`fas_listrik`) REFERENCES `p_listrik` (`id`),
  ADD CONSTRAINT `fk_tairbersih` FOREIGN KEY (`id_tairbersih`) REFERENCES `t_airbersih` (`id`),
  ADD CONSTRAINT `fk_tlistrik` FOREIGN KEY (`id_tlistrik`) REFERENCES `t_listrik` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
