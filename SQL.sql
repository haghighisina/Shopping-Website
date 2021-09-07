-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2021 at 02:16 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `product_price` int(10) DEFAULT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_name`, `product_price`, `product_id`, `quantity`, `created`) VALUES
(221, 1300365891, 'Product 2', 100000, 2, 2, '2021-07-31 17:38:47'),
(231, 460268583, 'Product 2', 350000, 2, 7, '2021-09-07 16:36:52'),
(232, 460268583, 'Product 3', 560000, 3, 4, '2021-09-07 16:36:53'),
(233, 460268583, 'Product 1', 60000, 1, 1, '2021-09-07 16:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(50) NOT NULL DEFAULT '',
  `parentId` int(10) UNSIGNED DEFAULT NULL,
  `position` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `label`, `parentId`, `position`) VALUES
(1, 'Electronic', 4, 0),
(2, 'Audio', 3, 0),
(3, 'Foto', 4, 0),
(4, 'service', 1, 0),
(5, 'Fotographie', 3, 0),
(6, 'device', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivey_adresses`
--

CREATE TABLE `delivey_adresses` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `recipient` text NOT NULL DEFAULT '',
  `city` text NOT NULL,
  `street` text NOT NULL,
  `streetNumber` varchar(50) NOT NULL,
  `zipCode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `ip` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL DEFAULT '',
  `price` int(11) NOT NULL DEFAULT 0,
  `pic` varchar(100) NOT NULL,
  `time` timestamp NULL DEFAULT current_timestamp(),
  `category_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price`, `pic`, `time`, `category_id`) VALUES
(1, 'Product 1', 'Product Test 1', 60000, 'asset/image/1630493383.jpeg', '2021-07-22 08:51:27', 1),
(2, 'Product 2', 'Product Test 2', 50000, 'asset/image/3.jpg', '2021-07-22 08:51:27', 2),
(3, 'Product 3', 'Product Test 3', 140000, 'asset/image/2.jpg', '2021-07-22 08:51:27', 5),
(4, 'Product 4', 'Product Test 4', 120000, 'asset/image/4.jpg', '2021-07-22 08:51:27', NULL),
(5, 'product 5', 'product 5', 80000, 'asset/image/2.jpg', '2021-07-23 13:22:00', NULL),
(7, 'asdasd', 'asdasd', 123123, 'asset/image/1626776085.jpeg', '2019-07-22 08:51:27', 4),
(8, 'asda', 'fdhfdgh', 123123, 'asset/image/1626776094.jpeg', '2019-08-22 08:51:27', 3),
(9, 'fgjthj', 'dsfsdg', 123123, 'asset/image/1626776101.jpeg', '2020-07-22 08:51:27', NULL),
(10, 'Car', 'wfsdfsfs', 123123, 'asset/image/1630675961.jpeg', '2020-08-22 08:51:27', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(512) CHARACTER SET utf8mb4 NOT NULL,
  `userRights` enum('USER','ADMIN') CHARACTER SET utf8mb4 NOT NULL DEFAULT 'USER',
  `token` varchar(30) CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `user_id`, `email`, `userRights`, `token`) VALUES
(145, 'admin', '$2y$10$jmDghdItnTsaV3664gZHX.sq360zAJEMFmAAbJZhuzGo/K8BQQPbu', 460268583, 'sinaasdasn@gmail.com', 'ADMIN', 'e1751f7214b2ce6e5320c6ccda0de0'),
(156, 'sina', '$2y$10$zQfas2c0.kPOU4MH/ICTYOZjGzCQO6GkK14DfRtTyk5deQkzkV6.G', 1300365891, 'sina@gmail.com', 'USER', '46653e2917fe4fe59ec1ae0f4daf25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id_user_id` (`product_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivey_adresses`
--
ALTER TABLE `delivey_adresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_delivery_adresses` (`user_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_category_ID` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivey_adresses`
--
ALTER TABLE `delivey_adresses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1077;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_cart_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivey_adresses`
--
ALTER TABLE `delivey_adresses`
  ADD CONSTRAINT `FK_user_delivery_adresses` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_category_ID` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
