-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2025 at 11:13 AM
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
-- Database: `online_ticket_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `details`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'hhgfv', NULL, '1729157467.jpg', 1, '2024-10-17 09:31:07', '2024-10-17 09:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_details` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `company_id`, `name`, `short_details`, `status`, `created_at`, `updated_at`) VALUES
(3, 3, 'abcd', 'hgdfyhsfg', 1, '2024-10-24 07:31:29', '2024-10-24 07:31:29'),
(4, 1, 'Air Conditioning (AC)', 'Test', 1, '2025-01-11 04:14:54', '2025-01-11 04:14:54'),
(5, 1, 'Blanket and Pillow', 'Test', 1, '2025-01-11 04:15:18', '2025-01-11 04:15:18'),
(6, 1, 'Wi-Fi Connectivity', 'Test', 1, '2025-01-11 04:15:31', '2025-01-11 04:15:31'),
(7, 1, 'TV/Monitor Screens', 'Test', 1, '2025-01-11 04:16:06', '2025-01-11 04:16:06'),
(8, 9, 'TV/Monitor Screens', 'Test', 1, '2025-02-04 05:48:29', '2025-02-04 05:48:29'),
(9, 9, 'Wi-Fi Connectivity', 'Test', 1, '2025-02-04 05:48:43', '2025-02-04 05:48:50'),
(10, 9, 'Blanket and Pillow', 'Test', 1, '2025-02-04 05:49:00', '2025-02-04 05:49:00'),
(11, 9, 'Air Conditioning (AC)', 'Test', 1, '2025-02-04 05:49:09', '2025-02-04 05:49:09');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `plane_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `plane_journey_id` bigint(20) UNSIGNED NOT NULL,
  `passengers_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`passengers_name`)),
  `passengers_phone` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`passengers_phone`)),
  `passengers_passport_no` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`passengers_passport_no`)),
  `passengers_age` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`passengers_age`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `plane_id`, `company_id`, `plane_journey_id`, `passengers_name`, `passengers_phone`, `passengers_passport_no`, `passengers_age`, `created_at`, `updated_at`) VALUES
(17, 6, 2, 1, 5, '[\"John Doe\",\"Jane Smith\"]', '[\"1234567890\",\"9876543210\"]', '[\"A1234567\",\"B9876543\"]', '[\"30\",\"25\"]', '2024-11-18 06:07:31', '2024-11-18 06:07:31');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `company_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'dsh', 1, '2024-10-19 06:58:33', '2024-10-19 06:58:33'),
(2, 1, 'dfsf', 1, '2024-10-19 06:58:36', '2024-10-19 06:58:36'),
(3, 1, 'Hollee Ferguson', 1, '2024-10-19 10:26:03', '2024-10-19 10:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `checkers`
--

CREATE TABLE `checkers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `nid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `checkers`
--

INSERT INTO `checkers` (`id`, `company_id`, `name`, `email`, `phone`, `address`, `nid`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mithi', 'mithi@gmail.com', '01754896512', 'Dhaka', '14523657854', '1', '2025-01-08 09:52:33', '2025-01-11 04:19:11'),
(2, 9, 'Checker1', 'checker1@gmail.com', '01766829756', 'Jatrabari', '1245896597', '1', '2025-02-04 05:35:44', '2025-02-18 07:37:12'),
(3, 9, 'Checker2', 'checker2@gmail.com', '01766829778', 'Bangla Bazar', '1245896542', '1', '2025-02-04 05:36:15', '2025-02-18 07:36:51');

-- --------------------------------------------------------

--
-- Table structure for table `counters`
--

CREATE TABLE `counters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `counter_no` varchar(255) DEFAULT NULL,
  `location_id` int(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `counters`
--

INSERT INTO `counters` (`id`, `company_id`, `name`, `counter_no`, `location_id`, `status`, `created_at`, `updated_at`) VALUES
(9, 9, 'Gabtoli Counter', '1', 6, '1', '2025-02-17 09:18:07', '2025-02-17 09:18:07'),
(10, 9, 'Sayedabad Counter', '1', 7, '1', '2025-02-17 09:25:48', '2025-02-18 07:05:13'),
(11, 9, 'Laboni Beach Counter', NULL, 8, '1', '2025-02-17 09:26:15', '2025-02-18 07:05:03'),
(12, 9, 'Bypass Counter', NULL, 10, '1', '2025-02-17 09:26:36', '2025-02-18 07:04:57'),
(13, 9, 'Jessore Sadar Counter', NULL, 12, '1', '2025-02-17 09:27:16', '2025-02-18 07:04:51'),
(14, 9, 'Rupatoli Counter', NULL, 19, '1', '2025-02-17 09:28:08', '2025-02-18 07:04:46'),
(15, 9, 'Kuakata Counter', NULL, 15, '1', '2025-02-17 09:28:33', '2025-02-18 07:04:39'),
(16, 9, 'Srimangal Counter', NULL, 16, '1', '2025-02-17 09:28:58', '2025-02-18 07:04:33'),
(17, 9, 'Pangsha Counter', '1', 5, '1', '2025-02-17 09:30:37', '2025-02-18 07:04:27'),
(18, 9, 'Rajbari Bus Terminal Counter', NULL, 20, '1', '2025-02-17 09:31:57', '2025-02-18 07:04:03'),
(19, 9, 'Barishal Counter', NULL, 19, '1', '2025-02-17 11:39:41', '2025-02-18 07:00:58'),
(20, 9, 'Gabtoli Counter', '2', 6, '1', '2025-02-18 07:00:47', '2025-02-18 07:00:47'),
(21, 9, 'Gabtoli Counter', '3', 6, '1', '2025-02-18 07:05:32', '2025-02-18 07:05:32');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bangladesh', 1, '2024-11-04 09:52:55', '2024-11-04 09:52:55'),
(3, 'America', 1, '2024-11-04 10:49:14', '2024-11-04 10:49:14');

-- --------------------------------------------------------

--
-- Table structure for table `cupons`
--

CREATE TABLE `cupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `cupon_code` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `minimum_expend` int(11) NOT NULL,
  `discount_amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cupons`
--

INSERT INTO `cupons` (`id`, `company_id`, `cupon_code`, `start_date`, `end_date`, `minimum_expend`, `discount_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 'g123', '2024-11-05', '2024-11-07', 2000, 200, '2024-11-05 05:38:18', '2024-11-05 05:38:27'),
(2, 1, 'g127', '2024-11-07', '2024-11-08', 2000, 120, '2024-11-07 06:17:58', '2024-11-07 06:17:58');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `division_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gazipur', 1, '2025-01-11 04:09:57', '2025-01-11 04:09:57'),
(2, 1, 'Dhaka', 1, '2025-01-11 04:10:22', '2025-01-11 04:10:22'),
(3, 1, 'Rajbari', 1, '2025-01-11 04:10:33', '2025-01-11 04:10:33'),
(4, 2, 'Bogura', 1, '2025-01-11 04:13:50', '2025-01-11 04:13:50'),
(5, 2, 'Pabna', 1, '2025-02-17 06:19:29', '2025-02-17 06:19:29'),
(6, 3, 'Jessore', 1, '2025-02-17 06:20:13', '2025-02-17 06:20:13'),
(7, 7, 'Cox’s Bazar', 1, '2025-02-17 06:21:28', '2025-02-17 06:21:28'),
(8, 7, 'Cumilla', 1, '2025-02-17 06:21:45', '2025-02-17 06:21:45'),
(9, 2, 'Natore', 1, '2025-02-17 06:22:01', '2025-02-17 06:22:01'),
(10, 3, 'Bagerhat', 1, '2025-02-17 06:22:25', '2025-02-17 06:22:47'),
(11, 6, 'Patuakhali', 1, '2025-02-17 06:23:03', '2025-02-17 06:23:03'),
(12, 6, 'Jhalokathi', 1, '2025-02-17 06:23:21', '2025-02-17 06:23:21'),
(13, 5, 'Panchagarh', 1, '2025-02-17 06:23:43', '2025-02-17 06:23:43'),
(14, 5, 'Dinajpur', 1, '2025-02-17 06:23:52', '2025-02-17 06:23:52'),
(15, 4, 'Moulvibazar', 1, '2025-02-17 06:24:11', '2025-02-17 06:24:11'),
(16, 7, 'Chattogram', 1, '2025-02-17 06:25:10', '2025-02-17 06:25:10'),
(17, 6, 'Barishal', 1, '2025-02-17 06:25:35', '2025-02-17 06:25:35'),
(18, 5, 'Rangpur', 1, '2025-02-17 06:25:43', '2025-02-17 06:25:43'),
(19, 4, 'Sylhet', 1, '2025-02-17 06:25:52', '2025-02-17 06:25:52'),
(20, 3, 'Khulna', 1, '2025-02-17 06:26:00', '2025-02-17 06:26:00'),
(21, 2, 'Rajshahi', 1, '2025-02-17 06:26:09', '2025-02-17 06:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka', 1, '2025-01-11 04:09:31', '2025-01-11 04:09:31'),
(2, 'Rajshahi', 1, '2025-01-11 04:09:41', '2025-01-11 04:09:41'),
(3, 'Khulna', 1, '2025-02-17 06:19:57', '2025-02-17 06:19:57'),
(4, 'Sylhet', 1, '2025-02-17 06:20:28', '2025-02-17 06:20:28'),
(5, 'Rangpur', 1, '2025-02-17 06:20:37', '2025-02-17 06:20:37'),
(6, 'Barishal', 1, '2025-02-17 06:20:48', '2025-02-17 06:20:48'),
(7, 'Chattogram', 1, '2025-02-17 06:21:15', '2025-02-17 06:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `license` varchar(255) NOT NULL,
  `nid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `company_id`, `name`, `email`, `phone`, `address`, `license`, `nid`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 'Karim', 'karim@gmail.com', '01785625896', 'Dhaka', 'uploads/driverLicense/1736402765.pdf', '12458965412', '1', '2025-01-09 06:06:05', '2025-01-11 04:19:42'),
