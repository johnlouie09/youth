-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 09:09 AM
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
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cluster_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `name`, `cluster_id`, `created_at`, `updated_at`) VALUES
(1, 'San Francisco', 1, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(2, 'Francia', 1, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(3, 'La Purisima', 1, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(4, 'San Juan', 1, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(5, 'San Jose', 1, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(6, 'San Miguel', 1, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(7, 'San Nicolas', 2, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(8, 'Del Rosario', 3, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(9, 'Santiago', 3, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(10, 'Sto. Domingo', 3, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(11, 'La Anunciacion', 3, '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(12, 'Sta. Cruz Norte', 4, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(13, 'Cristo Rey', 4, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(14, 'San Vicente Norte', 4, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(15, 'Antipolo', 4, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(16, 'Sta. Maria', 4, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(17, 'San Pedro', 4, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(18, 'San Rafael', 4, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(19, 'Sta. Cruz Sur', 5, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(20, 'Sto. Niño', 5, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(21, 'San Vicente Sur', 5, '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(22, 'Salvacion', 5, '2025-02-17 08:07:33', '2025-02-17 08:07:33');

-- --------------------------------------------------------

--
-- Table structure for table `clusters`
--

CREATE TABLE `clusters` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clusters`
--

INSERT INTO `clusters` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Poblacion Unit', '2025-02-17 07:54:50', '2025-02-17 07:54:50'),
(2, 'National Road Unit', '2025-02-17 07:54:50', '2025-02-17 07:54:50'),
(3, 'East Road Unit', '2025-02-17 07:56:30', '2025-02-17 07:56:30'),
(4, 'Mountain Unit', '2025-02-17 07:56:30', '2025-02-17 07:56:30'),
(5, 'River Unit', '2025-02-17 07:56:30', '2025-02-17 07:56:30');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(200) NOT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `status` enum('Proposed','Ongoing','Completed') DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_chairpersons`
--

CREATE TABLE `sk_chairpersons` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `contact_number` int(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `barangay_id` tinyint(3) UNSIGNED NOT NULL,
  `term_start` date DEFAULT NULL,
  `term_end` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_members`
--

CREATE TABLE `sk_members` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `position` enum('SK Secretary','SK Treasurer','SK Kagawad','') NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `sk_chairpersons`
--
ALTER TABLE `sk_chairpersons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `sk_members`
--
ALTER TABLE `sk_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `clusters`
--
ALTER TABLE `clusters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sk_chairpersons`
--
ALTER TABLE `sk_chairpersons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sk_members`
--
ALTER TABLE `sk_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `sk_members`
--
ALTER TABLE `sk_members`
  ADD CONSTRAINT `sk_members_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
