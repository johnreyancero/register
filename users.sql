-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 19, 2025 at 10:42 AM
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
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MidName` varchar(255) NOT NULL,
  `Course` varchar(255) NOT NULL,
  `Year` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `idno` varchar(20) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `LastName`, `FirstName`, `MidName`, `Course`, `Year`, `UserName`, `Password`, `idno`, `image`) VALUES
(1, 'Ancero', 'John Reyae', 'Tac-an', 'Bachelor of Science in Technology', 0, 'asd', '$2y$10$ZGWx9xrT8XP.uOC1FDBhU.CBvHuHBsRmE4nklULQf6fHqScA09wNS', '20949186', 'dance dance dance.jpeg'),
(2, 'ANCERO', 'John Rey', 'Tac-an', 'Bachelor of Science in Technology', 3, 'asdek', '$2y$10$PYcoKMsIJM/nh7Wg2RKbnOYVRWMsme4ds/qbnez04p6yz6SC3Ww76', '20949186', ''),
(3, 'asd', 'asd', 'as', 'Bachelor of Science in Computer Science', 2, 'asddd', '$2y$10$L/vbSGSSoK9xiVMloy2ZFeWbLl.3Z9FSfQ32azoKRR0MmRLA5xrTa', '20949186', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
