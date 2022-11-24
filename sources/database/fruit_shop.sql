-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2022 at 07:48 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fruit_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_order` int(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_order`, `id_user`, `id_item`, `name`, `price`, `quantity`) VALUES
(1, 2, 1, 'Apple', 3.00, 53),
(2, 2, 2, 'Orange', 4.00, 1),
(21, 8, 5, 'Waterlemon', 7.00, 30);

-- --------------------------------------------------------

--
-- Table structure for table `fruits_table`
--

CREATE TABLE `fruits_table` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fruits_table`
--

INSERT INTO `fruits_table` (`id`, `name`, `image`, `price`) VALUES
(1, 'Apple', 'apple.jpg', 3.00),
(2, 'Orange', 'orange.jpg', 4.00),
(3, 'Banana', 'banana.jpg', 5.00),
(4, 'Lemon', 'lemon.jpg', 3.50),
(5, 'Waterlemon', 'waterlemon.jpg', 7.00),
(6, 'Cherry', 'cherry.jpg', 4.00),
(8, 'Grape', 'grape.jpg', 3.00),
(10, 'Durian', 'durian.jpg', 11.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'default.png',
  `name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL,
  `wallet` double(10,2) NOT NULL DEFAULT 0.00,
  `vip_end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `avatar`, `name`, `email`, `phone_number`, `role`, `wallet`, `vip_end`) VALUES
(2, 'naruto2', '827ccb0eea8a706c4c34a16891f84e7b', 'default.png', '', '', '', 'user', 0.00, NULL),
(4, 'admin', '0192023a7bbd73250516f069df18b500', 'default.png', '', '', '', 'admin', 9000.00, NULL),
(5, 'test', 'cc03e747a6afbbcbf8be7668acfebee5', 'default.png', '', '', '', 'user', 0.00, NULL),
(7, 'naruto', '827ccb0eea8a706c4c34a16891f84e7b', 'default.png', 'naruto2', 'naruto@naruto', '12345678', 'VIP', 10000.00, '2022-12-17'),
(8, 'naruto3', '884ecc7ac05cb5d52aa970f523a3b7e6', 'default.png', '', 'hokage@hokage2', '12345678', 'user', 1000.00, NULL),
(13, 'naruanru', '827ccb0eea8a706c4c34a16891f84e7b', 'default.png', 'naruanru', 'naruanru@33.com', '12345678999', 'user', 0.00, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_item` (`id_item`);

--
-- Indexes for table `fruits_table`
--
ALTER TABLE `fruits_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_order` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `fruits_table`
--
ALTER TABLE `fruits_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `fruits_table` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
