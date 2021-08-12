-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 05 Agu 2021 pada 02.51
-- Versi server: 8.0.22
-- Versi PHP: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rml`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `annual_leaves`
--

CREATE TABLE `annual_leaves` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `poh_id` int UNSIGNED NOT NULL,
  `day_of_id` bigint UNSIGNED NOT NULL,
  `year` year NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `sum` int DEFAULT NULL,
  `standart` int DEFAULT NULL,
  `should` int DEFAULT NULL,
  `less` int DEFAULT NULL,
  `less_before` int DEFAULT NULL,
  `approv` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `revision` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `annual_leave_counters`
--

CREATE TABLE `annual_leave_counters` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `year` year NOT NULL,
  `day` int DEFAULT NULL,
  `standart` int DEFAULT NULL,
  `should` int DEFAULT NULL,
  `less` int DEFAULT NULL,
  `less_before` int DEFAULT NULL,
  `first_date` date NOT NULL,
  `last_date` date NOT NULL,
  `revision` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `approval_records`
--

CREATE TABLE `approval_records` (
  `id` bigint UNSIGNED NOT NULL,
  `doc` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `reason` tinytext COLLATE utf8mb4_unicode_ci,
  `level` enum('1','2','3','4','5','6') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `type` enum('cuti','izin','dinas','training') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cuti',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignments`
--

