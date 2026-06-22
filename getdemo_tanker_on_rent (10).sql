-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2026 at 02:04 PM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.34

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
(1, 'prerna', '09790954014', 'dev5.apolloinfotech@gmail.com', '3/176, Samathuva Nagar Main Road, 14, Kazhipathur, Padur Post', 'retailer', 1, 1, '2025-09-19 16:35:32', '2026-05-18 10:23:20'),
(2, 'lgglkg;kg', '3409-094-096', 'dev1.apolloinfotech@gmail.com', 'Sola\r\nScience City', NULL, 1, 1, '2025-09-29 18:17:12', '2025-09-29 18:17:49'),
(3, 'Krunal shah', '9824773136', 'dev4.apolloinfotech@gmail.com', 'isanpur', 'customer', 1, 1, '2025-09-30 12:51:55', '2026-05-18 10:23:35'),
(4, 'પ્રેરણા અર્પિત પારેખ', '09987654321', 'dev1.apolloinfotech@gmail.com', 'સોલા\r\nસાયન્સ સિટી', 'retailer', 1, 1, '2025-10-13 11:41:04', '2025-10-13 11:41:19'),
(5, 'Asif Bhai', '9825717492', NULL, 'anand', 'retailer', 1, 1, '2025-11-24 10:15:16', '2026-05-18 10:23:43'),
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
(24, 'રતન સિંહ અમરસિંહ પરમાર', '7567020792', NULL, 'સંજયા', 'retailer', 1, 0, '2026-05-11 14:43:39', '2026-05-11 14:43:39'),
(26, 'અલ્પેશભાઈ ઉદસિંહ', '7984016008', NULL, 'આણંદ', 'retailer', 1, 0, '2026-05-18 11:01:15', '2026-05-18 11:01:15'),
(27, 'વિજયભાઈ શેખ', '9998539505', NULL, 'ચિકોદરા', 'retailer', 1, 0, '2026-06-12 09:42:29', '2026-06-12 09:42:29'),
(28, 'વિજયભાઈ શેખ', '9998539505', NULL, 'ચિકોદરા', 'retailer', 1, 0, '2026-06-12 09:42:29', '2026-06-12 09:42:29'),
(29, 'ગૌરાંગ ભાઈ પટેલ', '9512162627', NULL, 'નડિયાદ', 'retailer', 1, 0, '2026-06-16 14:59:47', '2026-06-16 14:59:47'),
(30, 'રવિરાજ દરબાર', '91577711111', NULL, 'નડિયાદ', 'retailer', 1, 1, '2026-06-18 18:12:13', '2026-06-18 18:12:27'),
(31, 'ભાવિન ભાઈ ભરવાડ', '6354464038', NULL, 'લુણાવ', 'retailer', 1, 0, '2026-06-20 15:08:31', '2026-06-20 15:08:31');

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

-- --------------------------------------------------------

--
-- Table structure for table `daily_order`
--

