-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 10:38 PM
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
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'admin', '2025-02-21 03:55:40'),
(4, 'sk-admin', '$2y$10$.pkAzmiSRIteWTkSl1c17Ocu96EdyP43DJ8WTHwZWbH37pGMV5AEO', '2025-02-21 03:59:43');

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `id` int(11) NOT NULL,
  `cluster_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `cluster_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'San Francisco', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(2, 1, 'Francia', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(3, 1, 'La Purisima', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(4, 1, 'San Juan', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(5, 1, 'San Jose', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(6, 1, 'San Miguel', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(7, 2, 'San Nicolas', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(8, 3, 'Del Rosario', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(9, 3, 'Santiago', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(10, 3, 'Sto. Domingo', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(11, 3, 'La Anunciacion', '2025-02-17 08:00:20', '2025-02-17 08:00:20'),
(12, 4, 'Sta. Cruz Norte', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(13, 4, 'Cristo Rey', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(14, 4, 'San Vicente Norte', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(15, 4, 'Antipolo', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(16, 4, 'Sta. Maria', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(17, 4, 'San Pedro', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(18, 4, 'San Rafael', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(19, 5, 'Sta. Cruz Sur', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(20, 5, 'Sto. Niño', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(21, 5, 'San Vicente Sur', '2025-02-17 08:07:33', '2025-02-17 08:07:33'),
(22, 5, 'Salvacion', '2025-02-17 08:07:33', '2025-02-17 08:07:33');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_achievement`
--

CREATE TABLE `barangay_achievement` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `subtitle` varchar(100) NOT NULL,
  `info` text NOT NULL,
  `img` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_achievement`
--

INSERT INTO `barangay_achievement` (`id`, `barangay_id`, `title`, `subtitle`, `info`, `img`, `date`) VALUES
(1, 1, 'Hello', 'Community unites for cleaner streets', 'The barangay successfully conducted a clean-up drive, removing over 500kg of waste.', '/public/ex.jpg', '2024-04-22'),
(2, 1, 'Medical Mission', 'Free healthcare services for residents', 'Over 300 residents received free medical checkups and medicines.', 'medical.jpg', '2024-02-10'),
(3, 1, 'Youth Leadership Seminar', 'Empowering the next leaders', 'The barangay hosted a leadership seminar for young individuals.', 'youth_seminar.jpg', '2024-03-05'),
(4, 1, 'Barangay Basketball League', 'Sports event for the youth', 'The annual basketball tournament engaged over 10 teams.', 'basketball.jpg', '2024-04-20'),
(5, 1, 'Scholarship Granting', 'Helping students achieve their dreams', 'Ten students received full scholarships.', '/public/ex.jpg', '2024-05-15'),
(6, 1, 'Tree Planting Initiative', 'Environmental awareness program', 'Residents planted over 1,000 trees.', 'tree_planting.jpg', '2024-06-18'),
(7, 1, 'Livelihood Training', 'Supporting small businesses', 'Residents received training in baking and soap making.', 'livelihood.jpg', '2024-07-25'),
(8, 1, 'Disaster Preparedness Drill', 'Ensuring community safety', 'A drill was conducted with over 500 participants.', 'drill.jpg', '2024-08-10'),
(9, 1, 'Feeding Program', 'Nutrition for children', '300 children received free nutritious meals.', 'feeding.jpg', '2024-09-05'),
(10, 1, 'Elderly Support Program', 'Caring for our seniors', 'Seniors were given free medical checkups and wellness programs.', 'elderly.jpg', '2024-10-12'),
(11, 1, 'Barangay Fiesta', 'Celebrating unity', 'The barangay held a grand fiesta with cultural performances.', 'fiesta.jpg', '2024-11-20'),
(12, 1, 'Year-End Recognition', 'Honoring outstanding citizens', 'Outstanding youth and barangay officials were awarded.', 'recognition.jpg', '2024-12-15'),
(13, 1, 'Job Fair 2025', 'Providing employment opportunities', 'Over 100 people found job opportunities.', 'job_fair.jpg', '2025-01-10'),
(14, 1, 'Anti-Drug Campaign', 'Spreading awareness on drug prevention', 'An awareness seminar on the dangers of drugs was held.', 'anti_drug.jpg', '2025-01-25'),
(15, 1, 'Sports Clinic', 'Training young athletes', 'A sports training program was conducted for young athletes.', 'sports_clinic.jpg', '2025-02-05'),
(16, 1, 'IT Skills Training', 'Equipping youth with digital skills', 'Students were trained in basic coding and graphic design.', 'it_training.jpg', '2025-02-12'),
(17, 1, 'Fire Safety Seminar', 'Educating residents on fire prevention', 'Residents were taught fire prevention techniques.', 'fire_safety.jpg', '2025-02-18'),
(18, 1, 'Community Garden Project', 'Promoting urban gardening', 'A community garden was established in the barangay.', '/public/ex.jpg', '2025-02-22'),
(19, 1, 'Ginawsssa q naman lahat huhuhuHU', 'Celebrating women in leadership', 'A forum was conducted to discuss women’s rights and empowerment.', '/public/ex.jpg', '2025-02-28');

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
  `barangay_id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
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
  `barangay_id` int(11) NOT NULL,
  `project_name` varchar(200) NOT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `status` enum('Proposed','Ongoing','Completed') DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sk_chairpersons`
--

CREATE TABLE `sk_chairpersons` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `contact_number` int(12) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `term_start` date DEFAULT NULL,
  `term_end` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sk_chairpersons`
--

INSERT INTO `sk_chairpersons` (`id`, `barangay_id`, `full_name`, `contact_number`, `email`, `term_start`, `term_end`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dessa Mare P. Lontayao', 0, '', NULL, NULL, '2025-02-21 06:16:33', '2025-02-21 06:43:34'),
(2, 2, 'Irish N. Zaragoza', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(3, 3, 'Anthony T. Balbuena', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(4, 4, 'Aiden Osward M. Basagre', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(5, 5, 'Neil Christian D. Vargas', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(6, 6, 'Jade Dustin F. Villareal', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(7, 7, 'Kim Roland P. Vargas', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(8, 8, 'Leiriz C. Ibarreta', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(9, 9, 'Bea Franchezka Naldo', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(10, 10, 'Rex A. Embestro', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(11, 11, 'Rico Maniscan', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(12, 12, 'Jhustine A. Robles', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(13, 13, 'James Lorren J. Brondial', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(14, 14, 'Eddel Mae D. Brago', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(15, 15, 'Princes Leonard W. Llagas', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(16, 16, 'Diana Rose A. Canlas', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(17, 17, 'Mary Grace A. Biag', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(18, 18, 'Jean-Lyka C. Villanueva', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(19, 19, 'James S. Tasarra', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(20, 20, 'Aliza Mae P. Viñas', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(21, 21, 'Erika Mae V. Molina', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36'),
(22, 22, 'Jessa Mae C. Matubis', 0, '', NULL, NULL, '2025-02-21 06:41:36', '2025-02-21 06:41:36');

-- --------------------------------------------------------

--
-- Table structure for table `sk_members`
--

CREATE TABLE `sk_members` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `position` enum('SK Secretary','SK Treasurer','SK Kagawad','') NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cluster_id` (`cluster_id`);

--
-- Indexes for table `barangay_achievement`
--
ALTER TABLE `barangay_achievement`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `barangay_achievement`
--
ALTER TABLE `barangay_achievement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- Constraints for table `sk_chairpersons`
--
ALTER TABLE `sk_chairpersons`
  ADD CONSTRAINT `sk_chairpersons_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sk_members`
--
ALTER TABLE `sk_members`
  ADD CONSTRAINT `sk_members_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
