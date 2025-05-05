-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2025 at 02:42 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `sewa_barang`
--

-- --------------------------------------------------------

--
-- Dumping data for table `categories`
--

INSERT IGNORE INTO `categories` (`id`, `name`, `description`, `slug`, `image`, `created_at`, `updated_at`) VALUES
('1b8c7850-5a1a-436d-adf5-586975a70a02', 'Kamera', 'Untuk individu yang butuh kamera buat fotografi, video, atau konten kreator.', 'kamera', 'categories/H7h9rZsqWghuCmXcMoq8xSoZUPqrgp66QytxkvMv.jpg', '2025-04-29 00:30:19', '2025-04-29 00:38:23'),
('6e73a9a0-ab3e-4f28-9e74-a363ac818aa7', 'Laptop', 'Untuk kebutuhan kerja, belajar, atau gaming sementara.', 'laptop', 'categories/fbCL4gJEXRWREILFaU82ARIN5hU5BVbkk8EZyIyg.png', '2025-04-29 00:39:47', '2025-04-29 00:39:47'),
('860197ac-e72e-47d4-9fb0-ba330d7b6688', 'Proyektor', 'Untuk presentasi, nonton bareng, atau acara kecil.', 'proyektor', 'categories/SzhVUc4QhBYm41ex3uhhtkiPZuvNwRb3i1BdPhzN.jpg', '2025-04-29 00:40:30', '2025-04-29 00:40:30'),
('d03761ca-0909-4e94-a747-5c343c40da9c', 'Konsol Game', 'Untuk hiburan, misal rental PlayStation atau Nintendo buat gaming.', 'konsol-game', 'categories/P6FVo5S3Z5nB1cCUsdzXPLFf3ylbTLxtInxdRHGH.png', '2025-04-29 00:41:39', '2025-04-29 00:41:39'),
('d23e242c-f7b2-49c8-95bc-875237f4f7b7', 'Speaker', 'Untuk kebutuhan audio, misal buat acara kecil atau karaoke.', 'speaker', 'categories/2lb9fQZLYhVty4z3PUanDP2sps82SyxdpvlJQf42.png', '2025-04-29 00:41:07', '2025-04-29 00:41:07');

-- --------------------------------------------------------

--
-- Dumping data for table `migrations`
--

INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_25_113514_create_categories_table', 1),
(5, '2025_04_25_113600_create_products_table', 1),
(6, '2025_04_25_174335_create_rentals_table', 1);

-- --------------------------------------------------------

--
-- Dumping data for table `products`
--

