-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 03:29 PM
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
-- Database: `votewebdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `role` varchar(254) NOT NULL,
  `password` varchar(254) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'admin', '12345', '2024-06-30 18:20:01', '2024-06-30 18:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `fname` varchar(254) NOT NULL,
  `lname` varchar(254) NOT NULL,
  `company` varchar(254) NOT NULL,
  `email` varchar(254) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `fname`, `lname`, `company`, `email`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Kayode', 'Owoseni', 'Mhista Kayne', 'abc@gmail.com', 'This will ensure that the background color is set to #ffb7d5 and override any other styles that may be applied to the element.\r\n\r\nIf you want to add additional styles to make the text more prominent, you can add other properties...', '2024-07-03 22:36:53', '2024-07-03 22:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `about` varchar(200) NOT NULL,
  `details1` mediumtext NOT NULL,
  `details2` mediumtext NOT NULL,
  `details3` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `topic`, `about`, `details1`, `details2`, `details3`, `created_at`, `updated_at`) VALUES
(1, 'Stay Tuned with VoteWebApp', 'Keep up to date with important election information and reminders. VoteWebApp ensures you never miss an important date or announcement.', '<b>Upcoming Election Dates:</b> Receive timely notifications about upcoming election dates so you can be prepared and informed.', '<b>Polling Station Information:</b> Get updates on your designated polling station, including any changes or important details.', '<b>Important Announcements:</b> Stay informed with crucial messages and updates from election officials to ensure a smooth voting experience.', '2024-07-04 00:16:26', '2024-07-04 00:16:26'),
(2, 'Stay Tuned with VoteWebApp', 'Keep up to date with important election information and reminders. VoteWebApp ensures you never miss an important date or announcement.', '<b>Upcoming Election Dates:</b> Receive timely notifications about upcoming election dates so you can be prepared and informed.', '<b>Polling Station Information:</b> Get updates on your designated polling station, including any changes or important details.', '<b>Important Announcements:</b> Stay informed with crucial messages and updates from election officials to ensure a smooth voting experience.', '2024-07-04 00:54:14', '2024-07-04 00:54:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `idno` varchar(50) NOT NULL,
  `pstation` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `picture` varchar(200) NOT NULL DEFAULT 'product.jpg',
  `password` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `role`, `idno`, `pstation`, `phone`, `address`, `picture`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Kunle One', 'officer@example.com', 'officer123', 'officer', '', '', '', '', 'default.jpg', '12345', '2024-06-30 19:38:17', '2024-06-30 19:38:17'),
(2, 'New Details', 'voter@example.com', 'voter1', 'voter', '1234567890', 'Scotland', '09012345678', '2, Address street, Nearest Bus-stop, Landmark, State', 'updatedvoter_95575.jpg', '54321', '2024-06-30 19:59:07', '2024-06-30 19:59:07'),
(3, 'Edited Voter Three', 'voter2@example.com', 'voter2', 'voter', '5432109876', 'Manchester', '08012345678', '2, Banjo street, Agiliti Mile-12', 'updatedvoter_73979.jpg', '54321', '2024-07-01 03:12:18', '2024-07-01 03:12:18'),
(4, 'Better ID 3 Voter', 'voter3@example.com', 'voter3', 'voter', '6267318652', 'Sunderland', '08012345678', '3, Banjo street, Agiliti Mile-12', 'updatedvoter_98699.jpg', '54321', '2024-07-01 03:19:41', '2024-07-01 03:19:41'),
(5, 'Hutty', 'officer2@gmail.com', 'hutty123', 'officer', '', '', '', '', 'updatedofficer_67773.jpg', '12345', '2024-07-01 09:34:45', '2024-07-01 09:34:45'),
(7, 'Voter Four', 'voter4@gmail.com', 'voter4', 'voter', '6456388298', 'Scotland', '09098765432', '1, Address Street, Location Nigeria', 'updatedvoter_84306.jpg', '12345', '2024-07-02 18:29:28', '2024-07-02 18:29:28'),
(12, 'New Voter', 'newvoter@gmail.com', 'newvoter', 'voter', '5677234872', 'DebbyCounty', '08012345678', '5, Street, Landmark, Country', 'updatedvoter_96545.jpg', '12345', '2024-07-03 20:45:34', '2024-07-03 20:45:34'),
(14, 'Picture', 'voter35243@example.com', 'Malkayne', 'voter', '4234534635', 'Scotland', '41354252345', 'qwfawre', 'voter_2880.jpg', '12345', '2024-07-11 00:17:22', '2024-07-11 00:17:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
