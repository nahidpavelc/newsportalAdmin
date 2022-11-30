-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 11:23 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `extra_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_photo_album_2`
--

CREATE TABLE `tbl_photo_album_2` (
  `id` int(11) NOT NULL,
  `album_title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT 1 COMMENT 'max are top',
  `insert_by` int(11) NOT NULL,
  `insert_time` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_photo_album_2`
--

INSERT INTO `tbl_photo_album_2` (`id`, `album_title`, `priority`, `insert_by`, `insert_time`) VALUES
(3, 'This is the bset ', 8, 1, '2022-09-25 17:28:03'),
(10, 'Travel Album', 5, 1, '2022-11-28 12:59:53'),
(11, 'New ', 5, 1, '2022-11-28 15:58:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_photo_album_2`
--
ALTER TABLE `tbl_photo_album_2`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_photo_album_2`
--
ALTER TABLE `tbl_photo_album_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
