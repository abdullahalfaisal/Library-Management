-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2025 at 10:42 AM
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
-- Database: `books_info`
--

-- --------------------------------------------------------

--
-- Table structure for table `booksinfo`
--

CREATE TABLE `booksinfo` (
  `id` int(50) NOT NULL,
  `book_Name` varchar(100) NOT NULL,
  `author_Name` varchar(100) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booksinfo`
--

INSERT INTO `booksinfo` (`id`, `book_Name`, `author_Name`, `quantity`) VALUES
(1, 'Pather Panchali', 'Bibhutibhushan Bandyopadhyay', 10),
(2, 'Gitanjoli', 'Rabindranath Tagore', 10),
(3, 'Java Programming', 'A N M Bajlur Rahman', 6),
(8, 'DSA', 'Shajalal Shohag', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booksinfo`
--
ALTER TABLE `booksinfo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booksinfo`
--
ALTER TABLE `booksinfo`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
