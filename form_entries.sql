-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 06, 2024 at 08:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_entries`
--

CREATE TABLE `form_entries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `subscribe` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_entries`
--

INSERT INTO `form_entries` (`id`, `name`, `email`, `message`, `gender`, `subscribe`, `created_at`) VALUES
(1, 'Hassan', 'hs@gmail.com', 'Lorem Ipsum ', 'male', 1, '2024-05-06 16:37:35'),
(2, 'dev', 'devhs@gmail.com', 'Lorem Ipsum dev', 'male', 1, '2024-05-06 16:38:25'),
(3, 'dev', 'devsdhs@gmail.com', 'sadadsa', 'male', 1, '2024-05-06 16:46:45'),
(4, 'dev', 'sadad@gmail.com', 'asdad', 'male', 1, '2024-05-06 16:47:41'),
(7, 'dev', 'manystrategy@gmail.com', 'sdsad', 'male', 1, '2024-05-06 16:54:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_entries`
--
ALTER TABLE `form_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_entries`
--
ALTER TABLE `form_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
