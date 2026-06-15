-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2026 at 02:28 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webgis_pdam`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_02_12_035346_create_pipes_table', 1),
(6, '2026_02_17_140257_modify_status_enum_on_pipes_table', 1),
(7, '2026_02_19_045759_add_role_to_users_table', 2),
(8, '2026_04_20_133847_add_is_active_to_users_table', 3),
(9, '2026_04_27_010903_add_force_password_change_to_users_table', 4),
(10, '2026_05_03_120735_add_timeline_to_pipes_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pipes`
--

CREATE TABLE `pipes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pipe_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length` double DEFAULT NULL,
  `planned_at` date DEFAULT NULL,
  `installed_at` date DEFAULT NULL,
  `geometry` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pipes`
--

INSERT INTO `pipes` (`id`, `name`, `pipe_type`, `length`, `planned_at`, `installed_at`, `geometry`, `created_at`, `updated_at`) VALUES
(9, 'Pipa Bandara', 'PVC', 913.69594427762, '2025-07-08', '2026-05-05', '{\"type\":\"LineString\",\"coordinates\":[[107.579938,-6.904092],[107.582953,-6.904987],[107.586976,-6.906387],[107.58718,-6.906435],[107.587658,-6.9066],[107.58777,-6.906702]]}', '2026-03-04 19:11:47', '2026-05-10 00:10:28'),
(21, 'Pipa Stasiun', 'Sekunder', 633, '2025-05-01', NULL, '{\"type\":\"LineString\",\"coordinates\":[[107.59815573692323,-6.9124211855468],[107.59896576404573,-6.912410534695595],[107.60069310665132,-6.912522368621326],[107.60387957096101,-6.912714083861033]]}', '2026-04-13 23:53:48', '2026-05-12 21:01:13'),
(39, 'Pipa jl.Sukajadi', 'Sekunder', 844, '2020-05-04', '2020-05-13', '{\"type\":\"LineString\",\"coordinates\":[[107.5814723968506,-6.884504481462231],[107.58139193058015,-6.88796087379729],[107.58155286312105,-6.889729003128102],[107.58152604103088,-6.890613065321237],[107.58139729499818,-6.891555708132913],[107.58123099803926,-6.8920509942828225]]}', '2026-04-15 21:03:39', '2026-05-22 22:34:47'),
(40, 'Pipa arah Tol Pasteur', 'Primer', 596, '2024-06-03', NULL, '{\"type\":\"LineString\",\"coordinates\":[[107.5813114643097,-6.892184135632707],[107.58213222026826,-6.892290648685705],[107.58358597755432,-6.892258694772325],[107.58456230163576,-6.892418464317688],[107.58558154106142,-6.892844516175402],[107.58640766143799,-6.893435662493624]]}', '2026-04-15 21:07:23', '2026-05-12 21:01:22'),
(41, 'Pipa Paskal23', 'PVC', 343, '2025-04-15', NULL, '{\"type\":\"LineString\",\"coordinates\":[[107.59814500808717,-6.916191571790329],[107.59806990623476,-6.915190398716247],[107.59807527065277,-6.914604604976208],[107.59809136390687,-6.913965556431433],[107.59797334671022,-6.913113490360615]]}', '2026-04-16 18:08:28', '2026-05-12 21:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `force_password_change` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `is_active`, `force_password_change`) VALUES
(1, 'Admin 1', 'admin1@pipa.com', NULL, '$2y$12$FQJrQYby2cXmwUlaKWMtJepR5M/saspgJJsI92d5ixrGi58DI1kDy', NULL, '2026-02-18 21:55:58', '2026-06-06 01:07:04', 'admin', 1, 0),
(2, 'Super Admin', 'superadmin@pipa.com', NULL, '$2y$12$Le5pzYnzjC05Ob4fTbDYIen2vFH6ZYbEyiAyJK/XBsYfZswFOMZZ6', 'oVo4T61XiFDFyoCYiHuOWFMcI8ONl5uKoIg7ND5sFrXUZLI1M4yGibAYgcDC', '2026-04-23 23:47:23', '2026-04-23 23:47:23', 'super_admin', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `pipes`
--
ALTER TABLE `pipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pipes`
--
ALTER TABLE `pipes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
