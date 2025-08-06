-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Aug 06, 2025 at 02:43 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_filament`
--

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint UNSIGNED NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci,
  `new_values` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(1023) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `id` bigint UNSIGNED NOT NULL,
  `trademark_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`id`, `trademark_name`, `model_name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Vestax', '500', 'Sint aut magni.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(2, 'Technics', 'M-1000', 'Beatae voluptatum ut.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(3, 'Technics', 'G-120', 'Architecto eos placeat.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(4, 'Technics', 'M-1000', 'Reprehenderit numquam fugit magnam.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(5, 'Vestax', '500', 'Reprehenderit vitae porro quod.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(6, 'Numark', 'M-1000', 'Atque odit quia nisi.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(7, 'Technics', 'G-120', 'Perspiciatis et sunt.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(8, 'Vestax', 'SL-1200', 'Eos et.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(9, 'Vestax', 'SL-1200', 'Nisi ut nihil.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(10, 'Technics', 'SL-1200', 'Aliquid dolore molestiae.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(11, 'Technics', 'G-120', 'Rerum tenetur esse perferendis ipsa.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(12, 'Technics', 'G-120', 'A dolor voluptas quia.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(13, 'Pioneer', 'M-1000', 'Quia expedita et.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(14, 'Technics', '500', 'Sint sit mollitia consequatur.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(15, 'Pioneer', '500', 'Commodi aut non quod.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(16, 'Technics', 'SL-1200', 'Doloribus doloremque iure.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(17, 'Pioneer', '500', 'Est eaque sit repellat.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(18, 'Technics', 'G-120', 'Et aut tempore.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(19, 'Technics', 'M-1000', 'Quasi corrupti sed et.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(20, 'Numark', 'M-1000', 'Porro ex.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(21, 'Technics', '500', 'Fugiat nam.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(22, 'Numark', '500', 'Ipsam harum voluptate.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(23, 'Vestax', 'M-1000', 'Ipsam quidem expedita excepturi voluptatem.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(24, 'Technics', 'SL-1200', 'Et dolorum.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(25, 'Technics', 'G-120', 'Vel qui pariatur dolorem.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(26, 'Pioneer', 'G-120', 'Rem aut distinctio inventore.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(27, 'Pioneer', 'G-120', 'Laudantium velit illo voluptatum.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(28, 'Pioneer', 'SL-1200', 'Non in veritatis ut.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(29, 'Technics', 'M-1000', 'Velit dolores enim.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(30, 'Pioneer', 'M-1000', 'Ut praesentium et itaque.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(31, 'Technics', 'G-120', 'Officiis nemo.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(32, 'Numark', 'SL-1200', 'Est rem omnis est.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(33, 'Vestax', 'M-1000', 'Numquam tempore blanditiis harum ratione.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(34, 'Numark', 'SL-1200', 'Sint possimus molestiae.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(35, 'Vestax', 'SL-1200', 'Hic soluta repellat.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(36, 'Pioneer', '500', 'Necessitatibus ipsa at.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(37, 'Vestax', '500', 'Perferendis vel est debitis.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(38, 'Numark', 'G-120', 'Excepturi ea odit animi.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(39, 'Technics', 'G-120', 'Qui atque beatae et.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(40, 'Numark', 'G-120', 'Reiciendis sed ullam error.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(41, 'Pioneer', 'SL-1200', 'Dolores esse est.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(42, 'Numark', '500', 'Id sapiente nostrum.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(43, 'Numark', '500', 'Accusantium minima magni nesciunt.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(44, 'Numark', 'M-1000', 'Quibusdam eius at.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(45, 'Pioneer', 'SL-1200', 'Quia debitis qui.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(46, 'Pioneer', 'G-120', 'Nostrum maxime ut harum.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(47, 'Vestax', '500', 'Occaecati perferendis numquam voluptatem.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(48, 'Numark', 'SL-1200', 'Quam dolorem voluptatem autem.', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(49, 'Numark', '500', 'Commodi consectetur omnis qui.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(50, 'Technics', 'SL-1200', 'Nostrum aperiam aperiam id blanditiis.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(51, 'Pioneer', 'G-120', 'Natus reiciendis et sed.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(52, 'Vestax', 'SL-1200', 'Ullam dolorem.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(53, 'Vestax', 'SL-1200', 'Delectus id minus et.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(54, 'Numark', 'M-1000', 'Et aut vel maxime.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(55, 'Numark', 'M-1000', 'Deleniti commodi aut qui.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(56, 'Pioneer', '500', 'Expedita vel nobis.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(57, 'Vestax', '500', 'Numquam est quidem hic.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(58, 'Vestax', 'M-1000', 'Ratione quis culpa.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(59, 'Technics', 'M-1000', 'Aut omnis blanditiis.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(60, 'Technics', '500', 'Enim aperiam consequatur.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(61, 'Technics', 'M-1000', 'Ea saepe aut itaque enim.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(62, 'Numark', 'M-1000', 'Nam et.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(63, 'Numark', 'M-1000', 'Et sequi in modi.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(64, 'Pioneer', 'M-1000', 'Quae consectetur cum.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(65, 'Pioneer', 'SL-1200', 'Soluta error quo.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(66, 'Pioneer', 'SL-1200', 'Vel consequuntur eius optio.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(67, 'Vestax', 'SL-1200', 'Quibusdam et culpa doloremque.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(68, 'Pioneer', 'G-120', 'Cupiditate consequuntur voluptatem consequatur.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(69, 'Numark', '500', 'Fugit sunt et ut.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(70, 'Technics', 'SL-1200', 'Omnis cumque magni.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(71, 'Pioneer', 'M-1000', 'Quam iste fugiat aut.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(72, 'Vestax', 'G-120', 'Maxime illum aut nihil aliquam.', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `equipment_venue`
--

CREATE TABLE `equipment_venue` (
  `equipment_id` bigint UNSIGNED NOT NULL,
  `venue_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipment_venue`
--

INSERT INTO `equipment_venue` (`equipment_id`, `venue_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 1, NULL, NULL),
(3, 1, NULL, NULL),
(4, 2, NULL, NULL),
(5, 2, NULL, NULL),
(6, 2, NULL, NULL),
(7, 3, NULL, NULL),
(8, 3, NULL, NULL),
(9, 3, NULL, NULL),
(10, 4, NULL, NULL),
(11, 4, NULL, NULL),
(12, 4, NULL, NULL),
(13, 5, NULL, NULL),
(14, 5, NULL, NULL),
(15, 5, NULL, NULL),
(16, 6, NULL, NULL),
(17, 6, NULL, NULL),
(18, 6, NULL, NULL),
(19, 7, NULL, NULL),
(20, 7, NULL, NULL),
(21, 7, NULL, NULL),
(22, 8, NULL, NULL),
(23, 8, NULL, NULL),
(24, 8, NULL, NULL),
(25, 9, NULL, NULL),
(26, 9, NULL, NULL),
(27, 9, NULL, NULL),
(28, 10, NULL, NULL),
(29, 10, NULL, NULL),
(30, 10, NULL, NULL),
(31, 11, NULL, NULL),
(32, 11, NULL, NULL),
(33, 11, NULL, NULL),
(34, 12, NULL, NULL),
(35, 12, NULL, NULL),
(36, 12, NULL, NULL),
(37, 13, NULL, NULL),
(38, 13, NULL, NULL),
(39, 13, NULL, NULL),
(40, 14, NULL, NULL),
(41, 14, NULL, NULL),
(42, 14, NULL, NULL),
(43, 15, NULL, NULL),
(44, 15, NULL, NULL),
(45, 15, NULL, NULL),
(46, 16, NULL, NULL),
(47, 16, NULL, NULL),
(48, 16, NULL, NULL),
(49, 17, NULL, NULL),
(50, 17, NULL, NULL),
(51, 17, NULL, NULL),
(52, 18, NULL, NULL),
(53, 18, NULL, NULL),
(54, 18, NULL, NULL),
(55, 19, NULL, NULL),
(56, 19, NULL, NULL),
(57, 19, NULL, NULL),
(58, 20, NULL, NULL),
(59, 20, NULL, NULL),
(60, 20, NULL, NULL),
(61, 21, NULL, NULL),
(62, 21, NULL, NULL),
(63, 21, NULL, NULL),
(64, 22, NULL, NULL),
(65, 22, NULL, NULL),
(66, 22, NULL, NULL),
(67, 23, NULL, NULL),
(68, 23, NULL, NULL),
(69, 23, NULL, NULL),
(70, 24, NULL, NULL),
(71, 24, NULL, NULL),
(72, 24, NULL, NULL);

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_20_135953_create_owners_table', 1),
(5, '2025_06_20_140022_create_venues_table', 1),
(6, '2025_06_20_140044_create_equipment_table', 1),
(7, '2025_06_20_140127_create_equipment_venue_table', 1),
(8, '2025_06_20_140244_add_column_options_to_owners_table', 1),
(9, '2025_06_20_140320_add_location_to_venues_table', 1),
(10, '2025_06_23_161855_create_permission_tables', 1),
(11, '2025_06_28_112729_add_image_to_owners_table', 1),
(12, '2025_06_28_131136_create_personal_access_tokens_table', 1),
(13, '2025_07_02_114605_create_audits_table', 1),
(14, '2025_07_02_132132_add_description_and_status_to_users_table', 1),
(15, '2025_07_12_130133_create_notifications_table', 1),
(16, '2025_07_30_170410_add_cashier_columns_to_users_table', 1),
(17, '2025_08_04_134619_create_products_table', 1),
(18, '2025_08_04_162022_create_orders_table', 1),
(19, '2025_08_04_162306_create_order_items_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `stripe_session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '1',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`id`, `first_name`, `last_name`, `email`, `image`, `phone`, `confirmed`, `location`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Roberto', 'Krajcik', 'qkuvalis@example.org', 'https://picsum.photos/400/300?random=8593', '+38002258090', 1, 'EUU', NULL, '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(2, 'Lula', 'Goodwin', 'reed.harris@example.com', 'https://picsum.photos/400/300?random=6554', '+38023415596', 0, 'EUU', NULL, '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(3, 'Janae', 'Lindgren', 'jamie.crooks@example.org', 'https://picsum.photos/400/300?random=6260', '+38036497263', 1, 'UAA', NULL, '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(4, 'Hazel', 'D\'Amore', 'labadie.trever@example.org', 'https://picsum.photos/400/300?random=758', '+38019154500', 0, 'UAA', NULL, '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(5, 'Lilla', 'Steuber', 'quincy.wolf@example.net', 'https://picsum.photos/400/300?random=4193', '+38012817581', 1, 'EUU', NULL, '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(6, 'Mario', 'Grant', 'rhaag@example.com', 'https://picsum.photos/400/300?random=723', '+38082193972', 0, 'EUU', NULL, '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(7, 'Laverna', 'Upton', 'annabel.littel@example.org', 'https://picsum.photos/400/300?random=9571', '+38051044335', 1, 'EUU', NULL, '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(8, 'Terence', 'O\'Conner', 'mwindler@example.org', 'https://picsum.photos/400/300?random=3222', '+38051985183', 0, 'EUU', NULL, '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(9, 'Cleveland', 'Douglas', 'felton.stehr@example.net', 'https://picsum.photos/400/300?random=1295', '+38088585104', 1, 'EUU', NULL, '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(10, 'Abigayle', 'Dickens', 'hswift@example.com', 'https://picsum.photos/400/300?random=1167', '+38041774297', 0, 'UAA', NULL, '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(11, 'Leon', 'Heller', 'makenna34@example.org', 'https://picsum.photos/400/300?random=9353', '+38092222835', 1, 'EUU', NULL, '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(12, 'Nico', 'Hand', 'lrunolfsdottir@example.org', 'https://picsum.photos/400/300?random=3246', '+38079934921', 0, 'EUU', NULL, '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view owner', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(2, 'view owners', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(3, 'edit owners', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(4, 'delete owners', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(5, 'view venue ', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(6, 'view venues', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(7, 'edit venue', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(8, 'delete venue', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(9, 'view roles', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(10, 'view audits', 'web', '2025-08-06 14:41:44', '2025-08-06 14:41:44'),
(11, 'view owner admin quantity', 'api', '2025-08-06 14:41:45', '2025-08-06 14:41:45'),
(12, 'not admin permission', 'web', '2025-08-06 14:41:45', '2025-08-06 14:41:45');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `stock` int UNSIGNED NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `views` int UNSIGNED NOT NULL DEFAULT '0',
  `details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `sku`, `price`, `discount_price`, `stock`, `image`, `gallery`, `is_active`, `views`, `details`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Serato', 'sint-velit-excepturi', 'Fugit accusamus beatae neque error quas ut dignissimos rerum in rerum velit eos distinctio unde quia ut dolores nobis expedita adipisci.', 'SKU-8854NE', 285.06, NULL, 33, 'https://picsum.photos/200/150?random=3034', '[\"https://via.placeholder.com/640x480.png/00ddcc?text=products+similique\", \"https://via.placeholder.com/640x480.png/009977?text=products+eos\"]', 1, 684, '{\"color\": \"Orange\", \"material\": \"aut\", \"warranty\": \"2 years\"}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(2, 'Pioneer DJ', 'consequuntur-enim-doloribus', 'Ut veniam ut modi exercitationem cum aut et sunt odit aliquam minus voluptate tempore provident qui temporibus.', 'SKU-8277WH', 271.34, 154.43, 97, 'https://picsum.photos/200/150?random=8997', '[\"https://via.placeholder.com/640x480.png/0077dd?text=products+qui\", \"https://via.placeholder.com/640x480.png/0088dd?text=products+sint\"]', 1, 814, '{\"color\": \"Cyan\", \"material\": \"nobis\", \"warranty\": \"4 years\"}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(3, 'Gemini', 'dolorem-adipisci-non', 'Laborum hic repellat eius repudiandae eos eaque voluptates non quam dignissimos a non.', 'SKU-6955AH', 481.56, 216.21, 90, 'https://picsum.photos/200/150?random=5119', '[\"https://via.placeholder.com/640x480.png/00aa22?text=products+quia\", \"https://via.placeholder.com/640x480.png/004433?text=products+cupiditate\"]', 1, 405, '{\"color\": \"GoldenRod\", \"material\": \"consequatur\", \"warranty\": \"1 years\"}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(4, 'Audio-Technica', 'ab-labore-temporibus', 'Dolores cum aliquam eum vitae voluptas sint quos voluptate nemo itaque aperiam ullam error aut.', 'SKU-1005UW', 226.09, 99.28, 42, 'https://picsum.photos/200/150?random=5776', '[\"https://via.placeholder.com/640x480.png/0033bb?text=products+omnis\", \"https://via.placeholder.com/640x480.png/0022bb?text=products+ut\"]', 1, 434, '{\"color\": \"Darkorange\", \"material\": \"qui\", \"warranty\": \"1 years\"}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(5, 'Gemini', 'mollitia-id-consectetur', 'Velit occaecati est aliquid placeat veritatis error cupiditate asperiores enim dolores consequatur ut ea labore ratione ut accusamus.', 'SKU-2499NR', 191.26, 138.03, 91, 'https://picsum.photos/200/150?random=3735', '[\"https://via.placeholder.com/640x480.png/00cc99?text=products+eligendi\", \"https://via.placeholder.com/640x480.png/00aa55?text=products+nihil\"]', 1, 692, '{\"color\": \"DodgerBlue\", \"material\": \"maiores\", \"warranty\": \"3 years\"}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(6, 'Rane', 'libero-temporibus-dicta', 'Ipsum alias deleniti dolores at quo et non ea ut eos.', 'SKU-4052WJ', 421.80, NULL, 99, 'https://picsum.photos/200/150?random=4206', '[\"https://via.placeholder.com/640x480.png/0055dd?text=products+incidunt\", \"https://via.placeholder.com/640x480.png/00dd11?text=products+expedita\"]', 1, 755, '{\"color\": \"Peru\", \"material\": \"neque\", \"warranty\": \"4 years\"}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(7, 'Soundcraft', 'molestiae-autem-et', 'Rem ratione est praesentium recusandae sit delectus id sed quia dicta aut qui explicabo dicta sunt autem qui quis totam qui.', 'SKU-0221EG', 498.43, 276.97, 53, 'https://picsum.photos/200/150?random=6331', '[\"https://via.placeholder.com/640x480.png/00ddcc?text=products+hic\", \"https://via.placeholder.com/640x480.png/00bb66?text=products+ducimus\"]', 1, 998, '{\"color\": \"OliveDrab\", \"material\": \"rerum\", \"warranty\": \"5 years\"}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(8, 'Technics', 'sint-illo-aliquid', 'Sed quo consequatur fuga quo voluptatibus fuga ratione voluptatibus placeat dolorem repellat aperiam vero eos vitae.', 'SKU-0147YV', 39.60, NULL, 34, 'https://picsum.photos/200/150?random=4119', '[\"https://via.placeholder.com/640x480.png/008877?text=products+itaque\", \"https://via.placeholder.com/640x480.png/00bb33?text=products+culpa\"]', 1, 459, '{\"color\": \"Silver\", \"material\": \"distinctio\", \"warranty\": \"3 years\"}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-08-06 14:41:45', '2025-08-06 14:41:45'),
(2, 'user', 'web', '2025-08-06 14:41:45', '2025-08-06 14:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
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
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(1, 2),
(2, 2),
(5, 2),
(6, 2),
(10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `description`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`) VALUES
(1, 'Dima', 'dima@gmail.com', NULL, '2025-08-06 14:41:43', '$2y$12$jz0D2X1RKjmCEgUNrNCdI.5XgOCc/mHsSA./TAassB9J8l2WAsLEy', 1, 'tHwtGRLpB5', '2025-08-06 14:41:44', '2025-08-06 14:41:44', NULL, NULL, NULL, NULL),
(2, 'Olya', 'olya@gmail.com', NULL, '2025-08-06 14:41:44', '$2y$12$q.x/fLAbxP1rFYyRm9zuBe3pAoYTnaIEpCaAn0wQmmY86kTG0jfjK', 1, 'jqTJaMaz7p', '2025-08-06 14:41:44', '2025-08-06 14:41:44', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` bigint UNSIGNED NOT NULL,
  `venue_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `owner_id` bigint UNSIGNED DEFAULT NULL,
  `location` json DEFAULT NULL COMMENT 'lon, lng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `venue_name`, `address`, `active`, `owner_id`, `location`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Gibson-Hane', '59817 Harvey Lock Suite 815\nSouth Queenie, TN 05938', 1, 1, '{\"lat\": 39.371289, \"lng\": 2.775132}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(2, 'Gutkowski-Ankunding', '16663 Caleb Springs Suite 405\nMuellerland, WA 04042', 1, 1, '{\"lat\": 39.398501, \"lng\": 2.350086}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(3, 'Beahan PLC', '19746 Kling Mountains\nProhaskachester, MO 14951-6541', 1, 2, '{\"lat\": 39.837059, \"lng\": 2.363053}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(4, 'Schumm Group', '8106 Price Lodge Suite 181\nEast Kayleigh, MA 45558-6502', 1, 2, '{\"lat\": 39.358569, \"lng\": 3.024706}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(5, 'Jast Inc', '3423 Graham Falls Apt. 612\nLake Shakiraport, MN 91375-7208', 1, 3, '{\"lat\": 39.327105, \"lng\": 2.911623}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(6, 'Bins, Balistreri and Wolff', '63681 Price Oval\nKilbackville, DC 54580', 1, 3, '{\"lat\": 39.296581, \"lng\": 2.660038}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(7, 'Swaniawski Group', '8793 Candida Meadow\nNorth Dantehaven, AK 12568-8400', 1, 4, '{\"lat\": 39.303619, \"lng\": 3.1648}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(8, 'Crona, Ratke and Kovacek', '75975 Reinger Meadows\nNew Tessside, CT 81662', 1, 4, '{\"lat\": 39.284815, \"lng\": 2.542627}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(9, 'Smitham Group', '39268 Gonzalo Road\nAmieview, WA 14557', 1, 5, '{\"lat\": 39.201721, \"lng\": 3.417}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(10, 'Schoen, DuBuque and Macejkovic', '3453 Gerard Meadow\nLueside, PA 30180-3100', 1, 5, '{\"lat\": 39.357913, \"lng\": 3.249857}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(11, 'Fisher PLC', '267 Ebert Pine\nKuhnburgh, DC 32168', 1, 6, '{\"lat\": 39.446202, \"lng\": 2.440521}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(12, 'Nitzsche, Daniel and Zemlak', '6120 Wade Avenue\nAbdulfort, MI 19526', 1, 6, '{\"lat\": 39.744619, \"lng\": 2.80022}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(13, 'Blanda-Streich', '6724 Kuvalis Dam Apt. 528\nAnnabury, MD 26440', 1, 7, '{\"lat\": 39.695218, \"lng\": 3.306341}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(14, 'Hartmann-Von', '58512 Carlie Squares Apt. 578\nSouth Rachael, ND 00393', 1, 7, '{\"lat\": 39.788972, \"lng\": 3.443268}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(15, 'Mayer, West and Klein', '5647 Wisoky Mountain Suite 403\nNorth Loyce, MN 10543-6324', 1, 8, '{\"lat\": 39.838962, \"lng\": 3.457411}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(16, 'Dibbert, Stracke and Kuhlman', '547 Arne Plain\nNameland, MS 44177', 1, 8, '{\"lat\": 39.331301, \"lng\": 2.532184}', '2025-08-06 14:41:45', '2025-08-06 14:41:45', NULL),
(17, 'Goodwin, Dach and Wintheiser', '703 Hershel Summit Suite 525\nTorphyville, WY 21886', 1, 9, '{\"lat\": 39.854629, \"lng\": 2.853456}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(18, 'Macejkovic, Lehner and Doyle', '5353 Hayes Circle Apt. 166\nTaureanview, IA 23111', 1, 9, '{\"lat\": 39.578715, \"lng\": 2.50753}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(19, 'Bergstrom Inc', '49694 Koss Centers Suite 721\nNorth Rebeca, GA 47499-5827', 1, 10, '{\"lat\": 39.763949, \"lng\": 2.639677}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(20, 'Kertzmann, Leannon and Reinger', '9617 Gregg Gardens Suite 546\nWest Tyrel, LA 19253-9677', 1, 10, '{\"lat\": 39.367264, \"lng\": 3.272623}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(21, 'Corkery Inc', '5905 Scarlett Freeway Apt. 088\nWolfffurt, WA 74406-5553', 1, 11, '{\"lat\": 39.407535, \"lng\": 2.658555}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(22, 'Kessler Inc', '35371 Kreiger Prairie\nNorth Amalia, MO 12443-4349', 1, 11, '{\"lat\": 39.570503, \"lng\": 2.77317}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(23, 'Feest, Labadie and Beer', '3148 Art Estates Apt. 713\nBodefurt, VA 67214', 1, 12, '{\"lat\": 39.400426, \"lng\": 2.844781}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL),
(24, 'Deckow, Goldner and Witting', '544 Mosciski Glens Suite 556\nCormierbury, IN 26352', 1, 12, '{\"lat\": 39.925103, \"lng\": 2.802891}', '2025-08-06 14:41:46', '2025-08-06 14:41:46', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`);

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
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment_venue`
--
ALTER TABLE `equipment_venue`
  ADD PRIMARY KEY (`equipment_id`,`venue_id`),
  ADD KEY `equipment_venue_venue_id_foreign` (`venue_id`),
  ADD KEY `equipment_venue_equipment_id_index` (`equipment_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_stripe_session_id_unique` (`stripe_session_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_stripe_id_index` (`stripe_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venues_owner_id_index` (`owner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment_venue`
--
ALTER TABLE `equipment_venue`
  ADD CONSTRAINT `equipment_venue_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipment_venue_venue_id_foreign` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `venues`
--
ALTER TABLE `venues`
  ADD CONSTRAINT `venues_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