CREATE TABLE `daily_order` (
  `daily_order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `tanker_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rent_date` date NOT NULL,
  `placed_the_tanker` int(11) DEFAULT NULL,
  `empty_the_tanker` int(11) DEFAULT NULL,
  `filled_the_tanker` int(11) DEFAULT NULL,
  `extra_amount` int(11) DEFAULT '0',
  `total_amount` int(11) NOT NULL,
  `isPaid` int(11) NOT NULL DEFAULT '0' COMMENT '0 =unpaid, 1=paid',
  `received_at` date DEFAULT NULL,
  `isReceive` int(11) DEFAULT '1' COMMENT '1= not received , 0=received',
  `extra_duration` int(11) DEFAULT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `driver_master`
--

CREATE TABLE `driver_master` (
  `driver_id` int(11) NOT NULL,
  `driver_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 12, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12'),
(2, 8, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12'),
(3, 10, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12'),
(4, 14, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12'),
(5, 15, '2026-05-05', 'P', NULL, '1', 1, 0, '2026-05-13 16:06:12', '2026-05-13 16:06:12'),
(6, 12, '2026-05-17', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:28', '2026-05-18 11:31:28'),
(7, 11, '2026-05-17', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:28', '2026-05-18 11:31:28'),
(8, 9, '2026-05-17', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:28', '2026-05-18 11:31:28'),
(9, 8, '2026-05-17', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:28', '2026-05-18 11:31:28'),
(10, 13, '2026-05-17', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:28', '2026-05-18 11:31:28'),
(11, 10, '2026-05-17', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:28', '2026-05-18 11:31:28'),
(12, 5, '2026-05-17', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:28', '2026-05-18 11:31:28'),
(13, 14, '2026-05-17', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:28', '2026-05-18 11:31:28'),
(14, 15, '2026-05-17', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:28', '2026-05-18 11:31:28'),
(15, 12, '2026-05-18', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:46', '2026-05-18 11:31:46'),
(16, 11, '2026-05-18', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:46', '2026-05-18 11:31:46'),
(17, 13, '2026-05-18', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:46', '2026-05-18 11:31:46'),
(18, 10, '2026-05-18', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:46', '2026-05-18 11:31:46'),
(19, 5, '2026-05-18', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:46', '2026-05-18 11:31:46'),
(20, 6, '2026-05-18', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:46', '2026-05-18 11:31:46'),
(21, 14, '2026-05-18', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:46', '2026-05-18 11:31:46'),
(22, 15, '2026-05-18', 'P', NULL, '1', 1, 0, '2026-05-18 11:31:46', '2026-05-18 11:31:46'),
(23, 12, '2026-05-23', 'P', NULL, '1', 1, 0, '2026-05-23 12:40:57', '2026-05-23 12:40:57'),
(24, 11, '2026-05-23', 'P', NULL, '1', 1, 0, '2026-05-23 12:40:57', '2026-05-23 12:40:57'),
(25, 9, '2026-05-23', 'P', NULL, '1', 1, 0, '2026-05-23 12:40:57', '2026-05-23 12:40:57'),
(26, 8, '2026-05-23', 'P', NULL, '1', 1, 0, '2026-05-23 12:40:57', '2026-05-23 12:40:57'),
(27, 13, '2026-05-23', 'P', NULL, '1', 1, 0, '2026-05-23 12:40:57', '2026-05-23 12:40:57'),
(28, 10, '2026-05-23', 'P', NULL, '1', 1, 0, '2026-05-23 12:40:57', '2026-05-23 12:40:57'),
(29, 5, '2026-05-23', 'P', NULL, '1', 1, 0, '2026-05-23 12:40:57', '2026-05-23 12:40:57'),
(30, 6, '2026-05-23', 'P', NULL, '1', 1, 0, '2026-05-23 12:40:57', '2026-05-23 12:40:57'),
(31, 14, '2026-05-23', 'P', NULL, '1', 1, 0, '2026-05-23 12:40:57', '2026-05-23 12:40:57'),
(32, 11, '2026-06-13', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:22', '2026-06-13 14:43:22'),
(33, 9, '2026-06-13', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:22', '2026-06-13 14:43:22'),
(34, 8, '2026-06-13', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:22', '2026-06-13 14:43:22'),
(35, 5, '2026-06-13', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:22', '2026-06-13 14:43:22'),
(36, 6, '2026-06-13', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:22', '2026-06-13 14:43:22'),
(37, 14, '2026-06-13', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:22', '2026-06-13 14:43:22'),
(38, 15, '2026-06-13', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:22', '2026-06-13 14:43:22'),
(39, 12, '2026-06-12', 'H', NULL, '1', 1, 0, '2026-06-13 14:43:59', '2026-06-13 14:43:59'),
(40, 11, '2026-06-12', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:59', '2026-06-13 14:43:59'),
(41, 9, '2026-06-12', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:59', '2026-06-13 14:43:59'),
(42, 8, '2026-06-12', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:59', '2026-06-13 14:43:59'),
(43, 5, '2026-06-12', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:59', '2026-06-13 14:43:59'),
(44, 6, '2026-06-12', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:59', '2026-06-13 14:43:59'),
(45, 14, '2026-06-12', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:59', '2026-06-13 14:43:59'),
(46, 15, '2026-06-12', 'P', NULL, '1', 1, 0, '2026-06-13 14:43:59', '2026-06-13 14:43:59'),
(47, 12, '2026-06-11', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:00', '2026-06-13 14:46:00'),
(48, 11, '2026-06-11', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:00', '2026-06-13 14:46:00'),
(49, 9, '2026-06-11', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:00', '2026-06-13 14:46:00'),
(50, 8, '2026-06-11', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:00', '2026-06-13 14:46:00'),
(51, 5, '2026-06-11', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:00', '2026-06-13 14:46:00'),
(52, 6, '2026-06-11', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:00', '2026-06-13 14:46:00'),
(53, 14, '2026-06-11', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:00', '2026-06-13 14:46:00'),
(54, 15, '2026-06-11', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:00', '2026-06-13 14:46:00'),
(55, 12, '2026-06-10', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:55', '2026-06-13 14:46:55'),
(56, 11, '2026-06-10', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:55', '2026-06-13 14:46:55'),
(57, 5, '2026-06-10', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:55', '2026-06-13 14:46:55'),
(58, 6, '2026-06-10', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:55', '2026-06-13 14:46:55'),
(59, 14, '2026-06-10', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:55', '2026-06-13 14:46:55'),
(60, 15, '2026-06-10', 'P', NULL, '1', 1, 0, '2026-06-13 14:46:55', '2026-06-13 14:46:55'),
(61, 12, '2026-06-09', 'P', NULL, '1', 1, 0, '2026-06-13 14:48:04', '2026-06-13 14:48:04'),
(62, 11, '2026-06-09', 'P', NULL, '1', 1, 0, '2026-06-13 14:48:04', '2026-06-13 14:48:04'),
(63, 9, '2026-06-09', 'H', NULL, '1', 1, 0, '2026-06-13 14:48:04', '2026-06-13 14:48:04'),
(64, 8, '2026-06-09', 'P', NULL, '1', 1, 0, '2026-06-13 14:48:04', '2026-06-13 14:48:04'),
(65, 5, '2026-06-09', 'P', NULL, '1', 1, 0, '2026-06-13 14:48:04', '2026-06-13 14:48:04'),
(66, 6, '2026-06-09', 'P', NULL, '1', 1, 0, '2026-06-13 14:48:04', '2026-06-13 14:48:04'),
(67, 14, '2026-06-09', 'P', NULL, '1', 1, 0, '2026-06-13 14:48:04', '2026-06-13 14:48:04'),
(68, 15, '2026-06-09', 'P', NULL, '1', 1, 0, '2026-06-13 14:48:04', '2026-06-13 14:48:04'),
(69, 12, '2026-06-08', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:01', '2026-06-13 14:55:01'),
(70, 11, '2026-06-08', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:01', '2026-06-13 14:55:01'),
(71, 9, '2026-06-08', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:01', '2026-06-13 14:55:01'),
(72, 8, '2026-06-08', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:01', '2026-06-13 14:55:01'),
(73, 5, '2026-06-08', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:01', '2026-06-13 14:55:01'),
(74, 6, '2026-06-08', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:01', '2026-06-13 14:55:01'),
(75, 14, '2026-06-08', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:01', '2026-06-13 14:55:01'),
(76, 15, '2026-06-08', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:01', '2026-06-13 14:55:01'),
(77, 12, '2026-06-07', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:56', '2026-06-13 14:55:56'),
(78, 11, '2026-06-07', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:56', '2026-06-13 14:55:56'),
(79, 9, '2026-06-07', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:56', '2026-06-13 14:55:56'),
(80, 8, '2026-06-07', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:56', '2026-06-13 14:55:56'),
(81, 6, '2026-06-07', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:56', '2026-06-13 14:55:56'),
(82, 14, '2026-06-07', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:56', '2026-06-13 14:55:56'),
(83, 15, '2026-06-07', 'P', NULL, '1', 1, 0, '2026-06-13 14:55:56', '2026-06-13 14:55:56'),
(84, 12, '2026-06-06', 'P', NULL, '1', 1, 0, '2026-06-13 14:57:48', '2026-06-13 14:57:48'),
(85, 9, '2026-06-06', 'P', NULL, '1', 1, 0, '2026-06-13 14:57:48', '2026-06-13 14:57:48'),
(86, 8, '2026-06-06', 'P', NULL, '1', 1, 0, '2026-06-13 14:57:48', '2026-06-13 14:57:48'),
(87, 5, '2026-06-06', 'H', NULL, '1', 1, 0, '2026-06-13 14:57:48', '2026-06-13 14:57:48'),
(88, 14, '2026-06-06', 'P', NULL, '1', 1, 0, '2026-06-13 14:57:48', '2026-06-13 14:57:48'),
(89, 11, '2026-06-06', 'P', NULL, '1', 1, 0, '2026-06-13 14:58:40', '2026-06-13 14:58:40'),
(90, 12, '2026-06-05', 'P', NULL, '1', 1, 0, '2026-06-13 14:59:10', '2026-06-13 14:59:10'),
(91, 9, '2026-06-05', 'P', NULL, '1', 1, 0, '2026-06-13 14:59:10', '2026-06-13 14:59:10'),
(92, 8, '2026-06-05', 'P', NULL, '1', 1, 0, '2026-06-13 14:59:10', '2026-06-13 14:59:10'),
(93, 5, '2026-06-05', 'H', NULL, '1', 1, 0, '2026-06-13 14:59:10', '2026-06-13 14:59:10'),
(94, 14, '2026-06-05', 'P', NULL, '1', 1, 0, '2026-06-13 14:59:10', '2026-06-13 14:59:10'),
(95, 12, '2026-06-04', 'P', NULL, '1', 1, 0, '2026-06-13 14:59:40', '2026-06-13 14:59:40'),
(96, 9, '2026-06-04', 'P', NULL, '1', 1, 0, '2026-06-13 14:59:40', '2026-06-13 14:59:40'),
(97, 5, '2026-06-04', 'P', NULL, '1', 1, 0, '2026-06-13 14:59:40', '2026-06-13 14:59:40'),
(98, 14, '2026-06-04', 'P', NULL, '1', 1, 0, '2026-06-13 14:59:40', '2026-06-13 14:59:40'),
(99, 12, '2026-06-03', 'P', NULL, '1', 1, 0, '2026-06-13 15:00:11', '2026-06-13 15:00:11'),
(100, 8, '2026-06-03', 'P', NULL, '1', 1, 0, '2026-06-13 15:00:11', '2026-06-13 15:00:11'),
(101, 5, '2026-06-03', 'P', NULL, '1', 1, 0, '2026-06-13 15:00:11', '2026-06-13 15:00:11'),
(102, 14, '2026-06-03', 'P', NULL, '1', 1, 0, '2026-06-13 15:00:11', '2026-06-13 15:00:11'),
(103, 12, '2026-06-02', 'P', NULL, '1', 1, 0, '2026-06-13 15:00:35', '2026-06-13 15:00:35'),
(104, 5, '2026-06-02', 'P', NULL, '1', 1, 0, '2026-06-13 15:00:35', '2026-06-13 15:00:35'),
(105, 14, '2026-06-02', 'P', NULL, '1', 1, 0, '2026-06-13 15:00:35', '2026-06-13 15:00:35'),
(106, 12, '2026-06-01', 'P', NULL, '1', 1, 0, '2026-06-13 15:01:25', '2026-06-13 15:01:25'),
(107, 9, '2026-06-01', 'P', NULL, '1', 1, 0, '2026-06-13 15:01:25', '2026-06-13 15:01:25'),
(108, 5, '2026-06-01', 'P', NULL, '1', 1, 0, '2026-06-13 15:01:25', '2026-06-13 15:01:25'),
(109, 6, '2026-06-01', 'P', NULL, '1', 1, 0, '2026-06-13 15:01:25', '2026-06-13 15:01:25'),
(110, 14, '2026-06-01', 'P', NULL, '1', 1, 0, '2026-06-13 15:01:25', '2026-06-13 15:01:25'),
(111, 13, '2026-06-12', 'A', NULL, '1', 1, 0, '2026-06-13 15:02:41', '2026-06-13 15:02:41'),
(112, 10, '2026-06-12', 'A', NULL, '1', 1, 0, '2026-06-13 15:02:41', '2026-06-13 15:02:41'),
(113, 12, '2026-06-13', 'P', NULL, '1', 1, 0, '2026-06-13 15:03:03', '2026-06-13 15:03:03'),
(114, 13, '2026-06-13', 'A', NULL, '1', 1, 0, '2026-06-13 15:03:03', '2026-06-13 15:03:03'),
(115, 10, '2026-06-13', 'H', NULL, '1', 1, 0, '2026-06-13 15:03:03', '2026-06-13 15:03:03'),
(116, 13, '2026-06-11', 'A', NULL, '1', 1, 0, '2026-06-13 15:03:17', '2026-06-13 15:03:17'),
(117, 10, '2026-06-11', 'A', NULL, '1', 1, 0, '2026-06-13 15:03:17', '2026-06-13 15:03:17'),
(118, 9, '2026-06-10', 'A', NULL, '1', 1, 0, '2026-06-13 15:03:55', '2026-06-13 15:03:55'),
(119, 8, '2026-06-10', 'A', NULL, '1', 1, 0, '2026-06-13 15:03:55', '2026-06-13 15:03:55'),
(120, 13, '2026-06-10', 'A', NULL, '1', 1, 0, '2026-06-13 15:03:55', '2026-06-13 15:03:55'),
(121, 10, '2026-06-10', 'A', NULL, '1', 1, 0, '2026-06-13 15:03:55', '2026-06-13 15:03:55'),
(122, 13, '2026-06-09', 'A', NULL, '1', 1, 0, '2026-06-13 15:05:02', '2026-06-13 15:05:02'),
(123, 10, '2026-06-09', 'A', NULL, '1', 1, 0, '2026-06-13 15:05:02', '2026-06-13 15:05:02'),
(124, 12, '2026-06-14', 'P', NULL, '1', 1, 0, '2026-06-14 17:01:01', '2026-06-14 17:01:01'),
(125, 11, '2026-06-14', 'P', NULL, '1', 1, 0, '2026-06-14 17:01:01', '2026-06-14 17:01:01'),
(126, 9, '2026-06-14', 'P', NULL, '1', 1, 0, '2026-06-14 17:01:01', '2026-06-14 17:01:01'),
(127, 8, '2026-06-14', 'P', NULL, '1', 1, 0, '2026-06-14 17:01:01', '2026-06-14 17:01:01'),
(128, 5, '2026-06-14', 'P', NULL, '1', 1, 0, '2026-06-14 17:01:01', '2026-06-14 17:01:01'),
(129, 6, '2026-06-14', 'P', NULL, '1', 1, 0, '2026-06-14 17:01:01', '2026-06-14 17:01:01'),
(130, 14, '2026-06-14', 'P', NULL, '1', 1, 0, '2026-06-14 17:01:01', '2026-06-14 17:01:01'),
(131, 15, '2026-06-14', 'P', NULL, '1', 1, 0, '2026-06-14 17:01:01', '2026-06-14 17:01:01'),
(132, 12, '2026-06-18', 'P', NULL, '1', 1, 0, '2026-06-18 15:10:14', '2026-06-18 15:10:14'),
(133, 11, '2026-06-18', 'P', NULL, '1', 1, 0, '2026-06-18 15:10:14', '2026-06-18 15:10:14'),
(134, 9, '2026-06-18', 'P', NULL, '1', 1, 0, '2026-06-18 15:10:14', '2026-06-18 15:10:14'),
(135, 8, '2026-06-18', 'P', NULL, '1', 1, 0, '2026-06-18 15:10:14', '2026-06-18 15:10:14'),
(136, 5, '2026-06-18', 'P', NULL, '1', 1, 0, '2026-06-18 15:10:14', '2026-06-18 15:10:14'),
(137, 6, '2026-06-18', 'P', NULL, '1', 1, 0, '2026-06-18 15:10:14', '2026-06-18 15:10:14'),
(138, 14, '2026-06-18', 'P', NULL, '1', 1, 0, '2026-06-18 15:10:14', '2026-06-18 15:10:14'),
(139, 12, '2026-06-17', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:03', '2026-06-18 15:11:03'),
(140, 11, '2026-06-17', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:03', '2026-06-18 15:11:03'),
(141, 9, '2026-06-17', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:03', '2026-06-18 15:11:03'),
(142, 5, '2026-06-17', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:03', '2026-06-18 15:11:03'),
(143, 6, '2026-06-17', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:03', '2026-06-18 15:11:03'),
(144, 14, '2026-06-17', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:03', '2026-06-18 15:11:03'),
(145, 15, '2026-06-17', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:03', '2026-06-18 15:11:03'),
(146, 12, '2026-06-16', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:41', '2026-06-18 15:11:41'),
(147, 11, '2026-06-16', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:41', '2026-06-18 15:11:41'),
(148, 9, '2026-06-16', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:41', '2026-06-18 15:11:41'),
(149, 5, '2026-06-16', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:41', '2026-06-18 15:11:41'),
(150, 6, '2026-06-16', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:41', '2026-06-18 15:11:41'),
(151, 14, '2026-06-16', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:41', '2026-06-18 15:11:41'),
(152, 15, '2026-06-16', 'P', NULL, '1', 1, 0, '2026-06-18 15:11:41', '2026-06-18 15:11:41');

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
  `withdrawal_id` int(11) DEFAULT '0',
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
(1, 12, '2026-05-17 00:00:00', '2026-05-18', 400, 850, 0.00, NULL, '50', 1, 0, '2026-05-18 11:32:26', '2026-05-18 11:32:26');

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
(1, 'test godown address', 'test godown', '', 1, 1, '2025-09-25 16:31:14', '2026-06-16 15:03:48'),
(2, 'test address', 'test godown12', 'test-godown12', 1, 1, '2025-09-29 17:41:00', '2026-06-16 15:03:44'),
(3, 'આણંદ', 'ગોપી ગોડાઉન', 'godown', 1, 0, '2025-12-10 10:39:55', '2025-12-10 10:39:55'),
(4, 'લાભવેલ', 'લાભવેલ ગોડાઉન', 'godown-2', 1, 0, '2025-12-10 10:40:15', '2025-12-10 10:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `iscon_daily_expence_master`
--

CREATE TABLE `iscon_daily_expence_master` (
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
  `reference_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_mobile_no` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
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
(21, 19, '-', '6352685235', 112, '1', '2025-12-22 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'આણંદ', NULL, 1, 1, 1, '2026-05-23 12:34:42', '2026-06-14 17:08:00'),
(22, 19, '-', '6352685235', 112, '1', '2026-05-23 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'આણંદ', NULL, 1, 1, 1, '2026-05-23 12:34:43', '2026-06-14 17:08:00'),
(20, 19, '-', '6352685235', 118, '1', '2025-10-07 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ANAND', NULL, 1, 1, 1, '2026-05-23 12:33:53', '2026-06-14 17:05:46'),
(17, 3, 'test', '84748487878', 27, '1', '2026-04-01 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'test ref name', '9874589878', 'test ref address', 'ahmedabad , maninager', 'ok', 1, 1, 1, '2026-05-18 17:51:23', '2026-05-23 11:00:05'),
(4, 16, '-', '9825026078', 31, '1', '2025-11-02 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'સાણદ', NULL, 1, 1, 1, '2026-05-18 10:25:41', '2026-06-10 15:37:59'),
(5, 17, 'વિરલ પરમાર', '9624978851', 96, '1', '2025-09-09 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિરલ પરમાર', '8758600614', '-', 'મુંબઈ', NULL, 1, 1, 1, '2026-05-18 10:30:44', '2026-06-10 15:31:59'),
(6, 19, '-', '6352685235', 75, '1', '2025-10-05 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'સમીરભાઈ JCB', '9825019090', NULL, 'આણંદ', NULL, 1, 1, 1, '2026-05-18 10:38:32', '2026-06-14 17:04:39'),
(7, 19, '-', '6352685235', 75, '1', '2025-10-05 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'સમીરભાઈ JCB', '9825019090', NULL, 'આણંદ', NULL, 1, 1, 1, '2026-05-18 10:38:37', '2026-06-14 17:04:39'),
(8, 19, '-', '6352685235', 75, '1', '2025-10-05 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'સમીરભાઈ JCB', '9825019090', NULL, 'આણંદ', NULL, 1, 1, 1, '2026-05-18 10:38:38', '2026-06-14 17:04:39'),
(9, 20, '-', '9824552610', 68, '1', '2025-10-24 00:00:00', NULL, 0, 4000, 0, NULL, NULL, '-', NULL, NULL, 'સુરત', NULL, 1, 1, 1, '2026-05-18 10:47:33', '2026-06-20 15:34:28'),
(10, 20, '-', '9824552610', 80, '1', '2025-10-24 00:00:00', '2025-12-20', 0, 4000, 4000, NULL, '1 month', NULL, NULL, NULL, 'સુરત', NULL, 1, 1, 1, '2026-05-18 10:53:23', '2026-06-10 15:31:59'),
(11, 20, '-', '9824552610', 93, '1', '2025-10-03 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'સુરત', NULL, 1, 1, 1, '2026-05-18 10:56:04', '2026-06-10 15:31:52'),
(12, 20, '-', '9824552610', 36, '1', '2025-10-29 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'સુરત', NULL, 1, 1, 1, '2026-05-18 10:58:31', '2026-06-10 15:31:52'),
(13, 26, 'જયેશભાઈ પ્રજાપતિ', '7984016008', 24, '1', '2025-12-10 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'આણંદ', NULL, 1, 1, 1, '2026-05-18 11:09:33', '2026-06-10 15:31:52'),
(14, 26, 'જયેશભાઈ પ્રજાપતિ', '7984016008', 3, '1', '2025-12-10 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'આણંદ', NULL, 1, 1, 1, '2026-05-18 11:10:59', '2026-06-10 15:31:52'),
(18, 19, '-', '6352685235', 75, '1', '2025-10-05 00:00:00', NULL, 0, 4000, 0, NULL, NULL, '-', NULL, NULL, 'ANAND', NULL, 1, 1, 1, '2026-05-23 12:30:43', '2026-06-14 17:04:39'),
(19, 19, '-', '6352685235', 75, '1', '2025-10-05 00:00:00', NULL, 0, 4000, 0, NULL, NULL, '-', NULL, NULL, 'ANAND', NULL, 1, 1, 1, '2026-05-23 12:33:08', '2026-06-14 17:04:39'),
(23, 21, '-', '-', 94, '1', '2025-09-25 00:00:00', NULL, 0, 4000, 0, NULL, NULL, '-', NULL, NULL, 'સોજીત્રા', NULL, 1, 1, 1, '2026-05-23 12:43:07', '2026-06-10 15:31:52'),
(24, 21, '-', '9824399684', 105, '1', '2025-10-15 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'સોજીત્રા', NULL, 1, 1, 1, '2026-05-23 12:44:11', '2026-06-10 15:31:52'),
(25, 21, '-', '9824399684', 85, '1', '2025-10-15 00:00:00', '2026-01-06', 0, 4000, 32000, NULL, '8 months', NULL, NULL, NULL, 'સોજીત્રા', NULL, 0, 1, 0, '2026-05-23 12:44:56', '2026-05-23 12:49:02'),
(26, 21, '-', '98243', 126, '1', '2025-11-02 00:00:00', '2026-01-06', 0, 4000, 28000, NULL, '7 months', NULL, NULL, NULL, 'સોજીત્રા', NULL, 0, 1, 0, '2026-05-23 12:45:48', '2026-05-23 12:49:24'),
(27, 21, '-', '9824399684', 102, '1', '2025-11-02 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'સોજીત્રા', NULL, 1, 1, 1, '2026-05-23 12:46:51', '2026-06-10 15:31:52'),
(28, 16, NULL, '9825026078', 31, '1', '2025-11-02 00:00:00', NULL, 0, 4000, 0, NULL, NULL, '-', NULL, NULL, 'સાણદ', NULL, 1, 1, 0, '2026-06-10 15:37:59', '2026-06-10 15:37:59'),
(29, 28, '-', '9998539505', 78, '1', '2026-02-16 00:00:00', NULL, 4000, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ચિકોદરા', NULL, 1, 1, 1, '2026-06-12 09:45:03', '2026-06-12 09:48:06'),
(30, 28, '-', '9998539505', 86, '1', '2026-02-26 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ચિકોદરા', NULL, 1, 1, 0, '2026-06-12 09:45:59', '2026-06-12 09:46:19'),
(31, 28, '-', '9998539505', 78, '1', '2026-02-16 00:00:00', '2026-06-12', 0, 4000, 16000, NULL, '4 months', NULL, NULL, NULL, 'ચિકોદરા', NULL, 0, 1, 0, '2026-06-12 09:48:06', '2026-06-13 14:27:33'),
(32, 19, '-', '6352685235', 75, '1', '2025-10-05 00:00:00', NULL, 0, 4000, 0, NULL, NULL, '-', NULL, NULL, 'આણંદ', NULL, 1, 1, 0, '2026-06-14 17:04:39', '2026-06-14 17:04:39'),
(33, 19, '-', '6352685235', 118, '1', '2025-10-07 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'આણંદ', NULL, 1, 1, 0, '2026-06-14 17:05:46', '2026-06-14 17:05:46'),
(34, 19, '-', '6352685235', 112, '1', '2025-12-22 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'આણંદ', NULL, 1, 1, 0, '2026-06-14 17:08:00', '2026-06-14 17:08:00'),
(35, 29, '-', '9512162627', 97, '1', '2025-10-16 00:00:00', '2026-06-05', 0, 4000, 36000, NULL, '9 months', NULL, NULL, NULL, 'નડિયાદ', NULL, 0, 1, 0, '2026-06-16 15:01:15', '2026-06-16 15:03:08'),
(36, 10, '-', '9157771111', 55, '1', '2025-11-16 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'નડિયાદ', NULL, 1, 1, 1, '2026-06-18 18:13:46', '2026-06-19 09:44:31'),
(37, 30, '-', '9157771111', 52, '1', '2025-11-24 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'નડિયાદ', NULL, 1, 1, 0, '2026-06-18 18:14:43', '2026-06-20 15:32:47'),
(38, 10, '-', '9157771111', 37, '1', '2026-01-17 00:00:00', NULL, 0, 4000, 0, NULL, NULL, '-', NULL, NULL, 'નડિયાદ', NULL, 1, 1, 0, '2026-06-18 18:15:22', '2026-06-18 18:16:50'),
(39, 10, '-', '9157771111', 55, '1', '2025-11-16 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'નડિયાદ', NULL, 1, 1, 1, '2026-06-18 18:19:36', '2026-06-19 09:44:31'),
(40, 10, '-', '9157771111', 55, '1', '2025-11-16 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'નડિયાદ', NULL, 1, 1, 0, '2026-06-19 09:44:31', '2026-06-19 09:44:31'),
(41, 8, 'સૂખા ભાઈ ongc', '9924814523', 70, '1', '2026-02-04 00:00:00', NULL, 0, 4000, 0, NULL, NULL, '-', NULL, NULL, 'ખંભાત', NULL, 1, 1, 0, '2026-06-19 09:56:15', '2026-06-19 09:56:15'),
(42, 8, '-', '9924814523', 109, '1', '2026-02-04 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ખંભાત', NULL, 1, 1, 0, '2026-06-19 09:58:39', '2026-06-20 12:20:06'),
(43, 8, '-', '9924814523', 131, '1', '2026-02-14 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ખંભાત', NULL, 1, 1, 0, '2026-06-19 09:59:27', '2026-06-19 09:59:27'),
(44, 8, 'સૂખા ભાઈ ongc', '9924814523', 54, '1', '2026-02-16 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ખંભાત', NULL, 1, 1, 0, '2026-06-19 10:01:36', '2026-06-19 10:01:36'),
(45, 8, 'સૂખા ભાઈ ongc', '9924814523', 66, '1', '2026-02-16 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ખંભાત', NULL, 1, 1, 0, '2026-06-19 10:07:29', '2026-06-19 10:07:29'),
(46, 8, 'સૂખા ભાઈ ongc', '9924814523', 73, '1', '2026-02-19 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ખંભાત', NULL, 1, 1, 0, '2026-06-19 10:08:25', '2026-06-19 10:08:25'),
(47, 8, 'સૂખા ભાઈ ongc', '9924814523', 56, '1', '2026-02-27 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ખંભાત', NULL, 1, 1, 0, '2026-06-19 10:10:17', '2026-06-19 10:10:17'),
(48, 8, 'સૂખાભાઈ ongc', '9924814523', 17, '1', '2026-03-09 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ખંભાત', NULL, 1, 1, 0, '2026-06-19 14:00:33', '2026-06-19 14:00:33'),
(49, 8, 'સૂખાભાઈ ongc', '9924814523', 110, '1', '2026-03-12 00:00:00', '2026-05-26', 0, 4000, 16000, NULL, '4 months', NULL, NULL, NULL, 'ખંભાત', NULL, 0, 1, 0, '2026-06-19 14:02:25', '2026-06-19 14:05:02'),
(50, 8, 'સૂખાભાઈ ongc', '9924814523', 8, '1', '2026-03-12 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, NULL, NULL, 'ખંભાત', NULL, 1, 1, 0, '2026-06-19 14:03:29', '2026-06-19 14:03:29'),
(51, 7, 'સાવંત પદમણી', '9904459749', 25, '1', '2025-11-27 00:00:00', NULL, 0, 4000, 0, NULL, NULL, '-', NULL, NULL, 'સુરત', NULL, 1, 1, 0, '2026-06-20 12:14:32', '2026-06-20 12:14:32'),
(52, 7, 'સાવંત પદમણી', '9904459749', 46, '1', '2025-11-29 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, '9099162713', NULL, 'સુરત', NULL, 1, 1, 0, '2026-06-20 12:16:19', '2026-06-20 12:16:19'),
(53, 7, 'સાવંત પદમણી', '9904459749', 42, '1', '2026-01-12 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, '9099162713', NULL, 'સુરત', NULL, 1, 1, 0, '2026-06-20 12:18:02', '2026-06-20 12:18:02'),
(54, 7, 'સાવંત પદમણી', '9904459749', 109, '1', '2026-01-16 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, '9099162713', NULL, 'સુરત', NULL, 1, 1, 0, '2026-06-20 12:20:06', '2026-06-20 12:20:06'),
(55, 7, 'સાવંત પદમણી', '9904459749', 6, '1', '2026-01-17 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, '9099162713', NULL, 'સુરત', NULL, 1, 1, 0, '2026-06-20 12:21:07', '2026-06-20 12:21:07'),
(56, 7, 'સાવંત પદમણી', '9904459749', 59, '1', '2026-01-22 00:00:00', NULL, 0, 4000, 0, NULL, NULL, NULL, '9099162713', NULL, 'સુરત', NULL, 1, 1, 0, '2026-06-20 12:22:12', '2026-06-20 12:22:12'),
(57, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 128, '1', '2025-12-14 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:12:03', '2026-06-20 15:12:03'),
(58, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 38, '1', '2026-01-12 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:13:54', '2026-06-20 15:13:54'),
(59, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 87, '1', '2026-01-18 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:16:11', '2026-06-20 15:16:11'),
(60, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', NULL, 69, '1', '2026-02-25 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:17:49', '2026-06-20 15:17:49'),
(61, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 132, '1', '2026-03-05 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', '-', 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:22:35', '2026-06-20 15:22:35'),
(62, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 116, '1', '2026-03-08 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:23:49', '2026-06-20 15:23:49'),
(63, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 72, '1', '2026-03-20 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:26:36', '2026-06-20 15:26:36'),
(64, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 7, '1', '2026-03-26 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:28:33', '2026-06-20 15:28:33'),
(65, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 123, '1', '2026-04-04 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:29:53', '2026-06-20 15:29:53'),
(66, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 52, '1', '2026-06-06 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:32:47', '2026-06-20 15:32:47'),
(67, 31, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '6354464038', 68, '1', '2026-06-13 00:00:00', NULL, 0, 4000, 0, NULL, NULL, 'વિભાભાઈ કરસન  ભાઈ ભરવાડ', '8980642722', NULL, 'લુણાવ', NULL, 1, 1, 0, '2026-06-20 15:34:28', '2026-06-20 15:34:28');

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
(22, 3, 16, 4000, 0, 4000, 0, NULL, 1, 1, '2026-05-18 17:11:39', '2026-05-18 17:11:49'),
(4, 16, 4, 4000, 0, 4000, 0, NULL, 1, 0, '2026-05-18 10:25:41', '2026-05-18 10:25:41'),
(5, 17, 5, 4000, 0, 4000, 0, NULL, 1, 0, '2026-05-18 10:30:44', '2026-05-18 10:30:44'),
(23, 3, 0, 8000, 2000, 6000, 1, '2026-05-18', 1, 0, '2026-05-18 17:51:39', '2026-05-18 17:51:39'),
(28, 28, 0, 32000, 4000, 28000, 1, '2026-02-16', 1, 0, '2026-06-12 09:48:47', '2026-06-12 09:48:47'),
(33, 19, 0, 60500, 28000, 32500, 1, '2026-06-14', 1, 0, '2026-06-14 17:11:17', '2026-06-14 17:11:17'),
(9, 19, 0, 96000, 28000, 68000, 1, '2026-02-01', 1, 1, '2026-05-18 10:39:23', '2026-05-18 10:48:52'),
(10, 19, 0, 68000, 28000, 40000, 1, '2026-02-01', 1, 1, '2026-05-18 10:39:33', '2026-05-18 10:48:42'),
(32, 19, 0, 96000, 35500, 60500, 1, '2026-04-03', 1, 0, '2026-06-14 17:10:39', '2026-06-14 17:10:39'),
(12, 20, 9, 4000, 0, 4000, 0, NULL, 1, 0, '2026-05-18 10:47:33', '2026-05-18 10:47:33'),
(13, 20, 10, 4000, 0, 4000, 0, NULL, 1, 0, '2026-05-18 10:53:23', '2026-05-18 10:53:23'),
(14, 20, 11, 4000, 0, 4000, 0, NULL, 1, 0, '2026-05-18 10:56:04', '2026-05-18 10:56:04'),
(15, 20, 12, 4000, 0, 4000, 0, NULL, 1, 0, '2026-05-18 10:58:31', '2026-05-18 10:58:31'),
(16, 26, 13, 4000, 0, 4000, 0, NULL, 1, 0, '2026-05-18 11:09:33', '2026-05-18 11:09:33'),
(17, 26, 14, 4000, 0, 4000, 0, NULL, 1, 1, '2026-05-18 11:10:59', '2026-05-18 11:48:11'),
(18, 26, 0, 48000, 8000, 40000, 1, '2025-11-27', 1, 1, '2026-05-18 11:48:20', '2026-05-18 11:56:30'),
(19, 26, 0, 40000, 16000, 24000, 1, '2026-04-02', 1, 0, '2026-05-18 11:48:52', '2026-05-18 11:48:52'),
(20, 26, 0, 24000, 10000, 14000, 1, '2026-05-07', 1, 0, '2026-05-18 11:49:18', '2026-05-18 11:49:18'),
(21, 3, 15, 4000, 0, 4000, 0, NULL, 1, 1, '2026-05-18 17:06:22', '2026-05-18 17:06:39'),
(29, 28, 0, 28000, 4000, 24000, 1, '2026-03-28', 1, 0, '2026-06-12 09:49:48', '2026-06-12 09:49:48'),
(30, 28, 0, 24000, 8000, 16000, 1, '2026-03-29', 1, 0, '2026-06-12 09:50:33', '2026-06-12 09:50:33'),
(34, 29, 0, 36000, 25000, 11000, 1, '2026-05-22', 1, 0, '2026-06-16 15:02:44', '2026-06-16 15:02:44'),
(35, 8, 0, 184000, 50000, 134000, 2, '2026-04-30', 1, 0, '2026-06-19 14:04:17', '2026-06-19 14:04:17'),
(36, 7, 0, 148000, 56000, 92000, 2, '2026-03-28', 1, 0, '2026-06-20 12:22:52', '2026-06-20 12:22:52'),
(37, 7, 0, 92000, 45000, 47000, 2, '2026-05-15', 1, 0, '2026-06-20 12:23:23', '2026-06-20 12:23:23'),
(38, 7, 0, 47000, 4000, 43000, 3, '2025-11-27', 1, 0, '2026-06-20 12:29:51', '2026-06-20 12:29:51'),
(39, 7, 0, 43000, 4000, 39000, 3, '2025-11-29', 1, 0, '2026-06-20 12:30:32', '2026-06-20 12:30:32'),
(47, 31, 0, 156000, 4000, 152000, 3, '2026-02-25', 1, 0, '2026-06-20 15:39:58', '2026-06-20 15:39:58'),
(41, 31, 0, 168000, 8000, 160000, 3, '2026-01-12', 1, 0, '2026-06-20 15:36:09', '2026-06-20 15:36:09'),
(49, 31, 0, 152000, 4000, 148000, 3, '2026-03-08', 1, 0, '2026-06-20 15:41:19', '2026-06-20 15:41:19'),
(46, 31, 0, 160000, 4000, 156000, 3, '2025-11-14', 1, 0, '2026-06-20 15:39:30', '2026-06-20 15:39:30'),
(48, 31, 0, 156000, 4000, 152000, 3, '2026-03-05', 1, 0, '2026-06-20 15:40:44', '2026-06-20 15:40:44'),
(50, 31, 0, 148000, 4000, 144000, 3, '2026-03-20', 1, 0, '2026-06-20 15:41:45', '2026-06-20 15:41:45'),
(51, 31, 0, 144000, 4000, 140000, 3, '2026-03-26', 1, 0, '2026-06-20 15:42:18', '2026-06-20 15:42:18'),
(52, 31, 0, 140000, 4000, 136000, 3, '2026-06-06', 1, 0, '2026-06-20 15:42:44', '2026-06-20 15:42:44'),
(53, 31, 0, 136000, 4000, 132000, 3, '2026-06-13', 1, 0, '2026-06-20 15:43:09', '2026-06-20 15:43:09'),
(54, 31, 0, 132000, 12000, 120000, 3, '2026-02-22', 1, 0, '2026-06-20 15:43:40', '2026-06-20 15:43:40'),
(55, 31, 0, 120000, 20000, 100000, 3, '2026-04-15', 1, 0, '2026-06-20 15:44:03', '2026-06-20 15:44:03'),
(56, 31, 0, 100000, 20000, 80000, 3, '2026-05-14', 1, 0, '2026-06-20 15:44:55', '2026-06-20 15:44:55'),
(57, 31, 0, 80000, 25000, 55000, 3, '2026-06-08', 1, 0, '2026-06-20 15:45:27', '2026-06-20 15:45:27');

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
(1, 'અરવિંદ', 1, 1, '2026-05-13 17:13:34', '2026-06-16 15:04:18'),
(2, 'મિહિત', 1, 0, '2026-06-16 15:04:31', '2026-06-16 15:04:31'),
(3, 'mkp bank A/C', 1, 0, '2026-06-16 15:05:15', '2026-06-16 15:05:15');

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
(1, 'Monthly', '4000', 1, 0, '2025-09-26 15:45:31', '2026-05-07 15:14:48'),
(2, 'Daily', '200', 1, 0, '2025-09-26 15:45:31', '2026-05-07 15:08:22');

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
(1, 4, 'જય માતાજી', 'a-1', 'A-1', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-18 17:11:39'),
(2, 4, 'જય સિકોતર', 'b-2', 'B-2', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(3, 4, 'જય શ્રી ચામુંડા માં', 'c-3', 'C-3', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-18 11:10:59'),
(4, 4, 'જય શ્રી મેલડી માં', 'd-4', 'D-4', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(5, 4, 'જય ભોલેનાથ', 'e-5', 'E-5', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(6, 4, 'જય શ્રી ગણેશયા નમઃ', 'f-6', 'F-6', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 12:21:07'),
(7, 4, 'જય  શ્રીનાથજી', 'g-7', 'G-7', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:28:33'),
(8, 4, 'જય આશાપુરા', 'h-8', 'H-8', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-19 14:03:29'),
(9, 4, 'જય હનુમાન', 'i-9', 'I-9', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(10, 4, 'જય ખોડિયાર માં', 'j-10', 'J-10', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(11, 4, 'જય શ્રી  અંબે માં', 'k-11', 'K-11', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(12, 4, 'જય હિંગળાજ માં', 'l-12', 'L-12', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(13, 4, 'જય કુળદેવી માં', 'm-13', 'M-13', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 12:41:25'),
(14, 4, 'જય શ્રી વહાણવટી માં', 'n-14', 'N-14', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(15, 4, 'જય  મોમઇ માં', 'o-15', 'O-15', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(16, 4, 'શિવશક્તિ', 'p-16', 'P-16', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(17, 4, 'જય મહાકાળી માં', 'q-17', 'Q-17', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-19 14:00:33'),
(18, 4, 'જય ડાડા', 'r-18', 'R-18', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-13 12:10:06'),
(19, 4, 'શ્રી લક્ષ્મી માં', 's-19', 'S-19', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(20, 1, 'જય રાજબાઈ માં', 't-20', 'T-20', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-13 13:21:29'),
(21, 4, 'જય ગાયત્રીમાં', 'u-21', 'U-21', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(22, 4, 'જય જોગણી માં', 'v-22', 'V-22', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(23, 4, 'જય દશામાં', 'w-23', 'W-23', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(24, 4, 'જય સંતોષો માં', 'x-24', 'X-24', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-18 11:09:33'),
(25, 4, 'જય શ્રી કૃષણ', 'y-25', 'Y-25', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 12:14:32'),
(26, 4, 'જય વિશ્વકર્મા', 'z-26', 'Z-26', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 14:33:56'),
(27, 4, 'બાપા સિતારામ', 'aa-27', 'AA-27', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-23 11:00:05'),
(28, 4, 'જય શ્રી રામ', 'ab-28', 'AB-28', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(29, 4, 'જય સરસ્વતી માં', 'ac-29', 'AC-29', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(30, 4, 'જય ગંગા મૈયા', 'ad-30', 'AD-30', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(31, 4, 'જય શ્રી જમના મૈયા', 'ae-31', 'AE-31', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-10 15:37:59'),
(32, 4, 'જય શ્રી નર્મદા મૈયા', 'af-32', 'AF-32', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 14:32:42'),
(33, 4, 'જય શ્રી મહીસાગર મૈયા', 'ag-33', 'AG-33', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(34, 4, 'જય જલારામ', 'ah-34', 'AH-34', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(35, 4, 'જય સ્વામિનારયણ', 'ai-35', 'AI-35', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(36, 4, 'જય સંતરામ મહારાજ', 'aj-36', 'AJ-36', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-18 10:58:31'),
(37, 4, 'જય સુરપુરા', 'ak-37', 'AK-37', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-18 18:16:50'),
(38, 4, 'જય રવેચી માં', 'al-38', 'AL-38', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:13:54'),
(39, 4, 'જય ઉમિયા માતા', 'am-39', 'AM-39', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(40, 4, 'જય મારૂતિ  નંદન', 'an-40', 'AN-40', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(41, 4, 'જય શનિ દેવ', 'ao--41', 'AO--41', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(42, 4, 'જય સાંઈબાબા', 'ap-42', 'AP-42', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 12:18:02'),
(43, 4, 'જય ગુરૂનાનક દેવ', 'aq-43', 'AQ-43', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(44, 4, 'જય સોમનાથ', 'ar-44', 'AR-44', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(45, 4, 'જય પિતૃ દેવ', 'as-45', 'AS-45', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(46, 4, 'જય ભાથીજી મહારાજ', 'at-46', 'AT-46', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 12:16:19'),
(47, 4, 'બાબા રામદેવ પીર', 'au-47', 'AU-47', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(48, 4, 'જય મોગલ માં', 'av-48', 'AV-48', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(49, 4, 'જય શ્રી નાગબાઈ માં', 'aw-49', 'AW-49', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-13 12:05:03'),
(50, 4, 'જય રણછોડરાય', 'ax-50', 'AX-50', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(51, 4, 'જય મામા', 'ay-51', 'AY-51', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(52, 4, 'જય  ભૈરવ દાદા', 'az-52', 'AZ-52', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:32:47'),
(53, 4, 'જય   કાર્તિકે', 'aaa-53', 'AAA-53', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-18 10:16:46'),
(54, 4, 'જય હરસિદ્ધિમાં', 'aab-54', 'AAB-54', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-19 10:01:36'),
(55, 4, 'જય રામેશ્વર', 'aac-55', 'AAC-55', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-19 09:44:31'),
(56, 4, 'જય શ્રી દ્વારકાધીશ', 'aad-56', 'AAD-56', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-19 10:10:17'),
(57, 4, 'જય શ્રી માધવ', 'aae-57', 'AAE-57', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(58, 4, 'જય ૐ  નમઃ શિવયા', 'aaf-58', 'AAF-58', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(59, 4, 'જય શ્રી કેશવ', 'aag-59', 'AAG-59', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 12:22:12'),
(60, 4, 'જય શ્રી  વેરાઈ માં', 'aah-60', 'AAH-60', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(61, 4, 'જય શ્રી અન્નપૂર્ણા માં', 'aai-61', 'AAI-61', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(62, 4, 'બ્રહ્મા વિષ્ણુ મહેશ', 'aaj-62', 'AAJ-62', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(63, 4, 'જય શ્રી ચંડી ચામુંડા માં', 'aak-63', 'AAK-63', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(64, 4, 'જય શ્રી ચાવન કૃપા', 'aal-64', 'AAL-64', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:20:51'),
(65, 4, 'જય ભવાની માં', 'aam-65', 'AAM-65', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(66, 4, 'જય ગંગા સાગર', 'aan-66', 'AAN-66', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-19 10:07:29'),
(67, 4, 'જય ત્રિદેવ', 'aao-67', 'AAO-67', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 10:51:53'),
(68, 4, 'જય ભગવાન', 'aap-68', 'AAP-68', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:34:28'),
(69, 4, 'જય  સુંધા માતા', 'aaq-69', 'AAQ-69', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:17:49'),
(70, 4, 'જય યોગેશ્વર', 'aar-70', 'AAR-70', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-19 09:56:15'),
(71, 4, 'જય બળીયા દેવ', 'aas-71', 'AAS-71', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(72, 4, 'જય કેદારનાથ', 'aat-72', 'AAT-72', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:26:36'),
(73, 4, 'જય યમનોત્રી', 'aau-73', 'AAU-73', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-19 10:08:25'),
(74, 4, 'જય ગંગોત્રી', 'aav-74', 'AAV-74', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(75, 4, 'જય બદ્રીનાથ', 'aaw-75', 'AAW-75', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-14 17:04:39'),
(76, 4, 'જય હરિદ્વાર', 'aax-76', 'AAX-76', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:22:37'),
(77, 4, 'જય જીવણીસતી માં', 'aay-77', 'AAY-77', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 12:08:12'),
(78, 3, 'કાનમેર ના ચામુંડા માં', 'aaz-78', 'AAZ-78', 0, 1, 0, '2026-05-07 16:05:27', '2026-06-13 14:13:56'),
(79, 4, 'જય  વચ્છરાજ ડાડા', 'aaaa-79', 'AAAA-79', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-13 12:10:50'),
(80, 3, 'શ્રી ભાગવત ગીતા', 'aaab-80', 'AAAB-80', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-18 10:55:04'),
(81, 4, 'જય શ્રી ચોટીલા ના ચામુંડા માં', 'aaac-81', 'AAAC-81', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(82, 4, 'શ્રી પ્રમુખ સ્વામિ', 'aaad-82', 'AAAD-82', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(83, 4, 'શ્રી પાબુ ડાડા', 'aaae-83', 'AAAE-83', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(84, 4, 'જય શ્રી આશાપુરી પીપળાવ', 'aaaf-84', 'AAAF-84', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(85, 3, 'જય શ્રી ઉજ્જૈન ના મહાકાલેશ્વર', 'aaag-85', 'AAAG-85', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-23 12:49:02'),
(86, 4, 'જય શ્રી રિદ્ધિસિદ્ધિ', 'aaah-86', 'AAAH-86', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-12 09:46:19'),
(87, 4, 'જય શ્રી શુભ લાભ', 'aaai-87', 'AAAI-87', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:16:11'),
(88, 4, 'જય શ્રી વાઘેશ્વરી માં', 'aaaj-88', 'AAAJ-88', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 17:14:07'),
(89, 4, 'જય શ્રી લક્ષ્મણ', 'aaak-89', 'AAAK-89', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(90, 4, 'જય શ્રી વેણુ ડાડા', 'aaal-90', 'AAAL-90', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(91, 4, 'જય બાબા અમરનાથ', 'aaam-91', 'AAAM-91', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 16:06:46'),
(92, 4, 'શ્રી ભૂરખિયા હનુમાન', 'aaan-92', 'AAAN-92', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(93, 4, 'જય શ્રી  વરૂડી માતાજી', 'aaao-93', 'AAAO-93', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-18 10:56:04'),
(94, 4, 'શ્રી કષ્ટભંજન હનુમાન', 'aaap-94', 'AAAP-94', 0, 1, 0, '2026-05-07 16:05:27', '2026-06-14 17:14:26'),
(95, 4, 'શ્રી ઝંડ હનુમાન', 'aaaq-95', 'AAAQ-95', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 16:52:47'),
(96, 4, 'શ્રી   ગજનંદ', 'aaar-96', 'AAAR-96', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-18 10:30:44'),
(97, 3, 'શ્રી ઠાકર', 'aaas-97', 'AAAS-97', 0, 1, 0, '2026-05-07 16:05:27', '2026-06-16 15:03:08'),
(98, 4, 'હરેક્રુષ્ણ હરે રામ', 'aaat-98', 'AAAT-98', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(99, 4, '|| શ્રી રાધેરાધે||', 'aaav-99', 'AAAV-99', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(100, 4, 'શ્રી કોટેશ્વર મહાદેવ', 'aaaw-100', 'AAAW-100', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(101, 3, 'જય શ્રી નીલકંઠ વરણી', 'aaax-101', 'AAAX-101', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 17:53:22'),
(102, 4, 'જય શ્રી વિહત માં', 'aaay-102', 'AAAY-102', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-23 12:46:51'),
(103, 4, 'જય  બ્રહ્માણી માં', 'aaaz-103', 'AAAZ-103', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:21:27'),
(104, 4, 'જય વિધ્યાવાસીની', 'aaaaa-104', 'AAAAA-104', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(105, 4, 'જય શ્રી મસાણિ  માં', 'aaaab-105', 'AAAAB-105', 1, 1, 0, '2026-05-07 16:05:27', '2026-05-23 12:44:11'),
(106, 4, 'રાધેશ્યામ', 'aaaac-106', 'AAAAC-106', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 17:12:38'),
(107, 4, 'જય રાજાધિરાજ', 'aaaad-107', 'AAAAD-107', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 12:17:22'),
(108, 4, 'શ્રી ક્રુષ્ણ સુદામા', 'aaaae-108', 'AAAAE-108', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(109, 4, 'જય શ્રી સૂર્ય દેવ', 'aaaaf-109', 'AAAAF-109', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 12:20:06'),
(110, 3, 'જય શ્રી ચંદ્ર દેવ', 'aaaag-110', 'AAAAG-110', 0, 1, 0, '2026-05-07 16:05:27', '2026-06-19 14:05:02'),
(111, 4, 'જય શ્રી એકંદતય', 'aaaah-111', 'AAAAH-111', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(112, 4, 'જય શ્રી ભીમ', 'aaaai-112', 'AAAAI-112', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-14 17:08:00'),
(113, 4, 'જય શ્રી શંકર પાર્વતી', 'aaaaj-113', 'AAAAJ-113', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(114, 4, 'જય શ્રી અગ્નિ દેવ', 'aaaak-114', 'AAAAK-114', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 17:21:32'),
(115, 4, 'જય શ્રી વાયુ દેવ', 'aaaal-115', 'AAAAL-115', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(116, 4, 'જય સત્યનારાયણ', 'aaaam-116', 'AAAAM-116', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:23:49'),
(117, 4, 'જય જગનાથ', 'aaaan-117', 'AAAAN-117', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:17:01'),
(118, 4, 'જય શ્રી ભદ્રકાળી', 'aaaao-118', 'AAAAO-118', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-14 17:05:46'),
(119, 4, 'જય શ્રી ઉટકેશ્વર મહાદેવ', 'aaaap-119', 'AAAAP-119', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(120, 4, 'લક્ષ્મી નારાયણ', 'aaaaq-120', 'AAAAQ-120', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(121, 4, 'જય શ્રી કુંબેર ભંડારી', 'aaaar-121', 'AAAAR-121', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(122, 4, 'શ્રી પાનેતર ડુગર ચામુંડા માં', 'aaaas-122', 'AAAAS-122', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(123, 4, 'શ્રી સુદર્શન ચક્ર', 'aaaat-123', 'AAAAT-123', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:29:53'),
(124, 4, 'જય શ્રી વાસુદેવ', 'aaaau-124', 'AAAAU-124', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(125, 4, 'જય પશુપતિ નાથ', 'aaaav-125', 'AAAAV-125', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-07 16:05:27'),
(126, 3, 'રાપર ચંડી ચામુંડા', 'aaaaw-126', 'AAAAW-126', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-23 12:49:24'),
(127, 4, 'વાગડ ચંડી ચામુંડા', 'aaaax-127', 'AAAAX-127', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 12:09:50'),
(128, 4, 'જય ગોદાવરી મૈયા', 'aaaay-128', 'AAAAY-128', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:12:03'),
(129, 4, 'જય કસીવિશ્વનાથ', 'aaaaz-129', 'AAAAZ-129', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-11 15:21:27'),
(130, 4, 'જય મલિકાઅર્જુન', 'aaaay-130', 'AAAAAA-130', 0, 1, 0, '2026-05-07 16:05:27', '2026-05-10 17:09:09'),
(131, 4, 'જય ઓમકાલેસ્વર', 'aaaaz-131', 'AAAAZ-131', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-19 09:59:27'),
(132, 4, 'જય વેજનાથ', 'aaaaaa-132', 'AAAAAA-132', 1, 1, 0, '2026-05-07 16:05:27', '2026-06-20 15:22:35'),
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

CREATE TABLE `trip_master` (
  `trip_id` int(11) NOT NULL,
  `trip_date` date NOT NULL,
  `truck_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `product` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `no_of_bags` int(11) DEFAULT NULL,
  `weight` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `total_weight` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `truck_master`
--

CREATE TABLE `truck_master` (
  `truck_id` int(11) NOT NULL,
  `godown_id` int(11) DEFAULT NULL,
  `truck_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `truck_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0=inside, 1=outside',
  `iStatus` int(11) NOT NULL DEFAULT '1',
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `truck_master`
--

INSERT INTO `truck_master` (`truck_id`, `godown_id`, `truck_name`, `slug`, `truck_number`, `status`, `iStatus`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 1, 'test truck name', 'test-truck-name', '0123456', 0, 1, 0, '2025-12-12 14:05:56', '2025-12-12 14:05:56');

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
-- Indexes for table `driver_master`
--
ALTER TABLE `driver_master`
  ADD PRIMARY KEY (`driver_id`);

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
-- Indexes for table `iscon_daily_expence_master`
--
ALTER TABLE `iscon_daily_expence_master`
  ADD PRIMARY KEY (`expence_id`);

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
-- Indexes for table `trip_master`
--
ALTER TABLE `trip_master`
  ADD PRIMARY KEY (`trip_id`);

--
-- Indexes for table `truck_master`
--
ALTER TABLE `truck_master`
  ADD PRIMARY KEY (`truck_id`);

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `daily_expence_master`
--
ALTER TABLE `daily_expence_master`
  MODIFY `expence_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_expence_type`
--
ALTER TABLE `daily_expence_type`
  MODIFY `expence_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_order`
--
ALTER TABLE `daily_order`
  MODIFY `daily_order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_order_ledger`
--
ALTER TABLE `daily_order_ledger`
  MODIFY `ledger_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_master`
--
ALTER TABLE `driver_master`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_extra_withdrawal`
--
ALTER TABLE `employee_extra_withdrawal`
  MODIFY `withdrawal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_master`
--
ALTER TABLE `employee_master`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `emp_attendance_master`
--
ALTER TABLE `emp_attendance_master`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `emp_salary`
--
ALTER TABLE `emp_salary`
  MODIFY `emp_salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `godown_master`
--
ALTER TABLE `godown_master`
  MODIFY `godown_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `iscon_daily_expence_master`
--
ALTER TABLE `iscon_daily_expence_master`
  MODIFY `expence_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_master`
--
ALTER TABLE `order_master`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `order_payment_master`
--
ALTER TABLE `order_payment_master`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `payment_received_user`
--
ALTER TABLE `payment_received_user`
  MODIFY `received_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `tanker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `trip_master`
--
ALTER TABLE `trip_master`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `truck_master`
--
ALTER TABLE `truck_master`
  MODIFY `truck_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_master`
--
ALTER TABLE `vendor_master`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
