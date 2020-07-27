-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2020 at 02:55 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `radiusdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bundle_plans`
--

CREATE TABLE `bundle_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plantitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `planname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` double(8,2) NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bundle_plans`
--

INSERT INTO `bundle_plans` (`id`, `plantitle`, `planname`, `cost`, `desc`, `mode`, `created_at`, `updated_at`) VALUES
(1, '50MBS', '50mbs', 10.00, 'No expiry date', NULL, NULL, NULL),
(2, '100MBS', '100mbs', 20.00, '100mbs with no expiry date', 'no expiry date', NULL, NULL),
(3, '250MBS', '250mbs', 40.00, '250mbs without expiry', NULL, NULL, NULL),
(4, 'Daily Plan', 'dailyplan', 50.00, 'valid for 24 hours', NULL, NULL, NULL),
(5, '200 MBS', '200mbs', 30.00, 'bundle with no expiry', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(100) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `cleartextpassword` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role_id` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_06_30_144451_create_bundle_plans_table', 1),
(5, '2020_07_23_125338_create_notifications_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('2b8b77fb-b1e2-4d16-9a16-b37f06e8210e', 'App\\Notifications\\PlanPaid', 'App\\Customer', 5, '{\"user_id\":5,\"user_name\":\"kamau1\",\"not_message\":\"kamau1 created an account\"}', NULL, '2020-07-23 15:48:46', '2020-07-23 15:48:46'),
('5a4786ca-b608-412d-b97c-75471b08590a', 'App\\Notifications\\PlanPaid', 'App\\Customer', 3, '{\"user_id\":6,\"user_name\":\"clement\",\"not_message\":\"clement created an account\"}', NULL, '2020-07-23 16:25:26', '2020-07-23 16:25:26'),
('5ac365df-fddb-4821-b7a3-fb9f5728e705', 'App\\Notifications\\PlanPaid', 'App\\Customer', 1, '{\"user_id\":1,\"user_name\":\"hidiamin\"}', NULL, '2020-07-23 14:07:24', '2020-07-23 14:07:24'),
('e8417caa-a369-4674-9281-2ae07541ce26', 'App\\Notifications\\PlanPaid', 'App\\Customer', 1, '{\"user_id\":1,\"user_name\":\"hidiamin\"}', '2020-07-23 14:01:25', '2020-07-23 13:54:27', '2020-07-23 14:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `amount` double(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `amount`) VALUES
(1, 'dailyplan', 50.00),
(2, 'weekly', 300.00),
(3, '20gb', 1000.00),
(4, '200gb', 3000.00),
(5, '20gb', 1000.00),
(6, '20gb', 1000.00),
(7, '20gb', 1000.00),
(8, '20gb', 1000.00),
(9, '20gb', 1000.00),
(10, '20gb', 1000.00),
(11, '20gb', 1000.00),
(12, '20gb', 1000.00),
(13, '20gb', 1000.00),
(14, '20gb', 1000.00),
(15, '20gb', 1000.00);

--
-- Table structure for table `tempaccount`
--

CREATE TABLE `tempaccount` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone` int(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tempaccount`
--

INSERT INTO `tempaccount` (`id`, `name`, `phone`, `email`, `username`, `password`) VALUES
(1, 'morris mbae', 701530647, 'morrisdestro@gmail.com', 'destro', '123456'),
(2, 'mike mortisonm', 790261115, '', 'mike', '123456'),
(3, 'Morris Mbae', 703330749, 'dianamukami@gmail.com', 'kami', '123456'),
(4, 'MORRIS MBAE', 701234566, '', 'fort', 'fort'),
(5, 'loplop l', 799009890, '', 'lopi', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `transaction_date` varchar(100) NOT NULL,
  `phone_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `username`, `payment_method`, `amount`, `plan`, `transaction_id`, `transaction_date`, `phone_number`) VALUES
(1, 'destro', 'M-Pesa', '1', 'dailyplan', 'OC47IP5P95', '2147483647', '2147483647'),
(2, 'RHCVL3', 'Mpesa', '1', 'dailyplan', 'OG24ETKXWQ', '20200702085757', '254701530647');


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bundle_plans`
--
ALTER TABLE `bundle_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);
--
-- Indexes for table `tempaccount`
--
ALTER TABLE `tempaccount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
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
-- AUTO_INCREMENT for table `bundle_plans`
--
ALTER TABLE `bundle_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tempaccount`
--
ALTER TABLE `tempaccount`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

DELIMITER $$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
