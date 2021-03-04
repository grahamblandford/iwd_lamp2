-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 06, 2021 at 02:00 AM
-- Server version: 10.3.25-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lamp`
--
CREATE DATABASE IF NOT EXISTS `lamp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lamp`;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NULL,
  `last_name` varchar(50) NOT NULL,
  `job_type` varchar(2) NOT NULL DEFAULT 'FT',
  `date_of_birth` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `date_hired` date NOT NULL,
  `hired_salary_level` int(11) NOT NULL DEFAULT 1,
  `last_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `last_updated_user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee_files`
--

DROP TABLE IF EXISTS `employee_files`;
CREATE TABLE `employee_files` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(27) NOT NULL,
  `last_update_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_files`
--
ALTER TABLE `employee_files`
  ADD PRIMARY KEY (`file_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_files`
--
ALTER TABLE `employee_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;


DROP USER IF EXISTS `lamp`;

GRANT USAGE ON *.* TO `lamp`@`%` IDENTIFIED BY PASSWORD '*35C8523607F9FDC4AF8B9618CF953EEEFD83275B';

GRANT ALL PRIVILEGES ON `lamp`.* TO `lamp`@`%`;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
