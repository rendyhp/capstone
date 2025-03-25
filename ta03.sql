-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Mar 2025 pada 08.10
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
(14, 1, 'TEST', 'des', 7.522, 1, '2025-03-24 21:10:26', '2025-03-24 22:51:06', NULL);

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
(59, 1, '2025-03-19', 14, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL);

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
(58, '2025-03-20', 14, 0.000, '2025-03-24 22:35:48', '2025-03-24 22:35:48', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barangs`
--

INSERT INTO `barangs` (`id`, `user_id`, `name`, `description`, `jumlah`, `satuan`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Gelas', 'AW', -56.750, 'Pcs', NULL, '2025-03-21 19:56:40', '2025-03-24 20:30:57', NULL),
(4, 1, 'Setrika', '-', 2.000, '-', NULL, '2025-03-21 20:04:59', '2025-03-24 19:51:09', NULL),
(5, 1, 'Piring', '-', 22.000, '-', NULL, '2025-03-21 20:57:32', '2025-03-21 20:57:32', NULL),
(6, 1, 'Kursi indoor', '-', 15.500, '-', NULL, '2025-03-24 19:46:51', '2025-03-24 19:46:51', NULL),
(7, 1, 'Meja', '-', 2.043, '-', NULL, '2025-03-24 20:50:43', '2025-03-24 20:51:35', NULL);

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
(1, 1, 1, 50.000, '2025-03-24 05:34:17', '2025-03-24 05:34:17', NULL),
(2, 1, 2, 200.000, '2025-03-24 05:34:17', '2025-03-24 05:34:17', NULL),
(4, 5, 11, 50.000, '2025-03-23 23:45:29', '2025-03-23 23:45:29', NULL),
(5, 5, 9, 180.000, '2025-03-23 23:45:29', '2025-03-23 23:45:29', NULL),
(6, 5, 5, 15.000, '2025-03-23 23:45:29', '2025-03-23 23:45:29', NULL);

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
(5, 1, 'Hot Chocolate', '-', NULL, '2025-03-23 23:45:29', '2025-03-23 23:45:29', NULL);

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
(8, '2025_03_12_042720_create_barangs_table', 1),
(9, '2025_03_12_042747_create_bahans_table', 1),
(10, '2025_03_12_042837_create_bahan_awals_table', 1),
(11, '2025_03_12_042909_create_history_inputs_table', 1),
(12, '2025_03_12_043200_create_akhir_terpakai_seharusnyas_table', 1),
(13, '2025_03_12_045257_create_menus_table', 1),
(14, '2025_03_12_045314_create_temporary_files_table', 1),
(15, '2025_03_12_045324_create_log_activities_table', 2),
(16, '2025_03_12_045333_create_notifikasis_table', 2),
(17, '2025_03_12_045403_create_transaksis_table', 2),
(18, '2025_03_12_060225_create_komposisi_menus_table', 2),
(19, '2025_03_12_070515_create_deleted_items_table', 2),
(20, '2025_03_22_021220_create_bahan_akhirs_table', 2);

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
  `menu` varchar(255) NOT NULL,
  `jumlah` decimal(12,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  ADD KEY `barangs_user_id_foreign` (`user_id`);

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
  ADD KEY `transaksis_user_id_foreign` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `bahan_awals`
--
ALTER TABLE `bahan_awals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `komposisi_menus`
--
ALTER TABLE `komposisi_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Ketidakleluasaan untuk tabel `tag_notifikasis`
--
ALTER TABLE `tag_notifikasis`
  ADD CONSTRAINT `tag_notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
