-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Bulan Mei 2025 pada 06.51
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
-- Database: `ta03`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahans`
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
-- Dumping data untuk tabel `bahans`
--

INSERT INTO `bahans` (`id`, `user_id`, `name`, `description`, `section`, `minimum`, `satuan_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(17, 2, 'Susu UHT', 'Indomilk', 'BAR', 3000.000, 1, NULL, '2025-05-16 08:39:05', '2025-05-16 08:39:05', NULL),
(18, 2, 'Kopi Espresso', 'Espresso KNK', 'BAR', 500.000, 1, NULL, '2025-05-16 08:40:26', '2025-05-16 08:40:26', NULL),
(19, 2, 'Evaporasi', 'Sunbay, Carnation', 'BAR', 500.000, 1, NULL, '2025-05-16 08:42:05', '2025-05-16 08:42:05', NULL),
(20, 2, 'Consentrate Mangga', 'Toza', 'BAR', 500.000, 1, NULL, '2025-05-16 08:43:12', '2025-05-16 08:43:12', NULL),
(21, 2, 'Consentrate Lemon', 'Toza', 'BAR', 500.000, 1, NULL, '2025-05-16 08:44:09', '2025-05-16 08:44:09', NULL),
(22, 1, 'Brown Sugar', 'Boskaf', 'BAR', 1000.000, 1, NULL, '2025-05-16 08:44:37', '2025-05-20 06:59:56', NULL),
(23, 2, 'Sirup Hazelnut', 'Tofico', 'BAR', 500.000, 1, NULL, '2025-05-16 08:45:27', '2025-05-16 08:45:27', NULL),
(24, 2, 'Sirup Caramel', 'Tofico', 'BAR', 500.000, 1, NULL, '2025-05-16 08:46:06', '2025-05-16 08:46:06', NULL),
(25, 2, 'Sirup Mint', 'Tofico', 'BAR', 500.000, 1, NULL, '2025-05-16 08:46:36', '2025-05-16 08:46:36', NULL),
(26, 2, 'Sirup Lychee', 'Tofico', 'BAR', 500.000, 1, NULL, '2025-05-16 08:47:06', '2025-05-16 08:47:06', NULL),
(27, 2, 'Soda', 'Fanta', 'BAR', 2.000, 7, NULL, '2025-05-16 08:48:03', '2025-05-16 08:48:03', NULL),
(28, 1, 'Yakult', 'Yakult', 'BAR', 1000.000, 7, NULL, '2025-05-16 08:48:32', '2025-05-20 07:01:19', NULL),
(29, 2, 'Kopi Blend 70:30', 'Depangi', 'BAR', 300.000, 4, NULL, '2025-05-16 08:49:26', '2025-05-16 08:49:35', NULL),
(30, 2, 'Chocolate Powder', 'Bromo', 'BAR', 300.000, 4, NULL, '2025-05-16 08:50:47', '2025-05-16 08:50:47', NULL),
(31, 2, 'Matcha Powder', 'Tofico', 'BAR', 300.000, 4, NULL, '2025-05-16 08:51:21', '2025-05-16 08:51:21', NULL),
(32, 2, 'Gula Pasir', '-', 'BAR', 1000.000, 4, NULL, '2025-05-16 08:53:27', '2025-05-16 08:53:27', NULL),
(33, 1, 'Cabe biasa', '-', 'KITCHEN', 800.000, 4, NULL, '2025-05-19 16:04:20', '2025-05-20 06:03:46', NULL),
(34, 1, 'Cabe pedas', '-', 'KITCHEN', 300.000, 4, NULL, '2025-05-19 16:04:30', '2025-05-20 06:03:52', NULL),
(35, 1, 'Bawang Bombay', '-', 'KITCHEN', 50.000, 4, NULL, '2025-05-20 05:56:09', '2025-05-20 06:03:41', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_akhirs`
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
-- Dumping data untuk tabel `bahan_akhirs`
--

INSERT INTO `bahan_akhirs` (`id`, `user_id`, `date`, `bahan_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(109, 2, '2025-05-01', 30, 1000.000, '2025-05-16 10:03:42', '2025-05-16 10:03:42', NULL),
(110, 2, '2025-05-01', 21, 1000.000, '2025-05-16 10:03:46', '2025-05-16 10:03:46', NULL),
(111, 2, '2025-05-01', 20, 900.000, '2025-05-16 10:03:50', '2025-05-16 10:03:50', NULL),
(112, 2, '2025-05-01', 19, 750.000, '2025-05-16 10:03:55', '2025-05-16 10:03:55', NULL),
(113, 2, '2025-05-01', 32, 1000.000, '2025-05-16 10:04:00', '2025-05-16 10:04:00', NULL),
(114, 2, '2025-05-01', 29, 1000.000, '2025-05-16 10:04:03', '2025-05-16 10:04:03', NULL),
(115, 2, '2025-05-01', 18, 790.000, '2025-05-16 10:04:07', '2025-05-16 10:04:07', NULL),
(116, 2, '2025-05-01', 31, 955.000, '2025-05-16 10:04:11', '2025-05-16 10:04:11', NULL),
(117, 2, '2025-05-01', 24, 1000.000, '2025-05-16 10:04:15', '2025-05-16 10:04:15', NULL),
(118, 2, '2025-05-01', 23, 1000.000, '2025-05-16 10:04:19', '2025-05-16 10:04:19', NULL),
(119, 2, '2025-05-01', 26, 1000.000, '2025-05-16 10:04:23', '2025-05-16 10:04:23', NULL),
(120, 2, '2025-05-01', 25, 1000.000, '2025-05-16 10:04:26', '2025-05-16 10:04:26', NULL),
(121, 2, '2025-05-01', 27, 1000.000, '2025-05-16 10:04:30', '2025-05-16 10:04:30', NULL),
(122, 2, '2025-05-01', 17, 8750.000, '2025-05-16 10:04:35', '2025-05-16 10:04:35', NULL),
(124, 2, '2025-05-10', 22, 775.000, '2025-05-16 10:08:26', '2025-05-16 10:08:26', NULL),
(125, 2, '2025-05-10', 30, 1000.000, '2025-05-16 10:08:30', '2025-05-16 10:08:30', NULL),
(126, 2, '2025-05-10', 21, 1000.000, '2025-05-16 10:08:48', '2025-05-16 10:08:48', NULL),
(127, 2, '2025-05-10', 20, 880.000, '2025-05-16 10:08:54', '2025-05-16 10:08:54', NULL),
(128, 2, '2025-05-10', 19, 500.000, '2025-05-16 10:08:57', '2025-05-16 10:08:57', NULL),
(129, 2, '2025-05-10', 32, 1000.000, '2025-05-16 10:09:01', '2025-05-16 10:09:01', NULL),
(130, 2, '2025-05-10', 29, 1000.000, '2025-05-16 10:09:05', '2025-05-16 10:09:05', NULL),
(131, 2, '2025-05-10', 18, 550.000, '2025-05-16 10:09:09', '2025-05-16 10:09:09', NULL),
(132, 2, '2025-05-10', 31, 925.000, '2025-05-16 10:09:16', '2025-05-16 10:09:16', NULL),
(133, 2, '2025-05-10', 24, 1000.000, '2025-05-16 10:09:20', '2025-05-16 10:09:20', NULL),
(134, 2, '2025-05-10', 23, 1000.000, '2025-05-16 10:09:25', '2025-05-16 10:09:25', NULL),
(135, 2, '2025-05-10', 26, 1000.000, '2025-05-16 10:09:32', '2025-05-16 10:09:32', NULL),
(136, 2, '2025-05-10', 25, 1000.000, '2025-05-16 10:09:37', '2025-05-16 10:09:37', NULL),
(137, 2, '2025-05-10', 27, 1000.000, '2025-05-16 10:09:41', '2025-05-16 10:09:41', NULL),
(138, 2, '2025-05-10', 17, 7700.000, '2025-05-16 10:09:46', '2025-05-16 10:09:46', NULL),
(139, 2, '2025-05-10', 28, 988.000, '2025-05-16 10:09:50', '2025-05-16 10:09:50', NULL),
(140, 2, '2025-05-31', 22, 725.000, '2025-05-16 10:17:47', '2025-05-16 10:17:47', NULL),
(141, 2, '2025-05-31', 30, 1000.000, '2025-05-16 10:17:51', '2025-05-16 10:17:51', NULL),
(142, 2, '2025-05-31', 21, 1000.000, '2025-05-16 10:17:55', '2025-05-16 10:17:55', NULL),
(143, 2, '2025-05-31', 20, 840.000, '2025-05-16 10:18:00', '2025-05-16 10:18:00', NULL),
(144, 2, '2025-05-31', 19, 350.000, '2025-05-16 10:18:05', '2025-05-16 10:18:05', NULL),
(145, 2, '2025-05-31', 32, 1000.000, '2025-05-16 10:18:09', '2025-05-16 10:18:09', NULL),
(146, 2, '2025-05-31', 29, 1000.000, '2025-05-16 10:18:13', '2025-05-16 10:18:13', NULL),
(147, 2, '2025-05-31', 18, 430.000, '2025-05-16 10:18:18', '2025-05-16 10:18:18', NULL),
(148, 2, '2025-05-31', 31, 895.000, '2025-05-16 10:18:22', '2025-05-16 10:18:22', NULL),
(149, 2, '2025-05-31', 24, 1000.000, '2025-05-16 10:18:26', '2025-05-16 10:18:26', NULL),
(150, 2, '2025-05-31', 23, 1000.000, '2025-05-16 10:18:29', '2025-05-16 10:18:29', NULL),
(151, 2, '2025-05-31', 26, 1000.000, '2025-05-16 10:18:32', '2025-05-16 10:18:32', NULL),
(152, 2, '2025-05-31', 25, 1000.000, '2025-05-16 10:18:36', '2025-05-16 10:18:36', NULL),
(153, 2, '2025-05-31', 27, 1000.000, '2025-05-16 10:18:40', '2025-05-16 10:18:40', NULL),
(154, 2, '2025-05-31', 17, 7000.000, '2025-05-16 10:18:45', '2025-05-16 10:18:45', NULL),
(155, 2, '2025-05-31', 28, 984.000, '2025-05-16 10:18:49', '2025-05-16 10:18:49', NULL),
(156, 1, '2025-05-01', 33, 1400.000, '2025-05-19 16:05:21', '2025-05-19 16:05:21', NULL),
(158, 1, '2025-05-01', 28, 990.000, '2025-05-20 05:48:58', '2025-05-20 05:48:58', NULL),
(160, 1, '2025-05-01', 22, 1920.000, '2025-05-20 05:53:34', '2025-05-20 05:53:34', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_awals`
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
-- Dumping data untuk tabel `bahan_awals`
--

INSERT INTO `bahan_awals` (`id`, `user_id`, `date`, `bahan_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(68, 2, '2025-05-01', 22, NULL, 1000.000, '2025-05-16 09:46:01', '2025-05-16 09:46:01', NULL),
(69, 2, '2025-05-01', 30, NULL, 1000.000, '2025-05-16 09:46:06', '2025-05-16 09:46:06', NULL),
(70, 2, '2025-05-01', 21, NULL, 1000.000, '2025-05-16 09:46:12', '2025-05-16 09:46:12', NULL),
(71, 2, '2025-05-01', 20, NULL, 1000.000, '2025-05-16 09:46:19', '2025-05-16 09:46:19', NULL),
(72, 2, '2025-05-01', 19, NULL, 1000.000, '2025-05-16 09:46:24', '2025-05-16 09:46:24', NULL),
(73, 2, '2025-05-01', 32, NULL, 1000.000, '2025-05-16 09:46:29', '2025-05-16 09:46:29', NULL),
(74, 2, '2025-05-01', 29, NULL, 1000.000, '2025-05-16 09:46:35', '2025-05-16 09:46:35', NULL),
(75, 2, '2025-05-01', 18, NULL, 1000.000, '2025-05-16 09:46:40', '2025-05-16 09:46:40', NULL),
(76, 2, '2025-05-01', 31, NULL, 1000.000, '2025-05-16 09:46:45', '2025-05-16 09:46:45', NULL),
(77, 2, '2025-05-01', 24, NULL, 1000.000, '2025-05-16 09:46:50', '2025-05-16 09:46:50', NULL),
(78, 2, '2025-05-01', 23, NULL, 1000.000, '2025-05-16 09:46:57', '2025-05-16 09:46:57', NULL),
(79, 2, '2025-05-01', 26, NULL, 1000.000, '2025-05-16 09:47:02', '2025-05-16 09:47:02', NULL),
(80, 2, '2025-05-01', 25, NULL, 1000.000, '2025-05-16 09:47:07', '2025-05-16 09:47:07', NULL),
(81, 2, '2025-05-01', 27, NULL, 1000.000, '2025-05-16 09:47:14', '2025-05-16 09:47:14', NULL),
(83, 2, '2025-05-01', 17, NULL, 10000.000, '2025-05-16 09:47:25', '2025-05-16 09:47:25', NULL),
(84, 2, '2025-05-01', 28, NULL, 1000.000, '2025-05-16 09:47:30', '2025-05-16 09:47:30', NULL),
(86, 2, '2025-06-01', 22, NULL, 725.000, '2025-05-16 10:19:23', '2025-05-16 10:19:23', NULL),
(87, 1, '2025-05-01', 33, NULL, 1000.000, '2025-05-19 16:04:45', '2025-05-19 16:04:45', NULL),
(88, 1, '2025-05-01', 34, NULL, 1000.000, '2025-05-19 16:04:49', '2025-05-19 16:04:49', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_masuks`
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
-- Dumping data untuk tabel `bahan_masuks`
--

INSERT INTO `bahan_masuks` (`id`, `user_id`, `date`, `bahan_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 1, '2025-05-01', 33, 'Cash', 500.000, '2025-05-19 16:05:03', '2025-05-19 16:05:03', NULL),
(10, 1, '2025-05-19', 28, '-', 200.000, '2025-05-19 16:31:45', '2025-05-19 16:31:45', NULL),
(11, 1, '2025-05-19', 34, 'Cash', 500.000, '2025-05-19 16:32:31', '2025-05-19 16:32:31', NULL),
(12, 1, '2025-05-19', 34, 'Cash', 500.000, '2025-05-19 16:32:31', '2025-05-19 16:32:31', NULL),
(13, 1, '2025-05-01', 22, 'Cash', 500.000, '2025-05-20 05:39:27', '2025-05-20 05:39:27', NULL),
(14, 1, '2025-05-01', 28, 'cash', 2.000, '2025-05-20 05:44:13', '2025-05-20 05:44:13', NULL),
(15, 1, '2025-05-20', 27, 'cash', 2.000, '2025-05-20 05:44:48', '2025-05-20 05:44:48', NULL),
(16, 1, '2025-05-20', 17, 'cash', 200.000, '2025-05-20 05:46:08', '2025-05-20 05:46:08', NULL),
(17, 1, '2025-05-01', 22, 'cash', 555.000, '2025-05-20 05:53:06', '2025-05-20 05:53:06', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `stok_awal` int(12) NOT NULL,
  `minimum` int(12) NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barangs`
--

INSERT INTO `barangs` (`id`, `user_id`, `date`, `name`, `description`, `stok_awal`, `minimum`, `satuan_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-05-05', 'Piring', 'Piring baru', 20, 0, 2, 'upload/barang/1746413436.jpg', '2025-05-04 19:50:36', '2025-05-04 19:50:36', NULL),
(2, 1, '2025-05-05', 'Gelas Kecil', '-', 12, 0, 2, 'upload/barang/1746413584.jpg', '2025-05-04 19:53:04', '2025-05-04 19:53:04', NULL),
(3, 1, '2025-05-05', 'Gelas Besar', '-', 20, 0, 2, 'upload/barang/1746413997.webp', '2025-05-04 19:59:57', '2025-05-20 04:48:07', NULL),
(4, 1, '2025-05-05', 'Meja Kafe', 'Meja baru', 10, 0, 2, 'upload/barang/1746414173.jpg', '2025-05-04 20:02:53', '2025-05-04 20:02:53', NULL),
(5, 1, '2025-05-05', 'Kursi Kafe', '-', 20, 0, 2, 'upload/barang/1746414367.webp', '2025-05-04 20:06:07', '2025-05-04 20:06:07', NULL),
(6, 1, '2025-05-15', 'Mangkok', '-', 10, 20, 2, NULL, '2025-05-15 00:13:13', '2025-05-20 07:04:25', NULL),
(7, 1, '2025-01-15', 'mangkok besar', '-', 5, 5, 2, NULL, '2025-05-15 00:57:31', '2025-05-20 04:39:13', NULL),
(8, 1, '2025-05-19', 'Sendok', '-', 20, 15, 2, NULL, '2025-05-19 16:52:38', '2025-05-20 04:48:13', NULL),
(9, 1, '2025-05-20', 'Garpu', '-', 12, 15, 2, NULL, '2025-05-20 04:12:48', '2025-05-20 06:54:56', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_awals`
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
-- Dumping data untuk tabel `barang_awals`
--

INSERT INTO `barang_awals` (`id`, `user_id`, `date`, `barang_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-05-05', 1, 'Stok awal Piring', 20, '2025-05-04 19:50:36', '2025-05-04 19:50:36', NULL),
(2, 1, '2025-05-05', 2, 'Stok awal Gelas Kecil', 12, '2025-05-04 19:53:04', '2025-05-04 19:53:04', NULL),
(3, 1, '2025-05-05', 3, 'Stok awal Gelas Besar', 20, '2025-05-04 19:59:57', '2025-05-04 19:59:57', NULL),
(4, 1, '2025-05-05', 4, 'Stok awal Meja Kafe', 10, '2025-05-04 20:02:53', '2025-05-04 20:02:53', NULL),
(5, 1, '2025-05-05', 5, 'Stok awal Kursi Kafe', 20, '2025-05-04 20:06:07', '2025-05-04 20:06:07', NULL),
(6, 3, '2025-05-15', 6, 'Stok awal Mangkok', 10, '2025-05-15 00:13:13', '2025-05-15 00:13:13', NULL),
(7, 1, '2025-01-15', 7, 'Stok awal mangkok besar', 5, '2025-05-15 00:57:31', '2025-05-15 00:57:31', NULL),
(8, 1, '2025-05-19', 8, 'Stok awal Sendok', 20, '2025-05-19 16:52:38', '2025-05-19 16:52:38', NULL),
(10, 1, '2025-05-20', 9, 'Stok awal Garpu', 12, '2025-05-20 04:17:52', '2025-05-20 04:17:52', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluars`
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
-- Dumping data untuk tabel `barang_keluars`
--

INSERT INTO `barang_keluars` (`id`, `user_id`, `barang_id`, `date`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2, '2025-05-15', 'Gelas pecah', 3, '2025-05-15 00:34:38', '2025-05-15 00:34:38', NULL),
(2, 1, 7, '2025-05-14', 'pecah', 2, '2025-05-15 00:58:29', '2025-05-15 00:58:29', NULL),
(3, 1, 3, '2025-05-20', '-', 3, '2025-05-19 17:15:29', '2025-05-19 17:15:29', NULL),
(4, 1, 2, '2025-05-20', 'Gelas rusak', 2, '2025-05-20 04:19:57', '2025-05-20 04:19:57', NULL),
(5, 1, 2, '2025-05-20', 'Rusak', 2, '2025-05-20 04:20:40', '2025-05-20 04:20:40', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuks`
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
-- Dumping data untuk tabel `barang_masuks`
--

INSERT INTO `barang_masuks` (`id`, `user_id`, `date`, `barang_id`, `keterangan`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-05-05', 1, 'Beli lagi', 5, '2025-05-04 19:50:58', '2025-05-04 19:50:58', NULL),
(2, 1, '2025-05-15', 7, '-', 5, '2025-05-15 00:58:10', '2025-05-15 00:58:10', NULL),
(3, 1, '2025-05-20', 3, '-', 5, '2025-05-19 17:15:38', '2025-05-19 17:15:38', NULL),
(4, 1, '2025-05-20', 1, 'Beli cash', 2, '2025-05-20 04:19:34', '2025-05-20 04:19:34', NULL),
(5, 1, '2025-05-20', 2, 'Beli cash', 2, '2025-05-20 04:20:25', '2025-05-20 04:20:25', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `deleted_items`
--

CREATE TABLE `deleted_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `komposisi_menus`
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
-- Dumping data untuk tabel `komposisi_menus`
--

INSERT INTO `komposisi_menus` (`id`, `menu_id`, `bahan_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(24, 8, 19, 25.000, '2025-05-16 08:57:36', '2025-05-16 08:57:36', NULL),
(25, 8, 17, 100.000, '2025-05-16 08:57:36', '2025-05-16 08:57:36', NULL),
(26, 8, 18, 30.000, '2025-05-16 08:57:36', '2025-05-16 08:57:36', NULL),
(27, 9, 22, 25.000, '2025-05-16 08:58:41', '2025-05-16 08:58:41', NULL),
(28, 9, 19, 25.000, '2025-05-16 08:58:41', '2025-05-16 08:58:41', NULL),
(29, 9, 17, 100.000, '2025-05-16 08:58:41', '2025-05-16 08:58:41', NULL),
(30, 9, 18, 30.000, '2025-05-16 08:58:41', '2025-05-16 08:58:41', NULL),
(31, 10, 31, 15.000, '2025-05-16 09:00:09', '2025-05-16 09:00:09', NULL),
(32, 10, 19, 25.000, '2025-05-16 09:00:09', '2025-05-16 09:00:09', NULL),
(33, 10, 17, 100.000, '2025-05-16 09:00:09', '2025-05-16 09:00:09', NULL),
(34, 11, 28, 2.000, '2025-05-16 09:01:39', '2025-05-16 09:01:39', NULL),
(35, 11, 17, 50.000, '2025-05-16 09:01:39', '2025-05-16 09:01:39', NULL),
(36, 11, 20, 20.000, '2025-05-16 09:01:39', '2025-05-16 09:01:39', NULL),
(43, 13, 22, 23.000, '2025-05-20 06:46:40', '2025-05-20 06:46:40', NULL),
(44, 13, 22, 23.000, '2025-05-20 06:46:40', '2025-05-20 06:46:40', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_activities`
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
-- Struktur dari tabel `menus`
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
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id`, `user_id`, `name`, `description`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 2, 'Kopi Susu Original', 'ice', NULL, '2025-05-16 08:57:36', '2025-05-16 08:57:36', NULL),
(9, 2, 'Kopi Susu Gula Aren', 'ice', NULL, '2025-05-16 08:58:41', '2025-05-16 08:58:41', NULL),
(10, 2, 'Greentea Latte', 'ice', NULL, '2025-05-16 09:00:09', '2025-05-16 09:00:09', NULL),
(11, 2, 'Mango Yakult', 'ice', NULL, '2025-05-16 09:01:39', '2025-05-16 09:01:39', NULL),
(13, 1, 'Test', 'r', NULL, '2025-05-20 06:46:40', '2025-05-20 06:48:03', '2025-05-20 06:48:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `target` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `typing` varchar(255) DEFAULT NULL,
  `delay` varchar(255) DEFAULT NULL,
  `countryCode` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `followup` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(31, '2025_05_07_023900_create_user_profiles_table', 3),
(32, '2025_05_21_101505_create_messages_table', 4),
(33, '2025_05_21_102821_create_reports_table', 4),
(34, '2025_05_21_103042_create_stock_alert_logs_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasis`
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
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
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
-- Struktur dari tabel `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category` enum('barang','bahan','lainnya') NOT NULL,
  `type` enum('lapor_rusak','lainnya') NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan_bahans`
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
-- Dumping data untuk tabel `satuan_bahans`
--

INSERT INTO `satuan_bahans` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'mL', '2025-05-04 20:13:44', '2025-05-04 20:13:44', NULL),
(2, 2, 'kg', '2025-05-04 20:13:53', '2025-05-16 00:33:23', NULL),
(3, 1, 'lembar', '2025-05-04 20:18:21', '2025-05-04 20:18:21', NULL),
(4, 1, 'gram', '2025-05-04 20:40:54', '2025-05-04 20:40:54', NULL),
(5, 1, 'potong', '2025-05-04 21:03:43', '2025-05-04 21:03:43', NULL),
(7, 2, 'botol', '2025-05-16 08:47:50', '2025-05-16 08:47:50', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan_barangs`
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
-- Dumping data untuk tabel `satuan_barangs`
--

INSERT INTO `satuan_barangs` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Pkg', '2025-05-04 19:47:44', '2025-05-20 04:25:02', NULL),
(2, 1, 'Pcs', '2025-05-04 19:47:50', '2025-05-20 04:22:52', NULL),
(3, 1, '-', '2025-05-20 04:22:24', '2025-05-20 04:22:38', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_alert_logs`
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
-- Dumping data untuk tabel `stock_alert_logs`
--

INSERT INTO `stock_alert_logs` (`id`, `stockable_id`, `stockable_type`, `alert_date`, `created_at`, `updated_at`) VALUES
(1, 9, 'App\\Models\\Barang', '2025-05-21', '2025-05-21 03:51:31', '2025-05-21 03:51:31'),
(2, 6, 'App\\Models\\Barang', '2025-05-21', '2025-05-21 03:51:31', '2025-05-21 03:51:31'),
(3, 22, 'App\\Models\\Bahan', '2025-05-21', '2025-05-21 03:51:31', '2025-05-21 03:51:31'),
(4, 28, 'App\\Models\\Bahan', '2025-05-21', '2025-05-21 03:51:31', '2025-05-21 03:51:31'),
(5, 35, 'App\\Models\\Bahan', '2025-05-21', '2025-05-21 03:51:31', '2025-05-21 03:51:31'),
(6, 34, 'App\\Models\\Bahan', '2025-05-21', '2025-05-21 03:51:31', '2025-05-21 03:51:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tag_notifikasis`
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
-- Struktur dari tabel `temporary_files`
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
-- Struktur dari tabel `transaksis`
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
-- Dumping data untuk tabel `transaksis`
--

INSERT INTO `transaksis` (`id`, `user_id`, `date`, `menu_name`, `menu_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(30, 2, '2025-05-01', NULL, 10, 3, '2025-05-16 09:47:49', '2025-05-16 09:47:49', NULL),
(31, 2, '2025-05-01', NULL, 9, 5, '2025-05-16 09:47:49', '2025-05-16 09:47:49', NULL),
(32, 2, '2025-05-01', NULL, 8, 2, '2025-05-16 09:47:49', '2025-05-16 09:47:49', NULL),
(33, 2, '2025-05-01', NULL, 11, 5, '2025-05-16 09:47:49', '2025-05-16 09:47:49', NULL),
(34, 2, '2025-05-02', NULL, 10, 1, '2025-05-16 09:58:53', '2025-05-16 09:58:53', NULL),
(35, 2, '2025-05-02', NULL, 9, 2, '2025-05-16 09:58:53', '2025-05-16 09:58:53', NULL),
(36, 2, '2025-05-02', NULL, 8, 1, '2025-05-16 09:58:53', '2025-05-16 09:58:53', NULL),
(37, 2, '2025-05-02', NULL, 11, 1, '2025-05-16 09:58:53', '2025-05-16 09:58:53', NULL),
(38, 2, '2025-05-10', NULL, 10, 2, '2025-05-16 10:06:36', '2025-05-16 10:06:36', NULL),
(39, 2, '2025-05-10', NULL, 9, 4, '2025-05-16 10:06:36', '2025-05-16 10:06:36', NULL),
(40, 2, '2025-05-10', NULL, 8, 4, '2025-05-16 10:06:36', '2025-05-16 10:06:36', NULL),
(41, 2, '2025-05-10', NULL, 11, 1, '2025-05-16 10:06:36', '2025-05-16 10:06:36', NULL),
(46, 2, '2025-05-31', NULL, 10, 2, '2025-05-16 10:16:35', '2025-05-16 10:16:35', NULL),
(47, 2, '2025-05-31', NULL, 9, 2, '2025-05-16 10:16:35', '2025-05-16 10:16:35', NULL),
(48, 2, '2025-05-31', NULL, 8, 2, '2025-05-16 10:16:35', '2025-05-16 10:16:35', NULL),
(49, 2, '2025-05-31', NULL, 11, 2, '2025-05-16 10:16:35', '2025-05-16 10:16:35', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_details`
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
-- Dumping data untuk tabel `transaksi_details`
--

INSERT INTO `transaksi_details` (`id`, `date`, `transaksi_id`, `menu_id`, `bahan_id`, `jumlah`, `satuan`, `created_at`, `updated_at`) VALUES
(85, '2025-05-01', 30, 10, 31, 45.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(86, '2025-05-01', 30, 10, 19, 75.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(87, '2025-05-01', 30, 10, 17, 300.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(88, '2025-05-01', 31, 9, 22, 125.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(89, '2025-05-01', 31, 9, 19, 125.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(90, '2025-05-01', 31, 9, 17, 500.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(91, '2025-05-01', 31, 9, 18, 150.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(92, '2025-05-01', 32, 8, 19, 50.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(93, '2025-05-01', 32, 8, 17, 200.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(94, '2025-05-01', 32, 8, 18, 60.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(95, '2025-05-01', 33, 11, 28, 10.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(96, '2025-05-01', 33, 11, 17, 250.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(97, '2025-05-01', 33, 11, 20, 100.000, NULL, '2025-05-16 09:47:49', '2025-05-16 09:47:49'),
(98, '2025-05-02', 34, 10, 31, 15.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(99, '2025-05-02', 34, 10, 19, 25.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(100, '2025-05-02', 34, 10, 17, 100.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(101, '2025-05-02', 35, 9, 22, 50.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(102, '2025-05-02', 35, 9, 19, 50.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(103, '2025-05-02', 35, 9, 17, 200.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(104, '2025-05-02', 35, 9, 18, 60.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(105, '2025-05-02', 36, 8, 19, 25.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(106, '2025-05-02', 36, 8, 17, 100.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(107, '2025-05-02', 36, 8, 18, 30.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(108, '2025-05-02', 37, 11, 28, 2.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(109, '2025-05-02', 37, 11, 17, 50.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(110, '2025-05-02', 37, 11, 20, 20.000, NULL, '2025-05-16 09:58:53', '2025-05-16 09:58:53'),
(111, '2025-05-10', 38, 10, 31, 30.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(112, '2025-05-10', 38, 10, 19, 50.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(113, '2025-05-10', 38, 10, 17, 200.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(114, '2025-05-10', 39, 9, 22, 100.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(115, '2025-05-10', 39, 9, 19, 100.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(116, '2025-05-10', 39, 9, 17, 400.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(117, '2025-05-10', 39, 9, 18, 120.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(118, '2025-05-10', 40, 8, 19, 100.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(119, '2025-05-10', 40, 8, 17, 400.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(120, '2025-05-10', 40, 8, 18, 120.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(121, '2025-05-10', 41, 11, 28, 2.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(122, '2025-05-10', 41, 11, 17, 50.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(123, '2025-05-10', 41, 11, 20, 20.000, NULL, '2025-05-16 10:06:36', '2025-05-16 10:06:36'),
(137, '2025-05-31', 46, 10, 31, 30.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(138, '2025-05-31', 46, 10, 19, 50.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(139, '2025-05-31', 46, 10, 17, 200.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(140, '2025-05-31', 47, 9, 22, 50.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(141, '2025-05-31', 47, 9, 19, 50.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(142, '2025-05-31', 47, 9, 17, 200.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(143, '2025-05-31', 47, 9, 18, 60.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(144, '2025-05-31', 48, 8, 19, 50.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(145, '2025-05-31', 48, 8, 17, 200.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(146, '2025-05-31', 48, 8, 18, 60.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(147, '2025-05-31', 49, 11, 28, 4.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(148, '2025-05-31', 49, 11, 17, 100.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(149, '2025-05-31', 49, 11, 20, 40.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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
  `wa_api_token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `wa_api_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rendy Hartono Putra', 'rendi45hp', 'rendi45hp@gmail.com', '2025-05-04 19:45:10', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MANAJER', 'ultWtxI98rzOwhpItthKEUEx30BC13gaWDLYuAWmR0giO3LALIzLYqn0stFw', '', '2025-05-04 19:45:10', '2025-05-21 04:36:04', NULL),
(2, 'Maritza Septiarini', 'maritzaseptiarini', 'maritzaseptiarini@gmail.com', '2025-05-04 19:45:12', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'STAF', 'zbl9Lv458W6S6Qlu7cGDu7Lsyd4pLD0s6H2k2VKO7hy1Fuo5QYHZHF08AdZa', '', '2025-05-04 19:45:12', '2025-05-04 19:45:12', NULL),
(3, 'Abida Amalia Syifa', 'abidaams', 'abidaams@gmail.com', '2025-05-04 19:45:16', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OWNER', 'CAgxl4zYl0kBXHEBXnkKb2zioHnNgr8ZxAnFkrDoEjko40Dv0SWkixYu6IAN', '', '2025-05-04 19:45:16', '2025-05-04 19:45:16', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_profiles`
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

--
-- Dumping data untuk tabel `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `phone`, `address`, `birth_date`, `gender`, `created_at`, `updated_at`) VALUES
(1, 1, '081226077106', 'Cokroyasan, Ngombol', '2003-03-03', 'L', '2025-05-21 04:23:31', '2025-05-21 04:23:11'),
(2, 2, NULL, NULL, NULL, NULL, '2025-05-21 04:23:34', '2025-05-21 04:24:04'),
(3, 3, NULL, NULL, NULL, NULL, '2025-05-21 04:23:37', '2025-05-21 04:24:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_settings`
--

CREATE TABLE `user_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_settings`
--

INSERT INTO `user_settings` (`id`, `user_id`, `settings`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2025-05-21 04:23:41', '2025-05-21 04:23:44'),
(2, 2, NULL, '2025-05-21 04:23:46', '2025-05-21 04:23:48'),
(3, 3, NULL, '2025-05-21 04:23:50', '2025-05-21 04:23:52');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bahans`
--
ALTER TABLE `bahans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahans_user_id_foreign` (`user_id`),
  ADD KEY `bahans_satuan_id_foreign` (`satuan_id`);

--
-- Indeks untuk tabel `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_akhirs_user_id_foreign` (`user_id`),
  ADD KEY `bahan_akhirs_bahan_id_foreign` (`bahan_id`);

--
-- Indeks untuk tabel `bahan_awals`
--
ALTER TABLE `bahan_awals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_awals_user_id_foreign` (`user_id`),
  ADD KEY `bahan_awals_bahan_id_foreign` (`bahan_id`);

--
-- Indeks untuk tabel `bahan_masuks`
--
ALTER TABLE `bahan_masuks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_masuks_user_id_foreign` (`user_id`),
  ADD KEY `bahan_masuks_bahan_id_foreign` (`bahan_id`);

--
-- Indeks untuk tabel `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangs_user_id_foreign` (`user_id`),
  ADD KEY `barangs_satuan_id_foreign` (`satuan_id`);

--
-- Indeks untuk tabel `barang_awals`
--
ALTER TABLE `barang_awals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_awals_user_id_foreign` (`user_id`),
  ADD KEY `barang_awals_barang_id_foreign` (`barang_id`);

--
-- Indeks untuk tabel `barang_keluars`
--
ALTER TABLE `barang_keluars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_keluars_user_id_foreign` (`user_id`),
  ADD KEY `barang_keluars_barang_id_foreign` (`barang_id`);

--
-- Indeks untuk tabel `barang_masuks`
--
ALTER TABLE `barang_masuks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_masuks_user_id_foreign` (`user_id`),
  ADD KEY `barang_masuks_barang_id_foreign` (`barang_id`);

--
-- Indeks untuk tabel `deleted_items`
--
ALTER TABLE `deleted_items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komposisi_menus_menu_id_foreign` (`menu_id`),
  ADD KEY `komposisi_menus_bahan_id_foreign` (`bahan_id`);

--
-- Indeks untuk tabel `log_activities`
--
ALTER TABLE `log_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_user_id_foreign` (`user_id`),
  ADD KEY `notifikasis_tag_notifikasi_id_foreign` (`tag_notifikasi_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `satuan_bahans`
--
ALTER TABLE `satuan_bahans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satuan_bahans_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satuan_barangs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `stock_alert_logs`
--
ALTER TABLE `stock_alert_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tag_notifikasis`
--
ALTER TABLE `tag_notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_notifikasis_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `temporary_files`
--
ALTER TABLE `temporary_files`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_user_id_foreign` (`user_id`),
  ADD KEY `transaksis_menu_id_foreign` (`menu_id`);

--
-- Indeks untuk tabel `transaksi_details`
--
ALTER TABLE `transaksi_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_details_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `transaksi_details_menu_id_foreign` (`menu_id`),
  ADD KEY `transaksi_details_bahan_id_foreign` (`bahan_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indeks untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_settings_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bahans`
--
ALTER TABLE `bahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT untuk tabel `bahan_awals`
--
ALTER TABLE `bahan_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT untuk tabel `bahan_masuks`
--
ALTER TABLE `bahan_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `barang_awals`
--
ALTER TABLE `barang_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `barang_keluars`
--
ALTER TABLE `barang_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `barang_masuks`
--
ALTER TABLE `barang_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `deleted_items`
--
ALTER TABLE `deleted_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `satuan_bahans`
--
ALTER TABLE `satuan_bahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `stock_alert_logs`
--
ALTER TABLE `stock_alert_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tag_notifikasis`
--
ALTER TABLE `tag_notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `temporary_files`
--
ALTER TABLE `temporary_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `transaksi_details`
--
ALTER TABLE `transaksi_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bahans`
--
ALTER TABLE `bahans`
  ADD CONSTRAINT `bahans_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuan_bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  ADD CONSTRAINT `bahan_akhirs_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_akhirs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bahan_awals`
--
ALTER TABLE `bahan_awals`
  ADD CONSTRAINT `bahan_awals_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_awals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bahan_masuks`
--
ALTER TABLE `bahan_masuks`
  ADD CONSTRAINT `bahan_masuks_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bahan_masuks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuan_barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barangs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_awals`
--
ALTER TABLE `barang_awals`
  ADD CONSTRAINT `barang_awals_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_awals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_keluars`
--
ALTER TABLE `barang_keluars`
  ADD CONSTRAINT `barang_keluars_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_keluars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_masuks`
--
ALTER TABLE `barang_masuks`
  ADD CONSTRAINT `barang_masuks_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `barang_masuks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  ADD CONSTRAINT `komposisi_menus_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komposisi_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_tag_notifikasi_id_foreign` FOREIGN KEY (`tag_notifikasi_id`) REFERENCES `tag_notifikasis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `satuan_bahans`
--
ALTER TABLE `satuan_bahans`
  ADD CONSTRAINT `satuan_bahans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  ADD CONSTRAINT `satuan_barangs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tag_notifikasis`
--
ALTER TABLE `tag_notifikasis`
  ADD CONSTRAINT `tag_notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_details`
--
ALTER TABLE `transaksi_details`
  ADD CONSTRAINT `transaksi_details_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_details_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
