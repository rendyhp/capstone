-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 10:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta03`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahans`
--

CREATE TABLE `bahans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` text DEFAULT NULL,
  `minimum` decimal(15,3) NOT NULL,
  `section` enum('BAR','KITCHEN') NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bahans`
--

INSERT INTO `bahans` (`id`, `user_id`, `name`, `description`, `minimum`, `section`, `satuan_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'Kopi Arabika', '-', 500.000, 'BAR', 2, 'upload/bahan/1748061039.jpg', '2025-05-24 04:29:33', '2025-05-24 04:30:39', NULL),
(2, 2, 'Kopi Robusta', '-', 500.000, 'BAR', 2, 'upload/bahan/1748061015.jpg', '2025-05-24 04:30:15', '2025-05-24 04:30:15', NULL),
(3, 2, 'Susu Segar', '-', 1000.000, 'BAR', 1, 'upload/bahan/1748061061.jpg', '2025-05-24 04:31:01', '2025-05-26 07:59:12', NULL),
(4, 2, 'Gula Pasir', '-', 1000.000, 'BAR', 2, 'upload/bahan/1748061090.jpg', '2025-05-24 04:31:30', '2025-05-24 04:31:30', NULL),
(5, 2, 'Sirup Karamel', '-', 500.000, 'BAR', 1, 'upload/bahan/1748061113.jpg', '2025-05-24 04:31:53', '2025-05-24 04:31:53', NULL),
(6, 2, 'Matcha Powder', '-', 500.000, 'BAR', 2, 'upload/bahan/1748061130.png', '2025-05-24 04:32:10', '2025-05-24 04:32:10', NULL),
(7, 2, 'Coklat Bubuk', '-', 500.000, 'BAR', 2, 'upload/bahan/1748061154.jpg', '2025-05-24 04:32:34', '2025-05-24 04:32:34', NULL),
(8, 2, 'Es Batu', '-', 1000.000, 'BAR', 2, NULL, '2025-05-24 04:33:02', '2025-05-26 07:00:35', NULL),
(9, 2, 'Mangga Segar', '-', 15.000, 'BAR', 5, 'upload/bahan/1748061211.jpeg', '2025-05-24 04:33:31', '2025-05-24 04:33:31', NULL),
(10, 2, 'Strawberry Segar', '-', 30.000, 'BAR', 5, 'upload/bahan/1748061234.jpg', '2025-05-24 04:33:54', '2025-05-24 04:33:54', NULL),
(11, 2, 'Roti Tawar', '-', 48.000, 'KITCHEN', 3, 'upload/bahan/1748061263.jpg', '2025-05-24 04:34:23', '2025-05-24 04:34:23', NULL),
(12, 2, 'Keju Cheddar', '-', 500.000, 'KITCHEN', 2, 'upload/bahan/1748061292.png', '2025-05-24 04:34:52', '2025-05-24 04:34:52', NULL),
(13, 2, 'Daun Mint', '-', 20.000, 'BAR', 3, 'upload/bahan/1748061310.webp', '2025-05-24 04:35:10', '2025-05-24 04:35:10', NULL),
(14, 2, 'Air Soda', '-', 500.000, 'BAR', 1, NULL, '2025-05-24 04:43:23', '2025-05-24 04:43:23', NULL);

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
(1, 3, '2025-05-01', 14, 2000.000, '2025-05-24 05:03:17', '2025-05-24 05:03:17', NULL),
(2, 3, '2025-05-01', 7, 1800.000, '2025-05-24 05:03:24', '2025-05-24 05:03:24', NULL),
(3, 3, '2025-05-01', 13, 25.000, '2025-05-24 05:03:32', '2025-05-24 05:03:32', NULL),
(4, 3, '2025-05-01', 8, 700.000, '2025-05-24 05:03:43', '2025-05-24 05:03:43', NULL),
(5, 3, '2025-05-01', 4, 1900.000, '2025-05-24 05:03:54', '2025-05-24 05:03:54', NULL),
(6, 3, '2025-05-01', 1, 730.000, '2025-05-24 05:04:03', '2025-05-24 05:04:03', NULL),
(7, 3, '2025-05-01', 2, 880.000, '2025-05-24 05:04:09', '2025-05-24 05:04:09', NULL),
(8, 3, '2025-05-01', 9, 27.000, '2025-05-24 05:04:18', '2025-05-24 05:04:18', NULL),
(9, 3, '2025-05-01', 6, 1000.000, '2025-05-24 05:04:26', '2025-05-24 05:04:26', NULL),
(10, 3, '2025-05-01', 5, 980.000, '2025-05-24 05:04:36', '2025-05-24 05:04:36', NULL),
(11, 3, '2025-05-01', 10, 40.000, '2025-05-24 05:04:43', '2025-05-24 05:04:43', NULL),
(12, 3, '2025-05-01', 3, 530.000, '2025-05-24 05:04:56', '2025-05-24 05:04:56', NULL),
(13, 3, '2025-05-01', 12, 800.000, '2025-05-24 05:05:04', '2025-05-24 05:05:04', NULL),
(14, 3, '2025-05-01', 11, 48.000, '2025-05-24 05:05:16', '2025-05-24 05:05:16', NULL);

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
(2, 3, '2025-05-01', 14, NULL, 2000.000, '2025-05-24 04:56:54', '2025-05-24 04:56:54', NULL),
(3, 3, '2025-05-01', 7, NULL, 2000.000, '2025-05-24 04:57:02', '2025-05-24 04:57:02', NULL),
(4, 3, '2025-05-01', 13, NULL, 50.000, '2025-05-24 04:57:09', '2025-05-24 04:57:09', NULL),
(5, 3, '2025-05-01', 8, NULL, 2000.000, '2025-05-24 04:57:16', '2025-05-24 04:57:16', NULL),
(6, 3, '2025-05-01', 4, NULL, 2000.000, '2025-05-24 04:57:35', '2025-05-24 04:57:35', NULL),
(7, 3, '2025-05-01', 1, NULL, 1000.000, '2025-05-24 04:57:42', '2025-05-24 04:57:42', NULL),
(8, 3, '2025-05-01', 2, NULL, 1000.000, '2025-05-24 04:57:48', '2025-05-24 04:57:48', NULL),
(9, 3, '2025-05-01', 9, NULL, 30.000, '2025-05-24 04:57:54', '2025-05-24 04:57:54', NULL),
(10, 3, '2025-05-01', 6, NULL, 1000.000, '2025-05-24 04:58:01', '2025-05-24 04:58:01', NULL),
(11, 3, '2025-05-01', 5, NULL, 1000.000, '2025-05-24 04:58:10', '2025-05-24 04:58:10', NULL),
(12, 3, '2025-05-01', 10, NULL, 50.000, '2025-05-24 04:58:17', '2025-05-24 04:58:17', NULL),
(13, 3, '2025-05-01', 3, NULL, 2000.000, '2025-05-24 04:58:22', '2025-05-24 04:58:22', NULL),
(14, 3, '2025-05-01', 12, NULL, 1000.000, '2025-05-24 04:58:30', '2025-05-24 04:58:30', NULL),
(15, 3, '2025-05-01', 11, NULL, 60.000, '2025-05-24 04:58:35', '2025-05-24 04:58:35', NULL);

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
(1, 3, '2025-05-02', 13, 'cash', 40.000, '2025-05-24 05:05:51', '2025-05-24 05:05:51', NULL),
(2, 3, '2025-05-02', 3, 'BRI', 2000.000, '2025-05-24 05:06:04', '2025-05-24 05:06:04', NULL),
(3, 3, '2025-05-02', 8, 'cash', 1000.000, '2025-05-24 05:06:30', '2025-05-24 05:06:30', NULL);

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
  `name` varchar(30) NOT NULL,
  `description` text DEFAULT NULL,
  `stok_awal` int(11) NOT NULL,
  `minimum` int(11) NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangs`
--

INSERT INTO `barangs` (`id`, `user_id`, `date`, `name`, `description`, `stok_awal`, `minimum`, `satuan_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '2025-05-24', 'Gelas Kecil', '-', 20, 15, 1, 'upload/barang/1748060488.jpg', '2025-05-24 04:21:28', '2025-05-24 04:21:28', NULL),
(2, 2, '2025-05-24', 'Gelas Besar', '-', 15, 12, 1, 'upload/barang/1748060537.webp', '2025-05-24 04:22:17', '2025-05-24 04:22:17', NULL),
(3, 2, '2025-05-24', 'Hand Sanitizer', '-', 5, 4, 1, 'upload/barang/1748060566.jpg', '2025-05-24 04:22:46', '2025-05-24 04:22:46', NULL),
(4, 2, '2025-05-24', 'Piring', '-', 22, 20, 1, 'upload/barang/1748060590.jpg', '2025-05-24 04:23:10', '2025-05-24 04:23:10', NULL),
(5, 2, '2025-05-24', 'Kursi kafe', '-', 20, 18, 1, 'upload/barang/1748060624.webp', '2025-05-24 04:23:44', '2025-05-24 04:23:44', NULL),
(6, 2, '2025-05-24', 'Meja Kafe', '-', 8, 0, 1, 'upload/barang/1748060654.jpg', '2025-05-24 04:24:14', '2025-05-24 04:24:14', NULL),
(7, 2, '2025-05-24', 'Sendok', '-', 30, 28, 1, 'upload/barang/1748060691.jpg', '2025-05-24 04:24:51', '2025-05-24 04:24:51', NULL),
(8, 2, '2025-05-24', 'Garpu', '-', 30, 28, 1, 'upload/barang/1748060720.jpg', '2025-05-24 04:25:20', '2025-05-26 08:05:58', NULL);

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
(1, 2, '2025-05-24', 1, 'Stok awal Gelas Kecil', 20, '2025-05-24 04:21:28', '2025-05-24 04:21:28', NULL),
(2, 2, '2025-05-24', 2, 'Stok awal Gelas Besar', 15, '2025-05-24 04:22:17', '2025-05-24 04:22:17', NULL),
(3, 2, '2025-05-24', 3, 'Stok awal Hand Sanitizer', 5, '2025-05-24 04:22:46', '2025-05-24 04:22:46', NULL),
(4, 2, '2025-05-24', 4, 'Stok awal Piring', 22, '2025-05-24 04:23:10', '2025-05-24 04:23:10', NULL),
(5, 2, '2025-05-24', 5, 'Stok awal Kursi kafe', 20, '2025-05-24 04:23:44', '2025-05-24 04:23:44', NULL),
(6, 2, '2025-05-24', 6, 'Stok awal Meja Kafe', 8, '2025-05-24 04:24:14', '2025-05-24 04:24:14', NULL),
(7, 2, '2025-05-24', 7, 'Stok awal Sendok', 30, '2025-05-24 04:24:51', '2025-05-24 04:24:51', NULL),
(8, 2, '2025-05-24', 8, 'Stok awal Garpuuuuuuuuu', 30, '2025-05-24 04:25:20', '2025-05-24 04:25:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluars`
--

CREATE TABLE `barang_keluars` (
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
-- Dumping data for table `barang_keluars`
--

INSERT INTO `barang_keluars` (`id`, `user_id`, `date`, `barang_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '2025-05-24', 1, 'Rusak', 15, '2025-05-24 04:27:05', '2025-05-24 04:27:05', NULL);

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
(1, 2, '2025-05-24', 1, 'Cash', 8, '2025-05-24 04:26:18', '2025-05-24 04:26:18', NULL);

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
(1, 1, 1, 50.000, '2025-05-24 04:36:24', '2025-05-24 04:36:24', NULL),
(7, 4, 7, 50.000, '2025-05-24 04:38:44', '2025-05-24 04:38:44', NULL),
(8, 4, 3, 180.000, '2025-05-24 04:38:44', '2025-05-24 04:38:44', NULL),
(9, 4, 4, 15.000, '2025-05-24 04:38:44', '2025-05-24 04:38:44', NULL),
(10, 3, 6, 30.000, '2025-05-24 04:38:52', '2025-05-24 04:38:52', NULL),
(11, 3, 3, 200.000, '2025-05-24 04:38:52', '2025-05-24 04:38:52', NULL),
(12, 5, 9, 1.000, '2025-05-24 04:39:49', '2025-05-24 04:39:49', NULL),
(13, 5, 3, 100.000, '2025-05-24 04:39:49', '2025-05-24 04:39:49', NULL),
(14, 5, 8, 100.000, '2025-05-24 04:39:49', '2025-05-24 04:39:49', NULL),
(15, 6, 1, 40.000, '2025-05-24 04:40:38', '2025-05-24 04:40:38', NULL),
(16, 6, 3, 150.000, '2025-05-24 04:40:38', '2025-05-24 04:40:38', NULL),
(17, 6, 5, 20.000, '2025-05-24 04:40:38', '2025-05-24 04:40:38', NULL),
(18, 7, 10, 5.000, '2025-05-24 04:41:19', '2025-05-24 04:41:19', NULL),
(19, 7, 4, 10.000, '2025-05-24 04:41:19', '2025-05-24 04:41:19', NULL),
(20, 7, 8, 50.000, '2025-05-24 04:41:19', '2025-05-24 04:41:19', NULL),
(21, 8, 11, 2.000, '2025-05-24 04:41:51', '2025-05-24 04:41:51', NULL),
(22, 8, 12, 30.000, '2025-05-24 04:41:51', '2025-05-24 04:41:51', NULL),
(23, 9, 2, 40.000, '2025-05-24 04:42:28', '2025-05-24 04:42:28', NULL),
(24, 9, 8, 100.000, '2025-05-24 04:42:28', '2025-05-24 04:42:28', NULL),
(25, 10, 13, 5.000, '2025-05-24 04:42:58', '2025-05-24 04:42:58', NULL),
(26, 10, 8, 100.000, '2025-05-24 04:42:58', '2025-05-24 04:42:58', NULL),
(27, 2, 1, 40.000, '2025-05-24 05:00:17', '2025-05-24 05:00:17', NULL),
(28, 2, 3, 150.000, '2025-05-24 05:00:17', '2025-05-24 05:00:17', NULL),
(29, 2, 4, 10.000, '2025-05-24 05:00:17', '2025-05-24 05:00:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
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
(1, 2, 'Espresso', '-', 'upload/menu/1748061384.webp', '2025-05-24 04:36:24', '2025-05-24 04:36:24', NULL),
(2, 2, 'Cappuccino', '-', 'upload/menu/1748061434.jpg', '2025-05-24 04:37:14', '2025-05-26 08:05:22', NULL),
(3, 2, 'Matcha Latte', '-', 'upload/menu/1748061472.jpg', '2025-05-24 04:37:52', '2025-05-24 04:38:52', NULL),
(4, 2, 'Hot Chocolate', '-', 'upload/menu/1748061524.jpg', '2025-05-24 04:38:44', '2025-05-24 04:38:44', NULL),
(5, 2, 'Mango Smoothie', '-', 'upload/menu/1748061589.jpg', '2025-05-24 04:39:49', '2025-05-24 04:39:49', NULL),
(6, 2, 'Caramel Latte', '-', 'upload/menu/1748061638.jpg', '2025-05-24 04:40:38', '2025-05-24 04:40:38', NULL),
(7, 2, 'Strawberry Juice', '-', 'upload/menu/1748061679.jpg', '2025-05-24 04:41:19', '2025-05-24 04:41:19', NULL),
(8, 2, 'Cheese Toast', '-', 'upload/menu/1748061711.jpg', '2025-05-24 04:41:51', '2025-05-24 04:41:51', NULL),
(9, 2, 'Iced Americano', '-', 'upload/menu/1748061748.jpg', '2025-05-24 04:42:28', '2025-05-24 04:42:28', NULL),
(10, 2, 'Mint Mojito', '-', 'upload/menu/1748061778.jpg', '2025-05-24 04:42:58', '2025-05-24 04:42:58', NULL);

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
(11, '2025_04_22_000080_create_bahan_akhirs_table', 1),
(12, '2025_04_22_000080_create_bahan_stoks_table', 1),
(13, '2025_04_22_000110_create_satuan_barangs_table', 1),
(14, '2025_04_22_000120_create_barangs_table', 1),
(15, '2025_04_22_000129_create_barang_awals_table', 1),
(16, '2025_04_22_000130_create_barang_masuks_table', 1),
(17, '2025_04_22_000140_create_barang_keluars_table', 1),
(18, '2025_04_22_000210_create_menus_table', 1),
(19, '2025_04_22_000220_create_komposisi_menus_table', 1),
(20, '2025_04_22_000310_create_transaksis_table', 1),
(21, '2025_04_22_000320_create_transaksi_details_table', 1),
(22, '2025_05_07_023832_create_user_settings_table', 1),
(23, '2025_05_07_023900_create_user_profiles_table', 1),
(24, '2025_05_21_103042_create_stock_alert_logs_table', 1),
(25, '2025_05_26_131914_create_set_api_tokens_table', 2);

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
  `name` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan_bahans`
--

INSERT INTO `satuan_bahans` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'mL', '2025-05-24 04:28:51', '2025-05-24 04:28:51', NULL),
(2, 2, 'gram', '2025-05-24 04:28:56', '2025-05-24 04:28:56', NULL),
(3, 2, 'lembar', '2025-05-24 04:29:00', '2025-05-24 04:29:00', NULL),
(4, 2, 'potong', '2025-05-24 04:29:13', '2025-05-24 04:29:13', NULL),
(5, 2, 'buah', '2025-05-24 04:33:13', '2025-05-24 04:33:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `satuan_barangs`
--

CREATE TABLE `satuan_barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan_barangs`
--

INSERT INTO `satuan_barangs` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'Pcs', '2025-05-24 04:20:54', '2025-05-24 04:20:54', NULL),
(2, 2, 'Pkg', '2025-05-24 04:20:59', '2025-05-24 04:20:59', NULL),
(3, 2, 'Lembar', '2025-05-24 04:21:05', '2025-05-24 04:21:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `set_api_tokens`
--

CREATE TABLE `set_api_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `token_name` varchar(50) DEFAULT NULL,
  `phone` varchar(18) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `set_api_tokens`
--

INSERT INTO `set_api_tokens` (`id`, `name`, `token_name`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'NotificationApi', '49zbRGa16VLm8S44vT5E', '6281226077106', NULL, '2025-05-26 06:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `stock_alert_logs`
--

CREATE TABLE `stock_alert_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stockable_id` bigint(20) UNSIGNED NOT NULL,
  `stockable_type` varchar(255) NOT NULL,
  `alert_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_alert_logs`
--

INSERT INTO `stock_alert_logs` (`id`, `stockable_id`, `stockable_type`, `alert_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Models\\Barang', '2025-05-24', '2025-05-24 04:27:05', '2025-05-24 04:27:05'),
(2, 3, 'App\\Models\\Bahan', '2025-05-24', '2025-05-24 05:00:41', '2025-05-24 05:00:41'),
(3, 8, 'App\\Models\\Bahan', '2025-05-24', '2025-05-24 05:00:41', '2025-05-24 05:00:41'),
(4, 1, 'App\\Models\\Bahan', '2025-05-24', '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(5, 10, 'App\\Models\\Bahan', '2025-05-24', '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(6, 11, 'App\\Models\\Bahan', '2025-05-24', '2025-05-24 05:06:46', '2025-05-24 05:06:46');

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
(10, 3, '2025-05-01', NULL, 1, 3, '2025-05-24 05:01:09', '2025-05-24 05:01:09', NULL),
(11, 3, '2025-05-01', NULL, 2, 2, '2025-05-24 05:01:09', '2025-05-24 05:01:09', NULL),
(12, 3, '2025-05-01', NULL, 6, 1, '2025-05-24 05:01:09', '2025-05-24 05:01:09', NULL),
(13, 3, '2025-05-01', NULL, 4, 4, '2025-05-24 05:01:09', '2025-05-24 05:01:09', NULL),
(14, 3, '2025-05-01', NULL, 5, 3, '2025-05-24 05:01:09', '2025-05-24 05:01:09', NULL),
(15, 3, '2025-05-01', NULL, 7, 2, '2025-05-24 05:01:09', '2025-05-24 05:01:09', NULL),
(16, 3, '2025-05-01', NULL, 8, 6, '2025-05-24 05:01:09', '2025-05-24 05:01:09', NULL),
(17, 3, '2025-05-01', NULL, 9, 3, '2025-05-24 05:01:09', '2025-05-24 05:01:09', NULL),
(18, 3, '2025-05-01', NULL, 10, 5, '2025-05-24 05:01:09', '2025-05-24 05:01:09', NULL),
(19, 3, '2025-05-02', NULL, 1, 5, '2025-05-24 05:06:46', '2025-05-24 05:06:46', NULL),
(20, 3, '2025-05-02', NULL, 2, 3, '2025-05-24 05:06:46', '2025-05-24 05:06:46', NULL),
(21, 3, '2025-05-02', NULL, 3, 2, '2025-05-24 05:06:46', '2025-05-24 05:06:46', NULL),
(22, 3, '2025-05-02', NULL, 4, 5, '2025-05-24 05:06:46', '2025-05-24 05:06:46', NULL),
(23, 3, '2025-05-02', NULL, 5, 4, '2025-05-24 05:06:46', '2025-05-24 05:06:46', NULL),
(24, 3, '2025-05-02', NULL, 7, 5, '2025-05-24 05:06:46', '2025-05-24 05:06:46', NULL),
(25, 3, '2025-05-02', NULL, 8, 3, '2025-05-24 05:06:46', '2025-05-24 05:06:46', NULL),
(26, 3, '2025-05-02', NULL, 9, 4, '2025-05-24 05:06:46', '2025-05-24 05:06:46', NULL),
(27, 3, '2025-05-02', NULL, 10, 3, '2025-05-24 05:06:46', '2025-05-24 05:06:46', NULL);

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
(23, '2025-05-01', 10, 1, 1, 150.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(24, '2025-05-01', 11, 2, 1, 80.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(25, '2025-05-01', 11, 2, 3, 300.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(26, '2025-05-01', 11, 2, 4, 20.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(27, '2025-05-01', 12, 6, 1, 40.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(28, '2025-05-01', 12, 6, 3, 150.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(29, '2025-05-01', 12, 6, 5, 20.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(30, '2025-05-01', 13, 4, 7, 200.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(31, '2025-05-01', 13, 4, 3, 720.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(32, '2025-05-01', 13, 4, 4, 60.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(33, '2025-05-01', 14, 5, 9, 3.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(34, '2025-05-01', 14, 5, 3, 300.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(35, '2025-05-01', 14, 5, 8, 300.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(36, '2025-05-01', 15, 7, 10, 10.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(37, '2025-05-01', 15, 7, 4, 20.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(38, '2025-05-01', 15, 7, 8, 100.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(39, '2025-05-01', 16, 8, 11, 12.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(40, '2025-05-01', 16, 8, 12, 180.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(41, '2025-05-01', 17, 9, 2, 120.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(42, '2025-05-01', 17, 9, 8, 300.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(43, '2025-05-01', 18, 10, 13, 25.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(44, '2025-05-01', 18, 10, 8, 500.000, NULL, '2025-05-24 05:01:09', '2025-05-24 05:01:09'),
(45, '2025-05-02', 19, 1, 1, 250.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(46, '2025-05-02', 20, 2, 1, 120.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(47, '2025-05-02', 20, 2, 3, 450.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(48, '2025-05-02', 20, 2, 4, 30.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(49, '2025-05-02', 21, 3, 6, 60.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(50, '2025-05-02', 21, 3, 3, 400.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(51, '2025-05-02', 22, 4, 7, 250.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(52, '2025-05-02', 22, 4, 3, 900.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(53, '2025-05-02', 22, 4, 4, 75.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(54, '2025-05-02', 23, 5, 9, 4.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(55, '2025-05-02', 23, 5, 3, 400.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(56, '2025-05-02', 23, 5, 8, 400.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(57, '2025-05-02', 24, 7, 10, 25.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(58, '2025-05-02', 24, 7, 4, 50.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(59, '2025-05-02', 24, 7, 8, 250.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(60, '2025-05-02', 25, 8, 11, 6.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(61, '2025-05-02', 25, 8, 12, 90.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(62, '2025-05-02', 26, 9, 2, 160.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(63, '2025-05-02', 26, 9, 8, 400.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(64, '2025-05-02', 27, 10, 13, 15.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46'),
(65, '2025-05-02', 27, 10, 8, 300.000, NULL, '2025-05-24 05:06:46', '2025-05-24 05:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(72) NOT NULL,
  `role` enum('OWNER','MANAJER','STAF') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `wa_api_token` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `wa_api_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Abida Amalia Syifa', 'abidaams@gmail.com', '2025-05-24 03:44:28', '$2y$10$9ICOM0sLYIHqleDvEEOAQ.7r1JCCQv2cKDpXab0m.LOzeGJqo1SCG', 'OWNER', '3BHpGP5kkAZFwRP8g8zUxB3nsIx2YlFzLh5OgqVfI249AWkavUl881AYrsNL', NULL, '2025-05-24 03:44:28', '2025-05-24 03:44:28', NULL),
(2, 'Rendy Hartono Putra', 'rendi45hp@gmail.com', '2025-05-24 04:17:21', '$2y$10$X0j3.HKJEktkkUzlxuhbiuvAVExr4B3lPa0N5lga6hBBqrimkqSsy', 'MANAJER', '4ZCFufCOel6qP8BSrp05LiTozBM8ntYa38Hcli7BOq2PZhhDmXPHkncDmT8x', '49zbRGa16VLm8S44vT5E', '2025-05-24 04:17:21', '2025-05-26 06:59:27', NULL),
(3, 'Maritza Septiarini', 'maritzaseptiarini@gmail.com', '2025-05-24 04:53:03', '$2y$10$G7XvoR/XpdUoBi2EyKDsputGdAPmv5oNawsb7hMqcPEW4WYbmboSC', 'STAF', NULL, NULL, '2025-05-24 04:53:03', '2025-05-24 04:53:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(18) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('L','P') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `phone`, `address`, `birth_date`, `gender`, `created_at`, `updated_at`) VALUES
(1, 1, '62812260', NULL, NULL, 'P', '2025-05-24 03:44:28', '2025-05-24 04:18:05'),
(2, 2, '6281226077106', NULL, NULL, NULL, '2025-05-24 04:17:21', '2025-05-26 06:51:04'),
(3, 3, NULL, NULL, NULL, NULL, '2025-05-24 04:53:03', '2025-05-24 04:53:03');

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
-- Dumping data for table `user_settings`
--

INSERT INTO `user_settings` (`id`, `user_id`, `settings`, `created_at`, `updated_at`) VALUES
(1, 1, '\"{\\\"show_image_bahan\\\":true,\\\"show_keterangan\\\":\\\"0\\\",\\\"show_awal\\\":\\\"1\\\",\\\"show_masuk\\\":\\\"1\\\",\\\"show_terpakai\\\":\\\"1\\\",\\\"show_sisa\\\":\\\"1\\\",\\\"show_akhir\\\":\\\"1\\\",\\\"show_terbuang\\\":\\\"1\\\",\\\"show_minimum\\\":\\\"0\\\",\\\"pagination_bahanBar\\\":\\\"20\\\",\\\"pagination_bahanKitchen\\\":\\\"20\\\"}\"', '2025-05-24 03:44:28', '2025-05-26 06:08:14'),
(2, 2, '\"{\\\"show_image_barang\\\":true,\\\"show_keteranganB\\\":\\\"0\\\",\\\"show_awalB\\\":\\\"1\\\",\\\"show_masukB\\\":\\\"1\\\",\\\"show_total_beliB\\\":\\\"0\\\",\\\"show_keluarB\\\":\\\"1\\\",\\\"show_sisaB\\\":\\\"1\\\",\\\"show_minimumB\\\":\\\"1\\\",\\\"pagination_barang\\\":20,\\\"filter_barang\\\":null,\\\"show_image_bahan2\\\":true,\\\"pagination_bahanBar2\\\":\\\"20\\\",\\\"pagination_bahanKitchen2\\\":\\\"20\\\",\\\"show_image_bahan\\\":true,\\\"show_keterangan\\\":\\\"0\\\",\\\"show_awal\\\":\\\"1\\\",\\\"show_masuk\\\":\\\"1\\\",\\\"show_terpakai\\\":\\\"1\\\",\\\"show_sisa\\\":\\\"1\\\",\\\"show_akhir\\\":\\\"1\\\",\\\"show_terbuang\\\":\\\"1\\\",\\\"show_minimum\\\":\\\"0\\\",\\\"pagination_bahanBar\\\":\\\"20\\\",\\\"pagination_bahanKitchen\\\":\\\"20\\\"}\"', '2025-05-24 04:17:21', '2025-05-24 04:51:47'),
(3, 3, '\"{\\\"show_image_bahan\\\":true,\\\"show_keterangan\\\":\\\"0\\\",\\\"show_awal\\\":\\\"1\\\",\\\"show_masuk\\\":\\\"1\\\",\\\"show_terpakai\\\":\\\"1\\\",\\\"show_sisa\\\":\\\"1\\\",\\\"show_akhir\\\":\\\"1\\\",\\\"show_terbuang\\\":\\\"1\\\",\\\"show_minimum\\\":\\\"1\\\",\\\"pagination_bahanBar\\\":\\\"20\\\",\\\"pagination_bahanKitchen\\\":\\\"20\\\"}\"', '2025-05-24 04:53:03', '2025-05-24 05:05:26');

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
-- Indexes for table `set_api_tokens`
--
ALTER TABLE `set_api_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_alert_logs`
--
ALTER TABLE `stock_alert_logs`
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
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bahan_awals`
--
ALTER TABLE `bahan_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bahan_masuks`
--
ALTER TABLE `bahan_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bahan_stoks`
--
ALTER TABLE `bahan_stoks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `barang_awals`
--
ALTER TABLE `barang_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `barang_keluars`
--
ALTER TABLE `barang_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang_masuks`
--
ALTER TABLE `barang_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan_bahans`
--
ALTER TABLE `satuan_bahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `set_api_tokens`
--
ALTER TABLE `set_api_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_alert_logs`
--
ALTER TABLE `stock_alert_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `transaksi_details`
--
ALTER TABLE `transaksi_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
