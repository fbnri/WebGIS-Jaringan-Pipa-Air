-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2026 at 12:43 PM
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
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `address`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Pelanggan A', 'Bandung', -6.9044646, 107.5802668, NULL, NULL),
(2, 'Pelanggan B', 'Bandung', -6.9044953, 107.5804049, NULL, NULL);

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
(10, '2026_05_03_120735_add_timeline_to_pipes_table', 5),
(11, '2026_06_20_013247_create_customers_table', 6);

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
(9, 'Pipa Bandara Husein Sastranegara', 'Sekunder', 913.69594427762, '2022-01-04', NULL, '{\"type\":\"LineString\",\"coordinates\":[[107.579938,-6.904092],[107.582953,-6.904987],[107.586976,-6.906387],[107.58718,-6.906435],[107.587658,-6.9066],[107.58777,-6.906702]]}', '2026-03-04 19:11:47', '2026-06-17 05:11:40'),
(21, 'Pipa Stasiun', 'Primer', 633, '2025-05-01', NULL, '{\"type\":\"LineString\",\"coordinates\":[[107.59815573692323,-6.9124211855468],[107.59896576404573,-6.912410534695595],[107.60069310665132,-6.912522368621326],[107.60387957096101,-6.912714083861033]]}', '2026-04-13 23:53:48', '2026-06-15 00:31:35'),
(39, 'Pipa jl.Sukajadi', 'Primer', 844, '2020-05-04', '2026-06-15', '{\"type\":\"LineString\",\"coordinates\":[[107.5814723968506,-6.884504481462231],[107.58139193058015,-6.88796087379729],[107.58155286312105,-6.889729003128102],[107.58152604103088,-6.890613065321237],[107.58139729499818,-6.891555708132913],[107.58123099803926,-6.8920509942828225]]}', '2026-04-15 21:03:39', '2026-06-15 00:56:30'),
(41, 'Pipa Paskal23', 'Primer', 343, '2025-04-15', NULL, '{\"type\":\"LineString\",\"coordinates\":[[107.59814500808717,-6.916191571790329],[107.59806990623476,-6.915190398716247],[107.59807527065277,-6.914604604976208],[107.59809136390687,-6.913965556431433],[107.59797334671022,-6.913113490360615]]}', '2026-04-16 18:08:28', '2026-06-15 00:31:24'),
(82, 'Pipa Pasupati', 'Primer', 4546, '2020-05-19', '2022-03-09', '{\"type\":\"LineString\",\"coordinates\":[[107.58124709129335,-6.892226740856781],[107.58212685585023,-6.892343905203222],[107.583886384964,-6.892322602596935],[107.5851094722748,-6.892642141590743],[107.5870943069458,-6.894005505543824],[107.5895941257477,-6.8958268684545265],[107.59223341941835,-6.897254130403427],[107.5935745239258,-6.8983192484585425],[107.59516239166261,-6.899735851760049],[107.59566664695741,-6.900076688012117],[107.5963318347931,-6.900236454920813],[107.60426044464113,-6.900279059420687],[107.60526895523073,-6.89983171198075],[107.6085412502289,-6.898095573865665],[107.60935664176942,-6.898095573865665],[107.61031150817873,-6.898383155465675],[107.61162042617799,-6.898894411212267],[107.61594414711,-6.8990222250626685],[107.61800408363344,-6.89930980609995],[107.61923789978029,-6.89930980609995]]}', '2026-06-14 21:09:24', '2026-06-15 00:30:10'),
(83, 'Pipa Sumber 1', 'Primer', 314, '2020-01-15', '2020-04-09', '{\"type\":\"LineString\",\"coordinates\":[[107.61015594005586,-6.895731007423255],[107.60960876941681,-6.895933380688748],[107.60950148105623,-6.896119777040997],[107.60963559150697,-6.896737547284152],[107.609640955925,-6.897264781595842],[107.60960876941681,-6.897765387368821],[107.6095497608185,-6.898132852971812]]}', '2026-06-14 21:29:11', '2026-06-17 05:10:39'),
(84, 'Pipa jl.Cokroaminoto', 'Primer', 1422, '2020-08-12', '2021-05-15', '{\"type\":\"LineString\",\"coordinates\":[[107.597393989563,-6.900311012793081],[107.59798407554628,-6.913081537853065]]}', '2026-06-15 00:27:46', '2026-06-15 00:30:53'),
(86, 'Pipa Jl.Merdeka', 'Primer', 2006, '2021-01-13', '2023-07-17', '{\"type\":\"LineString\",\"coordinates\":[[107.61277914047243,-6.898958318141781],[107.61273622512819,-6.899906269916756],[107.61070847511293,-6.9045607921004075],[107.61060118675233,-6.90496553099642],[107.6106119155884,-6.9099821343540295],[107.6105046272278,-6.912282724462337],[107.61008083820344,-6.916548372319819]]}', '2026-06-17 05:04:02', '2026-06-17 05:04:02'),
(87, 'Pipa Bapak A', 'Tersier', 25, '2022-12-08', NULL, '{\"type\":\"LineString\",\"coordinates\":[[107.58036196231843,-6.904230610113018],[107.58030831813812,-6.904448956291762]]}', '2026-06-17 05:13:50', '2026-06-17 05:14:25'),
(88, 'Pipa Ibu B', 'Tersier', 19, '2026-12-08', NULL, '{\"type\":\"LineString\",\"coordinates\":[[107.58061945438385,-6.904310492873025],[107.58057653903963,-6.904475583867642]]}', '2026-06-17 05:15:11', '2026-06-17 05:15:11'),
(89, 'Pipa jl.Tamansari', 'Primer', 934, '2022-02-16', '2023-02-07', '{\"type\":\"LineString\",\"coordinates\":[[107.6095497608185,-6.8981488297306965],[107.60950684547426,-6.898383155465675],[107.60932981967927,-6.898739969430336],[107.60928690433504,-6.8990275506390235],[107.6093351840973,-6.899315131673073],[107.60944247245789,-6.899544131260443],[107.60935664176942,-6.900092664705406],[107.60915815830232,-6.9004494773818665],[107.60810136795045,-6.902036491699581],[107.60802090168,-6.902249513350612],[107.60806381702425,-6.902702184040736],[107.60816574096681,-6.902909879859543],[107.60845541954042,-6.903287992526437],[107.6081281900406,-6.904203982523346],[107.60801553726196,-6.904992158543231],[107.60765075683594,-6.905822937250875]]}', '2026-06-17 05:20:26', '2026-06-17 05:20:26'),
(90, 'Pipa jl.Tamansari', 'Primer', 28, '2022-02-22', '2023-02-28', '{\"type\":\"LineString\",\"coordinates\":[[107.60781168937685,-6.905418199088362],[107.60756492614748,-6.90546612862569]]}', '2026-06-17 05:21:14', '2026-06-17 05:22:09');

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
(1, 'Admin 1', 'admin1@pipa.com', NULL, '$2y$12$FQJrQYby2cXmwUlaKWMtJepR5M/saspgJJsI92d5ixrGi58DI1kDy', NULL, '2026-02-18 21:55:58', '2026-06-14 18:03:42', 'admin', 1, 0),
(2, 'Super Admin', 'superadmin@pipa.com', NULL, '$2y$12$Le5pzYnzjC05Ob4fTbDYIen2vFH6ZYbEyiAyJK/XBsYfZswFOMZZ6', '5MrWR6mTRmXtqteLqyAIkw3RIWztenyStTwr3fmztFNTX0jaeDPpqRkv6B6T', '2026-04-23 23:47:23', '2026-04-23 23:47:23', 'super_admin', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pipes`
--
ALTER TABLE `pipes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
