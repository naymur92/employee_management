-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2023 at 06:32 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `type` tinyint(4) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `email_verified_at`, `status`, `type`, `password`, `remember_token`, `created_at`, `updated_at`, `google_id`) VALUES
(1, 'Naymur Rahman', 'naymur@example.com', NULL, 1, 1, '$2y$10$hFnzlT/Z9OzKzkbsxeGWDOlZlgXa49nvoSbuwiPpUc7TytA8qIudS', NULL, '2023-03-16 23:48:40', '2023-03-16 23:48:40', NULL),
(2, 'Kamrul Hasan', 'kamrul@example.com', NULL, 1, 0, '$2y$10$hLsyZ4ovlM6e7og29T.n2eEvswj0h4BU.8tkr.iPJ2JuMviNzPrgC', NULL, '2023-03-16 23:48:40', '2023-03-18 00:38:37', NULL),
(3, 'Alauddin Alo', 'alo@example.com', NULL, 1, 0, '$2y$10$opuvjwlimYINYqyOFa5s5uHUrXAjaLm7zoekRh2X/y1OFKRiw3crG', NULL, '2023-03-17 07:17:14', '2023-03-17 07:17:14', NULL),
(6, 'Naymur Rahman', 'naim.mict@gmail.com', NULL, 1, 0, '$2y$10$IuMqRN59IzgWzQMEqnv9aelDZaYjUpFVVS5bTxKgBCaFS8vnqjfW2', NULL, '2023-03-17 08:56:16', '2023-03-18 13:40:16', '109947788424447267070'),
(10, 'Fayzullah Aman', 'aman@example.com', NULL, 1, 0, '$2y$10$27/Oqo1qQBHZXBDKc0KQT.MnL072hBK3kWB67ARQwhZwAZUi6.lVy', NULL, '2023-03-19 02:42:14', '2023-03-19 02:42:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendances`
--

CREATE TABLE `employee_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `entry_time` time DEFAULT NULL,
  `exit_time` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_attendances`
--

INSERT INTO `employee_attendances` (`id`, `employee_id`, `date`, `entry_time`, `exit_time`, `created_at`, `updated_at`) VALUES
(2, 1, '2023-03-18', '16:42:06', '17:03:53', '2023-03-18 10:30:25', '2023-03-18 11:03:53'),
(4, 6, '2023-03-18', '17:30:27', '17:32:35', '2023-03-18 11:30:27', '2023-03-18 11:32:35'),
(5, 6, '2023-03-17', '09:48:02', '17:08:02', NULL, NULL),
(6, 6, '2023-03-01', '08:48:02', '17:08:02', NULL, NULL),
(7, 6, '2023-03-02', '08:51:47', '17:51:47', NULL, NULL),
(8, 6, '2023-03-16', '09:01:02', '17:08:02', NULL, NULL),
(9, 6, '2023-03-15', '08:59:02', '17:08:02', NULL, NULL),
(10, 6, '2023-03-14', '08:59:59', '17:08:02', NULL, NULL),
(11, 3, '2023-03-16', '09:01:02', '17:08:02', NULL, NULL),
(12, 3, '2023-03-15', '08:59:02', '17:08:02', NULL, NULL),
(13, 3, '2023-03-14', '08:59:59', '17:08:02', NULL, NULL),
(14, 2, '2023-03-16', '09:01:02', '17:08:02', NULL, NULL),
(15, 2, '2023-03-15', '08:59:02', '17:08:02', NULL, NULL),
(16, 2, '2023-03-14', '08:59:59', '17:08:02', NULL, NULL),
(17, 1, '2023-03-19', '07:18:45', NULL, '2023-03-19 01:18:45', '2023-03-19 01:18:45'),
(22, 10, '2023-03-19', '09:24:17', NULL, '2023-03-19 03:24:17', '2023-03-19 03:25:30');

-- --------------------------------------------------------

--
-- Table structure for table `employee_contacts`
--

CREATE TABLE `employee_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(15) NOT NULL,
  `contact_relation` varchar(15) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_contacts`
--

INSERT INTO `employee_contacts` (`id`, `employee_id`, `contact_name`, `contact_email`, `contact_phone`, `contact_relation`, `created_at`, `updated_at`) VALUES
(3, 3, 'Naymur Rahman', 'naymur@example.com', '01737036324', 'Roommate', '2023-03-17 07:17:14', '2023-03-17 23:29:32'),
(5, 3, 'Kamrul Hassan Sohag', 'sohag@example.com', '01745896325', 'Friend', '2023-03-17 23:29:32', '2023-03-17 23:29:32'),
(6, 6, 'Abdul Haque', NULL, '01735678566', 'Father', '2023-03-17 23:45:35', '2023-03-17 23:45:35'),
(8, 1, 'Abdul Haque', NULL, '01735678566', 'Father', '2023-03-18 11:27:53', '2023-03-18 11:27:53'),
(9, 6, 'Kamrul Hassan Sohag', 'sohag@example.com', '01745896325', 'Friend', '2023-03-18 13:37:47', '2023-03-18 13:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `employee_details`
--

CREATE TABLE `employee_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` varchar(5) NOT NULL,
  `dob` date NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_details`
--

INSERT INTO `employee_details` (`id`, `employee_id`, `job_title`, `address`, `gender`, `dob`, `photo`, `created_at`, `updated_at`) VALUES
(2, 3, 'Junior Software Engineer', 'Banasree, Dhaka', 'Male', '1991-10-10', '(3).png', '2023-03-17 07:17:14', '2023-03-17 23:22:13'),
(3, 6, 'Software Engineer', 'Mirpur', 'Male', '1993-10-10', '(6).jpg', '2023-03-17 23:45:35', '2023-03-18 13:40:16'),
(4, 1, 'Software Engineer', 'Banasree, Dhaka', 'Male', '1993-10-10', '(1).jpg', '2023-03-18 11:27:53', '2023-03-18 15:47:10');

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
(1, '2014_10_12_000000_create_employees_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_17_123105_create_employee_details_table', 2),
(6, '2023_03_17_123120_create_employee_contacts_table', 2),
(7, '2023_03_17_133808_add_google_id_column', 3),
(8, '2023_03_18_071758_create_employee_attendances_table', 4);

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`);

--
-- Indexes for table `employee_attendances`
--
ALTER TABLE `employee_attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_attendances_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_contacts`
--
ALTER TABLE `employee_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_contacts_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_details_employee_id_foreign` (`employee_id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee_attendances`
--
ALTER TABLE `employee_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `employee_contacts`
--
ALTER TABLE `employee_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee_details`
--
ALTER TABLE `employee_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_attendances`
--
ALTER TABLE `employee_attendances`
  ADD CONSTRAINT `employee_attendances_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_contacts`
--
ALTER TABLE `employee_contacts`
  ADD CONSTRAINT `employee_contacts_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_details`
--
ALTER TABLE `employee_details`
  ADD CONSTRAINT `employee_details_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
