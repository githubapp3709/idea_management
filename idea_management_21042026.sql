-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 21, 2026 at 04:28 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idea_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model`, `model_id`, `old_values`, `new_values`, `remark`, `created_at`, `updated_at`) VALUES
(1, 3, 'idea_approved', 'Idea', 20, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', NULL, '2026-02-11 00:22:42', '2026-02-11 00:22:42'),
(2, 3, 'idea_rejected', 'Idea', 21, '{\"status\": \"submitted\"}', '{\"status\": \"rejected\"}', 'rejected', '2026-02-11 00:30:12', '2026-02-11 00:30:12'),
(3, 3, 'idea_approved', 'Idea', 22, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', NULL, '2026-02-11 00:56:35', '2026-02-11 00:56:35'),
(4, 1, 'idea_approved', 'Idea', 24, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', NULL, '2026-02-11 05:59:07', '2026-02-11 05:59:07'),
(5, 1, 'idea_approved', 'Idea', 26, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', NULL, '2026-02-12 07:09:38', '2026-02-12 07:09:38'),
(6, 25, 'idea_approved', 'Idea', 33, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', 'Hello', '2026-03-17 01:27:59', '2026-03-17 01:27:59'),
(7, 25, 'idea_approved', 'Idea', 34, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', 'good', '2026-03-17 06:33:29', '2026-03-17 06:33:29'),
(8, 1, 'idea_approved', 'Idea', 31, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', NULL, '2026-03-19 02:28:07', '2026-03-19 02:28:07'),
(9, 1, 'idea_approved', 'Idea', 30, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', NULL, '2026-03-19 02:28:16', '2026-03-19 02:28:16'),
(10, 1, 'idea_approved', 'Idea', 23, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', NULL, '2026-03-19 02:28:30', '2026-03-19 02:28:30'),
(11, 1, 'idea_rejected', 'Idea', 5, '{\"status\": \"submitted\"}', '{\"status\": \"rejected\"}', 'Hello', '2026-03-19 02:28:57', '2026-03-19 02:28:57'),
(12, 1, 'idea_rejected', 'Idea', 4, '{\"status\": \"submitted\"}', '{\"status\": \"rejected\"}', 'NA', '2026-03-19 02:29:14', '2026-03-19 02:29:14'),
(13, 1, 'idea_approved', 'Idea', 38, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', NULL, '2026-03-25 05:49:39', '2026-03-25 05:49:39'),
(14, 25, 'idea_approved', 'Idea', 49, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', 'approved hai idea testing k liye', '2026-04-02 04:43:02', '2026-04-02 04:43:02'),
(15, 25, 'idea_approved', 'Idea', 50, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', 'approve', '2026-04-02 05:12:44', '2026-04-02 05:12:44'),
(16, 1, 'idea_rejected', 'Idea', 53, '{\"status\": \"submitted\"}', '{\"status\": \"rejected\"}', 'BekR', '2026-04-06 23:57:27', '2026-04-06 23:57:27'),
(17, 1, 'idea_rejected', 'Idea', 47, '{\"status\": \"submitted\"}', '{\"status\": \"rejected\"}', 'hello', '2026-04-07 02:51:03', '2026-04-07 02:51:03'),
(18, 1, 'idea_approved', 'Idea', 36, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', 'approve', '2026-04-07 02:51:50', '2026-04-07 02:51:50'),
(19, 25, 'idea_approved', 'Idea', 43, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', 'ss', '2026-04-17 00:25:16', '2026-04-17 00:25:16'),
(20, 19, 'idea_approved', 'Idea', 59, '{\"status\": \"submitted\"}', '{\"status\": \"approved\"}', 'Hello', '2026-04-19 23:41:42', '2026-04-19 23:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-superadmin@gmail.com|127.0.0.1:timer', 'i:1775110294;', 1775110294),
('laravel-cache-superadmin@gmail.com|127.0.0.1', 'i:1;', 1775110294),
('laravel-cache-neeraj@example.com|127.0.0.1:timer', 'i:1775118817;', 1775118817),
('laravel-cache-neeraj@example.com|127.0.0.1', 'i:1;', 1775118817),
('laravel-cache-adityadandotia@ens.enterprises|127.0.0.1:timer', 'i:1775548102;', 1775548102),
('laravel-cache-adityadandotia@ens.enterprises|127.0.0.1', 'i:1;', 1775548102);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ideas`
--

