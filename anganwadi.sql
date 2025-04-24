-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 12:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anganwadi`
--

-- --------------------------------------------------------

--
-- Table structure for table `above_60_dashboard`
--

CREATE TABLE `above_60_dashboard` (
  `id` int(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `guardian` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `birth_certificate` varchar(255) NOT NULL,
  `aadhaar` varchar(255) NOT NULL,
  `ration_card` varchar(255) NOT NULL,
  `bank_passbook` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `above_60_dashboard`
--

INSERT INTO `above_60_dashboard` (`id`, `name`, `email`, `password`, `guardian`, `address`, `phone`, `dob`, `birth_certificate`, `aadhaar`, `ration_card`, `bank_passbook`, `reg_date`) VALUES
(1, 'aa', 'aa@aa', '$2y$10$8vnOo4AF5mA8iESCVpdwOOkkJhnxx7IFK627G2y5D8gSiQdY6SJxK', 'bb', 'cc', '5953265562', '1945-06-07', 'uploads/cen1.jpg', 'uploads/cen2.jpg', 'uploads/cen3.jpg', 'uploads/cen4.jpg', '2024-11-06 16:46:49'),
(2, 'kumar', 'kumar@gmail.com', '$2y$10$8SRr8/yhcC5PWUDY37cr3OGEzWSnMlzQ3y1aWOkuUPrsmXhkrnrke', 'sdadsd', 'pondy', '9342481144', '1953-06-09', 'uploads/cen2.jpg', '5684231589', 'uploads/pback.jpg', 'uploads/pback2.jpg', '2024-11-06 17:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`id`, `name`, `date`, `status`) VALUES
(1, 'Keerthi v', '2024-09-20', 'Absent'),
(2, 'swetha', '2024-09-20', 'Present'),
(3, 'priya', '2024-10-24', 'Present'),
(4, 'aa', '2024-11-03', 'Present'),
(5, 'kalai', '2024-11-08', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `camp_details`
--

CREATE TABLE `camp_details` (
  `id` int(11) NOT NULL,
  `camp_name` varchar(255) NOT NULL,
  `camp_location` varchar(255) NOT NULL,
  `camp_date` date NOT NULL,
  `status` enum('Saved','Submitted','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `camp_details`
--

INSERT INTO `camp_details` (`id`, `camp_name`, `camp_location`, `camp_date`, `status`) VALUES
(8, 'eye', 'saram', '2024-11-12', 'Submitted');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `child_id` int(11) NOT NULL,
  `child_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','','') NOT NULL,
  `height` decimal(5,2) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `birth_certificate` enum('Birth Certificate','','','') NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`child_id`, `child_name`, `date_of_birth`, `age`, `gender`, `height`, `weight`, `birth_certificate`, `parent_id`) VALUES
(7, 'Keerthana', '2002-10-19', 21, 'Female', '6.20', '50.00', '', 3),
(8, 'Megha', '2022-06-21', 2, 'Female', '1.50', '15.00', '', 11),
(9, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 13),
(10, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 14),
(11, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 15),
(12, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 16),
(13, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 17),
(14, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 18),
(15, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 19),
(16, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 20),
(17, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 21),
(18, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 22),
(19, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 23),
(20, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 24),
(21, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 25),
(22, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 26),
(23, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 27),
(24, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 28),
(25, 'avhdio', '2024-10-01', 23, 'Male', '5.00', '5.00', '', 29),
(26, 'avhdio', '2024-10-16', 23, 'Male', '5.00', '5.00', '', 34),
(27, 'avhdio', '2024-10-25', -1, 'Male', '5.00', '5.00', '', 35),
(28, 'avhdio', '2024-10-25', -1, 'Male', '5.00', '5.00', '', 36),
(29, '', '2023-06-06', 1, 'Male', '5.00', '8.00', '', 37);

-- --------------------------------------------------------

--
-- Table structure for table `daily_updates_db`
--

