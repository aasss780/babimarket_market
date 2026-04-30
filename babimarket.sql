-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 30, 2026 at 03:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `babimarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 10, '2026-04-29 11:19:21', '2026-04-29 11:19:21'),
(2, 12, '2026-04-29 11:43:00', '2026-04-29 11:43:00'),
(3, 14, '2026-04-29 12:40:50', '2026-04-29 12:40:50'),
(101, 101, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 102, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 103, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(104, 104, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 105, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 106, '2026-04-29 17:53:35', '2026-04-29 17:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(3, 2, 13, 1, '2026-04-29 11:43:00', '2026-04-29 11:43:00'),
(101, 101, 101, 1, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 101, 103, 2, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 102, 110, 1, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(104, 103, 114, 1, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 104, 116, 2, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 105, 120, 1, '2026-04-29 17:53:35', '2026-04-29 17:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Baby Clothing', NULL, '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(2, 'Toys & Games', NULL, '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(3, 'Feeding', NULL, '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(4, 'Nursery', NULL, '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(5, 'Health & Safety', NULL, '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(6, 'Strollers', NULL, '2026-04-29 11:02:43', '2026-04-29 11:02:43');

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
  `attempts` smallint(5) UNSIGNED NOT NULL,
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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `product_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 14, 11, 15, 'hello how are you', 1, '2026-04-29 12:42:00', '2026-04-29 12:52:06'),
(2, 14, 11, 15, 'my name abed saadi', 1, '2026-04-29 12:42:12', '2026-04-29 12:52:06'),
(3, 11, 14, 15, 'hi abed', 1, '2026-04-29 12:44:28', '2026-04-29 13:01:43'),
(4, 14, 7, 1, 'hii', 0, '2026-04-29 13:22:59', '2026-04-29 13:22:59'),
(5, 14, 11, 16, 'hello', 0, '2026-04-29 13:31:07', '2026-04-29 13:31:07'),
(6, 14, 13, 14, 'gii', 1, '2026-04-29 13:32:51', '2026-04-29 13:33:12'),
(7, 13, 14, 14, 'hii', 1, '2026-04-29 13:33:16', '2026-04-29 13:33:49'),
(8, 14, 1, NULL, 'hello my name abed saadi', 1, '2026-04-29 13:42:16', '2026-04-29 13:55:05'),
(9, 14, 1, NULL, 'hello', 1, '2026-04-29 13:42:35', '2026-04-29 13:55:05'),
(101, 101, 107, 101, 'Hello, is this cotton set available in size 3-6 months?', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 107, 101, 101, 'Yes, it is available. You can order it today.', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 102, 108, 110, 'Can this stroller fold easily?', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(104, 108, 102, 110, 'Yes, it is compact and easy to fold.', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 103, 109, 114, 'Is the thermometer suitable for newborns?', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 104, 107, 102, 'Do you have another color for this hoodie?', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(107, 105, 110, 119, 'Is this onesie organic cotton?', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(108, 106, 110, 120, 'Does this toy need batteries?', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35');

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
(4, '2026_04_29_124745_create_categories_table', 1),
(5, '2026_04_29_124745_create_product_images_table', 1),
(6, '2026_04_29_124745_create_products_table', 1),
(7, '2026_04_29_124746_create_cart_items_table', 1),
(8, '2026_04_29_124746_create_carts_table', 1),
(9, '2026_04_29_124747_create_order_items_table', 1),
(10, '2026_04_29_124747_create_orders_table', 1),
(11, '2026_04_29_124748_create_messages_table', 1),
(12, '2026_04_29_124748_create_wishlists_table', 1),
(13, '2026_04_29_124749_create_notifications_table', 1),
(14, '2026_04_29_124749_create_reviews_table', 1),
(15, '2026_04_29_130500_add_missing_foreign_keys', 1),
(16, '2026_04_29_180000_create_withdrawals_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 11, 'New order received', 'A customer ordered abed', 'order', 1, '2026-04-29 11:39:33', '2026-04-29 12:52:13'),
(2, 10, 'Order status updated', 'Your order #1 is now processing.', 'order', 0, '2026-04-29 11:59:07', '2026-04-29 11:59:07'),
(3, 10, 'Order status updated', 'Your order #1 is now processing.', 'order', 0, '2026-04-29 11:59:11', '2026-04-29 11:59:11'),
(4, 10, 'Order status updated', 'Your order #1 is now processing.', 'order', 0, '2026-04-29 11:59:12', '2026-04-29 11:59:12'),
(5, 11, 'New order received', 'A customer ordered abed', 'order', 1, '2026-04-29 12:41:17', '2026-04-29 12:52:13'),
(6, 11, 'New message', 'You received a new message.', 'message', 1, '2026-04-29 12:42:00', '2026-04-29 12:52:13'),
(7, 11, 'New message', 'You received a new message.', 'message', 1, '2026-04-29 12:42:12', '2026-04-29 12:52:13'),
(8, 14, 'New message', 'You received a new message.', 'message', 1, '2026-04-29 12:44:28', '2026-04-29 13:00:01'),
(9, 14, 'Order status updated', 'Your order #2 is now processing.', 'order', 1, '2026-04-29 12:45:24', '2026-04-29 13:00:01'),
(10, 7, 'New message', 'You received a new message.', 'message', 0, '2026-04-29 13:22:59', '2026-04-29 13:22:59'),
(11, 11, 'New message', 'You received a new message.', 'message', 0, '2026-04-29 13:31:07', '2026-04-29 13:31:07'),
(12, 13, 'New message', 'You received a new message.', 'message', 1, '2026-04-29 13:32:51', '2026-04-29 13:33:07'),
(13, 14, 'New message', 'You received a new message.', 'message', 1, '2026-04-29 13:33:16', '2026-04-29 13:34:12'),
(14, 1, 'New message', 'You received a new message.', 'message', 1, '2026-04-29 13:42:16', '2026-04-29 13:55:10'),
(15, 1, 'New message', 'You received a new message.', 'message', 1, '2026-04-29 13:42:35', '2026-04-29 13:55:10'),
(17, 14, 'Order status updated', 'Your order #3 is now processing.', 'order', 1, '2026-04-29 14:20:14', '2026-04-29 14:43:56'),
(19, 14, 'Order status updated', 'Your order #4 is now processing.', 'order', 1, '2026-04-29 14:29:55', '2026-04-29 14:43:56'),
(20, 13, 'New order received', 'A customer ordered sda', 'order', 0, '2026-04-29 14:45:19', '2026-04-29 14:45:19'),
(21, 14, 'Order status updated', 'Your order #5 is now processing.', 'order', 1, '2026-04-29 14:45:41', '2026-04-30 01:10:31'),
(101, 107, 'New message', 'You received a new product message.', 'message', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 101, 'New reply', 'Seller replied to your message.', 'message', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 108, 'New order received', 'A customer ordered Lightweight Baby Stroller.', 'order', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(104, 109, 'New order received', 'A customer ordered Digital Baby Thermometer.', 'order', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 110, 'New order received', 'A customer ordered Organic Cotton Onesie.', 'order', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 102, 'Order status updated', 'Your order is waiting for seller approval.', 'order', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(107, 103, 'Order status updated', 'Your order is now processing.', 'order', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(108, 1, 'New contact message', 'A customer sent a new admin contact message.', 'message', 0, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(200, 107, 'New order received', 'A customer ordered Colorful Baby Rattle', 'order', 0, '2026-04-29 15:08:03', '2026-04-29 15:08:03'),
(201, 13, 'New order received', 'A customer ordered omar GH', 'order', 0, '2026-04-30 01:10:23', '2026-04-30 01:10:23'),
(202, 14, 'Order status updated', 'Your order #201 is now processing.', 'order', 0, '2026-04-30 01:11:26', '2026-04-30 01:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `payment_method`, `shipping_name`, `shipping_phone`, `shipping_address`, `notes`, `created_at`, `updated_at`) VALUES
(1, 10, 1200.00, 'processing', 'card', 'abed', 'اهاهه', 'اعاهخاهخلخهعل', NULL, '2026-04-29 11:39:33', '2026-04-29 11:59:07'),
(2, 14, 1200.00, 'processing', 'credit_card', 'abed', 'اهاهه', 'abed - abed', NULL, '2026-04-29 12:41:17', '2026-04-29 12:45:24'),
(3, 14, 1200.00, 'processing', 'cash_on_delivery', 'abed', 'wqw', 'wqwwqw - wqwqw', NULL, '2026-04-29 14:19:48', '2026-04-29 14:20:14'),
(4, 14, 1500.00, 'processing', 'cash_on_delivery', 'abed', '212', '1212212 - 2121', NULL, '2026-04-29 14:29:34', '2026-04-29 14:29:55'),
(5, 14, 1200.00, 'processing', 'cash_on_delivery', 'abed', 'sas', 'sas - sas', NULL, '2026-04-29 14:45:19', '2026-04-29 14:45:41'),
(101, 101, 33.00, 'processing', 'cash_on_delivery', 'Maya Haddad', '70111222', 'Beirut - Hamra Street', 'Please call before delivery.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 102, 120.00, 'pending', 'credit_card', 'Karim Nasser', '71122334', 'Tripoli - Mina Area', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 103, 25.00, 'processing', 'paypal', 'Sara Mansour', '76123456', 'Saida - Downtown', 'Deliver after 5 PM.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(104, 104, 18.00, 'pending', 'cash_on_delivery', 'Omar Khaled', '03111999', 'Zahle - Main Road', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 105, 39.00, 'processing', 'cash_on_delivery', 'Lina Farhat', '70199887', 'Jounieh - Near old souk', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 106, 24.00, 'pending', 'paypal', 'Hadi Daher', '81222333', 'Tyre - Sea Road', 'Small package please.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(200, 14, 7.50, 'pending', 'cash_on_delivery', 'abed', '212', 'sass - sas', NULL, '2026-04-29 15:08:03', '2026-04-29 15:08:03'),
(201, 14, 1200.00, 'processing', 'cash_on_delivery', 'abed', 'ewe', 'eq - eqeq', NULL, '2026-04-30 01:10:23', '2026-04-30 01:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `seller_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 11, 1, 1200.00, '2026-04-29 11:39:33', '2026-04-29 11:39:33'),
(2, 2, 15, 11, 1, 1200.00, '2026-04-29 12:41:17', '2026-04-29 12:41:17'),
(5, 5, 20, 13, 1, 1200.00, '2026-04-29 14:45:19', '2026-04-29 14:45:19'),
(101, 101, 101, 107, 1, 18.00, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 101, 104, 107, 2, 6.00, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 102, 110, 108, 1, 120.00, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(104, 103, 114, 109, 1, 12.00, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 103, 113, 109, 1, 13.00, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 104, 102, 107, 1, 22.00, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(107, 105, 119, 110, 1, 15.00, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(108, 105, 120, 110, 1, 24.00, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(109, 106, 120, 110, 1, 24.00, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(200, 200, 103, 107, 1, 7.50, '2026-04-29 15:08:03', '2026-04-29 15:08:03');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','pending','rejected') NOT NULL DEFAULT 'pending',
  `main_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `category_id`, `name`, `description`, `price`, `old_price`, `stock`, `status`, `main_image`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 'Sample Baby Product 1', 'Safe and quality baby item for marketplace demo.', 116.00, 180.00, 36, 'active', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(2, 7, 1, 'Sample Baby Product 2', 'Safe and quality baby item for marketplace demo.', 17.00, 176.00, 29, 'active', 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(3, 7, 1, 'Sample Baby Product 3', 'Safe and quality baby item for marketplace demo.', 67.00, 160.00, 23, 'active', 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(4, 7, 1, 'Sample Baby Product 4', 'Safe and quality baby item for marketplace demo.', 60.00, 124.00, 39, 'active', 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(5, 7, 1, 'Sample Baby Product 5', 'Safe and quality baby item for marketplace demo.', 20.00, 169.00, 9, 'active', 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(6, 7, 1, 'Sample Baby Product 6', 'Safe and quality baby item for marketplace demo.', 68.00, 165.00, 33, 'active', 'https://images.unsplash.com/photo-1546015720-b8b30df5aa27?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(7, 7, 1, 'Sample Baby Product 7', 'Safe and quality baby item for marketplace demo.', 63.00, 134.00, 26, 'active', 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(8, 7, 1, 'Sample Baby Product 8', 'Safe and quality baby item for marketplace demo.', 77.00, 172.00, 48, 'active', 'https://images.unsplash.com/photo-1519689680058-324335c77eba?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(9, 7, 1, 'Sample Baby Product 9', 'Safe and quality baby item for marketplace demo.', 93.00, 177.00, 49, 'active', 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(10, 7, 1, 'Sample Baby Product 10', 'Safe and quality baby item for marketplace demo.', 65.00, 160.00, 9, 'active', 'https://images.unsplash.com/photo-1522771930-78848d9293e8?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(11, 7, 1, 'Sample Baby Product 11', 'Safe and quality baby item for marketplace demo.', 87.00, 162.00, 43, 'active', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(12, 7, 1, 'Sample Baby Product 12', 'Safe and quality baby item for marketplace demo.', 71.00, 166.00, 35, 'active', 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(13, 11, 1, 'abed', 'شلاص', 1200.00, NULL, 3, 'active', 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=900&auto=format&fit=crop', '2026-04-29 11:37:52', '2026-04-29 11:37:52'),
(14, 13, 2, 'abed', 'abed', 1200.00, NULL, 2, 'active', 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=900&auto=format&fit=crop', '2026-04-29 12:29:59', '2026-04-29 12:29:59'),
(15, 11, 1, 'abed', 'abed saadi', 1200.00, 1500.00, 22, 'active', 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?q=80&w=900&auto=format&fit=crop', '2026-04-29 12:39:18', '2026-04-29 12:39:18'),
(16, 11, 1, 'abed', 'سش', 11.00, 1.00, 1, 'active', 'https://images.unsplash.com/photo-1546015720-b8b30df5aa27?q=80&w=900&auto=format&fit=crop', '2026-04-29 13:29:51', '2026-04-29 13:29:51'),
(20, 13, 1, 'sda', 'dasd1', 1200.00, 1000.00, 1, 'active', 'https://images.unsplash.com/photo-1522771930-78848d9293e8?q=80&w=900&auto=format&fit=crop', '2026-04-29 14:44:41', '2026-04-29 14:45:19'),
(101, 107, 1, 'Soft Cotton Baby Set', 'Comfortable cotton outfit for newborns, soft and easy to wash.', 18.00, 24.00, 12, 'active', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 107, 1, 'Winter Baby Hoodie', 'Warm hoodie for cold days with soft inner lining.', 22.00, 30.00, 8, 'active', 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 107, 2, 'Colorful Baby Rattle', 'Lightweight rattle toy with safe rounded edges.', 7.50, 10.00, 24, 'active', 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 15:08:03'),
(104, 107, 3, 'Silicone Feeding Spoon Set', 'Soft silicone spoons suitable for early feeding.', 6.00, NULL, 30, 'active', 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 107, 5, 'Baby Safety Corner Guards', 'Clear soft corner protectors for tables and furniture.', 9.00, 12.00, 20, 'active', 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 108, 1, 'Newborn Socks Pack', 'Pack of five soft newborn socks.', 5.00, 8.00, 40, 'active', 'https://images.unsplash.com/photo-1546015720-b8b30df5aa27?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(107, 108, 2, 'Soft Plush Teddy Bear', 'Cute plush teddy bear for babies and toddlers.', 14.00, 18.00, 15, 'active', 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(108, 108, 3, 'Baby Bottle 250ml', 'BPA-free feeding bottle with anti-colic nipple.', 11.00, 15.00, 18, 'active', 'https://images.unsplash.com/photo-1519689680058-324335c77eba?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(109, 108, 4, 'Nursery Night Light', 'Soft warm night light for baby rooms.', 19.00, 25.00, 10, 'active', 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(110, 108, 6, 'Lightweight Baby Stroller', 'Compact stroller for daily walks and travel.', 120.00, 150.00, 4, 'active', 'https://images.unsplash.com/photo-1522771930-78848d9293e8?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(111, 109, 4, 'Baby Blanket Premium', 'Soft premium blanket for newborn comfort.', 21.00, 28.00, 14, 'active', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(112, 109, 4, 'Crib Organizer Bag', 'Storage organizer for diapers, bottles, and wipes.', 16.00, 20.00, 9, 'active', 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(113, 109, 2, 'Wooden Stacking Toy', 'Educational toy for shape and color learning.', 13.00, 17.00, 11, 'active', 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(114, 109, 5, 'Digital Baby Thermometer', 'Fast reading thermometer for baby health checks.', 12.00, 16.00, 16, 'active', 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(115, 109, 6, 'Stroller Rain Cover', 'Transparent rain cover compatible with most strollers.', 10.00, NULL, 22, 'active', 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(116, 110, 3, 'Baby Bibs Pack', 'Set of three waterproof baby bibs.', 8.00, 12.00, 35, 'active', 'https://images.unsplash.com/photo-1546015720-b8b30df5aa27?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(117, 110, 3, 'Training Sippy Cup', 'Spill-proof cup for toddlers learning to drink.', 9.50, 13.00, 18, 'active', 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(118, 110, 5, 'Baby Nail Care Kit', 'Safe nail clippers and care tools for babies.', 7.00, 11.00, 23, 'active', 'https://images.unsplash.com/photo-1519689680058-324335c77eba?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(119, 110, 1, 'Organic Cotton Onesie', 'Breathable organic cotton onesie for daily use.', 15.00, 20.00, 12, 'active', 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(120, 110, 2, 'Musical Activity Cube', 'Interactive activity cube with sounds and shapes.', 24.00, 32.00, 7, 'active', 'https://images.unsplash.com/photo-1522771930-78848d9293e8?q=80&w=900&auto=format&fit=crop', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(200, 13, 2, 'liu', 'kk', 1200.00, 1000.00, 2, 'active', 'products/GRiIJLHtk48Y4uppkXrb9Tk8F0Q783ERIesnlhnT.png', '2026-04-29 15:08:47', '2026-04-29 15:10:04'),
(201, 13, 1, 'saadi1', 'asa', 1200.00, 1500.00, 2, 'active', 'products/kvuFLigsyQ9cNR4D0MzA2AaqEdK8ggbJdirfrx3R.png', '2026-04-29 15:15:55', '2026-04-29 15:15:55'),
(202, 13, 6, 'mis', 'juju', 1500.00, 7000.00, 2, 'active', 'products/Mc1tzRbHfP5lyl1GocTdQPf1uRCZuudp5FPIzW05.png', '2026-04-29 15:21:19', '2026-04-29 15:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(64, 1, 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(65, 2, 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(66, 3, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(67, 4, 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(68, 5, 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(69, 6, 'https://images.unsplash.com/photo-1546015720-b8b30df5aa27?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(70, 7, 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(71, 8, 'https://images.unsplash.com/photo-1519689680058-324335c77eba?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(72, 9, 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(73, 10, 'https://images.unsplash.com/photo-1522771930-78848d9293e8?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(74, 11, 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(75, 12, 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(76, 13, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(77, 14, 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(78, 15, 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(79, 16, 'https://images.unsplash.com/photo-1546015720-b8b30df5aa27?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(80, 20, 'https://images.unsplash.com/photo-1522771930-78848d9293e8?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(81, 101, 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(82, 102, 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(83, 103, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(84, 104, 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(85, 105, 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(86, 106, 'https://images.unsplash.com/photo-1546015720-b8b30df5aa27?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(87, 107, 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(88, 108, 'https://images.unsplash.com/photo-1519689680058-324335c77eba?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(89, 109, 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(90, 110, 'https://images.unsplash.com/photo-1522771930-78848d9293e8?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(91, 111, 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(92, 112, 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(93, 113, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(94, 114, 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(95, 115, 'https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(96, 116, 'https://images.unsplash.com/photo-1546015720-b8b30df5aa27?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(97, 117, 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(98, 118, 'https://images.unsplash.com/photo-1519689680058-324335c77eba?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(99, 119, 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04'),
(100, 120, 'https://images.unsplash.com/photo-1522771930-78848d9293e8?q=80&w=900&auto=format&fit=crop', '2026-04-29 18:07:04', '2026-04-29 18:07:04');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 10, 13, 5, 'ممتاز', '2026-04-29 11:39:11', '2026-04-29 11:39:11'),
(2, 14, 15, 5, 'wow', '2026-04-29 14:46:49', '2026-04-29 14:46:49'),
(101, 101, 107, 5, 'Very soft and nice quality.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 102, 101, 4, 'Good product and fast communication.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 103, 114, 5, 'Useful and easy to use.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(104, 104, 108, 4, 'Bottle quality is good.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 105, 119, 5, 'Comfortable cotton, recommended.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 106, 120, 4, 'Nice activity toy for babies.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(107, 101, 110, 5, 'The stroller looks strong and clean.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(108, 102, 111, 4, 'Soft blanket and good price.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(109, 103, 113, 5, 'My baby liked this toy.', '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(110, 105, 115, 4, 'Good cover for rainy days.', '2026-04-29 17:53:35', '2026-04-29 17:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `role` enum('customer','seller','admin') NOT NULL DEFAULT 'customer',
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `store_description` text DEFAULT NULL,
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `avatar`, `store_name`, `store_description`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'BabiMarket Admin', 'admin@babimarket.com', NULL, '$2y$12$oroQTRCZKWqFceltqn9LK.rmBqP9QbEiqM9bRlFIH.W9taEI6hwNe', 'admin', NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-04-29 11:02:42', '2026-04-29 11:02:42'),
(2, 'Khalil Brown', 'verlie.stroman@example.org', '2026-04-29 11:02:42', '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', NULL, NULL, NULL, NULL, NULL, 'active', 'LjMCJ7Oa1S', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(3, 'Francis O\'Connell', 'nels.stanton@example.com', '2026-04-29 11:02:43', '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', NULL, NULL, NULL, NULL, NULL, 'active', 'plLyowSnXy', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(4, 'Hassie Goldner', 'amari.frami@example.org', '2026-04-29 11:02:43', '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', NULL, NULL, NULL, NULL, NULL, 'active', 'dMhLpJUDAq', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(5, 'Ima Wuckert', 'kayli.herzog@example.net', '2026-04-29 11:02:43', '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', NULL, NULL, NULL, NULL, NULL, 'active', 'c4oUHfdDAU', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(6, 'Dina Gleason', 'estelle63@example.com', '2026-04-29 11:02:43', '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', NULL, NULL, NULL, NULL, NULL, 'active', 'eN80M0mLka', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(7, 'Wilma Legros', 'zachariah.corwin@example.com', '2026-04-29 11:02:43', '$2y$12$m/15cbxRhDyLUaKMfA1.J.0RlN23j2oUvTinWQoEHBs/CqdaPf.nC', 'seller', NULL, NULL, NULL, NULL, NULL, 'active', 'X4MOtiXG1l', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(8, 'Mrs. Cleora Bergnaum II', 'morissette.nya@example.net', '2026-04-29 11:02:43', '$2y$12$m/15cbxRhDyLUaKMfA1.J.0RlN23j2oUvTinWQoEHBs/CqdaPf.nC', 'seller', NULL, NULL, NULL, NULL, NULL, 'active', 's1dvfW1vn7', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(9, 'Neal Weimann', 'robel.emma@example.org', '2026-04-29 11:02:43', '$2y$12$m/15cbxRhDyLUaKMfA1.J.0RlN23j2oUvTinWQoEHBs/CqdaPf.nC', 'seller', NULL, NULL, NULL, NULL, NULL, 'active', '2DpqJa8e1w', '2026-04-29 11:02:43', '2026-04-29 11:02:43'),
(10, 'abed', 'liu@gmail.com', NULL, '$2y$12$eZhIDP7XCXdsXoxI5MZxAuAIkOCH52Tvg58.mSSNh0BXWU6ShfO7O', 'customer', NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-04-29 11:18:57', '2026-04-29 11:18:57'),
(11, 'abed', 'abeds3di@gmail.com', NULL, '$2y$12$gR8tcqFIB3Ccfy01j3bci.rDWywDjNoaBKD/b9v4lKCUKiOFuyr36', 'seller', NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-04-29 11:37:08', '2026-04-29 11:37:08'),
(12, 'abed', 'saadi@gmail.com', NULL, '$2y$12$pKAPj24ctsdzzkxskTycWu9n1Nbt9NmVvrM2mlyHJje/j.wcQeLKW', 'customer', NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-04-29 11:42:54', '2026-04-29 11:42:54'),
(13, 'abed', 'abedsaadi@gmail.com', NULL, '$2y$12$JZXZnTZWv3AgBxGAYu6wnOwLBUwA5OuqjMPQ1uQWvqzxC8lvNHmoq', 'seller', NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-04-29 12:29:23', '2026-04-29 12:29:23'),
(14, 'abed', 'saadi1@gmail.com', NULL, '$2y$12$629bQ/KkA6YoQ40qESAQxORJGmrFwJWiw5WjvdGc80xX04thPV9ti', 'customer', NULL, NULL, 'avatars/q3JmsziE4agIPovtH25Bw2ByyAiT5MR5N2HawlJB.png', NULL, NULL, 'active', NULL, '2026-04-29 12:40:28', '2026-04-29 13:28:30'),
(101, 'Maya Haddad', 'maya.customer@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', '70111222', 'Beirut, Lebanon', NULL, NULL, NULL, 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 'Karim Nasser', 'karim.customer@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', '71122334', 'Tripoli, Lebanon', NULL, NULL, NULL, 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 'Sara Mansour', 'sara.customer@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', '76123456', 'Saida, Lebanon', NULL, NULL, NULL, 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(104, 'Omar Khaled', 'omar.customer@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', '03111999', 'Zahle, Lebanon', NULL, NULL, NULL, 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 'Lina Farhat', 'lina.customer@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', '70199887', 'Jounieh, Lebanon', NULL, NULL, NULL, 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 'Hadi Daher', 'hadi.customer@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'customer', '81222333', 'Tyre, Lebanon', NULL, NULL, NULL, 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(107, 'Nour Baby Shop', 'nour.seller@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'seller', '76888001', 'Beirut, Lebanon', NULL, 'Nour Baby Shop', 'Clothes, toys, and daily baby essentials.', 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(108, 'Tiny Steps Store', 'tiny.seller@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'seller', '70999002', 'Tripoli, Lebanon', NULL, 'Tiny Steps Store', 'Quality products for newborns and toddlers.', 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(109, 'Happy Baby Market', 'happy.seller@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'seller', '71999003', 'Saida, Lebanon', NULL, 'Happy Baby Market', 'Trusted baby gear and nursery items.', 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(110, 'Mini Care Store', 'mini.seller@test.com', NULL, '$2y$12$jkXPFvLzDQ0j5ZC0OFp9UOFiPtBvJXaU9lcXLxR/LPYw6aPrbv542', 'seller', '76999004', 'Jounieh, Lebanon', NULL, 'Mini Care Store', 'Safe health, feeding, and care products.', 'active', NULL, '2026-04-29 17:53:35', '2026-04-29 17:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(2, 14, 2, '2026-04-29 12:41:35', '2026-04-29 12:41:35'),
(3, 14, 16, '2026-04-29 14:00:52', '2026-04-29 14:00:52'),
(4, 14, 15, '2026-04-29 14:00:54', '2026-04-29 14:00:54'),
(5, 14, 4, '2026-04-29 14:01:40', '2026-04-29 14:01:40'),
(6, 14, 14, '2026-04-29 14:08:08', '2026-04-29 14:08:08'),
(7, 14, 13, '2026-04-29 14:43:28', '2026-04-29 14:43:28'),
(101, 101, 107, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(102, 101, 110, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(103, 102, 101, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(104, 102, 111, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(105, 103, 114, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(106, 103, 120, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(107, 104, 108, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(108, 104, 119, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(109, 105, 102, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(110, 105, 115, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(111, 106, 113, '2026-04-29 17:53:35', '2026-04-29 17:53:35'),
(112, 106, 117, '2026-04-29 17:53:35', '2026-04-29 17:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_method` varchar(64) NOT NULL,
  `payment_details` text NOT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`),
  ADD KEY `messages_product_id_foreign` (`product_id`);

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
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_seller_id_foreign` (`seller_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_seller_id_foreign` (`seller_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_seller_id_foreign` (`seller_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
