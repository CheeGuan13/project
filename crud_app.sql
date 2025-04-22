-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 22, 2025 at 04:22 AM
-- Server version: 8.0.41
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `name`, `password`) VALUES
(123, 'Cheng', '$2y$10$dOlSpEfK3jnMoRs.nj9Mb.ng/J89GJ5GrQ4bAs8dAYJ5pX8cACOgy'),
(555, 'Darryl', '$2y$10$PbYQgCpzbRyfvGb46jJCp.x9Q3//T0S6yQGnxBzdeUNb/nq.v6uvq');

-- --------------------------------------------------------

--
-- Table structure for table `book_details`
--

CREATE TABLE `book_details` (
  `BookID` int NOT NULL,
  `Title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Published_Date` date NOT NULL,
  `Genre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Synopsis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_details`
--

INSERT INTO `book_details` (`BookID`, `Title`, `Author`, `Published_Date`, `Genre`, `Synopsis`, `Image`) VALUES
(1, 'The First Frost', 'Zhu Yi', '2025-04-18', 'Romance', 'Romance story about Wen Yi Fan and Sang Yan', 'images/book1.jpg'),
(3, 'The Dream Hotel', 'Laila Lalami', '2025-04-22', 'Technology', 'A novel about one woman’s fight for freedom, set in a near future where even dreams are under surveillance. \r\nSara has just landed at LAX, returning home from a conference abroad, when agents from the Risk Assessment Administration pull her aside and inform her that she will soon commit a crime. Using data from her dreams, the RAA’s algorithm has determined that she is at imminent risk of harming the person she loves most: her husband. For his safety, she must be kept under observation for twenty-one days.', 'uploads/book_1745292125_68070b5d0bdab.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `forum_id` int DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `forum_id`, `username`, `content`, `created_at`) VALUES
(22, 11, 'Dgan0621', 'haha', '2025-04-21 15:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `forum_id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `username`, `title`, `content`, `created_at`) VALUES
(1, 'Cheng Bin', 'First Frost', 'The story of \"First Frost\" is good and heartwarming. Absolutely worth a watch!', '2025-04-19 16:12:21'),
(10, 'Wen Hao', 'Count My Lies', 'OMG! What a twisted, twisted tale. From the very beginning, I was drawn in by the deliciously unhinged premise that just got better with each page. Told in four increasingly shocking parts that turned everything inside out and upside down, the pile of lies grew right along with the page count. The truth, though, was what made this book sing. You see, thanks to a Gone Girl-esque vibe, I was positively hooked by the the unbridled deceit, underhanded manipulation, and well-hidden secrets that made this book into a multilayered treat for yours truly as they exploded into view.', '2025-04-19 16:17:13'),
(11, 'Chee Guan', 'Wings of Starlight', 'I like how they ended happily together. I SCREAM THROUGH TEARS STREAMING DOWN MY FACE!!!', '2025-04-19 16:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `forum_likes`
--

CREATE TABLE `forum_likes` (
  `like_id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `forum_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_likes`
--

INSERT INTO `forum_likes` (`like_id`, `username`, `forum_id`, `created_at`) VALUES
(17, 'Dgan0621', 11, '2025-04-21 17:14:09'),
(19, 'hehehehe', 11, '2025-04-22 02:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'images/user-icon.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `created_at`, `avatar`) VALUES
(29, 'Darryl', 'Darryl', 'darr@gmail.com', '$2y$10$Q2E8ti7r95AULJTyo4ju0u2uv1u4YUugmiwKm8FGSfYqc65HxwplW', '2025-04-21 15:17:53', 'uploads/avatar_Dgan0621_1745255667.jpg'),
(30, 'Wen Hao', 'hehehehe', 'jdisa@gmail.com', '$2y$10$IKp0MLoYWE2hdE./CIE/R.2cGgrbOXC14ImMvKiZbwbvO9giTkdKi', '2025-04-21 15:21:47', 'images/user-icon.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `book_details`
--
ALTER TABLE `book_details`
  ADD PRIMARY KEY (`BookID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `forum_id` (`forum_id`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`forum_id`);

--
-- Indexes for table `forum_likes`
--
ALTER TABLE `forum_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `unique_like` (`username`,`forum_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_details`
--
ALTER TABLE `book_details`
  MODIFY `BookID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `forum_likes`
--
ALTER TABLE `forum_likes`
  MODIFY `like_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