(5, 9, 'Driver1', 'driver1@gmail.com', '01766829719', 'Bangla Bazar', 'uploads/driverLicense/1738647771.pdf', '1245896548', '1', '2025-02-04 05:42:51', '2025-02-18 07:35:34'),
(6, 9, 'Driver2', 'driver2@gmail.com', '01766829715', 'Bangla Bazar', 'uploads/driverLicense/1738647821.pdf', '1245896541', '1', '2025-02-04 05:43:41', '2025-02-18 07:35:27');

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journey_types`
--

CREATE TABLE `journey_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journey_types`
--

INSERT INTO `journey_types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'One Way', 1, '2024-11-04 09:21:42', '2024-11-04 09:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `country_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dhaka', '1', '2024-11-04 10:49:25', '2024-11-04 10:49:40'),
(3, 3, 'New York', '1', '2024-11-05 10:30:53', '2024-11-05 10:30:53'),
(4, 1, 'Rajshahi', '1', '2024-11-05 11:23:24', '2024-11-05 11:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `email`, `ip`, `browser`, `platform`, `last_login`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-10-08 04:14:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', NULL, NULL),
(2, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-10-17 09:29:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', NULL, NULL),
(3, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-10-19 06:25:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', NULL, NULL),
(4, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-10-22 06:26:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', NULL, NULL),
(5, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-10-24 04:49:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(6, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-10-24 05:22:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(7, 'susmita@gmail.com', '127.0.0.1', 'Chrome', 'Windows', '2024-10-24 07:30:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(8, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-10-24 07:36:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(9, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-10-31 04:35:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(10, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-04 09:14:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(11, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-05 04:39:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(12, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-05 09:16:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(13, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-06 04:55:16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(14, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-06 09:29:31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(15, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-07 05:49:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(16, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-09 10:17:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(17, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-10 09:39:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(18, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-11 06:06:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(19, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-11 10:07:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(20, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-13 03:58:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(21, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-13 10:57:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(22, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-16 05:15:41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(23, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-17 06:45:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(24, 'susmita@gmail.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-18 03:49:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(25, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-18 03:49:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(26, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-20 06:57:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(27, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2024-11-21 04:54:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(28, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-04 08:54:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(29, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-07 04:49:47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(30, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-07 07:25:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(31, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-08 03:54:43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(32, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-08 06:09:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(33, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-08 09:07:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(34, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-09 04:00:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(35, 'susmita@gmail.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-09 04:08:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(36, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-09 04:08:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(37, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-09 05:29:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(38, 'susmita@gmail.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-09 05:29:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(39, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-09 09:56:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(40, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-09 10:38:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(41, 'susmita@gmail.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-09 11:00:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(42, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-11 03:53:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(43, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-11 09:51:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(44, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-12 04:09:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(45, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-12 09:07:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(46, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-12 10:29:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(47, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-13 04:27:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(48, 'susmita@gmail.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-13 10:44:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(49, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-14 04:21:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(50, 'gexona6478@sfxeur.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-14 05:52:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(51, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-14 05:53:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(52, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-15 09:59:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(53, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-16 04:37:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(54, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-18 03:52:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(55, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-18 05:58:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(56, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-18 09:42:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(57, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-19 03:59:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(58, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-19 11:12:01', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(59, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-20 03:56:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(60, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-20 08:51:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(61, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-21 03:53:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(62, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-21 07:38:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(63, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-25 04:17:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(64, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-25 09:24:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(65, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-26 05:26:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(66, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-27 05:32:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', NULL, NULL),
(67, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-28 03:46:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(68, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-29 06:48:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(69, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-29 10:13:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(70, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-29 12:02:45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', NULL, NULL),
(71, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-01-30 08:57:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(72, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-01 04:07:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(73, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-02 04:22:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(74, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 04:07:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(75, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 04:52:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(76, 'golden.line@user.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 05:22:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(77, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 05:26:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(78, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 05:37:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(79, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 05:47:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(80, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 05:48:01', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(81, 'golden.line@user.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 06:05:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(82, 'golden.line@user2.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 06:21:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(83, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 10:52:59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(84, 'golden.line@user1.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 11:01:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(85, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 11:09:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(86, 'golden.line@user1.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 11:30:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(87, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 11:41:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(88, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 11:41:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(89, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 11:42:51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(90, 'golden.line@user1.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-04 11:44:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(91, 'golden.line@user1.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-05 04:16:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(92, 'golden.line@user2.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-05 04:17:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(93, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-05 04:46:53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(94, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-05 10:24:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(95, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-06 06:03:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(96, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-08 03:53:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(97, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-08 04:53:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(98, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-08 09:53:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(99, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-10 04:19:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(100, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-10 04:24:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(101, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-11 05:14:46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(102, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-16 06:02:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(103, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-17 03:49:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(104, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-17 06:14:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(105, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-17 11:42:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(106, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-18 04:14:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(107, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-19 03:56:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(108, 'golden.line@company.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-19 04:12:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(109, 'golden.line@user1.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-19 07:12:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(110, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-19 07:27:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(111, 'golden.line@user1.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-19 07:30:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(112, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-19 07:31:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(113, 'golden.line@user2.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-19 07:34:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(114, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-19 07:35:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL),
(115, 'online.ticket@admin.com', '127.0.0.1', 'Chrome', 'Windows', '2025-02-19 10:13:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', NULL, NULL);

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_17_103901_create_abouts_table', 1),
(6, '2023_12_19_043053_create_permission_tables', 1),
(7, '2024_01_16_112131_create_site_settings_table', 1),
(8, '2024_02_11_050810_create_login_logs_table', 1),
(9, '2024_10_08_120055_create_offers_table', 2),
(10, '2024_10_08_125537_create_faqs_table', 2),
(11, '2024_10_08_125841_create_terms_and_conditions_table', 2),
(12, '2024_10_12_151331_create_categories_table', 2),
(13, '2024_10_12_151347_create_types_table', 2),
(14, '2024_10_17_153433_create_amenities_table', 3),
(16, '2024_10_19_124429_create_amenities_table', 5),
(17, '2024_10_22_122954_create_seats_table', 6),
(20, '2024_11_04_145919_create_journey_types_table', 9),
(21, '2024_11_04_152242_create_countries_table', 10),
(22, '2024_10_31_100550_create_locations_table', 11),
(24, '2024_11_05_105249_create_cupons_table', 12),
(27, '2024_11_09_162209_create_passengers_table', 15),
(29, '2024_11_05_114034_create_planes_table', 16),
(32, '2024_11_10_154713_create_plane_journeys_table', 17),
(34, '2024_11_16_101725_create_bookings_table', 18),
(36, '2024_11_06_131730_add_columns_to_users_table', 19),
(38, '2025_01_04_101032_create_vehicle_publisheds_table', 20),
(39, '2025_01_04_111510_create_districts_table', 20),
(40, '2025_01_04_112413_create_divisions_table', 20),
(52, '2025_01_07_131916_create_counters_table', 21),
(53, '2025_01_07_150356_create_route_managers_table', 21),
(54, '2025_01_07_153729_create_checkers_table', 21),
(55, '2025_01_07_153740_create_owners_table', 21),
(56, '2025_01_07_153750_create_drivers_table', 21),
(57, '2025_01_07_153809_create_supervisors_table', 21),
(61, '2014_10_12_000000_create_users_table', 23),
(69, '2024_10_19_102033_create_vehicles_table', 26),
(73, '2025_01_25_113151_create_services_table', 28),
(74, '2025_01_25_113250_create_blogs_table', 28),
(75, '2025_01_25_113313_create_sliders_table', 28),
(76, '2025_01_09_162330_create_trips_table', 29),
(87, '2025_02_17_095246_create_payments_table', 31),
(88, '2025_02_17_120126_create_places_table', 32),
(90, '2025_01_08_113349_create_routes_table', 33),
(91, '2025_01_20_154327_create_ticket_bookings_table', 34);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `discount_amount` decimal(8,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `nid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `company_id`, `name`, `email`, `phone`, `address`, `nid`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Susmita', 'susmita@gmail.com', '01789651236', 'Dhaka', '214563258962', '1', '2025-01-08 09:56:21', '2025-01-11 04:17:46'),
(2, 9, 'Owner1', 'owner1@gmail.com', '01766829785', 'Kakrail', '1245896585', '1', '2025-02-04 05:37:09', '2025-02-18 07:36:40'),
(3, 9, 'Owner2', 'owner2@gmail.com', '01766829745', 'Bangla Bazar', '1245896548', '1', '2025-02-04 05:39:48', '2025-02-18 07:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `plane_id` bigint(20) UNSIGNED NOT NULL,
  `passenger_name` varchar(255) NOT NULL,
  `passenger_age` varchar(255) NOT NULL,
  `passport` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`id`, `user_id`, `plane_id`, `passenger_name`, `passenger_age`, `passport`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 'susmita', '25', '11223455', '2024-11-09 11:17:28', '2024-11-09 11:17:28'),
(2, 6, 1, 'susmita', '25', 'uploads/passports/1731152134_passport.pdf', '2024-11-09 11:35:34', '2024-11-09 11:35:34'),
(3, 8, 1, 'susmita', '25', 'uploads/passports/1731495560_passport.pdf', '2024-11-13 10:59:20', '2024-11-13 10:59:20');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` int(11) NOT NULL,
  `total_payment` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `card_number` varchar(255) DEFAULT NULL,
  `card_expiry` varchar(255) DEFAULT NULL,
  `security_code` varchar(255) DEFAULT NULL,
  `banking_type` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `total_payment`, `payment_method`, `card_number`, `card_expiry`, `security_code`, `banking_type`, `transaction_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(45, 1, '1200', 'cash', NULL, NULL, NULL, 'bKash', NULL, NULL, '2025-02-19 04:47:39', '2025-02-19 04:47:39'),
(46, 2, '600', 'cash', NULL, NULL, NULL, 'bKash', NULL, NULL, '2025-02-19 04:49:46', '2025-02-19 04:49:46'),
(47, 3, '600', 'mobile_banking', NULL, NULL, NULL, 'bKash', '1234569871', NULL, '2025-02-19 05:32:16', '2025-02-19 05:32:16'),
(48, 4, '1600', 'card', '1111222233334444', '02/2027', '123', 'bKash', NULL, NULL, '2025-02-19 05:33:04', '2025-02-19 05:33:04'),
(49, 5, '600', 'mobile_banking', NULL, NULL, NULL, 'Nagad', '1234569871', NULL, '2025-02-19 07:13:11', '2025-02-19 07:13:11'),
(50, 6, '600', 'mobile_banking', NULL, NULL, NULL, 'Nagad', '1234569871', NULL, '2025-02-19 07:13:36', '2025-02-19 07:13:36'),
(51, 7, '600', 'cash', NULL, NULL, NULL, 'bKash', NULL, NULL, '2025-02-19 07:34:53', '2025-02-19 07:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'role-list', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(2, 'role-create', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(3, 'role-edit', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(4, 'role-delete', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(5, 'role-and-permission-list', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(6, 'resource-list', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(7, 'user-list', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(8, 'user-create', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(9, 'user-edit', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(10, 'user-delete', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(11, 'about-list', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(12, 'about-create', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(13, 'about-edit', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(14, 'about-delete', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(15, 'site-setting', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(16, 'cart-list', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(17, 'login-log-list', 'web', '2024-10-08 04:11:19', '2024-10-08 04:11:19'),
(18, 'faq-list', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(19, 'faq-create', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(20, 'faq-edit', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(21, 'faq-delete', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(22, 'offer-list', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(23, 'offer-create', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(24, 'offer-edit', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(25, 'offer-delete', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(26, 'terms-list', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(27, 'terms-create', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(28, 'terms-edit', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(29, 'terms-delete', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(30, 'category-list', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(31, 'category-create', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(32, 'category-edit', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(33, 'category-delete', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(34, 'type-list', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(35, 'type-create', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(36, 'type-edit', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(37, 'type-delete', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(38, 'amenities-list', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(39, 'amenities-create', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(40, 'amenities-edit', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(41, 'amenities-delete', 'web', '2024-10-17 10:38:52', '2024-10-17 10:38:52'),
(42, 'vehicle-list', 'web', '2024-10-19 06:25:12', '2024-10-19 06:25:12'),
(43, 'vehicle-create', 'web', '2024-10-19 06:25:12', '2024-10-19 06:25:12'),
(44, 'vehicle-edit', 'web', '2024-10-19 06:25:12', '2024-10-19 06:25:12'),
(45, 'vehicle-delete', 'web', '2024-10-19 06:25:12', '2024-10-19 06:25:12'),
(46, 'seats-list', 'web', '2024-10-24 05:19:49', '2024-10-24 05:19:49'),
(47, 'seats-create', 'web', '2024-10-24 05:19:49', '2024-10-24 05:19:49'),
(48, 'seats-edit', 'web', '2024-10-24 05:19:49', '2024-10-24 05:19:49'),
(49, 'seats-delete', 'web', '2024-10-24 05:19:49', '2024-10-24 05:19:49'),
(50, 'location-list', 'web', '2024-10-31 04:38:49', '2024-10-31 04:38:49'),
(51, 'location-create', 'web', '2024-10-31 04:38:49', '2024-10-31 04:38:49'),
(52, 'location-edit', 'web', '2024-10-31 04:38:49', '2024-10-31 04:38:49'),
(53, 'location-delete', 'web', '2024-10-31 04:38:49', '2024-10-31 04:38:49'),
(54, 'booking-list', 'web', '2024-10-31 04:38:49', '2024-10-31 04:38:49'),
(55, 'booking-create', 'web', '2024-10-31 04:38:49', '2024-10-31 04:38:49'),
(56, 'booking-edit', 'web', '2024-10-31 04:38:49', '2024-10-31 04:38:49'),
(57, 'booking-delete', 'web', '2024-10-31 04:38:49', '2024-10-31 04:38:49'),
(58, 'journey_type-list', 'web', '2024-11-04 09:12:42', '2024-11-04 09:12:42'),
(59, 'journey_type-create', 'web', '2024-11-04 09:12:42', '2024-11-04 09:12:42'),
(60, 'journey_type-edit', 'web', '2024-11-04 09:12:42', '2024-11-04 09:12:42'),
(61, 'journey_type-delete', 'web', '2024-11-04 09:12:42', '2024-11-04 09:12:42'),
(62, 'country-list', 'web', '2024-11-04 09:51:18', '2024-11-04 09:51:18'),
(63, 'country-create', 'web', '2024-11-04 09:51:18', '2024-11-04 09:51:18'),
(64, 'country-edit', 'web', '2024-11-04 09:51:18', '2024-11-04 09:51:18'),
(65, 'country-delete', 'web', '2024-11-04 09:51:18', '2024-11-04 09:51:18'),
(66, 'cupon-list', 'web', '2024-11-05 05:19:18', '2024-11-05 05:19:18'),
(67, 'cupon-create', 'web', '2024-11-05 05:19:18', '2024-11-05 05:19:18'),
(68, 'cupon-edit', 'web', '2024-11-05 05:19:18', '2024-11-05 05:19:18'),
(69, 'cupon-delete', 'web', '2024-11-05 05:19:18', '2024-11-05 05:19:18'),
(70, 'plane-list', 'web', '2024-11-05 09:25:53', '2024-11-05 09:25:53'),
(71, 'plane-create', 'web', '2024-11-05 09:25:53', '2024-11-05 09:25:53'),
(72, 'plane-edit', 'web', '2024-11-05 09:25:53', '2024-11-05 09:25:53'),
(73, 'plane-delete', 'web', '2024-11-05 09:25:53', '2024-11-05 09:25:53'),
(74, 'admin-menu-list', 'web', '2024-11-06 05:57:13', '2024-11-06 05:57:13'),
(75, 'menu-list-for-bus', 'web', '2024-11-06 05:57:13', '2024-11-06 05:57:13'),
(76, 'menu-list-for-plane', 'web', '2024-11-06 05:57:13', '2024-11-06 05:57:13'),
(77, 'plane-journey-list', 'web', '2024-11-10 11:33:34', '2024-11-10 11:33:34'),
(78, 'plane-journey-create', 'web', '2024-11-10 11:33:34', '2024-11-10 11:33:34'),
(79, 'plane-journey-edit', 'web', '2024-11-10 11:33:34', '2024-11-10 11:33:34'),
(80, 'plane-journey-delete', 'web', '2024-11-10 11:33:34', '2024-11-10 11:33:34'),
(81, 'division-list', 'web', '2025-01-07 07:28:30', '2025-01-07 07:28:30'),
(82, 'division-create', 'web', '2025-01-07 07:28:30', '2025-01-07 07:28:30'),
(83, 'division-edit', 'web', '2025-01-07 07:28:30', '2025-01-07 07:28:30'),
(84, 'division-delete', 'web', '2025-01-07 07:28:30', '2025-01-07 07:28:30'),
(85, 'district-list', 'web', '2025-01-07 07:28:30', '2025-01-07 07:28:30'),
(86, 'district-create', 'web', '2025-01-07 07:28:30', '2025-01-07 07:28:30'),
(87, 'district-edit', 'web', '2025-01-07 07:28:30', '2025-01-07 07:28:30'),
(88, 'district-delete', 'web', '2025-01-07 07:28:30', '2025-01-07 07:28:30'),
(89, 'published-vehicle', 'web', '2025-01-07 07:28:30', '2025-01-07 07:28:30'),
(90, 'counter-list', 'web', '2025-01-07 08:46:31', '2025-01-07 08:46:31'),
(91, 'counter-create', 'web', '2025-01-07 08:46:31', '2025-01-07 08:46:31'),
(92, 'counter-edit', 'web', '2025-01-07 08:46:31', '2025-01-07 08:46:31'),
(93, 'counter-delete', 'web', '2025-01-07 08:46:31', '2025-01-07 08:46:31'),
(94, 'route-manager-list', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(95, 'route-manager-create', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(96, 'route-manager-edit', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(97, 'route-manager-delete', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(98, 'checker-list', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(99, 'checker-create', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(100, 'checker-edit', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(101, 'checker-delete', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(102, 'owner-list', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(103, 'owner-create', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(104, 'owner-edit', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(105, 'owner-delete', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(106, 'driver-list', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(107, 'driver-create', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(108, 'driver-edit', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(109, 'driver-delete', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(110, 'supervisor-list', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(111, 'supervisor-create', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(112, 'supervisor-edit', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(113, 'supervisor-delete', 'web', '2025-01-07 09:08:57', '2025-01-07 09:08:57'),
(114, 'published-vehicle-delete', 'web', '2025-01-08 05:41:39', '2025-01-08 05:41:39'),
(115, 'route-list', 'web', '2025-01-08 05:41:39', '2025-01-08 05:41:39'),
(116, 'route-create', 'web', '2025-01-08 05:41:40', '2025-01-08 05:41:40'),
(117, 'route-edit', 'web', '2025-01-08 05:41:40', '2025-01-08 05:41:40'),
(118, 'route-delete', 'web', '2025-01-08 05:41:40', '2025-01-08 05:41:40'),
(119, 'trip-list', 'web', '2025-01-09 10:53:59', '2025-01-09 10:53:59'),
(120, 'trip-create', 'web', '2025-01-09 10:53:59', '2025-01-09 10:53:59'),
(121, 'trip-edit', 'web', '2025-01-09 10:53:59', '2025-01-09 10:53:59'),
(122, 'trip-delete', 'web', '2025-01-09 10:53:59', '2025-01-09 10:53:59'),
(123, 'seat-booking-list', 'web', '2025-01-11 10:08:33', '2025-01-11 10:08:33'),
(124, 'seat-booking-create', 'web', '2025-01-11 10:08:33', '2025-01-11 10:08:33'),
(125, 'seat-booking-edit', 'web', '2025-01-11 10:08:33', '2025-01-11 10:08:33'),
(126, 'seat-booking-delete', 'web', '2025-01-11 10:08:33', '2025-01-11 10:08:33'),
(127, 'reset-seat-list', 'web', '2025-01-12 06:20:07', '2025-01-12 06:20:07'),
(128, 'vehicle-select', 'web', '2025-01-13 10:54:24', '2025-01-13 10:54:24'),
(129, 'ticket-booking', 'web', '2025-01-20 11:33:04', '2025-01-20 11:33:04'),
(130, 'ticket-booking-list', 'web', '2025-01-21 05:03:19', '2025-01-21 05:03:19'),
(131, 'slider-list', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(132, 'slider-create', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(133, 'slider-edit', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(134, 'slider-delete', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(135, 'blog-list', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(136, 'blog-create', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(137, 'blog-edit', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(138, 'blog-delete', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(139, 'service-list', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(140, 'service-create', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(141, 'service-edit', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(142, 'service-delete', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(143, 'place-list', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(144, 'place-create', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(145, 'place-edit', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54'),
(146, 'place-delete', 'web', '2025-02-17 06:06:54', '2025-02-17 06:06:54');

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
(1, 'App\\Models\\User', 5, 'YourAppName', '236dc4dc3b9f317434d744c96dd0ba484bb41408d3d820d5a538c7aa5c8e171c', '[\"*\"]', NULL, NULL, '2024-11-06 10:24:54', '2024-11-06 10:24:54'),
(2, 'App\\Models\\User', 6, 'YourAppName', 'c5f4cbca1a3748bd92c87da21ca1e206c09e1abb3f90c36c5df1d6a1d8a12f89', '[\"*\"]', NULL, NULL, '2024-11-06 10:52:42', '2024-11-06 10:52:42'),
(3, 'App\\Models\\User', 6, 'YourAppName', '09841ea284633f7fc11f36877485338f7e256f8168ead3f3252c84e313b1b38b', '[\"*\"]', '2024-11-06 11:19:08', NULL, '2024-11-06 11:14:40', '2024-11-06 11:19:08'),
(4, 'App\\Models\\User', 7, 'YourAppName', 'c6a057b7d47bb6c6d1fe2fc689484ddaaab7fc5766db9585e651c1430ea40748', '[\"*\"]', '2024-11-07 05:58:45', NULL, '2024-11-07 05:52:24', '2024-11-07 05:58:45'),
(5, 'App\\Models\\User', 7, 'YourAppName', 'd9fc2ce0da586c01c73bae95d9fbe1df4045c4ef47d524cbe919fe91a8e94fc0', '[\"*\"]', '2024-11-07 06:09:36', NULL, '2024-11-07 06:02:07', '2024-11-07 06:09:36'),
(6, 'App\\Models\\User', 8, 'YourAppName', '6d575f8873870566b9062509aa226b6773d63ea97d3319e81fd94fc18f16a42d', '[\"*\"]', '2024-11-07 06:13:21', NULL, '2024-11-07 06:12:55', '2024-11-07 06:13:21'),
(7, 'App\\Models\\User', 8, 'YourAppName', '508da9203a941ad56c2088ca53c49ddd06222f93b99f210c8a71fcf03c0a1ba4', '[\"*\"]', '2024-11-16 09:33:24', NULL, '2024-11-09 10:45:50', '2024-11-16 09:33:24'),
(8, 'App\\Models\\User', 6, 'YourAppName', 'e786aee3e869f52ba7a7a980c0d952703b1f1ec381b5a5ccf32fdc1918420bbe', '[\"*\"]', '2024-11-09 11:35:34', NULL, '2024-11-09 10:57:58', '2024-11-09 11:35:34'),
(9, 'App\\Models\\User', 6, 'YourAppName', '60f52bc165fba46caa0478839501107657b30fc96ae4d9f62d462c4576fd1ee0', '[\"*\"]', '2024-11-18 06:18:39', NULL, '2024-11-18 06:06:48', '2024-11-18 06:18:39'),
(10, 'App\\Models\\User', 2, 'YourAppName', '66fc043b6fd0e8c3c63467c74be095748574169c97904c936f1ca1ad3aac66ea', '[\"*\"]', NULL, NULL, '2025-01-06 07:30:33', '2025-01-06 07:30:33'),
(11, 'App\\Models\\User', 3, 'YourAppName', 'b6d9048ed467ceb26901958ee5ba2e6e732ac7c60b912935755cfa56939bb5f8', '[\"*\"]', NULL, NULL, '2025-01-07 08:42:13', '2025-01-07 08:42:13'),
(12, 'App\\Models\\User', 5, 'YourAppName', '21e58a448aa9228c14a2b18ab5deee4056c76efc96f57da2cbeba46fb4459f69', '[\"*\"]', '2025-01-09 09:50:54', NULL, '2025-01-09 09:48:44', '2025-01-09 09:50:54'),
(13, 'App\\Models\\User', 5, 'YourAppName', 'da3def2099463f07547c6eddf587acde1b574a0e167a8e55850990ef1ede776a', '[\"*\"]', NULL, NULL, '2025-01-14 05:26:12', '2025-01-14 05:26:12'),
(14, 'App\\Models\\User', 5, 'YourAppName', '34ad2cb849ca4efa18352a7b16ca6f56602ed07e1f6b9a47b574947ec1943e9d', '[\"*\"]', NULL, NULL, '2025-01-14 05:43:22', '2025-01-14 05:43:22'),
(15, 'App\\Models\\User', 6, 'YourAppName', '6fdf8c0373231e05a3f349be16c5e9b957a9c8d3cbd326f130221d62e13990d7', '[\"*\"]', '2025-01-20 04:25:32', NULL, '2025-01-14 05:47:15', '2025-01-20 04:25:32'),
(16, 'App\\Models\\User', 7, 'YourAppName', '0550684b91617a94aa0c5786fece8f09765bdf2f2b6a13aaedad36d651210abd', '[\"*\"]', NULL, NULL, '2025-01-20 05:25:40', '2025-01-20 05:25:40'),
(17, 'App\\Models\\User', 8, 'YourAppName', '19e0a542b14d1af238ec212d8592fb1fd6402d692275a87aedb712a834e7cedd', '[\"*\"]', NULL, NULL, '2025-01-20 05:27:02', '2025-01-20 05:27:02'),
(18, 'App\\Models\\User', 12, 'YourAppName', '6c8813c99f6a766c3af582cdfdfa3013e77c0b19b1e71e42e73813998b6a045a', '[\"*\"]', NULL, NULL, '2025-02-19 09:12:40', '2025-02-19 09:12:40'),
(19, 'App\\Models\\User', 13, 'YourAppName', 'd5ed9a89e7e4416c685ef97151b9250c5955c6a8360b6be6d17942add574728c', '[\"*\"]', NULL, NULL, '2025-02-19 09:17:19', '2025-02-19 09:17:19');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `district_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(5, 3, 'Pangsha', 1, '2025-02-17 06:17:35', '2025-02-17 06:17:35'),
(6, 2, 'Gabtoli', 1, '2025-02-17 06:24:48', '2025-02-17 06:24:48'),
(7, 2, 'Sayedabad', 1, '2025-02-17 06:26:35', '2025-02-17 06:26:35'),
(8, 7, 'Laboni Beach', 1, '2025-02-17 06:28:53', '2025-02-17 06:28:53'),
(9, 8, 'Comilla Cantonment', 1, '2025-02-17 06:29:07', '2025-02-17 06:29:07'),
(10, 21, 'Rajshahi Bypass', 1, '2025-02-17 06:29:26', '2025-02-17 06:29:26'),
(11, 9, 'Natore Sadar', 1, '2025-02-17 06:29:44', '2025-02-17 06:29:44'),
(12, 6, 'Jessore Sadar', 1, '2025-02-17 06:30:02', '2025-02-17 06:30:02'),
(13, 10, 'Bagerhat Sadar', 1, '2025-02-17 06:30:14', '2025-02-17 06:30:14'),
(14, 17, 'Rupatoli', 1, '2025-02-17 06:30:31', '2025-02-17 06:30:31'),
(15, 11, 'Kuakata', 1, '2025-02-17 06:30:42', '2025-02-17 06:30:42'),
(16, 15, 'Srimangal', 1, '2025-02-17 06:30:58', '2025-02-17 06:30:58'),
(17, 13, 'Panchagarh Sadar', 1, '2025-02-17 06:31:19', '2025-02-17 06:31:19'),
(18, 12, 'Jhalokathi Sadar', 1, '2025-02-17 06:31:33', '2025-02-17 06:31:33'),
(19, 17, 'Barishal Sadar', 1, '2025-02-17 09:27:54', '2025-02-18 06:51:42'),
(20, 3, 'Rajbari Sadar', 1, '2025-02-17 09:31:38', '2025-02-18 06:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `planes`
--

CREATE TABLE `planes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `plane_name` varchar(255) NOT NULL,
  `amenities_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`amenities_id`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `planes`
--

INSERT INTO `planes` (`id`, `company_id`, `plane_name`, `amenities_id`, `created_at`, `updated_at`) VALUES
(2, 1, 'v567', '[\"2\",\"1\"]', '2024-11-10 10:13:32', '2024-11-10 10:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `plane_journeys`
--

CREATE TABLE `plane_journeys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `plane_id` bigint(20) UNSIGNED NOT NULL,
  `journey_types_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`journey_types_id`)),
  `from_country_id` bigint(20) UNSIGNED NOT NULL,
  `to_country_id` bigint(20) UNSIGNED NOT NULL,
  `start_location_id` bigint(20) UNSIGNED NOT NULL,
  `end_location_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_seats` int(11) NOT NULL,
  `available_seats` int(11) DEFAULT NULL,
  `published_status` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plane_journeys`
--

INSERT INTO `plane_journeys` (`id`, `company_id`, `plane_id`, `journey_types_id`, `from_country_id`, `to_country_id`, `start_location_id`, `end_location_id`, `start_date`, `end_date`, `total_seats`, `available_seats`, `published_status`, `created_at`, `updated_at`) VALUES
(5, 1, 2, '[\"2\"]', 3, 1, 3, 1, '2024-11-17', '2024-11-17', 20, 20, '0', '2024-11-16 05:16:09', '2024-11-16 05:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-10-08 04:11:41', '2024-10-08 04:11:41'),
(2, 'User', 'web', '2024-10-24 07:30:01', '2024-10-24 07:30:01'),
(3, 'Company', 'web', '2025-02-04 04:52:08', '2025-02-04 04:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(5, 3),
(6, 1),
(7, 1),
(7, 3),
(8, 1),
(8, 3),
(9, 1),
(9, 3),
(10, 1),
(10, 3),
(11, 1),
(11, 3),
(12, 1),
(12, 3),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(15, 1),
(15, 3),
(16, 1),
(16, 2),
(16, 3),
(17, 1),
(17, 2),
(17, 3),
(18, 1),
(18, 3),
(19, 1),
(19, 3),
(20, 1),
(20, 3),
(21, 1),
(21, 3),
(22, 1),
(22, 3),
(23, 1),
(23, 3),
(24, 1),
(24, 3),
(25, 1),
(25, 3),
(26, 1),
(26, 3),
(27, 1),
(27, 3),
(28, 1),
(28, 3),
(29, 1),
(29, 3),
(30, 1),
(30, 3),
(31, 1),
(31, 3),
(32, 1),
(32, 3),
(33, 1),
(33, 3),
(34, 1),
(34, 3),
(35, 1),
(35, 3),
(36, 1),
(36, 3),
(37, 1),
(37, 3),
(38, 1),
(38, 3),
(39, 1),
(39, 3),
(40, 1),
(40, 3),
(41, 1),
(41, 3),
(42, 1),
(42, 3),
(43, 1),
(43, 3),
(44, 1),
(44, 3),
(45, 1),
(45, 3),
(46, 1),
(46, 3),
(47, 1),
(47, 3),
(48, 1),
(48, 3),
(49, 1),
(49, 3),
(50, 1),
(50, 3),
(51, 1),
(51, 3),
(52, 1),
(52, 3),
(53, 1),
(53, 3),
(54, 1),
(54, 2),
(54, 3),
(55, 1),
(55, 3),
(56, 1),
(56, 3),
(57, 1),
(57, 2),
(57, 3),
(58, 1),
(58, 3),
(59, 1),
(59, 3),
(60, 1),
(60, 3),
(61, 1),
(61, 3),
(62, 1),
(62, 3),
(63, 1),
(63, 3),
(64, 1),
(64, 3),
(65, 1),
(65, 3),
(66, 1),
(66, 3),
(67, 1),
(67, 3),
(68, 1),
(68, 3),
(69, 1),
(69, 3),
(70, 1),
(70, 3),
(71, 1),
(71, 3),
(72, 1),
(72, 3),
(73, 1),
(73, 3),
(74, 1),
(74, 3),
(75, 1),
(75, 2),
(75, 3),
(76, 1),
(76, 3),
(77, 1),
(77, 3),
(78, 1),
(78, 3),
(79, 1),
(79, 3),
(80, 1),
(80, 3),
(81, 1),
(81, 3),
(82, 1),
(82, 3),
(83, 1),
(83, 3),
(84, 1),
(84, 3),
(85, 1),
(85, 3),
(86, 1),
(86, 3),
(87, 1),
(87, 3),
(88, 1),
(88, 3),
(89, 1),
(89, 3),
(90, 1),
(90, 3),
(91, 1),
(91, 3),
(92, 1),
(92, 3),
(93, 1),
(93, 3),
(94, 1),
(94, 3),
(95, 1),
(95, 3),
(96, 1),
(96, 3),
(97, 1),
(97, 3),
(98, 1),
(98, 3),
(99, 1),
(99, 3),
(100, 1),
(100, 3),
(101, 1),
(101, 3),
(102, 1),
(102, 3),
(103, 1),
(103, 3),
(104, 1),
(104, 3),
(105, 1),
(105, 3),
(106, 1),
(106, 3),
(107, 1),
(107, 3),
(108, 1),
(108, 3),
(109, 1),
(109, 3),
(110, 1),
(110, 3),
(111, 1),
(111, 3),
(112, 1),
(112, 3),
(113, 1),
(113, 3),
(114, 1),
(114, 3),
(115, 1),
(115, 3),
(116, 1),
(116, 3),
(117, 1),
(117, 3),
(118, 1),
(118, 3),
(119, 1),
(119, 3),
(120, 1),
(120, 3),
(121, 1),
(121, 3),
(122, 1),
(122, 3),
(123, 1),
(123, 3),
(124, 1),
(124, 3),
(125, 1),
(125, 3),
(126, 1),
(126, 3),
(127, 1),
(127, 3),
(128, 1),
(128, 3),
(129, 1),
(129, 2),
(129, 3),
(130, 1),
(130, 2),
(130, 3),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(141, 1),
(142, 1),
(143, 1),
(143, 3),
(144, 1),
(144, 3),
(145, 1),
(145, 3),
(146, 1),
(146, 3);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `from_location_id` varchar(255) NOT NULL,
  `to_location_id` varchar(255) NOT NULL,
  `start_counter_id` int(11) NOT NULL,
  `end_counter_id` int(11) NOT NULL,
  `route_manager_id` int(11) NOT NULL,
  `checkers_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`checkers_id`)),
  `document` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `company_id`, `from_location_id`, `to_location_id`, `start_counter_id`, `end_counter_id`, `route_manager_id`, `checkers_id`, `document`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, '6', '20', 9, 18, 4, '[\"3\"]', NULL, '1', '2025-02-18 05:05:52', '2025-02-18 05:05:52'),
(2, 9, '7', '15', 10, 15, 3, '[\"3\"]', NULL, '1', '2025-02-18 05:54:05', '2025-02-18 05:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `route_managers`
--

CREATE TABLE `route_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `nid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_managers`
--

INSERT INTO `route_managers` (`id`, `company_id`, `name`, `email`, `phone`, `address`, `nid`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'Rahim', 'rahim@gmail.com', '01234562314', 'dhaka', '12478541235', '1', '2025-01-08 11:02:22', '2025-01-11 04:18:49'),
(3, 9, 'Route Manager 1', 'routemanager1@gmail.com', '01766829714', 'shantinagar', '12458965412', '1', '2025-02-04 05:34:03', '2025-02-18 07:32:07'),
(4, 9, 'Route Manager 2', 'routemanager2@gmail.com', '01766829715', 'Bangla Bazar', '12458965415', '1', '2025-02-04 05:34:33', '2025-02-18 07:31:46'),
(5, 9, 'Route Manager 3', 'routemanager3@gmail.com', '01766852147', 'Bangla Bazar', '1245896548', '1', '2025-02-18 07:31:23', '2025-02-18 07:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `seat_no` varchar(255) NOT NULL,
  `is_booked` tinyint(1) NOT NULL DEFAULT 0,
  `is_reserved_by` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `company_id`, `vehicle_id`, `seat_no`, `is_booked`, `is_reserved_by`, `status`, `created_at`, `updated_at`) VALUES
(52, 9, 5, 'A1', 2, NULL, '1', '2025-02-04 05:52:48', '2025-02-19 04:47:39'),
(53, 9, 5, 'A2', 2, NULL, '1', '2025-02-04 05:52:52', '2025-02-19 04:47:39'),
(54, 9, 5, 'A3', 2, NULL, '1', '2025-02-04 05:52:57', '2025-02-19 04:49:46'),
(55, 9, 5, 'A4', 2, NULL, '1', '2025-02-04 05:53:06', '2025-02-19 05:32:16'),
(56, 9, 5, 'B1', 2, NULL, '1', '2025-02-04 05:53:14', '2025-02-19 07:13:11'),
(57, 9, 5, 'B2', 2, NULL, '1', '2025-02-04 05:53:20', '2025-02-19 07:13:36'),
(58, 9, 5, 'B3', 2, NULL, '1', '2025-02-04 05:53:26', '2025-02-19 07:34:53'),
(59, 9, 5, 'B4', 0, NULL, '1', '2025-02-04 05:53:30', '2025-02-17 07:16:08'),
(60, 9, 5, 'C1', 0, NULL, '1', '2025-02-04 05:53:36', '2025-02-17 07:16:08'),
(61, 9, 5, 'C2', 0, NULL, '1', '2025-02-04 05:54:05', '2025-02-17 07:16:08'),
(62, 9, 5, 'C3', 0, NULL, '1', '2025-02-04 05:54:10', '2025-02-17 07:16:08'),
(63, 9, 5, 'C4', 0, NULL, '1', '2025-02-04 05:54:16', '2025-02-17 07:16:08'),
(64, 9, 6, 'A1', 2, NULL, '1', '2025-02-04 05:59:10', '2025-02-19 05:33:04'),
(65, 9, 6, 'A2', 0, NULL, '1', '2025-02-04 05:59:13', '2025-02-18 06:48:36'),
(66, 9, 6, 'A3', 0, NULL, '1', '2025-02-04 05:59:18', '2025-02-19 04:47:30'),
(67, 9, 6, 'B1', 0, NULL, '1', '2025-02-04 05:59:24', '2025-02-04 05:59:24'),
(68, 9, 6, 'B2', 0, NULL, '1', '2025-02-04 05:59:29', '2025-02-19 04:47:30'),
(69, 9, 6, 'B3', 0, NULL, '1', '2025-02-04 05:59:34', '2025-02-19 04:47:30'),
(70, 9, 6, 'C1', 0, NULL, '1', '2025-02-04 05:59:42', '2025-02-04 05:59:42'),
(71, 9, 6, 'C2', 0, NULL, '1', '2025-02-04 05:59:49', '2025-02-04 05:59:49'),
(72, 9, 6, 'C3', 0, NULL, '1', '2025-02-04 05:59:53', '2025-02-04 05:59:53'),
(73, 9, 6, 'D1', 0, NULL, '1', '2025-02-17 11:32:43', '2025-02-17 11:32:43'),
(74, 9, 6, 'D2', 0, NULL, '1', '2025-02-17 11:32:50', '2025-02-17 11:32:50'),
(75, 9, 6, 'D3', 0, NULL, '1', '2025-02-17 11:32:56', '2025-02-17 11:32:56'),
(76, 9, 5, 'D1', 0, NULL, '1', '2025-02-17 11:33:57', '2025-02-17 11:33:57'),
(77, 9, 5, 'D2', 0, NULL, '1', '2025-02-17 11:34:01', '2025-02-17 11:34:01'),
(78, 9, 5, 'D3', 0, NULL, '1', '2025-02-17 11:34:05', '2025-02-17 11:34:05'),
(79, 9, 5, 'D4', 0, NULL, '1', '2025-02-17 11:34:08', '2025-02-17 11:34:08'),
(84, 9, 7, 'A1', 0, NULL, '1', '2025-02-17 11:41:35', '2025-02-17 11:41:35'),
(85, 9, 7, 'A2', 0, NULL, '1', '2025-02-17 11:41:40', '2025-02-17 11:41:40'),
(86, 9, 7, 'A3', 0, NULL, '1', '2025-02-17 11:41:44', '2025-02-17 11:41:44'),
(87, 9, 7, 'A4', 0, NULL, '1', '2025-02-17 11:46:16', '2025-02-17 11:46:16'),
(88, 9, 7, 'A5', 0, NULL, '1', '2025-02-17 11:46:20', '2025-02-17 11:46:20'),
(89, 9, 7, 'A6', 0, NULL, '1', '2025-02-17 11:46:24', '2025-02-17 11:46:24'),
(90, 9, 7, 'B1', 0, NULL, '1', '2025-02-17 11:46:29', '2025-02-17 11:46:29'),
(91, 9, 7, 'B2', 0, NULL, '1', '2025-02-17 11:46:33', '2025-02-17 11:46:33'),
(92, 9, 7, 'B3', 0, NULL, '1', '2025-02-17 11:46:38', '2025-02-17 11:46:38'),
(93, 9, 7, 'B4', 0, NULL, '1', '2025-02-17 11:46:44', '2025-02-17 11:46:44'),
(94, 9, 7, 'B5', 0, NULL, '1', '2025-02-17 11:46:49', '2025-02-17 11:46:49'),
(95, 9, 7, 'B6', 0, NULL, '1', '2025-02-17 11:46:55', '2025-02-17 11:46:55'),
(96, 9, 7, 'C1', 0, NULL, '1', '2025-02-17 11:46:59', '2025-02-17 11:46:59'),
(97, 9, 7, 'C2', 0, NULL, '1', '2025-02-17 11:47:04', '2025-02-17 11:47:04'),
(98, 9, 7, 'C3', 0, NULL, '1', '2025-02-17 11:47:09', '2025-02-17 11:47:09'),
(99, 9, 7, 'C4', 0, NULL, '1', '2025-02-17 11:47:13', '2025-02-17 11:47:13'),
(100, 9, 7, 'C5', 0, NULL, '1', '2025-02-17 11:47:20', '2025-02-17 11:47:20'),
(101, 9, 7, 'C6', 0, NULL, '1', '2025-02-17 11:47:25', '2025-02-17 11:47:25'),
(102, 9, 7, 'D1', 0, NULL, '1', '2025-02-17 11:47:31', '2025-02-17 11:47:31'),
(103, 9, 7, 'D2', 0, NULL, '1', '2025-02-17 11:47:35', '2025-02-17 11:47:35'),
(104, 9, 7, 'D3', 0, NULL, '1', '2025-02-17 11:47:39', '2025-02-17 11:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `site_preview_image` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `site_link` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `nid` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`id`, `company_id`, `name`, `email`, `phone`, `address`, `nid`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Anik', 'anik@gmail.com', '01478965235', 'Dhaka', '14523657852', '1', '2025-01-08 09:56:33', '2025-01-11 04:20:05'),
(2, 9, 'Supervisor1', 'supervisor1@gmail.com', '01766829718', 'Bangla Bazar', '1245896549', '1', '2025-02-04 05:44:05', '2025-02-18 07:38:30'),
(3, 9, 'Supervisor2', 'supervisor2@gmail.com', '01766829719', 'Bangla Bazar', '1245896548', '1', '2025-02-04 05:44:27', '2025-02-18 07:38:12');

-- --------------------------------------------------------

--
-- Table structure for table `terms_and_conditions`
--

CREATE TABLE `terms_and_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_bookings`
--

CREATE TABLE `ticket_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `seat_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`seat_data`)),
  `passenger_name` varchar(255) DEFAULT NULL,
  `passenger_phone` varchar(255) NOT NULL,
  `travel_date` date NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_bookings`
--

INSERT INTO `ticket_bookings` (`id`, `company_id`, `trip_id`, `vehicle_id`, `seat_data`, `passenger_name`, `passenger_phone`, `travel_date`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 9, 4, 5, '[{\"seatId\":\"52\",\"seatNo\":\"A1\",\"seatPrice\":600},{\"seatId\":\"53\",\"seatNo\":\"A2\",\"seatPrice\":600}]', NULL, '01766829719', '2025-02-28', NULL, '2025-02-19 04:47:39', '2025-02-19 04:47:39'),
(2, 9, 4, 5, '[{\"seatId\":\"54\",\"seatNo\":\"A3\",\"seatPrice\":600}]', NULL, '01766829719', '2025-02-28', NULL, '2025-02-19 04:49:46', '2025-02-19 04:49:46'),
(3, 9, 4, 5, '[{\"seatId\":\"55\",\"seatNo\":\"A4\",\"seatPrice\":600}]', NULL, '01766829719', '2025-02-28', NULL, '2025-02-19 05:32:16', '2025-02-19 05:32:16'),
(4, 9, 5, 6, '[{\"seatId\":\"64\",\"seatNo\":\"A1\",\"seatPrice\":1600}]', NULL, '01766829719', '2025-02-28', NULL, '2025-02-19 05:33:04', '2025-02-19 05:33:04'),
(5, 10, 4, 5, '[{\"seatId\":\"56\",\"seatNo\":\"B1\",\"seatPrice\":600}]', NULL, '01766829719', '2025-02-28', NULL, '2025-02-19 07:13:11', '2025-02-19 07:13:11'),
(6, 10, 4, 5, '[{\"seatId\":\"57\",\"seatNo\":\"B2\",\"seatPrice\":600}]', NULL, '01766829719', '2025-02-28', NULL, '2025-02-19 07:13:36', '2025-02-19 07:13:36'),
(7, 11, 4, 5, '[{\"seatId\":\"58\",\"seatNo\":\"B3\",\"seatPrice\":600}]', NULL, '01766829719', '2025-02-28', NULL, '2025-02-19 07:34:53', '2025-02-19 07:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_route_cost` varchar(255) NOT NULL,
  `ticket_price` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `company_id`, `route_id`, `vehicle_id`, `driver_id`, `supervisor_id`, `start_date`, `end_date`, `start_time`, `end_time`, `total_route_cost`, `ticket_price`, `status`, `created_at`, `updated_at`) VALUES
(4, 9, 1, 5, 5, 3, '2025-02-28', '2025-02-28', '12:00:00', '16:00:00', '1200', '600', '1', '2025-02-18 05:19:16', '2025-02-18 05:20:11'),
(5, 9, 2, 6, 5, 2, '2025-02-28', '2025-02-28', '01:30:00', '07:40:00', '1200', '1600', '1', '2025-02-18 06:44:21', '2025-02-18 06:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `company_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 'AC', 1, '2025-01-11 04:16:44', '2025-01-11 04:16:44'),
(5, 1, 'NON-AC', 1, '2025-01-11 04:16:54', '2025-01-11 04:16:54'),
(6, 6, 'AC', 1, '2025-01-14 05:53:48', '2025-01-14 05:53:48'),
(7, 9, 'AC', 1, '2025-02-04 05:44:35', '2025-02-04 05:44:35'),
(8, 9, 'NON-AC', 1, '2025-02-04 05:44:42', '2025-02-04 05:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `is_registration_by` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `verification_code`, `image`, `status`, `is_registration_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Online Ticket Booking Super Admin', 'online.ticket@admin.com', NULL, '$2y$12$RPEJRel6m/fq4hjFMzxof.4p/0bS8k5oFbKdH2vpNtIzwjOgbiAvy', NULL, NULL, NULL, 1, NULL, NULL, '2025-01-09 10:37:54', '2025-01-09 10:37:54'),
(9, 'Golden Line', 'golden.line@company.com', NULL, '$2y$12$/YfXR4KbwBz.Vt7.Bc6dDezpPGkvq.A0qnOf/N9C2vVUwMYhlkoOi', NULL, NULL, NULL, 1, '1', NULL, '2025-02-04 04:49:11', '2025-02-04 04:52:37'),
(10, 'Golden Line User1', 'golden.line@user1.com', NULL, '$2y$12$laHaRJ7nQL/CsSHiMxUia.PHpfIPDHnmQZJ.xm99FDW47KSLzLzne', NULL, NULL, NULL, 1, '9', NULL, '2025-02-04 05:20:28', '2025-02-04 06:20:45'),
(11, 'Golden Line User2', 'golden.line@user2.com', NULL, '$2y$12$PyThPGyV55Q56o6mZ8PiIOKjKBx4jLEySIxNsD9qsGOMAGGUympiy', NULL, NULL, NULL, 1, '9', NULL, '2025-02-04 06:20:36', '2025-02-04 06:20:36'),
(12, 'Test', 'higiyec854@jarars.com', '2025-02-19 09:12:24', '$2y$12$fcAEST1N59uBt0muHO9ApuGUPBrdqmjqSBEghmkxb9vwSGSLZOAH2', '01755698547', NULL, NULL, 1, 'User', NULL, '2025-02-19 09:09:07', '2025-02-19 09:12:24'),
(13, 'Test', 'yivopi1025@jarars.com', '2025-02-19 09:17:09', '$2y$12$GfQGiEFf9NJqmkwbiDiznORLcODMBtGmlQIpTzNxdAvTo9NRvbhpO', '01755698547', NULL, NULL, 1, 'User', NULL, '2025-02-19 09:14:46', '2025-02-19 09:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `vehicle_no` varchar(255) NOT NULL,
  `engin_no` varchar(255) NOT NULL,
  `chest_no` varchar(255) NOT NULL,
  `total_seat` int(11) NOT NULL,
  `amenities_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`amenities_id`)),
  `document` varchar(255) DEFAULT NULL,
  `is_booked` varchar(255) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `company_id`, `owner_id`, `type_id`, `category`, `name`, `vehicle_no`, `engin_no`, `chest_no`, `total_seat`, `amenities_id`, `document`, `is_booked`, `status`, `created_at`, `updated_at`) VALUES
(5, 9, 2, 8, '0', 'Golden Line', '3818', '1HDFG456789', 'CK1X98765Y4567', 20, '[\"9\",\"8\"]', NULL, '1', 1, '2025-02-04 05:45:38', '2025-02-18 05:19:16'),
(6, 9, 2, 7, '1', 'Golden Line', '3001', '1HDFG456789', 'CK1X98765Y4567', 12, '[\"11\",\"9\"]', NULL, '1', 1, '2025-02-04 05:59:02', '2025-02-18 06:44:21'),
(7, 9, 2, 8, '2', 'Golden Line', '3240', '1HDFG456785', 'JH1X45678Y1231', 24, '[\"11\",\"10\",\"9\",\"8\"]', NULL, '0', 1, '2025-02-17 11:40:54', '2025-02-17 11:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_publisheds`
--

CREATE TABLE `vehicle_publisheds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `start_location_id` int(11) DEFAULT NULL,
  `end_location_id` int(11) DEFAULT NULL,
  `journey_date` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkers`
--
ALTER TABLE `checkers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counters`
--
ALTER TABLE `counters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cupons`
--
ALTER TABLE `cupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journey_types`
--
ALTER TABLE `journey_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plane_journeys`
--
ALTER TABLE `plane_journeys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route_managers`
--
ALTER TABLE `route_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_bookings`
--
ALTER TABLE `ticket_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_publisheds`
--
ALTER TABLE `vehicle_publisheds`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `checkers`
--
ALTER TABLE `checkers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `counters`
--
ALTER TABLE `counters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cupons`
--
ALTER TABLE `cupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journey_types`
--
ALTER TABLE `journey_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `planes`
--
ALTER TABLE `planes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `plane_journeys`
--
ALTER TABLE `plane_journeys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `route_managers`
--
ALTER TABLE `route_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_bookings`
--
ALTER TABLE `ticket_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vehicle_publisheds`
--
ALTER TABLE `vehicle_publisheds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