CREATE TABLE `assignments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `in_date` date NOT NULL,
  `sum_day` int NOT NULL,
  `ticket_date_from_go` date DEFAULT NULL,
  `ticket_date_from_back` date DEFAULT NULL,
  `ticket_time_from_go` time DEFAULT NULL,
  `ticket_time_from_back` time DEFAULT NULL,
  `travel_date_from_go` date DEFAULT NULL,
  `travel_date_from_back` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` enum('inSite','inRegional','outRegional') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lodging_cost` double(13,2) DEFAULT NULL,
  `transportation_cost` double(13,2) DEFAULT NULL,
  `meal_cost` double(13,2) DEFAULT NULL,
  `other_cost` double(13,2) DEFAULT NULL,
  `lodging_day` int DEFAULT NULL,
  `transportation_day` int DEFAULT NULL,
  `meal_day` int DEFAULT NULL,
  `other_day` int DEFAULT NULL,
  `head_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sm_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hrd_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `approv` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignment_destinations`
--

CREATE TABLE `assignment_destinations` (
  `id` bigint UNSIGNED NOT NULL,
  `assignment_id` bigint UNSIGNED NOT NULL,
  `from_id` int UNSIGNED NOT NULL,
  `to_id` int UNSIGNED NOT NULL,
  `type` enum('Go','Back') COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination` enum('Ticket','Travel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `big_leaves`
--

CREATE TABLE `big_leaves` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `poh_id` int UNSIGNED NOT NULL,
  `day_of_id` bigint UNSIGNED DEFAULT NULL,
  `year` year NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `sum` int DEFAULT NULL,
  `standart` int DEFAULT NULL,
  `should` int DEFAULT NULL,
  `less` int DEFAULT NULL,
  `less_before` int DEFAULT NULL,
  `description` tinytext COLLATE utf8mb4_unicode_ci,
  `approv` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `take` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `revision` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `big_leave_claims`
--

CREATE TABLE `big_leave_claims` (
  `id` bigint UNSIGNED NOT NULL,
  `big_leave_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year NOT NULL,
  `idr` double(13,2) DEFAULT NULL,
  `multiplier_salary` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `hrd_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sm_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `paid` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `big_leave_counters`
--

CREATE TABLE `big_leave_counters` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `year` year NOT NULL,
  `day` int DEFAULT NULL,
  `standart` int DEFAULT NULL,
  `should` int DEFAULT NULL,
  `less` int DEFAULT NULL,
  `less_before` int DEFAULT NULL,
  `first_date` date NOT NULL,
  `last_date` date NOT NULL,
  `revision` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `day_ofs`
--

CREATE TABLE `day_ofs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `poh_id` int UNSIGNED NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `in` date NOT NULL,
  `in_before` date NOT NULL,
  `work_day` int NOT NULL,
  `annual_leave_start` date DEFAULT NULL,
  `annual_leave_end` date DEFAULT NULL,
  `annual_leave` int DEFAULT NULL,
  `big_leave_start` date DEFAULT NULL,
  `big_leave_end` date DEFAULT NULL,
  `big_leave` int DEFAULT NULL,
  `day_of_sum` int NOT NULL,
  `day_of_total` int NOT NULL,
  `day_of_grandtotal` int NOT NULL,
  `day_of_standart` int DEFAULT NULL,
  `day_of_should` int DEFAULT NULL,
  `day_of_less` int DEFAULT NULL,
  `annual_leave_standart` int DEFAULT NULL,
  `annual_leave_should` int DEFAULT NULL,
  `annual_leave_less` int DEFAULT NULL,
  `big_leave_standart` int DEFAULT NULL,
  `big_leave_should` int DEFAULT NULL,
  `big_leave_less` int DEFAULT NULL,
  `travel_from_go` date DEFAULT NULL,
  `travel_to_go` date DEFAULT NULL,
  `travel_from_back` date DEFAULT NULL,
  `travel_to_back` date DEFAULT NULL,
  `ticket_from_go` date DEFAULT NULL,
  `ticket_from_back` date DEFAULT NULL,
  `ticket_time_go` time DEFAULT NULL,
  `ticket_time_back` time DEFAULT NULL,
  `travel_day` int DEFAULT NULL,
  `ticket_day` int DEFAULT NULL,
  `travel_day_go` int DEFAULT NULL,
  `travel_day_back` int DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `lumpsum` double(13,2) NOT NULL,
  `head_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sm_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hrd_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `approv` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `update_count` int DEFAULT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `day_of_destinations`
--

CREATE TABLE `day_of_destinations` (
  `id` bigint UNSIGNED NOT NULL,
  `day_of_id` bigint UNSIGNED NOT NULL,
  `from_id` int UNSIGNED NOT NULL,
  `to_id` int UNSIGNED NOT NULL,
  `type` enum('Go','Back') COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination` enum('Ticket','Travel') COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `day_of_periods`
--

CREATE TABLE `day_of_periods` (
  `id` int UNSIGNED NOT NULL,
  `staff` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `day` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `day_of_periods`
--

INSERT INTO `day_of_periods` (`id`, `staff`, `day`, `created_at`, `updated_at`) VALUES
(1, '1', 60, '2021-07-10 01:31:17', '2021-07-14 05:15:33'),
(2, '0', 90, '2021-07-10 01:31:17', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `departments`
--

CREATE TABLE `departments` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `departments`
--

INSERT INTO `departments` (`id`, `code`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'HR', 'Human Resource', '1', '2021-08-01 08:36:54', NULL),
(2, 'FA', 'Finance & Accounting', '1', '2021-07-09 14:57:30', '2021-07-09 14:57:30'),
(3, 'OPR', 'Operational', '1', '2021-07-09 14:57:44', '2021-07-09 14:57:44'),
(4, 'PRD', 'Production', '1', '2021-07-09 14:58:17', '2021-07-09 14:58:17'),
(5, 'MM', 'Material Management', '1', '2021-07-09 14:58:26', '2021-07-09 14:58:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `destinations`
--

CREATE TABLE `destinations` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(2, 'Balikpapan', '1', '2021-07-09 14:55:09', '2021-07-09 14:55:09'),
(3, 'Bontang', '1', '2021-07-09 14:55:15', '2021-07-09 14:55:15'),
(4, 'Sanggata', '1', '2021-07-09 14:55:25', '2021-07-09 14:55:25'),
(5, 'Tarakan', '1', '2021-07-09 14:55:29', '2021-07-09 14:55:29'),
(6, 'Bulungan', '1', '2021-07-09 14:55:34', '2021-07-09 14:55:34'),
(7, 'Tenggarong', '1', '2021-07-09 14:55:44', '2021-07-09 14:55:44'),
(8, 'Banjarmasin', '1', '2021-07-09 14:55:49', '2021-07-09 14:55:49'),
(9, 'Palangkaraya', '1', '2021-07-09 14:56:00', '2021-07-09 14:56:00'),
(10, 'Pontianak', '1', '2021-07-09 14:56:04', '2021-07-09 14:56:14'),
(11, 'Surabaya', '1', '2021-07-09 14:56:25', '2021-07-09 14:56:32'),
(12, 'Jakarta', '1', '2021-07-09 14:56:37', '2021-07-09 14:56:37'),
(13, 'Batu Kajang', '1', '2021-07-09 15:25:43', '2021-07-09 15:25:43'),
(14, 'Melak', '1', '2021-07-14 03:15:17', '2021-07-14 03:15:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lumpsums`
--

CREATE TABLE `lumpsums` (
  `id` int UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `poh_id` int UNSIGNED NOT NULL,
  `position_id` int UNSIGNED NOT NULL,
  `idr` double(13,2) NOT NULL,
  `idr_staff` double(13,2) NOT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2021_06_20_105441_create_sites_table', 1),
(3, '2021_06_20_105803_create_pohs_table', 1),
(4, '2021_06_20_110011_create_departments_table', 1),
(5, '2021_06_20_110025_create_positions_table', 1),
(6, '2021_06_20_110026_create_poh_day_ofs_table', 1),
(7, '2021_06_20_110027_create_poh_annual_leaves_table', 1),
(8, '2021_06_20_110028_create_poh_big_leaves_table', 1),
(9, '2021_06_20_110121_create_lumpsums_table', 1),
(10, '2021_06_20_110143_create_users_table', 1),
(11, '2021_06_20_110144_create_day_of_periods_table', 1),
(12, '2021_06_20_110144_create_destinations_table', 1),
(13, '2021_06_20_110144_create_password_resets_table', 1),
(14, '2021_06_20_110146_create_permission_categories_table', 1),
(15, '2021_06_21_022512_create_day_ofs_table', 1),
(16, '2021_06_21_022513_create_annual_leaves_table', 1),
(17, '2021_06_21_022514_create_big_leaves_table', 1),
(18, '2021_06_21_022515_create_approval_records_table', 1),
(19, '2021_07_09_122244_create_day_of_destinations_table', 1),
(20, '2021_07_19_231953_create_big_leave_claims_table', 1),
(21, '2021_07_20_053746_create_annual_leave_counters_table', 1),
(22, '2021_07_20_053810_create_big_leave_counters_table', 1),
(23, '2021_07_25_014906_create_permissions_table', 1),
(24, '2021_07_27_023841_create_permission_debts_table', 1),
(25, '2021_07_29_233403_create_assignments_table', 1),
(26, '2021_07_30_000155_create_assignment_destinations_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `permission_category_id` int UNSIGNED NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `in_date` date NOT NULL,
  `sum_day` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `head_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sm_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hrd_approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `approv` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permission_categories`
--

CREATE TABLE `permission_categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` int DEFAULT NULL,
  `official` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `type` enum('Official','CutAnnualLeave','CutBasicSalary') COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permission_categories`
--

INSERT INTO `permission_categories` (`id`, `name`, `day`, `official`, `type`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Pernikahan Pekerja', 3, '1', 'Official', '1', '2021-07-26 14:17:29', '2021-07-26 14:17:29'),
(2, 'Istri pekerjaan melahirkan / keguguran', 2, '1', 'Official', '1', '2021-07-26 14:17:54', '2021-07-26 14:17:54'),
(3, 'Potong Cuti Tahunan', 0, '0', 'CutAnnualLeave', '1', '2021-07-26 14:18:07', '2021-07-26 14:18:07'),
(4, 'Potong Gaji Pokok', 0, '0', 'CutBasicSalary', '1', '2021-07-26 14:18:18', '2021-07-26 14:18:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permission_debts`
--

CREATE TABLE `permission_debts` (
  `id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `year` year NOT NULL,
  `date` date NOT NULL,
  `sum_day` int NOT NULL,
  `less_day` int NOT NULL,
  `for` enum('DayOf','AnnualLeave','BigLeave','BasicSalary') COLLATE utf8mb4_unicode_ci NOT NULL,
  `approv` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pohs`
--

CREATE TABLE `pohs` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pohs`
--

INSERT INTO `pohs` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Samarinda', '1', '2021-08-01 08:36:54', NULL),
(2, 'Balikpapan', '1', '2021-07-09 14:35:57', '2021-07-09 14:35:57'),
(3, 'Melak', '1', '2021-07-09 14:36:02', '2021-07-09 14:36:02'),
(4, 'Bontang', '1', '2021-07-09 14:36:08', '2021-07-09 14:36:08'),
(5, 'Sanggata', '1', '2021-07-09 14:36:13', '2021-07-09 14:36:13'),
(6, 'Tarakan', '1', '2021-07-09 14:36:18', '2021-07-09 14:36:18'),
(7, 'Bulungan', '1', '2021-07-09 14:36:30', '2021-07-09 14:36:30'),
(8, 'Tenggarong', '1', '2021-07-09 14:36:35', '2021-07-09 14:36:35'),
(9, 'Banjarmasin', '1', '2021-07-09 14:36:53', '2021-07-09 14:36:53'),
(10, 'Palangkaraya', '1', '2021-07-09 14:37:13', '2021-07-09 14:37:13'),
(11, 'Pontianak', '1', '2021-07-09 14:37:24', '2021-07-09 14:37:24'),
(12, 'Surabaya', '1', '2021-07-09 14:37:29', '2021-07-09 14:37:29'),
(13, 'Jakarta', '1', '2021-07-09 14:37:34', '2021-07-09 14:37:34'),
(14, 'Batu Kajang', '1', '2021-07-09 15:25:32', '2021-07-09 15:25:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `poh_annual_leaves`
--

CREATE TABLE `poh_annual_leaves` (
  `id` int UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `poh_id` int UNSIGNED NOT NULL,
  `day_of` int NOT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `poh_annual_leaves`
--

INSERT INTO `poh_annual_leaves` (`id`, `site_id`, `poh_id`, `day_of`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 12, '1', '2021-07-17 01:02:35', '2021-07-17 01:09:55'),
(2, 1, 9, 12, '1', '2021-07-17 01:10:40', '2021-07-17 01:10:52'),
(3, 2, 13, 12, '1', '2021-07-17 01:21:10', '2021-07-17 01:21:10'),
(4, 2, 9, 12, '1', '2021-08-03 22:07:17', '2021-08-03 22:11:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `poh_big_leaves`
--

CREATE TABLE `poh_big_leaves` (
  `id` int UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `poh_id` int UNSIGNED NOT NULL,
  `day_of` int NOT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `poh_big_leaves`
--

INSERT INTO `poh_big_leaves` (`id`, `site_id`, `poh_id`, `day_of`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 25, '1', '2021-07-17 01:12:12', '2021-07-17 01:15:34'),
(2, 1, 9, 40, '1', '2021-07-17 01:14:12', '2021-07-20 09:40:24'),
(3, 2, 13, 25, '1', '2021-07-17 06:44:21', '2021-07-17 06:44:21'),
(4, 2, 9, 25, '1', '2021-08-03 22:16:45', '2021-08-03 22:16:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `poh_day_ofs`
--

CREATE TABLE `poh_day_ofs` (
  `id` int UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `poh_id` int UNSIGNED NOT NULL,
  `day_of` int DEFAULT NULL,
  `travel_day` int DEFAULT NULL,
  `travel_day_ticket` int DEFAULT NULL,
  `ticket_facilities` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `travel_day_facilities` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `lumpsum_facilities` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `poh_day_ofs`
--

INSERT INTO `poh_day_ofs` (`id`, `site_id`, `poh_id`, `day_of`, `travel_day`, `travel_day_ticket`, `ticket_facilities`, `travel_day_facilities`, `lumpsum_facilities`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 14, 2, 2, '1', '1', '1', '1', '2017-12-30 16:00:00', '2021-07-22 03:06:01'),
(2, 1, 9, 14, 1, 1, '1', '1', '1', '1', '2017-12-30 16:00:00', '2021-07-12 15:16:03'),
(3, 1, 3, 14, 0, 0, '0', '0', '0', '1', '2017-12-30 16:00:00', '2021-07-12 15:16:22'),
(4, 1, 14, 14, 1, 1, '1', '1', '0', '1', '2017-12-30 16:00:00', '2021-07-12 15:15:45'),
(5, 2, 13, 14, 2, 2, '1', '1', '1', '1', '2017-12-30 16:00:00', '2021-07-22 02:47:27'),
(6, 2, 9, 14, 1, 1, '1', '1', '1', '1', '2017-12-30 16:00:00', '2021-07-12 15:15:18'),
(7, 2, 3, 14, 1, 1, '1', '1', '1', '1', '2017-12-30 16:00:00', '2021-07-12 15:15:24'),
(8, 2, 14, 14, 0, 0, '0', '0', '0', '1', '2017-12-30 16:00:00', '2021-07-14 05:45:52'),
(9, 1, 10, 14, 2, 2, '0', '0', '1', '1', '2021-07-12 14:49:35', '2021-07-26 10:22:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `positions`
--

CREATE TABLE `positions` (
  `id` int UNSIGNED NOT NULL,
  `department_id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `positions`
--

INSERT INTO `positions` (`id`, `department_id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 'HR Staff', '1', '2021-08-01 08:36:54', NULL),
(2, 1, 'HR Manager', '1', '2021-07-09 14:58:53', '2021-07-09 14:58:53'),
(3, 2, 'FA Manager', '1', '2021-07-09 14:59:02', '2021-07-09 14:59:02'),
(4, 5, 'MM Manager', '1', '2021-07-09 14:59:11', '2021-07-09 15:00:10'),
(5, 3, 'Site Manager', '1', '2021-07-09 15:00:26', '2021-07-09 15:00:26'),
(6, 4, 'Production Manager', '1', '2021-07-09 15:00:47', '2021-07-09 15:00:47'),
(7, 2, 'FA Staff', '1', '2021-07-09 15:01:23', '2021-07-09 15:01:23'),
(8, 5, 'Storeman', '1', '2021-07-09 15:01:39', '2021-07-09 15:01:39'),
(9, 4, 'Operator', '1', '2021-07-09 15:02:06', '2021-07-09 15:02:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sites`
--

CREATE TABLE `sites` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sites`
--

INSERT INTO `sites` (`id`, `code`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'TCM', 'PT Turbaindo Coal Mining', '1', '2021-08-01 08:36:54', NULL),
(2, 'KDC', 'PT Kideco Jaya Agung', '1', '2021-07-27 07:44:42', '2021-07-27 07:44:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `site_id` int UNSIGNED NOT NULL,
  `poh_id` int UNSIGNED NOT NULL,
  `position_id` int UNSIGNED NOT NULL,
  `nrp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ktp` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place_of_birth` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `join_date` date NOT NULL,
  `religion` enum('Katolik','Protestan','Islam','Hindu','Buddha','Khonghucu') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Katolik',
  `blood_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `employee` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `home_facilities` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `lumpsum` double(13,2) NOT NULL,
  `lumpsum_status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `level` enum('administrator','hrd_admin','hrd_head','site_manager','department_head','employee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employee',
  `hr_head` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `site_id`, `poh_id`, `position_id`, `nrp`, `ktp`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `place_of_birth`, `date_of_birth`, `join_date`, `religion`, `blood_type`, `address`, `phone`, `staff`, `employee`, `home_facilities`, `lumpsum`, `lumpsum_status`, `level`, `hr_head`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, '111111', '1111111111111111', 'Administrator', 'administrator@email.com', NULL, '$2y$10$CksO17FzGehU3jAzDm3iDOLKfzjdRF/wTuyluKhXh8VzgfkiJOvFK', NULL, NULL, NULL, '2021-01-01', 'Katolik', NULL, NULL, '081258297255', '1', '0', '0', 0.00, '0', 'administrator', '0', '1', '2021-08-01 08:36:54', NULL, NULL),
(2, 1, 13, 5, '100001', '1122332212343431', 'Glen Ngantung', NULL, NULL, '$2y$10$A2IsIwsqcol9ViNpo38vAukOtt8hrJyqFMcho.gnZFWRdeQGHBjey', NULL, '', '1983-01-02', '2018-01-02', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'site_manager', '0', '1', '2017-12-31 08:00:00', '2021-07-26 01:29:14', NULL),
(3, 2, 13, 5, '100002', '1122332212343432', 'Eli Subarnas', NULL, NULL, '$2y$10$rHdexPlu6GFQsfS22iGUNO04dEEb0isl9y9L9MP6YufwzMa0bshnm', NULL, '', '1983-01-03', '2018-01-03', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'site_manager', '0', '1', '2018-01-01 08:00:00', '2021-07-25 01:53:12', NULL),
(4, 1, 9, 2, '100003', '1122332212343433', 'Frank Hendrik', NULL, NULL, '$2y$10$Y9b.Qf5DQD6DmR8ByZWypOgiI2Pe3w5BPlPZ3uq.tLDqX5xolNUFS', NULL, '', '1983-01-04', '2018-01-04', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'department_head', '1', '1', '2018-01-02 08:00:00', '2021-07-26 01:28:39', NULL),
(5, 1, 13, 3, '100004', '1122332212343434', 'Dhian Sandra', NULL, NULL, '$2y$10$ZwwxD9Bjabzm0.OduHOI0e6SUWddpsB9H.UFKy86dltDhrVDwYoFu', NULL, NULL, '1983-01-05', '2018-01-05', 'Islam', NULL, NULL, NULL, '1', '1', '0', 0.00, '0', 'department_head', '0', '1', '2018-01-03 08:00:00', '2021-07-26 01:25:22', NULL),
(6, 1, 13, 4, '100005', '1122332212343435', 'Irvan Manurung', NULL, NULL, '100005060183', NULL, NULL, '1983-01-06', '2018-01-06', 'Protestan', NULL, NULL, NULL, '1', '1', '0', 0.00, '0', 'department_head', '0', '1', '2018-01-04 08:00:00', NULL, NULL),
(7, 1, 9, 6, '100006', '1122332212343436', 'Roni Setiawan', NULL, NULL, '100006070183', NULL, NULL, '1983-01-07', '2018-01-07', 'Islam', NULL, NULL, NULL, '1', '1', '0', 0.00, '0', 'department_head', '0', '1', '2018-01-05 08:00:00', NULL, NULL),
(8, 1, 9, 1, '100007', '1122332212343437', 'Nanda Sabri', NULL, NULL, '100007080183', NULL, NULL, '1983-01-08', '2018-01-08', 'Islam', NULL, NULL, NULL, '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-06 08:00:00', NULL, NULL),
(9, 1, 9, 7, '100008', '1122332212343438', 'Sugianto', NULL, NULL, '100008090183', NULL, NULL, '1983-01-09', '2018-01-09', 'Islam', NULL, NULL, NULL, '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-07 08:00:00', NULL, NULL),
(10, 1, 9, 8, '100009', '1122332212343439', 'Wiwied', NULL, NULL, '100009100183', NULL, NULL, '1983-01-10', '2018-01-10', 'Islam', NULL, NULL, NULL, '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-08 08:00:00', NULL, NULL),
(11, 1, 13, 9, '100010', '1122332212343440', 'Rizal', NULL, NULL, '100010110183', NULL, NULL, '1983-01-11', '2018-01-11', 'Islam', NULL, NULL, NULL, '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-09 08:00:00', NULL, NULL),
(12, 1, 3, 8, '100011', '1122332212343441', 'Rinto', NULL, NULL, '$2y$10$fy1QCZfSIV4G/Mgxt3E.3OHjrd6ps/VYP1Z9m54d4V.2cK/mgcKH2', NULL, '', '1983-01-12', '2018-01-12', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-10 08:00:00', '2021-07-21 01:25:35', NULL),
(13, 2, 13, 2, '100012', '1122332212343442', 'Budi Handuk', NULL, NULL, '$2y$10$WbrISPUpGI5YhZGBBF6KyejKbZ.Jx1DMM45G9nKNn.6pxkZ.PH63C', NULL, '', '1983-01-13', '2018-01-13', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'department_head', '1', '1', '2018-01-11 08:00:00', '2021-07-25 01:54:23', NULL),
(14, 2, 13, 3, '100013', '1122332212343443', 'Wawan Setiawan', NULL, NULL, '$2y$10$lY9Rzn5vkBojJT49NT4Go./8CvVrg6a.EpSnKSkFO0BAH4TMeeJKm', NULL, '', '1983-01-14', '2018-01-14', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'department_head', '0', '1', '2018-01-12 08:00:00', '2021-07-25 06:55:41', NULL),
(15, 2, 9, 4, '100014', '1122332212343444', 'Arwin', NULL, NULL, '$2y$10$4xNNfbTYDvS58vadk9jsuubqDj0RRuN2f0KpWlC1DQXniXhvSLnbO', NULL, '', '1983-01-15', '2018-01-15', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'department_head', '0', '1', '2018-01-13 08:00:00', '2021-08-03 21:10:10', NULL),
(16, 2, 13, 6, '100015', '1122332212343445', 'Yuda', NULL, NULL, '$2y$10$kiZgWg9Mbm7yACMDUqzqKek26Yi68tZWdzQ79/ujgNj/OM5vYdjIe', NULL, '', '1983-01-16', '2018-01-16', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'department_head', '0', '1', '2018-01-14 08:00:00', '2021-07-24 23:44:42', NULL),
(17, 2, 9, 1, '100016', '1122332212343446', 'Dirman', NULL, NULL, '$2y$10$Ctk6PappbTBO.rSy.XUVF./Qg8HFKfa6yYblCOA13ZhAosrdrDX0m', NULL, '', '1983-01-17', '2018-01-17', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-15 08:00:00', '2021-07-31 16:52:33', NULL),
(18, 2, 9, 7, '100017', '1122332212343447', 'Taufik', NULL, NULL, '$2y$10$20ECffJ8mt5/xW6swSFwiOPpZ2LqRbvL131b7gSOhwK/2KnK8i/0O', NULL, '', '1983-01-18', '2018-01-18', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-16 08:00:00', '2021-07-25 00:58:43', NULL),
(19, 2, 13, 8, '100018', '1122332212343448', 'Anjas', NULL, NULL, '$2y$10$TzTazVnmHW5P7mfBJO/SrulAXDv7M0AI6ausP/17m3wTbVvr9/gNG', NULL, '', '1983-01-19', '2018-01-19', 'Katolik', '', '', '', '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-17 08:00:00', '2021-07-09 15:52:38', NULL),
(20, 2, 13, 9, '100019', '1122332212343449', 'Widaja', NULL, NULL, '$2y$10$r8Kregz/W1Hk3S1Xq/E/aeFB1VA7Hww1Twd.Z7GFvJ1xmKjwTW/3K', NULL, '', '1983-01-20', '2007-01-02', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-18 08:00:00', '2021-07-23 00:16:52', NULL),
(21, 2, 14, 8, '100020', '1122332212343450', 'Roby', NULL, NULL, '$2y$10$T6v1/SAq1L1DkSGP0.vHI.NO2FxZsVvQk6q9rlgEq0EIJpKSt04Z2', NULL, '', '1983-01-21', '2018-01-21', 'Katolik', '', '', '', '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2018-01-19 08:00:00', '2021-08-04 15:41:02', NULL),
(22, 1, 13, 7, '100021', '1122332212343451', 'Iwan Taruna', NULL, NULL, '$2y$10$YBLt/JCQtdhL8FvsJdUbfeNhM2pJrOALI1ia/Oe3JE/pUngnyCZQG', NULL, '', '1983-01-22', '2020-06-01', 'Islam', '', '', '', '1', '1', '0', 0.00, '0', 'employee', '0', '1', '2021-07-12 16:13:53', '2021-07-26 04:43:30', NULL);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_trans_site`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_trans_site` (
`siteId` int unsigned
,`employDayOf` bigint
,`startDayOf` date
,`employAssign` bigint
,`startAssign` date
,`employPerm` bigint
,`startPerm` date
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_trans_site_join_dates`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_trans_site_join_dates` (
`startDate` varchar(30)
,`siteId` int unsigned
,`employDayOf` bigint
,`employAssign` bigint
,`employPerm` bigint
,`startDayOf` date
,`startAssign` date
,`startPerm` date
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_trans_site_months`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_trans_site_months` (
`siteId` int unsigned
,`year` int
,`month` int
,`sumDayOf` decimal(42,0)
,`sumAssign` decimal(42,0)
,`sumPerm` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_trans_site`
--
DROP TABLE IF EXISTS `view_trans_site`;

CREATE ALGORITHM=UNDEFINED DEFINER=`biraldino`@`localhost` SQL SECURITY DEFINER VIEW `view_trans_site`  AS SELECT `e`.`id` AS `siteId`, count(0) AS `employDayOf`, `b`.`start` AS `startDayOf`, 0 AS `employAssign`, NULL AS `startAssign`, 0 AS `employPerm`, NULL AS `startPerm` FROM ((`users` `a` join `day_ofs` `b` on(((`b`.`user_id` = `a`.`id`) and (`a`.`active` = '1') and (`b`.`active` = '1')))) join `sites` `e` on((`a`.`site_id` = `e`.`id`))) GROUP BY `e`.`id`, `b`.`start` HAVING (count(0) > 0) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_trans_site_join_dates`
--
DROP TABLE IF EXISTS `view_trans_site_join_dates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`biraldino`@`localhost` SQL SECURITY DEFINER VIEW `view_trans_site_join_dates`  AS SELECT concat_ws('',`view_trans_site`.`startDayOf`,`view_trans_site`.`startPerm`,`view_trans_site`.`startAssign`) AS `startDate`, `view_trans_site`.`siteId` AS `siteId`, `view_trans_site`.`employDayOf` AS `employDayOf`, `view_trans_site`.`employAssign` AS `employAssign`, `view_trans_site`.`employPerm` AS `employPerm`, `view_trans_site`.`startDayOf` AS `startDayOf`, `view_trans_site`.`startAssign` AS `startAssign`, `view_trans_site`.`startPerm` AS `startPerm` FROM `view_trans_site` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_trans_site_months`
--
DROP TABLE IF EXISTS `view_trans_site_months`;

CREATE ALGORITHM=UNDEFINED DEFINER=`biraldino`@`localhost` SQL SECURITY DEFINER VIEW `view_trans_site_months`  AS SELECT `view_trans_site_join_dates`.`siteId` AS `siteId`, year(`view_trans_site_join_dates`.`startDate`) AS `year`, month(`view_trans_site_join_dates`.`startDate`) AS `month`, sum(`view_trans_site_join_dates`.`employDayOf`) AS `sumDayOf`, sum(`view_trans_site_join_dates`.`employAssign`) AS `sumAssign`, sum(`view_trans_site_join_dates`.`employPerm`) AS `sumPerm` FROM `view_trans_site_join_dates` GROUP BY year(`view_trans_site_join_dates`.`startDate`), month(`view_trans_site_join_dates`.`startDate`), `view_trans_site_join_dates`.`employDayOf`, `view_trans_site_join_dates`.`employAssign`, `view_trans_site_join_dates`.`employPerm` ORDER BY year(`view_trans_site_join_dates`.`startDate`) ASC, month(`view_trans_site_join_dates`.`startDate`) ASC, `view_trans_site_join_dates`.`employDayOf` ASC, `view_trans_site_join_dates`.`employAssign` ASC, `view_trans_site_join_dates`.`employPerm` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `annual_leaves`
--
ALTER TABLE `annual_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `poh_id` (`poh_id`),
  ADD KEY `day_of_id` (`day_of_id`);

--
-- Indeks untuk tabel `annual_leave_counters`
--
ALTER TABLE `annual_leave_counters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `site_id` (`site_id`);

--
-- Indeks untuk tabel `approval_records`
--
ALTER TABLE `approval_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doc_id` (`doc`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `site_id` (`site_id`);

--
-- Indeks untuk tabel `assignment_destinations`
--
ALTER TABLE `assignment_destinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `to_id` (`to_id`);

--
-- Indeks untuk tabel `big_leaves`
--
ALTER TABLE `big_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `poh_id` (`poh_id`),
  ADD KEY `day_of_id` (`day_of_id`);

--
-- Indeks untuk tabel `big_leave_claims`
--
ALTER TABLE `big_leave_claims`
  ADD PRIMARY KEY (`id`),
  ADD KEY `big_leave_id` (`big_leave_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `site_id` (`site_id`);

--
-- Indeks untuk tabel `big_leave_counters`
--
ALTER TABLE `big_leave_counters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `site_id` (`site_id`);

--
-- Indeks untuk tabel `day_ofs`
--
ALTER TABLE `day_ofs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `poh_id` (`poh_id`);

--
-- Indeks untuk tabel `day_of_destinations`
--
ALTER TABLE `day_of_destinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_of_id` (`day_of_id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `to_id` (`to_id`);

--
-- Indeks untuk tabel `day_of_periods`
--
ALTER TABLE `day_of_periods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `day_of_periods_staff_unique` (`staff`),
  ADD KEY `doper_id` (`id`);

--
-- Indeks untuk tabel `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dep_id` (`id`);

--
-- Indeks untuk tabel `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `destination_id` (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `lumpsums`
--
ALTER TABLE `lumpsums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lump_id` (`id`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `poh_id` (`poh_id`),
  ADD KEY `pos_id` (`position_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `permission_category_id` (`permission_category_id`);

--
-- Indeks untuk tabel `permission_categories`
--
ALTER TABLE `permission_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_categories_id` (`id`);

--
-- Indeks untuk tabel `permission_debts`
--
ALTER TABLE `permission_debts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `site_id` (`site_id`);

--
-- Indeks untuk tabel `pohs`
--
ALTER TABLE `pohs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poh_id` (`id`);

--
-- Indeks untuk tabel `poh_annual_leaves`
--
ALTER TABLE `poh_annual_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ann_lvs_id` (`id`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `poh_id` (`poh_id`);

--
-- Indeks untuk tabel `poh_big_leaves`
--
ALTER TABLE `poh_big_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `big_lvs_id` (`id`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `poh_id` (`poh_id`);

--
-- Indeks untuk tabel `poh_day_ofs`
--
ALTER TABLE `poh_day_ofs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poh_days_of_id` (`id`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `poh_id` (`poh_id`);

--
-- Indeks untuk tabel `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pos_id` (`id`),
  ADD KEY `dep_id` (`department_id`);

--
-- Indeks untuk tabel `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sites_code_unique` (`code`),
  ADD KEY `site_id` (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_nrp_unique` (`nrp`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `site_id` (`site_id`),
  ADD KEY `poh_id` (`poh_id`),
  ADD KEY `pos_id` (`position_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `annual_leaves`
--
ALTER TABLE `annual_leaves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `annual_leave_counters`
--
ALTER TABLE `annual_leave_counters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `approval_records`
--
ALTER TABLE `approval_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `assignment_destinations`
--
ALTER TABLE `assignment_destinations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `big_leaves`
--
ALTER TABLE `big_leaves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `big_leave_claims`
--
ALTER TABLE `big_leave_claims`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `big_leave_counters`
--
ALTER TABLE `big_leave_counters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `day_ofs`
--
ALTER TABLE `day_ofs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `day_of_destinations`
--
ALTER TABLE `day_of_destinations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `day_of_periods`
--
ALTER TABLE `day_of_periods`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lumpsums`
--
ALTER TABLE `lumpsums`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `permission_categories`
--
ALTER TABLE `permission_categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `permission_debts`
--
ALTER TABLE `permission_debts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pohs`
--
ALTER TABLE `pohs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `poh_annual_leaves`
--
ALTER TABLE `poh_annual_leaves`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `poh_big_leaves`
--
ALTER TABLE `poh_big_leaves`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `poh_day_ofs`
--
ALTER TABLE `poh_day_ofs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `annual_leaves`
--
ALTER TABLE `annual_leaves`
  ADD CONSTRAINT `annual_leaves_day_of_id_foreign` FOREIGN KEY (`day_of_id`) REFERENCES `day_ofs` (`id`),
  ADD CONSTRAINT `annual_leaves_poh_id_foreign` FOREIGN KEY (`poh_id`) REFERENCES `pohs` (`id`),
  ADD CONSTRAINT `annual_leaves_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `annual_leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `annual_leave_counters`
--
ALTER TABLE `annual_leave_counters`
  ADD CONSTRAINT `annual_leave_counters_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `annual_leave_counters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `approval_records`
--
ALTER TABLE `approval_records`
  ADD CONSTRAINT `approval_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `assignments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `assignment_destinations`
--
ALTER TABLE `assignment_destinations`
  ADD CONSTRAINT `assignment_destinations_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`),
  ADD CONSTRAINT `assignment_destinations_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `destinations` (`id`),
  ADD CONSTRAINT `assignment_destinations_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `destinations` (`id`);

--
-- Ketidakleluasaan untuk tabel `big_leaves`
--
ALTER TABLE `big_leaves`
  ADD CONSTRAINT `big_leaves_day_of_id_foreign` FOREIGN KEY (`day_of_id`) REFERENCES `day_ofs` (`id`),
  ADD CONSTRAINT `big_leaves_poh_id_foreign` FOREIGN KEY (`poh_id`) REFERENCES `pohs` (`id`),
  ADD CONSTRAINT `big_leaves_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `big_leaves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `big_leave_claims`
--
ALTER TABLE `big_leave_claims`
  ADD CONSTRAINT `big_leave_claims_big_leave_id_foreign` FOREIGN KEY (`big_leave_id`) REFERENCES `big_leaves` (`id`),
  ADD CONSTRAINT `big_leave_claims_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `big_leave_claims_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `big_leave_counters`
--
ALTER TABLE `big_leave_counters`
  ADD CONSTRAINT `big_leave_counters_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `big_leave_counters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `day_ofs`
--
ALTER TABLE `day_ofs`
  ADD CONSTRAINT `day_ofs_poh_id_foreign` FOREIGN KEY (`poh_id`) REFERENCES `pohs` (`id`),
  ADD CONSTRAINT `day_ofs_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `day_ofs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `day_of_destinations`
--
ALTER TABLE `day_of_destinations`
  ADD CONSTRAINT `day_of_destinations_day_of_id_foreign` FOREIGN KEY (`day_of_id`) REFERENCES `day_ofs` (`id`),
  ADD CONSTRAINT `day_of_destinations_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `destinations` (`id`),
  ADD CONSTRAINT `day_of_destinations_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `destinations` (`id`);

--
-- Ketidakleluasaan untuk tabel `lumpsums`
--
ALTER TABLE `lumpsums`
  ADD CONSTRAINT `lumpsums_poh_id_foreign` FOREIGN KEY (`poh_id`) REFERENCES `pohs` (`id`),
  ADD CONSTRAINT `lumpsums_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `lumpsums_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`);

--
-- Ketidakleluasaan untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_permission_category_id_foreign` FOREIGN KEY (`permission_category_id`) REFERENCES `permission_categories` (`id`),
  ADD CONSTRAINT `permissions_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `permission_debts`
--
ALTER TABLE `permission_debts`
  ADD CONSTRAINT `permission_debts_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_debts_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`),
  ADD CONSTRAINT `permission_debts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `poh_annual_leaves`
--
ALTER TABLE `poh_annual_leaves`
  ADD CONSTRAINT `poh_annual_leaves_poh_id_foreign` FOREIGN KEY (`poh_id`) REFERENCES `pohs` (`id`),
  ADD CONSTRAINT `poh_annual_leaves_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`);

--
-- Ketidakleluasaan untuk tabel `poh_big_leaves`
--
ALTER TABLE `poh_big_leaves`
  ADD CONSTRAINT `poh_big_leaves_poh_id_foreign` FOREIGN KEY (`poh_id`) REFERENCES `pohs` (`id`),
  ADD CONSTRAINT `poh_big_leaves_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`);

--
-- Ketidakleluasaan untuk tabel `poh_day_ofs`
--
ALTER TABLE `poh_day_ofs`
  ADD CONSTRAINT `poh_day_ofs_poh_id_foreign` FOREIGN KEY (`poh_id`) REFERENCES `pohs` (`id`),
  ADD CONSTRAINT `poh_day_ofs_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`);

--
-- Ketidakleluasaan untuk tabel `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_poh_id_foreign` FOREIGN KEY (`poh_id`) REFERENCES `pohs` (`id`),
  ADD CONSTRAINT `users_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `users_site_id_foreign` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