CREATE TABLE `daily_updates_db` (
  `id` int(11) NOT NULL,
  `update_text` text NOT NULL,
  `status` enum('Posted','Saved','','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daily_updates_db`
--

INSERT INTO `daily_updates_db` (`id`, `update_text`, `status`, `created_at`) VALUES
(3, 'rfff', 'Saved', '2024-10-02 08:10:43'),
(5, 'camp on saturday', 'Saved', '2024-10-17 16:05:05'),
(7, 'camp on monday', 'Posted', '2024-10-17 16:07:38'),
(10, 'today pooja sepcial', 'Posted', '2024-11-08 07:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `document_type` enum('Birth Certificate','Bank Passbook','','') NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `parent_id`, `document_type`, `file_path`) VALUES
(1, 3, 'Birth Certificate', 'uploads/profile.png'),
(6, 10, '', 'uploads/staffbg3.jpg'),
(7, 10, 'Bank Passbook', 'uploads/staffbg1.jpg'),
(8, 11, 'Birth Certificate', 'uploads/b3.jpg'),
(9, 12, '', 'uploads/pback.jpg'),
(10, 12, 'Bank Passbook', 'uploads/logo3.jpg'),
(11, 13, 'Birth Certificate', 'uploads/logo3.jpg'),
(12, 14, 'Birth Certificate', 'uploads/logo3.jpg'),
(13, 15, 'Birth Certificate', 'uploads/logo3.jpg'),
(14, 16, 'Birth Certificate', 'uploads/logo3.jpg'),
(15, 17, 'Birth Certificate', 'uploads/logo3.jpg'),
(16, 18, 'Birth Certificate', 'uploads/logo3.jpg'),
(17, 19, 'Birth Certificate', 'uploads/logo3.jpg'),
(18, 20, 'Birth Certificate', 'uploads/logo3.jpg'),
(19, 21, 'Birth Certificate', 'uploads/logo3.jpg'),
(20, 22, 'Birth Certificate', 'uploads/logo3.jpg'),
(21, 23, 'Birth Certificate', 'uploads/logo3.jpg'),
(22, 24, 'Birth Certificate', 'uploads/logo3.jpg'),
(23, 25, 'Birth Certificate', 'uploads/logo3.jpg'),
(24, 26, 'Birth Certificate', 'uploads/logo3.jpg'),
(25, 27, 'Birth Certificate', 'uploads/logo3.jpg'),
(26, 28, 'Birth Certificate', 'uploads/logo3.jpg'),
(27, 29, 'Birth Certificate', 'uploads/logo3.jpg'),
(28, 30, '', 'uploads/pback.jpg'),
(29, 30, 'Bank Passbook', 'uploads/logo3.jpg'),
(30, 31, '', 'uploads/pback.jpg'),
(31, 31, 'Bank Passbook', 'uploads/pback.jpg'),
(32, 32, '', 'uploads/pback2.jpg'),
(33, 32, 'Bank Passbook', 'uploads/pback.jpg'),
(34, 33, '', 'uploads/pback2.jpg'),
(35, 33, 'Bank Passbook', 'uploads/pback2.jpg'),
(36, 34, 'Birth Certificate', 'uploads/t2.webp'),
(37, 35, 'Birth Certificate', 'uploads/pback.jpg'),
(38, 36, 'Birth Certificate', 'uploads/pback.jpg'),
(39, 37, 'Birth Certificate', 'uploads/t3.webp');

-- --------------------------------------------------------

--
-- Table structure for table `family_head_woman_dashboard`
--

CREATE TABLE `family_head_woman_dashboard` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `husband_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `native_place` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `ration_card_color` enum('red','yellow','','') NOT NULL,
  `birth_certificate` varchar(255) NOT NULL,
  `family_photo` varchar(255) NOT NULL,
  `bank_passbook` varchar(255) NOT NULL,
  `annual_income_certificate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `family_head_woman_dashboard`
--

INSERT INTO `family_head_woman_dashboard` (`id`, `name`, `occupation`, `husband_name`, `email`, `password`, `address`, `native_place`, `phone`, `ration_card_color`, `birth_certificate`, `family_photo`, `bank_passbook`, `annual_income_certificate`) VALUES
(1, 'priya', 'house wife', 'raja', 'priya@gmail.com', '$2y$10$./50Xk6ZdaXuqweo1Tr/9OEWf3rNzQDwyuAvY0b6683LYbMcEBc3q', 'pondy', 'pondy', '9080706050', 'yellow', 'uploads/logo3.jpg', 'uploads/pback.jpg', 'uploads/pback2.jpg', 'uploads/logo2.png'),
(2, 'banu', 'house wife', 'abi', 'banu@gmail.com', '$2y$10$tCGvR0KCInLACAM6graO8eT1Hs4goxd2vVOpiGiP4cD6jnk2EFwWK', 'pondy', 'pondy', '9342481144', 'yellow', 'uploads/SIGNUP.jpeg', 'uploads/LOGIN.jpeg', 'uploads/logo2.png', 'uploads/logo2.png'),
(3, 'kavitha', 'house wife', 'mani', 'kavitha@gmail.com', '$2y$10$ZCvGMsQwU71DwXbvH6px8u1K.dyWXlEtLYayQ1H0r4Ig/7XNqRW4G', 'pondy', 'pondy', '9342481144', 'red', 'uploads/pback4.jpg', 'uploads/pback2.jpg', 'uploads/profile1.png', 'uploads/logo2.png'),
(4, 'banu', 'house wife', 'abi', 'banu@gmail.com', '$2y$10$urpdJ4MERWNBeWN7eSRQnu6rniX6MKCD7CHHbwoooLsaFKoQDYmpu', 'pondy', 'pondy', '9342481144', 'yellow', 'uploads/pback.jpg', 'uploads/cen2.jpg', 'uploads/cen1.jpg', 'no_file'),
(5, 'aa', 'bb', 'cc', 'aa@aa', '$2y$10$aF0fiDA0cbn3vVte0scbgOkysdSv3hZGomzQzFfdb6ZI/FlSeLVgK', 'dd', 'ee', '6562823205', 'red', 'uploads/cen1.jpg', 'uploads/logo3.jpg', 'uploads/daily.jpg', 'no_file');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FED_ID` int(11) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `COMMENT` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FED_ID`, `EMAIL`, `COMMENT`) VALUES
(11, 'keerthanav1910@gmail.com', 'good job'),
(12, 'ravi@gmail.com', 'good job');

-- --------------------------------------------------------

--
-- Table structure for table `fhw_temp`
--

CREATE TABLE `fhw_temp` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `husband_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `native_place` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `ration_card_color` enum('red','yellow','','') NOT NULL,
  `birth_certificate` varchar(255) NOT NULL,
  `family_photo` varchar(255) NOT NULL,
  `bank_passbook` varchar(255) NOT NULL,
  `annual_income_certificate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fhw_temp`
--

INSERT INTO `fhw_temp` (`id`, `name`, `occupation`, `husband_name`, `email`, `password`, `address`, `native_place`, `phone`, `ration_card_color`, `birth_certificate`, `family_photo`, `bank_passbook`, `annual_income_certificate`) VALUES
(1, 'priya', 'house wife', 'raja', 'priya@gmail.com', '$2y$10$./50Xk6ZdaXuqweo1Tr/9OEWf3rNzQDwyuAvY0b6683LYbMcEBc3q', 'pondy', 'pondy', '9080706050', 'yellow', 'uploads/logo3.jpg', 'uploads/pback.jpg', 'uploads/pback2.jpg', 'uploads/logo2.png'),
(2, 'banu', 'house wife', 'abi', 'banu@gmail.com', '$2y$10$tCGvR0KCInLACAM6graO8eT1Hs4goxd2vVOpiGiP4cD6jnk2EFwWK', 'pondy', 'pondy', '9342481144', 'yellow', 'uploads/SIGNUP.jpeg', 'uploads/LOGIN.jpeg', 'uploads/logo2.png', 'uploads/logo2.png'),
(3, 'kavitha', 'house wife', 'mani', 'kavitha@gmail.com', '$2y$10$ZCvGMsQwU71DwXbvH6px8u1K.dyWXlEtLYayQ1H0r4Ig/7XNqRW4G', 'pondy', 'pondy', '9342481144', 'red', 'uploads/pback4.jpg', 'uploads/pback2.jpg', 'uploads/profile1.png', 'uploads/logo2.png'),
(4, 'banu', 'house wife', 'abi', 'banu@gmail.com', '$2y$10$urpdJ4MERWNBeWN7eSRQnu6rniX6MKCD7CHHbwoooLsaFKoQDYmpu', 'pondy', 'pondy', '9342481144', 'yellow', 'uploads/pback.jpg', 'uploads/cen2.jpg', 'uploads/cen1.jpg', 'no_file');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

CREATE TABLE `meals` (
  `id` int(11) NOT NULL,
  `update_text` text NOT NULL,
  `status` enum('Posted','Saved','','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `update_text`, `status`, `created_at`) VALUES
(5, 'egg 2', 'Posted', '2024-10-24 15:47:23'),
(6, 'pudina rice', 'Posted', '2024-11-03 12:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `message`, `created_at`) VALUES
(1, 'Time for the first vaccination!', '2024-10-07 04:23:14'),
(2, 'Time for the first vaccination!', '2024-10-07 04:23:14'),
(3, 'Time for the first vaccination!', '2024-10-07 04:24:20'),
(4, 'Time for the first vaccination!', '2024-10-07 04:24:20'),
(5, 'Time for the first vaccination!', '2024-10-07 04:25:01'),
(6, 'Time for the first vaccination!', '2024-10-07 04:25:01'),
(7, 'Time for the first vaccination!', '2024-10-07 04:36:54'),
(8, 'Time for the first vaccination!', '2024-10-07 04:36:54'),
(9, 'Time for the first vaccination!', '2024-10-07 04:37:20'),
(10, 'Time for the first vaccination!', '2024-10-07 04:37:20'),
(11, 'Time for the first vaccination!', '2024-10-07 04:50:31'),
(12, 'Time for the first vaccination!', '2024-10-07 04:50:31'),
(13, 'Time for the first vaccination!', '2024-10-07 04:53:37'),
(14, 'Time for the first vaccination!', '2024-10-07 04:53:37'),
(15, 'Time for the first vaccination!', '2024-10-07 04:55:10'),
(16, 'Time for the first vaccination!', '2024-10-07 04:55:10'),
(17, 'Time for the first vaccination!', '2024-10-07 05:55:15'),
(18, 'Time for the first vaccination!', '2024-10-07 05:55:15'),
(19, 'Time for the first vaccination!', '2024-10-08 04:40:30'),
(20, 'Time for the first vaccination!', '2024-10-08 04:40:30'),
(21, 'Time for the first vaccination!', '2024-10-08 04:54:54'),
(22, 'Time for the first vaccination!', '2024-10-08 04:54:54'),
(23, 'Time for the first vaccination!', '2024-10-08 04:58:37'),
(24, 'Time for the first vaccination!', '2024-10-08 04:58:37'),
(25, 'Time for the first vaccination!', '2024-10-18 05:57:13'),
(26, 'Time for the first vaccination!', '2024-10-18 05:57:13'),
(27, 'Time for the first vaccination!', '2024-10-18 05:57:21'),
(28, 'Time for the first vaccination!', '2024-10-18 05:57:21'),
(29, 'Time for the first vaccination!', '2024-10-22 05:59:10'),
(30, 'Time for the first vaccination!', '2024-10-22 05:59:10'),
(31, 'Time for the first vaccination!', '2024-10-22 06:03:11'),
(32, 'Time for the first vaccination!', '2024-10-22 06:03:11'),
(33, 'Time for the first vaccination!', '2024-10-22 06:03:18'),
(34, 'Time for the first vaccination!', '2024-10-22 06:03:18'),
(35, 'Time for the first vaccination!', '2024-10-22 06:04:29'),
(36, 'Time for the first vaccination!', '2024-10-22 06:04:29'),
(37, 'Time for the first vaccination!', '2024-10-23 05:09:28'),
(38, 'Time for the first vaccination!', '2024-10-23 05:09:28'),
(39, 'Time for the first vaccination!', '2024-10-23 05:41:49'),
(40, 'Time for the first vaccination!', '2024-10-23 05:41:49'),
(41, 'Time for the first vaccination!', '2024-10-23 05:41:58'),
(42, 'Time for the first vaccination!', '2024-10-23 05:41:58'),
(43, 'Time for the first vaccination!', '2024-10-23 05:44:25'),
(44, 'Time for the first vaccination!', '2024-10-23 05:44:25'),
(45, 'Time for the first vaccination!', '2024-10-23 05:45:46'),
(46, 'Time for the first vaccination!', '2024-10-23 05:45:46'),
(47, 'Time for the first vaccination!', '2024-10-23 05:45:57'),
(48, 'Time for the first vaccination!', '2024-10-23 05:45:57'),
(49, 'Time for the first vaccination!', '2024-10-23 05:55:21'),
(50, 'Time for the first vaccination!', '2024-10-23 05:55:21'),
(51, 'Time for the first vaccination!', '2024-10-23 05:56:10'),
(52, 'Time for the first vaccination!', '2024-10-23 05:56:10'),
(53, 'Time for the first vaccination!', '2024-10-23 05:57:37'),
(54, 'Time for the first vaccination!', '2024-10-23 05:57:37'),
(55, 'Time for the first vaccination!', '2024-10-23 05:57:55'),
(56, 'Time for the first vaccination!', '2024-10-23 05:57:55'),
(57, 'Time for the first vaccination!', '2024-10-23 05:59:06'),
(58, 'Time for the first vaccination!', '2024-10-23 05:59:06'),
(59, 'Time for the first vaccination!', '2024-10-23 06:25:26'),
(60, 'Time for the first vaccination!', '2024-10-23 06:25:26'),
(61, 'Time for the first vaccination!', '2024-10-23 06:26:50'),
(62, 'Time for the first vaccination!', '2024-10-23 06:26:50'),
(63, 'Time for the first vaccination!', '2024-10-23 06:34:58'),
(64, 'Time for the first vaccination!', '2024-10-23 06:34:58'),
(65, 'Time for the first vaccination!', '2024-10-23 16:22:08'),
(66, 'Time for the first vaccination!', '2024-10-23 16:22:08'),
(67, 'Time for the first vaccination!', '2024-11-06 06:28:05'),
(68, 'Time for the first vaccination!', '2024-11-06 06:28:05'),
(69, 'Time for the first vaccination!', '2024-11-06 16:18:19'),
(70, 'Time for the first vaccination!', '2024-11-06 16:18:19'),
(71, 'Time for the first vaccination!', '2024-11-06 17:52:08'),
(72, 'Time for the first vaccination!', '2024-11-06 17:52:08'),
(73, 'Time for the first vaccination!', '2024-11-06 17:59:41'),
(74, 'Time for the first vaccination!', '2024-11-06 17:59:41'),
(75, 'Time for the first vaccination!', '2024-11-08 07:43:45'),
(76, 'Time for the first vaccination!', '2024-11-08 07:43:45'),
(77, 'Time for the first vaccination!', '2024-11-08 07:51:14'),
(78, 'Time for the first vaccination!', '2024-11-08 07:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `parent_temp`
--

CREATE TABLE `parent_temp` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `husband_name` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `phone_no` varchar(10) NOT NULL,
  `photo` blob NOT NULL,
  `native_place` varchar(100) NOT NULL,
  `aadhar_no` varchar(20) NOT NULL,
  `pregnancy_status` tinyint(1) NOT NULL,
  `pregnancy_month` int(11) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `bank_passbook` blob NOT NULL,
  `child_count` int(11) NOT NULL,
  `child_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`child_details`)),
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_temp`
--

INSERT INTO `parent_temp` (`id`, `name`, `husband_name`, `address`, `phone_no`, `photo`, `native_place`, `aadhar_no`, `pregnancy_status`, `pregnancy_month`, `pincode`, `bank_passbook`, `child_count`, `child_details`, `email`, `password`) VALUES
(1, 'amudha', 'mani', 'pondy', '9789182218', 0x75706c6f6164732f70686f746f732f36373239656435633166376130392e32353734313835342e6a706567, 'pondy', '012365248795', 1, 5, '', 0x75706c6f6164732f62616e6b5f70617373626f6f6b2f36373131663831373862646230342e38323035323337312e6a7067, 1, '0', '0', '$2y$10$rtUkJnInbEo47L5GjfBThOFzSFPXvglgzMB8joKhz.kY1RRaF9RwG'),
(2, 'raji', 'kumaran', 'saram', '6352485412', 0x75706c6f6164732f70686f746f732f36373262393566343661646564342e31313536363537392e6a7067, 'tamil nadu', '235648974120', 0, 0, '', '', 2, '0', 'raji@gmail.com', '$2y$10$2pG0OcUa73HiJhBrxjHZVetti30tK1KQOSbYfmlp3jeFtCk/JNp9e'),
(4, 'raji', 'kumaran', 'saram', '6352485412', 0x75706c6f6164732f70686f746f732f36373262393566343661646564342e31313536363537392e6a7067, 'tamil nadu', '325641000854', 0, 0, '', '', 2, '0', 'raji@gmail.com', '$2y$10$ca4Hlj4rclaaLJo5Etcl4OfTXS1iAf4CaoFfy4.hKKJepTvK2ziSK'),
(5, 'vijula', 'shiva', 'Karunagara Pillai street', '9342481144', 0x75706c6f6164732f70686f746f732f63656e322e6a7067, 'pondy', '253410398006', 0, 0, '', '', 1, '0', 'vijula@gmail.com', '$2y$10$DUeiO7/tuL8ppkS1IRJTnOMBs1Gj3a.dcjMy6rsfNmEGY8oP0eVDy'),
(6, 'vimala', 'kumaran', 'saram', '6352485412', 0x75706c6f6164732f70686f746f732f6c6f676f332e6a7067, 'pondy', '652314002598', 0, 0, '', '', 1, '0', 'vimala@gmail.com', '$2y$10$e7gSUKEYYzmDGQNIVuB1ReisvO4IJwC54N4LDvuDs.Q19cEMiHxbe'),
(7, 'muthu', 'mari', 'saram', '6253418547', 0x75706c6f6164732f70686f746f732f6c6f676f332e6a7067, 'tamilnadu', '302564100854', 0, 0, '', '', 4, '0', '0', '$2y$10$A9kUkWJpkks.P3s8C2xE/eDcFbul60qB9dkFUfPkEnW8HH/rVdhDu'),
(8, 'mani', 'martin', 'rajanagar', '8532410235', 0x75706c6f6164732f70686f746f732f706261636b2e6a7067, 'tamil nadu', '501243612503', 1, 8, '', 0x75706c6f6164732f62616e6b5f70617373626f6f6b2f63656e322e6a7067, 0, '0', 'mani@gmail.com', '$2y$10$eqrQMrTA5IpDWOoqbn9rkOuqzeEI.AVHsUWrPjKRwMBUv.CzzD4VS'),
(9, 'virchu', 'vanan', 'dss', '5236412854', 0x75706c6f6164732f70686f746f732f706261636b2e6a7067, 'das', '985641230741', 1, 4, '', 0x75706c6f6164732f62616e6b5f70617373626f6f6b2f706261636b2e6a7067, 0, '0', 'virchu@gmail.com', '$2y$10$hcuBTlrzekESglxJYVSe5.TZyX5SAybvADViHcRrLZPhVjx6vCI7C');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` int(11) NOT NULL,
  `query_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `husband_name` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `phone_no` varchar(10) NOT NULL,
  `photo` blob NOT NULL,
  `native_place` varchar(100) NOT NULL,
  `aadhar_no` varchar(20) NOT NULL,
  `pregnancy_status` tinyint(1) NOT NULL,
  `pregnancy_month` int(11) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `bank_passbook` blob NOT NULL,
  `child_count` int(11) NOT NULL,
  `child_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`child_details`)),
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `name`, `husband_name`, `address`, `phone_no`, `photo`, `native_place`, `aadhar_no`, `pregnancy_status`, `pregnancy_month`, `pincode`, `bank_passbook`, `child_count`, `child_details`, `email`, `password`) VALUES
(1, 'amudha', 'mani', 'pondy', '9789182218', 0x75706c6f6164732f70686f746f732f36373239656435633166376130392e32353734313835342e6a706567, 'pondy', '012365248795', 1, 5, '', 0x75706c6f6164732f62616e6b5f70617373626f6f6b2f36373131663831373862646230342e38323035323337312e6a7067, 1, '0', '0', '$2y$10$rtUkJnInbEo47L5GjfBThOFzSFPXvglgzMB8joKhz.kY1RRaF9RwG'),
(2, 'raji', 'kumaran', 'saram', '6352485412', 0x75706c6f6164732f70686f746f732f36373262393566343661646564342e31313536363537392e6a7067, 'tamil nadu', '235648974120', 0, 0, '', '', 2, '0', 'raji@gmail.com', '$2y$10$2pG0OcUa73HiJhBrxjHZVetti30tK1KQOSbYfmlp3jeFtCk/JNp9e'),
(4, 'raji', 'kumaran', 'saram', '6352485412', 0x75706c6f6164732f70686f746f732f36373262393566343661646564342e31313536363537392e6a7067, 'tamil nadu', '325641000854', 0, 0, '', '', 2, '0', 'raji@gmail.com', '$2y$10$ca4Hlj4rclaaLJo5Etcl4OfTXS1iAf4CaoFfy4.hKKJepTvK2ziSK'),
(5, 'vijula', 'shiva', 'Karunagara Pillai street', '9342481144', 0x75706c6f6164732f70686f746f732f63656e322e6a7067, 'pondy', '253410398006', 0, 0, '', '', 1, '0', 'vijula@gmail.com', '$2y$10$DUeiO7/tuL8ppkS1IRJTnOMBs1Gj3a.dcjMy6rsfNmEGY8oP0eVDy'),
(6, 'vimala', 'kumaran', 'saram', '6352485412', 0x75706c6f6164732f70686f746f732f6c6f676f332e6a7067, 'pondy', '652314002598', 0, 0, '', '', 1, '0', 'vimala@gmail.com', '$2y$10$e7gSUKEYYzmDGQNIVuB1ReisvO4IJwC54N4LDvuDs.Q19cEMiHxbe'),
(7, 'muthu', 'mari', 'saram', '6253418547', 0x75706c6f6164732f70686f746f732f6c6f676f332e6a7067, 'tamilnadu', '302564100854', 0, 0, '', '', 4, '0', '0', '$2y$10$A9kUkWJpkks.P3s8C2xE/eDcFbul60qB9dkFUfPkEnW8HH/rVdhDu'),
(8, 'mani', 'martin', 'rajanagar', '8532410235', 0x75706c6f6164732f70686f746f732f706261636b2e6a7067, 'tamil nadu', '501243612503', 1, 8, '', 0x75706c6f6164732f62616e6b5f70617373626f6f6b2f63656e322e6a7067, 0, '0', 'mani@gmail.com', '$2y$10$eqrQMrTA5IpDWOoqbn9rkOuqzeEI.AVHsUWrPjKRwMBUv.CzzD4VS'),
(9, 'aa', 'bb', 'cc', '5595626255', 0x75706c6f6164732f70686f746f732f63656e312e6a7067, 'aa', '456265845232', 0, 0, '', '', 1, '0', 'aa@aa', '$2y$10$nMwkY3R9fHkceKWxS7SZOOKi.zHluI5C34y4A4HlzWWs3r9YhTLxK');

