-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 03:25 AM
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
(1, 1, 'Sample Achievement', 'Subtitle Achievement', 'Information of Achievement', NULL, '2025-03-03', '2025-03-12 10:49:25', '2025-03-12 10:49:25'),
(2, 23, 'Another Sample', 'Again Another Sample', 'This is the information for another sample', NULL, '2025-03-14', '2025-03-12 10:59:39', '2025-03-12 10:59:39');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `cluster_id`, `slug`, `name`, `img`, `created_at`, `updated_at`) VALUES
(1, 1, 'san-francisco', 'San Francisco', 'san_francisco_bh.jpg', '2025-02-17 08:00:20', '2025-03-13 13:32:13'),
(2, 1, 'francia', 'Francia', 'francia_bh.png', '2025-02-17 08:00:20', '2025-03-13 13:32:13'),
(3, 1, 'la-purisima', 'La Purisima', 'lapurisima_bh.png', '2025-02-17 08:00:20', '2025-03-13 13:32:13'),
(4, 1, 'san-juan', 'San Juan', 'san_juan_bh.jpg', '2025-02-17 08:00:20', '2025-03-13 13:32:13'),
(5, 1, 'san-jose', 'San Jose', 'san_jose_bh.jpg', '2025-02-17 08:00:20', '2025-03-13 13:32:13'),
(6, 1, 'san-miguel', 'San Miguel', 'san_miguel_bh.png', '2025-02-17 08:00:20', '2025-03-13 13:32:13'),
(7, 2, 'san-nicolas', 'San Nicolas', 'san_nicolas_bh.png', '2025-02-17 08:00:20', '2025-03-13 13:32:13'),
(8, 3, 'del-rosario', 'Del Rosario', '', '2025-02-17 08:00:20', '2025-03-10 08:42:59'),
(9, 3, 'santiago', 'Santiago', 'santiago_bh.jpeg', '2025-02-17 08:00:20', '2025-03-13 13:32:13'),
(10, 3, 'sto-domingo', 'Sto. Domingo', 'sto_domingo_bh.png', '2025-02-17 08:00:20', '2025-03-13 13:32:13'),
(11, 3, 'la-anunciacion', 'La Anunciacion', '', '2025-02-17 08:00:20', '2025-03-10 08:42:59'),
(12, 4, 'sta-cruz-norte', 'Sta. Cruz Norte', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59'),
(13, 4, 'cristo-rey', 'Cristo Rey', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59'),
(14, 4, 'san-vicente-norte', 'San Vicente Norte', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59'),
(15, 4, 'antipolo', 'Antipolo', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59'),
(16, 4, 'sta-maria', 'Sta. Maria', 'sta_maria_bh.png', '2025-02-17 08:07:33', '2025-03-13 13:32:13'),
(17, 4, 'san-pedro', 'San Pedro', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59'),
(18, 4, 'san-rafael', 'San Rafael', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59'),
(19, 5, 'sta-cruz-sur', 'Sta. Cruz Sur', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59'),
(20, 5, 'sto-niño', 'Sto. Niño', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59'),
(21, 5, 'san-vicente-sur', 'San Vicente Sur', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59'),
(22, 5, 'salvacion', 'Salvacion', '', '2025-02-17 08:07:33', '2025-03-10 08:42:59');

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
-- Table structure for table `sk_educations`
--

CREATE TABLE `sk_educations` (
  `id` int(11) NOT NULL,
  `sk_official_id` int(11) NOT NULL,
  `education_level_id` int(11) NOT NULL,
  `school_name` varchar(100) NOT NULL,
  `course` varchar(100) DEFAULT NULL,
  `start_year` int(4) DEFAULT NULL,
  `end_year` int(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_educations`
--

INSERT INTO `sk_educations` (`id`, `sk_official_id`, `education_level_id`, `school_name`, `course`, `start_year`, `end_year`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Sample Elementary School', NULL, 2006, 2012, '2025-03-11 11:43:03', '2025-03-11 11:43:03'),
(2, 1, 2, 'Sample High School', NULL, 2012, 2016, '2025-03-11 11:43:03', '2025-03-11 11:43:03'),
(3, 1, 3, 'Sample High School', NULL, 2016, 2018, '2025-03-11 11:43:03', '2025-03-11 11:43:03'),
(4, 1, 4, 'Camarines Sur Polytechnic College', 'Bachelor of Science in Tourism Management', 2018, 2022, '2025-03-11 11:43:03', '2025-03-11 11:43:03');

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

INSERT INTO `sk_officials` (`id`, `barangay_id`, `slug`, `username`, `password`, `full_name`, `position`, `contact_number`, `email`, `birthday`, `motto`, `img`, `term_start`, `term_end`, `reset_token`, `token_expires`, `created_at`, `updated_at`) VALUES
(1, 1, 'dessa-mare', 'dessa', '123456', 'Dessa Mare P. Lontayao', 'SK Chairperson', '09274668490', 'dessa@localhost.net', NULL, '', '', NULL, NULL, 'c88b1862cafeb7644995da16b1a5a031', '2025-03-18 10:15:31', '2025-02-21 06:16:33', '2025-03-18 02:14:31'),
(2, 2, 'irish', 'irish', 'qwerty', 'Irish N. Zaragoza', 'SK Chairperson', '09082565497', 'irish@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:33:27'),
(3, 3, 'anthony', '', '', 'Anthony T. Balbuena', 'SK Chairperson', '09915612246', 'anthony@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(4, 4, 'aiden-osward', '', '', 'Aiden Osward M. Basagre', 'SK Chairperson', '09617360226', 'aiden@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(5, 5, 'neil-christian', '', '', 'Neil Christian D. Vargas', 'SK Chairperson', '09773292890', 'neil@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(6, 6, 'jade-dustin', '', '', 'Jade Dustin F. Villareal', 'SK Chairperson', '09291118624', 'jade@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(7, 7, 'kim-roland', '', '', 'Kim Roland P. Vargas', 'SK Chairperson', '09618808019', 'kim@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(8, 8, 'leiriz', '', '', 'Leiriz C. Ibarreta', 'SK Chairperson', '09508374203', 'leiriz@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(9, 9, 'bea-franchezka', '', '', 'Bea Franchezka Naldo', 'SK Chairperson', '09484018819', 'bea@localhost.net', NULL, 'Unified Youth for One Santiago', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(10, 10, 'rex', '', '', 'Rex A. Embestro', 'SK Chairperson', '09915618021', 'rex@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(11, 11, 'rico', '', '', 'Rico Maniscan', 'SK Chairperson', '0', 'rico@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(12, 12, 'jhustine', '', '', 'Jhustine A. Robles', 'SK Chairperson', '09674164962', 'jhustine@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(13, 13, 'james-lorren', '', '', 'James Lorren J. Brondial', 'SK Chairperson', '09092168955', 'james@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:50:47'),
(14, 14, 'eddel-mae', '', '', 'Eddel Mae D. Brago', 'SK Chairperson', '09203025407', 'eddel@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(15, 15, 'prince-leonard', '', '', 'Prince Leonard W. Llagas', 'SK Chairperson', '09518971664', 'prince@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(16, 16, 'diana-rose', '', '', 'Diana Rose A. Canlas', 'SK Chairperson', '09950653343', 'diana@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(17, 17, 'mary-grace', '', '', 'Mary Grace A. Biag', 'SK Chairperson', '09916828638', 'mary@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(18, 18, 'jean-lyka', '', '', 'Jean-Lyka C. Villanueva', 'SK Chairperson', '09919459266', 'jean@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(19, 19, 'james', '', '', 'James S. Tasarra', 'SK Chairperson', '09630466338', 'james@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(20, 20, 'aliza-mae', '', '', 'Aliza Mae P. Viñas', 'SK Chairperson', '09383706542', 'aliza@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(21, 21, 'erika-mae', '', '', 'Erika Mae V. Molina', 'SK Chairperson', '09389182048', 'erika@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(22, 22, 'jessa-mae', '', '', 'Jessa Mae C. Matubis', 'SK Chairperson', '09486804219', 'jessa@localhost.net', NULL, '', '', NULL, NULL, NULL, NULL, '2025-02-21 06:41:36', '2025-03-17 05:58:47'),
(23, 1, 'sample', 'sample', '', 'Sample for San Francisco', 'SK Secretary', '', 'sample_official@localhost.net', NULL, 'I\'m created just for a test.', '', NULL, NULL, NULL, NULL, '2025-03-12 10:58:56', '2025-03-17 05:58:47');

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
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sk_educations`
--
ALTER TABLE `sk_educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sk_officials`
--
ALTER TABLE `sk_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `fk_achievements_sk_officials` FOREIGN KEY (`sk_official_id`) REFERENCES `sk_officials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
