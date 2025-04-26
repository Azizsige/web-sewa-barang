-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 26, 2025 at 06:12 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

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
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
('56318ee4-cf3f-4a8f-9007-3f641e3c6aa9', 'Elektronik', 'elektronik', 'categories/elektronik.jpg', '2025-04-25 23:03:51', '2025-04-25 23:03:51'),
('a9d8b7e2-fc5d-4b9e-8c3f-2e5d9a7b6c2d', 'Pakaian', 'pakaian', 'categories/pakaian.jpg', '2025-04-25 23:03:51', '2025-04-25 23:03:51'),
('b7c6a5d3-eb4f-4c8d-9d2e-1f4c8a6b5e3c', 'Alat Olahraga', 'alat-olahraga', 'categories/alat_olahraga.jpg', '2025-04-25 23:03:51', '2025-04-25 23:03:51');

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
(73, '0001_01_01_000000_create_users_table', 1),
(74, '0001_01_01_000001_create_cache_table', 1),
(75, '0001_01_01_000002_create_jobs_table', 1),
(76, '2025_04_25_113514_create_categories_table', 1),
(77, '2025_04_25_113600_create_products_table', 1),
(78, '2025_04_25_174335_create_rentals_table', 1);

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
  `stock` int NOT NULL,
  `is_bundle` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `is_bundle`, `status`, `created_at`, `updated_at`) VALUES
('53f223f0-f575-4b9c-a0ad-a1d31adfdfdd', '56318ee4-cf3f-4a8f-9007-3f641e3c6aa9', 'Laptop', 'laptop', 'Laptop untuk kebutuhan kerja', 50000, 5, 0, 'active', '2025-04-25 23:03:51', '2025-04-25 23:03:51'),
('6caadc50-9c5b-4d65-bffe-e81dd17641bf', 'a9d8b7e2-fc5d-4b9e-8c3f-2e5d9a7b6c2d', 'Jaket', 'jaket', 'Jaket musim dingin', 20000, 10, 0, 'active', '2025-04-25 23:03:51', '2025-04-25 23:03:51'),
('703c387c-a8fc-4810-a69f-3661bfefc9b2', 'a9d8b7e2-fc5d-4b9e-8c3f-2e5d9a7b6c2d', 'Pakaian Produk', 'pakaian-produk', 'fasdf', 10000, 10, 0, 'active', '2025-04-25 23:05:25', '2025-04-25 23:05:25'),
('aed59bc2-c350-4056-b5bc-97de4921a662', '56318ee4-cf3f-4a8f-9007-3f641e3c6aa9', 'Paket Laptop + Mouse', 'paket-laptop-mouse', 'Paket sewa laptop dan mouse', 60000, 3, 1, 'inactive', '2025-04-25 23:03:51', '2025-04-25 23:03:51');

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
('0663b9ed-e4f0-45a7-a566-62e0ebe50c42', '703c387c-a8fc-4810-a69f-3661bfefc9b2', 'product_images/C73Wa36ygJUw3X5GK9A5koSuqXs2kkzZwxS0qWHp.png', 0, 3, '2025-04-25 23:05:25', '2025-04-25 23:05:25'),
('288ce973-0ca2-41a3-b965-62ef0b8b85f0', '703c387c-a8fc-4810-a69f-3661bfefc9b2', 'product_images/O5nwOmvkbSB4Lp8ZSzypwhaZPJPXETZvXrEeXhdy.png', 0, 1, '2025-04-25 23:05:25', '2025-04-25 23:05:25'),
('2dd1c69d-8fc7-4f81-8a74-26e8313d33d5', '703c387c-a8fc-4810-a69f-3661bfefc9b2', 'product_images/Ul65AYnZzBOJG8ip8iI6BbJJZONR7LU6bjqZDC6W.png', 0, 2, '2025-04-25 23:05:25', '2025-04-25 23:05:25'),
('4886fb02-b1c2-45fd-929c-5a0779132043', '53f223f0-f575-4b9c-a0ad-a1d31adfdfdd', 'product_images/laptop-side.jpg', 0, 1, '2025-04-25 23:03:51', '2025-04-25 23:03:51'),
('4978b51e-1dbb-4963-9887-89ce86d6ce47', 'aed59bc2-c350-4056-b5bc-97de4921a662', 'product_images/paket-laptop-mouse.jpg', 1, 0, '2025-04-25 23:03:51', '2025-04-25 23:03:51'),
('5209017d-e68b-4084-80c1-b647a6c176a8', '703c387c-a8fc-4810-a69f-3661bfefc9b2', 'product_images/gjFygVkBbHJDCCvLbQIQhABGpaAiqMLApVHNZDGh.png', 1, 0, '2025-04-25 23:05:25', '2025-04-25 23:05:25'),
('7a6d647c-b60e-4c66-bf69-5c4b5ab6a822', '53f223f0-f575-4b9c-a0ad-a1d31adfdfdd', 'product_images/laptop.jpg', 1, 0, '2025-04-25 23:03:51', '2025-04-25 23:03:51'),
('7a709ebc-b73f-40c6-88fb-789868e30b95', '6caadc50-9c5b-4d65-bffe-e81dd17641bf', 'product_images/jaket.jpg', 1, 0, '2025-04-25 23:03:51', '2025-04-25 23:03:51'),
('e20c8cd7-ea63-4046-9579-5a6baa369b9f', '703c387c-a8fc-4810-a69f-3661bfefc9b2', 'product_images/O84vXnIzej2h6r6EclcwhwfEw6jGNRh6ih79uEbZ.png', 0, 4, '2025-04-25 23:05:25', '2025-04-25 23:05:25');

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
  `duration` int NOT NULL,
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
('Ygysbw1MRmuHPwH7YWQB2ntjW5T6SydSPPogCTgX', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoielhyQjhieHdENTcwM3pNc24yektaTjlDZlBMUGtwY3paeVR0UjltMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0cy83MDNjMzg3Yy1hOGZjLTQ4MTAtYTY5Zi0zNjYxYmZlZmM5YjIvZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1745647792);

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
(1, 'Admin Toko', 'admin@tokosewa.com', '$2y$12$PLpCHgUofN9xucAg4vfYLOnL/ld9O3kQhScz/7kgJE0gtSrpvTOcO', 'admin', '2025-04-25 23:03:50', '2025-04-25 23:03:50'),
(2, 'Developer', 'dev@tokosewa.com', '$2y$12$kNpN6y6GJCXWymH850mno.K3Tzg3N/VHOcL1Vpb3dNWrnDVhV/6wW', 'developer', '2025-04-25 23:03:51', '2025-04-25 23:03:51');

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

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
