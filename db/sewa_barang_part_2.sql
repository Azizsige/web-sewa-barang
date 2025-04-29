-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2025 at 09:51 AM
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
('6e73a9a0-ab3e-4f28-9e74-a363ac818aa7', 'Laptop', 'Untuk kebutuhan kerja, belajar, atau gaming sementara.', 'laptop', 'categories/fbCL4gJEXRWREILFaU82ARIN5hU5BVbkk8EZyIyg.png', '2025-04-29 00:39:47', '2025-04-29 00:39:47'),
('860197ac-e72e-47d4-9fb0-ba330d7b6688', 'Proyektor', 'Untuk presentasi, nonton bareng, atau acara kecil.', 'proyektor', 'categories/SzhVUc4QhBYm41ex3uhhtkiPZuvNwRb3i1BdPhzN.jpg', '2025-04-29 00:40:30', '2025-04-29 00:40:30'),
('d03761ca-0909-4e94-a747-5c343c40da9c', 'Konsol Game', 'Untuk hiburan, misal rental PlayStation atau Nintendo buat gaming.', 'konsol-game', 'categories/P6FVo5S3Z5nB1cCUsdzXPLFf3ylbTLxtInxdRHGH.png', '2025-04-29 00:41:39', '2025-04-29 00:41:39'),
('d23e242c-f7b2-49c8-95bc-875237f4f7b7', 'Speaker', 'Untuk kebutuhan audio, misal buat acara kecil atau karaoke.', 'speaker', 'categories/2lb9fQZLYhVty4z3PUanDP2sps82SyxdpvlJQf42.png', '2025-04-29 00:41:07', '2025-04-29 00:41:07');

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
(6, '2025_04_25_174335_create_rentals_table', 1);

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
('6082b452-79c5-492c-b272-444f0cb9468b', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Canon Bagus Banget', 'camera-canon-bagus-banget', 'Ini camera canon bagus banget', 800000, 5, 0, 'active', '2025-04-29 01:04:27', '2025-04-29 01:04:27'),
('77f72fb6-ff9f-4c3c-b4ef-d14b089d820d', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Nikon Bagus', 'camera-nikon-bagus', 'Ini camera nikon bagus', 30000, 5, 0, 'active', '2025-04-29 01:07:20', '2025-04-29 01:07:20'),
('96769196-517c-47f7-ba32-17ad41f56076', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Canon Lumayan Bagus', 'camera-canon-lumayan-bagus', NULL, 400000, 5, 0, 'active', '2025-04-29 01:03:59', '2025-04-29 01:03:59'),
('a0eab8ef-36e5-4d78-9be5-c6d6d7399d1f', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Sony Lumayan Bagus', 'camera-sony-lumayan-bagus', 'Ini camera sony lumayan bagus', 1500000, 5, 0, 'active', '2025-04-29 01:25:09', '2025-04-29 01:25:09'),
('b4808347-140a-4434-ba07-1e1e36482377', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Sony Bagus Banget', 'camera-sony-bagus-banget', 'Ini camera sony bagus banget', 2000000, 5, 0, 'active', '2025-04-29 01:25:48', '2025-04-29 01:25:48'),
('bc944a00-c051-4ebd-8062-3b8fa01b9ab7', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Nikon Lumayan Bagus', 'camera-nikon-lumayan-bagus', 'asdfasdf', 60000, 5, 0, 'active', '2025-04-29 01:08:09', '2025-04-29 01:08:09'),
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
('267c7098-b892-40e0-a1b3-d93c0ebef71d', 'b4808347-140a-4434-ba07-1e1e36482377', 'product_images/T72q8dQW302Nt8Az6tVxLhwPmgkKQlBmBGir4SAT.jpg', 1, 0, '2025-04-29 01:25:48', '2025-04-29 01:25:48'),
('2d1736a1-4f63-4500-a177-3d07d1a3f04f', '6082b452-79c5-492c-b272-444f0cb9468b', 'product_images/t16TqzCY8mkcPDQm69FAvTaMoWkYyffOolLWrE7n.jpg', 1, 0, '2025-04-29 01:04:27', '2025-04-29 01:04:27'),
('2d49fa1a-bb53-46f4-945f-7015d5bbc341', 'b4808347-140a-4434-ba07-1e1e36482377', 'product_images/ofw9cCfvwzacskJW03rLaoHeMzgyTypsMOYi05zm.jpg', 0, 1, '2025-04-29 01:25:48', '2025-04-29 01:25:48'),
('324191e1-12b6-47b1-95d1-0924aae0c8f3', '96769196-517c-47f7-ba32-17ad41f56076', 'product_images/LFQGo58m0q6CGzO7GRA117Mcguq5A8H6VeSNfyjZ.jpg', 1, 0, '2025-04-29 01:03:59', '2025-04-29 01:03:59'),
('3aa79456-20c3-40d3-a588-2a41c1246ff9', '332cc5fa-6e1d-433c-998b-b9d3fc2f4ea3', 'product_images/4gXGi3uRmh4FNfOC4KAnV6cm9VX3ivvJq9svlrUc.jpg', 1, 0, '2025-04-29 01:24:43', '2025-04-29 01:24:43'),
('3f1e5b8f-8647-4c62-90f9-481c4f7c46a1', '3735d509-0116-48b8-b710-0f8b4ca98882', 'product_images/Mdb6vFtP8K7m8NepXYjPa8thaxV5RgmQHh09JF1E.jpg', 0, 1, '2025-04-29 01:30:10', '2025-04-29 01:30:10'),
('4497d025-9b0e-49fe-84a3-27d0ff84966f', '77f72fb6-ff9f-4c3c-b4ef-d14b089d820d', 'product_images/93mTRuWns2bFgY5XXClTrHTBrZARCKAMlZmP9rs1.jpg', 1, 0, '2025-04-29 01:07:20', '2025-04-29 01:07:20'),
('55c04bb8-040a-48c2-b089-c96942b9bf09', '96769196-517c-47f7-ba32-17ad41f56076', 'product_images/exXSmvjsKOJimrqgWXmj970NBlt1BRKYpRoEsmdB.jpg', 0, 1, '2025-04-29 01:03:59', '2025-04-29 01:03:59'),
('5c3e1856-c924-4ea0-97d5-6031f6bc9a3c', '0ece5d32-c03a-4cf8-88f3-7d6379d32526', 'product_images/ttrPcxk6rFlUrm50s6p4z3AWp0BSFzpXU81EN5gY.jpg', 0, 1, '2025-04-29 01:31:12', '2025-04-29 01:31:12'),
('5cbcb259-0e1c-429a-aae4-f17f2f949422', '77f72fb6-ff9f-4c3c-b4ef-d14b089d820d', 'product_images/ENDbakN7sYvdGC9D4RK8pgpO10QdGG1AMuvT6EAc.jpg', 0, 1, '2025-04-29 01:07:20', '2025-04-29 01:07:20'),
('7504276b-eba1-424e-b576-805ebf966c58', '332cc5fa-6e1d-433c-998b-b9d3fc2f4ea3', 'product_images/K5k1NXtX1OMIIwVRzHF9J3Sz9gFI26DIhmn45HRR.png', 0, 1, '2025-04-29 01:24:43', '2025-04-29 01:24:43'),
('8105e906-58b3-43bc-abef-dfebb5f4d6b9', '6082b452-79c5-492c-b272-444f0cb9468b', 'product_images/F7lY0bEJ69pMthIi7QLgcBBWLjO2bwxVnSHTJzyY.jpg', 0, 1, '2025-04-29 01:04:27', '2025-04-29 01:04:27'),
('937578f4-710d-4829-9502-8f0dacca80d2', 'fd169d3f-a221-48b5-bcfd-896931b88503', 'product_images/KJyWQT3ebcfowCYjNMCXOjqr3pwH3oJSteohPT7J.jpg', 0, 1, '2025-04-29 01:09:15', '2025-04-29 01:09:15'),
('bba3619f-8a09-4590-9f3d-0c6ea52e16ed', 'f9897367-bf79-4221-9299-b636ac2a1095', 'product_images/QBLJ0sQOgczMEtP6yOkdU9rpxBLmG1prosUvJrFf.png', 1, 0, '2025-04-29 01:03:27', '2025-04-29 01:03:27'),
('c8b6471a-51ab-4e66-8517-bb8584bf0b1d', 'bc944a00-c051-4ebd-8062-3b8fa01b9ab7', 'product_images/onxx2iaCXHPEQntXcGlkDYNwLMz2tDS8oYon7y5G.jpg', 0, 1, '2025-04-29 01:08:09', '2025-04-29 01:08:09'),
('e06f4e6c-d697-420e-8a75-957ea7b33dc2', 'bc944a00-c051-4ebd-8062-3b8fa01b9ab7', 'product_images/NZakL5HGL4wzoAvoiD5f43r0ee4u2nKSWXbbzksx.jpg', 1, 0, '2025-04-29 01:08:09', '2025-04-29 01:08:09'),
('eb5fee79-cee5-4753-8711-46d6464248fd', 'a0eab8ef-36e5-4d78-9be5-c6d6d7399d1f', 'product_images/ktcgHR5TNWPlh6MvXllNzPiCUBMXGt72j9kKT4m4.jpg', 0, 1, '2025-04-29 01:25:09', '2025-04-29 01:25:09'),
('eb6a6a44-c38b-4777-8391-fe196689fd60', 'fd169d3f-a221-48b5-bcfd-896931b88503', 'product_images/Yr5VZ5jP71yS1MRiijB692QudQYVQOD1miVd9mJr.jpg', 1, 0, '2025-04-29 01:09:15', '2025-04-29 01:09:15'),
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
('mNa05XoGRqzsPLnphs5wCo4JftaFRxCvSEBnjxvS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQldmMWw0OHBKMU9kYTJNTWZ0RzNkb3FkZ2NwUnVzcVFYUGhhR2x6TCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1745918898);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

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
