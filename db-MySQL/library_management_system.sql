-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2025 at 04:24 PM
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
-- Database: `library_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_users`
--

CREATE TABLE `all_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','librarian','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_users`
--

INSERT INTO `all_users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Sabbir', 'sabbir@gmail.com', '$2y$10$b7Ab4SceVFzJcCk9NBxtjeckr00QLaRAliI/3Q3qW/O2wpshamhKG', 'admin'),
(3, 'Hossain', 'hossain@gmail.com', '$2y$10$zkAobPIIyHYaeX1gRhQKOeS2dfxWdppCEyEdy9skFCWP7nDbhW.ma', 'librarian'),
(5, 'Niyaz', 'niyaz@gmail.com', '$2y$10$fbWknEBAdZeAReAiQhs1VuLTKw4/IHXcd6xIee7byGoGAiNCuFxF.', 'student'),
(9, 'test', 'test@gmail.com', '$2y$10$J4luMO0rpKH3SJ7pfvEnVOHdFkWRQDVI4M7MMSvVUOJ.3Di/6iMg2', 'admin'),
(22, 'MVC', 'mvc@gmail.com', '$2y$10$hZ6AxsNbTBHkt9W3unKXvOs1XTD91q4pehfCvKgEJe0rWcqf6NbVK', 'student'),
(25, 'admin', 'admin@gmail.com', '$2y$10$IG.n9NFcbofoK1uAPQYzlOQJ91gkg./WdKXUEAQcytphICIbk0PNy', 'admin'),
(27, 'des', 'd@gmil.com', '$2y$10$/JRAeHQWL05FWTb5rcFTE.a1ZclesdDbSdHva5pkQoyB6p7NJ0uHG', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `copies` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `copies`, `created_at`) VALUES
(2, 'C++', 'Sabbir Hossain', 'EEE', 10, '2025-09-16 21:23:55'),
(5, 'C#', 'Niyaz', 'CSE', 6, '2025-09-16 22:05:23'),
(6, 'JAVA', 'shn', 'CSE', 10, '2025-09-17 19:30:33'),
(7, 'CSS', 'SHN', 'CS', 2, '2025-09-17 20:32:25'),
(8, 'HTML', 'Hossain', 'CS', 5, '2025-09-17 20:37:14'),
(9, 'php', 'sabbir', 'CS', 5, '2025-09-18 21:37:44'),
(12, 'busCom', 'kst', 'BBA', 10, '2025-09-21 22:38:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_users`
--
ALTER TABLE `all_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_users`
--
ALTER TABLE `all_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
