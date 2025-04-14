-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Apr 2025 pada 06.59
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
-- Struktur dari tabel `akhir_terpakai_seharusnyas`
--

CREATE TABLE `akhir_terpakai_seharusnyas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahans`
--

CREATE TABLE `bahans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `minimum` decimal(12,3) NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bahans`
--

INSERT INTO `bahans` (`id`, `user_id`, `name`, `description`, `minimum`, `satuan_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Kopi Arabica', '-', 100.000, 2, '2025-03-21 21:25:37', '2025-03-21 21:25:37', NULL),
(2, 1, 'Air', 'Air bening', 0.000, 3, '2025-03-21 21:30:00', '2025-03-23 20:51:16', NULL),
(5, 1, 'Gula pasir', '-', 500.000, 2, '2025-03-21 22:16:20', '2025-03-24 21:41:18', NULL),
(6, 1, 'Jeruk', '-', 1.000, 1, '2025-03-23 20:13:04', '2025-03-23 20:13:04', NULL),
(9, 1, 'Susu Segar', '-', 100.000, 3, '2025-03-24 05:32:40', '2025-03-24 05:32:40', NULL),
(10, 1, 'Sirup Karamel', '-', 100.000, 3, '2025-03-24 05:32:40', '2025-03-24 05:32:40', NULL),
(11, 1, 'Cokelat Bubuk', '-', 100.000, 2, '2025-03-24 06:19:40', '2025-03-24 06:19:40', NULL),
(12, 1, 'Mangga Cengkir', 'Mangga segar dari Probolinggo', 3.000, 1, '2025-03-24 20:06:44', '2025-03-24 20:07:07', NULL),
(13, 1, 'TEST', 'SAS', 0.000, 2, '2025-03-24 20:27:44', '2025-03-24 20:35:59', '2025-03-24 20:35:59'),
(14, 1, 'TEST', 'des', 7.522, 1, '2025-03-24 21:10:26', '2025-03-24 22:51:06', '2025-04-10 03:22:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_akhirs`
--

CREATE TABLE `bahan_akhirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bahan_akhirs`
--

INSERT INTO `bahan_akhirs` (`id`, `user_id`, `date`, `bahan_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(24, 1, '2025-03-25', 2, 0.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(25, 1, '2025-03-25', 11, 500.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(26, 1, '2025-03-25', 5, 600.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(27, 1, '2025-03-25', 6, 2.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(28, 1, '2025-03-25', 1, 500.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(29, 1, '2025-03-25', 12, 20.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(30, 1, '2025-03-25', 10, 590.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(31, 1, '2025-03-25', 9, 150.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(32, 1, '2025-03-25', 13, 0.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(33, 1, '2025-03-07', 2, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(34, 1, '2025-03-07', 11, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(35, 1, '2025-03-07', 5, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(36, 1, '2025-03-07', 6, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(37, 1, '2025-03-07', 1, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(38, 1, '2025-03-07', 12, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(39, 1, '2025-03-07', 10, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(40, 1, '2025-03-07', 9, 34.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(41, 1, '2025-03-07', 14, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(42, 1, '2025-03-03', 2, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(43, 1, '2025-03-03', 11, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(44, 1, '2025-03-03', 5, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(45, 1, '2025-03-03', 6, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(46, 1, '2025-03-03', 1, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(47, 1, '2025-03-03', 12, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(48, 1, '2025-03-03', 10, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(49, 1, '2025-03-03', 9, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(50, 1, '2025-03-03', 14, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(51, 1, '2025-03-19', 2, 3.444, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(52, 1, '2025-03-19', 11, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(53, 1, '2025-03-19', 5, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(54, 1, '2025-03-19', 6, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(55, 1, '2025-03-19', 1, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(56, 1, '2025-03-19', 12, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(57, 1, '2025-03-19', 10, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(58, 1, '2025-03-19', 9, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(59, 1, '2025-03-19', 14, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(60, 1, '2025-03-05', 2, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(61, 1, '2025-03-05', 11, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(62, 1, '2025-03-05', 5, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(63, 1, '2025-03-05', 6, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(64, 1, '2025-03-05', 1, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(65, 1, '2025-03-05', 12, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(66, 1, '2025-03-05', 10, 0.000, '2025-03-26 21:52:53', '2025-03-26 21:52:53', NULL),
(67, 1, '2025-03-05', 9, 45.000, '2025-03-26 21:52:53', '2025-03-26 21:52:53', NULL),
(68, 1, '2025-03-05', 14, 0.000, '2025-03-26 21:52:53', '2025-03-26 21:52:53', NULL),
(69, 1, '2025-03-05', 2, 55.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(70, 1, '2025-03-05', 11, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(71, 1, '2025-03-05', 5, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(72, 1, '2025-03-05', 6, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(73, 1, '2025-03-05', 1, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(74, 1, '2025-03-05', 12, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(75, 1, '2025-03-05', 10, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(76, 1, '2025-03-05', 9, 0.000, '2025-03-26 21:53:19', '2025-03-26 21:53:19', NULL),
(77, 1, '2025-03-05', 14, 0.000, '2025-03-26 21:53:19', '2025-03-26 21:53:19', NULL),
(78, 1, '2025-03-05', 2, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(79, 1, '2025-03-05', 11, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(80, 1, '2025-03-05', 5, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(81, 1, '2025-03-05', 6, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(82, 1, '2025-03-05', 1, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(83, 1, '2025-03-05', 12, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(84, 1, '2025-03-05', 10, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(85, 1, '2025-03-05', 9, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(86, 1, '2025-03-05', 14, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(87, 1, '2025-03-27', 2, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(88, 1, '2025-03-27', 11, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(89, 1, '2025-03-27', 5, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(90, 1, '2025-03-27', 6, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(91, 1, '2025-03-27', 1, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(92, 1, '2025-03-27', 12, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(93, 1, '2025-03-27', 10, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(94, 1, '2025-03-27', 9, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(95, 1, '2025-03-27', 14, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(96, 1, '2025-04-10', 2, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(97, 1, '2025-04-10', 11, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(98, 1, '2025-04-10', 5, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(99, 1, '2025-04-10', 6, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(100, 1, '2025-04-10', 1, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(101, 1, '2025-04-10', 12, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(102, 1, '2025-04-10', 10, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(103, 1, '2025-04-10', 9, 59.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(104, 1, '2025-04-10', 14, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(105, 1, '2025-04-14', 2, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(106, 1, '2025-04-14', 11, 1000.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(107, 1, '2025-04-14', 5, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(108, 1, '2025-04-14', 6, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(109, 1, '2025-04-14', 1, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(110, 1, '2025-04-14', 12, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(111, 1, '2025-04-14', 10, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(112, 1, '2025-04-14', 9, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(113, 1, '2025-04-14', 2, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(114, 1, '2025-04-14', 11, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(115, 1, '2025-04-14', 5, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(116, 1, '2025-04-14', 6, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(117, 1, '2025-04-14', 1, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(118, 1, '2025-04-14', 12, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(119, 1, '2025-04-14', 10, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(120, 1, '2025-04-14', 9, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_awals`
--

CREATE TABLE `bahan_awals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bahan_awals`
--

INSERT INTO `bahan_awals` (`id`, `date`, `bahan_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(23, '2025-03-26', 2, 0.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(24, '2025-03-26', 11, 500.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(25, '2025-03-26', 5, 600.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(26, '2025-03-26', 6, 2.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(27, '2025-03-26', 1, 500.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(28, '2025-03-26', 12, 20.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(29, '2025-03-26', 10, 590.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(30, '2025-03-26', 9, 150.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(31, '2025-03-26', 13, 0.000, '2025-03-24 20:29:07', '2025-03-24 20:29:07', NULL),
(32, '2025-03-08', 2, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(33, '2025-03-08', 11, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(34, '2025-03-08', 5, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(35, '2025-03-08', 6, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(36, '2025-03-08', 1, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(37, '2025-03-08', 12, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(38, '2025-03-08', 10, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(39, '2025-03-08', 9, 34.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(40, '2025-03-08', 14, 0.000, '2025-03-24 21:50:35', '2025-03-24 21:50:35', NULL),
(41, '2025-03-04', 2, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(42, '2025-03-04', 11, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(43, '2025-03-04', 5, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(44, '2025-03-04', 6, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(45, '2025-03-04', 1, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(46, '2025-03-04', 12, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(47, '2025-03-04', 10, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(48, '2025-03-04', 9, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(49, '2025-03-04', 14, 0.000, '2025-03-24 22:15:45', '2025-03-24 22:15:45', NULL),
(50, '2025-03-20', 2, 3.444, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(51, '2025-03-20', 11, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(52, '2025-03-20', 5, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(53, '2025-03-20', 6, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(54, '2025-03-20', 1, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(55, '2025-03-20', 12, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(56, '2025-03-20', 10, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(57, '2025-03-20', 9, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(58, '2025-03-20', 14, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL),
(59, '2025-03-06', 2, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(60, '2025-03-06', 11, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(61, '2025-03-06', 5, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(62, '2025-03-06', 6, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(63, '2025-03-06', 1, 0.000, '2025-03-26 21:52:52', '2025-03-26 21:52:52', NULL),
(64, '2025-03-06', 12, 0.000, '2025-03-26 21:52:53', '2025-03-26 21:52:53', NULL),
(65, '2025-03-06', 10, 0.000, '2025-03-26 21:52:53', '2025-03-26 21:52:53', NULL),
(66, '2025-03-06', 9, 45.000, '2025-03-26 21:52:53', '2025-03-26 21:52:53', NULL),
(67, '2025-03-06', 14, 0.000, '2025-03-26 21:52:53', '2025-03-26 21:52:53', NULL),
(68, '2025-03-06', 2, 55.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(69, '2025-03-06', 11, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(70, '2025-03-06', 5, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(71, '2025-03-06', 6, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(72, '2025-03-06', 1, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(73, '2025-03-06', 12, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(74, '2025-03-06', 10, 0.000, '2025-03-26 21:53:18', '2025-03-26 21:53:18', NULL),
(75, '2025-03-06', 9, 0.000, '2025-03-26 21:53:19', '2025-03-26 21:53:19', NULL),
(76, '2025-03-06', 14, 0.000, '2025-03-26 21:53:19', '2025-03-26 21:53:19', NULL),
(77, '2025-03-06', 2, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(78, '2025-03-06', 11, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(79, '2025-03-06', 5, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(80, '2025-03-06', 6, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(81, '2025-03-06', 1, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(82, '2025-03-06', 12, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(83, '2025-03-06', 10, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(84, '2025-03-06', 9, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(85, '2025-03-06', 14, 0.000, '2025-03-26 21:54:24', '2025-03-26 21:54:24', NULL),
(86, '2025-03-28', 2, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(87, '2025-03-28', 11, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(88, '2025-03-28', 5, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(89, '2025-03-28', 6, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(90, '2025-03-28', 1, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(91, '2025-03-28', 12, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(92, '2025-03-28', 10, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(93, '2025-03-28', 9, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(94, '2025-03-28', 14, 0.000, '2025-03-26 22:03:10', '2025-03-26 22:03:10', NULL),
(95, '2025-04-11', 2, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(96, '2025-04-11', 11, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(97, '2025-04-11', 5, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(98, '2025-04-11', 6, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(99, '2025-04-11', 1, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(100, '2025-04-11', 12, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(101, '2025-04-11', 10, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(102, '2025-04-11', 9, 59.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(103, '2025-04-11', 14, 0.000, '2025-04-09 20:22:11', '2025-04-09 20:22:11', NULL),
(104, '2025-04-15', 2, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(105, '2025-04-15', 11, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(106, '2025-04-15', 5, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(107, '2025-04-15', 6, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(108, '2025-04-15', 1, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(109, '2025-04-15', 12, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(110, '2025-04-15', 10, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(111, '2025-04-15', 9, 0.000, '2025-04-13 21:00:31', '2025-04-13 21:00:31', NULL),
(112, '2025-04-15', 2, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(113, '2025-04-15', 11, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(114, '2025-04-15', 5, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(115, '2025-04-15', 6, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(116, '2025-04-15', 1, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(117, '2025-04-15', 12, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(118, '2025-04-15', 10, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL),
(119, '2025-04-15', 9, 50000.000, '2025-04-13 21:57:34', '2025-04-13 21:57:34', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `jumlah` int(12) NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barangs`
--

INSERT INTO `barangs` (`id`, `user_id`, `name`, `description`, `jumlah`, `satuan_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Gelas', '-', 60, 2, NULL, '2025-04-14 02:47:29', '2025-04-13 20:06:01', NULL),
(2, 1, 'Piring', '-', 60, 2, NULL, '2025-04-14 02:47:29', '2025-04-14 02:47:29', NULL),
(3, 1, 'Meja 1', '-', 10, 1, NULL, '2025-04-13 20:06:25', '2025-04-13 20:06:25', NULL);

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
-- Struktur dari tabel `history_inputs`
--

CREATE TABLE `history_inputs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `history_inputs`
--

INSERT INTO `history_inputs` (`id`, `user_id`, `date`, `bahan_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-04-17', 11, 10.000, '2025-04-13 20:43:45', '2025-04-13 20:43:45', NULL),
(2, 1, '2025-04-13', 11, 10000.000, '2025-04-13 20:48:18', '2025-04-13 20:48:18', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `komposisi_menus`
--

CREATE TABLE `komposisi_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `komposisi_menus`
--

INSERT INTO `komposisi_menus` (`id`, `menu_id`, `bahan_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(50, 2, 1, 8.000, '2025-04-09 22:51:40', '2025-04-09 22:51:40', NULL),
(54, 1, 6, 66.000, '2025-04-09 22:54:26', '2025-04-09 22:54:26', NULL),
(55, 1, 5, 6.000, '2025-04-09 22:54:26', '2025-04-09 22:54:26', NULL),
(56, 5, 11, 50.000, '2025-04-09 22:54:38', '2025-04-09 22:54:38', NULL),
(57, 5, 9, 200.000, '2025-04-09 22:54:38', '2025-04-09 22:54:38', NULL),
(58, 5, 5, 15.000, '2025-04-09 22:54:38', '2025-04-09 22:54:38', NULL);

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
(1, 1, 'Espresso Ice', NULL, NULL, '2025-03-24 05:30:41', NULL, NULL),
(2, 1, 'Cappucino', NULL, NULL, '2025-03-24 05:31:25', '2025-03-24 05:31:25', NULL),
(3, 1, 'Caramel Latte', NULL, NULL, '2025-03-24 05:31:45', '2025-03-24 05:31:45', NULL),
(5, 1, 'Hot Chocolate', '-', NULL, '2025-03-23 23:45:29', '2025-03-23 23:45:29', NULL),
(9, 1, 'Test 23', 'd', NULL, '2025-04-09 22:51:32', '2025-04-09 22:54:01', '2025-04-09 22:54:01');

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2021_03_12_045244_create_users_table', 1),
(4, '2022_03_12_042756_create_satuans_table', 1),
(5, '2022_03_12_052551_create_tag_notifikasis_table', 1),
(6, '2023_11_09_063757_create_password_reset_tokens_table', 1),
(7, '2023_11_09_064003_create_failed_jobs_table', 1),
(9, '2025_03_12_042747_create_bahans_table', 1),
(10, '2025_03_12_042837_create_bahan_awals_table', 1),
(11, '2025_03_12_042909_create_history_inputs_table', 1),
(12, '2025_03_12_043200_create_akhir_terpakai_seharusnyas_table', 1),
(13, '2025_03_12_045257_create_menus_table', 1),
(14, '2025_03_12_045314_create_temporary_files_table', 1),
(15, '2025_03_12_045324_create_log_activities_table', 2),
(16, '2025_03_12_045333_create_notifikasis_table', 2),
(18, '2025_03_12_060225_create_komposisi_menus_table', 2),
(19, '2025_03_12_070515_create_deleted_items_table', 2),
(20, '2025_03_22_021220_create_bahan_akhirs_table', 2),
(21, '2025_03_12_045403_create_transaksis_table', 3),
(22, '2025_03_28_091206_create_transaksi_details_table', 3),
(23, '2025_04_14_022715_create_satuan_barangs_table', 4),
(24, '2025_04_14_022716_create_barangs_table', 5);

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
-- Struktur dari tabel `satuans`
--

CREATE TABLE `satuans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `satuans`
--

INSERT INTO `satuans` (`id`, `user_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Kg', '2025-03-22 04:22:08', '2025-03-22 04:22:08', NULL),
(2, 1, 'gram', '2025-03-22 04:28:30', '2025-03-22 04:28:30', NULL),
(3, 1, 'mL', '2025-03-22 04:29:32', '2025-03-22 04:29:32', NULL);

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
(1, 1, '-', '2025-04-14 02:45:49', '2025-04-14 02:45:49', NULL),
(2, 1, 'Pcs', '2025-04-14 02:45:49', '2025-04-14 02:45:49', NULL);

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
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksis`
--

INSERT INTO `transaksis` (`id`, `user_id`, `date`, `menu_name`, `menu_id`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '2025-04-10', NULL, 5, 10.000, '2025-04-09 22:02:40', '2025-04-09 22:02:40', NULL),
(2, 1, '2025-04-10', NULL, 6, 8.000, '2025-04-09 22:29:23', '2025-04-09 22:29:23', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_details`
--

CREATE TABLE `transaksi_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksi_details`
--

INSERT INTO `transaksi_details` (`id`, `transaksi_id`, `bahan_id`, `jumlah`, `satuan_id`, `catatan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 11, 500.000, 2, NULL, '2025-04-09 22:02:40', '2025-04-09 22:02:40', NULL),
(2, 1, 9, 1800.000, 3, NULL, '2025-04-09 22:02:40', '2025-04-09 22:02:40', NULL),
(3, 1, 5, 150.000, 2, NULL, '2025-04-09 22:02:40', '2025-04-09 22:02:40', NULL),
(4, 2, 5, 4400.000, 2, NULL, '2025-04-09 22:29:23', '2025-04-09 22:29:23', NULL),
(5, 2, 1, 0.000, 2, NULL, '2025-04-09 22:29:23', '2025-04-09 22:29:23', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('OWNER','MANAJER','STAF') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rendy Hartono Putra', 'rerena12', 'rerena12@gmail.com', '2025-03-21 19:54:15', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OWNER', 'ZPICGeCAWeDKCVPTq0bHgH4fh0dpyVTPxkErocn8tUslNRtHduDZnIcztqK2', '2025-03-21 19:54:15', '2025-03-21 19:54:15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akhir_terpakai_seharusnyas`
--
ALTER TABLE `akhir_terpakai_seharusnyas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `akhir_terpakai_seharusnyas_bahan_id_foreign` (`bahan_id`);

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
  ADD KEY `bahan_awals_bahan_id_foreign` (`bahan_id`);

--
-- Indeks untuk tabel `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangs_user_id_foreign` (`user_id`),
  ADD KEY `barangs_satuan_id_foreign` (`satuan_id`);

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
-- Indeks untuk tabel `history_inputs`
--
ALTER TABLE `history_inputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_inputs_user_id_foreign` (`user_id`),
  ADD KEY `history_inputs_bahan_id_foreign` (`bahan_id`);

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
-- Indeks untuk tabel `satuans`
--
ALTER TABLE `satuans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satuans_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `satuan_barangs_user_id_foreign` (`user_id`);

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
  ADD KEY `transaksi_details_bahan_id_foreign` (`bahan_id`),
  ADD KEY `transaksi_details_satuan_id_foreign` (`satuan_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akhir_terpakai_seharusnyas`
--
ALTER TABLE `akhir_terpakai_seharusnyas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `bahans`
--
ALTER TABLE `bahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT untuk tabel `bahan_awals`
--
ALTER TABLE `bahan_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT untuk tabel `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT untuk tabel `history_inputs`
--
ALTER TABLE `history_inputs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
-- AUTO_INCREMENT untuk tabel `satuans`
--
ALTER TABLE `satuans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `transaksi_details`
--
ALTER TABLE `transaksi_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akhir_terpakai_seharusnyas`
--
ALTER TABLE `akhir_terpakai_seharusnyas`
  ADD CONSTRAINT `akhir_terpakai_seharusnyas_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`);

--
-- Ketidakleluasaan untuk tabel `bahans`
--
ALTER TABLE `bahans`
  ADD CONSTRAINT `bahans_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuans` (`id`),
  ADD CONSTRAINT `bahans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `bahan_akhirs`
--
ALTER TABLE `bahan_akhirs`
  ADD CONSTRAINT `bahan_akhirs_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`),
  ADD CONSTRAINT `bahan_akhirs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `bahan_awals`
--
ALTER TABLE `bahan_awals`
  ADD CONSTRAINT `bahan_awals_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`);

--
-- Ketidakleluasaan untuk tabel `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuan_barangs` (`id`),
  ADD CONSTRAINT `barangs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `history_inputs`
--
ALTER TABLE `history_inputs`
  ADD CONSTRAINT `history_inputs_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`),
  ADD CONSTRAINT `history_inputs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  ADD CONSTRAINT `komposisi_menus_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`),
  ADD CONSTRAINT `komposisi_menus_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Ketidakleluasaan untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_tag_notifikasi_id_foreign` FOREIGN KEY (`tag_notifikasi_id`) REFERENCES `tag_notifikasis` (`id`),
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `satuans`
--
ALTER TABLE `satuans`
  ADD CONSTRAINT `satuans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `satuan_barangs`
--
ALTER TABLE `satuan_barangs`
  ADD CONSTRAINT `satuan_barangs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `tag_notifikasis`
--
ALTER TABLE `tag_notifikasis`
  ADD CONSTRAINT `tag_notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi_details`
--
ALTER TABLE `transaksi_details`
  ADD CONSTRAINT `transaksi_details_bahan_id_foreign` FOREIGN KEY (`bahan_id`) REFERENCES `bahans` (`id`),
  ADD CONSTRAINT `transaksi_details_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuans` (`id`),
  ADD CONSTRAINT `transaksi_details_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
