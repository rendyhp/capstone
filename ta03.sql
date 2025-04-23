-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 08:05 PM
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
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
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

INSERT INTO `bahans` (`id`, `user_id`, `name`, `description`, `minimum`, `satuan_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Kopi Arabika', 'Kopi arabika (Coffea arabica), juga dikenal sebagai kopi arab, kopi semak arab, atau kopi gunung, adalah spesies dari genus Coffea.', 100.000, 1, NULL, '2025-04-21 21:41:14', '2025-04-21 21:41:14', NULL),
(2, 1, 'Kopi Robusta', 'Kopi robusta (Coffea canephora) merupakan keturunan beberapa spesies kopi yang tumbuh baik di ketinggian 400–700 mdpl, temperatur 21-24 °C.', 150.000, 1, NULL, '2025-04-21 21:42:19', '2025-04-21 21:42:19', NULL),
(3, 1, 'Susu Segar', 'Susu segar merupakan 100% susu murni perahan sapi berkualitas dan bermutu tinggi. Dikemas dalam 2 plastik yaitu plastik tebal luar dan plastik dalam.', 3000.000, 2, NULL, '2025-04-21 21:43:20', '2025-04-21 21:43:20', NULL),
(4, 1, 'Gula Pasir', 'Gula adalah suatu karbohidrat sederhana yang menjadi sumber energi dan komoditas perdagangan utama. Gula paling banyak diperdagangkan dalam bentuk kristal.', 500.000, 1, NULL, '2025-04-21 21:44:11', '2025-04-21 21:44:11', NULL),
(5, 1, 'Sirup Caramel', 'Sirup ini biasa digunakan untuk ditambahkan ke dalam minuman kopi, milkshake, susu dan bahkan sering juga digunakan untuk hiasan dessert es krim atau pudding. Rasa karamel yang khas dengan gula terbakar sangat cocok digunakan untuk minuman kopi bercampur susu.', 200.000, 2, NULL, '2025-04-21 21:45:15', '2025-04-21 21:45:15', NULL),
(6, 1, 'Matcha Powder', 'Beorganik Pure Matcha Powder / Bubuk Matcha Organik Murni Uji Matcha Jepang.', 50.000, 1, NULL, '2025-04-21 22:59:23', '2025-04-21 22:59:23', NULL),
(7, 1, 'Coklat Bubuk', 'Bubuk cokelat yang diambil dari biji kakao pilihan tanaman Indonesia.', 100.000, 1, NULL, '2025-04-21 23:01:00', '2025-04-21 23:01:00', NULL),
(8, 1, 'Es Batu', 'Es Batu Kristal', 2000.000, 1, NULL, '2025-04-21 23:02:07', '2025-04-21 23:02:07', NULL),
(9, 1, 'Mangga Segar', '-', 5.000, 4, NULL, '2025-04-21 23:02:59', '2025-04-23 10:18:57', NULL),
(10, 1, 'Strawberry Segar', '-', 7.000, 4, NULL, '2025-04-21 23:03:37', '2025-04-21 23:03:37', NULL),
(11, 1, 'Roti Tawar', 'Roti tawar dengan bahan premium yang terbuat dari telur, butter, gula dan tepung dan taburan raisin yang melimpah.', 12.000, 3, NULL, '2025-04-21 23:04:37', '2025-04-21 23:04:37', NULL),
(12, 1, 'Keju Cheddar', 'Keju Cheddar adalah keju yang relatif keras, berwarna kuning pucat hingga putih gading, dan kadang-kadang memiliki rasa yang kuat.', 300.000, 1, NULL, '2025-04-21 23:05:17', '2025-04-21 23:05:17', NULL),
(13, 1, 'Daun Mint', '-', 10.000, 3, NULL, '2025-04-21 23:07:57', '2025-04-21 23:07:57', NULL),
(14, 1, 'Air', '-', 0.000, 2, NULL, '2025-04-21 23:08:32', '2025-04-21 23:08:32', NULL),
(15, 1, 'Test 1 (ada)', '-', 0.000, 4, NULL, '2025-04-22 20:30:30', '2025-04-22 20:30:30', NULL),
(16, 1, 'Test 2 (deleted)', '-', 0.000, 4, NULL, '2025-04-22 20:30:46', '2025-04-22 20:30:53', '2025-04-22 20:30:53'),
(17, 1, 'Air Soda', '-', 200.000, 2, NULL, '2025-04-22 20:57:17', '2025-04-22 20:57:17', NULL),
(18, 1, 'TEST 23', 'AW', 0.000, 2, NULL, '2025-04-23 10:20:58', '2025-04-23 10:20:58', NULL);

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
(1, 1, '2025-04-22', 14, 0.000, '2025-04-22 21:47:59', '2025-04-22 21:47:59', NULL),
(2, 1, '2025-04-22', 14, 0.000, '2025-04-22 21:50:08', '2025-04-22 21:50:08', NULL),
(3, 1, '2025-04-22', 14, 0.000, '2025-04-22 21:52:13', '2025-04-22 21:52:13', NULL),
(4, 1, '2025-04-22', 17, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(5, 1, '2025-04-22', 7, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(6, 1, '2025-04-22', 13, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(7, 1, '2025-04-22', 8, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(8, 1, '2025-04-22', 4, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(9, 1, '2025-04-22', 12, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(10, 1, '2025-04-22', 1, 1000.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(11, 1, '2025-04-22', 2, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(12, 1, '2025-04-22', 9, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(13, 1, '2025-04-22', 6, 0.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(14, 1, '2025-04-22', 11, 0.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(15, 1, '2025-04-22', 5, 500.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(16, 1, '2025-04-22', 10, 0.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(17, 1, '2025-04-22', 3, 1000.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(18, 1, '2025-04-22', 15, 0.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(19, 1, '2025-04-23', 14, 0.000, '2025-04-22 21:58:36', '2025-04-22 21:58:36', NULL),
(20, 1, '2025-04-23', 17, 0.000, '2025-04-22 21:58:36', '2025-04-22 21:58:36', NULL),
(21, 1, '2025-04-23', 7, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(22, 1, '2025-04-23', 13, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(23, 1, '2025-04-23', 8, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(24, 1, '2025-04-23', 4, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(25, 1, '2025-04-23', 12, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(26, 1, '2025-04-23', 1, 1300.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(27, 1, '2025-04-23', 2, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(28, 1, '2025-04-23', 9, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(29, 1, '2025-04-23', 6, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(30, 1, '2025-04-23', 11, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(31, 1, '2025-04-23', 5, 400.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(32, 1, '2025-04-23', 10, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(33, 1, '2025-04-23', 3, 400.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(34, 1, '2025-04-23', 15, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL);

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
(1, 1, '2025-04-23', 14, NULL, 0.000, '2025-04-22 21:52:13', '2025-04-22 21:52:13', NULL),
(2, 1, '2025-04-23', 17, NULL, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(3, 1, '2025-04-23', 7, NULL, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(4, 1, '2025-04-23', 13, NULL, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(5, 1, '2025-04-23', 8, NULL, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(6, 1, '2025-04-23', 4, NULL, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(7, 1, '2025-04-23', 12, NULL, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(8, 1, '2025-04-23', 1, NULL, 1000.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(9, 1, '2025-04-23', 2, NULL, 0.000, '2025-04-22 21:52:14', '2025-04-22 21:52:14', NULL),
(10, 1, '2025-04-23', 9, NULL, 0.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(11, 1, '2025-04-23', 6, NULL, 0.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(12, 1, '2025-04-23', 11, NULL, 0.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(13, 1, '2025-04-23', 5, NULL, 500.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(14, 1, '2025-04-23', 10, NULL, 0.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(15, 1, '2025-04-23', 3, NULL, 1000.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(16, 1, '2025-04-23', 15, NULL, 0.000, '2025-04-22 21:52:15', '2025-04-22 21:52:15', NULL),
(17, 1, '2025-04-24', 14, NULL, 0.000, '2025-04-22 21:58:36', '2025-04-22 21:58:36', NULL),
(18, 1, '2025-04-24', 17, NULL, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(19, 1, '2025-04-24', 7, NULL, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(20, 1, '2025-04-24', 13, NULL, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(21, 1, '2025-04-24', 8, NULL, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(22, 1, '2025-04-24', 4, NULL, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(23, 1, '2025-04-24', 12, NULL, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(24, 1, '2025-04-24', 1, NULL, 1300.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(25, 1, '2025-04-24', 2, NULL, 0.000, '2025-04-22 21:58:37', '2025-04-22 21:58:37', NULL),
(26, 1, '2025-04-24', 9, NULL, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(27, 1, '2025-04-24', 6, NULL, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(28, 1, '2025-04-24', 11, NULL, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(29, 1, '2025-04-24', 5, NULL, 400.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(30, 1, '2025-04-24', 10, NULL, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(31, 1, '2025-04-24', 3, NULL, 400.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL),
(32, 1, '2025-04-24', 15, NULL, 0.000, '2025-04-22 21:58:38', '2025-04-22 21:58:38', NULL);

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

--
-- Dumping data for table `bahan_keluars`
--

INSERT INTO `bahan_keluars` (`id`, `user_id`, `date`, `bahan_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-04-23', 1, 'Terpakai', 30.000, '2025-04-23 17:47:19', '2025-04-23 17:47:19', NULL);

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
(1, 1, '2025-04-23', 1, NULL, 500.000, '2025-04-22 21:57:08', '2025-04-22 21:57:08', NULL),
(2, 1, '2025-04-23', 14, NULL, 50.000, '2025-04-22 23:06:49', '2025-04-22 23:06:49', NULL);

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

INSERT INTO `barangs` (`id`, `user_id`, `name`, `description`, `jumlah`, `satuan_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Piring', 'Piring bagus ini\r\n.', 33, 1, NULL, '2025-04-22 23:57:16', '2025-04-23 00:03:50', NULL),
(2, 1, 'Gelas', 'Gelas bagus', 10, 1, NULL, '2025-04-23 08:20:33', '2025-04-23 11:00:36', NULL);

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
(1, 1, 1, '2025-04-23', '15 Piring pecah saat storing barang.', 15, '2025-04-23 08:25:06', '2025-04-23 08:25:06', NULL),
(2, 1, 2, '2025-04-23', NULL, 15, '2025-04-23 08:45:01', '2025-04-23 08:45:01', NULL);

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
(1, 2, '2025-04-23', 1, 'Beli piring baru.', 10, '2025-04-23 08:23:11', '2025-04-23 08:23:11', NULL),
(2, 1, '2025-04-23', 1, 'Dapat piring dikasih.', 2, '2025-04-23 08:23:11', '2025-04-23 08:23:11', NULL),
(3, 1, '2025-04-23', 2, NULL, 20, '2025-04-23 08:38:18', '2025-04-23 08:38:18', NULL);

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
(1, 1, 1, 50.000, '2025-04-22 20:24:38', '2025-04-22 20:24:38', NULL),
(2, 1, 14, 200.000, '2025-04-22 20:24:38', '2025-04-22 20:24:38', NULL),
(3, 2, 1, 40.000, '2025-04-22 20:35:04', '2025-04-22 20:35:04', NULL),
(4, 2, 3, 150.000, '2025-04-22 20:35:04', '2025-04-22 20:35:04', NULL),
(5, 2, 4, 10.000, '2025-04-22 20:35:04', '2025-04-22 20:35:04', NULL),
(6, 3, 1, 40.000, '2025-04-22 20:36:11', '2025-04-22 20:36:11', NULL),
(7, 3, 3, 150.000, '2025-04-22 20:36:11', '2025-04-22 20:36:11', NULL),
(8, 3, 5, 20.000, '2025-04-22 20:36:11', '2025-04-22 20:36:11', NULL),
(9, 4, 6, 30.000, '2025-04-22 20:40:53', '2025-04-22 20:40:53', NULL),
(10, 4, 3, 200.000, '2025-04-22 20:40:54', '2025-04-22 20:40:54', NULL),
(11, 5, 7, 50.000, '2025-04-22 20:42:28', '2025-04-22 20:42:28', NULL),
(12, 5, 3, 180.000, '2025-04-22 20:42:28', '2025-04-22 20:42:28', NULL),
(13, 5, 4, 15.000, '2025-04-22 20:42:28', '2025-04-22 20:42:28', NULL),
(14, 6, 9, 1.000, '2025-04-22 20:44:14', '2025-04-22 20:44:14', NULL),
(15, 6, 3, 100.000, '2025-04-22 20:44:14', '2025-04-22 20:44:14', NULL),
(16, 6, 8, 100.000, '2025-04-22 20:44:14', '2025-04-22 20:44:14', NULL),
(17, 7, 10, 5.000, '2025-04-22 20:45:08', '2025-04-22 20:45:08', NULL),
(18, 7, 4, 10.000, '2025-04-22 20:45:08', '2025-04-22 20:45:08', NULL),
(19, 7, 8, 50.000, '2025-04-22 20:45:08', '2025-04-22 20:45:08', NULL),
(20, 8, 11, 2.000, '2025-04-22 20:46:46', '2025-04-22 20:46:46', NULL),
(21, 8, 12, 30.000, '2025-04-22 20:46:47', '2025-04-22 20:46:47', NULL),
(22, 9, 2, 40.000, '2025-04-22 20:50:16', '2025-04-22 20:50:16', NULL),
(23, 9, 14, 20.000, '2025-04-22 20:50:16', '2025-04-22 20:50:16', NULL),
(24, 9, 8, 100.000, '2025-04-22 20:50:16', '2025-04-22 20:50:16', NULL),
(25, 10, 13, 5.000, '2025-04-22 20:58:06', '2025-04-22 20:58:06', NULL),
(26, 10, 17, 200.000, '2025-04-22 20:58:06', '2025-04-22 20:58:06', NULL),
(27, 10, 8, 100.000, '2025-04-22 20:58:06', '2025-04-22 20:58:06', NULL);

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
(1, 1, 'Espresso', 'Espreso adalah jenis kopi yang dihasilkan dengan mengekstraksi biji kopi yang sudah digiling dengan menyemburkan air panas di bawah tekanan tinggi.', NULL, '2025-04-21 23:35:51', '2025-04-22 20:24:38', NULL),
(2, 1, 'Cappucino', 'Kapucino (dari bahasa Italia: cappuccino) adalah minuman kopi khas Italia yang dibuat dari espreso dan susu.', NULL, '2025-04-22 20:35:04', '2025-04-22 20:35:04', NULL),
(3, 1, 'Caramel Latte', 'Kopi caramel latte dan caramel macchiato sama-sama hidangan kopi susu. Bedanya, kopi caramel latte mengandung susu lebih banyak, yaitu sekitar ¾ cup.', NULL, '2025-04-22 20:36:11', '2025-04-22 20:36:11', NULL),
(4, 1, 'Matcha Latte', 'Matcha Latte memiliki karakter rasa umami, sedikit rasa pahit dan aroma lembut khas teh hijau.', NULL, '2025-04-22 20:40:53', '2025-04-22 20:40:53', NULL),
(5, 1, 'Hot Chocolate', 'Hot Chocolate adalah minuman panas yang dibuat dari cokelat atau kakao bubuk dan gula, dengan air atau susu hangat.', NULL, '2025-04-22 20:42:28', '2025-04-22 20:42:28', NULL),
(6, 1, 'Mango Smoothie', 'Rasa Mango Smoothies yang segar sekaligus melekat di setiap puff nya. Flavor American Fruity sudah melalui berbagai proses penyempurnaan.', NULL, '2025-04-22 20:44:14', '2025-04-22 20:44:14', NULL),
(7, 1, 'Strawberry Juice', 'Strawberry Juice is a refreshing fresh fruit juice that is full of vitamin C and antioxidants and lot of invigorating flavor.', NULL, '2025-04-22 20:45:08', '2025-04-22 20:45:08', NULL),
(8, 1, 'Cheese Toast', 'Roti ini difermentasi total lebih dari 18 jam, sehingga rasa jadi jauh lebih enak daripada roti industri yang diproses kilat, kadang hanya 1 jam .', NULL, '2025-04-22 20:46:46', '2025-04-22 20:46:46', NULL),
(9, 1, 'Iced Americano', 'Espresso shots topped with cold water produce a light layer of crema, then served over ice. The result: a wonderfully rich cup with depth and nuance.', NULL, '2025-04-22 20:50:16', '2025-04-22 20:50:16', NULL),
(10, 1, 'Mint Mojito', 'Mix this classic cocktail for a party using fresh mint, white rum, sugar, zesty lime and cooling soda water. Play with the quantities to suit your taste.', NULL, '2025-04-22 20:58:06', '2025-04-22 20:58:06', NULL);

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
(16, '2025_04_22_000130_create_barang_masuks_table', 1),
(17, '2025_04_22_000140_create_barang_keluars_table', 1),
(18, '2025_04_22_000210_create_menus_table', 1),
(19, '2025_04_22_000220_create_komposisi_menus_table', 1),
(20, '2025_04_22_000310_create_transaksis_table', 1),
(21, '2025_04_22_000320_create_transaksi_details_table', 1),
(22, '2025_04_22_900010_create_temporary_files_table', 1),
(23, '2025_04_22_900020_create_deleted_items_table', 1),
(24, '2025_04_22_900029_create_tag_notifikasis_table', 1),
(25, '2025_04_22_900030_create_notifikasis_table', 1),
(26, '2025_04_22_900040_create_log_activities_table', 1);

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
(1, 2, 'gram', '2025-04-22 04:36:31', '2025-04-22 04:36:31', NULL),
(2, 2, 'mL', '2025-04-22 04:36:31', '2025-04-22 04:36:31', NULL),
(3, 2, 'lembar', '2025-04-22 04:37:43', '2025-04-22 04:37:43', NULL),
(4, 1, 'buah', '2025-04-22 04:37:43', '2025-04-23 09:21:48', NULL),
(5, 2, 'kg', '2025-04-22 04:39:26', '2025-04-22 04:39:26', NULL);

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
(1, 1, 'Pcs', '2025-04-23 06:47:00', '2025-04-23 06:47:00', NULL),
(2, 1, '-', '2025-04-23 00:34:36', '2025-04-23 00:43:40', NULL);

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
  `jumlah` decimal(15,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `user_id`, `date`, `menu_name`, `menu_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-04-23', NULL, 1, 3.000, '2025-04-22 21:00:03', '2025-04-22 21:00:03', NULL),
(2, 1, '2025-04-23', NULL, 2, 2.000, '2025-04-22 21:14:51', '2025-04-22 21:14:51', NULL),
(4, 1, '2025-04-23', NULL, 5, 4.000, '2025-04-22 21:17:23', '2025-04-22 21:17:23', NULL),
(5, 1, '2025-04-23', NULL, 6, 3.000, '2025-04-22 21:17:43', '2025-04-22 21:17:43', NULL),
(6, 1, '2025-04-23', NULL, 7, 2.000, '2025-04-22 21:17:59', '2025-04-22 21:17:59', NULL),
(7, 1, '2025-04-23', NULL, 8, 6.000, '2025-04-22 21:20:45', '2025-04-22 21:20:45', NULL),
(8, 1, '2025-04-23', NULL, 9, 3.000, '2025-04-22 21:21:06', '2025-04-22 21:21:06', NULL),
(9, 1, '2025-04-23', NULL, 10, 5.000, '2025-04-22 21:21:16', '2025-04-22 21:21:16', NULL),
(10, 1, '2025-04-23', NULL, 2, 3.000, '2025-04-22 21:37:33', '2025-04-22 21:37:33', NULL),
(16, 1, '2025-04-23', NULL, 3, 4.000, '2025-04-22 21:44:13', '2025-04-22 21:44:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_details`
--

CREATE TABLE `transaksi_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` double NOT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi_details`
--

INSERT INTO `transaksi_details` (`id`, `transaksi_id`, `menu_id`, `bahan_id`, `jumlah`, `satuan`, `created_at`, `updated_at`) VALUES
(1, 16, NULL, 1, 160, NULL, '2025-04-22 21:44:13', '2025-04-22 21:44:13'),
(2, 16, NULL, 3, 600, NULL, '2025-04-22 21:44:13', '2025-04-22 21:44:13'),
(3, 16, NULL, 5, 80, NULL, '2025-04-22 21:44:13', '2025-04-22 21:44:13');

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
(1, 'Rendy Hartono Putra', 'rendy12', 'rendy12@gmail.com', '2025-04-21 20:54:52', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OWNER', '0Ph88ibMostAGlS8b1LmEfs7EiWcUxL7CLDmICTeAr9gRLf7kklLLUQbPMFO', '2025-04-21 20:54:52', '2025-04-21 20:54:52', NULL),
(2, 'Maritza Septiarini', 'maritza12', 'maritza12@gmail.com', '2025-04-21 20:54:54', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MANAJER', 'jT0MdSOWXUkkraGDrB95JQQouUYnihvx0gdKNVX4xLFKnZeJvS6nijxrPmle', '2025-04-21 20:54:54', '2025-04-21 20:54:54', NULL),
(3, 'Abida Amalia Syifa', 'abida12', 'abida12@gmail.com', '2025-04-21 20:54:56', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'STAF', '9Fl8k5380EKhPFQznqecKxJoNrLTxFOxV5E4qqFTv7t6byTHU9tu07XA2TLo', '2025-04-21 20:54:56', '2025-04-21 20:54:56', NULL);

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
  ADD KEY `transaksi_details_bahan_id_foreign` (`bahan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahans`
--
ALTER TABLE `bahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `bahan_awals`
--
ALTER TABLE `bahan_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `bahan_keluars`
--
ALTER TABLE `bahan_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bahan_masuks`
--
ALTER TABLE `bahan_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bahan_stoks`
--
ALTER TABLE `bahan_stoks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang_keluars`
--
ALTER TABLE `barang_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang_masuks`
--
ALTER TABLE `barang_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transaksi_details`
--
ALTER TABLE `transaksi_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
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
  ADD CONSTRAINT `transaksi_details_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
