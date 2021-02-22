-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2021 at 09:15 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_panel`
--

CREATE TABLE `admin_panel` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `category` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `post` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_panel`
--

INSERT INTO `admin_panel` (`id`, `datetime`, `title`, `category`, `author`, `image`, `post`) VALUES
(14, 'February-22-2021 00:24:33', 'post 1', 'PHP', 'rvnd', '', 'post 1'),
(15, 'February-22-2021 00:24:44', 'post 2', 'PHP', 'rvnd', '', 'post 2'),
(16, 'February-22-2021 00:24:52', 'post 3', 'Trending', 'rvnd', '', 'post 3'),
(17, 'February-22-2021 00:25:01', 'post 4', 'PHP', 'rvnd', '', 'post 4'),
(18, 'February-22-2021 00:25:31', 'post 5', 'Trending', 'nim1', '', 'post 5'),
(19, 'February-22-2021 00:25:39', 'post 6', 'Trending', 'nim1', '', 'post 6'),
(20, 'February-22-2021 00:25:51', 'post 7 ', 'PHP', 'nim1', '', 'post 7'),
(21, 'February-22-2021 00:26:02', 'post 8', 'Trending', 'nim1', '', 'post 8'),
(22, 'February-22-2021 00:26:40', 'post 9', 'Trending', 'babi', '', 'post 9'),
(23, 'February-22-2021 00:26:51', 'post 10', 'Trending', 'babi', '', 'post 10\r\n'),
(24, 'February-22-2021 00:26:57', 'post 11', 'Trending', 'babi', '', 'post 11'),
(25, 'February-22-2021 00:27:05', 'post 12', 'Trending', 'babi', '', 'post 12'),
(26, 'February-22-2021 00:27:10', 'post 13', 'Trending', 'babi', '', 'post 13'),
(27, 'February-22-2021 00:27:17', 'post 14', 'Trending', 'babi', '', 'post 14'),
(28, 'February-22-2021 00:27:24', 'post 15', 'Trending', 'babi', '', 'post 15'),
(29, 'February-22-2021 01:57:17', 'post 16', 'Trending', 'rvnd', '', 'post 16\r\nposda y \r\nsa dk oka j sfv m\r\nsa fadjfnadjhfui hadf '),
(30, 'February-22-2021 12:52:27', 'Testing date and time', 'PHP', 'rvnd', '', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `creatorname` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `datetime`, `name`, `creatorname`) VALUES
(2, 'February-16-2021 19:27:44', 'PHP', 'Ravindu Madushan'),
(10, 'February-21-2021 17:32:46', 'Trending', 'nim1'),
(11, 'February-22-2021 12:58:07', 'LOVE', 'rvnd');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedby` varchar(200) NOT NULL,
  `status` varchar(5) NOT NULL,
  `admin_panel_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedby`, `status`, `admin_panel_id`) VALUES
(9, 'February-22-2021 13:06:13', 'Ravindu', 'ravui@gmail.cmo', 'fhdagbf gfa ', 'rvnd', 'ON', 30);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `addedby` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `datetime`, `username`, `password`, `addedby`) VALUES
(3, 'February-21-2021 00:19:46', 'nim1', 'nim1', 'Ravindu Madushan'),
(4, 'February-21-2021 14:49:08', 'rvnd', 'rvnd', 'Ravindu Madushan'),
(5, 'February-21-2021 17:33:07', 'babi', 'babi', 'nim1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_panel`
--
ALTER TABLE `admin_panel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_panel_id` (`admin_panel_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_panel`
--
ALTER TABLE `admin_panel`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Foriegn key to admin_panel table` FOREIGN KEY (`admin_panel_id`) REFERENCES `admin_panel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
