-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2025 at 08:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `youth`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `sk_official_id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `subtitle` varchar(100) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `thumbnail_id` int(11) DEFAULT NULL,
  `sk_official_comment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `sk_official_id`, `title`, `subtitle`, `info`, `thumbnail_id`, `sk_official_comment`, `created_at`, `updated_at`) VALUES
(4, 23, 'Brigada Eskwela Support', 'Improving Local Schools', 'In a bid to improve local educational facilities, we partnered with high schools to supply essential school materials and infrastructure improvements. This initiative aimed to create a nurturing learning environment by ensuring that schools had adequate resources and modern facilities, which, in turn, helped boost student performance and community pride.', 38, 'lorem ipsum', '2025-03-18 07:45:06', '2025-09-01 07:23:57'),
(6, 1, 'Community Volunteers', 'Building Team Spirit designed to build team spirit and leadership skills among the youth. The initia', 'Our SK officials engaged in a series of community service projects with local volunteers. These activities were designed to build team spirit and leadership skills among the youth. The initiatives ranged from environmental clean-ups to organizing cultural events, all aimed at strengthening community bonds and encouraging civic responsibility.', 31, 'lorem ipsum designed to build team spirit and leadership skills among the youth. The initiatives ranged from environmental clean-ups to organizing cultural events, all aimed at strengthenin', '2025-03-18 07:45:06', '2025-09-14 13:29:09'),
(7, 23, 'Feeding Programm', 'Nurturing the Community', 'Recognizing the pressing need for nutritional support, we launched a comprehensive feeding program for underprivileged families. This program provided healthy meals to children, ensuring that they received the necessary nutrients to thrive, while also promoting community awareness about sustainable food practices and local resource utilization.', NULL, 'lorem ipsum', '2025-03-18 07:45:06', '2025-09-01 07:36:53'),
(9, 1, 'Community Fiesta', 'Celebrating Togedfsfdtherness', 'Hosted a community fiesta that brought everyone together for celebration.', 32, 'lorem ipsum', '2025-03-18 07:45:06', '2025-09-06 05:24:52'),
(14, 23, 'Digital Innovation Workshop', 'Enhancing Digital Skills', 'Conducted a digital innovation workshop aimed at improving the technological skills of the youth, focusing on digital literacy, cybersecurity, and creative problem solving. The workshop provided practical skills for modern challenges.', NULL, 'lorem ipsum', '2025-03-24 06:45:44', '2025-08-26 15:46:03'),
(29, 23, 'sfsdf', 'sdfdsf', 'sdfdsfdsf', NULL, 'sfsdfdfs', '2025-08-27 08:00:14', '2025-08-27 08:00:14');

-- --------------------------------------------------------

--
-- Table structure for table `achievement_date`
--

