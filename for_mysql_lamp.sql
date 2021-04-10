-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 10, 2021 at 07:54 AM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

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
  `employee_id` int NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `middle_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `job_type` varchar(2) NOT NULL DEFAULT 'FT',
  `date_of_birth` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `date_hired` date NOT NULL,
  `hired_salary_level` int NOT NULL DEFAULT '1',
  `last_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_user_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_files`
--

DROP TABLE IF EXISTS `employee_files`;
CREATE TABLE `employee_files` (
  `file_id` int NOT NULL,
  `file_name` varchar(27) NOT NULL,
  `last_update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

DROP TABLE IF EXISTS `salaries`;
CREATE TABLE `salaries` (
  `salary_level` int NOT NULL,
  `effective_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `salary_per_annum` decimal(13,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`salary_level`, `effective_date`, `end_date`, `salary_per_annum`) VALUES
(1, '1900-01-01 00:00:00', '2017-12-31 00:00:00', '60000.00'),
(1, '2018-01-01 00:00:00', '2020-03-13 00:00:00', '61200.00'),
(1, '2020-03-14 00:00:00', '2020-12-31 00:00:00', '62730.00'),
(1, '2021-01-01 00:00:00', '2021-12-31 00:00:00', '63357.30'),
(2, '1900-01-01 00:00:00', '2017-12-31 00:00:00', '62000.00'),
(2, '2018-01-01 00:00:00', '2020-03-13 00:00:00', '63240.00'),
(2, '2020-03-14 00:00:00', '2020-12-31 00:00:00', '64821.00'),
(2, '2021-01-01 00:00:00', '2021-12-31 00:00:00', '65469.21'),
(3, '1900-01-01 00:00:00', '2017-12-31 00:00:00', '64000.00'),
(3, '2018-01-01 00:00:00', '2020-03-13 00:00:00', '65280.00'),
(3, '2020-03-14 00:00:00', '2020-12-31 00:00:00', '66912.00'),
(3, '2021-01-01 00:00:00', '2021-12-31 00:00:00', '67581.12'),
(4, '1900-01-01 00:00:00', '2017-12-31 00:00:00', '66000.00'),
(4, '2018-01-01 00:00:00', '2020-03-13 00:00:00', '67320.00'),
(4, '2020-03-14 00:00:00', '2020-12-31 00:00:00', '69003.00'),
(4, '2021-01-01 00:00:00', '2021-12-31 00:00:00', '69693.03'),
(5, '1900-01-01 00:00:00', '2017-12-31 00:00:00', '68000.00'),
(5, '2018-01-01 00:00:00', '2020-03-13 00:00:00', '69360.00'),
(5, '2020-03-14 00:00:00', '2020-12-31 00:00:00', '71094.00'),
(5, '2021-01-01 00:00:00', '2021-12-31 00:00:00', '71804.94'),
(6, '1900-01-01 00:00:00', '2017-12-31 00:00:00', '70000.00'),
(6, '2018-01-01 00:00:00', '2020-03-13 00:00:00', '71400.00'),
(6, '2020-03-14 00:00:00', '2020-12-31 00:00:00', '73185.00'),
(6, '2021-01-01 00:00:00', '2021-12-31 00:00:00', '73916.85'),
(7, '1900-01-01 00:00:00', '2017-12-31 00:00:00', '72000.00'),
(7, '2018-01-01 00:00:00', '2020-03-13 00:00:00', '73440.00'),
(7, '2020-03-14 00:00:00', '2020-12-31 00:00:00', '75276.00'),
(7, '2021-01-01 00:00:00', '2021-12-31 00:00:00', '76028.76'),
(8, '1900-01-01 00:00:00', '2017-12-31 00:00:00', '74000.00'),
(8, '2018-01-01 00:00:00', '2020-03-13 00:00:00', '75480.00'),
(8, '2020-03-14 00:00:00', '2020-12-31 00:00:00', '77367.00'),
(8, '2021-01-01 00:00:00', '2021-12-31 00:00:00', '78140.67'),
(9, '1900-01-01 00:00:00', '2017-12-31 00:00:00', '76000.00'),
(9, '2018-01-01 00:00:00', '2020-03-13 00:00:00', '77520.00'),
(9, '2020-03-14 00:00:00', '2020-12-31 00:00:00', '79458.00'),
(9, '2021-01-01 00:00:00', '2021-12-31 00:00:00', '80252.58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`salary_level`,`end_date`);
COMMIT;
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `password`, `address`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', '');

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
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`salary_level`,`end_date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_files`
--
ALTER TABLE `employee_files`
  MODIFY `file_id` int NOT NULL AUTO_INCREMENT;
COMMIT;
