-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2023 at 12:45 PM
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
-- Database: `dams_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_details`
--

CREATE TABLE `file_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `uploaded_by` varchar(255) NOT NULL,
  `date_uploaded` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `file_requests`
--

CREATE TABLE `file_requests` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `reason` longtext NOT NULL,
  `is_approved` int(11) NOT NULL,
  `date_processed` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `date_requested` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `file_types`
--

CREATE TABLE `file_types` (
  `id` int(11) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `login_attempts` int(11) NOT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`id`, `user_id`, `picture`, `first_name`, `middle_name`, `last_name`, `phone_no`, `email`, `address`, `username`, `password`, `is_admin`, `status`, `login_attempts`, `date_added`) VALUES
(1, '130352', '1672026986channels4_profile.jpg', 'DAMS', '', 'Admin', '09323232323', 'admin@gmail.com', 'jan lang', 'admin', '$2y$10$jnyTebCUHYu.mq0FEX.7xOYxlbyKxhLusF9zUjWIqF7uN/9XrNp7W', 1, 1, 3, '2022-12-14 14:58:45'),
(2, '766563', '1671360442coco.png', 'User', '', 'User', '09891212121', 'user@gmail.com', 'user', 'user', '$2y$10$Ke9EDs0MZMR7N8aVOauhyepl/s/aP/gToaacYL2/ENzn8wEslirfy', 0, 1, 3, '2022-12-17 09:41:03'),
(3, '830402', '1672207443maprisuka.png', 'Mapriso ka', '', 'Aguy', '09121212121', 'user1@gmail.com', 'qwe', 'aguy', '$2y$10$KIKfG66lAePDdDXXwgmvpucm97SFDuK/p4RfG9KSOmr2z/4crLD5C', 0, 1, 3, '2022-12-28 07:03:17'),
(4, '523083', '1672207512yor.jpg', 'qweqws', '', 'qwe', '09212121212', 'qwe@ds.v', 'ads', 'qwe', '$2y$10$6VQXk36BTwHkJfdgFATfwOm2gZTxWJWoQxQmDNdBsvjNVIbLMsasu', 1, 1, 3, '2022-12-28 07:04:28'),
(5, '745059', '1672207843141455.jpg', 'q', '', 'User', '09212222222', 'asd@qew.c', 'qwe', 'w', '$2y$10$7znCCyctuFoNFkCCDkY4beULISl3pJjsQahEgBV9tcQYtl4zvWr1W', 0, 1, 3, '2022-12-28 07:06:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_details`
--
ALTER TABLE `file_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_requests`
--
ALTER TABLE `file_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_types`
--
ALTER TABLE `file_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_details`
--
ALTER TABLE `file_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_requests`
--
ALTER TABLE `file_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_types`
--
ALTER TABLE `file_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
