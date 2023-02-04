-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2023 at 08:39 AM
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
  `batch` varchar(255) NOT NULL,
  `uploaded_by` varchar(255) NOT NULL,
  `date_uploaded` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_details`
--

INSERT INTO `file_details` (`id`, `user_id`, `file_type_id`, `file_name`, `status`, `batch`, `uploaded_by`, `date_uploaded`) VALUES
(1, 766563, 1, '1673095857Cover-page.docx', 1, '2018', '130352', '2023-01-07 13:50:57'),
(2, 766563, 2, '1673095998RESUME_GUINANAO_RICO.pdf', 1, '2022', '130352', '2023-01-07 13:53:18'),
(3, 745059, 2, '1674373292Cover-page.docx', 1, '2022', '130352', '2023-01-22 08:41:32'),
(4, 830402, 2, '1674373313Cover-page.docx', 1, '2018', '130352', '2023-01-22 08:41:53'),
(5, 830402, 3, '1674373326RESUME_GUINANAO_RICO.pdf', 1, '2018', '130352', '2023-01-22 08:42:06'),
(6, 745059, 4, '1674823270OJT-pics.docx', 1, '2017', '130352', '2023-01-27 13:41:10'),
(7, 766563, 3, '1674825701RESUME_GUINANAO_RICO.pdf', 1, '2022', '130352', '2023-01-27 14:21:41');

-- --------------------------------------------------------

--
-- Table structure for table `file_requests`
--

CREATE TABLE `file_requests` (
  `id` int(11) NOT NULL,
  `request_id` varchar(255) NOT NULL,
  `file_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `reason` longtext NOT NULL,
  `is_approved` int(11) NOT NULL,
  `is_director_approved` int(11) NOT NULL,
  `is_released` int(11) NOT NULL,
  `processed_by` varchar(255) DEFAULT NULL,
  `date_processed` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `date_requested` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_requests`
--

INSERT INTO `file_requests` (`id`, `request_id`, `file_id`, `user_id`, `reason`, `is_approved`, `is_director_approved`, `is_released`, `processed_by`, `date_processed`, `remarks`, `status`, `date_requested`) VALUES
(1, 'IETI686346', 1, '766563', 'approve<br>', 2, 0, 0, '130352', '2023-02-04 15:28:19', '<p>rejected by admin</p>', 0, '2023-02-04 15:24:24'),
(2, 'IETI309766', 1, '766563', '<p>approvd1<br></p>', 1, 1, 1, '347264', '2023-02-04 15:27:11', '<p>approved by director<br></p>', 1, '2023-02-04 15:25:25');

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

--
-- Dumping data for table `file_types`
--

INSERT INTO `file_types` (`id`, `file_type`, `status`, `created_by`, `date_created`) VALUES
(1, 'transcript of records', 1, '130352', '2023-01-07 13:47:48'),
(2, 'compcard', 1, '130352', '2023-01-07 13:48:23'),
(3, 'tyd', 1, '130352', '2023-01-17 12:47:43'),
(4, 'q', 1, '130352', '2023-02-02 17:40:25');

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
(1, '130352', '1672026986channels4_profile.jpg', 'DAMS', '', 'Admin', '09323232323', 'cccadmissionproject2021@gmail.com', 'jan lang', 'admin', '$2y$10$jnyTebCUHYu.mq0FEX.7xOYxlbyKxhLusF9zUjWIqF7uN/9XrNp7W', 1, 1, 3, '2022-12-14 14:58:45'),
(2, '766563', '1671360442coco.png', 'User', '', 'User', '09891212121', 'guinanaorico@gmail.com', 'user', 'user', '$2y$10$Ke9EDs0MZMR7N8aVOauhyepl/s/aP/gToaacYL2/ENzn8wEslirfy', 0, 1, 3, '2022-12-17 09:41:03'),
(3, '830402', '1672207443maprisuka.png', 'Mapriso ka', '', 'Aguy', '09121212121', 'user1@gmail.com', 'qwe', 'aguy', '$2y$10$Ke9EDs0MZMR7N8aVOauhyepl/s/aP/gToaacYL2/ENzn8wEslirfy', 0, 1, 3, '2022-12-28 07:03:17'),
(4, '523083', '1672207512yor.jpg', 'qweqws', '', 'qwe', '09212121212', 'user2@gmail.com', 'ads', 'qwe', '$2y$10$yR2nRZStgakf6jE71j7Kz.VXX4YkGeYsBZE3sYXxbMY4MU/cXh7HS', 0, 1, 3, '2022-12-28 07:04:28'),
(5, '745059', '1672207843141455.jpg', 'q', '', 'User', '09212222222', 'asd@qew.c', 'qwe', 'w', '$2y$10$E/tNezsVyHaAtS9j9yBvmuDMcg7/9E5K.oHJm8jyIT48hVBWYIRqm', 0, 1, 3, '2022-12-28 07:06:00'),
(6, '347264', 'default.png', 'derek', 'director', 'ramsay', '09121212121', 'ieti.system2023@gmail.com', 'qwe', 'derek', '$2y$10$SySICQlHcqtcl0oIqqj9xOlqT1Di/vzcPz2yeMfm66VBb2cpiXmiG', 2, 1, 3, '2023-02-03 08:13:39'),
(7, '842744', 'default.png', '111', '111', '111', '09212121212', 'estriborics@gmail.com', 'asd', '111', '$2y$10$knQxS4Z18uhlPaKeQv3ETeJZU5BvYvyRlBIcMlrOVOkq2QotKuThm', 1, 1, 3, '2023-02-04 14:37:03'),
(8, '370020', 'default.png', 'qweww22', 'qwe22', 'qwe22', '09212121212', 'ricoestriboguinanao@gmail.com', 'qew', 'qweww22', '$2y$10$CG0mfQ0lkpl3GKNNkD0Opu9Cb8hqDroRSgJ8SFT5/PFPbhdzHJ3/m', 1, 1, 3, '2023-02-04 14:38:08'),
(9, '504927', 'default.png', 'dfss', 'asda', 'asda', '09234234234', 'ewe@sss', 'ewq', 'ewe', '$2y$10$SkoGPJrPjtbjFuma0tSvOed9Cp1jlQ8fDtiAl3ovHDQ4uSakatZfe', 0, 1, 3, '2023-02-04 14:40:33'),
(10, '113574', 'default.png', 'q12312', '123', '1231', '09321312312', '12333@das.c', '12322', '12322', '$2y$10$lZGHNBypD7KsjFFmFnVXau1mDA2/RBAWpHbvpAdfl2Vc/obI4Ut7q', 0, 1, 3, '2023-02-04 14:44:32');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `file_requests`
--
ALTER TABLE `file_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `file_types`
--
ALTER TABLE `file_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
