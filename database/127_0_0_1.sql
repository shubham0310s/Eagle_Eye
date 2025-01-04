SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Create the database if it doesn't exist
-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `society_data` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `society_data`;

-- --------------------------------------------------------
-- Table structure for `admin_table`
-- --------------------------------------------------------
CREATE TABLE `admin_table` (
  `admin_id` INT(3) NOT NULL AUTO_INCREMENT,
  `ad_password` VARCHAR(100) NOT NULL,
  `society_reg` INT(4) NOT NULL,
  `a_email` VARCHAR(50) NOT NULL,
  `a_name` TEXT NOT NULL,
  PRIMARY KEY (`admin_id`, `society_reg`),
  UNIQUE KEY `a_email` (`a_email`),
  KEY `society_reg` (`society_reg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into `admin_table`
INSERT INTO `admin_table` (`ad_password`, `society_reg`, `a_email`, `a_name`) VALUES
('0b5f5fec8f76afb4fc36f8e38ca3de2b', 1234, 'demonslayer1me2u@gmail.com', 'Shubham');

-- --------------------------------------------------------
-- Table structure for `member_table`
-- --------------------------------------------------------
CREATE TABLE `member_table` (
  `member_id` INT(5) NOT NULL AUTO_INCREMENT,
  `m_password` VARCHAR(100) NOT NULL,
  `m_name` TEXT NOT NULL,
  `society_reg` INT(4) NOT NULL,
  `residence` TEXT NOT NULL DEFAULT 'Not specified',
  `phone_no` BIGINT(10) NOT NULL DEFAULT 0,
  `flat_no` VARCHAR(9) NOT NULL,
  `m_email` VARCHAR(50) NOT NULL,
  `payment_status` VARCHAR (10) NOT NULL,
  PRIMARY KEY (`member_id`, `flat_no`),
  UNIQUE KEY `m_email` (`m_email`),
  KEY `society_reg` (`society_reg`),
  CONSTRAINT `member_table_ibfk_1` FOREIGN KEY (`society_reg`) REFERENCES `admin_table` (`society_reg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into `member_table`
INSERT INTO `member_table` (`m_password`, `m_name`, `society_reg`, `residence`, `phone_no`, `flat_no`, `m_email`, `payment_status`) VALUES
('efa74ac8ab520985afdb5d587c272df3', 'bhargvi', 1234, 'Owned', 9435627847, '2222_A101', 'cosmicmarrow77@gmail.com','Paid'),
('efa74ac8ab520985afdb5d587c272df3', 'Bhavya', 1234, 'Owned', 9359038738, '2222_A102', 'socialgaurav02@gmail.com', 'Pending');

-- --------------------------------------------------------
-- Table structure for `watchman_table`
-- --------------------------------------------------------
CREATE TABLE `watchman_table` (
  `watchman_id` INT(5) NOT NULL AUTO_INCREMENT,
  `w_password` VARCHAR(100) NOT NULL,
  `society_reg` INT(4) NOT NULL,
  `w_name` TEXT NOT NULL,
  `w_email` VARCHAR(50) NOT NULL,
  `w_docs` TEXT NOT NULL,
  `w_phno` INT(10) UNIQUE,
  PRIMARY KEY (`watchman_id`),
  UNIQUE KEY `w_email` (`w_email`),
  KEY `society_reg` (`society_reg`),
  CONSTRAINT `watchman_table_ibfk_1` FOREIGN KEY (`society_reg`) REFERENCES `admin_table` (`society_reg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into `watchman_table`
INSERT INTO `watchman_table` (`w_password`, `society_reg`, `w_name`, `w_email` ,`w_phno`) VALUES
('dfaa192a5bf01f2e3966a69ac3bf2caa', 1234, 'watchmanA', 'watchmanA@gmail.com',9874563210);

-- --------------------------------------------------------
-- Table structure for `visitor_table`
-- --------------------------------------------------------
CREATE TABLE `visitor_table` (
  `visitor_id` INT(3) NOT NULL AUTO_INCREMENT,
  `v_name` TEXT NOT NULL,
  `v_image` TEXT NOT NULL DEFAULT 'NO IMG',
  `society_reg` INT(4) NOT NULL,
  `phone_no` BIGINT(10) NOT NULL,
  `visiting_date` DATETIME(6) NOT NULL,
  `visiting_purpose` TEXT NOT NULL,
  `flat_no` VARCHAR(9) NOT NULL,
  `status` TEXT NOT NULL,
  PRIMARY KEY (`visitor_id`),
  KEY `society_reg` (`society_reg`),
  CONSTRAINT `visitor_table_ibfk_1` FOREIGN KEY (`society_reg`) REFERENCES `admin_table` (`society_reg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into `visitor_table`
INSERT INTO `visitor_table` (`v_name`, `v_image`, `society_reg`, `phone_no`, `visiting_date`, `visiting_purpose`, `flat_no`, `status`) VALUES
('Ajay', '12.jpg', 1234, 9987685647, '2023-01-23 11:59:14 ', 'Guest', 'A101', 'Approved');

-- --------------------------------------------------------
-- AUTO_INCREMENT for `visitor_table`
-- --------------------------------------------------------
ALTER TABLE `visitor_table`
  MODIFY `visitor_id` INT(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

-- --------------------------------------------------------
-- Table structure for `event`
-- --------------------------------------------------------
CREATE TABLE `events` (
  `event_id` INT AUTO_INCREMENT PRIMARY KEY,         -- Unique event ID
  `event_title` VARCHAR(255) NOT NULL,               -- Title of the event
  `event_start` DATETIME NOT NULL,                   -- Start date and time of the event
  `event_end` DATETIME NOT NULL,                     -- End date and time of the event
  `society_reg` INT NOT NULL,                        -- Society registration ID
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp of when the event was created
  FOREIGN KEY (`society_reg`) REFERENCES admin_table(`society_reg`) -- Foreign key reference to society
);


INSERT INTO `events` (`event_title`, `event_start`, `event_end`, `society_reg`)
VALUES
('Community Meeting', '2024-12-30 10:00:00', '2024-12-30 12:00:00', 1234),
('Annual General Meeting', '2025-01-15 17:00:00', '2025-01-15 19:00:00', 1234);

COMMIT;
