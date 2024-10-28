-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 01:44 PM
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
-- Database: `database_alumni`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nomor_induk` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `id_user`, `nama`, `nomor_induk`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin User', 'ADM001', '081234567890', '2024-10-28 05:42:11', '2024-10-28 05:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id_alumni` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nama_alumni` varchar(255) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `angkatan` varchar(255) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_tlp` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','pasif') NOT NULL DEFAULT 'pasif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id_alumni`, `id_user`, `nama_alumni`, `nim`, `angkatan`, `tanggal_lahir`, `alamat`, `no_tlp`, `email`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Noval Achmad Raisha', '3202116067', '2021', NULL, NULL, '081234567891', 'novalachmadraisha@gmail.com', NULL, 'pasif', '2024-10-28 05:42:11', '2024-10-28 05:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` bigint(20) UNSIGNED NOT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `deskripsi_berita` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_jawaban`
--

CREATE TABLE `data_jawaban` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_alumni` bigint(20) UNSIGNED NOT NULL,
  `id_pertanyaan` bigint(20) UNSIGNED NOT NULL,
  `jawaban_terbuka` varchar(255) DEFAULT NULL,
  `jawaban_skala` varchar(255) NOT NULL,
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lamaran`
--

CREATE TABLE `lamaran` (
  `id_lamaran` bigint(20) UNSIGNED NOT NULL,
  `id_alumni` bigint(20) UNSIGNED NOT NULL,
  `id_lowongan` bigint(20) UNSIGNED NOT NULL,
  `nama_pelamar` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `CV` varchar(255) NOT NULL,
  `transkrip_nilai` varchar(255) NOT NULL,
  `sertifikat` varchar(255) NOT NULL,
  `portopolio` varchar(255) NOT NULL,
  `status` enum('terima','tolak','pending') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lowongan`
--

CREATE TABLE `lowongan` (
  `id_lowongan` bigint(20) UNSIGNED NOT NULL,
  `nib` bigint(20) UNSIGNED NOT NULL,
  `judul_lowongan` varchar(255) NOT NULL,
  `posisi_pekerjaan` varchar(255) NOT NULL,
  `deskripsi_pekerjaan` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tipe_pekerjaan` enum('Full_time','Part_time','Contract') NOT NULL,
  `jumlah_kandidat` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `rentang_gaji` varchar(255) NOT NULL,
  `pengalaman_kerja` varchar(255) NOT NULL,
  `kontak` varchar(255) NOT NULL,
  `status` enum('terima','tolak','pending') NOT NULL,
  `tanggal_aktif` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_04_013859_create_personal_access_tokens_table', 1),
(5, '2024_10_04_014212_create_alumni_table', 1),
(6, '2024_10_04_014239_create_tracer_study_table', 1),
(7, '2024_10_04_014351_create_pertanyaan_table', 1),
(8, '2024_10_04_014423_create_perusahaan_table', 1),
(9, '2024_10_04_014437_create_lowongan_table', 1),
(10, '2024_10_13_091338_create_lamaran_table', 1),
(11, '2024_10_13_095249_create_admins_table', 1),
(12, '2024_10_25_002649_create_berita_table', 1),
(13, '2024_10_25_010956_create_data_jawaban_table', 1);

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', 'b3e809e27693b94d79b976342dbb73a9922c8a932b68c2bcaf92427f58a58b6e', '[\"*\"]', NULL, NULL, '2024-10-28 05:43:17', '2024-10-28 05:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id_pertanyaan` bigint(20) UNSIGNED NOT NULL,
  `pertanyaan` text NOT NULL,
  `jenis` enum('terbuka','skala') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `nib` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `sektor_bisnis` varchar(255) NOT NULL,
  `deskripsi_perusahaan` varchar(255) DEFAULT NULL,
  `jumlah_karyawan` varchar(255) DEFAULT NULL,
  `no_tlp` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `website_perusahaan` varchar(255) NOT NULL,
  `status` enum('mengunggu','diterima','ditolak') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracer_study`
--

CREATE TABLE `tracer_study` (
  `id_tracer_study` bigint(20) UNSIGNED NOT NULL,
  `id_pertanyaan` bigint(20) UNSIGNED NOT NULL,
  `id_alumni` bigint(20) UNSIGNED NOT NULL,
  `jawaban` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nomor_induk` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `nomor_induk`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 'Admin User', 'ADM001', 'admin123@gmail.com', '$2y$12$lyHTPnXPTLpFitA6nBHHYOHnISIxcE2dVBFtIOWNEFI65pyJKkX7C', NULL, '2024-10-28 05:42:11', '2024-10-28 05:42:11'),
(2, 1, 'Noval Achmad Raisha', '3202116067', 'novalachmadraisha@gmail.com', '$2y$12$l2fXmrJ1HWn50NfxKReqpOBw/9wgcOEwAkAR6NN4K4XnjEtYqOEXe', NULL, '2024-10-28 05:42:11', '2024-10-28 05:42:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admins_nomor_induk_unique` (`nomor_induk`),
  ADD KEY `admins_id_user_foreign` (`id_user`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id_alumni`),
  ADD UNIQUE KEY `alumni_nim_unique` (`nim`),
  ADD UNIQUE KEY `alumni_email_unique` (`email`),
  ADD KEY `alumni_id_user_foreign` (`id_user`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `data_jawaban`
--
ALTER TABLE `data_jawaban`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_jawaban_id_alumni_unique` (`id_alumni`),
  ADD UNIQUE KEY `data_jawaban_id_pertanyaan_unique` (`id_pertanyaan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id_lamaran`),
  ADD KEY `lamaran_id_alumni_foreign` (`id_alumni`),
  ADD KEY `lamaran_id_lowongan_foreign` (`id_lowongan`);

--
-- Indexes for table `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id_lowongan`),
  ADD UNIQUE KEY `lowongan_nib_unique` (`nib`);

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
-- Indexes for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`),
  ADD UNIQUE KEY `perusahaan_id_user_unique` (`id_user`),
  ADD UNIQUE KEY `perusahaan_email_unique` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_id_user_index` (`id_user`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tracer_study`
--
ALTER TABLE `tracer_study`
  ADD PRIMARY KEY (`id_tracer_study`),
  ADD UNIQUE KEY `tracer_study_id_pertanyaan_unique` (`id_pertanyaan`),
  ADD UNIQUE KEY `tracer_study_id_alumni_unique` (`id_alumni`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id_alumni` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_jawaban`
--
ALTER TABLE `data_jawaban`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id_lamaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id_lowongan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tracer_study`
--
ALTER TABLE `tracer_study`
  MODIFY `id_tracer_study` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `alumni_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD CONSTRAINT `lamaran_id_alumni_foreign` FOREIGN KEY (`id_alumni`) REFERENCES `alumni` (`id_alumni`),
  ADD CONSTRAINT `lamaran_id_lowongan_foreign` FOREIGN KEY (`id_lowongan`) REFERENCES `lowongan` (`id_lowongan`);

--
-- Constraints for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD CONSTRAINT `perusahaan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracer_study`
--
ALTER TABLE `tracer_study`
  ADD CONSTRAINT `tracer_study_id_alumni_foreign` FOREIGN KEY (`id_alumni`) REFERENCES `alumni` (`id_alumni`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
