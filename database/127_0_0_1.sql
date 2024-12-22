-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2023 at 10:37 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `society_data`
--
CREATE DATABASE IF NOT EXISTS `society_data` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `society_data`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(3) NOT NULL,
  `ad_password` varchar(100) NOT NULL,
  `society_reg` int(4) NOT NULL,
  `a_email` varchar(50) NOT NULL,
  `a_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `ad_password`, `society_reg`, `a_email`, `a_name`) VALUES
(100, 'a9da3f24567a4e9efd9952aa1734df74', 1234, 'admintest@gmail.com', 'Rahul sharma'),
(102, 'bca701b6a508a5b52919dbe677a8f570', 2222, 'adminmail@gmail.com', 'Gaurav'),
(103, 'e66055e8e308770492a44bf16e875127', 7685, 'muko0903@gmail.com', 'Hashmukh');

-- --------------------------------------------------------

--
-- Table structure for table `member_table`
--

CREATE TABLE `member_table` (
  `member_id` varchar(5) NOT NULL,
  `m_password` varchar(100) NOT NULL,
  `m_name` text NOT NULL,
  `society_reg` int(4) NOT NULL,
  `residence` text NOT NULL DEFAULT 'Not specified',
  `phone_no` bigint(10) NOT NULL DEFAULT 0,
  `flat_no` varchar(9) NOT NULL,
  `m_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_table`
--

INSERT INTO `member_table` (`member_id`, `m_password`, `m_name`, `society_reg`, `residence`, `phone_no`, `flat_no`, `m_email`) VALUES
('m_101', 'efa74ac8ab520985afdb5d587c272df3', 'bhargvi', 2222, 'Owned', 9435627847, '2222_A101', 'cosmicmarrow77@gmail.com'),
('m_102', 'efa74ac8ab520985afdb5d587c272df3', 'Bhavya', 2222, 'Owned', 9359038738, '2222_A102', 'socialgaurav02@gmail.com'),
('m_103', 'efa74ac8ab520985afdb5d587c272df3', 'ankit', 2222, 'On Rent', 9345627846, '2222_A103', 'memberC@gmail.com'),
('m_201', 'efa74ac8ab520985afdb5d587c272df3', 'Rahul', 2222, 'Owned', 9978657498, '2222_B201', 'rahul354@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `watchman_tabe`
--

CREATE TABLE `watchman_tabe` (
  `watchman_id` varchar(5) NOT NULL,
  `w_password` varchar(100) NOT NULL,
  `society_reg` int(4) NOT NULL,
  `w_name` text NOT NULL,
  `w_email` varchar(50) NOT NULL,
  `w_docs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchman_tabe`
--

INSERT INTO `watchman_tabe` (`watchman_id`, `w_password`, `society_reg`, `w_name`, `w_email`, `w_docs`) VALUES
('w_102', 'dfaa192a5bf01f2e3966a69ac3bf2caa', 2222, 'watchmanA', 'watchmanA@gmail.com', 'Nitro_Wallpaper_06_3840x2400.jpg'),
('w_103', 'dfaa192a5bf01f2e3966a69ac3bf2caa', 2222, 'watchmanB', 'watchmanB@gmail.com', 'Nitro_Wallpaper_02_3840x2400.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`,`society_reg`),
  ADD UNIQUE KEY `a_email` (`a_email`),
  ADD KEY `society_reg` (`society_reg`);

--
-- Indexes for table `member_table`
--
ALTER TABLE `member_table`
  ADD PRIMARY KEY (`member_id`,`flat_no`),
  ADD UNIQUE KEY `m_email` (`m_email`),
  ADD KEY `society_reg` (`society_reg`);

--
-- Indexes for table `watchman_tabe`
--
ALTER TABLE `watchman_tabe`
  ADD PRIMARY KEY (`watchman_id`),
  ADD UNIQUE KEY `w_email` (`w_email`),
  ADD KEY `society_reg` (`society_reg`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `member_table`
--
ALTER TABLE `member_table`
  ADD CONSTRAINT `member_table_ibfk_1` FOREIGN KEY (`society_reg`) REFERENCES `admin_table` (`society_reg`);

--
-- Constraints for table `watchman_tabe`
--
ALTER TABLE `watchman_tabe`
  ADD CONSTRAINT `watchman_tabe_ibfk_1` FOREIGN KEY (`society_reg`) REFERENCES `admin_table` (`society_reg`);
--
-- Database: `visitor_log`
--
CREATE DATABASE IF NOT EXISTS `visitor_log` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `visitor_log`;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_table`
--

CREATE TABLE `visitor_table` (
  `visitor_id` int(3) NOT NULL,
  `v_name` text NOT NULL,
  `v_image` text NOT NULL DEFAULT '\'NO IMG\'',
  `society_reg` int(4) NOT NULL,
  `phone_no` bigint(10) NOT NULL,
  `visiting_date` datetime(6) NOT NULL,
  `visiting_purpose` text NOT NULL,
  `flat_no` varchar(9) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor_table`
--

INSERT INTO `visitor_table` (`visitor_id`, `v_name`, `v_image`, `society_reg`, `phone_no`, `visiting_date`, `visiting_purpose`, `flat_no`, `status`) VALUES
(1, 'Ajay', '12.jpg', 2222, 9987685647, '2023-01-23 11:59:14.000000', 'Guest', 'A101', 'Approved'),
(7, 'jay', 'Nitro_Wallpaper_01_3840x2400.jpg', 2222, 9978574657, '2023-01-24 15:01:58.000000', 'Guest', 'A101', 'Denied'),
(10, 'Vasant gavde', 'Nitro_Wallpaper_02_3840x2400.jpg', 2222, 9987695476, '2023-02-04 18:01:09.000000', 'Guest', 'A101', 'Approved'),
(11, 'Shravan', '02.jpeg', 2222, 9956748369, '2023-02-05 14:56:17.000000', 'Guest', 'A102', 'Approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `visitor_table`
--
ALTER TABLE `visitor_table`
  ADD PRIMARY KEY (`visitor_id`),
  ADD KEY `society_reg` (`society_reg`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `visitor_table`
--
ALTER TABLE `visitor_table`
  MODIFY `visitor_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `visitor_table`
--
ALTER TABLE `visitor_table`
  ADD CONSTRAINT `visitor_table_ibfk_1` FOREIGN KEY (`society_reg`) REFERENCES `society_data`.`admin_table` (`society_reg`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
