-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2025 at 10:07 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewa_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `old_values`, `new_values`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'created', 'Category', 'f6ea41c1-346d-4170-bf06-77e45c6ef9d1', NULL, NULL, 'Admin Update Admin Toko menambah category Baju Jelek Banget', '2025-05-04 20:52:39', '2025-05-04 20:52:39'),
(2, 1, 'logout', NULL, NULL, NULL, NULL, 'Admin Update Admin Toko logout.', '2025-05-05 00:06:56', '2025-05-05 00:06:56'),
(3, 1, 'logout', NULL, NULL, NULL, NULL, 'Admin Update Admin Toko logout.', '2025-05-05 00:08:48', '2025-05-05 00:08:48'),
(4, 1, 'logout', NULL, NULL, NULL, NULL, 'Admin Update Admin Toko logout.', '2025-05-05 00:10:32', '2025-05-05 00:10:32'),
(5, 1, 'logout', NULL, NULL, NULL, NULL, 'Admin Update Admin Toko logout.', '2025-05-05 00:11:11', '2025-05-05 00:11:11'),
(6, 1, 'login', NULL, NULL, NULL, NULL, 'Admin Update Admin Toko login.', '2025-05-05 00:14:11', '2025-05-05 00:14:11'),
(7, 1, 'logout', NULL, NULL, NULL, NULL, 'Admin Update Admin Toko logout.', '2025-05-05 00:14:16', '2025-05-05 00:14:16'),
(8, 1, 'login', NULL, NULL, NULL, NULL, 'Admin Update Admin Toko login.', '2025-05-05 00:15:29', '2025-05-05 00:15:29'),
(9, 1, 'updated', 'Category', 'f6ea41c1-346d-4170-bf06-77e45c6ef9d1', '{\"name\": \"Baju Jelek Banget\", \"slug\": \"baju-jelek-banget\"}', '{\"id\": \"f6ea41c1-346d-4170-bf06-77e45c6ef9d1\", \"name\": \"Edit Baju Jelek Banget\", \"slug\": \"edit-baju-jelek-banget\", \"created_at\": \"2025-05-05 03:52:39\", \"updated_at\": \"2025-05-05 07:15:41\"}', 'Admin Update Admin Toko mengedit category Edit Baju Jelek Banget', '2025-05-05 00:15:41', '2025-05-05 00:15:41'),
(10, 1, 'created', 'Product', '3d599ed0-0c02-4412-ad2d-1f3a92f94cfc', NULL, NULL, 'Admin Update Admin Toko menambah product Produk Baju Jelek Banget', '2025-05-05 00:16:12', '2025-05-05 00:16:12'),
(11, 1, 'updated', 'Product', '3d599ed0-0c02-4412-ad2d-1f3a92f94cfc', '{\"status\": \"active\"}', '{\"id\": \"3d599ed0-0c02-4412-ad2d-1f3a92f94cfc\", \"status\": \"inactive\", \"created_at\": \"2025-05-05 07:16:12\", \"updated_at\": \"2025-05-05 07:16:22\"}', 'Admin Update Admin Toko mengubah status product Produk Baju Jelek Banget menjadi inactive', '2025-05-05 00:16:22', '2025-05-05 00:16:22'),
(12, 1, 'logout', NULL, NULL, NULL, NULL, 'Admin Update Admin Toko logout.', '2025-05-05 00:16:27', '2025-05-05 00:16:27'),
(13, 2, 'created', 'User', '3', NULL, NULL, 'Superadmin Developer menambah admin Admin Baru', '2025-05-05 01:48:40', '2025-05-05 01:48:40'),
(16, 2, 'deleted', 'User', '3', NULL, NULL, 'Superadmin Developer menghapus admin Admin Baru', '2025-05-05 02:03:46', '2025-05-05 02:03:46'),
(17, 1, 'login', NULL, NULL, NULL, NULL, 'Admin Update Admin Toko login.', '2025-05-05 02:20:17', '2025-05-05 02:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_dew@tokosewa.com|127.0.0.1', 'i:1;', 1745912623),
('laravel_cache_dew@tokosewa.com|127.0.0.1:timer', 'i:1745912623;', 1745912623);

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `slug`, `image`, `created_at`, `updated_at`) VALUES
('1b8c7850-5a1a-436d-adf5-586975a70a02', 'Kamera', 'Untuk individu yang butuh kamera buat fotografi, video, atau konten kreator.', 'kamera', 'categories/H7h9rZsqWghuCmXcMoq8xSoZUPqrgp66QytxkvMv.jpg', '2025-04-29 00:30:19', '2025-04-29 00:38:23'),
('4a96ea2f-18df-4c66-82b3-27386fc4aeed', 'Baju Jelek', 'aa', 'baju-jelek', 'categories/r2bVbQIplkPFX1JcL0klPnpeXr5hFQL9vvcl7peA.jpg', '2025-05-04 20:43:24', '2025-05-04 20:43:24'),
('6e73a9a0-ab3e-4f28-9e74-a363ac818aa7', 'Laptop', 'Untuk kebutuhan kerja, belajar, atau gaming sementara.', 'laptop', 'categories/fbCL4gJEXRWREILFaU82ARIN5hU5BVbkk8EZyIyg.png', '2025-04-29 00:39:47', '2025-04-29 00:39:47'),
('860197ac-e72e-47d4-9fb0-ba330d7b6688', 'Proyektor', 'Untuk presentasi, nonton bareng, atau acara kecil.', 'proyektor', 'categories/SzhVUc4QhBYm41ex3uhhtkiPZuvNwRb3i1BdPhzN.jpg', '2025-04-29 00:40:30', '2025-04-29 00:40:30'),
('d03761ca-0909-4e94-a747-5c343c40da9c', 'Konsol Game', 'Untuk hiburan, misal rental PlayStation atau Nintendo buat gaming.', 'konsol-game', 'categories/P6FVo5S3Z5nB1cCUsdzXPLFf3ylbTLxtInxdRHGH.png', '2025-04-29 00:41:39', '2025-04-29 00:41:39'),
('d23e242c-f7b2-49c8-95bc-875237f4f7b7', 'Speaker', 'Untuk kebutuhan audio, misal buat acara kecil atau karaoke.', 'speaker', 'categories/2lb9fQZLYhVty4z3PUanDP2sps82SyxdpvlJQf42.png', '2025-04-29 00:41:07', '2025-04-29 00:41:07'),
('f6ea41c1-346d-4170-bf06-77e45c6ef9d1', 'Edit Baju Jelek Banget', 'DD', 'edit-baju-jelek-banget', 'categories/vliU8iwLzUGqyviTPQMfDnsEBs5bxJhMeHeVbxC8.jpg', '2025-05-04 20:52:39', '2025-05-05 00:15:41');

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
(4, '2025_04_25_113514_create_categories_table', 1),
(5, '2025_04_25_113600_create_products_table', 1),
(6, '2025_04_25_174335_create_rentals_table', 1),
(8, '2025_05_05_033008_activity_logs', 2);

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` int NOT NULL,
  `stock` int UNSIGNED NOT NULL,
  `is_bundle` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `is_bundle`, `status`, `created_at`, `updated_at`) VALUES
('0ece5d32-c03a-4cf8-88f3-7d6379d32526', '6e73a9a0-ab3e-4f28-9e74-a363ac818aa7', 'Laptop Asus Zenbook', 'laptop-asus-zenbook', 'ini laptop zenbook', 1000000, 5, 0, 'active', '2025-04-29 01:31:12', '2025-04-29 01:31:12'),
('1a06706a-3fb0-437c-8bba-c7688c8e6701', '6e73a9a0-ab3e-4f28-9e74-a363ac818aa7', 'Laptop Asus Vivobook 14', 'laptop-asus-vivobook-14', 'Ini laptop asus vivobook 14', 800000, 5, 0, 'active', '2025-04-29 01:29:35', '2025-04-29 01:29:35'),
('332cc5fa-6e1d-433c-998b-b9d3fc2f4ea3', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Sony Bagus', 'camera-sony-bagus', 'Ini camera sony bagus', 1000000, 5, 0, 'active', '2025-04-29 01:24:43', '2025-04-29 01:24:43'),
('3735d509-0116-48b8-b710-0f8b4ca98882', '6e73a9a0-ab3e-4f28-9e74-a363ac818aa7', 'Laptop Asus ROG STRIX', 'laptop-asus-rog-strix', 'ini laptop asus rog strix', 900000, 5, 0, 'active', '2025-04-29 01:30:10', '2025-04-29 01:30:10'),
('3d599ed0-0c02-4412-ad2d-1f3a92f94cfc', 'f6ea41c1-346d-4170-bf06-77e45c6ef9d1', 'Produk Baju Jelek Banget', 'produk-baju-jelek-banget', 'asdf', 30000, 4, 0, 'inactive', '2025-05-05 00:16:12', '2025-05-05 00:16:22'),
('6082b452-79c5-492c-b272-444f0cb9468b', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Canon Bagus Banget', 'camera-canon-bagus-banget', 'Ini camera canon bagus banget', 800000, 5, 0, 'active', '2025-04-29 01:04:27', '2025-04-29 01:04:27'),
('77f72fb6-ff9f-4c3c-b4ef-d14b089d820d', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Nikon Bagus', 'camera-nikon-bagus', 'Ini camera nikon bagus', 30000, 5, 0, 'active', '2025-04-29 01:07:20', '2025-04-29 01:07:20'),
('96769196-517c-47f7-ba32-17ad41f56076', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Canon Lumayan Bagus', 'camera-canon-lumayan-bagus', NULL, 400000, 5, 0, 'active', '2025-04-29 01:03:59', '2025-04-29 01:03:59'),
('a0eab8ef-36e5-4d78-9be5-c6d6d7399d1f', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Sony Lumayan Bagus', 'camera-sony-lumayan-bagus', 'Ini camera sony lumayan bagus', 1500000, 5, 0, 'active', '2025-04-29 01:25:09', '2025-04-29 01:25:09'),
('b4808347-140a-4434-ba07-1e1e36482377', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Sony Bagus Banget', 'camera-sony-bagus-banget', 'Ini camera sony bagus banget', 2000000, 5, 0, 'active', '2025-04-29 01:25:48', '2025-04-29 01:25:48'),
('bc944a00-c051-4ebd-8062-3b8fa01b9ab7', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Nikon Lumayan Bagus', 'camera-nikon-lumayan-bagus', 'asdfasdf', 60000, 5, 0, 'active', '2025-04-29 01:08:09', '2025-04-29 01:08:09'),
('c2893ded-f81a-46e4-a6ce-0dc26e8a1283', '860197ac-e72e-47d4-9fb0-ba330d7b6688', 'Proyektor Samsung Bagus Banget', 'proyektor-samsung-bagus-banget', 'ini proyektor samsung bagus banget', 50000, 1, 0, 'active', '2025-05-03 11:23:11', '2025-05-04 10:16:00'),
('eb6e0280-2c0a-4c27-806f-199013f87dd8', '860197ac-e72e-47d4-9fb0-ba330d7b6688', 'Proyektor Samsung Bagus', 'proyektor-samsung-bagus', 'Ini proyektor samsung bagus', 300000, 3, 0, 'active', '2025-05-03 11:30:38', '2025-05-04 10:47:17'),
('f9897367-bf79-4221-9299-b636ac2a1095', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Canon Bagus', 'camera-canon-bagus', 'Ini camera cannon bagus', 200000, 5, 0, 'active', '2025-04-29 01:03:27', '2025-04-29 01:03:27'),
('fd169d3f-a221-48b5-bcfd-896931b88503', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Nikon Bagus Banget', 'camera-nikon-bagus-banget', 'Ini Camera Nikon Bagus Banget', 90000, 5, 0, 'active', '2025-04-29 01:09:15', '2025-04-29 01:09:15');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `order`, `created_at`, `updated_at`) VALUES
('0e171370-b309-4873-a09d-77265eafa570', 'f9897367-bf79-4221-9299-b636ac2a1095', 'product_images/znw4CT2ywuY7C8tOi0izhwgE01mVyFfK4nwELKKp.png', 0, 1, '2025-04-29 01:03:27', '2025-04-29 01:03:27'),
('1ae81b32-2c93-42ab-9948-e797e11e37c3', '1a06706a-3fb0-437c-8bba-c7688c8e6701', 'product_images/PEJAn4ff0IMpRjeENRPINaE2hQ7xU8Y0LLIY5nrr.png', 0, 1, '2025-04-29 01:29:35', '2025-04-29 01:29:35'),
('1bb2c25b-ef8f-4892-9438-570dec3a3147', '1a06706a-3fb0-437c-8bba-c7688c8e6701', 'product_images/G7drPK0OzZWJS5UT8feNpXgdnXUMVmqbdJU6Q3il.png', 1, 0, '2025-04-29 01:29:35', '2025-04-29 01:29:35'),
('23946edb-ead3-4939-80c0-faa0a5a10b77', '0ece5d32-c03a-4cf8-88f3-7d6379d32526', 'product_images/05vnGb4bmypFugfSFQ8p9qPqK1ySlXUjf0wc3LKB.jpg', 1, 0, '2025-04-29 01:31:12', '2025-04-29 01:31:12'),
('253cdf7f-8a1f-4475-98ff-f61862379970', '3d599ed0-0c02-4412-ad2d-1f3a92f94cfc', 'product_images/ioMP7IJggj8Oi00jNgKpqInpCYnBdicVor7EfLT1.jpg', 0, 2, '2025-05-05 00:16:12', '2025-05-05 00:16:12'),
('267c7098-b892-40e0-a1b3-d93c0ebef71d', 'b4808347-140a-4434-ba07-1e1e36482377', 'product_images/T72q8dQW302Nt8Az6tVxLhwPmgkKQlBmBGir4SAT.jpg', 1, 0, '2025-04-29 01:25:48', '2025-04-29 01:25:48'),
('2a6b80bc-0f97-4411-a83f-9ae449e3d7db', 'c2893ded-f81a-46e4-a6ce-0dc26e8a1283', 'product_images/IDxHybx7tF6rJHLDK16918ZBktpTzuOiUH5Il96u.jpg', 1, 0, '2025-05-03 11:23:11', '2025-05-03 11:23:11'),
('2b72d79b-0e40-43b4-a61d-05af9f775505', 'eb6e0280-2c0a-4c27-806f-199013f87dd8', 'product_images/KcNBGZktdh4QmxdM5RBJxRlKMvFk6nLSFl6zK6KE.jpg', 0, 1, '2025-05-03 11:30:38', '2025-05-03 11:30:38'),
('2d1736a1-4f63-4500-a177-3d07d1a3f04f', '6082b452-79c5-492c-b272-444f0cb9468b', 'product_images/t16TqzCY8mkcPDQm69FAvTaMoWkYyffOolLWrE7n.jpg', 1, 0, '2025-04-29 01:04:27', '2025-04-29 01:04:27'),
('2d49fa1a-bb53-46f4-945f-7015d5bbc341', 'b4808347-140a-4434-ba07-1e1e36482377', 'product_images/ofw9cCfvwzacskJW03rLaoHeMzgyTypsMOYi05zm.jpg', 0, 1, '2025-04-29 01:25:48', '2025-04-29 01:25:48'),
('324191e1-12b6-47b1-95d1-0924aae0c8f3', '96769196-517c-47f7-ba32-17ad41f56076', 'product_images/LFQGo58m0q6CGzO7GRA117Mcguq5A8H6VeSNfyjZ.jpg', 1, 0, '2025-04-29 01:03:59', '2025-04-29 01:03:59'),
('34067ab5-4b16-4035-ba16-125b9ab9f51e', '3d599ed0-0c02-4412-ad2d-1f3a92f94cfc', 'product_images/Lp9AZ1wD11CGqLdXCZ6AixbscPctQTcNOBnI0KXr.jpg', 0, 3, '2025-05-05 00:16:12', '2025-05-05 00:16:12'),
('3899eaf9-70f7-4528-973c-7082706ff251', '3d599ed0-0c02-4412-ad2d-1f3a92f94cfc', 'product_images/e7TkAZfXzCCig20loS0xfbfry8XiybeV2z7CBqYW.jpg', 1, 0, '2025-05-05 00:16:12', '2025-05-05 00:16:12'),
('3aa79456-20c3-40d3-a588-2a41c1246ff9', '332cc5fa-6e1d-433c-998b-b9d3fc2f4ea3', 'product_images/4gXGi3uRmh4FNfOC4KAnV6cm9VX3ivvJq9svlrUc.jpg', 1, 0, '2025-04-29 01:24:43', '2025-04-29 01:24:43'),
('3f1508fc-d472-4481-b5c8-c5a9793b9cfa', '3d599ed0-0c02-4412-ad2d-1f3a92f94cfc', 'product_images/HNR4vWnlxh5Lrt9KqaGNGZDAymw9uDVtVkNkzJ3u.jpg', 0, 1, '2025-05-05 00:16:12', '2025-05-05 00:16:12'),
('3f1e5b8f-8647-4c62-90f9-481c4f7c46a1', '3735d509-0116-48b8-b710-0f8b4ca98882', 'product_images/Mdb6vFtP8K7m8NepXYjPa8thaxV5RgmQHh09JF1E.jpg', 0, 1, '2025-04-29 01:30:10', '2025-04-29 01:30:10'),
('43c2a74f-df73-448b-9072-501497149e6d', 'eb6e0280-2c0a-4c27-806f-199013f87dd8', 'product_images/8yubuvi7AWqV4MUjZ5OlJ8IQycjkxinzKvwcRSob.jpg', 0, 2, '2025-05-03 11:30:38', '2025-05-03 11:30:38'),
('4497d025-9b0e-49fe-84a3-27d0ff84966f', '77f72fb6-ff9f-4c3c-b4ef-d14b089d820d', 'product_images/93mTRuWns2bFgY5XXClTrHTBrZARCKAMlZmP9rs1.jpg', 1, 0, '2025-04-29 01:07:20', '2025-04-29 01:07:20'),
('55c04bb8-040a-48c2-b089-c96942b9bf09', '96769196-517c-47f7-ba32-17ad41f56076', 'product_images/exXSmvjsKOJimrqgWXmj970NBlt1BRKYpRoEsmdB.jpg', 0, 1, '2025-04-29 01:03:59', '2025-04-29 01:03:59'),
('5c3e1856-c924-4ea0-97d5-6031f6bc9a3c', '0ece5d32-c03a-4cf8-88f3-7d6379d32526', 'product_images/ttrPcxk6rFlUrm50s6p4z3AWp0BSFzpXU81EN5gY.jpg', 0, 1, '2025-04-29 01:31:12', '2025-04-29 01:31:12'),
('5cbcb259-0e1c-429a-aae4-f17f2f949422', '77f72fb6-ff9f-4c3c-b4ef-d14b089d820d', 'product_images/ENDbakN7sYvdGC9D4RK8pgpO10QdGG1AMuvT6EAc.jpg', 0, 1, '2025-04-29 01:07:20', '2025-04-29 01:07:20'),
('7504276b-eba1-424e-b576-805ebf966c58', '332cc5fa-6e1d-433c-998b-b9d3fc2f4ea3', 'product_images/K5k1NXtX1OMIIwVRzHF9J3Sz9gFI26DIhmn45HRR.png', 0, 1, '2025-04-29 01:24:43', '2025-04-29 01:24:43'),
('8105e906-58b3-43bc-abef-dfebb5f4d6b9', '6082b452-79c5-492c-b272-444f0cb9468b', 'product_images/F7lY0bEJ69pMthIi7QLgcBBWLjO2bwxVnSHTJzyY.jpg', 0, 1, '2025-04-29 01:04:27', '2025-04-29 01:04:27'),
('90ac5e7c-f8be-4d13-90c6-41aa8e21f37a', 'c2893ded-f81a-46e4-a6ce-0dc26e8a1283', 'product_images/POT7Z5awvzJT1hVBXHLdVY2wYWIgAug6H1EBurAo.jpg', 0, 1, '2025-05-03 11:23:11', '2025-05-03 11:23:11'),
('937578f4-710d-4829-9502-8f0dacca80d2', 'fd169d3f-a221-48b5-bcfd-896931b88503', 'product_images/KJyWQT3ebcfowCYjNMCXOjqr3pwH3oJSteohPT7J.jpg', 0, 1, '2025-04-29 01:09:15', '2025-04-29 01:09:15'),
('bba3619f-8a09-4590-9f3d-0c6ea52e16ed', 'f9897367-bf79-4221-9299-b636ac2a1095', 'product_images/QBLJ0sQOgczMEtP6yOkdU9rpxBLmG1prosUvJrFf.png', 1, 0, '2025-04-29 01:03:27', '2025-04-29 01:03:27'),
('c8b6471a-51ab-4e66-8517-bb8584bf0b1d', 'bc944a00-c051-4ebd-8062-3b8fa01b9ab7', 'product_images/onxx2iaCXHPEQntXcGlkDYNwLMz2tDS8oYon7y5G.jpg', 0, 1, '2025-04-29 01:08:09', '2025-04-29 01:08:09'),
('e06f4e6c-d697-420e-8a75-957ea7b33dc2', 'bc944a00-c051-4ebd-8062-3b8fa01b9ab7', 'product_images/NZakL5HGL4wzoAvoiD5f43r0ee4u2nKSWXbbzksx.jpg', 1, 0, '2025-04-29 01:08:09', '2025-04-29 01:08:09'),
('eb5fee79-cee5-4753-8711-46d6464248fd', 'a0eab8ef-36e5-4d78-9be5-c6d6d7399d1f', 'product_images/ktcgHR5TNWPlh6MvXllNzPiCUBMXGt72j9kKT4m4.jpg', 0, 1, '2025-04-29 01:25:09', '2025-04-29 01:25:09'),
('eb6a6a44-c38b-4777-8391-fe196689fd60', 'fd169d3f-a221-48b5-bcfd-896931b88503', 'product_images/Yr5VZ5jP71yS1MRiijB692QudQYVQOD1miVd9mJr.jpg', 1, 0, '2025-04-29 01:09:15', '2025-04-29 01:09:15'),
('edb8168f-a607-4d4d-9dcb-b35d352d5395', 'eb6e0280-2c0a-4c27-806f-199013f87dd8', 'product_images/UNcQ3bYpJ0WBt96CSoFrISBV3RTyVSSgQOc8NBOz.jpg', 1, 0, '2025-05-03 11:30:38', '2025-05-03 11:30:38'),
('f2f2dd00-2574-46ef-a7af-34ace815b675', '3735d509-0116-48b8-b710-0f8b4ca98882', 'product_images/yVdowtmvpjdFfhTXNXbGRrz26idQGv2VXPha7bqs.jpg', 1, 0, '2025-04-29 01:30:10', '2025-04-29 01:30:10'),
('f5a4ed69-379c-46b7-be3a-8d808bd2d2fa', 'a0eab8ef-36e5-4d78-9be5-c6d6d7399d1f', 'product_images/VFHOw8OV8cJYjzUluv5625WTb8nli4JdE2DN0QAy.png', 1, 0, '2025-04-29 01:25:09', '2025-04-29 01:25:09');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rental_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_price` int NOT NULL,
  `status` enum('pending','ongoing','completed','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `proof_of_payment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `rental_code`, `customer_name`, `customer_email`, `customer_phone`, `product_id`, `start_date`, `end_date`, `total_price`, `status`, `proof_of_payment`, `created_at`, `updated_at`) VALUES
('21d8a042-ad64-4237-b710-405d196ffa03', 'RENTAL-007', 'staff-01', 'mail@mail.com', '099118822771', 'c2893ded-f81a-46e4-a6ce-0dc26e8a1283', '2025-05-07', '2025-05-08', 50000, 'ongoing', 'rentals/jaminan/o5HH16EuWHOOcplEYuyni2cD86Gwp6I4tlMBWCgu.jpg', '2025-05-04 10:16:00', '2025-05-04 10:16:00'),
('52f89cf0-8660-40b0-bfb7-bacac6579b9b', 'RENTAL-009', 'Lolo', 'lolo@mail.com', '089233122312', 'f9897367-bf79-4221-9299-b636ac2a1095', '2025-05-05', '2025-05-06', 200000, 'completed', 'rentals/jaminan/UFCiqv5qw2NYWy2WExmE3JH3h2wHBSLItpzmnA5H.jpg', '2025-05-04 10:34:30', '2025-05-04 10:46:43'),
('54ae5918-c179-4e02-b711-62bd2ea58eb9', 'RENTAL-002', 'admin', 'admin@example.com', '022331122333', '0ece5d32-c03a-4cf8-88f3-7d6379d32526', '2025-05-06', '2025-05-08', 2000000, 'ongoing', NULL, '2025-05-04 09:28:29', '2025-05-04 09:28:29'),
('5e42651e-0ff3-45b3-bac6-3752d0cbb0f7', 'RENTAL-003', 'Muhammad Aziz Sige kurniawan', 'kurniawan00azizsige@gmail.com', '089677144304', '0ece5d32-c03a-4cf8-88f3-7d6379d32526', '2025-05-09', '2025-05-11', 2000000, 'ongoing', NULL, '2025-05-04 09:29:01', '2025-05-04 09:29:01'),
('6e8d058e-72a6-434a-bc0b-fabadbb0dc8a', 'RENTAL-006', 'Tino', 'totim68660@regishub.com', '08574837938', 'c2893ded-f81a-46e4-a6ce-0dc26e8a1283', '2025-05-04', '2025-05-05', 50000, 'ongoing', 'rentals/jaminan/G06p16m1hvA3cjBhJVRxCPsOTslsEH2O9baeKjKE.jpg', '2025-05-04 10:15:28', '2025-05-04 10:15:28'),
('8eeeb227-38ac-4700-8087-1e96fe98ec88', 'RENTAL-005', 'Agus', 'orc2h8h79y@bltiwd.com', '089122122312', '0ece5d32-c03a-4cf8-88f3-7d6379d32526', '2025-05-14', '2025-05-15', 1000000, 'ongoing', NULL, '2025-05-04 09:29:48', '2025-05-04 09:29:48'),
('d07e3c81-548c-49cb-b04a-3296d3f0bd36', 'RENTAL-001', 'Banit', 'aziz@busanid.dev', '089677144304', '0ece5d32-c03a-4cf8-88f3-7d6379d32526', '2025-05-04', '2025-05-05', 1000000, 'ongoing', NULL, '2025-05-04 02:14:03', '2025-05-04 02:14:03'),
('fbc5b40c-0b08-4d99-bef7-1e8edc31e361', 'RENTAL-004', 'UPDATE Banit', 'm.azizsigekurniawan@gmail.com', '000081248640950', '0ece5d32-c03a-4cf8-88f3-7d6379d32526', '2025-05-12', '2025-05-13', 1000000, 'ongoing', NULL, '2025-05-04 09:29:24', '2025-05-04 09:29:24');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('r3QhgpmgWfFabCVmnvmL63Rw1H5Ezw3UaGY5xDhK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3c1WlJNd2RmMEpiUDhiUnRRc3ZWMUZjUnRNVUd0UDF2SW8zZXNyVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1746417245),
('ztTHF5LaFgMlfjv358nHJ0aKzlzESUTZQZdf7wv8', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidkNUU2VLNXhSUTFMNHNSU0RpM3VJSWQ2U1VMcjdERm43dExnRFBXbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1746438667);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','developer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Update Admin Toko', 'admin@tokosewa.com', '$2y$12$xCyLr18.bDfI7EfER7NYXOc5lIz1TT2paT9T3xINO4Et7sP7lBEmu', 'admin', '2025-04-28 21:40:28', '2025-04-29 02:28:03'),
(2, 'Developer', 'dev@tokosewa.com', '$2y$12$tyBE.QycIxd5GxpClkjp/eL92s9M3bdU26346EY6yJVMlh0XYJaPq', 'developer', '2025-04-28 21:40:28', '2025-04-28 21:40:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rentals_rental_code_unique` (`rental_code`),
  ADD KEY `rentals_product_id_foreign` (`product_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