-- --------------------------------------------------------

--
-- Table structure for table `schemes`
--

CREATE TABLE `schemes` (
  `id` int(11) NOT NULL,
  `scheme_name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `type` enum('parents','widow','senior_citizen','fhw') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schemes`
--

INSERT INTO `schemes` (`id`, `scheme_name`, `link`, `type`) VALUES
(2, 'aa', 'aa.com', 'parents'),
(3, 'ww', 'ww.com', 'widow'),
(4, 'ss', 'ss.com', 'senior_citizen'),
(5, 'ff', 'ff.com', 'fhw');

-- --------------------------------------------------------

--
-- Table structure for table `senior_temp`
--

CREATE TABLE `senior_temp` (
  `id` int(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `guardian` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `birth_certificate` varchar(255) NOT NULL,
  `aadhaar` varchar(255) NOT NULL,
  `ration_card` varchar(255) NOT NULL,
  `bank_passbook` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `senior_temp`
--

INSERT INTO `senior_temp` (`id`, `name`, `email`, `password`, `guardian`, `address`, `phone`, `dob`, `birth_certificate`, `aadhaar`, `ration_card`, `bank_passbook`, `reg_date`) VALUES
(1, 'aa', 'aa@aa', '$2y$10$8vnOo4AF5mA8iESCVpdwOOkkJhnxx7IFK627G2y5D8gSiQdY6SJxK', 'bb', 'cc', '5953265562', '1945-06-07', 'uploads/cen1.jpg', 'uploads/cen2.jpg', 'uploads/cen3.jpg', 'uploads/cen4.jpg', '2024-11-06 16:46:49'),
(2, 'kumar', 'kumar@gmail.com', '$2y$10$8SRr8/yhcC5PWUDY37cr3OGEzWSnMlzQ3y1aWOkuUPrsmXhkrnrke', 'sdadsd', 'pondy', '9342481144', '1953-06-09', 'uploads/cen2.jpg', '5684231589', 'uploads/pback.jpg', 'uploads/pback2.jpg', '2024-11-06 17:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `una_no` varchar(50) NOT NULL,
  `aadhar_no` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `anganwadi_address` varchar(255) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `una_no`, `aadhar_no`, `phone`, `otp`, `username`, `password`, `designation`, `department`, `dob`, `anganwadi_address`, `pincode`, `photo`, `email`) VALUES
(3, 'Keerthi V', '1575', '163549521716', '9342481144', '123', 'Keerthi@1910', '$2y$10$2VhATaeH.5Rgya8xc8R5xe.dlPEsc890doTh370hB/w2KbdpOeQ8O', 'Student', 'Cs', '2002-10-19', 'Pondy', '605013', '66e2fe03a8e0f5.00481689.jpg', ''),
(20, 'mithula', '4000', '79456123582', '9874557', '8547', 'mithula', '$2y$10$Xmww1vZH2yT83DELd.TTSu4fiNPAWCznY0n2Zh5tbCoWO7lQVbbn6', 'worker', 'section 2', '1999-02-02', 'tamilnadu', '605013', '1731219518_6729ed5c1f7a09.25741854.jpeg', 'mithula@gmail.com'),
(8, 'Keerthi v', '456', '79456123582', '09342481144', '852', 'keerthi', '$2y$10$qkb7IltpN6/xDohSpPK6DeEx.bEckgFySOvnvirPZXFHpRGtKB6vC', 'worker', 'section 2', '2024-09-09', 'pondy', '605013', '66ec5854206764.05090152.png', ''),
(21, 'badma', '456', '79456123582', '9080706050', '8547', 'Badma', '$2y$10$zqw62DvxMl0m3My2Zy83au94nrvNEzMPHeCzA5lEWJLHp6OkpJpx.', 'worker', 'section 2', '2000-06-06', 'pondy', '605013', '672f9995057581.14906566.jpg', ''),
(14, 'kani', '456', '79456123582', '9080706050', '8888', 'kani', '$2y$10$Vm0KFdLVWR5xjCzJF3Yu4.wqmCV2zCOGFlelBYwBLXZjD5bRHps0K', 'worker', 'section 2', '2012-06-05', 'pondy', '605013', '6704b96fbc6cd1.45607599.jpg', ''),
(17, 'karthiga', '524', '79456123582', '093424 81144', '85', 'karthiga', '$2y$10$5XvhMj4JYAMqmOFhnSGPUeYHTTiNVbfXXM/WbPRcteCgeH1r0cPbG', 'worker', 'section 2', '1998-06-08', 'pondy', '605013', '67189e72caf391.05466153.png', ''),
(4, 'Arun', '5431', '195623830312', '5832356753', '123', 'Arun@arun', '$2y$10$bZBCNPE1gxSxlRJ0Pr5M2eyjIpaDcINkVJ7n1leJ9/TB3FC7DfK7O', 'Developer', 'Cs', '1998-11-10', 'Pondy', '605013', '66e2ff12d59ca5.62966990.jpg', ''),
(7, 'Ms', '54820', '878412028781', '5484502821', '123', 'ms@ms', '$2y$10$NKdtthyyOFqFlzWeogKaFOFncO4ZXMMfoW0i.EyzSNBv0XfWQT8Hu', 'Developer', 'Cs', '2001-11-19', 'Pondy', '605004', '66e97e6f1e9b74.37011169.jpg', ''),
(23, 'arokya', '5496', '5246322000', '854712369', '5412', 'Arokya', '$2y$10$hKtBgbxFP8GMau1Bwh2t5u5hHyA9s3p1VXL9YJ7OkitQNvX16x8iy', 'worker', 'section 2', '1997-06-09', 'puudcherry', '605013', '1731180211_profile1.png', ''),
(1, 'Gd', '5757', '152463258495', '9585896412', '1253', 'gd@gd', '$2y$10$wqZ1eKKjgxzspIvmYpA2SO3K7P1vUi8wdAYLpzi3r4e76voO7TpQe', 'Staff', 'Cs', '2002-01-23', 'Pondy', '605004', '66e2fca8598493.65610310.jpg', ''),
(22, 'mithra', '7777', '58421635947', '8870621593', '8426', 'mithra', '$2y$10$OS3cIu1Q/0RPSmwYvriBX.RKdzXr55WeA0rL6uXSuwjWYazwXwRyu', 'worker', 'section 2', '2000-05-08', 'pondy', '605013', '672fadc3d85935.11206316.jpg', ''),
(18, 'latchi', '85247', '79456123582', '093424 81144', '8524', 'latchi', '$2y$10$nNhawYCnNBAVBRwx5fCFT.TFowRaLA1G4Tzth7Be4a2UvRiMT94/W', 'worker', 'section 2', '2024-09-29', 'pondy', '605013', '671a6db748da13.30152297.jpg', ''),
(13, 'vela', '85247', '75412896325', '2589631470', '0987', 'vela', '$2y$10$8ZKLh4K0qrNGPGAfSm.TIuS.Qk.PngjBqPZ/ZdCjQ0Ohj1awpictq', 'worker', 'section 2', '2024-09-16', 'puudcherry', '605013', '66ec71c61d61f0.16823916.jpg', ''),
(15, 'kannan', '85247', '79456123582', '9080706050', '8888', 'kannan', '$2y$10$0puiSZ5hFvEg1MsDyw4zgedCPwA3OylfbklZh5SzqQSjoHNJhbhVq', 'worker', 'section 2', '2024-10-15', 'puudcherry', '605013', '670e7702b5b375.22116806.jpg', ''),
(24, 'valvizi', '85247', '75412896325', '9080706050', '8542', 'Vel', '$2y$10$zfYgUE04Gb0mVJDie9monO1j7SjcH7ijvcts8Ks87XTgjeohIXKS.', 'worker', 'section 2', '1996-06-04', 'puudcherry', '605013', '673050caa57467.37837994.png', 'vel@gmail.com'),
(16, 'amala', '85247', '79456123582', '9342481144', '8524', 'amala', '$2y$10$G.yztvd5xOrMXgz79fyj4e8DeFY7hxd/ecFgNQu054M3c5BVxixrq', 'worker', 'section 2', '2000-06-06', 'pondy', '605013', '6711f8178bdb04.82052371.jpg', ''),
(19, 'ishu', '85247', '79456123582', '9874557', '74125', 'ishu', '$2y$10$C3uA8JIAo1zgFo0/9yJ6TOOb/zR16RvBJnKfsUd1DNc6lq8LAX2iG', 'worker', 'section 2', '2001-06-05', 'puudcherry', '605013', '672235be10ee93.98532012.jpg', ''),
(6, 'paravathi', '8541', '622151542819', '8482491325', '123', 'gs@gs', '$2y$10$LkZN362fLLvzw7pLaNBil.UY/5Lq.A2hyI3FJZkDgUGwo/170CEua', 'healper', 'section 3', '2004-02-15', 'Pondy', '605004', '66e30259dbb871.37624612.jpg', 'parvathi@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `staff_temp`
--

CREATE TABLE `staff_temp` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `una_no` varchar(50) NOT NULL,
  `aadhar_no` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `anganwadi_address` varchar(255) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_temp`
--

INSERT INTO `staff_temp` (`id`, `name`, `una_no`, `aadhar_no`, `phone`, `otp`, `username`, `password`, `designation`, `department`, `dob`, `anganwadi_address`, `pincode`, `photo`, `email`) VALUES
(3, 'Keerthi V', '1575', '163549521716', '9342481144', '123', 'Keerthi@1910', '$2y$10$2VhATaeH.5Rgya8xc8R5xe.dlPEsc890doTh370hB/w2KbdpOeQ8O', 'Student', 'Cs', '2002-10-19', 'Pondy', '605013', '66e2fe03a8e0f5.00481689.jpg', ''),
(20, 'mithula', '4000', '79456123582', '9874557', '8547', 'mithula', '$2y$10$Xmww1vZH2yT83DELd.TTSu4fiNPAWCznY0n2Zh5tbCoWO7lQVbbn6', 'worker', 'section 2', '1999-02-02', 'tamilnadu', '605013', '1731219518_6729ed5c1f7a09.25741854.jpeg', 'mithula@gmail.com'),
(8, 'Keerthi v', '456', '79456123582', '09342481144', '852', 'keerthi', '$2y$10$qkb7IltpN6/xDohSpPK6DeEx.bEckgFySOvnvirPZXFHpRGtKB6vC', 'worker', 'section 2', '2024-09-09', 'pondy', '605013', '66ec5854206764.05090152.png', ''),
(21, 'badma', '456', '79456123582', '9080706050', '8547', 'Badma', '$2y$10$zqw62DvxMl0m3My2Zy83au94nrvNEzMPHeCzA5lEWJLHp6OkpJpx.', 'worker', 'section 2', '2000-06-06', 'pondy', '605013', '672f9995057581.14906566.jpg', ''),
(14, 'kani', '456', '79456123582', '9080706050', '8888', 'kani', '$2y$10$Vm0KFdLVWR5xjCzJF3Yu4.wqmCV2zCOGFlelBYwBLXZjD5bRHps0K', 'worker', 'section 2', '2012-06-05', 'pondy', '605013', '6704b96fbc6cd1.45607599.jpg', ''),
(17, 'karthiga', '524', '79456123582', '093424 81144', '85', 'karthiga', '$2y$10$5XvhMj4JYAMqmOFhnSGPUeYHTTiNVbfXXM/WbPRcteCgeH1r0cPbG', 'worker', 'section 2', '1998-06-08', 'pondy', '605013', '67189e72caf391.05466153.png', ''),
(4, 'Arun', '5431', '195623830312', '5832356753', '123', 'Arun@arun', '$2y$10$bZBCNPE1gxSxlRJ0Pr5M2eyjIpaDcINkVJ7n1leJ9/TB3FC7DfK7O', 'Developer', 'Cs', '1998-11-10', 'Pondy', '605013', '66e2ff12d59ca5.62966990.jpg', ''),
(7, 'Ms', '54820', '878412028781', '5484502821', '123', 'ms@ms', '$2y$10$NKdtthyyOFqFlzWeogKaFOFncO4ZXMMfoW0i.EyzSNBv0XfWQT8Hu', 'Developer', 'Cs', '2001-11-19', 'Pondy', '605004', '66e97e6f1e9b74.37011169.jpg', ''),
(23, 'arokya', '5496', '5246322000', '854712369', '5412', 'Arokya', '$2y$10$hKtBgbxFP8GMau1Bwh2t5u5hHyA9s3p1VXL9YJ7OkitQNvX16x8iy', 'worker', 'section 2', '1997-06-09', 'puudcherry', '605013', '1731180211_profile1.png', ''),
(1, 'Gd', '5757', '152463258495', '9585896412', '1253', 'gd@gd', '$2y$10$wqZ1eKKjgxzspIvmYpA2SO3K7P1vUi8wdAYLpzi3r4e76voO7TpQe', 'Staff', 'Cs', '2002-01-23', 'Pondy', '605004', '66e2fca8598493.65610310.jpg', ''),
(22, 'mithra', '7777', '58421635947', '8870621593', '8426', 'mithra', '$2y$10$OS3cIu1Q/0RPSmwYvriBX.RKdzXr55WeA0rL6uXSuwjWYazwXwRyu', 'worker', 'section 2', '2000-05-08', 'pondy', '605013', '672fadc3d85935.11206316.jpg', ''),
(18, 'latchi', '85247', '79456123582', '093424 81144', '8524', 'latchi', '$2y$10$nNhawYCnNBAVBRwx5fCFT.TFowRaLA1G4Tzth7Be4a2UvRiMT94/W', 'worker', 'section 2', '2024-09-29', 'pondy', '605013', '671a6db748da13.30152297.jpg', ''),
(13, 'vela', '85247', '75412896325', '2589631470', '0987', 'vela', '$2y$10$8ZKLh4K0qrNGPGAfSm.TIuS.Qk.PngjBqPZ/ZdCjQ0Ohj1awpictq', 'worker', 'section 2', '2024-09-16', 'puudcherry', '605013', '66ec71c61d61f0.16823916.jpg', ''),
(15, 'kannan', '85247', '79456123582', '9080706050', '8888', 'kannan', '$2y$10$0puiSZ5hFvEg1MsDyw4zgedCPwA3OylfbklZh5SzqQSjoHNJhbhVq', 'worker', 'section 2', '2024-10-15', 'puudcherry', '605013', '670e7702b5b375.22116806.jpg', ''),
(24, 'valvizi', '85247', '75412896325', '9080706050', '8542', 'Vel', '$2y$10$zfYgUE04Gb0mVJDie9monO1j7SjcH7ijvcts8Ks87XTgjeohIXKS.', 'worker', 'section 2', '1996-06-04', 'puudcherry', '605013', '673050caa57467.37837994.png', 'vel@gmail.com'),
(16, 'amala', '85247', '79456123582', '9342481144', '8524', 'amala', '$2y$10$G.yztvd5xOrMXgz79fyj4e8DeFY7hxd/ecFgNQu054M3c5BVxixrq', 'worker', 'section 2', '2000-06-06', 'pondy', '605013', '6711f8178bdb04.82052371.jpg', ''),
(19, 'ishu', '85247', '79456123582', '9874557', '74125', 'ishu', '$2y$10$C3uA8JIAo1zgFo0/9yJ6TOOb/zR16RvBJnKfsUd1DNc6lq8LAX2iG', 'worker', 'section 2', '2001-06-05', 'puudcherry', '605013', '672235be10ee93.98532012.jpg', ''),
(6, 'paravathi', '8541', '622151542819', '8482491325', '123', 'gs@gs', '$2y$10$LkZN362fLLvzw7pLaNBil.UY/5Lq.A2hyI3FJZkDgUGwo/170CEua', 'healper', 'section 3', '2004-02-15', 'Pondy', '605004', '66e30259dbb871.37624612.jpg', 'parvathi@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `stock_records`
--

CREATE TABLE `stock_records` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `total_stock` int(11) NOT NULL,
  `used_stock` int(11) NOT NULL,
  `remaining_stock` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_records`
--

INSERT INTO `stock_records` (`id`, `item_name`, `total_stock`, `used_stock`, `remaining_stock`, `month`, `created_at`) VALUES
(10, 'egg', 10, 3, 7, 'may', '2024-09-20 07:50:46'),
(11, 'egg', 500, 200, 300, 'july', '2024-10-24 15:47:39'),
(12, 'rice', 550, 154, 396, 'September', '2024-11-03 12:38:27'),
(13, 'egg', 500, 200, 300, 'july', '2024-11-08 07:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `widow_details`
--

CREATE TABLE `widow_details` (
  `id` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `guardian` varchar(100) NOT NULL,
  `child_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `age` int(3) NOT NULL,
  `death_certificate` varchar(255) NOT NULL,
  `bank_passbook` varchar(255) NOT NULL,
  `aadhaar` varchar(255) NOT NULL,
  `ration_card` varchar(255) NOT NULL,
  `voter_id` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `widow_details`
--

INSERT INTO `widow_details` (`id`, `name`, `address`, `phone`, `guardian`, `child_name`, `dob`, `age`, `death_certificate`, `bank_passbook`, `aadhaar`, `ration_card`, `voter_id`, `reg_date`, `email`, `password`) VALUES
(1, 'Keerthi v', 'pondy', '09342481144', 'sdadsd', 'avhdio', '2013-01-02', 11, 'uploads/cen3.jpg', 'uploads/cen2.jpg', 'uploads/cen4.jpg', 'uploads/daily.jpg', 'uploads/logo1.jpg', '2024-10-02 14:16:55', '', ''),
(2, 'Keerthi v', 'tamilnade', '9342481144', 'dad', 'avhdio', '2024-10-25', -1, 'uploads/pback.jpg', 'uploads/cen4.jpg', 'uploads/logo2.png', 'uploads/daily.jpg', 'uploads/cen2.jpg', '2024-10-02 14:48:28', 'keerthanav1910@gmail.com', '$2y$10$.jh/qHoetMzaYfvaFmyE1uYH7wc/b84JmNJfWw6RlObM7OPTldQPO'),
(3, 'Keerthi v', 'pondy', '9342481144', 'sdadsd', 'avhdio', '2021-06-11', 3, 'uploads/t2.webp', 'uploads/t4.png', 'uploads/t2.webp', 'uploads/theorry 1.jpg', 'uploads/t5.jpg', '2024-10-07 05:00:14', 'keerthanav1910@gmail.com', '$2y$10$Kd/fXZpiI8pvlc5bSvJgLeK9n8/X1Hax1dNF5K2g3yMrEPEtSekz2'),
(4, 'kayal', 'pondy', '09342481144', 'sdadsd', 'kukhgf', '2021-02-03', 3, 'uploads/t4.png', 'uploads/t2.webp', 'uploads/theorry 1.jpg', 'uploads/t2.webp', 'uploads/t4.png', '2024-10-07 05:02:01', 'kayal123@gmail.com', '$2y$10$e3cBkDPl7wwzsy2hhIMiHOWzZaju8RdnuVw6Xig0m4EbCFpbn1c8S'),
(5, 'kayal', 'pondy', '9342481144', 'sdadsd', 'avhdio', '2021-06-15', 3, 'uploads/logo3.jpg', 'uploads/logo2.png', 'uploads/pback.jpg', 'uploads/pback2.jpg', 'uploads/logo1.jpg', '2024-10-08 04:43:26', 'kayal123@gmail.com', '$2y$10$Prkt7iE0MxVrO5GcSCqNJuSZodgREyWY/rj3HT84PvSKFxdn.UKQ6'),
(6, 'mano', 'pondy', '9342481144', 'sdadsd', 'kukhgf', '2022-02-08', 2, 'uploads/logo2.png', 'uploads/cen2.jpg', 'uploads/pback.jpg', 'uploads/pback2.jpg', 'uploads/cen1.jpg', '2024-10-08 04:45:09', 'mano@gmail.com', '$2y$10$oW3F/InUMfRzPwVU.x.xFuTv2.97AEcV.xUIBgX7xct1d1FNQgTSy'),
(7, 'Keerthi v', 'pondy', '9342481144', 'asdasd', 'kukhgf', '2024-10-09', 0, 'uploads/logo2.png', 'uploads/logo3.jpg', 'uploads/pback.jpg', 'uploads/pback.jpg', 'uploads/logo1.jpg', '2024-10-23 16:23:14', 'kayal123@gmail.com', '$2y$10$VI2SQcGtd9Hey4pkxh88s.kqUfyFECAEcw71ZWxTwYlnUlgTWUSBm'),
(8, 'kanmani', 'tamilnade', '093424 81144', 'sdadsd', 'avhdio', '2022-10-11', 2, 'uploads/logo2.png', 'uploads/pback.jpg', 'uploads/logo3.jpg', 'uploads/pback2.jpg', 'uploads/logo2.png', '2024-10-23 16:27:30', 'kanmani@gamil.com', '$2y$10$kEO28qCTFE1U/ZQz2xE7Melp5kr/IA41MiJgg6PsREHrJh5WbVnpa'),
(9, 'aa', 'Py', '8451214046', '', 'gs', '2013-06-27', 11, 'uploads/cen4.jpg', 'uploads/cen3.jpg', 'uploads/cen1.jpg', 'uploads/staffbg3.jpg', 'uploads/cen2.jpg', '2024-11-03 12:50:20', 'aa@aa', '$2y$10$0kZLVaJXW.68mGgkq/SLl.JnrhE07g47pthpoHPVZuVRW1oBksTei'),
(10, 'kaviya', 'pondicherry', '9342481144', 'dacc', 'avhdio', '2023-07-05', 1, '', 'uploads/logo2.png', '', 'uploads/pback.jpg', '', '2024-11-06 17:37:22', 'kaviya@gmail.com', '$2y$10$CntBG96BplI2epKsUiXdHuSFkQdLywYbySS5wrlFr0O73z./Ob5i.');

-- --------------------------------------------------------

--
-- Table structure for table `widow_temp`
--

CREATE TABLE `widow_temp` (
  `id` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `guardian` varchar(100) NOT NULL,
  `child_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `age` int(3) NOT NULL,
  `death_certificate` varchar(255) NOT NULL,
  `bank_passbook` varchar(255) NOT NULL,
  `aadhaar` varchar(255) NOT NULL,
  `ration_card` varchar(255) NOT NULL,
  `voter_id` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `widow_temp`
--

INSERT INTO `widow_temp` (`id`, `name`, `address`, `phone`, `guardian`, `child_name`, `dob`, `age`, `death_certificate`, `bank_passbook`, `aadhaar`, `ration_card`, `voter_id`, `reg_date`, `email`, `password`) VALUES
(1, 'Keerthi v', 'pondy', '09342481144', 'sdadsd', 'avhdio', '2013-01-02', 11, 'uploads/cen3.jpg', 'uploads/cen2.jpg', 'uploads/cen4.jpg', 'uploads/daily.jpg', 'uploads/logo1.jpg', '2024-10-02 14:16:55', '', ''),
(2, 'Keerthi v', 'tamilnade', '9342481144', 'dad', 'avhdio', '2024-10-25', -1, 'uploads/pback.jpg', 'uploads/cen4.jpg', 'uploads/logo2.png', 'uploads/daily.jpg', 'uploads/cen2.jpg', '2024-10-02 14:48:28', 'keerthanav1910@gmail.com', '$2y$10$.jh/qHoetMzaYfvaFmyE1uYH7wc/b84JmNJfWw6RlObM7OPTldQPO'),
(3, 'Keerthi v', 'pondy', '9342481144', 'sdadsd', 'avhdio', '2021-06-11', 3, 'uploads/t2.webp', 'uploads/t4.png', 'uploads/t2.webp', 'uploads/theorry 1.jpg', 'uploads/t5.jpg', '2024-10-07 05:00:14', 'keerthanav1910@gmail.com', '$2y$10$Kd/fXZpiI8pvlc5bSvJgLeK9n8/X1Hax1dNF5K2g3yMrEPEtSekz2'),
(4, 'kayal', 'pondy', '09342481144', 'sdadsd', 'kukhgf', '2021-02-03', 3, 'uploads/t4.png', 'uploads/t2.webp', 'uploads/theorry 1.jpg', 'uploads/t2.webp', 'uploads/t4.png', '2024-10-07 05:02:01', 'kayal123@gmail.com', '$2y$10$e3cBkDPl7wwzsy2hhIMiHOWzZaju8RdnuVw6Xig0m4EbCFpbn1c8S'),
(5, 'kayal', 'pondy', '9342481144', 'sdadsd', 'avhdio', '2021-06-15', 3, 'uploads/logo3.jpg', 'uploads/logo2.png', 'uploads/pback.jpg', 'uploads/pback2.jpg', 'uploads/logo1.jpg', '2024-10-08 04:43:26', 'kayal123@gmail.com', '$2y$10$Prkt7iE0MxVrO5GcSCqNJuSZodgREyWY/rj3HT84PvSKFxdn.UKQ6'),
(6, 'mano', 'pondy', '9342481144', 'sdadsd', 'kukhgf', '2022-02-08', 2, 'uploads/logo2.png', 'uploads/cen2.jpg', 'uploads/pback.jpg', 'uploads/pback2.jpg', 'uploads/cen1.jpg', '2024-10-08 04:45:09', 'mano@gmail.com', '$2y$10$oW3F/InUMfRzPwVU.x.xFuTv2.97AEcV.xUIBgX7xct1d1FNQgTSy'),
(7, 'Keerthi v', 'pondy', '9342481144', 'asdasd', 'kukhgf', '2024-10-09', 0, 'uploads/logo2.png', 'uploads/logo3.jpg', 'uploads/pback.jpg', 'uploads/pback.jpg', 'uploads/logo1.jpg', '2024-10-23 16:23:14', 'kayal123@gmail.com', '$2y$10$VI2SQcGtd9Hey4pkxh88s.kqUfyFECAEcw71ZWxTwYlnUlgTWUSBm'),
(8, 'kanmani', 'tamilnade', '093424 81144', 'sdadsd', 'avhdio', '2022-10-11', 2, 'uploads/logo2.png', 'uploads/pback.jpg', 'uploads/logo3.jpg', 'uploads/pback2.jpg', 'uploads/logo2.png', '2024-10-23 16:27:30', 'kanmani@gamil.com', '$2y$10$kEO28qCTFE1U/ZQz2xE7Melp5kr/IA41MiJgg6PsREHrJh5WbVnpa'),
(9, 'aa', 'Py', '8451214046', '', 'gs', '2013-06-27', 11, 'uploads/cen4.jpg', 'uploads/cen3.jpg', 'uploads/cen1.jpg', 'uploads/staffbg3.jpg', 'uploads/cen2.jpg', '2024-11-03 12:50:20', 'aa@aa', '$2y$10$0kZLVaJXW.68mGgkq/SLl.JnrhE07g47pthpoHPVZuVRW1oBksTei'),
(10, 'kaviya', 'pondicherry', '9342481144', 'dacc', 'avhdio', '2023-07-05', 1, '', 'uploads/logo2.png', '', 'uploads/pback.jpg', '', '2024-11-06 17:37:22', 'kaviya@gmail.com', '$2y$10$CntBG96BplI2epKsUiXdHuSFkQdLywYbySS5wrlFr0O73z./Ob5i.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `above_60_dashboard`
--
ALTER TABLE `above_60_dashboard`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `camp_details`
--
ALTER TABLE `camp_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`child_id`),
  ADD KEY `fk_parent` (`parent_id`);

--
-- Indexes for table `daily_updates_db`
--
ALTER TABLE `daily_updates_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `family_head_woman_dashboard`
--
ALTER TABLE `family_head_woman_dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FED_ID`),
  ADD KEY `TEST` (`EMAIL`);

--
-- Indexes for table `fhw_temp`
--
ALTER TABLE `fhw_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_temp`
--
ALTER TABLE `parent_temp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aadhaar` (`aadhar_no`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aadhaar` (`aadhar_no`);

--
-- Indexes for table `schemes`
--
ALTER TABLE `schemes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `senior_temp`
--
ALTER TABLE `senior_temp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`una_no`,`phone`,`username`,`aadhar_no`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `staff_temp`
--
ALTER TABLE `staff_temp`
  ADD PRIMARY KEY (`una_no`,`phone`,`username`,`aadhar_no`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `stock_records`
--
ALTER TABLE `stock_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widow_details`
--
ALTER TABLE `widow_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widow_temp`
--
ALTER TABLE `widow_temp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `above_60_dashboard`
--
ALTER TABLE `above_60_dashboard`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `camp_details`
--
ALTER TABLE `camp_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `daily_updates_db`
--
ALTER TABLE `daily_updates_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `family_head_woman_dashboard`
--
ALTER TABLE `family_head_woman_dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FED_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fhw_temp`
--
ALTER TABLE `fhw_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `meals`
--
ALTER TABLE `meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `parent_temp`
--
ALTER TABLE `parent_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `schemes`
--
ALTER TABLE `schemes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `senior_temp`
--
ALTER TABLE `senior_temp`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `staff_temp`
--
ALTER TABLE `staff_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `stock_records`
--
ALTER TABLE `stock_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `widow_details`
--
ALTER TABLE `widow_details`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `widow_temp`
--
ALTER TABLE `widow_temp`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
