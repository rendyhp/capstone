-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2025 at 12:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel2`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahans`
--

CREATE TABLE `bahans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `section` enum('BAR','KITCHEN') NOT NULL,
  `minimum` decimal(15,3) NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bahans`
--

INSERT INTO `bahans` (`id`, `user_id`, `name`, `description`, `section`, `minimum`, `satuan_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 1, 'Robusta 100%', '-', 'BAR', 500.000, 4, NULL, '2025-05-15 01:03:24', '2025-05-15 01:03:24', NULL),
(9, 1, 'Air', '-', 'BAR', 1000.000, 1, NULL, '2025-05-15 01:03:41', '2025-05-15 01:03:41', NULL),
(10, 3, 'Cabe Setan', '-', 'KITCHEN', 50.000, 4, NULL, '2025-05-15 09:53:02', '2025-05-15 09:53:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_akhirs`
--

CREATE TABLE `bahan_akhirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bahan_akhirs`
--

INSERT INTO `bahan_akhirs` (`id`, `user_id`, `date`, `bahan_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(40, 1, '2025-05-31', 9, 2000.000, '2025-05-15 01:43:13', '2025-05-15 01:43:13', NULL),
(41, 1, '2025-05-31', 8, 500.000, '2025-05-15 01:43:13', '2025-05-15 01:43:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_awals`
--

CREATE TABLE `bahan_awals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah` decimal(15,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bahan_awals`
--

INSERT INTO `bahan_awals` (`id`, `user_id`, `date`, `bahan_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(22, 1, '2025-06-01', 9, NULL, 2000.000, '2025-05-15 01:43:13', '2025-05-15 01:43:13', NULL),
(23, 1, '2025-06-01', 8, NULL, 500.000, '2025-05-15 01:43:13', '2025-05-15 01:43:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_keluars`
--

CREATE TABLE `bahan_keluars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah` decimal(15,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bahan_masuks`
--

CREATE TABLE `bahan_masuks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah` decimal(15,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bahan_masuks`
--

INSERT INTO `bahan_masuks` (`id`, `user_id`, `date`, `bahan_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 1, '2025-05-15', 9, '-', 1000.000, '2025-05-15 01:06:52', '2025-05-15 01:06:52', NULL),
(6, 1, '2025-05-15', 8, '-', 500.000, '2025-05-15 01:07:29', '2025-05-15 01:07:29', NULL),
(7, 1, '2025-05-15', 10, '-', 500.000, '2025-05-15 03:08:49', '2025-05-15 03:08:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_stoks`
--

CREATE TABLE `bahan_stoks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangs`
--

INSERT INTO `barangs` (`id`, `user_id`, `date`, `name`, `description`, `jumlah`, `satuan_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-05-05', 'Piring', 'Piring baru', 20, 2, 'upload/barang/1746413436.jpg', '2025-05-04 19:50:36', '2025-05-04 19:50:36', NULL),
(2, 1, '2025-05-05', 'Gelas Kecil', '-', 12, 2, 'upload/barang/1746413584.jpg', '2025-05-04 19:53:04', '2025-05-04 19:53:04', NULL),
(3, 1, '2025-05-05', 'Gelas Besar', '-', 20, 2, 'upload/barang/1746413997.webp', '2025-05-04 19:59:57', '2025-05-04 19:59:57', NULL),
(4, 1, '2025-05-05', 'Meja Kafe', 'Meja baru', 10, 2, 'upload/barang/1746414173.jpg', '2025-05-04 20:02:53', '2025-05-04 20:02:53', NULL),
(5, 1, '2025-05-05', 'Kursi Kafe', '-', 20, 2, 'upload/barang/1746414367.webp', '2025-05-04 20:06:07', '2025-05-04 20:06:07', NULL),
(6, 3, '2025-05-15', 'Mangkok', '-', 10, 2, NULL, '2025-05-15 00:13:13', '2025-05-15 00:13:13', NULL),
(7, 1, '2025-01-15', 'mangkok besar', '-', 5, 2, NULL, '2025-05-15 00:57:31', '2025-05-15 00:57:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_awals`
--

CREATE TABLE `barang_awals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_awals`
--

INSERT INTO `barang_awals` (`id`, `user_id`, `date`, `barang_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-05-05', 1, 'Stok awal Piring', 20, '2025-05-04 19:50:36', '2025-05-04 19:50:36', NULL),
(2, 1, '2025-05-05', 2, 'Stok awal Gelas Kecil', 12, '2025-05-04 19:53:04', '2025-05-04 19:53:04', NULL),
(3, 1, '2025-05-05', 3, 'Stok awal Gelas Besar', 20, '2025-05-04 19:59:57', '2025-05-04 19:59:57', NULL),
(4, 1, '2025-05-05', 4, 'Stok awal Meja Kafe', 10, '2025-05-04 20:02:53', '2025-05-04 20:02:53', NULL),
(5, 1, '2025-05-05', 5, 'Stok awal Kursi Kafe', 20, '2025-05-04 20:06:07', '2025-05-04 20:06:07', NULL),
(6, 3, '2025-05-15', 6, 'Stok awal Mangkok', 10, '2025-05-15 00:13:13', '2025-05-15 00:13:13', NULL),
(7, 1, '2025-01-15', 7, 'Stok awal mangkok besar', 5, '2025-05-15 00:57:31', '2025-05-15 00:57:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluars`
--

CREATE TABLE `barang_keluars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_keluars`
--

INSERT INTO `barang_keluars` (`id`, `user_id`, `barang_id`, `date`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2, '2025-05-15', 'Gelas pecah', 3, '2025-05-15 00:34:38', '2025-05-15 00:34:38', NULL),
(2, 1, 7, '2025-05-14', 'pecah', 2, '2025-05-15 00:58:29', '2025-05-15 00:58:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuks`
--

CREATE TABLE `barang_masuks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang_masuks`
--

INSERT INTO `barang_masuks` (`id`, `user_id`, `date`, `barang_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-05-05', 1, 'Beli lagi', 5, '2025-05-04 19:50:58', '2025-05-04 19:50:58', NULL),
(2, 1, '2025-05-15', 7, '-', 5, '2025-05-15 00:58:10', '2025-05-15 00:58:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deleted_items`
--

CREATE TABLE `deleted_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `komposisi_menus`
--

CREATE TABLE `komposisi_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komposisi_menus`
--

INSERT INTO `komposisi_menus` (`id`, `menu_id`, `bahan_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(20, 6, 9, 200.000, '2025-05-15 01:11:28', '2025-05-15 01:11:28', NULL),
(21, 6, 8, 20.000, '2025-05-15 01:11:28', '2025-05-15 01:11:28', NULL),
(22, 7, 9, 400.000, '2025-05-15 01:12:59', '2025-05-15 01:12:59', NULL),
(23, 7, 8, 10.000, '2025-05-15 01:12:59', '2025-05-15 01:12:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log_activities`
--

CREATE TABLE `log_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `user_id`, `name`, `description`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 1, 'Ice Coffee Original', '-', NULL, '2025-05-15 01:11:28', '2025-05-15 01:11:28', NULL),
(7, 1, 'Americano Ice', '-', NULL, '2025-05-15 01:12:59', '2025-05-15 01:12:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_04_22_000001_create_password_resets_table', 1),
(3, '2025_04_22_000010__create_personal_access_tokens_table', 1),
(4, '2025_04_22_000020_create_users_table', 1),
(5, '2025_04_22_000024_create_failed_jobs_table', 1),
(6, '2025_04_22_000025_create_password_reset_tokens_table', 1),
(7, '2025_04_22_000030_create_satuan_bahans_table', 1),
(8, '2025_04_22_000040_create_bahans_table', 1),
(9, '2025_04_22_000050_create_bahan_awals_table', 1),
(10, '2025_04_22_000060_create_bahan_masuks_table', 1),
(11, '2025_04_22_000070_create_bahan_keluars_table', 1),
(12, '2025_04_22_000080_create_bahan_akhirs_table', 1),
(13, '2025_04_22_000080_create_bahan_stoks_table', 1),
(14, '2025_04_22_000110_create_satuan_barangs_table', 1),
(15, '2025_04_22_000120_create_barangs_table', 1),
(16, '2025_04_22_000129_create_barang_awals_table', 1),
(17, '2025_04_22_000130_create_barang_masuks_table', 1),
(18, '2025_04_22_000140_create_barang_keluars_table', 1),
(19, '2025_04_22_000210_create_menus_table', 1),
(20, '2025_04_22_000220_create_komposisi_menus_table', 1),
(23, '2025_04_22_900010_create_temporary_files_table', 1),
(24, '2025_04_22_900020_create_deleted_items_table', 1),
(25, '2025_04_22_900029_create_tag_notifikasis_table', 1),
(26, '2025_04_22_900030_create_notifikasis_table', 1),
(27, '2025_04_22_900040_create_log_activities_table', 1),
(28, '2025_04_22_000310_create_transaksis_table', 2),
(29, '2025_04_22_000320_create_transaksi_details_table', 2),
(30, '2025_05_07_023832_create_user_settings_table', 3),
(31, '2025_05_07_023900_create_user_profiles_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tag_notifikasi_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuan_bahans`
--

CREATE TABLE `satuan_bahans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan_bahans`
--

INSERT INTO `satuan_bahans` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'mL', '2025-05-04 20:13:44', '2025-05-04 20:13:44', NULL),
(2, 1, 'kg', '2025-05-04 20:13:53', '2025-05-04 20:13:53', NULL),
(3, 1, 'lembar', '2025-05-04 20:18:21', '2025-05-04 20:18:21', NULL),
(4, 1, 'gram', '2025-05-04 20:40:54', '2025-05-04 20:40:54', NULL),
(5, 1, 'potong', '2025-05-04 21:03:43', '2025-05-04 21:03:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `satuan_barangs`
--

CREATE TABLE `satuan_barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan_barangs`
--

INSERT INTO `satuan_barangs` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '-', '2025-05-04 19:47:44', '2025-05-04 19:47:44', NULL),
(2, 1, 'Pcs', '2025-05-04 19:47:50', '2025-05-04 19:47:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag_notifikasis`
--

CREATE TABLE `tag_notifikasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temporary_files`
--

CREATE TABLE `temporary_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `folder` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `user_id`, `date`, `menu_name`, `menu_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(15, 1, '2025-05-10', NULL, 7, 1, '2025-05-15 01:24:42', '2025-05-15 01:24:42', NULL),
(16, 1, '2025-05-10', NULL, 7, 1, '2025-05-15 01:25:00', '2025-05-15 01:25:00', NULL),
(17, 1, '2025-05-10', NULL, 7, 1, '2025-05-15 01:25:50', '2025-05-15 01:25:50', NULL),
(19, 1, '2025-05-15', NULL, 7, 1, '2025-05-15 01:27:01', '2025-05-15 01:27:01', NULL),
(21, 1, '2025-05-16', NULL, 7, 2, '2025-05-15 01:33:29', '2025-05-15 01:33:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_details`
--

CREATE TABLE `transaksi_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,3) NOT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi_details`
--

INSERT INTO `transaksi_details` (`id`, `date`, `transaksi_id`, `menu_id`, `bahan_id`, `jumlah`, `satuan`, `created_at`, `updated_at`) VALUES
(45, '2025-05-10', 15, 7, 9, 400.000, NULL, '2025-05-15 01:24:42', '2025-05-15 01:24:42'),
(46, '2025-05-10', 15, 7, 8, 10.000, NULL, '2025-05-15 01:24:42', '2025-05-15 01:24:42'),
(47, '2025-05-10', 16, 7, 9, 400.000, NULL, '2025-05-15 01:25:00', '2025-05-15 01:25:00'),
(48, '2025-05-10', 16, 7, 8, 10.000, NULL, '2025-05-15 01:25:00', '2025-05-15 01:25:00'),
(49, '2025-05-10', 17, 7, 9, 400.000, NULL, '2025-05-15 01:25:50', '2025-05-15 01:25:50'),
(50, '2025-05-10', 17, 7, 8, 10.000, NULL, '2025-05-15 01:25:50', '2025-05-15 01:25:50'),
(53, '2025-05-15', 19, 7, 9, 400.000, NULL, '2025-05-15 01:27:01', '2025-05-15 01:27:01'),
(54, '2025-05-15', 19, 7, 8, 10.000, NULL, '2025-05-15 01:27:01', '2025-05-15 01:27:01'),
(57, '2025-05-16', 21, 7, 9, 800.000, NULL, '2025-05-15 01:33:29', '2025-05-15 01:33:29'),
(58, '2025-05-16', 21, 7, 8, 20.000, NULL, '2025-05-15 01:33:29', '2025-05-15 01:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('OWNER','MANAJER','STAF') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rendy Hartono Putra', 'rendi45hp', 'rendi45hp@gmail.com', '2025-05-04 19:45:10', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MANAJER', 'Qprfd2LkWsCMvU3DlSxA5AZqHVeaNX7Z8GR7OzW4wwAEuQX8W5spD9RcwPB2', '2025-05-04 19:45:10', '2025-05-04 19:45:10', NULL),
(2, 'Maritza Septiarini', 'maritzaseptiarini', 'maritzaseptiarini@gmail.com', '2025-05-04 19:45:12', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'STAF', 'GnmI9YfzopyeCYPcmSuLOFczSNRBAA6hp0wLhqADPsSqyO8weoypDxsXmY6b', '2025-05-04 19:45:12', '2025-05-04 19:45:12', NULL),
(3, 'Abida Amalia Syifa', 'abidaams', 'abidaams@gmail.com', '2025-05-04 19:45:16', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OWNER', 'CAgxl4zYl0kBXHEBXnkKb2zioHnNgr8ZxAnFkrDoEjko40Dv0SWkixYu6IAN', '2025-05-04 19:45:16', '2025-05-04 19:45:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahans`
--
ALTER TABLE `bahans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahans_user_id_foreign` (`user_id`),
  ADD KEY `bahans_satuan_id_foreign` (`satuan_id`);

--
-- Indexes for table `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_akhirs_user_id_foreign` (`user_id`),
  ADD KEY `bahan_akhirs_bahan_id_foreign` (`bahan_id`);

--
-- Indexes for table `bahan_awals`
--
ALTER TABLE `bahan_awals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_awals_user_id_foreign` (`user_id`),
  ADD KEY `bahan_awals_bahan_id_foreign` (`bahan_id`);

--
-- Indexes for table `bahan_keluars`
--
ALTER TABLE `bahan_keluars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_keluars_user_id_foreign` (`user_id`),
  ADD KEY `bahan_keluars_bahan_id_foreign` (`bahan_id`);

--
-- Indexes for table `bahan_masuks`
--
ALTER TABLE `bahan_masuks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_masuks_user_id_foreign` (`user_id`),
  ADD KEY `bahan_masuks_bahan_id_foreign` (`bahan_id`);

--
-- Indexes for table `bahan_stoks`
--
ALTER TABLE `bahan_stoks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_stoks_user_id_foreign` (`user_id`),
  ADD KEY `bahan_stoks_bahan_id_foreign` (`bahan_id`);

--
-- Indexes for table `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangs_user_id_foreign` (`user_id`),
  ADD KEY `barangs_satuan_id_foreign` (`satuan_id`);

--
-- Indexes for table `barang_awals`
--
ALTER TABLE `barang_awals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_awals_user_id_foreign` (`user_id`),
  ADD KEY `barang_awals_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `barang_keluars`
--
ALTER TABLE `barang_keluars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_keluars_user_id_foreign` (`user_id`),
  ADD KEY `barang_keluars_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `barang_masuks`
--
ALTER TABLE `barang_masuks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_masuks_user_id_foreign` (`user_id`),
  ADD KEY `barang_masuks_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `deleted_items`
--
ALTER TABLE `deleted_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komposisi_menus_menu_id_foreign` (`menu_id`),
  ADD KEY `komposisi_menus_bahan_id_foreign` (`bahan_id`);

--
-- Indexes for table `log_activities`
--
ALTER TABLE `log_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_user_id_foreign` (`user_id`),
  ADD KEY `notifikasis_tag_notifikasi_id_foreign` (`tag_notifikasi_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `satuan_bahans`
--
ALTER TABLE `satuan_bahans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satuan_bahans_user_id_foreign` (`user_id`);

--
-- Indexes for table `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satuan_barangs_user_id_foreign` (`user_id`);

--
-- Indexes for table `tag_notifikasis`
--
ALTER TABLE `tag_notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_notifikasis_user_id_foreign` (`user_id`);

--
-- Indexes for table `temporary_files`
--
ALTER TABLE `temporary_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_user_id_foreign` (`user_id`),
  ADD KEY `transaksis_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `transaksi_details`
--
ALTER TABLE `transaksi_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_details_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `transaksi_details_menu_id_foreign` (`menu_id`),
  ADD KEY `transaksi_details_bahan_id_foreign` (`bahan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_settings_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahans`
--
ALTER TABLE `bahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `bahan_awals`
--
ALTER TABLE `bahan_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `bahan_keluars`
--
ALTER TABLE `bahan_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bahan_masuks`
--
ALTER TABLE `bahan_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bahan_stoks`
--
ALTER TABLE `bahan_stoks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `barang_awals`
--
ALTER TABLE `barang_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `barang_keluars`
--
ALTER TABLE `barang_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang_masuks`
--
ALTER TABLE `barang_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deleted_items`
--
ALTER TABLE `deleted_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan_bahans`
--
ALTER TABLE `satuan_bahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tag_notifikasis`
--
ALTER TABLE `tag_notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temporary_files`
--
ALTER TABLE `temporary_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `transaksi_details`
--
ALTER TABLE `transaksi_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bahans`
--
ALTER TABLE `bahans`
  ADD CONSTRAINT `bahans_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuan_bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  ADD CONSTRAINT `bahan_akhirs_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_akhirs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bahan_awals`
--
ALTER TABLE `bahan_awals`
  ADD CONSTRAINT `bahan_awals_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_awals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bahan_keluars`
--
ALTER TABLE `bahan_keluars`
  ADD CONSTRAINT `bahan_keluars_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_keluars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bahan_masuks`
--
ALTER TABLE `bahan_masuks`
  ADD CONSTRAINT `bahan_masuks_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_masuks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bahan_stoks`
--
ALTER TABLE `bahan_stoks`
  ADD CONSTRAINT `bahan_stoks_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_stoks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuan_barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barangs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barang_awals`
--
ALTER TABLE `barang_awals`
  ADD CONSTRAINT `barang_awals_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_awals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barang_keluars`
--
ALTER TABLE `barang_keluars`
  ADD CONSTRAINT `barang_keluars_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_keluars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barang_masuks`
--
ALTER TABLE `barang_masuks`
  ADD CONSTRAINT `barang_masuks_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_masuks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  ADD CONSTRAINT `komposisi_menus_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komposisi_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_tag_notifikasi_id_foreign` FOREIGN KEY (`tag_notifikasi_id`) REFERENCES `tag_notifikasis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `satuan_bahans`
--
ALTER TABLE `satuan_bahans`
  ADD CONSTRAINT `satuan_bahans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  ADD CONSTRAINT `satuan_barangs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tag_notifikasis`
--
ALTER TABLE `tag_notifikasis`
  ADD CONSTRAINT `tag_notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi_details`
--
ALTER TABLE `transaksi_details`
  ADD CONSTRAINT `transaksi_details_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_details_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
