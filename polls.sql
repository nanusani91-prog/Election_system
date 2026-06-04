-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4305
-- Generation Time: Jan 05, 2026 at 09:12 PM
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
-- Database: `polls`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbadministrators`
--

CREATE TABLE `tbadministrators` (
  `admin_id` int(5) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbadministrators`
--

INSERT INTO `tbadministrators` (`admin_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'yopsun', 'group', 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(3, 'Gadisa', 'Shiferaw', 'gadish@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(4, '5yh', 'ede', 'nattybra2007@gmail.com', '473447ac58e1cd7e96172575f48dca3b'),
(5, 'girum', 'teke', 'nattybra2007@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(6, 'Gadiss', 'Shiferaw', 'nattybra2007@gmail.com', 'cfe8504bda37b575c70ee1a8276f3486');

-- --------------------------------------------------------

--
-- Table structure for table `tbcandidates`
--

CREATE TABLE `tbcandidates` (
  `candidate_id` int(5) NOT NULL,
  `candidate_name` varchar(45) NOT NULL,
  `constituency` varchar(45) NOT NULL,
  `party` varchar(45) NOT NULL,
  `candidate_position` varchar(45) NOT NULL,
  `candidate_cvotes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbcandidates`
--

INSERT INTO `tbcandidates` (`candidate_id`, `candidate_name`, `constituency`, `party`, `candidate_position`, `candidate_cvotes`) VALUES
(1, 'Saharla Abdulahi Bahdon', 'Addis Ababa 16', 'Prosperity Party', 'MP', 0),
(2, 'Kemal Hashi Mohamoud', 'Arabi', 'Prosperity Party', 'MP', 0),
(3, 'Dessalegn Chanie', 'Bahir Dar', 'National Movement of Amhara', 'MP', 0),
(4, 'Tagesse Chafo', 'SNNPR', 'Prosperity Party', 'Speaker', 0),
(23, 'Getahun', '', '', 'president', 2),
(24, 'Beatus', '', '', 'president', 1),
(25, 'Bekelu', '', '', 'Woman-Member', 1),
(26, 'Roar', '', '', 'president', 1),
(27, 'rg', '', '', 'president', 0),
(28, 'gelila', '', '', 'president', 0),
(30, 'Beatus', '', '', 'president', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbmembers`
--

CREATE TABLE `tbmembers` (
  `member_id` int(5) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `voter_id` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbmembers`
--

INSERT INTO `tbmembers` (`member_id`, `first_name`, `last_name`, `email`, `voter_id`, `password`) VALUES
(1, 'Abel', 'Tesfaye', 'abel.tesfaye@gmail.com', 'ET19990123456701', '7d9b087beffc9879ead55e7291d6b541'),
(2, 'Hanna', 'Bekele', 'hanna.bekele@gmail.com', 'ET19980234567802', '939d2ad38c88fda9c0bad11086e4e057'),
(3, 'Mekdes', 'Kebede', 'mekdes.kebede@gmail.com', 'ET20000145678903', 'e10adc3949ba59abbe56e057f20f883e'),
(4, 'Samuel', 'Alemu', 'samuel.alemu@gmail.com', 'ET19970356789004', '25d55ad283aa400af464c76d713c07ad'),
(5, 'Gadisa', 'Shiferaw', 'nattybra2007@gmail.com', '343', '202cb962ac59075b964b07152d234b70'),
(6, 'hh', 'hh', 'eyuelshemels65@gmail.com', '343', '310dcbbf4cce62f762a2aaa148d556bd'),
(7, 'oo', 'oo', 'oo@gmail.com', 'ET33', '03583c4ffb0e2e9a4bf09ab01c21dbc1'),
(8, 'Beatus', 'Beatus', 'b@ff', 'ET31', '550a141f12de6341fba65b0ad0433500'),
(9, 'Gadisa', 'Shiferaw', 'nattybra2007@gmail.com', 'ET33', '202cb962ac59075b964b07152d234b70'),
(10, 'Gadisa', 'Shiferaw', 'yohbog27@gmail.com', 'ET310', 'dc5e819e186f11ef3f59e6c7d6830c35'),
(11, 'Gadisa', 'Shiferaw', 'nattybra2007@gmail.com', 'ET3334', '01cfcd4f6b8770febfb40cb906715822');

-- --------------------------------------------------------

--
-- Table structure for table `tbpolls`
--

CREATE TABLE `tbpolls` (
  `id` int(11) NOT NULL,
  `voter_id` varchar(50) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `vote_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbpolls`
--

INSERT INTO `tbpolls` (`id`, `voter_id`, `candidate_id`, `vote_time`) VALUES
(1, 'ET33', 23, '2025-12-30 20:46:36'),
(2, 'ET31', 23, '2026-01-03 09:20:23'),
(3, 'ET33', 25, '2026-01-03 15:47:05'),
(4, 'ET33', 24, '2026-01-03 15:47:16'),
(5, 'ET33', 26, '2026-01-03 16:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbpositions`
--

CREATE TABLE `tbpositions` (
  `position_id` int(5) NOT NULL,
  `position_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbpositions`
--

INSERT INTO `tbpositions` (`position_id`, `position_name`) VALUES
(5, 'Organizing-Secretary'),
(6, 'Treasurer'),
(7, 'Vice-Treasurer'),
(8, 'Member'),
(9, 'Woman-Member'),
(12, 'president'),
(13, 'vice-president'),
(14, 'vice secretary'),
(16, 'president');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbadministrators`
--
ALTER TABLE `tbadministrators`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbcandidates`
--
ALTER TABLE `tbcandidates`
  ADD PRIMARY KEY (`candidate_id`);

--
-- Indexes for table `tbmembers`
--
ALTER TABLE `tbmembers`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `tbpolls`
--
ALTER TABLE `tbpolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbpositions`
--
ALTER TABLE `tbpositions`
  ADD PRIMARY KEY (`position_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbadministrators`
--
ALTER TABLE `tbadministrators`
  MODIFY `admin_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbcandidates`
--
ALTER TABLE `tbcandidates`
  MODIFY `candidate_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbmembers`
--
ALTER TABLE `tbmembers`
  MODIFY `member_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbpolls`
--
ALTER TABLE `tbpolls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbpositions`
--
ALTER TABLE `tbpositions`
  MODIFY `position_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