DROP TABLE IF EXISTS `ideas`;
CREATE TABLE IF NOT EXISTS `ideas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `impact_level` enum('low','medium','high') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `submitted_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `review_remark` text COLLATE utf8mb4_unicode_ci,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `swot` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `ideas_user_id_foreign` (`user_id`),
  KEY `ideas_team_id_foreign` (`team_id`),
  KEY `ideas_reviewed_by_foreign` (`reviewed_by`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ideas`
--

INSERT INTO `ideas` (`id`, `user_id`, `team_id`, `title`, `description`, `category`, `impact_level`, `status`, `submitted_at`, `reviewed_at`, `created_at`, `updated_at`, `review_remark`, `reviewed_by`, `deleted_at`, `swot`) VALUES
(1, 43, 27, 'Trump tariff refunds start from Monday, largest in US history: What it means and who gets the money back', 'The US government is set to kick off a long-awaited process to refund billions of dollars in tariffs after the Supreme Court struck down duties imposed by President Donald Trump earlier this year.\r\n\r\nAn online portal, launched by US Customs and Border Protection (CBP), allows importers to begin filing claims from Monday morning, marking the first phase of what could become the largest tariff refund exercise in US history.', 'HR', 'low', 'submitted', '2026-04-20 04:45:07', NULL, '2026-04-20 04:44:51', '2026-04-20 04:45:07', NULL, NULL, NULL, 'Who can claim refunds\r\n\r\nImporters and authorised customs brokers who paid tariffs under emergency powers can now submit claims through the CBP system.\r\n\r\nBut eligibility is limited in the first phase. Only certain “unliquidated” entries or those within 80 days of final accounting qualify initially, according to a report in Axios.\r\n\r\nAccording to CBP filings, over 330,000 importers paid about $166 billion in duties across more than 53 million shipments. However, only around 56,500 had completed the mandatory registration for electronic payments as of mid-April.'),
(2, 43, 27, 'Why refunds are being issued', 'In a 6–3 ruling on February 20, the Supreme Court found that Trump exceeded his authority by using a 1977 emergency law to impose sweeping tariffs, effectively bypassing Congress’ power to set taxes.\r\n\r\nWhile the top court did not directly address refunds, the US Court of International Trade later ruled that affected companies are entitled to reimbursement.', 'Tech', 'medium', 'submitted', '2026-04-20 04:47:43', NULL, '2026-04-20 04:47:31', '2026-04-20 04:47:43', NULL, NULL, NULL, 'Will consumers get any money back?\r\n\r\nNot necessarily. Tariffs are paid by importers, who often pass costs on to consumers through higher prices.\r\n\r\nThe current system refunds businesses — and they are not obligated to share the money, AP reported.\r\n\r\nThat said, some firms have indicated they may pass refunds along. Delivery giants like FedEx have said they will return tariff refunds to customers once received.'),
(3, 43, 27, 'Meanwhile, lawsuits against companies including Costco and EssilorLuxottica are seeking to force reimbursements to consumers. (AP, Axios)', 'What could delay payouts\r\n\r\nThe rollout is expected to be gradual. CBP will prioritise more recent payments, and technical glitches or documentation issues could slow processing.\r\n\r\n“Like any electronic online program that goes live with a lot of interest, I would expect that there might be some hiccups with the program on Monday,” Supino said.\r\n\r\nBusinesses also warn of cash flow concerns if refunds take months.\r\n\r\n“My main concern is the turnaround time,” Brad Jackson, co-founder of After Action Cigars, told AP. “A refund process that takes several months to complete doesn’t solve the cash flow problem that it is supposed to fix.”', 'Process', 'high', 'draft', NULL, NULL, '2026-04-20 04:49:13', '2026-04-20 04:49:13', NULL, NULL, NULL, 'What could delay payouts\r\n\r\nThe rollout is expected to be gradual. CBP will prioritise more recent payments, and technical glitches or documentation issues could slow processing.\r\n\r\n“Like any electronic online program that goes live with a lot of interest, I would expect that there might be some hiccups with the program on Monday,” Supino said.\r\n\r\nBusinesses also warn of cash flow concerns if refunds take months.\r\n\r\n“My main concern is the turnaround time,” Brad Jackson, co-founder of After Action Cigars, told AP. “A refund process that takes several months to complete doesn’t solve the cash flow problem that it is supposed to fix.”');

-- --------------------------------------------------------

--
-- Table structure for table `idea_attachments`
--

DROP TABLE IF EXISTS `idea_attachments`;
CREATE TABLE IF NOT EXISTS `idea_attachments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `idea_id` bigint UNSIGNED NOT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idea_attachments_idea_id_foreign` (`idea_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `idea_attachments`
--

INSERT INTO `idea_attachments` (`id`, `idea_id`, `file_path`, `file_type`, `created_at`, `updated_at`) VALUES
(1, 1, 'ideas/attachments/FebivEl7byQGQbYjl2hze0HIMCSqbY8qwnobyCEk.png', 'image', '2026-04-20 04:44:51', '2026-04-20 04:44:51'),
(2, 1, 'ideas/attachments/cGWUtVDcmzpBfsdr23pmBBQmtTN2MF6JYgJYajeA.mp4', 'video', '2026-04-20 04:44:51', '2026-04-20 04:44:51'),
(3, 2, 'ideas/attachments/ptp7dOVluZsv7gSOCs5xd73UJ5lifbA7zs4XzrDu.xlsx', 'document', '2026-04-20 04:47:31', '2026-04-20 04:47:31'),
(4, 2, 'ideas/attachments/7YYLS7VSET23fyhZ3pwgyWqSLnAuydYI0fpsknPs.mp4', 'video', '2026-04-20 04:47:31', '2026-04-20 04:47:31'),
(5, 3, 'ideas/attachments/sXvNHRyhVACNU0kGCUy4TssPi7DNyHOpSZAvwaKC.xlsx', 'document', '2026-04-20 04:49:13', '2026-04-20 04:49:13'),
(6, 3, 'ideas/attachments/P7ALHHyKvA49T6YtwFlnlEAlqVS6tC2PFRZ4hf0z.xlsx', 'document', '2026-04-20 04:49:13', '2026-04-20 04:49:13');

-- --------------------------------------------------------

--
-- Table structure for table `idea_rewards`
--

DROP TABLE IF EXISTS `idea_rewards`;
CREATE TABLE IF NOT EXISTS `idea_rewards` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `idea_id` bigint UNSIGNED NOT NULL,
  `points` int NOT NULL,
  `bonus_points` int NOT NULL DEFAULT '0',
  `awarded_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idea_rewards_idea_id_foreign` (`idea_id`),
  KEY `idea_rewards_awarded_by_foreign` (`awarded_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_04_053106_create_roles_table', 1),
(5, '2026_02_04_053426_add_role_and_team_to_users', 1),
(6, '2026_02_04_072108_create_teams_table', 2),
(7, '2026_02_05_050423_create_ideas_table', 3),
(8, '2026_02_05_102115_add_review_fields_to_ideas', 4),
(9, '2026_02_05_120301_create_idea_rewards_table', 5),
(10, '2026_02_05_120815_create_reward_logs_table', 5),
(11, '2026_02_06_062257_add_reward_points_to_users', 6),
(12, '2026_02_06_070702_create_notifications_table', 7),
(13, '2026_02_06_102344_create_activity_logs_table', 8),
(14, '2026_02_13_072058_add_status_to_users_table', 9),
(15, '2026_02_13_074357_add_employee_code_to_users_table', 10),
(16, '2026_02_16_044135_add_deleted_at_to_users_table', 11),
(17, '2026_02_17_064121_add_image_to_teams_table', 12),
(18, '2026_02_17_110427_add_profile_photo_to_users_table', 13),
(19, '2026_02_17_110911_add_profile_image_to_users_table', 14),
(20, '2026_02_18_095757_create_idea_attachments_table', 15),
(21, '2026_02_19_080525_add_soft_deletes_to_ideas_table', 16),
(22, '2026_03_25_050328_add_swot_to_ideas_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('25192781-de38-41f6-9376-98c5da7ad616', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 2, '{\"idea_id\":20,\"title\":\"Enim eligendi tempor\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-02-11 00:29:10', '2026-02-11 00:22:42', '2026-02-11 00:29:10'),
('dacf1108-68aa-43fe-a778-3268efa4e8cb', 'App\\Modules\\Notification\\Notifications\\IdeaRejectedNotification', 'App\\Models\\User', 2, '{\"idea_id\":21,\"title\":\"Perspiciatis modi q\",\"message\":\"Your idea was rejected\",\"remark\":\"rejected\",\"status\":\"rejected\"}', '2026-02-11 23:22:58', '2026-02-11 00:30:12', '2026-02-11 23:22:58'),
('1085d77c-6148-4d06-8b8e-0a5986627a25', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 3, '{\"idea_id\":22,\"title\":\"Magna et consequat\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"John Doe\"}', '2026-02-11 00:56:21', '2026-02-11 00:56:09', '2026-02-11 00:56:21'),
('c6b0ec6b-5523-4c4c-9434-7eb25ae363db', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 2, '{\"idea_id\":22,\"title\":\"Magna et consequat\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-02-11 23:22:56', '2026-02-11 00:56:35', '2026-02-11 23:22:56'),
('a3282936-30e0-48b3-ab9d-3b882f9cb067', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 2, '{\"idea_id\":24,\"title\":\"Labore autem ipsam e\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-02-11 23:22:54', '2026-02-11 05:59:07', '2026-02-11 23:22:54'),
('30ab9f49-b607-4e6c-983f-e0fd4b7ab68a', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 3, '{\"idea_id\":27,\"title\":\"Corrupti possimus\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"John Doe\"}', '2026-02-11 23:24:40', '2026-02-11 06:29:35', '2026-02-11 23:24:40'),
('5f13cfdc-84e9-4281-9264-d96406be6b88', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 2, '{\"idea_id\":26,\"title\":\"Voluptas consequat\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-02-12 22:48:09', '2026-02-12 07:09:38', '2026-02-12 22:48:09'),
('c84abf31-b054-46ae-92ee-ee62bce5fd6f', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":32,\"title\":\"Testing\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-03-17 01:56:54', '2026-02-19 06:31:49', '2026-03-17 01:56:54'),
('45efb137-dc31-4e58-85d8-f0035b684942', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":33,\"title\":\"Possimus sint ea r\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-03-17 01:56:52', '2026-03-17 01:24:51', '2026-03-17 01:56:52'),
('c2f2a300-ddea-407c-8f94-17be622df42c', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 21, '{\"idea_id\":33,\"title\":\"Possimus sint ea r\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-03-24 23:48:02', '2026-03-17 01:27:59', '2026-03-24 23:48:02'),
('8d885711-b3a3-4421-ae5f-b5e83a12fa6c', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":34,\"title\":\"Qui ea laboris quia\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-03-24 01:59:55', '2026-03-17 04:36:20', '2026-03-24 01:59:55'),
('81d9dc3f-526b-4f60-8f88-ecc653c8727a', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 21, '{\"idea_id\":34,\"title\":\"Qui ea laboris quia\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-03-24 23:48:02', '2026-03-17 06:33:29', '2026-03-24 23:48:02'),
('49863cd6-fbf6-4896-9f08-41584fb328dc', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 1, '{\"idea_id\":31,\"title\":\"Validation\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-03-25 06:22:39', '2026-03-19 02:28:07', '2026-03-25 06:22:39'),
('261849c5-6bab-4d43-8db3-43d713405547', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 1, '{\"idea_id\":30,\"title\":\"Hello one\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-03-25 06:22:39', '2026-03-19 02:28:16', '2026-03-25 06:22:39'),
('c9cc605a-e04a-428e-b1df-67a2eb02f116', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 2, '{\"idea_id\":23,\"title\":\"Neque amet aut reic\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', NULL, '2026-03-19 02:28:30', '2026-03-19 02:28:30'),
('f12df802-dae0-4ac9-871a-5bd24fce84ff', 'App\\Modules\\Notification\\Notifications\\IdeaRejectedNotification', 'App\\Models\\User', 2, '{\"idea_id\":5,\"title\":\"Hello World 2\",\"message\":\"Your idea was rejected\",\"remark\":\"Hello\",\"status\":\"rejected\"}', NULL, '2026-03-19 02:28:57', '2026-03-19 02:28:57'),
('3c450904-7a57-44da-b9f2-c945cf54346b', 'App\\Modules\\Notification\\Notifications\\IdeaRejectedNotification', 'App\\Models\\User', 2, '{\"idea_id\":4,\"title\":\"idea2 oK\",\"message\":\"Your idea was rejected\",\"remark\":\"NA\",\"status\":\"rejected\"}', NULL, '2026-03-19 02:29:14', '2026-03-19 02:29:14'),
('59cd2988-ec55-43cc-9892-08616c1a5f4c', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":36,\"title\":\"Enim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat d\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-03-24 01:59:54', '2026-03-20 01:06:55', '2026-03-24 01:59:54'),
('d265067f-02f7-42f6-9db5-b3904b76ed1e', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":38,\"title\":\"Assumenda voluptate\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-04-02 04:05:46', '2026-03-24 23:47:35', '2026-04-02 04:05:46'),
('172bf3ff-0f6c-49cc-a8d3-84c2446ef747', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":38,\"title\":\"Assumenda voluptate\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-04-02 04:05:46', '2026-03-25 04:09:10', '2026-04-02 04:05:46'),
('cf7de917-e00e-41b0-9ac2-6db3246aa69e', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":38,\"title\":\"Assumenda voluptate\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-04-02 04:05:46', '2026-03-25 04:23:54', '2026-04-02 04:05:46'),
('1fb67306-ea8a-48cd-b052-39b649169403', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":38,\"title\":\"Assumenda voluptate\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-04-02 04:05:46', '2026-03-25 05:47:10', '2026-04-02 04:05:46'),
('fe0a3169-eafd-471a-b908-258b225e22bd', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 21, '{\"idea_id\":38,\"title\":\"Assumenda voluptate\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-04-02 04:06:52', '2026-03-25 05:49:39', '2026-04-02 04:06:52'),
('f1034e2c-3f44-41e1-b8da-a76a8ff7675f', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":43,\"title\":\"Nihil nihil consequa\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-04-02 04:05:46', '2026-03-25 05:52:03', '2026-04-02 04:05:46'),
('ac7f7716-3d43-4b17-9c3c-84fa1ecda9ef', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":47,\"title\":\"Ea eligendi facere q\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-04-02 06:25:12', '2026-04-02 04:06:26', '2026-04-02 06:25:12'),
('5d373c91-01bd-45b3-9df5-4fd32716b07b', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":49,\"title\":\"Sunt laudantium sed\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-04-02 06:25:12', '2026-04-02 04:32:42', '2026-04-02 06:25:12'),
('47a366d4-a6b1-4796-9967-5ed11a702626', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 21, '{\"idea_id\":49,\"title\":\"Sunt laudantium sed\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-04-08 00:43:27', '2026-04-02 04:42:57', '2026-04-08 00:43:27'),
('02c9443c-5d40-44c0-90be-46ab691eb839', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":50,\"title\":\"Deleniti nisi quasi\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-04-02 06:25:12', '2026-04-02 05:11:56', '2026-04-02 06:25:12'),
('a801b335-473c-4eba-bb47-b0a6817bafe2', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 21, '{\"idea_id\":50,\"title\":\"Deleniti nisi quasi\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-04-08 00:43:27', '2026-04-02 05:12:40', '2026-04-08 00:43:27'),
('3adfd67b-b7f2-456e-8456-53f58442b849', 'App\\Modules\\Notification\\Notifications\\IdeaRejectedNotification', 'App\\Models\\User', 1, '{\"idea_id\":53,\"title\":\"Hello test\",\"message\":\"Your idea was rejected\",\"remark\":\"BekR\",\"status\":\"rejected\"}', '2026-04-06 23:59:42', '2026-04-06 23:57:10', '2026-04-06 23:59:42'),
('d012f944-3a7d-4413-a097-cc4e5e480fbd', 'App\\Modules\\Notification\\Notifications\\IdeaRejectedNotification', 'App\\Models\\User', 21, '{\"idea_id\":47,\"title\":\"Ea eligendi facere q\",\"message\":\"Your idea was rejected\",\"remark\":\"hello\",\"status\":\"rejected\"}', '2026-04-08 00:43:27', '2026-04-07 02:50:58', '2026-04-08 00:43:27'),
('dd452350-cd4e-46b1-81dd-6a5dcd7b0cd8', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 21, '{\"idea_id\":36,\"title\":\"Enim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat dEnim ut in quaerat d\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', '2026-04-08 00:43:27', '2026-04-07 02:51:45', '2026-04-08 00:43:27'),
('40753d4b-b441-47eb-b5ed-dafaa5ba199d', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":54,\"title\":\"Nostrud quod laborum\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', '2026-04-07 02:58:52', '2026-04-07 02:53:01', '2026-04-07 02:58:52'),
('933db5e7-bc57-4a90-b4f1-686c5ed1281d', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":48,\"title\":\"Ea eligendi facere q\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', NULL, '2026-04-08 06:29:58', '2026-04-08 06:29:58'),
('af8a7abd-963f-4780-ad13-8c14f6a569dd', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":55,\"title\":\"Ad amet ea rem dolo\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Lalit updated\"}', NULL, '2026-04-09 01:15:12', '2026-04-09 01:15:12'),
('4680ead8-8e97-48eb-8e59-061f0a139163', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":54,\"title\":\"Nostrud quod laborum\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', NULL, '2026-04-09 02:04:48', '2026-04-09 02:04:48'),
('18fdafa2-253b-43eb-991e-c5957239855c', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":57,\"title\":\"Thank you his idea hello\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', NULL, '2026-04-10 07:22:29', '2026-04-10 07:22:29'),
('59c36e39-bb99-4d75-aefd-b280433f076c', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":58,\"title\":\"checking regards\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', NULL, '2026-04-10 07:31:31', '2026-04-10 07:31:31'),
('274c476b-a472-4d7d-a984-3eb0f31cab69', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 21, '{\"idea_id\":43,\"title\":\"Nihil nihil consequa\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', NULL, '2026-04-17 00:24:55', '2026-04-17 00:24:55'),
('114b7f44-9e45-4724-a4bc-ae061063797f', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":58,\"title\":\"checking regards\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', NULL, '2026-04-17 00:27:25', '2026-04-17 00:27:25'),
('0b61ae96-f970-437f-a0c2-414cc38c744d', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":57,\"title\":\"Thank you his idea hello\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', NULL, '2026-04-17 00:27:37', '2026-04-17 00:27:37'),
('a97e4fa1-3267-412b-9349-bb435c98f0f9', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":54,\"title\":\"Nostrud quod laborum\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', NULL, '2026-04-17 00:27:49', '2026-04-17 00:27:49'),
('62c64966-2282-4d77-b92b-c7f8b13dbe73', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 25, '{\"idea_id\":48,\"title\":\"Ea eligendi facere q\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Neeraj\"}', NULL, '2026-04-17 00:28:03', '2026-04-17 00:28:03'),
('7665b439-0042-4e90-8de5-438aab471859', 'App\\Modules\\Notification\\Notifications\\IdeaSentBackNotification', 'App\\Models\\User', 21, '[]', NULL, '2026-04-17 00:28:47', '2026-04-17 00:28:47'),
('91992463-ccc5-436b-a7e1-3a48c9edd3b7', 'App\\Modules\\Notification\\Notifications\\IdeaSentBackNotification', 'App\\Models\\User', 21, '[]', NULL, '2026-04-17 00:41:39', '2026-04-17 00:41:39'),
('e2b4e494-b17d-49cb-8a25-9aa8dbedf739', 'App\\Modules\\Notification\\Notifications\\IdeaSentBackNotification', 'App\\Models\\User', 21, '{\"idea_id\":57,\"title\":\"Thank you his idea hello\",\"message\":\"Idea sent back for revision\",\"url\":\"\\/ideas\\/57\\/edit\"}', NULL, '2026-04-17 00:53:32', '2026-04-17 00:53:32'),
('46fc5756-7569-4703-acdd-f2f29e3ee429', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 19, '{\"idea_id\":59,\"title\":\"Architecto optio al\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Mike\"}', NULL, '2026-04-19 23:39:21', '2026-04-19 23:39:21'),
('6c9970fd-ada7-4780-af60-70f5f3a59001', 'App\\Modules\\Notification\\Notifications\\IdeaApprovedNotification', 'App\\Models\\User', 34, '{\"idea_id\":59,\"title\":\"Architecto optio al\",\"message\":\"Your idea has been approved \\ud83c\\udf89\",\"status\":\"approved\"}', NULL, '2026-04-19 23:41:38', '2026-04-19 23:41:38'),
('b15c81a1-3565-4e7f-a9f6-dbae7c8a057d', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 39, '{\"idea_id\":1,\"title\":\"Trump tariff refunds start from Monday, largest in US history: What it means and who gets the money back\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Lalit Kumar\"}', NULL, '2026-04-20 04:45:07', '2026-04-20 04:45:07'),
('bee613eb-f2df-46e5-bc5e-ed23ad06b6be', 'App\\Modules\\Notification\\Notifications\\IdeaSubmittedNotification', 'App\\Models\\User', 39, '{\"idea_id\":2,\"title\":\"Why refunds are being issued\",\"message\":\"New idea submitted for review\",\"submitted_by\":\"Lalit Kumar\"}', NULL, '2026-04-20 04:47:43', '2026-04-20 04:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reward_logs`
--

DROP TABLE IF EXISTS `reward_logs`;
CREATE TABLE IF NOT EXISTS `reward_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `idea_id` bigint UNSIGNED NOT NULL,
  `points` int NOT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reward_logs_user_id_foreign` (`user_id`),
  KEY `reward_logs_idea_id_foreign` (`idea_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reward_logs`
--

INSERT INTO `reward_logs` (`id`, `user_id`, `idea_id`, `points`, `reason`, `created_at`, `updated_at`) VALUES
(1, 2, 20, 60, 'Idea approved', '2026-02-11 00:22:42', '2026-02-11 00:22:42'),
(2, 2, 22, 30, 'Idea approved', '2026-02-11 00:56:35', '2026-02-11 00:56:35'),
(3, 2, 24, 60, 'Idea approved', '2026-02-11 05:59:07', '2026-02-11 05:59:07'),
(4, 2, 26, 100, 'Idea approved', '2026-02-12 07:09:38', '2026-02-12 07:09:38'),
(5, 21, 33, 100, 'Idea approved', '2026-03-17 01:27:59', '2026-03-17 01:27:59'),
(6, 21, 34, 100, 'Idea approved', '2026-03-17 06:33:29', '2026-03-17 06:33:29'),
(7, 1, 31, 60, 'Idea approved', '2026-03-19 02:28:06', '2026-03-19 02:28:06'),
(8, 1, 30, 60, 'Idea approved', '2026-03-19 02:28:16', '2026-03-19 02:28:16'),
(9, 2, 23, 60, 'Idea approved', '2026-03-19 02:28:30', '2026-03-19 02:28:30'),
(10, 21, 38, 100, 'Idea approved', '2026-03-25 05:49:39', '2026-03-25 05:49:39'),
(11, 21, 49, 100, 'Idea approved', '2026-04-02 04:42:57', '2026-04-02 04:42:57'),
(12, 21, 50, 60, 'Idea approved', '2026-04-02 05:12:40', '2026-04-02 05:12:40'),
(13, 21, 36, 30, 'Idea approved', '2026-04-07 02:51:45', '2026-04-07 02:51:45'),
(14, 21, 43, 100, 'Idea approved', '2026-04-17 00:24:54', '2026-04-17 00:24:54'),
(15, 34, 59, 100, 'Idea approved', '2026-04-19 23:41:38', '2026-04-19 23:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', '2026-02-04 01:24:13', '2026-02-04 01:24:13'),
(2, 'team_lead', '2026-02-04 01:24:13', '2026-02-04 01:24:13'),
(3, 'employee', '2026-02-04 01:24:13', '2026-02-04 01:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('hjfd5qgG1gspSmevxT6szfrfQb2hG0xhPfSZlH5l', 43, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMndtNXptY0Q0cHRkV2p4eU1uc0J5c1hDdVVsSzVpajZIOVVzeWhQMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDM7fQ==', 1776690312),
('JzabuKYGDnkXMYgcfBNMzLHRKRsk6fsQbLH33L3I', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNENHdDZDbmlmZnU1b2ZlNkE3YmVpeHZlUGpPRGg2aG50VzBaVzVsdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776745511),
('aM7kzuTkshvjvwYMfodcw0iVxFmxc7vtQ3Q1uqFp', 39, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVVhrM1JUcnoyUUY2WDNqS0w2eFpKMDYxTGdTS2UyUGxETkk2Qnp1NCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pZGVhcyI7czo1OiJyb3V0ZSI7czoxMToiaWRlYXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozOTt9', 1776682384),
('YSpGwDYlihr0F2NFA0i4igK2sM0hksJ4HRlBmoDG', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUk9XTk5RNnRtT3QzSFpEUDdWeFRUVVVkMTRyZ0lLc28ydG5wSWdSaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pZGVhcyI7czo1OiJyb3V0ZSI7czoxMToiaWRlYXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1776690312),
('pC5fdzY17CbTxzijMiFbhIh5ls76KMUNdgvtwyht', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVHoxN3lqV0VmV1Zva0ZxS2dCWFl4cFhHRndPU0JiaWZqMmpEM1VrVyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2lkZWFzIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776681737);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE IF NOT EXISTS `teams` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_lead_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teams_team_lead_id_foreign` (`team_lead_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `team_lead_id`, `created_at`, `updated_at`, `image`) VALUES
(30, 'Champions', 50, '2026-04-20 01:43:39', '2026-04-20 01:44:23', 'teams/AbZR3Y0DDIutGc7ljJucojpOCABW0sO35BRMANb8.png'),
(29, 'Pink Panthers', 40, '2026-04-20 01:12:30', '2026-04-20 01:36:07', 'teams/PVB3gNWTi3RhQy2OLpznsuzAHWtLiIqxrpM5lozs.png'),
(27, 'Atal Warriors', 39, '2026-04-20 01:10:44', '2026-04-20 01:35:57', 'teams/NBiVvPPeh3Afq6Ya5Rtl7g4iY1fEf7Un48vAXlQq.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `team_id` bigint UNSIGNED DEFAULT NULL,
  `reward_points` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_employee_code_unique` (`employee_code`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_team_id_foreign` (`team_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_code`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `team_id`, `reward_points`, `status`, `deleted_at`, `profile_image`) VALUES
(1, 'EMP001', 'Admin', 'shakti.kapoor@ens.enterprises', NULL, '$2y$12$4C.kyrC1ew6do2ddhNnlAOdschKuhUBPdp/uCjIKFDwnN.7fGUwES', NULL, '2026-02-04 01:32:13', '2026-04-20 00:56:06', 1, NULL, 0, 'active', NULL, 'employees/mYYYi7E0nKRMgrWi01WdOPmU7mbMqxGkzaqqoixC.png'),
(40, 'EMP004', 'Dharmendra Yadav', 'dharmendra.yadav@ens.enterprises', NULL, '$2y$12$Ju4gjwBU5ZALemTSiGcbbOsitn4RYIXkUTqaB5Km2tP0yptFEEA7y', NULL, '2026-04-20 00:45:02', '2026-04-20 01:36:07', 2, 29, 0, 'active', NULL, 'employees/WFPEAUTVAY98Z3HhdrN9Tdxb4pFIGLU4sXKzOHsW.jpg'),
(41, 'EMP005', 'Aditya Dandotia', 'aditya.dandotia@ens.enterprises', NULL, '$2y$12$vxW5zgAlHnIHfu9cEGemEe7obRT7YWrWuL2GGxydvv3Mc0wm7OCye', NULL, '2026-04-20 00:45:02', '2026-04-20 00:52:26', 3, NULL, 0, 'active', NULL, 'employees/cLALeZXqjGhZCBBRGhGJNOAm7BrG9rhWTcKDTkaW.jpg'),
(42, 'EMP006', 'Rahul Dabral', 'rahul.dabral@xyz.com', NULL, '$2y$12$kdFgyRIz80fX/6VvJnv34uCJ9N/yd38h.C5hOrBug5OeOqLA.kDiK', NULL, '2026-04-20 01:07:56', '2026-04-20 01:36:07', 3, 29, 0, 'active', NULL, NULL),
(43, 'EMP007', 'Lalit Kumar', 'lalit.kumar@xyz.com', NULL, '$2y$12$yeZTtltnTZVS/C2.ueIfvOqplCFEaH4kEC9iXf4PsIjucMSioeqz.', NULL, '2026-04-20 01:07:56', '2026-04-20 01:35:57', 3, 27, 0, 'active', NULL, NULL),
(44, 'EMP008', 'Deepak Singh', 'deepak.singh@xyz.com', NULL, '$2y$12$yWhDvRYt2LexqFIHCPk.6ea18qHMMc0JVj.y9e5OeI.sgiA/TtLIS', NULL, '2026-04-20 01:07:56', '2026-04-20 01:35:57', 3, 27, 0, 'active', NULL, NULL),
(45, 'EMP009', 'Navin Srivastva', 'navin.srivastva@xyz.com', NULL, '$2y$12$HMnFFbLdAkR8/DyABRyL5uvtc9cyivg6bulVoX3OwKdwzp9nqJdSG', NULL, '2026-04-20 01:07:57', '2026-04-20 01:36:07', 3, 29, 0, 'active', NULL, NULL),
(46, 'EMP010', 'Nandram', 'nandram.nandram@xyz.com', NULL, '$2y$12$fCgTttognM4eo6C.wdPjj.CY1PfBu6NmOWegZkjFZJ9OCGtR/wq/W', NULL, '2026-04-20 01:07:57', '2026-04-20 01:07:57', 3, NULL, 0, 'active', NULL, NULL),
(47, 'EMP011', 'Anil Bhatnagar', 'anil.bhatnagar@xyz.com', NULL, '$2y$12$V4UezQWuwVMlJtkjPnds1.81zffN3GyTxYV/aqS1DYjT29mm.y3ee', NULL, '2026-04-20 01:07:58', '2026-04-20 01:07:58', 3, NULL, 0, 'active', NULL, NULL),
(48, 'EMP012', 'Neeraj Gupta', 'neeraj.gupta@xyz.com', NULL, '$2y$12$mGNP6STiB5U93T4obGq78ukjq28oMu.rsHWr/k64IQcsJip431WIG', NULL, '2026-04-20 01:07:58', '2026-04-20 01:07:58', 3, NULL, 0, 'active', NULL, NULL),
(49, 'EMP013', 'Avanish Kumar', 'avanish.kumar@xyz.com', NULL, '$2y$12$STRje.GqRM9B8BTiiacomuLK1JlBeavm7mFA494SN/ZrexghwHZUS', NULL, '2026-04-20 01:07:58', '2026-04-20 01:44:23', 3, 30, 0, 'active', NULL, NULL),
(50, 'EMP014', 'Satyam Srivastva', 'satyam.srivastva@xyz.com', NULL, '$2y$12$4InwMpXyfY2hO0piWUa7Pu72dB19oGieJCbeIvth1U.91cMnaCLpu', NULL, '2026-04-20 01:07:59', '2026-04-20 01:44:23', 2, 30, 0, 'active', NULL, NULL),
(51, 'EMP015', 'Satya Yadav', 'satya.yadav@xyz.com', NULL, '$2y$12$iLdJvgr8afkTZ9jLBXm4A.JSB6Vttuj9Skbz4YVwdzf4MNpiKSM7.', NULL, '2026-04-20 01:07:59', '2026-04-20 01:07:59', 3, NULL, 0, 'active', NULL, NULL),
(52, 'EMP016', 'Vipul Yadav', 'vipul.yadav@xyz.com', NULL, '$2y$12$eAqfHDmwI/TcYg.mQ.tGjeNVlFX7.SUd5cIhNIT/oR.qvNDTMoLHO', NULL, '2026-04-20 01:07:59', '2026-04-20 01:44:23', 3, 30, 0, 'active', NULL, NULL),
(53, 'EMP017', 'Deep Singh', 'deep.singh@xyz.com', NULL, '$2y$12$TMiTNxizEU2JKebjcJ1Pzui6YoSdmKOAdhpwGYOSn5CxPFcfbMm4S', NULL, '2026-04-20 01:08:00', '2026-04-20 02:54:01', 3, NULL, 0, 'active', '2026-04-20 02:54:01', NULL),
(54, 'EMP018', 'Pratam Singh', 'pratam.singh@xyz.com', NULL, '$2y$12$f/tlKAxwEU8oQKoDTdbYsupj4NY./AL41HIFd9WkONbqqJ9sT3wym', NULL, '2026-04-20 01:08:00', '2026-04-20 01:40:24', 2, NULL, 0, 'active', NULL, NULL),
(55, 'EMP019', 'Rajesh Kumar', 'rajesh.kumar@xyz.com', NULL, '$2y$12$KhYOE9.PhiJ4yp/OhXH8VuE9BFVgnKqJuYcBnp1o3QpDHTb0g3lSO', NULL, '2026-04-20 01:08:00', '2026-04-20 01:08:00', 3, NULL, 0, 'active', NULL, NULL),
(56, 'EMP020', 'Binay Rai', 'binay.rai@xyz.com', NULL, '$2y$12$paS9nXaHLECMyt7w2LqdQuxyV1FndX4elgX7bflevcIGuA6pzbm8.', NULL, '2026-04-20 01:08:01', '2026-04-20 02:54:01', 3, NULL, 0, 'active', '2026-04-20 02:54:01', NULL),
(39, 'EMP002', 'Shakti Kapoor', 'shaktidd375@gmail.com', NULL, '$2y$12$pkaz2sccZ6y3mz9TfcucOuW4/lzXarPUEdlmTwwn5j.p7fHnuLvjK', NULL, '2026-04-20 00:32:32', '2026-04-20 01:35:57', 2, 27, 0, 'active', NULL, 'employees/nX4PgogCcleVAQaayhrbhXqwOrbG7aphHYAdxwVd.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
