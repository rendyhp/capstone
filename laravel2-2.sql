-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 28, 2025 at 08:41 AM
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
(160, 1, '2025-05-01', 22, 1920.000, '2025-05-20 05:53:34', '2025-05-20 05:53:34', NULL),
(161, 3, '2025-05-02', 22, 1870.000, '2025-05-22 02:46:57', '2025-05-22 02:46:57', NULL),
(162, 3, '2025-05-02', 30, 1000.000, '2025-05-22 02:47:24', '2025-05-22 02:47:24', NULL),
(163, 3, '2025-05-02', 21, 1000.000, '2025-05-22 02:47:28', '2025-05-22 02:47:28', NULL),
(164, 3, '2025-05-02', 20, 880.000, '2025-05-22 02:47:32', '2025-05-22 02:47:32', NULL),
(165, 3, '2025-05-02', 19, 650.000, '2025-05-22 02:47:38', '2025-05-22 02:47:38', NULL),
(166, 3, '2025-05-02', 32, 1000.000, '2025-05-22 02:47:44', '2025-05-22 02:47:44', NULL),
(167, 3, '2025-05-02', 29, 1000.000, '2025-05-22 02:47:48', '2025-05-22 02:47:48', NULL),
(168, 3, '2025-05-02', 18, 700.000, '2025-05-22 02:47:54', '2025-05-22 02:47:54', NULL),
(169, 3, '2025-05-02', 31, 940.000, '2025-05-22 02:48:00', '2025-05-22 02:48:00', NULL),
(170, 3, '2025-05-02', 24, 1000.000, '2025-05-22 02:48:03', '2025-05-22 02:48:03', NULL),
(171, 3, '2025-05-02', 23, 1000.000, '2025-05-22 02:48:08', '2025-05-22 02:48:08', NULL),
(172, 3, '2025-05-02', 26, 1000.000, '2025-05-22 02:48:13', '2025-05-22 02:48:13', NULL),
(173, 3, '2025-05-02', 25, 1000.000, '2025-05-22 02:48:17', '2025-05-22 02:48:17', NULL),
(174, 3, '2025-05-02', 27, 1000.000, '2025-05-22 02:48:20', '2025-05-22 02:48:20', NULL),
(175, 3, '2025-05-02', 17, 8300.000, '2025-05-22 02:48:24', '2025-05-22 02:48:24', NULL),
(177, 3, '2025-05-02', 28, 988.000, '2025-05-22 02:48:31', '2025-05-22 02:48:31', NULL),
(178, 3, '2025-05-03', 22, 1770.000, '2025-05-22 02:50:12', '2025-05-22 02:50:12', NULL),
(179, 3, '2025-05-03', 30, 1000.000, '2025-05-22 02:50:15', '2025-05-22 02:50:15', NULL),
(180, 3, '2025-05-03', 21, 1000.000, '2025-05-22 02:50:18', '2025-05-22 02:50:18', NULL),
(181, 3, '2025-05-03', 20, 800.000, '2025-05-22 02:50:24', '2025-05-22 02:50:24', NULL),
(182, 3, '2025-05-03', 19, 350.000, '2025-05-22 02:50:30', '2025-05-22 02:50:30', NULL),
(183, 3, '2025-05-03', 32, 1000.000, '2025-05-22 02:50:35', '2025-05-22 02:50:35', NULL),
(184, 3, '2025-05-03', 29, 1000.000, '2025-05-22 02:50:39', '2025-05-22 02:50:39', NULL),
(185, 3, '2025-05-03', 18, 460.000, '2025-05-22 02:50:45', '2025-05-22 02:50:45', NULL),
(186, 3, '2025-05-03', 31, 880.000, '2025-05-22 02:50:50', '2025-05-22 02:50:50', NULL),
(187, 3, '2025-05-03', 24, 1000.000, '2025-05-22 02:50:54', '2025-05-22 02:50:54', NULL),
(188, 3, '2025-05-03', 23, 1000.000, '2025-05-22 02:50:57', '2025-05-22 02:50:57', NULL),
(189, 3, '2025-05-03', 26, 1000.000, '2025-05-22 02:51:02', '2025-05-22 02:51:02', NULL),
(190, 3, '2025-05-03', 25, 1000.000, '2025-05-22 02:51:07', '2025-05-22 02:51:07', NULL),
(191, 3, '2025-05-03', 27, 1000.000, '2025-05-22 02:51:10', '2025-05-22 02:51:10', NULL),
(192, 3, '2025-05-03', 17, 6900.000, '2025-05-22 02:51:14', '2025-05-22 02:51:14', NULL),
(193, 3, '2025-05-03', 28, 980.000, '2025-05-22 02:51:18', '2025-05-22 02:51:18', NULL);

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
(20, 3, '2025-05-01', 22, 'cash', 555.000, '2025-05-22 01:38:47', '2025-05-22 01:38:47', NULL),
(21, 3, '2025-05-01', 22, 'cash', 500.000, '2025-05-22 01:38:57', '2025-05-22 01:38:57', NULL);

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
  `stok_awal` int(12) NOT NULL,
  `minimum` int(12) NOT NULL,
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
(1, 3, '2025-05-05', 'Piring', 'Piring baru', 20, 20, 2, 'upload/barang/1746413436.jpg', '2025-05-04 19:50:36', '2025-05-22 02:23:09', NULL),
(2, 3, '2025-05-05', 'Gelas Kecil', '-', 12, 20, 2, 'upload/barang/1746413584.jpg', '2025-05-04 19:53:04', '2025-05-22 02:32:28', NULL),
(3, 3, '2025-05-05', 'Gelas Besar', '-', 20, 15, 2, 'upload/barang/1746413997.webp', '2025-05-04 19:59:57', '2025-05-22 02:15:15', NULL),
(4, 3, '2025-05-05', 'Meja Kafe', 'Meja baru', 10, 6, 2, 'upload/barang/1746414173.jpg', '2025-05-04 20:02:53', '2025-05-22 02:32:42', NULL),
(5, 1, '2025-05-05', 'Kursi Kafe', '-', 20, 0, 2, 'upload/barang/1746414367.webp', '2025-05-04 20:06:07', '2025-05-04 20:06:07', NULL),
(6, 3, '2025-05-15', 'Mangkok', '-', 10, 9, 2, NULL, '2025-05-15 00:13:13', '2025-05-22 02:19:03', NULL),
(7, 1, '2025-01-15', 'mangkok besar', '-', 5, 5, 2, NULL, '2025-05-15 00:57:31', '2025-05-20 04:39:13', NULL),
(8, 3, '2025-05-19', 'Sendok', '-', 20, 13, 2, NULL, '2025-05-19 16:52:38', '2025-05-22 02:26:08', NULL),
(9, 2, '2025-05-20', 'Garpu', '-', 12, 10, 2, NULL, '2025-05-20 04:12:48', '2025-05-22 03:43:43', NULL);

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
(7, 1, '2025-01-15', 7, 'Stok awal mangkok besar', 5, '2025-05-15 00:57:31', '2025-05-15 00:57:31', NULL),
(8, 1, '2025-05-19', 8, 'Stok awal Sendok', 20, '2025-05-19 16:52:38', '2025-05-19 16:52:38', NULL),
(10, 1, '2025-05-20', 9, 'Stok awal Garpu', 12, '2025-05-20 04:17:52', '2025-05-20 04:17:52', NULL);

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
(14, 3, 8, '2025-05-22', 'r', 2, '2025-05-22 02:30:39', '2025-05-22 02:30:39', NULL),
(15, 2, 9, '2025-05-22', 'r', 5, '2025-05-22 03:43:56', '2025-05-22 03:43:56', NULL),
(16, 2, 3, '2025-05-25', 'pecah', 10, '2025-05-25 11:21:32', '2025-05-25 11:21:32', NULL),
(17, 3, 3, '2025-05-25', 'pecah', 2, '2025-05-25 11:22:45', '2025-05-25 11:22:45', NULL);

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
(2, 1, '2025-05-15', 7, '-', 5, '2025-05-15 00:58:10', '2025-05-15 00:58:10', NULL),
(3, 1, '2025-05-20', 3, '-', 5, '2025-05-19 17:15:38', '2025-05-19 17:15:38', NULL),
(4, 1, '2025-05-20', 1, 'Beli cash', 2, '2025-05-20 04:19:34', '2025-05-20 04:19:34', NULL),
(5, 1, '2025-05-20', 2, 'Beli cash', 2, '2025-05-20 04:20:25', '2025-05-20 04:20:25', NULL),
(6, 3, '2025-05-22', 9, 'b', 2, '2025-05-22 01:59:04', '2025-05-22 01:59:04', NULL);

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
(8, 2, 'Kopi Susu Original', 'ice', NULL, '2025-05-16 08:57:36', '2025-05-16 08:57:36', NULL),
(9, 2, 'Kopi Susu Gula Aren', 'ice', NULL, '2025-05-16 08:58:41', '2025-05-16 08:58:41', NULL),
(10, 2, 'Greentea Latte', 'ice', NULL, '2025-05-16 09:00:09', '2025-05-16 09:00:09', NULL),
(11, 2, 'Mango Yakult', 'ice', NULL, '2025-05-16 09:01:39', '2025-05-16 09:01:39', NULL),
(13, 1, 'Test', 'r', NULL, '2025-05-20 06:46:40', '2025-05-20 06:48:03', '2025-05-20 06:48:03');

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
(31, '2025_05_07_023900_create_user_profiles_table', 3),
(32, '2025_05_21_101505_create_messages_table', 4),
(33, '2025_05_21_102821_create_reports_table', 4),
(34, '2025_05_21_103042_create_stock_alert_logs_table', 4),
(35, '2025_05_21_164851_create_stock_statuses_table', 4);

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
(2, 2, 'kg', '2025-05-04 20:13:53', '2025-05-16 00:33:23', NULL),
(3, 1, 'lembar', '2025-05-04 20:18:21', '2025-05-04 20:18:21', NULL),
(4, 1, 'gram', '2025-05-04 20:40:54', '2025-05-04 20:40:54', NULL),
(5, 1, 'potong', '2025-05-04 21:03:43', '2025-05-04 21:03:43', NULL),
(7, 2, 'botol', '2025-05-16 08:47:50', '2025-05-16 08:47:50', NULL);

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
(1, 1, 'Pkg', '2025-05-04 19:47:44', '2025-05-20 04:25:02', NULL),
(2, 1, 'Pcs', '2025-05-04 19:47:50', '2025-05-20 04:22:52', NULL),
(3, 1, '-', '2025-05-20 04:22:24', '2025-05-20 04:22:38', NULL);

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
(11, 28, 'App\\Models\\Bahan', '2025-05-22', '2025-05-22 02:48:31', '2025-05-22 02:48:31'),
(12, 19, 'App\\Models\\Bahan', '2025-05-22', '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(13, 18, 'App\\Models\\Bahan', '2025-05-22', '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(14, 9, 'App\\Models\\Barang', '2025-05-22', '2025-05-22 03:43:56', '2025-05-22 03:43:56'),
(15, 22, 'App\\Models\\Bahan', '2025-05-22', '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(16, 3, 'App\\Models\\Barang', '2025-05-25', '2025-05-25 11:22:45', '2025-05-25 11:22:45'),
(17, 19, 'App\\Models\\Bahan', '2025-05-25', '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(18, 18, 'App\\Models\\Bahan', '2025-05-25', '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(19, 22, 'App\\Models\\Bahan', '2025-05-25', '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(20, 28, 'App\\Models\\Bahan', '2025-05-25', '2025-05-25 12:59:20', '2025-05-25 12:59:20');

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
(49, 2, '2025-05-31', NULL, 11, 2, '2025-05-16 10:16:35', '2025-05-16 10:16:35', NULL),
(59, 2, '2025-05-21', NULL, 10, 33, '2025-05-21 13:47:53', '2025-05-21 13:47:53', NULL),
(60, 3, '2025-05-03', NULL, 10, 4, '2025-05-22 02:49:54', '2025-05-22 02:49:54', NULL),
(61, 3, '2025-05-03', NULL, 9, 4, '2025-05-22 02:49:54', '2025-05-22 02:49:54', NULL),
(62, 3, '2025-05-03', NULL, 8, 4, '2025-05-22 02:49:54', '2025-05-22 02:49:54', NULL),
(63, 3, '2025-05-03', NULL, 11, 4, '2025-05-22 02:49:54', '2025-05-22 02:49:54', NULL),
(64, 2, '2025-05-22', NULL, 10, 3, '2025-05-22 03:45:52', '2025-05-22 03:45:52', NULL),
(65, 2, '2025-05-22', NULL, 9, 5, '2025-05-22 03:45:52', '2025-05-22 03:45:52', NULL),
(66, 2, '2025-05-22', NULL, 8, 2, '2025-05-22 03:45:52', '2025-05-22 03:45:52', NULL),
(67, 2, '2025-05-22', NULL, 11, 5, '2025-05-22 03:45:52', '2025-05-22 03:45:52', NULL),
(68, 1, '2025-05-25', NULL, 10, 3, '2025-05-25 12:59:20', '2025-05-25 12:59:20', NULL),
(69, 1, '2025-05-25', NULL, 9, 5, '2025-05-25 12:59:20', '2025-05-25 12:59:20', NULL),
(70, 1, '2025-05-25', NULL, 8, 2, '2025-05-25 12:59:20', '2025-05-25 12:59:20', NULL),
(71, 1, '2025-05-25', NULL, 11, 5, '2025-05-25 12:59:20', '2025-05-25 12:59:20', NULL);

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
(149, '2025-05-31', 49, 11, 20, 40.000, NULL, '2025-05-16 10:16:35', '2025-05-16 10:16:35'),
(183, '2025-05-21', 59, 10, 31, 495.000, NULL, '2025-05-21 13:47:53', '2025-05-21 13:47:53'),
(184, '2025-05-21', 59, 10, 19, 825.000, NULL, '2025-05-21 13:47:53', '2025-05-21 13:47:53'),
(185, '2025-05-21', 59, 10, 17, 3300.000, NULL, '2025-05-21 13:47:53', '2025-05-21 13:47:53'),
(186, '2025-05-03', 60, 10, 31, 60.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(187, '2025-05-03', 60, 10, 19, 100.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(188, '2025-05-03', 60, 10, 17, 400.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(189, '2025-05-03', 61, 9, 22, 100.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(190, '2025-05-03', 61, 9, 19, 100.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(191, '2025-05-03', 61, 9, 17, 400.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(192, '2025-05-03', 61, 9, 18, 120.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(193, '2025-05-03', 62, 8, 19, 100.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(194, '2025-05-03', 62, 8, 17, 400.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(195, '2025-05-03', 62, 8, 18, 120.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(196, '2025-05-03', 63, 11, 28, 8.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(197, '2025-05-03', 63, 11, 17, 200.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(198, '2025-05-03', 63, 11, 20, 80.000, NULL, '2025-05-22 02:49:54', '2025-05-22 02:49:54'),
(199, '2025-05-22', 64, 10, 31, 45.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(200, '2025-05-22', 64, 10, 19, 75.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(201, '2025-05-22', 64, 10, 17, 300.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(202, '2025-05-22', 65, 9, 22, 125.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(203, '2025-05-22', 65, 9, 19, 125.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(204, '2025-05-22', 65, 9, 17, 500.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(205, '2025-05-22', 65, 9, 18, 150.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(206, '2025-05-22', 66, 8, 19, 50.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(207, '2025-05-22', 66, 8, 17, 200.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(208, '2025-05-22', 66, 8, 18, 60.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(209, '2025-05-22', 67, 11, 28, 10.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(210, '2025-05-22', 67, 11, 17, 250.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(211, '2025-05-22', 67, 11, 20, 100.000, NULL, '2025-05-22 03:45:52', '2025-05-22 03:45:52'),
(212, '2025-05-25', 68, 10, 31, 45.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(213, '2025-05-25', 68, 10, 19, 75.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(214, '2025-05-25', 68, 10, 17, 300.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(215, '2025-05-25', 69, 9, 22, 125.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(216, '2025-05-25', 69, 9, 19, 125.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(217, '2025-05-25', 69, 9, 17, 500.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(218, '2025-05-25', 69, 9, 18, 150.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(219, '2025-05-25', 70, 8, 19, 50.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(220, '2025-05-25', 70, 8, 17, 200.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(221, '2025-05-25', 70, 8, 18, 60.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(222, '2025-05-25', 71, 11, 28, 10.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(223, '2025-05-25', 71, 11, 17, 250.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20'),
(224, '2025-05-25', 71, 11, 20, 100.000, NULL, '2025-05-25 12:59:20', '2025-05-25 12:59:20');

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
  `wa_api_token` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `wa_api_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rendy Hartono Putra', 'rendi45hp', 'rendi45hp@gmail.com', '2025-05-04 19:45:10', '$2y$10$Q8Ed2iM4NzZVnrymLFP7Y.dgy30XnsT3BmxsqJnbhZ7oaUfPosi7i', 'MANAJER', 'MBCZScZmNd0p3JjVJEIh8fBzSgF01quF7a8xuWiwjGSI2sy1jb8kWPcMvkQH', '49zbRGa16VLm8S44vT5E', '2025-05-04 19:45:10', '2025-05-21 13:49:01', NULL),
(2, 'Maritza Septiarini', 'maritzaseptiarini', 'maritzaseptiarini@gmail.com', '2025-05-04 19:45:12', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'STAF', 'Sj3ymuriIJsBq9rjuUEm75vwEwn6Fh9WoKjUWJMrKkXl5DIEOP8hgiAb80ry', NULL, '2025-05-04 19:45:12', '2025-05-04 19:45:12', NULL),
(3, 'Abida Amalia Syifa', 'abidaams', 'abidaams@gmail.com', '2025-05-04 19:45:16', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OWNER', 'yZwWtAxLupgIfIPcz7mvbfBrQnh0nOWYcfQPKwM5oJ9Tv0ysSJFEtx9QZG1E', '49zbRGa16VLm8S44vT5E', '2025-05-04 19:45:16', '2025-05-22 03:42:15', NULL);

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

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `phone`, `address`, `birth_date`, `gender`, `created_at`, `updated_at`) VALUES
(1, 1, '6281226077106', 'Cokroyasan, Ngombol', '2003-03-03', 'L', NULL, '2025-05-21 13:37:32'),
(2, 2, '62', NULL, NULL, 'P', NULL, '2025-05-21 13:46:29'),
(3, 3, '6285842311882', NULL, NULL, 'P', NULL, '2025-05-22 01:33:48');

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
(1, 1, '\"{\\\"show_image_bahan\\\":true,\\\"show_keterangan\\\":\\\"0\\\",\\\"show_awal\\\":\\\"1\\\",\\\"show_masuk\\\":\\\"1\\\",\\\"show_terpakai\\\":\\\"1\\\",\\\"show_sisa\\\":\\\"1\\\",\\\"show_akhir\\\":\\\"1\\\",\\\"show_terbuang\\\":\\\"1\\\",\\\"show_minimum\\\":\\\"0\\\",\\\"pagination_bahanBar\\\":\\\"20\\\",\\\"pagination_bahanKitchen\\\":\\\"20\\\"}\"', NULL, '2025-05-28 06:40:27'),
(2, 2, NULL, NULL, NULL),
(3, 3, NULL, NULL, NULL);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `bahan_awals`
--
ALTER TABLE `bahan_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `bahan_masuks`
--
ALTER TABLE `bahan_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `barang_awals`
--
ALTER TABLE `barang_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `barang_keluars`
--
ALTER TABLE `barang_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `barang_masuks`
--
ALTER TABLE `barang_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan_bahans`
--
ALTER TABLE `satuan_bahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_alert_logs`
--
ALTER TABLE `stock_alert_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `transaksi_details`
--
ALTER TABLE `transaksi_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
