-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 23, 2026 at 12:04 PM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tanker_on_rent`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

DROP TABLE IF EXISTS `customer_master`;
CREATE TABLE IF NOT EXISTS `customer_master` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `customer_mobile` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `customer_email` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `customer_type` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`customer_id`, `customer_name`, `customer_mobile`, `customer_email`, `customer_address`, `customer_type`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'prerna', '09790954014', 'dev5.apolloinfotech@gmail.com', '3/176, Samathuva Nagar Main Road, 14, Kazhipathur, Padur Post', 'retailer', 1, 0, '2025-09-19 16:35:32', '2025-10-10 14:59:48'),
(2, 'lgglkg;kg', '3409-094-096', 'dev1.apolloinfotech@gmail.com', 'Sola\r\nScience City', NULL, 1, 1, '2025-09-29 18:17:12', '2025-09-29 18:17:49'),
(3, 'Krunal shah', '9824773136', 'dev4.apolloinfotech@gmail.com', 'isanpur', 'customer', 1, 0, '2025-09-30 12:51:55', '2025-10-10 14:59:41'),
(4, 'પ્રેરણા અર્પિત પારેખ', '09987654321', 'dev1.apolloinfotech@gmail.com', 'સોલા\r\nસાયન્સ સિટી', 'retailer', 1, 1, '2025-10-13 11:41:04', '2025-10-13 11:41:19'),
(5, 'Asif Bhai', '9825717492', NULL, 'anand', 'retailer', 1, 0, '2025-11-24 10:15:16', '2025-11-24 10:15:16'),
(6, 'મુનિરભાઈ', '8160713035', NULL, 'આણંદ', 'retailer', 1, 1, '2026-01-10 09:43:29', '2026-02-19 11:00:51'),
(7, 'ચિરાગ ભાઈ સુરાણી', '9265995155', NULL, 'surat', 'customer', 1, 0, '2026-03-07 16:24:57', '2026-03-07 16:24:57'),
(8, 'અરવિંદ ભાઈ ongc', '9924814526', NULL, 'ongc', 'customer', 1, 0, '2026-05-07 15:18:20', '2026-05-07 15:18:20'),
(9, 'ભાનુ ભાઈ  ભરવાડ', '9978099122', NULL, 'તારાપુર', 'retailer', 1, 0, '2026-05-10 12:03:01', '2026-05-10 12:03:01'),
(10, 'રવિરાજ દરબાર', '91577711111', NULL, 'નડિયાદ', 'customer', 1, 0, '2026-05-10 12:21:40', '2026-05-10 12:21:40'),
(11, 'રૂપેશભાઈ ઠક્કર', '992524151', NULL, 'આણંદ', 'retailer', 1, 0, '2026-05-10 15:35:32', '2026-05-10 15:35:32'),
(12, 'દિવાન ભાઈ કોન્ટ્રાકટર', '7567898887', NULL, 'સમારખા ચોકડી', 'retailer', 1, 0, '2026-05-10 16:03:33', '2026-05-10 16:03:33'),
(13, 'કેતન ભાઈ પટેલ', '9824410816', NULL, 'ગાના  રોડ મોગરી', 'retailer', 1, 0, '2026-05-10 16:19:30', '2026-05-10 16:19:30'),
(14, 'સુધીરભાઈ સોમા ભાઈ પટેલ', '7016812897', NULL, 'બોરસાદ', 'retailer', 1, 0, '2026-05-10 17:02:06', '2026-05-10 17:02:06'),
(15, 'મૌલિક ભાઈ પરમાર', '9737060692', NULL, 'આણંદ', 'retailer', 1, 0, '2026-05-10 17:11:17', '2026-05-10 17:11:17'),
(16, 'ચંદ્ર્કાંત ભાઈ દેસાઇ', '9825026078', NULL, 'સાણદ', 'retailer', 1, 0, '2026-05-11 09:55:49', '2026-05-11 09:55:49'),
(17, 'અફજલ ભાઈ', '9624978851', NULL, 'મુબઈ', 'retailer', 1, 0, '2026-05-11 09:59:31', '2026-05-11 09:59:31'),
(18, 'અફજલ ભાઈ', '9624978851', NULL, 'મુબઈ', 'retailer', 1, 0, '2026-05-11 09:59:31', '2026-05-11 09:59:31'),
(19, 'ધનેજય ભાઈ પટેલ', '6352685235', NULL, 'બોરસદ ચોકડી', 'retailer', 1, 0, '2026-05-11 10:21:03', '2026-05-11 10:21:03'),
(20, 'અનિલ ભાઈ પ્રજાપતિ', '9824552617', NULL, 'મોટી ખોડિયાર', 'retailer', 1, 0, '2026-05-11 10:43:59', '2026-05-11 10:43:59'),
(21, 'બ્રિજલભાઈ ભરવાડ', '9824399684', NULL, 'સોજીત્રા', 'retailer', 1, 0, '2026-05-11 11:42:32', '2026-05-11 11:42:32'),
(25, 'જયેશભાઈ આહિર', '9979999849', NULL, 'આદિપુર', 'retailer', 1, 0, '2026-05-12 11:24:54', '2026-05-12 11:24:54'),
(23, 'હિરેનભાઈ કાલુંભાઈ  પારખિયા', '9898437424', NULL, 'સુરત', 'retailer', 1, 0, '2026-05-11 14:24:14', '2026-05-11 14:24:14'),
(24, 'રતન સિંહ અમરસિંહ પરમાર', '7567020792', NULL, 'સંજયા', 'retailer', 1, 0, '2026-05-11 14:43:39', '2026-05-11 14:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `daily_expence_master`
--

DROP TABLE IF EXISTS `daily_expence_master`;
CREATE TABLE IF NOT EXISTS `daily_expence_master` (
  `expence_id` int NOT NULL AUTO_INCREMENT,
  `expence_type_id` int NOT NULL,
  `expence_date` date DEFAULT NULL,
  `amount` int NOT NULL,
  `comment` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `iStatus` tinyint NOT NULL DEFAULT '1',
  `isDelete` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`expence_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_expence_type`
--

DROP TABLE IF EXISTS `daily_expence_type`;
CREATE TABLE IF NOT EXISTS `daily_expence_type` (
  `expence_type_id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`expence_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_order`
