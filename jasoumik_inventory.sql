-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2020 at 11:44 AM
-- Server version: 10.3.23-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jasoumik_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_name` varchar(250) NOT NULL,
  `brand_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`brand_id`, `category_id`, `brand_name`, `brand_status`) VALUES
(1, 1, 'DigitalX', 'active'),
(2, 3, 'Samsung(Chinese) ', 'inactive'),
(3, 4, 'Samsung', 'active'),
(4, 6, 'Apple', 'active'),
(5, 8, 'NRBC', 'active'),
(6, 8, 'OBL', 'active'),
(7, 9, 'Sony', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `category_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_status`) VALUES
(1, 'UPS 1200W', 'active'),
(2, 'UPS 600W', 'inactive'),
(3, 'UPS 2000W', 'active'),
(4, 'UPS 300W', 'active'),
(5, 'UPS 100W', 'inactive'),
(6, 'Iphone ', 'active'),
(7, 'Pay-Order', 'active'),
(8, '1 APBn', 'active'),
(9, 'LED TV', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_order`
--

CREATE TABLE `inventory_order` (
  `invent_ordr_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invent_ordr_total` double(10,2) NOT NULL,
  `invent_ordr_date` date NOT NULL,
  `invent_ordr_name` varchar(255) NOT NULL,
  `invent_ordr_adrs` text NOT NULL,
  `payment_status` enum('cash','credit') NOT NULL,
  `invent_ordr_status` varchar(100) NOT NULL,
  `invent_ordr_created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_order`
--

INSERT INTO `inventory_order` (`invent_ordr_id`, `user_id`, `invent_ordr_total`, `invent_ordr_date`, `invent_ordr_name`, `invent_ordr_adrs`, `payment_status`, `invent_ordr_status`, `invent_ordr_created_date`) VALUES
(1, 2, 20.00, '2020-06-01', 'Shouvick', 'uttara', 'cash', 'inactive', '2020-06-02'),
(5, 1, 230.00, '2020-06-19', 'Borno', 'uttara', 'cash', 'active', '2020-06-19'),
(6, 1, 507.20, '2020-06-19', 'Borno', 'uuuucvc', 'cash', 'active', '2020-06-19'),
(7, 4, 23.60, '2020-06-19', 'Borno', 'bogura', 'credit', 'active', '2020-06-19'),
(8, 4, 118.00, '2020-06-19', 'Borno', 'dhanmondi', 'credit', 'active', '2020-06-19'),
(9, 4, 6129730.00, '2020-06-03', 'Abul Kalam Azad', 'abulervaiazad@gmail.com', 'cash', 'inactive', '2020-06-20'),
(10, 1, 47.20, '2020-06-18', 'Borno', 'Bogura', 'credit', 'active', '2020-06-20'),
(11, 1, 9430.00, '2020-06-21', 'fjdjd', 'fdfd', 'cash', 'active', '2020-06-20'),
(12, 1, 0.00, '2020-06-21', 'nobin', 'pagla garot', 'credit', 'inactive', '2020-06-20'),
(13, 1, 25488.00, '2020-06-21', 'Nobin', 'pagla garot', 'cash', 'active', '2020-06-20'),
(14, 1, 578.00, '2020-06-23', 'borno', 'uttara', 'cash', 'active', '2020-06-23'),
(15, 1, 118.00, '2020-06-20', 'Borno', 'Uttara', 'cash', 'inactive', '2020-06-23'),
(16, 1, 1008.99, '2020-06-20', 'Borno', 'fhgj', 'cash', 'active', '2020-06-23'),
(17, 1, 10000.00, '2020-06-23', 'Bulbul', 'Uttara', 'cash', 'active', '2020-06-23');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_order_product`
--

CREATE TABLE `inventory_order_product` (
  `inventory_order_product_id` int(11) NOT NULL,
  `inventory_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  `tax` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory_order_product`
--

INSERT INTO `inventory_order_product` (`inventory_order_product_id`, `inventory_order_id`, `product_id`, `quantity`, `price`, `tax`) VALUES
(2, 5, 2, 1, 200.00, 15.00),
(17, 6, 1, 2, 20.00, 18.00),
(18, 6, 2, 2, 200.00, 15.00),
(19, 7, 1, 1, 20.00, 18.00),
(20, 8, 1, 5, 20.00, 18.00),
(21, 9, 2, 6000, 200.00, 15.00),
(22, 9, 2, 4544, 200.00, 15.00),
(23, 9, 2, 5454, 200.00, 15.00),
(24, 9, 2, 4545, 200.00, 15.00),
(25, 9, 2, 766, 200.00, 15.00),
(26, 9, 2, 5342, 200.00, 15.00),
(27, 10, 1, 2, 20.00, 18.00),
(28, 11, 2, 41, 200.00, 15.00),
(29, 13, 1, 1080, 20.00, 18.00),
(30, 14, 1, 5, 20.00, 18.00),
(31, 14, 2, 2, 200.00, 15.00),
(32, 15, 1, 5, 20.00, 18.00),
(34, 16, 4, 1, 999.00, 1.00),
(35, 17, 5, 1, 10000.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` varchar(300) NOT NULL,
  `product_desc` text NOT NULL,
  `product_qnty` int(11) NOT NULL,
  `product_unit` varchar(150) NOT NULL,
  `product_base_price` double(10,2) NOT NULL,
  `product_tax` decimal(4,2) NOT NULL,
  `product_min_order` double(10,2) DEFAULT NULL,
  `product_entry_by` int(11) NOT NULL,
  `product_status` enum('active','inactive') NOT NULL,
  `product_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `brand_id`, `product_name`, `product_desc`, `product_qnty`, `product_unit`, `product_base_price`, `product_tax`, `product_min_order`, `product_entry_by`, `product_status`, `product_date`) VALUES
(1, 1, 1, 'Best Quality 1200W UPS', 'Best Quality 1200W UPS', 5, 'Nos', 20.00, 18.00, NULL, 1, 'active', '2020-06-18'),
(2, 4, 3, 'Best 300W Samsung UPS', 'Best Qlty 300W Samsung UPS', 5, 'Nos', 200.00, 15.00, NULL, 1, 'active', '2020-06-18'),
(3, 6, 4, 'Iphone X', 'The All new iphone x', 5, 'Nos', 999.00, 15.00, NULL, 1, 'active', '2020-06-20'),
(4, 8, 6, 'Cheque OBL', 'sdsdd', 1, 'Nos', 999.00, 1.00, NULL, 1, 'active', '2020-06-23'),
(5, 9, 7, 'SONY LED TV 32 inch', 'dsjdhbsjd', 1, 'Nos', 10000.00, 0.00, NULL, 1, 'active', '2020-06-23');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `user_mail` varchar(200) NOT NULL,
  `user_pass` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_type` enum('master','user') NOT NULL,
  `user_status` enum('active','inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `user_mail`, `user_pass`, `user_name`, `user_type`, `user_status`) VALUES
(1, 'jasoumik@gmail.com', 'gocoronago', 'Jarif Ahmed Soumik', 'master', 'active'),
(2, 'nobin@gmail.com', '1234', 'Nobin', 'user', 'active'),
(3, 'bema@gmail.com', '1234', 'bema', 'user', 'inactive'),
(4, 'borno@gmail.com', 'gocoronago', 'Borno', 'user', 'active'),
(5, 'shakir@gmail.com', '1234', 'shakir', 'user', 'inactive'),
(6, 'jarin@gmail.com', '1234', 'jarin tasnim', 'user', 'inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `inventory_order`
--
ALTER TABLE `inventory_order`
  ADD PRIMARY KEY (`invent_ordr_id`);

--
-- Indexes for table `inventory_order_product`
--
ALTER TABLE `inventory_order_product`
  ADD PRIMARY KEY (`inventory_order_product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventory_order`
--
ALTER TABLE `inventory_order`
  MODIFY `invent_ordr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `inventory_order_product`
--
ALTER TABLE `inventory_order_product`
  MODIFY `inventory_order_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
