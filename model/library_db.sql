-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2025 at 12:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `summary` text NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `summary`, `quantity`) VALUES
(13, 'zz', 'zz', 'zz', 'zz', 1),
(17, 'adsf', 'asdaf', 'asdf', 'asdf', 2),
(18, 'asdf', 'asdf', 'asdf', 'adsf', 0),
(20, 'test book ', 'aaa', 'ddfdd', 'some ', 1),
(21, 'sfg', 'sdfg', 'sdfg', 'sdfg', 1),
(22, 'sdfg', 'sfdg', 'sdfg', 'sdfg', 1),
(23, 'sdfgs', 'fdg', 'sdfg', 'sdfg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` datetime DEFAULT current_timestamp(),
  `return_date` datetime DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`id`, `student_id`, `book_id`, `borrow_date`, `return_date`, `due_date`) VALUES
(1, 27, 13, '2025-09-13 16:04:23', '2025-09-13 16:58:14', NULL),
(2, 27, 16, '2025-09-13 16:10:21', '2025-09-13 16:58:37', NULL),
(3, 27, 17, '2025-09-13 16:10:52', '2025-09-13 16:57:06', NULL),
(4, 27, 17, '2025-09-13 16:13:03', '2025-09-13 16:55:47', NULL),
(5, 27, 17, '2025-09-13 16:57:21', '2025-09-13 16:59:33', '2025-09-20'),
(6, 27, 19, '2025-09-13 16:59:14', '2025-09-13 16:59:21', '2025-09-20'),
(7, 27, 17, '2025-09-13 17:14:23', '2025-09-13 17:14:30', '2025-09-20'),
(8, 27, 20, '2025-09-13 17:26:02', '2025-09-13 17:26:07', '2025-09-20'),
(9, 27, 20, '2025-09-13 17:26:09', '2025-09-13 17:26:10', '2025-09-20'),
(10, 27, 13, '2025-09-13 17:26:11', '2025-09-13 17:26:21', '2025-09-20'),
(11, 27, 20, '2025-09-13 17:26:12', '2025-09-13 17:26:22', '2025-09-20'),
(12, 27, 18, '2025-09-13 17:26:13', '2025-09-13 17:26:23', '2025-09-20'),
(13, 27, 17, '2025-09-13 17:26:13', '2025-09-13 17:26:22', '2025-09-20'),
(14, 27, 16, '2025-09-13 17:26:14', '2025-09-13 17:26:23', '2025-09-20'),
(15, 27, 20, '2025-09-13 17:26:17', '2025-09-13 17:26:24', '2025-09-20'),
(16, 27, 17, '2025-09-13 17:26:19', '2025-09-13 17:26:25', '2025-09-20'),
(17, 27, 17, '2025-09-13 17:26:19', '2025-09-13 17:26:24', '2025-09-20'),
(18, 27, 17, '2025-09-13 17:26:20', '2025-09-13 17:26:25', '2025-09-20'),
(19, 34, 17, '2025-09-13 21:22:47', '2025-09-13 21:22:54', '2025-09-20'),
(20, 34, 18, '2025-09-13 21:22:47', '2025-09-13 21:22:55', '2025-09-20'),
(21, 34, 20, '2025-09-13 21:22:48', NULL, '2025-09-20'),
(22, 34, 13, '2025-09-13 21:22:49', '2025-09-13 21:22:53', '2025-09-20'),
(23, 34, 17, '2025-09-13 21:22:49', '2025-09-13 21:22:53', '2025-09-20'),
(24, 34, 16, '2025-09-13 21:22:49', '2025-09-13 21:22:52', '2025-09-20'),
(25, 34, 18, '2025-09-13 21:23:27', NULL, '2025-09-20'),
(26, 28, 13, '2025-09-13 21:23:49', '2025-09-13 21:23:56', '2025-09-20'),
(27, 28, 17, '2025-09-13 21:23:50', '2025-09-13 21:23:58', '2025-09-20'),
(28, 28, 16, '2025-09-13 21:23:50', '2025-09-13 21:23:58', '2025-09-20'),
(29, 28, 20, '2025-09-13 21:23:52', '2025-09-13 21:23:54', '2025-09-20'),
(30, 28, 17, '2025-09-13 21:23:52', '2025-09-13 21:23:55', '2025-09-20'),
(31, 28, 17, '2025-09-13 21:23:53', '2025-09-13 21:23:57', '2025-09-20'),
(32, 28, 16, '2025-09-13 21:24:02', NULL, '2025-09-20'),
(33, 27, 17, '2025-09-13 22:10:31', '2025-09-13 22:13:30', '2025-09-20'),
(34, 27, 17, '2025-09-13 22:10:32', '2025-09-13 22:13:31', '2025-09-20'),
(35, 27, 20, '2025-09-13 22:10:34', '2025-09-13 22:13:31', '2025-09-20'),
(36, 27, 13, '2025-09-13 22:10:34', '2025-09-13 22:13:31', '2025-09-20'),
(37, 27, 17, '2025-09-13 22:13:27', '2025-09-13 22:13:33', '2025-09-20'),
(38, 27, 17, '2025-09-13 22:13:28', '2025-09-13 22:13:32', '2025-09-20'),
(39, 27, 17, '2025-09-13 22:13:29', '2025-09-13 22:13:32', '2025-09-20'),
(40, 36, 13, '2025-09-14 00:36:23', '2025-09-14 00:55:07', '2025-09-20'),
(41, 36, 17, '2025-09-14 00:54:52', '2025-09-14 00:55:06', '2025-09-20'),
(42, 36, 17, '2025-09-14 00:54:53', '2025-09-14 00:55:06', '2025-09-20'),
(43, 36, 17, '2025-09-14 00:54:54', '2025-09-14 00:55:05', '2025-09-20'),
(44, 36, 17, '2025-09-14 00:54:54', '2025-09-14 00:55:05', '2025-09-20'),
(45, 36, 17, '2025-09-14 00:54:55', '2025-09-14 00:55:04', '2025-09-20'),
(46, 36, 13, '2025-09-14 01:17:34', '2025-09-14 01:26:04', '2025-09-20'),
(47, 36, 22, '2025-09-14 01:26:06', '2025-09-14 01:26:08', '2025-09-20'),
(48, 36, 22, '2025-09-14 01:38:58', '2025-09-14 01:39:18', '2025-09-20'),
(49, 36, 23, '2025-09-14 01:38:59', '2025-09-14 01:39:18', '2025-09-20'),
(50, 36, 21, '2025-09-14 01:39:00', '2025-09-14 01:39:17', '2025-09-20'),
(51, 36, 20, '2025-09-14 01:39:01', '2025-09-14 01:39:17', '2025-09-20'),
(52, 36, 13, '2025-09-14 01:39:03', '2025-09-14 01:39:16', '2025-09-20'),
(53, 36, 17, '2025-09-14 01:39:04', '2025-09-14 01:39:16', '2025-09-20'),
(54, 36, 17, '2025-09-14 01:39:04', '2025-09-14 01:39:14', '2025-09-20'),
(55, 36, 17, '2025-09-14 01:39:04', '2025-09-14 01:39:14', '2025-09-20'),
(56, 36, 17, '2025-09-14 01:39:05', '2025-09-14 01:39:15', '2025-09-20'),
(57, 36, 17, '2025-09-14 01:39:05', '2025-09-14 01:39:12', '2025-09-20'),
(58, 36, 23, '2025-09-14 01:39:30', '2025-09-14 01:39:33', '2025-09-20'),
(59, 36, 21, '2025-09-14 01:39:31', '2025-09-14 01:42:01', '2025-09-20'),
(60, 36, 22, '2025-09-14 02:09:19', '2025-09-14 02:09:26', '2025-09-20'),
(61, 36, 17, '2025-09-14 03:37:56', NULL, '2025-09-20'),
(62, 36, 17, '2025-09-14 03:37:56', NULL, '2025-09-20'),
(63, 36, 17, '2025-09-14 03:37:57', NULL, '2025-09-20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `role`, `reset_token`, `token_expire`) VALUES
(37, 'asdf', 'asdf', 'asdf@gmail.com', '$2y$10$VXWgJ8Ny01BBz5hfv/PL8eWjBsoqQF6X/arnwiJbLWmnIOGl.WVH6', 'admin', NULL, NULL),
(38, 'admin', 'admin', 'admin@gmail.com', '$2y$10$.1F2B.rKRGpk8.sFvfcaeuF6rR0Abc/PYAK4n5/6uQzXY5/eVwGyy', 'admin', NULL, NULL),
(39, 'student', 'student', 'student@gmail.com', '$2y$10$lM3pPdhhIZPt.hicAzlycOst3V.kSAD4SmzpPVptX5x3GCafhSoKq', 'student', NULL, NULL),
(40, 'libary', 'library', 'libary@gmail.com', '$2y$10$3/kQ348FK.Kvcs3JB6u0geIgvW.8yNxkYwnmkUaYij0a8Q4.4U31.', 'librarian', NULL, NULL),
(41, 'sw', 'sw', 'sw@gmail.com', '$2y$10$V5VnodP9wQsW..EI69IgaOg6j2S7N1qv5inblwSOijE3QGyr2sd6C', 'student', NULL, NULL),
(42, 'sss', 'sss', 'sss@gmail.com', '$2y$10$abVHEWX1xrUWGdVevx2UTuVXGhqljF/6lus0BQ1KkKzWbwfSs0pKS', 'librarian', NULL, NULL),
(43, 'ad admin', 'adadmin', 'adasmin@hfh.ff', '$2y$10$5d0kKWtaMY2wmsOvEmJItuvOiNpLLxOkiFI0tO2JSgow3J6Sf5Pb.', 'student', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
