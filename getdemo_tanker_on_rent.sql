-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 24, 2025 at 01:26 PM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `getdemo_tanker_on_rent`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

CREATE TABLE `customer_master` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `customer_mobile` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`customer_id`, `customer_name`, `customer_mobile`, `customer_email`, `customer_address`, `customer_type`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'prerna', '09790954014', 'dev5.apolloinfotech@gmail.com', '3/176, Samathuva Nagar Main Road, 14, Kazhipathur, Padur Post', 'retailer', 1, 0, '2025-09-19 16:35:32', '2025-10-10 14:59:48'),
(2, 'lgglkg;kg', '3409-094-096', 'dev1.apolloinfotech@gmail.com', 'Sola\r\nScience City', NULL, 1, 1, '2025-09-29 18:17:12', '2025-09-29 18:17:49'),
(3, 'Krunal shah', '9824773136', 'dev4.apolloinfotech@gmail.com', 'isanpur', 'customer', 1, 0, '2025-09-30 12:51:55', '2025-10-10 14:59:41'),
(4, 'પ્રેરણા અર્પિત પારેખ', '09987654321', 'dev1.apolloinfotech@gmail.com', 'સોલા\r\nસાયન્સ સિટી', 'retailer', 1, 1, '2025-10-13 11:41:04', '2025-10-13 11:41:19'),
(5, 'Asif Bhai', '9825717492', NULL, 'anand', 'retailer', 1, 0, '2025-11-24 10:15:16', '2025-11-24 10:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `daily_expence_master`
--

CREATE TABLE `daily_expence_master` (
  `expence_id` int(11) NOT NULL,
  `expence_type_id` int(11) NOT NULL,
  `expence_date` date DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `comment` longtext COLLATE utf8_unicode_ci,
  `iStatus` tinyint(4) NOT NULL DEFAULT '1',
  `isDelete` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `daily_expence_master`
--

INSERT INTO `daily_expence_master` (`expence_id`, `expence_type_id`, `expence_date`, `amount`, `comment`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-09-30', 200, 'test', 1, 0, '2025-09-27 14:59:32', '2025-09-30 13:32:33'),
(2, 2, '2025-09-26', 100, NULL, 1, 0, '2025-09-27 16:45:27', '2025-09-30 13:06:32'),
(3, 2, '2025-09-26', 1000, NULL, 1, 0, '2025-10-08 07:06:33', '2025-10-08 07:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `daily_expence_type`
--

CREATE TABLE `daily_expence_type` (
  `expence_type_id` int(11) NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `daily_expence_type`
--

INSERT INTO `daily_expence_type` (`expence_type_id`, `type`, `slug`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'fuel', 'fuel', 1, 0, '2025-09-27 14:58:45', '2025-09-29 17:52:17'),
(2, 'Office', 'office', 1, 0, '2025-09-27 15:47:20', '2025-09-30 11:15:27'),
(3, 'Management', '', 1, 0, '2025-09-27 16:55:32', '2025-09-27 16:55:32'),
(4, 'Salary', 'salary', 1, 0, '2025-09-30 11:15:17', '2025-09-30 11:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `daily_order`
--

CREATE TABLE `daily_order` (
  `daily_order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `customer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rent_date` date NOT NULL,
  `placed_the_tanker` int(11) DEFAULT NULL,
  `empty_the_tanker` int(11) DEFAULT NULL,
  `filled_the_tanker` int(11) DEFAULT NULL,
  `total_amount` int(11) NOT NULL,
  `isPaid` int(11) NOT NULL DEFAULT '0' COMMENT '0 =unpaid, 1=paid',
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `daily_order`
--

INSERT INTO `daily_order` (`daily_order_id`, `customer_id`, `customer_name`, `mobile`, `location`, `rent_date`, `placed_the_tanker`, `empty_the_tanker`, `filled_the_tanker`, `total_amount`, `isPaid`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 0, 'Harish Thakkar', '9876543210', 'nadiad', '2025-10-10', 0, 0, NULL, 900, 0, 1, 0, '2025-10-10 23:28:05', '2025-10-10 23:28:05'),
(2, 1, 'prerna', '09790954014', 'nadiad', '2025-10-07', 0, 0, NULL, 300, 0, 1, 0, '2025-10-10 23:28:35', '2025-10-10 23:28:35'),
(3, 3, 'Krunal shah', '9824773136', 'Ahmedabad', '2025-10-10', 0, 0, NULL, 900, 0, 1, 0, '2025-10-11 00:06:51', '2025-10-11 00:06:51'),
(5, 3, 'Krunal shah', '9824773136', 'Ahmedabad', '2025-10-12', 900, 300, 200, 1400, 0, 1, 0, '2025-10-12 00:03:29', '2025-10-12 00:03:29'),
(9, 0, 'Bharti Devani', '9723391747', 'Ahmedabad', '2025-10-12', 800, 100, 200, 1100, 0, 1, 0, '2025-10-12 00:30:18', '2025-10-12 00:30:18'),
(13, 5, 'Asif Bhai', '9825717492', 'Present hotel', '2025-11-24', 900, 0, 0, 900, 0, 1, 0, '2025-11-24 10:15:44', '2025-11-24 10:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `daily_order_ledger`
--

CREATE TABLE `daily_order_ledger` (
  `ledger_id` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `daily_order_id` int(11) DEFAULT NULL,
  `entry_date` date NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `debit_bl` decimal(12,2) NOT NULL DEFAULT '0.00',
  `credit_bl` decimal(12,2) NOT NULL DEFAULT '0.00',
  `closing_bl` decimal(12,2) NOT NULL,
  `iStatus` tinyint(4) NOT NULL DEFAULT '1',
  `isDelete` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `daily_order_ledger`
--

INSERT INTO `daily_order_ledger` (`ledger_id`, `customer_id`, `daily_order_id`, `entry_date`, `comment`, `debit_bl`, `credit_bl`, `closing_bl`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 0, 1, '2025-10-10', 'Order created', 900.00, 0.00, 900.00, 1, 0, '2025-10-10 23:28:06', '2025-10-10 23:28:06'),
(2, 1, 2, '2025-10-07', 'Order created', 300.00, 0.00, 300.00, 1, 0, '2025-10-10 23:28:35', '2025-10-10 23:28:35'),
(3, 3, 3, '2025-10-10', 'Order created', 900.00, 0.00, 900.00, 1, 0, '2025-10-11 00:06:51', '2025-10-11 00:06:51'),
(4, 3, 3, '2025-10-11', '100 unpaid', 0.00, 800.00, 100.00, 1, 0, '2025-10-11 00:30:03', '2025-10-11 00:30:03'),
(6, 3, 5, '2025-10-12', 'Order debit', 1400.00, 0.00, 1500.00, 1, 0, '2025-10-12 00:03:29', '2025-10-12 00:03:29'),
(13, 0, 9, '2025-10-12', 'Order debit', 1100.00, 0.00, 5900.00, 1, 0, '2025-10-12 00:30:18', '2025-10-12 00:30:18'),
(15, 0, NULL, '2025-10-12', 'Order amount increased', 1000.00, 0.00, 7900.00, 1, 0, '2025-10-12 00:38:33', '2025-10-12 01:10:33'),
(16, 0, NULL, '2025-10-12', 'Order amount increased', 1050.00, 0.00, 8950.00, 1, 0, '2025-10-12 00:38:41', '2025-10-12 01:06:58'),
(23, 0, NULL, '2025-10-12', 'Order reversed (Order#12)', 0.00, 1050.00, 7900.00, 1, 0, '2025-10-12 01:06:58', '2025-10-12 01:06:58'),
(24, 0, NULL, '2025-10-12', 'Order reversed (Order#11)', 0.00, 1000.00, 6900.00, 1, 0, '2025-10-12 01:10:33', '2025-10-12 01:10:33'),
(25, 0, 9, '2025-10-12', 'Payment received for Order #9', 0.00, 150.00, 6750.00, 1, 0, '2025-10-12 01:26:36', '2025-10-12 01:26:36'),
(26, 3, 5, '2025-10-13', 'Payment received', 0.00, 200.00, 1200.00, 1, 0, '2025-10-13 16:33:26', '2025-10-13 16:33:26'),
(27, 3, 3, '2025-10-13', 'Payment received', 0.00, 100.00, 0.00, 1, 0, '2025-10-13 16:33:36', '2025-10-13 16:33:36'),
(28, 5, 13, '2025-11-24', 'Order debit', 900.00, 0.00, 900.00, 1, 0, '2025-11-24 10:15:44', '2025-11-24 10:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `employee_extra_withdrawal`
--

CREATE TABLE `employee_extra_withdrawal` (
  `withdrawal_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `withdrawal_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emi_amount` int(11) DEFAULT NULL,
  `remaining_amount` int(11) DEFAULT NULL,
  `isActive` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employee_extra_withdrawal`
--

INSERT INTO `employee_extra_withdrawal` (`withdrawal_id`, `emp_id`, `withdrawal_date`, `amount`, `reason`, `emi_amount`, `remaining_amount`, `isActive`, `created_at`, `updated_at`) VALUES
(2, 1, '2025-10-06', 2000.00, 'personal reason', 500, 1500, 0, '2025-10-08 10:49:40', '2025-10-13 08:35:39'),
(3, 5, '2025-11-01', 109200.00, 'ok', 1000, 187200, 0, '2025-11-24 04:32:42', '2025-11-24 05:07:35'),
(4, 6, '2025-11-24', 18500.00, 'ok', 1000, 18500, 0, '2025-11-24 04:34:10', '2025-11-24 04:34:10'),
(5, 11, '2025-11-24', 500.00, 'ok', 1000, 500, 0, '2025-11-24 04:34:33', '2025-11-24 04:34:33'),
(6, 9, '2025-11-24', 12100.00, NULL, 1000, 12100, 0, '2025-11-24 04:35:00', '2025-11-24 04:35:00'),
(7, 7, '2025-11-24', 19000.00, NULL, 1000, 19000, 0, '2025-11-24 04:35:15', '2025-11-24 04:35:15');

-- --------------------------------------------------------

--
-- Table structure for table `employee_master`
--

CREATE TABLE `employee_master` (
  `emp_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `daily_wages` int(11) DEFAULT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employee_master`
--

INSERT INTO `employee_master` (`emp_id`, `name`, `designation`, `mobile`, `address`, `daily_wages`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(5, 'Shailesh Bhai', 'Driver', '9876543210', 'anand', 400, 1, 0, '2025-11-24 09:44:37', '2025-11-24 09:44:37'),
(6, 'Vijay bhai', 'Driver', '9876543211', 'chklasi', 400, 1, 0, '2025-11-24 09:45:17', '2025-11-24 09:45:17'),
(7, 'Pappu bhai', 'Driver', '987654322', 'chalasi', 400, 1, 0, '2025-11-24 09:45:43', '2025-11-24 09:45:43'),
(8, 'Mini bhai', 'Driver', '987654323', 'labhel', 400, 1, 0, '2025-11-24 09:46:17', '2025-11-24 09:46:17'),
(9, 'Meet Bhai', 'Conductor', '987654324', 'anand', 300, 1, 0, '2025-11-24 09:47:04', '2025-11-24 09:47:04'),
(10, 'Sanjay bhai', 'Mehtaji', '987654325', 'devkapura', 400, 1, 0, '2025-11-24 09:47:37', '2025-11-24 09:47:37'),
(11, 'Jagdish bhai', 'Conductor', '987654326', 'anand', 300, 1, 0, '2025-11-24 09:48:25', '2025-11-24 09:48:25'),
(12, 'Hitesh bahi', 'driver', '987654328', 'chacklasi', 400, 1, 0, '2025-11-24 09:55:22', '2025-11-24 09:55:22');

-- --------------------------------------------------------

--
-- Table structure for table `emp_attendance_master`
--

CREATE TABLE `emp_attendance_master` (
  `attendance_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `leave_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enter_by` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emp_attendance_master`
--

INSERT INTO `emp_attendance_master` (`attendance_id`, `emp_id`, `attendance_date`, `status`, `leave_reason`, `enter_by`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-09-26', 'P', NULL, '1', 1, 0, '2025-09-26 16:49:22', '2025-09-26 16:49:22'),
(2, 1, '2025-09-26', 'P', NULL, '1', 1, 0, '2025-09-26 16:49:22', '2025-09-26 16:49:22'),
(3, 2, '2025-09-27', 'P', NULL, '1', 1, 0, '2025-09-27 17:53:14', '2025-09-27 17:53:14'),
(4, 1, '2025-09-27', 'P', NULL, '1', 1, 0, '2025-09-27 17:53:14', '2025-09-27 17:53:14'),
(5, 2, '2025-09-25', 'P', NULL, '1', 1, 0, '2025-09-27 18:03:34', '2025-09-27 18:03:34'),
(6, 1, '2025-09-25', 'H', NULL, '1', 1, 0, '2025-09-27 18:03:34', '2025-09-27 18:03:34'),
(7, 2, '2025-09-29', 'P', NULL, '1', 1, 0, '2025-09-29 18:22:19', '2025-09-29 18:22:19'),
(8, 1, '2025-09-29', 'P', NULL, '1', 1, 0, '2025-09-29 18:22:19', '2025-09-29 18:22:19'),
(9, 2, '2025-09-28', 'A', 'personal Reason', '1', 1, 0, '2025-09-29 18:23:14', '2025-09-29 18:23:14'),
(10, 1, '2025-09-28', 'A', 'personal Reason', '1', 1, 0, '2025-09-29 18:23:14', '2025-09-29 18:23:14'),
(11, 2, '2025-09-30', 'P', NULL, '1', 1, 0, '2025-09-30 15:03:07', '2025-09-30 15:03:07'),
(12, 1, '2025-09-30', 'H', NULL, '1', 1, 0, '2025-09-30 15:03:07', '2025-09-30 15:03:07'),
(13, 2, '2025-09-11', 'P', NULL, '1', 1, 0, '2025-09-30 15:03:44', '2025-09-30 15:03:44'),
(14, 1, '2025-09-11', 'H', NULL, '1', 1, 0, '2025-09-30 15:03:44', '2025-09-30 15:03:44'),
(15, 2, '2025-09-18', 'P', NULL, '1', 1, 0, '2025-09-30 15:17:07', '2025-09-30 15:17:07'),
(16, 1, '2025-09-18', 'P', NULL, '1', 1, 0, '2025-09-30 15:17:07', '2025-09-30 15:17:07'),
(17, 2, '2025-10-06', 'A', 'test', '1', 1, 0, '2025-10-06 13:02:40', '2025-10-06 13:02:40'),
(18, 1, '2025-10-06', 'P', NULL, '1', 1, 0, '2025-10-06 13:02:40', '2025-10-06 13:02:40'),
(19, 2, '2025-09-09', 'P', NULL, '1', 1, 0, '2025-10-08 17:35:51', '2025-10-08 17:35:51'),
(20, 1, '2025-09-09', 'P', NULL, '1', 1, 0, '2025-10-08 17:35:51', '2025-10-08 17:35:51'),
(21, 2, '2025-09-08', 'P', NULL, '1', 1, 0, '2025-10-08 17:35:58', '2025-10-08 17:35:58'),
(22, 1, '2025-09-08', 'P', NULL, '1', 1, 0, '2025-10-08 17:35:58', '2025-10-08 17:35:58'),
(23, 2, '2025-09-07', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:04', '2025-10-08 17:36:04'),
(24, 1, '2025-09-07', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:04', '2025-10-08 17:36:04'),
(25, 2, '2025-09-06', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:09', '2025-10-08 17:36:09'),
(26, 1, '2025-09-06', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:09', '2025-10-08 17:36:09'),
(27, 2, '2025-09-05', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:14', '2025-10-08 17:36:14'),
(28, 1, '2025-09-05', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:14', '2025-10-08 17:36:14'),
(29, 2, '2025-09-04', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:18', '2025-10-08 17:36:18'),
(30, 1, '2025-09-04', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:18', '2025-10-08 17:36:18'),
(31, 2, '2025-09-03', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:27', '2025-10-08 17:36:27'),
(32, 1, '2025-09-03', 'H', NULL, '1', 1, 0, '2025-10-08 17:36:27', '2025-10-08 17:36:27'),
(33, 2, '2025-09-02', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:32', '2025-10-08 17:36:32'),
(34, 1, '2025-09-02', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:32', '2025-10-08 17:36:32'),
(35, 2, '2025-09-01', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:37', '2025-10-08 17:36:37'),
(36, 1, '2025-09-01', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:37', '2025-10-08 17:36:37'),
(37, 2, '2025-09-10', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:44', '2025-10-08 17:36:44'),
(38, 1, '2025-09-10', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:44', '2025-10-08 17:36:44'),
(39, 2, '2025-09-12', 'P', NULL, '1', 1, 0, '2025-10-08 17:36:55', '2025-10-08 17:36:55'),
(40, 1, '2025-09-12', 'H', NULL, '1', 1, 0, '2025-10-08 17:36:55', '2025-10-08 17:36:55'),
(41, 2, '2025-09-13', 'H', NULL, '1', 1, 0, '2025-10-08 17:37:01', '2025-10-08 17:37:01'),
(42, 1, '2025-09-13', 'P', NULL, '1', 1, 0, '2025-10-08 17:37:01', '2025-10-08 17:37:01'),
(43, 2, '2025-09-14', 'P', NULL, '1', 1, 0, '2025-10-08 17:37:09', '2025-10-08 17:37:09'),
(44, 1, '2025-09-14', 'P', NULL, '1', 1, 0, '2025-10-08 17:37:09', '2025-10-08 17:37:09'),
(45, 2, '2025-09-15', 'H', NULL, '1', 1, 0, '2025-10-08 17:37:17', '2025-10-08 17:37:17'),
(46, 1, '2025-09-15', 'H', NULL, '1', 1, 0, '2025-10-08 17:37:17', '2025-10-08 17:37:17'),
(47, 11, '2025-11-06', 'A', NULL, '1', 1, 0, '2025-11-24 09:49:29', '2025-11-24 09:49:29'),
(48, 9, '2025-11-06', 'P', NULL, '1', 1, 0, '2025-11-24 09:49:29', '2025-11-24 09:49:29'),
(49, 8, '2025-11-06', 'A', NULL, '1', 1, 0, '2025-11-24 09:49:29', '2025-11-24 09:49:29'),
(50, 7, '2025-11-06', 'P', NULL, '1', 1, 0, '2025-11-24 09:49:29', '2025-11-24 09:49:29'),
(51, 10, '2025-11-06', 'P', NULL, '1', 1, 0, '2025-11-24 09:49:29', '2025-11-24 09:49:29'),
(52, 5, '2025-11-06', 'P', NULL, '1', 1, 0, '2025-11-24 09:49:29', '2025-11-24 09:49:29'),
(53, 6, '2025-11-06', 'P', NULL, '1', 1, 0, '2025-11-24 09:49:29', '2025-11-24 09:49:29'),
(54, 11, '2025-11-07', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:04', '2025-11-24 09:50:04'),
(55, 9, '2025-11-07', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:04', '2025-11-24 09:50:04'),
(56, 8, '2025-11-07', 'A', NULL, '1', 1, 0, '2025-11-24 09:50:04', '2025-11-24 09:50:04'),
(57, 7, '2025-11-07', 'A', NULL, '1', 1, 0, '2025-11-24 09:50:04', '2025-11-24 09:50:04'),
(58, 10, '2025-11-07', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:04', '2025-11-24 09:50:04'),
(59, 5, '2025-11-07', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:04', '2025-11-24 09:50:04'),
(60, 6, '2025-11-07', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:04', '2025-11-24 09:50:04'),
(61, 11, '2025-11-08', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:41', '2025-11-24 09:50:41'),
(62, 9, '2025-11-08', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:41', '2025-11-24 09:50:41'),
(63, 8, '2025-11-08', 'A', NULL, '1', 1, 0, '2025-11-24 09:50:41', '2025-11-24 09:50:41'),
(64, 7, '2025-11-08', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:41', '2025-11-24 09:50:41'),
(65, 10, '2025-11-08', 'H', NULL, '1', 1, 0, '2025-11-24 09:50:41', '2025-11-24 09:50:41'),
(66, 5, '2025-11-08', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:41', '2025-11-24 09:50:41'),
(67, 6, '2025-11-08', 'P', NULL, '1', 1, 0, '2025-11-24 09:50:41', '2025-11-24 09:50:41'),
(68, 11, '2025-11-09', 'P', NULL, '1', 1, 0, '2025-11-24 09:51:02', '2025-11-24 09:51:02'),
(69, 9, '2025-11-09', 'A', NULL, '1', 1, 0, '2025-11-24 09:51:02', '2025-11-24 09:51:02'),
(70, 8, '2025-11-09', 'A', NULL, '1', 1, 0, '2025-11-24 09:51:02', '2025-11-24 09:51:02'),
(71, 7, '2025-11-09', 'P', NULL, '1', 1, 0, '2025-11-24 09:51:02', '2025-11-24 09:51:02'),
(72, 10, '2025-11-09', 'P', NULL, '1', 1, 0, '2025-11-24 09:51:02', '2025-11-24 09:51:02'),
(73, 5, '2025-11-09', 'P', NULL, '1', 1, 0, '2025-11-24 09:51:02', '2025-11-24 09:51:02'),
(74, 6, '2025-11-09', 'P', NULL, '1', 1, 0, '2025-11-24 09:51:02', '2025-11-24 09:51:02'),
(75, 11, '2025-11-10', 'P', NULL, '1', 1, 0, '2025-11-24 09:51:37', '2025-11-24 09:51:37'),
(76, 9, '2025-11-10', 'P', NULL, '1', 1, 0, '2025-11-24 09:51:37', '2025-11-24 09:51:37'),
(77, 8, '2025-11-10', 'A', NULL, '1', 1, 0, '2025-11-24 09:51:37', '2025-11-24 09:51:37'),
(78, 7, '2025-11-10', 'A', NULL, '1', 1, 0, '2025-11-24 09:51:37', '2025-11-24 09:51:37'),
(79, 10, '2025-11-10', 'P', NULL, '1', 1, 0, '2025-11-24 09:51:37', '2025-11-24 09:51:37'),
(80, 5, '2025-11-10', 'P', NULL, '1', 1, 0, '2025-11-24 09:51:37', '2025-11-24 09:51:37'),
(81, 6, '2025-11-10', 'A', NULL, '1', 1, 0, '2025-11-24 09:51:37', '2025-11-24 09:51:37'),
(82, 11, '2025-11-11', 'P', NULL, '1', 1, 0, '2025-11-24 09:52:08', '2025-11-24 09:52:08'),
(83, 9, '2025-11-11', 'P', NULL, '1', 1, 0, '2025-11-24 09:52:08', '2025-11-24 09:52:08'),
(84, 8, '2025-11-11', 'A', NULL, '1', 1, 0, '2025-11-24 09:52:08', '2025-11-24 09:52:08'),
(85, 7, '2025-11-11', 'P', NULL, '1', 1, 0, '2025-11-24 09:52:08', '2025-11-24 09:52:08'),
(86, 10, '2025-11-11', 'A', NULL, '1', 1, 0, '2025-11-24 09:52:08', '2025-11-24 09:52:08'),
(87, 5, '2025-11-11', 'P', NULL, '1', 1, 0, '2025-11-24 09:52:08', '2025-11-24 09:52:08'),
(88, 6, '2025-11-11', 'P', NULL, '1', 1, 0, '2025-11-24 09:52:08', '2025-11-24 09:52:08'),
(89, 11, '2025-11-12', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:02', '2025-11-24 09:53:02'),
(90, 9, '2025-11-12', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:02', '2025-11-24 09:53:02'),
(91, 8, '2025-11-12', 'A', NULL, '1', 1, 0, '2025-11-24 09:53:02', '2025-11-24 09:53:02'),
(92, 7, '2025-11-12', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:02', '2025-11-24 09:53:02'),
(93, 10, '2025-11-12', 'A', NULL, '1', 1, 0, '2025-11-24 09:53:02', '2025-11-24 09:53:02'),
(94, 5, '2025-11-12', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:02', '2025-11-24 09:53:02'),
(95, 6, '2025-11-12', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:02', '2025-11-24 09:53:02'),
(96, 11, '2025-11-13', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:34', '2025-11-24 09:53:34'),
(97, 9, '2025-11-13', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:34', '2025-11-24 09:53:34'),
(98, 8, '2025-11-13', 'A', NULL, '1', 1, 0, '2025-11-24 09:53:34', '2025-11-24 09:53:34'),
(99, 7, '2025-11-13', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:34', '2025-11-24 09:53:34'),
(100, 10, '2025-11-13', 'A', NULL, '1', 1, 0, '2025-11-24 09:53:34', '2025-11-24 09:53:34'),
(101, 5, '2025-11-13', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:34', '2025-11-24 09:53:34'),
(102, 6, '2025-11-13', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:34', '2025-11-24 09:53:34'),
(103, 11, '2025-11-14', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:57', '2025-11-24 09:53:57'),
(104, 9, '2025-11-14', 'A', NULL, '1', 1, 0, '2025-11-24 09:53:57', '2025-11-24 09:53:57'),
(105, 8, '2025-11-14', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:57', '2025-11-24 09:53:57'),
(106, 7, '2025-11-14', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:57', '2025-11-24 09:53:57'),
(107, 10, '2025-11-14', 'A', NULL, '1', 1, 0, '2025-11-24 09:53:57', '2025-11-24 09:53:57'),
(108, 5, '2025-11-14', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:57', '2025-11-24 09:53:57'),
(109, 6, '2025-11-14', 'P', NULL, '1', 1, 0, '2025-11-24 09:53:57', '2025-11-24 09:53:57'),
(110, 11, '2025-11-15', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:07', '2025-11-24 09:54:07'),
(111, 9, '2025-11-15', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:07', '2025-11-24 09:54:07'),
(112, 8, '2025-11-15', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:07', '2025-11-24 09:54:07'),
(113, 7, '2025-11-15', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:07', '2025-11-24 09:54:07'),
(114, 10, '2025-11-15', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:07', '2025-11-24 09:54:07'),
(115, 5, '2025-11-15', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:07', '2025-11-24 09:54:07'),
(116, 6, '2025-11-15', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:07', '2025-11-24 09:54:07'),
(117, 11, '2025-11-16', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:27', '2025-11-24 09:54:27'),
(118, 9, '2025-11-16', 'H', NULL, '1', 1, 0, '2025-11-24 09:54:27', '2025-11-24 09:54:27'),
(119, 8, '2025-11-16', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:27', '2025-11-24 09:54:27'),
(120, 7, '2025-11-16', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:27', '2025-11-24 09:54:27'),
(121, 10, '2025-11-16', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:27', '2025-11-24 09:54:27'),
(122, 5, '2025-11-16', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:27', '2025-11-24 09:54:27'),
(123, 6, '2025-11-16', 'P', NULL, '1', 1, 0, '2025-11-24 09:54:27', '2025-11-24 09:54:27'),
(124, 12, '2025-11-17', 'P', NULL, '1', 1, 0, '2025-11-24 09:57:22', '2025-11-24 09:57:22'),
(125, 11, '2025-11-17', 'P', NULL, '1', 1, 0, '2025-11-24 09:57:22', '2025-11-24 09:57:22'),
(126, 9, '2025-11-17', 'A', NULL, '1', 1, 0, '2025-11-24 09:57:22', '2025-11-24 09:57:22'),
(127, 8, '2025-11-17', 'P', NULL, '1', 1, 0, '2025-11-24 09:57:22', '2025-11-24 09:57:22'),
(128, 7, '2025-11-17', 'A', NULL, '1', 1, 0, '2025-11-24 09:57:22', '2025-11-24 09:57:22'),
(129, 10, '2025-11-17', 'P', NULL, '1', 1, 0, '2025-11-24 09:57:22', '2025-11-24 09:57:22'),
(130, 5, '2025-11-17', 'P', NULL, '1', 1, 0, '2025-11-24 09:57:22', '2025-11-24 09:57:22'),
(131, 6, '2025-11-17', 'A', NULL, '1', 1, 0, '2025-11-24 09:57:22', '2025-11-24 09:57:22'),
(132, 12, '2025-11-18', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:15', '2025-11-24 09:58:15'),
(133, 11, '2025-11-18', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:15', '2025-11-24 09:58:15'),
(134, 9, '2025-11-18', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:15', '2025-11-24 09:58:15'),
(135, 8, '2025-11-18', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:15', '2025-11-24 09:58:15'),
(136, 7, '2025-11-18', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:15', '2025-11-24 09:58:15'),
(137, 10, '2025-11-18', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:15', '2025-11-24 09:58:15'),
(138, 5, '2025-11-18', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:15', '2025-11-24 09:58:15'),
(139, 6, '2025-11-18', 'A', NULL, '1', 1, 0, '2025-11-24 09:58:15', '2025-11-24 09:58:15'),
(140, 12, '2025-11-19', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:47', '2025-11-24 09:58:47'),
(141, 11, '2025-11-19', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:47', '2025-11-24 09:58:47'),
(142, 9, '2025-11-19', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:47', '2025-11-24 09:58:47'),
(143, 8, '2025-11-19', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:47', '2025-11-24 09:58:47'),
(144, 7, '2025-11-19', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:47', '2025-11-24 09:58:47'),
(145, 10, '2025-11-19', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:47', '2025-11-24 09:58:47'),
(146, 5, '2025-11-19', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:47', '2025-11-24 09:58:47'),
(147, 6, '2025-11-19', 'P', NULL, '1', 1, 0, '2025-11-24 09:58:47', '2025-11-24 09:58:47'),
(148, 12, '2025-11-20', 'P', NULL, '1', 1, 0, '2025-11-24 09:59:08', '2025-11-24 09:59:08'),
(149, 11, '2025-11-20', 'H', NULL, '1', 1, 0, '2025-11-24 09:59:08', '2025-11-24 09:59:08'),
(150, 9, '2025-11-20', 'H', NULL, '1', 1, 0, '2025-11-24 09:59:08', '2025-11-24 09:59:08'),
(151, 8, '2025-11-20', 'P', NULL, '1', 1, 0, '2025-11-24 09:59:08', '2025-11-24 09:59:08'),
(152, 7, '2025-11-20', 'P', NULL, '1', 1, 0, '2025-11-24 09:59:08', '2025-11-24 09:59:08'),
(153, 10, '2025-11-20', 'P', NULL, '1', 1, 0, '2025-11-24 09:59:08', '2025-11-24 09:59:08'),
(154, 5, '2025-11-20', 'P', NULL, '1', 1, 0, '2025-11-24 09:59:08', '2025-11-24 09:59:08'),
(155, 6, '2025-11-20', 'P', NULL, '1', 1, 0, '2025-11-24 09:59:08', '2025-11-24 09:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `emp_salary`
--

CREATE TABLE `emp_salary` (
  `emp_salary_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `salary_date` datetime NOT NULL,
  `last_date` date DEFAULT NULL,
  `daily_wages` int(11) DEFAULT NULL,
  `salary_amount` int(11) NOT NULL,
  `withdrawal_deducted` decimal(10,2) DEFAULT '0.00',
  `withdrawal_id` int(11) NOT NULL DEFAULT '0',
  `mobile_recharge` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iStatus` tinyint(4) NOT NULL DEFAULT '1',
  `isDelete` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emp_salary`
--

INSERT INTO `emp_salary` (`emp_salary_id`, `emp_id`, `salary_date`, `last_date`, `daily_wages`, `salary_amount`, `withdrawal_deducted`, `withdrawal_id`, `mobile_recharge`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-09-01 00:00:00', '2025-09-15', 1000, 12550, 500.00, 2, '50', 1, 0, '2025-10-10 16:22:16', '2025-10-10 16:22:16');

-- --------------------------------------------------------

--
-- Table structure for table `godown_master`
--

CREATE TABLE `godown_master` (
  `godown_id` int(11) NOT NULL,
  `godown_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `godown_master`
--

INSERT INTO `godown_master` (`godown_id`, `godown_address`, `Name`, `slug`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'test godown address', 'test godown', '', 1, 0, '2025-09-25 16:31:14', '2025-09-25 16:37:56'),
(2, 'test address', 'test godown12', 'test-godown12', 1, 0, '2025-09-29 17:41:00', '2025-09-29 17:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_master`
--

CREATE TABLE `order_master` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_mobile` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tanker_id` int(11) NOT NULL,
  `rent_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'daily, monthly',
  `rent_start_date` datetime NOT NULL,
  `received_at` date DEFAULT NULL,
  `advance_amount` int(11) NOT NULL,
  `rent_amount` int(11) NOT NULL,
  `extra_amount` int(11) NOT NULL DEFAULT '0' COMMENT 'extra charges of month and day',
  `extra_duration` int(11) DEFAULT NULL,
  `extraDM` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'day or month',
  `reference_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reference_mobile_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reference_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tanker_location` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `contract_text` longtext COLLATE utf8_unicode_ci,
  `isReceive` int(11) NOT NULL DEFAULT '1' COMMENT '1= not received , 0=received',
  `iStatus` tinyint(4) NOT NULL DEFAULT '1',
  `isDelete` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_master`
--

INSERT INTO `order_master` (`order_id`, `customer_id`, `user_name`, `user_mobile`, `tanker_id`, `rent_type`, `rent_start_date`, `received_at`, `advance_amount`, `rent_amount`, `extra_amount`, `extra_duration`, `extraDM`, `reference_name`, `reference_mobile_no`, `reference_address`, `tanker_location`, `contract_text`, `isReceive`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 1, '1', '2025-08-23 17:55:00', NULL, 2000, 3000, 0, NULL, NULL, 'test ref name', '9874589878', 'test ref address', 'ahmedabad , maninager', NULL, 1, 1, 0, '2025-09-25 17:57:11', '2025-09-29 15:56:12'),
(8, 1, NULL, NULL, 2, '2', '2025-09-24 11:00:00', NULL, 100, 300, 3900, 13, '13 days', 'test ref name', '9874589878', 'test ref address', 'ahmedabad , maninager', NULL, 1, 1, 0, '2025-09-26 18:02:26', '2025-10-06 14:36:23'),
(7, 1, NULL, NULL, 2, '2', '2025-02-25 18:00:00', NULL, 100, 300, 0, NULL, NULL, 'test ref name', '9874589878', 'test ref address', 'ahmedabad , maninager', NULL, 1, 1, 1, '2025-09-26 18:01:07', '2025-09-26 18:14:45'),
(9, 3, 'jhhjj', '84748487878', 3, '1', '2025-09-04 16:08:00', '2025-10-07', 1000, 3000, 6000, NULL, '2 months', 'test ref name', '9874589878', 'test ref address', 'ahmedabad , maninager', 'jkhkhjkh', 1, 1, 0, '2025-10-04 16:09:09', '2025-10-11 14:33:18'),
(10, 1, 'jhhjj', '84748487878', 3, '1', '2025-10-11 14:31:00', NULL, 500, 3500, 0, NULL, NULL, 'test ref name', '9874589878', 'test ref address', 'ahmedabad , maninager', 'test', 1, 1, 0, '2025-10-11 14:32:25', '2025-10-11 14:33:18'),
(11, 1, 'jhhjj', '84748487878', 3, '1', '2025-10-11 14:31:00', NULL, 500, 3000, 0, NULL, NULL, 'test ref name', '9874589878', 'test ref address', 'ahmedabad , maninager', 'test', 1, 1, 0, '2025-10-11 14:33:02', '2025-10-11 14:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_payment_master`
--

CREATE TABLE `order_payment_master` (
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `unpaid_amount` int(11) NOT NULL,
  `payment_received_by` int(11) DEFAULT '0',
  `payment_date` date DEFAULT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_payment_master`
--

INSERT INTO `order_payment_master` (`payment_id`, `customer_id`, `order_id`, `total_amount`, `paid_amount`, `unpaid_amount`, `payment_received_by`, `payment_date`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 3000, 200, 2800, 1, NULL, 1, 0, '2025-09-26 15:58:28', '2025-09-26 15:58:28'),
(3, 1, 1, 3000, 2000, 1000, 2, NULL, 1, 0, '2025-09-26 15:57:59', '2025-09-26 15:57:59'),
(5, 1, 1, 3000, 100, 700, 1, NULL, 1, 0, '2025-09-26 16:23:24', '2025-09-26 16:23:24'),
(6, 1, 7, 300, 100, 200, 2, NULL, 1, 0, '2025-09-26 18:01:07', '2025-09-26 18:01:07'),
(7, 1, 8, 300, 100, 200, 1, NULL, 1, 0, '2025-09-26 18:02:26', '2025-09-26 18:02:26'),
(10, 3, 9, 3000, 1000, 2000, 1, NULL, 1, 0, '2025-10-04 16:09:09', '2025-10-04 16:09:09'),
(14, 3, 9, 6000, 2000, 3000, 2, NULL, 1, 0, '2025-10-08 06:10:35', '2025-10-08 06:10:35'),
(16, 3, 9, 6000, 1000, 2000, 1, '2025-10-06', 1, 0, '2025-10-08 06:42:46', '2025-10-08 06:42:46'),
(17, 1, 11, 3500, 500, 3000, 2, NULL, 1, 0, '2025-10-11 14:33:02', '2025-10-11 14:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `payment_received_user`
--

CREATE TABLE `payment_received_user` (
  `received_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '0',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_received_user`
--

INSERT INTO `payment_received_user` (`received_id`, `name`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'prerna', 1, 0, '2025-10-08 06:27:10', '2025-10-08 06:27:10');

-- --------------------------------------------------------

--
-- Table structure for table `rent_prices`
--

CREATE TABLE `rent_prices` (
  `rent_price_id` int(11) NOT NULL,
  `rent_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rent_prices`
--

INSERT INTO `rent_prices` (`rent_price_id`, `rent_type`, `amount`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'Monthly', '3000', 1, 0, '2025-09-26 15:45:31', '2025-09-26 15:45:31'),
(2, 'Daily', '200', 1, 0, '2025-09-26 15:45:31', '2025-09-26 15:45:31');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `sendemaildetails` (
  `id` int(11) NOT NULL,
  `strSubject` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `strTitle` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `strFromMail` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ToMail` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `strCC` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `strBCC` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `sitename` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `strIP` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `sitename`, `logo`, `email`, `iStatus`, `isDelete`, `created_at`, `updated_at`, `strIP`) VALUES
(1, 'Jewellery crm', '1746446528.png', 'dev5.apolloinfotech@gmail.com', 1, 0, '2025-05-05 12:02:08', NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `tanker_master`
--

CREATE TABLE `tanker_master` (
  `tanker_id` int(11) NOT NULL,
  `godown_id` int(11) DEFAULT NULL,
  `tanker_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tanker_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0=inside, 1=outside',
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tanker_master`
--

INSERT INTO `tanker_master` (`tanker_id`, `godown_id`, `tanker_name`, `slug`, `tanker_code`, `status`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 2, 'test', 'test', 'test_123', 1, 1, 0, '2025-09-25 15:28:06', '2025-10-01 15:36:30'),
(2, 1, 'tanker 2', 'tanker-2', 'tanker_12', 1, 1, 0, '2025-09-26 15:31:46', '2025-10-06 14:36:23'),
(3, 1, 'tanker 3', 'tanker-3', 'test_123', 1, 1, 0, '2025-09-29 16:49:30', '2025-10-11 14:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT '2' COMMENT '1=Admin, 2=TA/TP',
  `otp` int(11) DEFAULT NULL,
  `otpTimeOut` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_token` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `mobile_number`, `email_verified_at`, `password`, `role_id`, `otp`, `otpTimeOut`, `status`, `remember_token`, `device_token`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'admin', 'admin@admin.com', '9876543210', NULL, '$2y$10$sPrSb4x/ajMNN4OAnT6pLe4jQXOovPn.05aQ9HlpTA5faYqRTUilO', 1, NULL, NULL, 1, NULL, NULL, '2022-09-12 04:33:06', '2025-09-30 05:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_master`
--

CREATE TABLE `vendor_master` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `contact_person` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gst_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vendor_master`
--

INSERT INTO `vendor_master` (`vendor_id`, `vendor_name`, `contact_person`, `email`, `mobile`, `address`, `gst_number`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 'abcd', 'Bansari Patel', 'dev1.apolloinfotech@gmail.com', '09987654321', 'Sola', 'o3980', 1, 0, '2025-09-29 18:20:06', '2025-09-29 18:20:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_master`
--
ALTER TABLE `customer_master`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `daily_expence_master`
--
ALTER TABLE `daily_expence_master`
  ADD PRIMARY KEY (`expence_id`);

--
-- Indexes for table `daily_expence_type`
--
ALTER TABLE `daily_expence_type`
  ADD PRIMARY KEY (`expence_type_id`);

--
-- Indexes for table `daily_order`
--
ALTER TABLE `daily_order`
  ADD PRIMARY KEY (`daily_order_id`);

--
-- Indexes for table `daily_order_ledger`
--
ALTER TABLE `daily_order_ledger`
  ADD PRIMARY KEY (`ledger_id`),
  ADD KEY `idx_customer_date` (`customer_id`,`entry_date`),
  ADD KEY `idx_daily_order` (`daily_order_id`);

--
-- Indexes for table `employee_extra_withdrawal`
--
ALTER TABLE `employee_extra_withdrawal`
  ADD PRIMARY KEY (`withdrawal_id`),
  ADD KEY `fk_emp_withdrawal` (`emp_id`);

--
-- Indexes for table `employee_master`
--
ALTER TABLE `employee_master`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `emp_attendance_master`
--
ALTER TABLE `emp_attendance_master`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `FK_Attendance_Employee` (`emp_id`);

--
-- Indexes for table `emp_salary`
--
ALTER TABLE `emp_salary`
  ADD PRIMARY KEY (`emp_salary_id`);

--
-- Indexes for table `godown_master`
--
ALTER TABLE `godown_master`
  ADD PRIMARY KEY (`godown_id`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `order_master`
--
ALTER TABLE `order_master`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_payment_master`
--
ALTER TABLE `order_payment_master`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `payment_received_user`
--
ALTER TABLE `payment_received_user`
  ADD PRIMARY KEY (`received_id`);

--
-- Indexes for table `rent_prices`
--
ALTER TABLE `rent_prices`
  ADD PRIMARY KEY (`rent_price_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sendemaildetails`
--
ALTER TABLE `sendemaildetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tanker_master`
--
ALTER TABLE `tanker_master`
  ADD PRIMARY KEY (`tanker_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendor_master`
--
ALTER TABLE `vendor_master`
  ADD PRIMARY KEY (`vendor_id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `unique_mobile` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_master`
--
ALTER TABLE `customer_master`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `daily_expence_master`
--
ALTER TABLE `daily_expence_master`
  MODIFY `expence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `daily_expence_type`
--
ALTER TABLE `daily_expence_type`
  MODIFY `expence_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `daily_order`
--
ALTER TABLE `daily_order`
  MODIFY `daily_order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `daily_order_ledger`
--
ALTER TABLE `daily_order_ledger`
  MODIFY `ledger_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `employee_extra_withdrawal`
--
ALTER TABLE `employee_extra_withdrawal`
  MODIFY `withdrawal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee_master`
--
ALTER TABLE `employee_master`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `emp_attendance_master`
--
ALTER TABLE `emp_attendance_master`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `emp_salary`
--
ALTER TABLE `emp_salary`
  MODIFY `emp_salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `godown_master`
--
ALTER TABLE `godown_master`
  MODIFY `godown_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_master`
--
ALTER TABLE `order_master`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_payment_master`
--
ALTER TABLE `order_payment_master`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment_received_user`
--
ALTER TABLE `payment_received_user`
  MODIFY `received_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rent_prices`
--
ALTER TABLE `rent_prices`
  MODIFY `rent_price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sendemaildetails`
--
ALTER TABLE `sendemaildetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tanker_master`
--
ALTER TABLE `tanker_master`
  MODIFY `tanker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `vendor_master`
--
ALTER TABLE `vendor_master`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