INSERT IGNORE INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `is_bundle`, `status`, `created_at`, `updated_at`) VALUES
('0ece5d32-c03a-4cf8-88f3-7d6379d32526', '6e73a9a0-ab3e-4f28-9e74-a363ac818aa7', 'Laptop Asus Zenbook', 'laptop-asus-zenbook', 'ini laptop zenbook', 1000000, 0, 0, 'active', '2025-04-29 01:31:12', '2025-05-04 09:29:48'),
('1a06706a-3fb0-437c-8bba-c7688c8e6701', '6e73a9a0-ab3e-4f28-9e74-a363ac818aa7', 'Laptop Asus Vivobook 14', 'laptop-asus-vivobook-14', 'Ini laptop asus vivobook 14', 800000, 5, 0, 'active', '2025-04-29 01:29:35', '2025-04-29 01:29:35'),
('332cc5fa-6e1d-433c-998b-b9d3fc2f4ea3', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Sony Bagus', 'camera-sony-bagus', 'Ini camera sony bagus', 1000000, 5, 0, 'active', '2025-04-29 01:24:43', '2025-04-29 01:24:43'),
('3735d509-0116-48b8-b710-0f8b4ca98882', '6e73a9a0-ab3e-4f28-9e74-a363ac818aa7', 'Laptop Asus ROG STRIX', 'laptop-asus-rog-strix', 'ini laptop asus rog strix', 900000, 5, 0, 'active', '2025-04-29 01:30:10', '2025-04-29 01:30:10'),
('6082b452-79c5-492c-b272-444f0cb9468b', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Canon Bagus Banget', 'camera-canon-bagus-banget', 'Ini camera canon bagus banget', 800000, 5, 0, 'active', '2025-04-29 01:04:27', '2025-04-29 01:04:27'),
('77f72fb6-ff9f-4c3c-b4ef-d14b089d820d', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Nikon Bagus', 'camera-nikon-bagus', 'Ini camera nikon bagus', 30000, 5, 0, 'active', '2025-04-29 01:07:20', '2025-04-29 01:07:20'),
('96769196-517c-47f7-ba32-17ad41f56076', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Canon Lumayan Bagus', 'camera-canon-lumayan-bagus', NULL, 400000, 5, 0, 'active', '2025-04-29 01:03:59', '2025-04-29 01:03:59'),
('a0eab8ef-36e5-4d78-9be5-c6d6d7399d1f', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Sony Lumayan Bagus', 'camera-sony-lumayan-bagus', 'Ini camera sony lumayan bagus', 1500000, 5, 0, 'active', '2025-04-29 01:25:09', '2025-04-29 01:25:09'),
('b4808347-140a-4434-ba07-1e1e36482377', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Sony Bagus Banget', 'camera-sony-bagus-banget', 'Ini camera sony bagus banget', 2000000, 5, 0, 'active', '2025-04-29 01:25:48', '2025-04-29 01:25:48'),
('bc944a00-c051-4ebd-8062-3b8fa01b9ab7', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Nikon Lumayan Bagus', 'camera-nikon-lumayan-bagus', 'asdfasdf', 60000, 5, 0, 'active', '2025-04-29 01:08:09', '2025-04-29 01:08:09'),
('c2893ded-f81a-46e4-a6ce-0dc26e8a1283', '860197ac-e72e-47d4-9fb0-ba330d7b6688', 'Proyektor Samsung Bagus Banget', 'proyektor-samsung-bagus-banget', 'ini proyektor samsung bagus banget', 50000, 1, 0, 'active', '2025-05-03 11:23:11', '2025-05-04 10:16:00'),
('eb6e0280-2c0a-4c27-806f-199013f87dd8', '860197ac-e72e-47d4-9fb0-ba330d7b6688', 'Proyektor Samsung Bagus', 'proyektor-samsung-bagus', 'Ini proyektor samsung bagus', 300000, 3, 0, 'active', '2025-05-03 11:30:38', '2025-05-04 10:47:17'),
('f9897367-bf79-4221-9299-b636ac2a1095', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Canon Bagus', 'camera-canon-bagus', 'Ini camera cannon bagus', 200000, 5, 0, 'active', '2025-04-29 01:03:27', '2025-05-04 10:46:43'),
('fd169d3f-a221-48b5-bcfd-896931b88503', '1b8c7850-5a1a-436d-adf5-586975a70a02', 'Camera Nikon Bagus Banget', 'camera-nikon-bagus-banget', 'Ini Camera Nikon Bagus Banget', 90000, 5, 0, 'active', '2025-04-29 01:09:15', '2025-04-29 01:09:15');

-- --------------------------------------------------------

--
-- Dumping data for table `product_images`
--

INSERT IGNORE INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `order`, `created_at`, `updated_at`) VALUES
('0e171370-b309-4873-a09d-77265eafa570', 'f9897367-bf79-4221-9299-b636ac2a1095', 'product_images/znw4CT2ywuY7C8tOi0izhwgE01mVyFfK4nwELKKp.png', 0, 1, '2025-04-29 01:03:27', '2025-04-29 01:03:27'),
('1ae81b32-2c93-42ab-9948-e797e11e37c3', '1a06706a-3fb0-437c-8bba-c7688c8e6701', 'product_images/PEJAn4ff0IMpRjeENRPINaE2hQ7xU8Y0LLIY5nrr.png', 0, 1, '2025-04-29 01:29:35', '2025-04-29 01:29:35'),
('1bb2c25b-ef8f-4892-9438-570dec3a3147', '1a06706a-3fb0-437c-8bba-c7688c8e6701', 'product_images/G7drPK0OzZWJS5UT8feNpXgdnXUMVmqbdJU6Q3il.png', 1, 0, '2025-04-29 01:29:35', '2025-04-29 01:29:35'),
('23946edb-ead3-4939-80c0-faa0a5a10b77', '0ece5d32-c03a-4cf8-88f3-7d6379d32526', 'product_images/05vnGb4bmypFugfSFQ8p9qPqK1ySlXUjf0wc3LKB.jpg', 1, 0, '2025-04-29 01:31:12', '2025-04-29 01:31:12'),
('267c7098-b892-40e0-a1b3-d93c0ebef71d', 'b4808347-140a-4434-ba07-1e1e36482377', 'product_images/T72q8dQW302Nt8Az6tVxLhwPmgkKQlBmBGir4SAT.jpg', 1, 0, '2025-04-29 01:25:48', '2025-04-29 01:25:48'),
('2a6b80bc-0f97-4411-a83f-9ae449e3d7db', 'c2893ded-f81a-46e4-a6ce-0dc26e8a1283', 'product_images/IDxHybx7tF6rJHLDK16918ZBktpTzuOiUH5Il96u.jpg', 1, 0, '2025-05-03 11:23:11', '2025-05-03 11:23:11'),
('2b72d79b-0e40-43b4-a61d-05af9f775505', 'eb6e0280-2c0a-4c27-806f-199013f87dd8', 'product_images/KcNBGZktdh4QmxdM5RBJxRlKMvFk6nLSFl6zK6KE.jpg', 0, 1, '2025-05-03 11:30:38', '2025-05-03 11:30:38'),
('2d1736a1-4f63-4500-a177-3d07d1a3f04f', '6082b452-79c5-492c-b272-444f0cb9468b', 'product_images/t16TqzCY8mkcPDQm69FAvTaMoWkYyffOolLWrE7n.jpg', 1, 0, '2025-04-29 01:04:27', '2025-04-29 01:04:27'),
('2d49fa1a-bb53-46f4-945f-7015d5bbc341', 'b4808347-140a-4434-ba07-1e1e36482377', 'product_images/ofw9cCfvwzacskJW03rLaoHeMzgyTypsMOYi05zm.jpg', 0, 1, '2025-04-29 01:25:48', '2025-04-29 01:25:48'),
('324191e1-12b6-47b1-95d1-0924aae0c8f3', '96769196-517c-47f7-ba32-17ad41f56076', 'product_images/LFQGo58m0q6CGzO7GRA117Mcguq5A8H6VeSNfyjZ.jpg', 1, 0, '2025-04-29 01:03:59', '2025-04-29 01:03:59'),
('3aa79456-20c3-40d3-a588-2a41c1246ff9', '332cc5fa-6e1d-433c-998b-b9d3fc2f4ea3', 'product_images/4gXGi3uRmh4FNfOC4KAnV6cm9VX3ivvJq9svlrUc.jpg', 1, 0, '2025-04-29 01:24:43', '2025-04-29 01:24:43'),
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
-- Dumping data for table `rentals`
--

INSERT IGNORE INTO `rentals` (`id`, `rental_code`, `customer_name`, `customer_email`, `customer_phone`, `product_id`, `start_date`, `end_date`, `total_price`, `status`, `proof_of_payment`, `created_at`, `updated_at`) VALUES
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
-- Dumping data for table `sessions`
--

INSERT IGNORE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gSFDvJhQ4gZ97cqcjtIXj5el6bwFGsV3t0aJ97cS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoid0M2RnB3VEhGY0dselNuNU1IRjU4ZmVQZVV1TGZLYzBveWczRnBXNSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcmVudGFscyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjE6e2k6MDtzOjc6InN1Y2Nlc3MiO31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo3OiJzdWNjZXNzIjtzOjI0OiJSZW50YWwgYmVyaGFzaWwgZGloYXB1cy4iO30=', 1746380838);

-- --------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Update Admin Toko', 'admin@tokosewa.com', '$2y$12$xCyLr18.bDfI7EfER7NYXOc5lIz1TT2paT9T3xINO4Et7sP7lBEmu', 'admin', '2025-04-28 21:40:28', '2025-04-29 02:28:03'),
(2, 'Developer', 'dev@tokosewa.com', '$2y$12$tyBE.QycIxd5GxpClkjp/eL92s9M3bdU26346EY6yJVMlh0XYJaPq', 'developer', '2025-04-28 21:40:28', '2025-04-28 21:40:28');

COMMIT;