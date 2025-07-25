-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 08:39 AM
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
  `img` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `sk_official_id`, `title`, `subtitle`, `info`, `img`, `date`, `created_at`, `updated_at`) VALUES
(3, 1, 'Transparency Assembly', 'Review of SK Fund Deposits', 'Held an assembly to review SK fund deposits for transparency.', '7.jpg', '2025-03-19', '2025-03-18 07:45:06', '2025-03-24 07:00:46'),
(4, 23, 'Brigada Eskwela Support', 'Improving Local Schools', 'In a bid to improve local educational facilities, we partnered with high schools to supply essential school materials and infrastructure improvements. This initiative aimed to create a nurturing learning environment by ensuring that schools had adequate resources and modern facilities, which, in turn, helped boost student performance and community pride.', '2.jpg', '2025-03-19', '2025-03-18 07:45:06', '2025-05-22 13:44:30'),
(5, 23, 'Youth Basketball League', 'Empowering Through Sports', 'We organized a vibrant basketball league to promote sportsmanship, physical fitness, and community unity among the youth. This league not only provided a competitive platform but also fostered camaraderie, instilled discipline, and encouraged teamwork, thereby contributing to the overall development of our young athletes.', '3.jpg', '2025-03-19', '2025-03-18 07:45:06', '2025-05-22 13:44:53'),
(6, 1, 'Community Volunteers', 'Building Team Spirit', 'Our SK officials engaged in a series of community service projects with local volunteers. These activities were designed to build team spirit and leadership skills among the youth. The initiatives ranged from environmental clean-ups to organizing cultural events, all aimed at strengthening community bonds and encouraging civic responsibility.', '5.jpg', '2025-03-19', '2025-03-18 07:45:06', '2025-03-24 07:00:46'),
(7, 24, 'Feeding Program', 'Nurturing the Community', 'Recognizing the pressing need for nutritional support, we launched a comprehensive feeding program for underprivileged families. This program provided healthy meals to children, ensuring that they received the necessary nutrients to thrive, while also promoting community awareness about sustainable food practices and local resource utilization.', '7.jpg', '2025-03-19', '2025-03-18 07:45:06', '2025-05-22 13:45:55'),
(8, 1, 'Adolescent Health Forum', 'Empowering Youth', 'Conducted a forum on adolescent health and youth rights.', '2.jpg', '2025-03-19', '2025-03-18 07:45:06', '2025-03-24 07:00:46'),
(9, 24, 'Community Fiesta', 'Celebrating Togetherness', 'Hosted a community fiesta that brought everyone together for celebration.', '3.jpg', '2025-03-19', '2025-03-18 07:45:06', '2025-05-22 13:45:49'),
(10, 23, 'Community Outreach Program', 'Improving Local Engagement', 'Organized a community outreach program that brought together local youth and residents to discuss community needs and solutions. This initiative improved transparency and accountability in local governance.', '5.jpg', '2025-03-20', '2025-03-24 06:45:44', '2025-03-24 07:00:46'),
(11, 23, 'Financial Transparency Report', 'Detailed Fund Utilization', 'Published a comprehensive financial transparency report detailing the SK fund deposits, expenditures, and impact on community projects. This report helped build trust among the constituents.', '7.jpg', '2025-03-21', '2025-03-24 06:45:44', '2025-03-24 07:00:46'),
(12, 23, 'Youth Empowerment Summit', 'Inspiring Future Leaders', 'Hosted a summit to empower local youth by providing leadership training, mentorship, and career guidance. The event featured influential speakers and interactive sessions.', '2.jpg', '2025-03-22', '2025-03-24 06:45:44', '2025-03-24 07:00:46'),
(13, 24, 'Public Service Award', 'Recognized for Excellence', 'Received a public service award for outstanding contributions to community development and transparent governance. The award recognized the effective management of SK funds and community initiatives.', '3.jpg', '2025-03-23', '2025-03-24 06:45:44', '2025-05-22 13:45:40'),
(14, 23, 'Digital Innovation Workshop', 'Enhancing Digital Skills', 'Conducted a digital innovation workshop aimed at improving the technological skills of the youth, focusing on digital literacy, cybersecurity, and creative problem solving. The workshop provided practical skills for modern challenges.', '5.jpg', '2025-03-24', '2025-03-24 06:45:44', '2025-03-24 07:00:46'),
(15, 1, 'Achievement from Feb', 'Something happened on Feb', 'May nangyari nung February', '1.jpg', '2025-02-14', '2025-03-26 15:26:20', '2025-04-02 13:12:40'),
(16, 27, '2024 achievement', 'Something happened on 2024', 'May na achieve ako nung 2024', '1.jpg', '2024-01-10', '2025-03-26 15:33:20', '2025-05-28 07:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
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

INSERT INTO `announcements` (`id`, `barangay_id`, `img`, `title`, `description`, `what`, `who`, `why`, `where`, `gmap_link`, `is_featured`, `created_at`, `updated_at`) VALUES
(2, 1, 'interzone_bb.jpg', 'Dummy Announcement Title 2', 'This is a dummy description for announcement 2.', '', '', '', '', '', 1, '2025-04-02 05:36:19', '2025-05-10 05:19:56'),
(3, 1, 'teentrail.jpg', 'Dummy Announcement Title 3', 'This is a dummy description for announcement 3.', '', '', '', '', '', 1, '2025-04-02 05:36:19', '2025-05-10 05:20:16'),
(4, 1, 'kk_ass.jpg', 'Dummy Announcement Title 4', 'This is a dummy description for announcement 4.', '', '', '', '', '', 1, '2025-04-02 05:36:19', '2025-05-10 05:20:28'),
(5, 1, 'youthnight.jpg', 'Dummy Announcement Title 5', 'This is a dummy description for announcement 5.', '', '', '', '', '', 1, '2025-04-02 05:36:19', '2025-04-03 06:44:35'),
(10, 1, 'youth.svg', 'Dummy Announcement Title 10', 'This is a dummy description for announcement 10.', '', '', '', '', '', 1, '2025-04-03 03:45:49', '2025-05-30 03:00:08'),
(15, 1, 'kalinisan.jpg', 'Kalinisan sa Kapaligiran', 'Basta maglilinis tayo ng Mother Earth.', '', '', '', '', '', 1, '2025-04-03 08:07:52', '2025-06-09 15:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_datetime`
--

CREATE TABLE `announcement_datetime` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_datetime`
--

INSERT INTO `announcement_datetime` (`id`, `announcement_id`, `date`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-06-27', '10:00:00', '17:00:00', '2025-06-14 07:37:57', '2025-06-14 07:38:17'),
(2, 2, '2025-04-09', '08:00:00', '17:00:00', '2025-06-14 07:40:47', '2025-06-14 07:40:47'),
(3, 3, '2025-04-09', '08:00:00', '17:00:00', '2025-06-14 07:40:47', '2025-06-14 07:40:47'),
(4, 4, '2025-04-05', '08:00:00', '17:00:00', '2025-06-14 07:40:47', '2025-06-14 07:40:47'),
(5, 5, '2025-04-11', '08:00:00', '17:00:00', '2025-06-14 07:40:47', '2025-06-14 07:40:47'),
(6, 10, '2025-04-16', '08:00:00', '17:00:00', '2025-06-14 07:40:47', '2025-06-14 07:40:47'),
(7, 15, '2025-04-11', '08:00:00', '17:00:00', '2025-06-14 07:40:47', '2025-06-14 07:40:47');

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
  `is_agreed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `cluster_id`, `slug`, `name`, `img`, `sk_barangay_logo`, `is_agreed`, `created_at`, `updated_at`) VALUES
(1, 1, 'san-francisco', 'San Francisco', 'san_francisco_bh.jpg', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:34:03'),
(2, 1, 'francia', 'Francia', 'francia_bh.png', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:34:03'),
(3, 1, 'la-purisima', 'La Purisima', 'lapurisima_bh.png', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(4, 1, 'san-juan', 'San Juan', 'san_juan_bh.jpg', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(5, 1, 'san-jose', 'San Jose', 'san_jose_bh.jpg', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(6, 1, 'san-miguel', 'San Miguel', 'san_miguel_bh.png', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(7, 2, 'san-nicolas', 'San Nicolas', 'san_nicolas_bh.png', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(8, 3, 'del-rosario', 'Del Rosario', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(9, 3, 'santiago', 'Santiago', 'santiago_bh.jpeg', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(10, 3, 'sto-domingo', 'Sto. Domingo', 'sto_domingo_bh.png', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(11, 3, 'la-anunciacion', 'La Anunciacion', '', '', 1, '2025-02-17 08:00:20', '2025-03-31 06:35:32'),
(12, 4, 'sta-cruz-norte', 'Sta. Cruz Norte', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(13, 4, 'cristo-rey', 'Cristo Rey', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(14, 4, 'san-vicente-norte', 'San Vicente Norte', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(15, 4, 'antipolo', 'Antipolo', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(16, 4, 'sta-maria', 'Sta. Maria', 'sta_maria_bh.png', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(17, 4, 'san-pedro', 'San Pedro', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(18, 4, 'san-rafael', 'San Rafael', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(19, 5, 'sta-cruz-sur', 'Sta. Cruz Sur', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(20, 5, 'sto-niño', 'Sto. Niño', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(21, 5, 'san-vicente-sur', 'San Vicente Sur', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(22, 5, 'salvacion', 'Salvacion', '', '', 1, '2025-02-17 08:07:33', '2025-03-31 06:35:32'),
(23, 1, 'san-roque', 'San Roque', '', '', 0, '2025-03-31 06:36:29', '2025-03-31 06:36:29'),
(24, 2, 'san-agustin', 'San Agustin', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(25, 2, 'san-isidro', 'San Isidro', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(26, 3, 'sta-elena', 'Sta. Elena', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(27, 4, 'niño-jesus', 'Niño Jesus', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(28, 4, 'perpetual-help', 'Perpetual Help', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(29, 4, 'sagrada', 'Sagrada', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(30, 4, 'san-andres', 'San Andres', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(31, 4, 'san-ramon', 'San Ramon', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(32, 4, 'sta-isabel', 'Sta. Isabel', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(33, 4, 'sta-teresita', 'Sta. Teresita', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(34, 5, 'la-medalla', 'La Medalla', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(35, 5, 'la-trinidad', 'La Trinidad', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55'),
(36, 5, 'san-antonio', 'San Antonio', '', '', 0, '2025-03-31 06:43:55', '2025-03-31 06:43:55');

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
-- Table structure for table `education_levels`
--

CREATE TABLE `education_levels` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education_levels`
--

INSERT INTO `education_levels` (`id`, `name`, `description`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Elementary', 'Elementary Education', 1, '2025-03-11 11:30:12', '2025-03-11 11:30:12'),
(2, 'Junior High School', 'Junior High Education', 2, '2025-03-11 11:30:12', '2025-03-11 11:30:12'),
(3, 'Senior High School', 'Senior High Education', 3, '2025-03-11 11:30:12', '2025-03-11 11:30:12'),
(4, 'College', 'College or University Education', 4, '2025-03-11 11:30:12', '2025-03-11 11:30:12');

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
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `youth_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `project_name` varchar(200) NOT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `status` enum('Proposed','Ongoing','Completed') DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `barangay_id`, `project_name`, `budget`, `status`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sample Project', NULL, 'Proposed', '2025-02-01', '2025-04-26', '2025-03-12 10:47:53', '2025-03-12 10:47:53');

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
  `thumbnail` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_educations`
--

CREATE TABLE `sk_educations` (
  `id` int(11) NOT NULL,
  `sk_official_id` int(11) NOT NULL,
  `education_level_id` int(11) NOT NULL,
  `school_name` varchar(100) NOT NULL,
  `school_logo` varchar(255) NOT NULL,
  `course` varchar(100) DEFAULT NULL,
  `start_year` int(4) DEFAULT NULL,
  `end_year` int(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_educations`
--

INSERT INTO `sk_educations` (`id`, `sk_official_id`, `education_level_id`, `school_name`, `school_logo`, `course`, `start_year`, `end_year`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Sample Elementary Central School', '', NULL, 2006, 2012, '2025-03-11 11:43:03', '2025-03-23 09:31:33'),
(2, 1, 2, 'Samplen National High School', '', NULL, 2012, 2016, '2025-03-11 11:43:03', '2025-03-23 09:31:41'),
(3, 1, 3, 'Sample National High School', '', NULL, 2016, 2018, '2025-03-11 11:43:03', '2025-03-23 09:31:49'),
(4, 1, 4, 'Camarines Sur Polytechnic College', '', 'Bachelor of Science in Tourism Management', 2018, 2022, '2025-03-11 11:43:03', '2025-03-11 11:43:03'),
(9, 23, 1, 'Ateneo de Naga University', 'Frame 173.png', 'Bachelor of Public Administration (BPA)', 2020, 2024, '2025-03-24 06:50:25', '2025-06-06 02:22:35'),
(10, 23, 2, 'Ateneo de Naga University Senior High School', '', 'STEM (Science, Technology, Engineering, and Mathematics)', 2018, 2020, '2025-03-24 06:50:25', '2025-03-24 14:19:59'),
(11, 23, 3, 'Naga City Science High School', '', NULL, 2014, 2018, '2025-03-24 06:50:25', '2025-03-24 06:50:25'),
(12, 23, 4, 'Ateneo de Naga University Grade School', '', NULL, 2008, 2014, '2025-03-24 06:50:25', '2025-03-24 06:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `sk_officials`
--

CREATE TABLE `sk_officials` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `slug` varchar(35) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `position` enum('SK Chairperson','SK Secretary','SK Treasurer','SK Kagawad') NOT NULL,
  `contact_number` varchar(14) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
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

INSERT INTO `sk_officials` (`id`, `barangay_id`, `slug`, `username`, `password`, `full_name`, `position`, `contact_number`, `address`, `email`, `birthday`, `motto`, `img`, `term_start`, `term_end`, `reset_token`, `token_expires`, `created_at`, `updated_at`) VALUES
(1, 1, 'dessa-mare', 'dessa', '123456', 'Dessa Mare P. Lontayao', 'SK Chairperson', '09274668490', '', 'dessa@localhost.net', '2003-03-28', '\"Bilang inyong SK Chairperson, ako’y naninindigan para sa kabataang may boses, may pangarap, at may lakas ng loob na maglingkod. Sama-sama tayong kikilos para sa makabuluhang pagbabago sa ating barangay.\"', 'images.jpeg', '2022-04-07', '2025-06-28', 'c88b1862cafeb7644995da16b1a5a031', '2025-03-18 10:15:31', '2025-02-21 06:16:33', '2025-05-22 13:43:55'),
(2, 2, 'irish', 'irish', 'qwerty', 'Irish N. Zaragoza', 'SK Chairperson', '09082565497', '', 'irish@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:33:27'),
(3, 3, 'anthony', '', '', 'Anthony T. Balbuena', 'SK Chairperson', '09915612246', '', 'anthony@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(4, 4, 'aiden-osward', '', '', 'Aiden Osward M. Basagre', 'SK Chairperson', '09617360226', '', 'aiden@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(5, 5, 'neil-christian', '', '', 'Neil Christian D. Vargas', 'SK Chairperson', '09773292890', '', 'neil@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(6, 6, 'jade-dustin', '', '', 'Jade Dustin F. Villareal', 'SK Chairperson', '09291118624', '', 'jade@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(7, 7, 'kim-roland', '', '', 'Kim Roland P. Vargas', 'SK Chairperson', '09618808019', '', 'kim@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(8, 8, 'leiriz', '', '', 'Leiriz C. Ibarreta', 'SK Chairperson', '09508374203', '', 'leiriz@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(9, 9, 'bea-franchezka', '', '', 'Bea Franchezka Naldo', 'SK Chairperson', '09484018819', '', 'bea@localhost.net', NULL, 'Unified Youth for One Santiago', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(10, 10, 'rex', '', '', 'Rex A. Embestro', 'SK Chairperson', '09915618021', '', 'rex@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(11, 11, 'rico', '', '', 'Rico Maniscan', 'SK Chairperson', '0', '', 'rico@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(12, 12, 'jhustine', '', '', 'Jhustine A. Robles', 'SK Chairperson', '09674164962', '', 'jhustine@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(13, 13, 'james-lorren', '', '', 'James Lorren J. Brondial', 'SK Chairperson', '09092168955', '', 'james@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(14, 14, 'eddel-mae', '', '', 'Eddel Mae D. Brago', 'SK Chairperson', '09203025407', '', 'eddel@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(15, 15, 'prince-leonard', '', '', 'Prince Leonard W. Llagas', 'SK Chairperson', '09518971664', '', 'prince@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(16, 16, 'diana-rose', '', '', 'Diana Rose A. Canlas', 'SK Chairperson', '09950653343', '', 'diana@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(17, 17, 'mary-grace', '', '', 'Mary Grace A. Biag', 'SK Chairperson', '09916828638', '', 'mary@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(18, 18, 'jean-lyka', '', '', 'Jean-Lyka C. Villanueva', 'SK Chairperson', '09919459266', '', 'jean@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(19, 19, 'james', '', '', 'James S. Tasarra', 'SK Chairperson', '09630466338', '', 'james@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(20, 20, 'aliza-mae', '', '', 'Aliza Mae P. Viñas', 'SK Chairperson', '09383706542', '', 'aliza@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(21, 21, 'erika-mae', '', '', 'Erika Mae V. Molina', 'SK Chairperson', '09389182048', '', 'erika@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(22, 22, 'jessa-mae', '', '', 'Jessa Mae C. Matubis', 'SK Chairperson', '09486804219', '', 'jessa@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(23, 1, 'sample', 'sample', '', 'Lee Hye-ri', 'SK Secretary', '09709542681', '', 'sample_official@localhost.net', '1994-06-09', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt', 'Screenshot 2025-05-22 214258.png', '2024-03-05', '2025-06-13', NULL, NULL, '2025-03-12 10:58:56', '2025-05-29 01:52:57'),
(24, 1, 'secretary-san-francisco', 'secretary-sf', 'password', 'Honda Civic', 'SK Secretary', '09171234567', '', 'secretary_sf@localhost.net', '1990-01-01', 'Leading with diligence', 'wp2367468.jpg', '2025-01-01', '2025-12-31', NULL, NULL, '2025-03-26 04:21:13', '2025-05-22 13:45:24'),
(25, 1, 'treasurer-san-francisco', 'treasurer_sf', 'password', 'SK Treasurer - San Francisco', 'SK Treasurer', '09172234567', '', 'treasurer_sf@localhost.net', '1991-02-02', 'Managing funds responsible', '', '2025-01-01', '2025-12-31', NULL, NULL, '2025-03-26 04:21:13', '2025-03-26 04:21:13'),
(26, 1, 'kagawad1-san-francisco', 'kagawad1_sf', 'password', 'SK Kagawad 1 - San Francisco', 'SK Kagawad', '09173234567', '', 'kagawad1_sf@localhost.net', '1992-03-03', 'Empowering youth', '', '2025-01-01', '2025-12-31', NULL, NULL, '2025-03-26 04:21:13', '2025-03-26 04:21:13'),
(27, 1, 'kagawad2-san-francisco', 'kagawad2_sf', 'password', 'SK Kagawad 2 - San Francisco', 'SK Kagawad', '09174234567', '', 'kagawad2_sf@localhost.net', '1993-04-04', 'Striving for progress', '', '2025-01-01', '2025-12-31', NULL, NULL, '2025-03-26 04:21:13', '2025-03-26 04:21:13');

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

-- --------------------------------------------------------

--
-- Table structure for table `sk_programs`
--

CREATE TABLE `sk_programs` (
  `id` int(11) NOT NULL,
  `sk_platform_id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `subtitle` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `thumbnail` varchar(50) NOT NULL,
  `status` enum('Done','Pending','Dismissed','') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `fk_achievements_sk_officials` (`sk_official_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `announcement_datetime`
--
ALTER TABLE `announcement_datetime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_idfk_2` (`announcement_id`);

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
-- Indexes for table `education_levels`
--
ALTER TABLE `education_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `youth_id` (`youth_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

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
  ADD KEY `education_level_id` (`education_level_id`),
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
  ADD KEY `sk_programsfk1` (`sk_platform_id`),
  ADD KEY `sk_programsfk2` (`achievement_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `announcement_datetime`
--
ALTER TABLE `announcement_datetime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- AUTO_INCREMENT for table `education_levels`
--
ALTER TABLE `education_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sk_advocacies`
--
ALTER TABLE `sk_advocacies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sk_educations`
--
ALTER TABLE `sk_educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sk_officials`
--
ALTER TABLE `sk_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sk_platforms`
--
ALTER TABLE `sk_platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sk_programs`
--
ALTER TABLE `sk_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `fk_achievements_sk_officials` FOREIGN KEY (`sk_official_id`) REFERENCES `sk_officials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `announcement_datetime`
--
ALTER TABLE `announcement_datetime`
  ADD CONSTRAINT `announcement_idfk_2` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`youth_id`) REFERENCES `youths` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sk_advocacies`
--
ALTER TABLE `sk_advocacies`
  ADD CONSTRAINT `sk_advocacyfk1` FOREIGN KEY (`sk_official_id`) REFERENCES `sk_officials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sk_educations`
--
ALTER TABLE `sk_educations`
  ADD CONSTRAINT `fk_education_levels` FOREIGN KEY (`education_level_id`) REFERENCES `education_levels` (`id`) ON UPDATE CASCADE,
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
  ADD CONSTRAINT `sk_programsfk1` FOREIGN KEY (`sk_platform_id`) REFERENCES `sk_platforms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sk_programsfk2` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `youths`
--
ALTER TABLE `youths`
  ADD CONSTRAINT `youths_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