CREATE TABLE `achievement_date` (
  `id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievement_date`
--

INSERT INTO `achievement_date` (`id`, `achievement_id`, `date`, `created_at`, `updated_at`) VALUES
(2, 6, '2025-08-25', '2025-08-25 02:25:44', '2025-08-25 02:25:44'),
(5, 4, '2025-08-25', '2025-08-25 02:25:44', '2025-08-25 02:25:44'),
(10, 14, '2025-08-25', '2025-08-25 02:25:44', '2025-08-25 02:25:44'),
(11, 7, '2025-08-25', '2025-08-25 02:25:44', '2025-08-25 02:25:44'),
(12, 9, '2025-08-25', '2025-08-25 02:25:44', '2025-08-25 02:25:44'),
(17, 4, '2025-08-26', '2025-08-25 09:13:12', '2025-08-25 09:13:12'),
(64, 29, '2025-06-19', '2025-08-27 08:00:14', '2025-08-27 08:00:14'),
(65, 29, '2022-06-18', '2025-08-27 08:00:14', '2025-08-27 08:00:14'),
(66, 29, '2016-06-16', '2025-08-27 08:00:14', '2025-08-27 08:00:14'),
(69, 6, '2025-08-28', '2025-08-27 13:48:25', '2025-08-27 13:48:25'),
(70, 6, '2025-08-29', '2025-08-27 13:48:25', '2025-08-27 13:48:25');

-- --------------------------------------------------------

--
-- Table structure for table `achievement_image`
--

CREATE TABLE `achievement_image` (
  `id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievement_image`
--

INSERT INTO `achievement_image` (`id`, `achievement_id`, `img`, `created_at`, `updated_at`) VALUES
(31, 6, '68addcb9767f1_1730117975971.png', '2025-08-26 16:11:37', '2025-08-26 16:11:37'),
(32, 9, '68aea621ef09f_wp1987762.jpg', '2025-08-27 06:30:57', '2025-08-27 06:30:57'),
(34, 14, '68aea640efc59_wp8227766.jpg', '2025-08-27 06:31:28', '2025-08-27 06:31:28'),
(35, 7, '68aea64b3c575_YB0fc4S.jpeg', '2025-08-27 06:31:39', '2025-08-27 06:31:39'),
(36, 29, '68aebb0e46db3_6bd01ad61378e91b7fe8eed1694d508f.png', '2025-08-27 08:00:14', '2025-08-27 08:00:14'),
(38, 4, '68b54a0d85bce_6.jpg', '2025-09-01 07:23:57', '2025-09-01 07:23:57'),
(39, 6, '68b84fa9a6a76_6a02a4d97be96796b9a816f4a3b420e0.png', '2025-09-03 14:24:41', '2025-09-03 14:24:41'),
(40, 6, '68b84fa9ad0a9_6bd01ad61378e91b7fe8eed1694d508f.png', '2025-09-03 14:24:41', '2025-09-03 14:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `thumbnail_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `what` varchar(255) NOT NULL,
  `who` varchar(255) NOT NULL,
  `why` varchar(255) NOT NULL,
  `where` varchar(255) NOT NULL,
  `gmap_link` varchar(255) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `barangay_id`, `title`, `thumbnail_id`, `description`, `what`, `who`, `why`, `where`, `gmap_link`, `is_featured`, `created_at`, `updated_at`) VALUES
(59, 1, 'Clean-up Drive', 110, 'A community-wide cfegflean-up activity.', 'Clean surroundings', 'Barangay Youth Council', 'Promote cleanliness', 'Barangay Plaza', 'https://maps.google.com/example1', 1, '2025-08-23 11:52:18', '2025-09-06 09:53:18'),
(60, 1, 'Tree Plantiin', 107, 'Join us in planting trees along the main road.', 'Tree planting', 'Barangay Youth & Volunteers', 'Environmental sustainability', 'Barangay Park', 'https://maps.google.com/example2', 1, '2025-08-23 11:52:18', '2025-08-26 07:07:20'),
(61, 1, 'Sports Tournament', 108, 'Basketball and Volleyball tournament for the youth.', 'Sports activities', 'Barangay Sports Committee', 'Promote healthy lifestyle', 'Barangay Gym', 'https://maps.google.com/example3', 1, '2025-08-23 11:52:18', '2025-08-25 02:13:23'),
(63, 1, 'Job Fair 2025', 120, 'Local employers offering job opportuerewrnities.', 'Employment opportunities', 'Barangay Officials', 'Support livelihood', 'Covered Court', 'https://maps.google.com/example5', 1, '2025-08-23 11:52:18', '2025-08-26 16:18:12'),
(65, 1, 'Medical Mission', NULL, 'Free medical check-up and consultation.', 'Free medical check-up', 'Local Doctors & Volunteers', 'Improve health awareness', 'Barangay Health Center', 'https://maps.google.com/example7', 1, '2025-08-23 11:52:18', '2025-08-25 02:06:28'),
(66, 1, 'dfgfd', 121, 'dfgfgd', 'dgdf', 'dfdf', 'dfgfd', 'dfgd', '', 0, '2025-08-26 16:18:40', '2025-08-26 16:18:40'),
(67, 2, 'Barangay Francia Announcement', 125, 'dsdfs', 'sfdsd', 'sdfds', 'sdfds', 'fdsfd', '', 0, '2025-08-27 07:48:43', '2025-08-27 07:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_datetime`
--

CREATE TABLE `announcement_datetime` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_datetime`
--

INSERT INTO `announcement_datetime` (`id`, `announcement_id`, `date`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(80, 61, '2025-08-22', '09:00:00', '17:00:00', '2025-08-23 15:01:18', '2025-08-23 15:01:18'),
(84, 59, '2022-04-22', '18:00', '06:00', '2025-08-24 04:49:50', '2025-08-24 04:49:50'),
(86, 63, '2025-08-29', '09:00:00', '17:00:00', '2025-08-24 05:28:54', '2025-08-24 05:28:54'),
(106, 65, '2025-06-22', '09:00:00', '17:00:00', '2025-08-25 13:56:18', '2025-08-25 13:56:18'),
(107, 65, '2025-06-24', '09:00:00', '17:00:00', '2025-08-25 13:56:18', '2025-08-25 13:56:18'),
(118, 66, '2025-08-20', '09:00:00', '17:00:00', '2025-08-26 16:18:40', '2025-08-26 16:18:40'),
(119, 66, '2025-08-28', '09:00:00', '17:00:00', '2025-08-26 16:18:40', '2025-08-26 16:18:40'),
(120, 67, '2025-08-21', '09:00:00', '17:00:00', '2025-08-27 07:48:43', '2025-08-27 07:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_image`
--

CREATE TABLE `announcement_image` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_image`
--

INSERT INTO `announcement_image` (`id`, `announcement_id`, `name`, `created_at`, `updated_at`) VALUES
(107, 60, 'bb_tryout.jpg', '2025-08-24 07:13:11', '2025-08-24 07:13:11'),
(108, 61, 'kk_ass.jpg', '2025-08-24 07:13:23', '2025-08-24 07:13:23'),
(110, 59, '531719838_746165091382935_8137629482291917304_n.jpg', '2025-08-24 08:18:16', '2025-08-24 08:18:16'),
(120, 63, '1730117975999.png', '2025-08-26 16:18:12', '2025-08-26 16:18:12'),
(121, 66, 'wp2367468-honda-civic-type-r-wallpapers.jpg', '2025-08-26 16:18:40', '2025-08-26 16:18:40'),
(122, 66, 'wp4826572-spider-amoled-wallpapers.jpg', '2025-08-26 16:18:40', '2025-08-26 16:18:40'),
(123, 66, 'wp4826572.jpg', '2025-08-26 16:18:40', '2025-08-26 16:18:40'),
(124, 66, 'wp8227766.jpg', '2025-08-26 16:18:40', '2025-08-26 16:18:40'),
(125, 67, '6a02a4d97be96796b9a816f4a3b420e0.png', '2025-08-27 07:48:43', '2025-08-27 07:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `authorized_accounts`
--

CREATE TABLE `authorized_accounts` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `provider` enum('google','facebook','','') NOT NULL,
  `provider_user_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` text NOT NULL,
  `access_token` text NOT NULL,
  `refresh_token` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `id` int(11) NOT NULL,
  `cluster_id` int(11) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL,
  `sk_barangay_logo` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_agreed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `cluster_id`, `slug`, `name`, `img`, `sk_barangay_logo`, `username`, `password`, `is_agreed`, `created_at`, `updated_at`) VALUES
(1, 1, 'san-francisco', 'San Francisco', 'san_francisco_bh.jpg', '', 'sanfrancisco', 'dessa', 1, '2025-02-17 08:00:20', '2025-09-18 05:32:41'),
(2, 1, 'francia', 'Francia', 'francia_bh.png', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:34:03'),
(3, 1, 'la-purisima', 'La Purisima', 'lapurisima_bh.png', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(4, 1, 'san-juan', 'San Juan', 'san_juan_bh.jpg', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(5, 1, 'san-jose', 'San Jose', 'san_jose_bh.jpg', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(6, 1, 'san-miguel', 'San Miguel', 'san_miguel_bh.png', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(7, 2, 'san-nicolas', 'San Nicolas', 'san_nicolas_bh.png', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(8, 3, 'del-rosario', 'Del Rosario', '', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(9, 3, 'santiago', 'Santiago', 'santiago_bh.jpeg', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(10, 3, 'sto-domingo', 'Sto. Domingo', 'sto_domingo_bh.png', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(11, 3, 'la-anunciacion', 'La Anunciacion', '', '', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(12, 4, 'sta-cruz-norte', 'Sta. Cruz Norte', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(13, 4, 'cristo-rey', 'Cristo Rey', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(14, 4, 'san-vicente-norte', 'San Vicente Norte', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(15, 4, 'antipolo', 'Antipolo', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(16, 4, 'sta-maria', 'Sta. Maria', 'sta_maria_bh.png', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(17, 4, 'san-pedro', 'San Pedro', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(18, 4, 'san-rafael', 'San Rafael', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(19, 5, 'sta-cruz-sur', 'Sta. Cruz Sur', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(20, 5, 'sto-niño', 'Sto. Niño', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(21, 5, 'san-vicente-sur', 'San Vicente Sur', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(22, 5, 'salvacion', 'Salvacion', '', '', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(23, 1, 'san-roque', 'San Roque', '', '', '', '', 0, '2025-03-31 06:36:29', '2025-03-31 06:36:29'),
(24, 2, 'san-agustin', 'San Agustin', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(25, 2, 'san-isidro', 'San Isidro', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(26, 3, 'sta-elena', 'Sta. Elena', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(27, 4, 'niño-jesus', 'Niño Jesus', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(28, 4, 'perpetual-help', 'Perpetual Help', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(29, 4, 'sagrada', 'Sagrada', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(30, 4, 'san-andres', 'San Andres', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(31, 4, 'san-ramon', 'San Ramon', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(32, 4, 'sta-isabel', 'Sta. Isabel', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(33, 4, 'sta-teresita', 'Sta. Teresita', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(34, 5, 'la-medalla', 'La Medalla', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(35, 5, 'la-trinidad', 'La Trinidad', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(36, 5, 'san-antonio', 'San Antonio', '', '', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55');

-- --------------------------------------------------------

--
-- Table structure for table `clusters`
--

CREATE TABLE `clusters` (
  `id` int(11) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clusters`
--

INSERT INTO `clusters` (`id`, `slug`, `name`, `created_at`, `updated_at`) VALUES
(1, 'poblacion-unit', 'Poblacion Unit', '2025-02-17 07:54:50', '2025-03-10 08:39:44'),
(2, 'national-road-unit', 'National Road Unit', '2025-02-17 07:54:50', '2025-03-10 08:39:44'),
(3, 'east-road-unit', 'East Road Unit', '2025-02-17 07:56:30', '2025-03-10 08:39:44'),
(4, 'mountain-unit', 'Mountain Unit', '2025-02-17 07:56:30', '2025-03-10 08:39:44'),
(5, 'river-unit', 'River Unit', '2025-02-17 07:56:30', '2025-03-10 08:39:44');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `event_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `barangay_id`, `event_name`, `event_date`, `location`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sample Event', '2025-03-12', 'Sample Location', 'Sample Description', '2025-03-12 10:47:05', '2025-03-12 10:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `class` varchar(255) NOT NULL,
  `action` varchar(50) NOT NULL,
  `object_data` text DEFAULT NULL,
  `actor_data` text DEFAULT NULL,
  `log_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `class`, `action`, `object_data`, `actor_data`, `log_time`) VALUES
(1, 'Barangay', 'update', '{\"before\":{\"id\":23,\"cluster_id\":1,\"slug\":\"test-barangay\",\"name\":\"Test Barangay\",\"img\":\"\"},\"after\":{\"id\":23,\"cluster_id\":2,\"slug\":\"updated-barangay\",\"name\":\"Updated Barangay\",\"img\":\"\"}}', '{\"id\":23,\"cluster_id\":2,\"slug\":\"updated-barangay\",\"name\":\"Updated Barangay\",\"img\":\"\"}', '2025-03-18 17:54:37'),
(2, 'Barangay', 'update', '{\"before\":{\"id\":24,\"cluster_id\":1,\"slug\":\"test-barangay\",\"name\":\"Test Barangay\",\"img\":\"\"},\"after\":{\"id\":24,\"cluster_id\":2,\"slug\":\"updated-barangay\",\"name\":\"Updated Barangay\",\"img\":\"\"}}', '{\"id\":24,\"cluster_id\":2,\"slug\":\"updated-barangay\",\"name\":\"Updated Barangay\",\"img\":\"\"}', '2025-03-19 09:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `sk_advocacies`
--

CREATE TABLE `sk_advocacies` (
  `id` int(11) NOT NULL,
  `sk_official_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `subtitle` varchar(100) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_advocacies`
--

INSERT INTO `sk_advocacies` (`id`, `sk_official_id`, `title`, `subtitle`, `detail`, `thumbnail`, `created_at`, `updated_at`) VALUES
(1, 1, 'Clean & Green Program', 'Environmental Awareness', 'Tree planting activities for youth', 'San_Francisco_Barangay_Hall.jpg', '2025-09-02 13:56:13', '2025-09-02 15:11:34'),
(2, 1, 'Youth Sports League', 'Basketball Tournament', 'Encouraging sportsmanship and teamwork', '', '2025-09-02 13:56:13', '2025-09-02 15:11:02'),
(3, 23, 'Skills Trainings', 'Computer Liteer Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere libero quod eligend', 'Free computer skillsdsffds Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere libero quod eligendi sequi labore illo eius hic quisquam dolores, quidem nisi totam nobis quasi. Eum inventore esse facilis impedit illo! Lorem ipsum dolor, sit am', '470e72f464163e96d9f87de75083b63a.png', '2025-09-02 13:56:13', '2025-09-03 14:33:45'),
(4, 23, 'Leadership Seminar', 'Youth Empowerment', 'Training young leaders in the barangay', '3130f31bc56c7ffb96941809d6dbebef.png', '2025-09-02 13:56:13', '2025-09-03 11:33:47'),
(5, 24, 'Health Drive', 'Free Medical Check-up', 'Providing free medical checkups to residents', 'thumb5.jpg', '2025-09-02 13:56:13', '2025-09-02 13:56:13'),
(6, 24, 'Community Feeding', 'Nutrition Program', 'Feeding program for malnourished children', 'thumb6.jpg', '2025-09-02 13:56:13', '2025-09-02 13:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `sk_educations`
--

CREATE TABLE `sk_educations` (
  `id` int(11) NOT NULL,
  `sk_official_id` int(11) NOT NULL,
  `educational_type` enum('Formal Education','Specialized Training / Seminars','','') DEFAULT NULL,
  `level_or_title` varchar(100) NOT NULL,
  `institution` varchar(100) NOT NULL,
  `institution_logo` varchar(255) NOT NULL,
  `course_or_details` varchar(100) DEFAULT NULL,
  `educational_achievements` varchar(100) DEFAULT NULL,
  `start_year` int(4) DEFAULT NULL,
  `end_year` int(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_educations`
--

INSERT INTO `sk_educations` (`id`, `sk_official_id`, `educational_type`, `level_or_title`, `institution`, `institution_logo`, `course_or_details`, `educational_achievements`, `start_year`, `end_year`, `created_at`, `updated_at`) VALUES
(1, 1, 'Formal Education', '', 'Sample Elementary Central School', '426ea488fae0096bbb5df51aab4aea4d.png', NULL, NULL, 2006, 2012, '2025-03-11 11:43:03', '2025-09-01 05:29:13'),
(2, 1, 'Specialized Training / Seminars', '', 'Samplen National High School7', '', NULL, NULL, 2012, 2016, '2025-03-11 11:43:03', '2025-09-01 05:29:20'),
(3, 1, '', '', 'Sample National High School', '', NULL, NULL, 2016, 2018, '2025-03-11 11:43:03', '2025-09-01 03:18:52'),
(4, 1, '', '', 'Camarines Sur Polytechnic College', '', 'Bachelor of Science in Tourism Management', NULL, 2018, 2022, '2025-03-11 11:43:03', '2025-09-01 03:18:52'),
(9, 23, 'Formal Education', '', 'Ateneo de Naga University', 'f9d4f35b1e43d8e417aa918dd2d7a0e5.png', 'Bachelor of Public Administration (BPA)', NULL, 2020, 2024, '2025-03-24 06:50:25', '2025-09-01 06:14:30'),
(10, 23, 'Formal Education', '', 'Ateneo de Naga University Senior High School', '', 'STEM (Science, Technology, Engineering, and Mathematics)', 'Dean Listers, With High Honor & Best in Research (Capstone Project)', 2018, 2020, '2025-03-24 06:50:25', '2025-09-01 06:14:38'),
(12, 23, 'Specialized Training / Seminars', '', 'Ateneo de Naga University Grade School', '470e72f464163e96d9f87de75083b63a.png', 'adsfafda', 'afadfadfa', 2008, 2021, '2025-03-24 06:50:25', '2025-09-01 06:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `sk_officials`
--

CREATE TABLE `sk_officials` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `slug` varchar(35) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `position` enum('SK Chairperson','SK Secretary','SK Treasurer','SK Kagawad') NOT NULL,
  `contact_number` varchar(14) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `google_id` text DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `motto` text NOT NULL,
  `img` text NOT NULL,
  `term_start` date DEFAULT NULL,
  `term_end` date DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_officials`
--

INSERT INTO `sk_officials` (`id`, `barangay_id`, `slug`, `full_name`, `position`, `contact_number`, `address`, `email`, `google_id`, `birthday`, `motto`, `img`, `term_start`, `term_end`, `reset_token`, `token_expires`, `created_at`, `updated_at`) VALUES
(1, 1, 'dessa-mare', 'Dessa Mare P. Lontayao', 'SK Chairperson', '09274668490', '', 'dessa@localhost.net', NULL, '2003-03-29', '\"Bilang inyong SK Chairperson, ako’y naninindigan para sa kabataang may boses, may pangarap, at may lakas ng loob n67a maglingkod. Sama-sama tayong kikilos para sa makabuluhang pagbabago sa ating rtbarangay.\"', 'images.jpeg', '2022-04-07', '2025-06-28', 'c88b1862cafeb7644995da16b1a5a031', '2025-03-18 10:15:31', '2025-02-21 06:16:33', '2025-09-11 00:04:24'),
(2, 2, 'irish', 'Irish N. Zaragoza', 'SK Chairperson', '09082565497', '', 'irish@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-09-08 05:52:34'),
(3, 3, 'anthony', 'Anthony T. Balbuena', 'SK Chairperson', '09915612246', '', 'anthony@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(4, 4, 'aiden-osward', 'Aiden Osward M. Basagre', 'SK Chairperson', '09617360226', '', 'aiden@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(5, 5, 'neil-christian', 'Neil Christian D. Vargas', 'SK Chairperson', '09773292890', '', 'neil@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(6, 6, 'jade-dustin', 'Jade Dustin F. Villareal', 'SK Chairperson', '09291118624', '', 'jade@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(7, 7, 'kim-roland', 'Kim Roland P. Vargas', 'SK Chairperson', '09618808019', '', 'kim@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(8, 8, 'leiriz', 'Leiriz C. Ibarreta', 'SK Chairperson', '09508374203', '', 'leiriz@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(9, 9, 'bea-franchezka', 'Bea Franchezka Naldo', 'SK Chairperson', '09484018819', '', 'bea@localhost.net', NULL, NULL, 'Unified Youth for One Santiago', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(10, 10, 'rex', 'Rex A. Embestro', 'SK Chairperson', '09915618021', '', 'rex@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(11, 11, 'rico', 'Rico Maniscan', 'SK Chairperson', '0', '', 'rico@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(12, 12, 'jhustine', 'Jhustine A. Robles', 'SK Chairperson', '09674164962', '', 'jhustine@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(13, 13, 'james-lorren', 'James Lorren J. Brondial', 'SK Chairperson', '09092168955', '', 'james@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(14, 14, 'eddel-mae', 'Eddel Mae D. Brago', 'SK Chairperson', '09203025407', '', 'eddel@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(15, 15, 'prince-leonard', 'Prince Leonard W. Llagas', 'SK Chairperson', '09518971664', '', 'prince@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(16, 16, 'diana-rose', 'Diana Rose A. Canlas', 'SK Chairperson', '09950653343', '', 'diana@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(17, 17, 'mary-grace', 'Mary Grace A. Biag', 'SK Chairperson', '09916828638', '', 'mary@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(18, 18, 'jean-lyka', 'Jean-Lyka C. Villanueva', 'SK Chairperson', '09919459266', '', 'jean@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(19, 19, 'james', 'James S. Tasarra', 'SK Chairperson', '09630466338', '', 'james@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(20, 20, 'aliza-mae', 'Aliza Mae P. Viñas', 'SK Chairperson', '09383706542', '', 'aliza@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(21, 21, 'erika-mae', 'Erika Mae V. Molina', 'SK Chairperson', '09389182048', '', 'erika@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(22, 22, 'jessa-mae', 'Jessa Mae C. Matubis', 'SK Chairperson', '09486804219', '', 'jessa@localhost.net', NULL, NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(23, 1, 'hyerilee', 'Lee Hye-ri', 'SK Secretary', '0970954268', '', 'harveygonzaga222@gmail.com', '103645300517448303091', '1994-06-09', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt', 'Screenshot 2025-05-22 214258.png', '2024-03-05', '2025-06-13', NULL, NULL, '2025-03-12 10:58:56', '2025-09-12 08:35:29'),
(24, 1, 'secretary-san-francisco', 'Honda Civic', 'SK Secretary', '09171234567', '', 'secretary_sf@localhost.net', NULL, '1990-01-01', 'Leading with diligence', 'wp2367468.jpg', '2025-01-01', '2025-12-31', NULL, NULL, '2025-03-26 04:21:13', '2025-05-22 13:45:24'),
(25, 1, 'treasurer-san-francisco', 'SK Treasurer - San Francisco', 'SK Treasurer', '09172234567', '', 'treasurer_sf@localhost.net', NULL, '1991-02-02', 'Managing funds responsible', '', '2025-01-01', '2025-12-31', NULL, NULL, '2025-03-26 04:21:13', '2025-03-26 04:21:13'),
(31, 2, 'sdf', 'sdf', 'SK Treasurer', '09709542681', '', 'sdf', NULL, '2025-09-26', 'sdfsd', 'Screenshot 2025-09-03 003531.png', '2025-09-18', '2025-09-23', NULL, NULL, '2025-09-06 09:37:52', '2025-09-06 09:37:52'),
(32, 1, 'makima', 'Makima', 'SK Secretary', '343', '', 'makimamammmaa@gmail.com', NULL, '2025-09-26', 'dsfwdfs', '540467416_1217490263751193_4671166342659193011_n.jpg', '2025-09-20', '2025-09-22', NULL, NULL, '2025-09-06 13:50:04', '2025-09-06 13:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `sk_platforms`
--

CREATE TABLE `sk_platforms` (
  `id` int(11) NOT NULL,
  `sk_advocacy_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_platforms`
--

INSERT INTO `sk_platforms` (`id`, `sk_advocacy_id`, `title`, `detail`, `created_at`, `updated_at`) VALUES
(21, 1, 'Platform 1asdas', 'Details for Platform 1', '2025-09-02 23:05:34', '2025-09-03 00:27:40'),
(22, 1, 'Platform 2', 'Details for Platform 2', '2025-09-02 23:05:34', '2025-09-03 00:27:34'),
(25, 3, 'Platform Example for Skill Trainings', 'Details for Platform 5, Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto ipsam, nostrum ex repellendus consequatur voluptatem ad, hic aperiam voluptatum, dolorem quo maxime amet nihil id corporis exercitationem nulla voluptates aut.\n', '2025-09-02 23:05:34', '2025-09-03 16:22:05'),
(26, 4, 'Example Platform for Leadership Seminar', 'Details for Platform 6, Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto ipsam, nostrum ex repellendus consequatur voluptatem ad, hic aperiam voluptatum, dolorem quo maxime amet nihil id corporis exercitationem nulla voluptates aut.', '2025-09-02 23:05:34', '2025-09-03 16:21:18'),
(28, 6, 'Platform 8', 'Details for Platform 8', '2025-09-02 23:05:34', '2025-09-02 23:05:34'),
(30, 5, 'Platform 10', 'Details for Platform 10', '2025-09-02 23:05:34', '2025-09-02 23:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `sk_programs`
--

CREATE TABLE `sk_programs` (
  `id` int(11) NOT NULL,
  `sk_platform_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `subtitle` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `status` enum('Done','Pending','Dismissed','') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_programs`
--

INSERT INTO `sk_programs` (`id`, `sk_platform_id`, `title`, `subtitle`, `detail`, `thumbnail`, `status`, `created_at`, `updated_at`) VALUES
(1, 21, 'Tree Planting', 'Environmental Care', 'Community-wide tree planting project.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(2, 21, 'River Clean-up', 'Environmental Action', 'Cleaning rivers and waterways.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(3, 21, 'Recycling Drive', 'Sustainability', 'Barangay-wide plastic recycling initiative.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(4, 22, 'Basketball League', 'Sports Development', 'Organizing an inter-barangay youth basketball league.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(5, 22, 'Volleyball Tournament', 'Sports Engagement', 'Barangay youth volleyball tournament.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(6, 22, 'Fun Run', 'Youth Fitness', 'Annual fun run to promote healthy lifestyle.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(7, 26, 'Scholarship Programsdfdfs', 'Educatiodsffdsnal Assistance, lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusm', 'Providing scholarshifdsdsfsfdp support for deserving students. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum distinctio expedita earum fugiat veniam asperiores, fugit adipisci cumque, nemo dolorum eos quasi inventore voluptates suscipit est corporis architecto ducimus sunt?\n', 'thumb-1920-922109.jpg', 'Pending', '2025-09-03 08:31:31', '2025-09-03 16:38:33'),
(8, 25, 'School Supplies Drived', 'Education Supportsdfdssdfdsdfs lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusm', 'Distribution of school supplies to sdfsdfindigent students.cxfdssdfdsfLorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum distinctio expedita earum fugiat veniam asperiores, fugit adipisci cumque, nemo dolorum eos quasi inventore voluptates suscipit est corporis architecto ducimus sunt?\n', '6bd01ad61378e91b7fe8eed1694d508f.png', 'Pending', '2025-09-03 08:31:31', '2025-09-03 16:37:48'),
(9, 25, 'After-School Tutorials', 'Academic Support, lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusm', 'Free tutorial sessions for struggling students. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum distinctio expedita earum fugiat veniam asperiores, fugit adipisci cumque, nemo dolorum eos quasi inventore voluptates suscipit est corporis architecto ducimus sunt?', '470e72f464163e96d9f87de75083b63a.png', 'Pending', '2025-09-03 08:31:31', '2025-09-03 16:38:20'),
(10, 25, 'Youth Leadership Seminaraaa', 'Leadership Trainingaaaaa, lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusm', 'A seminar to develop youth leadership skills.aaaaaaaaaa, Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum distinctio expedita earum fugiat veniam asperiores, fugit adipisci cumque, nemo dolorum eos quasi inventore voluptates suscipit est corporis architecto ducimus sunt?\n', 'thumb-1920-920085.jpg', 'Pending', '2025-09-03 08:31:31', '2025-09-03 16:38:38'),
(16, 28, 'Vocational Training', 'Skills Development', 'Technical and vocational training for unemployed youth.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(17, 28, 'Entrepreneurship Seminar', 'Business Skills', 'Teaching youth how to start small businesses.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(18, 28, 'Computer Literacy Class', 'Digital Skills', 'Basic computer and internet training for youth.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(22, 30, 'Cultural Dance Festival', 'Arts & Culture', 'A festival showcasing traditional dances and culture.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(23, 30, 'Art Exhibit', 'Creative Expression', 'Barangay youth art exhibit and competition.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00'),
(24, 30, 'Battle of the Bands', 'Music Event', 'Youth bands competing to showcase their talent.', '', 'Pending', '2025-09-03 08:31:31', '2025-09-03 09:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `url` text NOT NULL,
  `icon` varchar(50) NOT NULL,
  `linkable_id` int(11) NOT NULL,
  `linkable_type` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `youths`
--

CREATE TABLE `youths` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_achievements_sk_officials` (`sk_official_id`),
  ADD KEY `achievement_thumbnail_id_fk` (`thumbnail_id`);

--
-- Indexes for table `achievement_date`
--
ALTER TABLE `achievement_date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achievement_id_fk` (`achievement_id`);

--
-- Indexes for table `achievement_image`
--
ALTER TABLE `achievement_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achievement_id_ibfk_1` (`achievement_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`),
  ADD KEY `announcement_thumbnail_id_fk` (`thumbnail_id`);

--
-- Indexes for table `announcement_datetime`
--
ALTER TABLE `announcement_datetime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_idfk_2` (`announcement_id`);

--
-- Indexes for table `announcement_image`
--
ALTER TABLE `announcement_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id_fk` (`announcement_id`);

--
-- Indexes for table `authorized_accounts`
--
ALTER TABLE `authorized_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id_fk` (`barangay_id`);

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cluster_id` (`cluster_id`);

--
-- Indexes for table `clusters`
--
ALTER TABLE `clusters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sk_advocacies`
--
ALTER TABLE `sk_advocacies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sk_advocacyfk1` (`sk_official_id`);

--
-- Indexes for table `sk_educations`
--
ALTER TABLE `sk_educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sk_official_id` (`sk_official_id`);

--
-- Indexes for table `sk_officials`
--
ALTER TABLE `sk_officials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `sk_platforms`
--
ALTER TABLE `sk_platforms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sk_platformfk1` (`sk_advocacy_id`);

--
-- Indexes for table `sk_programs`
--
ALTER TABLE `sk_programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sk_programsfk1` (`sk_platform_id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `youths`
--
ALTER TABLE `youths`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `achievement_date`
--
ALTER TABLE `achievement_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `achievement_image`
--
ALTER TABLE `achievement_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `announcement_datetime`
--
ALTER TABLE `announcement_datetime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `announcement_image`
--
ALTER TABLE `announcement_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `authorized_accounts`
--
ALTER TABLE `authorized_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `clusters`
--
ALTER TABLE `clusters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sk_advocacies`
--
ALTER TABLE `sk_advocacies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sk_educations`
--
ALTER TABLE `sk_educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sk_officials`
--
ALTER TABLE `sk_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sk_platforms`
--
ALTER TABLE `sk_platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `sk_programs`
--
ALTER TABLE `sk_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `youths`
--
ALTER TABLE `youths`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `achievement_thumbnail_id_fk` FOREIGN KEY (`thumbnail_id`) REFERENCES `achievement_image` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_achievements_sk_officials` FOREIGN KEY (`sk_official_id`) REFERENCES `sk_officials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `achievement_date`
--
ALTER TABLE `achievement_date`
  ADD CONSTRAINT `achievement_id_fk` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `achievement_image`
--
ALTER TABLE `achievement_image`
  ADD CONSTRAINT `achievement_id_ibfk_1` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcement_thumbnail_id_fk` FOREIGN KEY (`thumbnail_id`) REFERENCES `announcement_image` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `announcement_datetime`
--
ALTER TABLE `announcement_datetime`
  ADD CONSTRAINT `announcement_idfk_2` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `announcement_image`
--
ALTER TABLE `announcement_image`
  ADD CONSTRAINT `announcement_id_fk` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `authorized_accounts`
--
ALTER TABLE `authorized_accounts`
  ADD CONSTRAINT `barangay_id_fk` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barangays`
--
ALTER TABLE `barangays`
  ADD CONSTRAINT `barangays_ibfk_1` FOREIGN KEY (`cluster_id`) REFERENCES `clusters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sk_advocacies`
--
ALTER TABLE `sk_advocacies`
  ADD CONSTRAINT `sk_advocacyfk1` FOREIGN KEY (`sk_official_id`) REFERENCES `sk_officials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sk_educations`
--
ALTER TABLE `sk_educations`
  ADD CONSTRAINT `sk_educations_ibfk_1` FOREIGN KEY (`sk_official_id`) REFERENCES `sk_officials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sk_officials`
--
ALTER TABLE `sk_officials`
  ADD CONSTRAINT `sk_officials_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sk_platforms`
--
ALTER TABLE `sk_platforms`
  ADD CONSTRAINT `sk_platformfk1` FOREIGN KEY (`sk_advocacy_id`) REFERENCES `sk_advocacies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sk_programs`
--
ALTER TABLE `sk_programs`
  ADD CONSTRAINT `sk_programsfk1` FOREIGN KEY (`sk_platform_id`) REFERENCES `sk_platforms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `youths`
--
ALTER TABLE `youths`
  ADD CONSTRAINT `youths_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