--

DROP TABLE IF EXISTS `daily_order`;
CREATE TABLE IF NOT EXISTS `daily_order` (
  `daily_order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL DEFAULT '0',
  `tanker_id` int DEFAULT NULL,
  `customer_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `mobile` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `rent_date` date NOT NULL,
  `placed_the_tanker` int DEFAULT NULL,
  `empty_the_tanker` int DEFAULT NULL,
  `filled_the_tanker` int DEFAULT NULL,
  `extra_amount` int DEFAULT '0',
  `total_amount` int NOT NULL,
  `isPaid` int NOT NULL DEFAULT '0' COMMENT '0 =unpaid, 1=paid',
  `received_at` date DEFAULT NULL,
  `isReceive` int DEFAULT '1' COMMENT '1= not received , 0=received',
  `extra_duration` int DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`daily_order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_order_ledger`
--

DROP TABLE IF EXISTS `daily_order_ledger`;
CREATE TABLE IF NOT EXISTS `daily_order_ledger` (
  `ledger_id` bigint NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `daily_order_id` int DEFAULT NULL,
  `entry_date` date NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `debit_bl` decimal(12,2) NOT NULL DEFAULT '0.00',
  `credit_bl` decimal(12,2) NOT NULL DEFAULT '0.00',
  `closing_bl` decimal(12,2) NOT NULL,
  `iStatus` tinyint NOT NULL DEFAULT '1',
  `isDelete` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ledger_id`),
  KEY `idx_customer_date` (`customer_id`,`entry_date`),
  KEY `idx_daily_order` (`daily_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_master`
--

DROP TABLE IF EXISTS `driver_master`;
CREATE TABLE IF NOT EXISTS `driver_master` (
  `driver_id` int NOT NULL AUTO_INCREMENT,
  `driver_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`driver_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_extra_withdrawal`
--

DROP TABLE IF EXISTS `employee_extra_withdrawal`;
CREATE TABLE IF NOT EXISTS `employee_extra_withdrawal` (
  `withdrawal_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `withdrawal_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `emi_amount` int DEFAULT NULL,
  `remaining_amount` int DEFAULT NULL,
  `isActive` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`withdrawal_id`),
  KEY `fk_emp_withdrawal` (`emp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_master`
--

DROP TABLE IF EXISTS `employee_master`;
CREATE TABLE IF NOT EXISTS `employee_master` (
  `emp_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `designation` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `daily_wages` int DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`emp_id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `employee_master`
--

INSERT INTO `employee_master` (`emp_id`, `name`, `designation`, `mobile`, `address`, `daily_wages`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(5, 'Shailesh Bhai', 'Driver', '9876543210', 'anand', 400, 1, 0, '2025-11-24 09:44:37', '2025-11-24 09:44:37'),
(6, 'Vijay bhai', 'Driver', '9876543211', 'chklasi', 400, 1, 0, '2025-11-24 09:45:17', '2025-11-24 09:45:17'),
(13, 'rahul chakalasi', 'કંડક્ટર', '9316103684', 'ચકલાસી', 300, 1, 0, '2026-05-11 15:04:43', '2026-05-11 15:04:43'),
(8, 'Mini bhai', 'Driver', '987654323', 'labhel', 400, 1, 0, '2025-11-24 09:46:17', '2025-11-24 09:46:17'),
(9, 'Meet Bhai', 'Conductor', '987654324', 'anand', 300, 1, 0, '2025-11-24 09:47:04', '2025-11-24 09:47:04'),
(10, 'Sanjay bhai', 'Mehtaji', '987654325', 'devkapura', 400, 1, 0, '2025-11-24 09:47:37', '2025-11-24 09:47:37'),
(11, 'Jagdish bhai', 'Conductor', '987654326', 'anand', 300, 1, 0, '2025-11-24 09:48:25', '2025-11-24 09:48:25'),
(12, 'Hitesh bahi', 'driver', '987654328', 'chacklasi', 400, 1, 0, '2025-11-24 09:55:22', '2025-11-24 09:55:22'),
(14, 'પઠાણ કાકા', 'કંડક્ટર', '9265995155', NULL, 300, 1, 0, '2026-05-13 15:52:26', '2026-05-13 15:52:26'),
(15, 'રાજુ કાકા', 'કંડક્ટર', '-', NULL, NULL, 1, 0, '2026-05-13 15:53:04', '2026-05-13 15:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `emp_attendance_master`
--

DROP TABLE IF EXISTS `emp_attendance_master`;
CREATE TABLE IF NOT EXISTS `emp_attendance_master` (
  `attendance_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `attendance_date` date NOT NULL,
  `status` char(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `leave_reason` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `enter_by` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`attendance_id`),
  KEY `FK_Attendance_Employee` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `emp_attendance_master`
--

INSERT INTO `emp_attendance_master` (`attendance_id`, `emp_id`, `attendance_date`, `status`, `leave_reason`, `enter_by`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 12, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12'),
(2, 8, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12'),
(3, 10, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12'),
(4, 14, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12'),
(5, 15, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary`
--

DROP TABLE IF EXISTS `emp_salary`;
CREATE TABLE IF NOT EXISTS `emp_salary` (
  `emp_salary_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `salary_date` datetime NOT NULL,
  `last_date` date DEFAULT NULL,
  `daily_wages` int DEFAULT NULL,
  `salary_amount` int NOT NULL,
  `withdrawal_deducted` decimal(10,2) DEFAULT '0.00',
  `withdrawal_id` int DEFAULT '0',
  `mobile_recharge` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `iStatus` tinyint NOT NULL DEFAULT '1',
  `isDelete` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`emp_salary_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `godown_master`
--

DROP TABLE IF EXISTS `godown_master`;
CREATE TABLE IF NOT EXISTS `godown_master` (
  `godown_id` int NOT NULL AUTO_INCREMENT,
  `godown_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`godown_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `godown_master`
--

INSERT INTO `godown_master` (`godown_id`, `godown_address`, `Name`, `slug`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'test godown address', 'test godown', '', 1, 0, '2025-09-25 16:31:14', '2025-09-25 16:37:56'),
(2, 'test address', 'test godown12', 'test-godown12', 1, 0, '2025-09-29 17:41:00', '2025-09-29 17:41:00'),
(3, 'આણંદ', 'ગોપી ગોડાઉન', 'godown', 1, 0, '2025-12-10 10:39:55', '2025-12-10 10:39:55'),
(4, 'લાભવેલ', 'લાભવેલ ગોડાઉન', 'godown-2', 1, 0, '2025-12-10 10:40:15', '2025-12-10 10:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `iscon_daily_expence_master`
--

DROP TABLE IF EXISTS `iscon_daily_expence_master`;
CREATE TABLE IF NOT EXISTS `iscon_daily_expence_master` (
  `expence_id` int NOT NULL AUTO_INCREMENT,
  `expence_type_id` int NOT NULL,
  `expence_date` date DEFAULT NULL,
  `amount` int NOT NULL,
  `comment` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `iStatus` tinyint NOT NULL DEFAULT '1',
  `isDelete` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`expence_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_master`
--

DROP TABLE IF EXISTS `order_master`;
CREATE TABLE IF NOT EXISTS `order_master` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `user_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_mobile` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tanker_id` int NOT NULL,
  `rent_type` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL COMMENT 'daily, monthly',
  `rent_start_date` datetime NOT NULL,
  `received_at` date DEFAULT NULL,
  `advance_amount` int NOT NULL,
  `rent_amount` int NOT NULL,
  `extra_amount` int NOT NULL DEFAULT '0' COMMENT 'extra charges of month and day',
  `extra_duration` int DEFAULT NULL,
  `extraDM` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL COMMENT 'day or month',
  `reference_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `reference_mobile_no` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `reference_address` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tanker_location` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `contract_text` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `isReceive` int NOT NULL DEFAULT '1' COMMENT '1= not received , 0=received',
  `iStatus` tinyint NOT NULL DEFAULT '1',
  `isDelete` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `order_master`
--

INSERT INTO `order_master` (`order_id`, `customer_id`, `user_name`, `user_mobile`, `tanker_id`, `rent_type`, `rent_start_date`, `received_at`, `advance_amount`, `rent_amount`, `extra_amount`, `extra_duration`, `extraDM`, `reference_name`, `reference_mobile_no`, `reference_address`, `tanker_location`, `contract_text`, `isReceive`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 3, 'krunal', '9824773136', 70, '1', '2026-02-04 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 14:48:05', '2026-06-22 14:48:05'),
(2, 3, 'krunal', '9824773136', 109, '1', '2026-02-04 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 14:49:56', '2026-06-22 14:49:56'),
(3, 3, 'krunal', '9824773136', 131, '1', '2026-02-14 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 14:50:54', '2026-06-22 14:50:54'),
(4, 3, 'krunal', NULL, 54, '1', '2026-02-16 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'test ref name', '9874589878', 'test ref address', 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 14:52:47', '2026-06-22 14:52:47'),
(5, 3, 'krunal', '9824773136', 66, '1', '2026-02-16 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 14:53:59', '2026-06-22 14:53:59'),
(6, 3, 'krunal', '9824773136', 73, '1', '2026-02-19 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 14:57:24', '2026-06-22 14:57:24'),
(7, 3, 'krunal', NULL, 56, '1', '2026-02-27 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 14:58:09', '2026-06-22 14:58:09'),
(8, 3, 'krunal', '9824773136', 17, '1', '2026-03-09 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 14:59:14', '2026-06-22 14:59:14'),
(9, 3, 'krunal', '9824773136', 110, '1', '2026-03-12 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 15:00:07', '2026-06-22 15:00:07'),
(10, 3, 'krunal', '9824773136', 8, '1', '2026-03-12 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 15:00:38', '2026-06-22 15:00:38'),
(11, 20, 'test', '84748487878', 104, '1', '2026-02-04 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 17:08:14', '2026-06-22 17:08:14'),
(12, 1, 'parekh', '8745895896', 130, '1', '2026-05-21 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ahmedabad , maninager', NULL, 1, 1, 0, '2026-06-22 17:30:32', '2026-06-22 17:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `order_payment_master`
--

DROP TABLE IF EXISTS `order_payment_master`;
CREATE TABLE IF NOT EXISTS `order_payment_master` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_id` int NOT NULL,
  `total_amount` int NOT NULL,
  `paid_amount` int NOT NULL,
  `unpaid_amount` int NOT NULL,
  `is_discount_amount` tinyint NOT NULL DEFAULT '0',
  `discount_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_received_by` int DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `order_payment_master`
--

INSERT INTO `order_payment_master` (`payment_id`, `customer_id`, `order_id`, `total_amount`, `paid_amount`, `unpaid_amount`, `is_discount_amount`, `discount_amount`, `payment_received_by`, `payment_date`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(2, 1, 0, 8000, 8000, 0, 0, '0.00', 1, '2026-06-22', 1, 0, '2026-06-22 17:32:48', '2026-06-22 17:32:48');

-- --------------------------------------------------------

--
-- Table structure for table `payment_received_user`
--

DROP TABLE IF EXISTS `payment_received_user`;
CREATE TABLE IF NOT EXISTS `payment_received_user` (
  `received_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `iStatus` int NOT NULL DEFAULT '0',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`received_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `payment_received_user`
--

INSERT INTO `payment_received_user` (`received_id`, `name`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'અરવિંદ', 1, 0, '2026-05-13 17:13:34', '2026-05-13 17:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `rent_prices`
--

DROP TABLE IF EXISTS `rent_prices`;
CREATE TABLE IF NOT EXISTS `rent_prices` (
  `rent_price_id` int NOT NULL AUTO_INCREMENT,
  `rent_type` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `amount` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rent_price_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `rent_prices`
--

INSERT INTO `rent_prices` (`rent_price_id`, `rent_type`, `amount`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'Monthly', '4000', 1, 0, '2025-09-26 15:45:31', '2026-05-07 15:14:48'),
(2, 'Daily', '200', 1, 0, '2025-09-26 15:45:31', '2026-05-07 15:08:22');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2022-09-12 04:33:06', '2022-09-12 04:33:06'),
(2, 'Employee', 'web', '2022-09-12 04:33:06', '2022-09-12 04:33:06'),
(3, 'Vendor', 'web', '2022-09-12 04:33:06', '2022-09-12 04:33:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sendemaildetails`
--

DROP TABLE IF EXISTS `sendemaildetails`;
CREATE TABLE IF NOT EXISTS `sendemaildetails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `strSubject` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strTitle` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strFromMail` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ToMail` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strCC` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `strBCC` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `sendemaildetails`
--

INSERT INTO `sendemaildetails` (`id`, `strSubject`, `strTitle`, `strFromMail`, `ToMail`, `strCC`, `strBCC`) VALUES
(4, 'Contact Inquiry', 'Sukti', 'support@sukti.in', NULL, '', ''),
(8, 'Forget Password', 'Sukti', 'support@sukti.in', NULL, NULL, NULL),
(9, 'sign_up', 'Sukti', 'support@sukti.in', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sitename` varchar(5000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `strIP` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `sitename`, `logo`, `email`, `iStatus`, `isDelete`, `created_at`, `updated_at`, `strIP`) VALUES
(1, 'Jewellery crm', '1746446528.png', 'dev5.apolloinfotech@gmail.com', 1, 0, '2025-05-05 12:02:08', NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `tanker_master`
--

DROP TABLE IF EXISTS `tanker_master`;
CREATE TABLE IF NOT EXISTS `tanker_master` (
  `tanker_id` int NOT NULL AUTO_INCREMENT,
  `godown_id` int DEFAULT NULL,
  `tanker_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `tanker_code` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=inside, 1=outside',
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tanker_id`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `tanker_master`
--

INSERT INTO `tanker_master` (`tanker_id`, `godown_id`, `tanker_name`, `slug`, `tanker_code`, `status`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 4, 'જય માતાજી', 'a-1', 'A-1', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-13 17:11:38'),
(2, 4, 'જય સિકોતર', 'b-2', 'B-2', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(3, 4, 'જય શ્રી ચામુંડા માં', 'c-3', 'C-3', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(4, 4, 'જય શ્રી મેલડી માં', 'd-4', 'D-4', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(5, 4, 'જય ભોલેનાથ', 'e-5', 'E-5', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(6, 4, 'જય શ્રી ગણેશયા નમઃ', 'f-6', 'F-6', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(7, 4, 'જય  શ્રીનાથજી', 'g-7', 'G-7', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(8, 4, 'જય આશાપુરા', 'h-8', 'H-8', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 15:00:38'),
(9, 4, 'જય હનુમાન', 'i-9', 'I-9', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(10, 4, 'જય ખોડિયાર માં', 'j-10', 'J-10', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(11, 4, 'જય શ્રી  અંબે માં', 'k-11', 'K-11', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(12, 4, 'જય હિંગળાજ માં', 'l-12', 'L-12', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(13, 4, 'જય કુળદેવી માં', 'm-13', 'M-13', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 12:41:25'),
(14, 4, 'જય શ્રી વહાણવટી માં', 'n-14', 'N-14', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(15, 4, 'જય  મોમઇ માં', 'o-15', 'O-15', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(16, 4, 'શિવશક્તિ', 'p-16', 'P-16', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(17, 4, 'જય મહાકાળી માં', 'q-17', 'Q-17', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 14:59:14'),
(18, 4, 'જય ડાડા', 'r-18', 'R-18', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-13 12:10:06'),
(19, 4, 'શ્રી લક્ષ્મી માં', 's-19', 'S-19', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(20, 1, 'જય રાજબાઈ માં', 't-20', 'T-20', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-13 13:21:29'),
(21, 4, 'જય ગાયત્રીમાં', 'u-21', 'U-21', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(22, 4, 'જય જોગણી માં', 'v-22', 'V-22', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(23, 4, 'જય દશામાં', 'w-23', 'W-23', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(24, 4, 'જય સંતોષો માં', 'x-24', 'X-24', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(25, 4, 'જય શ્રી કૃષણ', 'y-25', 'Y-25', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(26, 4, 'જય વિશ્વકર્મા', 'z-26', 'Z-26', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 14:33:56'),
(27, 4, 'બાપા સિતારામ', 'aa-27', 'AA-27', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-13 17:12:17'),
(28, 4, 'જય શ્રી રામ', 'ab-28', 'AB-28', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(29, 4, 'જય સરસ્વતી માં', 'ac-29', 'AC-29', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(30, 4, 'જય ગંગા મૈયા', 'ad-30', 'AD-30', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(31, 4, 'જય શ્રી જમના મૈયા', 'ae-31', 'AE-31', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 09:57:56'),
(32, 4, 'જય શ્રી નર્મદા મૈયા', 'af-32', 'AF-32', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 14:32:42'),
(33, 4, 'જય શ્રી મહીસાગર મૈયા', 'ag-33', 'AG-33', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(34, 4, 'જય જલારામ', 'ah-34', 'AH-34', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(35, 4, 'જય સ્વામિનારયણ', 'ai-35', 'AI-35', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(36, 4, 'જય સંતરામ મહારાજ', 'aj-36', 'AJ-36', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 11:07:21'),
(37, 4, 'જય સુરપુરા', 'ak-37', 'AK-37', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 12:56:39'),
(38, 4, 'જય રવેચી માં', 'al-38', 'AL-38', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(39, 4, 'જય ઉમિયા માતા', 'am-39', 'AM-39', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(40, 4, 'જય મારૂતિ  નંદન', 'an-40', 'AN-40', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(41, 4, 'જય શનિ દેવ', 'ao--41', 'AO--41', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(42, 4, 'જય સાંઈબાબા', 'ap-42', 'AP-42', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(43, 4, 'જય ગુરૂનાનક દેવ', 'aq-43', 'AQ-43', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(44, 4, 'જય સોમનાથ', 'ar-44', 'AR-44', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(45, 4, 'જય પિતૃ દેવ', 'as-45', 'AS-45', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(46, 4, 'જય ભાથીજી મહારાજ', 'at-46', 'AT-46', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(47, 4, 'બાબા રામદેવ પીર', 'au-47', 'AU-47', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(48, 4, 'જય મોગલ માં', 'av-48', 'AV-48', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(49, 4, 'જય શ્રી નાગબાઈ માં', 'aw-49', 'AW-49', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-13 12:05:03'),
(50, 4, 'જય રણછોડરાય', 'ax-50', 'AX-50', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(51, 4, 'જય મામા', 'ay-51', 'AY-51', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(52, 4, 'જય  ભૈરવ દાદા', 'az-52', 'AZ-52', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 13:15:31'),
(53, 4, 'જય   કાર્તિકે', 'aaa-53', 'AAA-53', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-13 17:33:17'),
(54, 4, 'જય હરસિદ્ધિમાં', 'aab-54', 'AAB-54', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 14:52:47'),
(55, 4, 'જય રામેશ્વર', 'aac-55', 'AAC-55', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 12:59:40'),
(56, 4, 'જય શ્રી દ્વારકાધીશ', 'aad-56', 'AAD-56', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 14:58:09'),
(57, 4, 'જય શ્રી માધવ', 'aae-57', 'AAE-57', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(58, 4, 'જય ૐ  નમઃ શિવયા', 'aaf-58', 'AAF-58', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(59, 4, 'જય શ્રી કેશવ', 'aag-59', 'AAG-59', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(60, 4, 'જય શ્રી  વેરાઈ માં', 'aah-60', 'AAH-60', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(61, 4, 'જય શ્રી અન્નપૂર્ણા માં', 'aai-61', 'AAI-61', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(62, 4, 'બ્રહ્મા વિષ્ણુ મહેશ', 'aaj-62', 'AAJ-62', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(63, 4, 'જય શ્રી ચંડી ચામુંડા માં', 'aak-63', 'AAK-63', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(64, 4, 'જય શ્રી ચાવન કૃપા', 'aal-64', 'AAL-64', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:20:51'),
(65, 4, 'જય ભવાની માં', 'aam-65', 'AAM-65', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(66, 4, 'જય ગંગા સાગર', 'aan-66', 'AAN-66', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 14:53:59'),
(67, 4, 'જય ત્રિદેવ', 'aao-67', 'AAO-67', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 10:51:53'),
(68, 4, 'જય ભગવાન', 'aap-68', 'AAP-68', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 17:04:27'),
(69, 4, 'જય  સુંધા માતા', 'aaq-69', 'AAQ-69', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(70, 4, 'જય યોગેશ્વર', 'aar-70', 'AAR-70', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 14:48:05'),
(71, 4, 'જય બળીયા દેવ', 'aas-71', 'AAS-71', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(72, 4, 'જય કેદારનાથ', 'aat-72', 'AAT-72', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(73, 4, 'જય યમનોત્રી', 'aau-73', 'AAU-73', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 14:57:24'),
(74, 4, 'જય ગંગોત્રી', 'aav-74', 'AAV-74', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(75, 4, 'જય બદ્રીનાથ', 'aaw-75', 'AAW-75', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 10:24:15'),
(76, 4, 'જય હરિદ્વાર', 'aax-76', 'AAX-76', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:22:37'),
(77, 4, 'જય જીવણીસતી માં', 'aay-77', 'AAY-77', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 12:08:12'),
(78, 4, 'કાનમેર ના ચામુંડા માં', 'aaz-78', 'AAZ-78', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(79, 4, 'જય  વચ્છરાજ ડાડા', 'aaaa-79', 'AAAA-79', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-18 17:20:08'),
(80, 3, 'શ્રી ભાગવત ગીતા', 'aaab-80', 'AAAB-80', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 11:05:30'),
(81, 4, 'જય શ્રી ચોટીલા ના ચામુંડા માં', 'aaac-81', 'AAAC-81', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(82, 4, 'શ્રી પ્રમુખ સ્વામિ', 'aaad-82', 'AAAD-82', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(83, 4, 'શ્રી પાબુ ડાડા', 'aaae-83', 'AAAE-83', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(84, 4, 'જય શ્રી આશાપુરી પીપળાવ', 'aaaf-84', 'AAAF-84', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(85, 4, 'જય શ્રી ઉજ્જૈન ના મહાકાલેશ્વર', 'aaag-85', 'AAAG-85', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 11:59:17'),
(86, 4, 'જય શ્રી રિદ્ધિસિદ્ધિ', 'aaah-86', 'AAAH-86', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(87, 4, 'જય શ્રી શુભ લાભ', 'aaai-87', 'AAAI-87', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 17:55:08'),
(88, 4, 'જય શ્રી વાઘેશ્વરી માં', 'aaaj-88', 'AAAJ-88', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 17:14:07'),
(89, 4, 'જય શ્રી લક્ષ્મણ', 'aaak-89', 'AAAK-89', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(90, 4, 'જય શ્રી વેણુ ડાડા', 'aaal-90', 'AAAL-90', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(91, 4, 'જય બાબા અમરનાથ', 'aaam-91', 'AAAM-91', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 16:06:46'),
(92, 4, 'શ્રી ભૂરખિયા હનુમાન', 'aaan-92', 'AAAN-92', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(93, 4, 'જય શ્રી  વરૂડી માતાજી', 'aaao-93', 'AAAO-93', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 11:04:50'),
(94, 4, 'શ્રી કષ્ટભંજન હનુમાન', 'aaap-94', 'AAAP-94', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 11:50:57'),
(95, 4, 'શ્રી ઝંડ હનુમાન', 'aaaq-95', 'AAAQ-95', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 16:52:47'),
(96, 4, 'શ્રી   ગજનંદ', 'aaar-96', 'AAAR-96', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 10:02:03'),
(97, 4, 'શ્રી ઠાકર', 'aaas-97', 'AAAS-97', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(98, 4, 'હરેક્રુષ્ણ હરે રામ', 'aaat-98', 'AAAT-98', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(99, 4, '|| શ્રી રાધેરાધે||', 'aaav-99', 'AAAV-99', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(100, 4, 'શ્રી કોટેશ્વર મહાદેવ', 'aaaw-100', 'AAAW-100', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(101, 3, 'જય શ્રી નીલકંઠ વરણી', 'aaax-101', 'AAAX-101', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 17:53:22'),
(102, 4, 'જય શ્રી વિહત માં', 'aaay-102', 'AAAY-102', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 15:40:05'),
(103, 4, 'જય  બ્રહ્માણી માં', 'aaaz-103', 'AAAZ-103', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:21:27'),
(104, 4, 'જય વિધ્યાવાસીની', 'aaaaa-104', 'AAAAA-104', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 17:08:14'),
(105, 4, 'જય શ્રી મસાણિ  માં', 'aaaab-105', 'AAAAB-105', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 11:54:54'),
(106, 4, 'રાધેશ્યામ', 'aaaac-106', 'AAAAC-106', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 17:12:38'),
(107, 4, 'જય રાજાધિરાજ', 'aaaad-107', 'AAAAD-107', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 12:17:22'),
(108, 4, 'શ્રી ક્રુષ્ણ સુદામા', 'aaaae-108', 'AAAAE-108', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(109, 4, 'જય શ્રી સૂર્ય દેવ', 'aaaaf-109', 'AAAAF-109', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 14:49:56'),
(110, 4, 'જય શ્રી ચંદ્ર દેવ', 'aaaag-110', 'AAAAG-110', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 15:00:07'),
(111, 4, 'જય શ્રી એકંદતય', 'aaaah-111', 'AAAAH-111', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(112, 4, 'જય શ્રી ભીમ', 'aaaai-112', 'AAAAI-112', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-12 10:49:16'),
(113, 4, 'જય શ્રી શંકર પાર્વતી', 'aaaaj-113', 'AAAAJ-113', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(114, 4, 'જય શ્રી અગ્નિ દેવ', 'aaaak-114', 'AAAAK-114', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 17:21:32'),
(115, 4, 'જય શ્રી વાયુ દેવ', 'aaaal-115', 'AAAAL-115', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(116, 4, 'જય સત્યનારાયણ', 'aaaam-116', 'AAAAM-116', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(117, 4, 'જય જગનાથ', 'aaaan-117', 'AAAAN-117', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:17:01'),
(118, 4, 'જય શ્રી ભદ્રકાળી', 'aaaao-118', 'AAAAO-118', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-12 10:50:10'),
(119, 4, 'જય શ્રી ઉટકેશ્વર મહાદેવ', 'aaaap-119', 'AAAAP-119', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(120, 4, 'લક્ષ્મી નારાયણ', 'aaaaq-120', 'AAAAQ-120', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(121, 4, 'જય શ્રી કુંબેર ભંડારી', 'aaaar-121', 'AAAAR-121', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(122, 4, 'શ્રી પાનેતર ડુગર ચામુંડા માં', 'aaaas-122', 'AAAAS-122', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(123, 4, 'શ્રી સુદર્શન ચક્ર', 'aaaat-123', 'AAAAT-123', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(124, 4, 'જય શ્રી વાસુદેવ', 'aaaau-124', 'AAAAU-124', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(125, 4, 'જય પશુપતિ નાથ', 'aaaav-125', 'AAAAV-125', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(126, 3, 'રાપર ચંડી ચામુંડા', 'aaaaw-126', 'AAAAW-126', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 17:52:52'),
(127, 4, 'વાગડ ચંડી ચામુંડા', 'aaaax-127', 'AAAAX-127', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 12:09:50'),
(128, 4, 'જય ગોદાવરી મૈયા', 'aaaay-128', 'AAAAY-128', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(129, 4, 'જય કસીવિશ્વનાથ', 'aaaaz-129', 'AAAAZ-129', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:21:27'),
(130, 4, 'જય મલિકાઅર્જુન', 'aaaay-130', 'AAAAAA-130', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 17:30:32'),
(131, 4, 'જય ઓમકાલેસ્વર', 'aaaaz-131', 'AAAAZ-131', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-22 14:50:54'),
(132, 4, 'જય વેજનાથ', 'aaaaaa-132', 'AAAAAA-132', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(133, 4, 'જય ભીમાશંકર', 'aaaaab-133', 'AAAAAB-133', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 16:53:17'),
(134, 4, 'જય નાગેશ્વર', 'aaaaac-134', 'AAAAAC-134', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 16:52:08'),
(135, 4, 'જય ત્રબ્કેશ્વર', 'aaaaad-135', 'AAAAAD-135', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(136, 4, 'જય ધૂણેશ્વર', 'aaaaaf-136', 'AAAAAF-136', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 15:45:18'),
(137, 4, 'જય નર નારાયણ', 'aaaaag-137', 'AAAAAG-137', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 15:45:18'),
(138, 4, 'જય લવ કુશ', 'aaaaah-138', 'AAAAAH-138', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 16:10:41'),
(139, 4, 'જય રોકડિયા હનુમાન', 'aaaaai-139', 'AAAAAI-139', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(140, 4, 'જય સિદ્ધિવિનાયક', 'aaaaaj-140', 'AAAAAJ-140', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 15:37:28');

-- --------------------------------------------------------

--
-- Table structure for table `trip_master`
--

DROP TABLE IF EXISTS `trip_master`;
CREATE TABLE IF NOT EXISTS `trip_master` (
  `trip_id` int NOT NULL AUTO_INCREMENT,
  `trip_date` date NOT NULL,
  `truck_id` int NOT NULL,
  `driver_id` int NOT NULL,
  `product` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `source` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `destination` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `no_of_bags` int DEFAULT NULL,
  `weight` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `total_weight` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`trip_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `truck_master`
--

DROP TABLE IF EXISTS `truck_master`;
CREATE TABLE IF NOT EXISTS `truck_master` (
  `truck_id` int NOT NULL AUTO_INCREMENT,
  `godown_id` int DEFAULT NULL,
  `truck_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `truck_number` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=inside, 1=outside',
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`truck_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `truck_master`
--

INSERT INTO `truck_master` (`truck_id`, `godown_id`, `truck_name`, `slug`, `truck_number`, `status`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 1, 'test truck name', 'test-truck-name', '0123456', 0, 1, 0, '2025-12-12 14:05:56', '2025-12-12 14:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `role_id` int NOT NULL DEFAULT '2' COMMENT '1=Admin, 2=TA/TP',
  `otp` int DEFAULT NULL,
  `otpTimeOut` datetime DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `device_token` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile_number`, `email_verified_at`, `password`, `role_id`, `otp`, `otpTimeOut`, `status`, `remember_token`, `device_token`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'admin', 'admin@admin.com', '9876543210', NULL, '$2y$10$sPrSb4x/ajMNN4OAnT6pLe4jQXOovPn.05aQ9HlpTA5faYqRTUilO', 1, NULL, NULL, 1, NULL, NULL, '2022-09-12 04:33:06', '2025-09-30 05:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_master`
--

DROP TABLE IF EXISTS `vendor_master`;
CREATE TABLE IF NOT EXISTS `vendor_master` (
  `vendor_id` int NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `contact_person` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `gst_number` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `iStatus` int NOT NULL DEFAULT '1',
  `isDelete` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`vendor_id`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `unique_mobile` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `vendor_master`
--

INSERT INTO `vendor_master` (`vendor_id`, `vendor_name`, `contact_person`, `email`, `mobile`, `address`, `gst_number`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'abcd', 'Bansari Patel', 'dev1.apolloinfotech@gmail.com', '09987654321', 'Sola', 'o3980', 1, 0, '2025-09-29 18:20:06', '2025-09-29 18:20:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
