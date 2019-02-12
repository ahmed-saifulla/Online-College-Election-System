-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2018 at 12:17 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oces`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Id` bigint(20) NOT NULL,
  `dept` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Id`, `dept`) VALUES
(2, 'Mechanical'),
(4, 'hee');

-- --------------------------------------------------------

--
-- Table structure for table `nominees`
--

CREATE TABLE `nominees` (
  `Id` int(11) NOT NULL,
  `usn` varchar(30) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `post` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `dept` varchar(50) NOT NULL,
  `sem` varchar(30) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `status` enum('Pending','Accept','Reject') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nominees`
--

INSERT INTO `nominees` (`Id`, `usn`, `c_name`, `gender`, `post`, `dob`, `dept`, `sem`, `mobile`, `email_id`, `status`) VALUES
(1, '4PA15CS008', 'lolooloo', 'Male', 'Chairman', '0000-00-00', 'Mechanical', 'Seveth', 1212121212, 'hjhj@df.com', 'Accept'),
(2, '4PA15CS000', 'kuuu', 'Female', 'Secretary', '2017-02-02', 'Mechanical', 'Fourth', 4545454545, 'uy@mn.com', 'Reject'),
(3, '4PA15CS004', 'jhg', 'Male', 'Chairman', '2019-02-02', 'jhv', 'First', 1212121212, 'lk@yhgb.com', 'Accept'),
(4, '4PA15CS004', 'jhg', 'Male', 'Chairman', '2019-02-02', 'jhv', 'First', 1212121212, 'lk@yhgb.com', 'Reject'),
(5, '4PA15CS004', 'iuiu', 'Male', 'Chairman', '2016-03-02', 'CS', 'First', 4545454545, 'kjkj@gh.com', 'Pending'),
(6, '4pa15cs038', 'jyothi prakash', 'Male', 'manager', '1111-09-21', 'cs', '7', 9876543210, 'jyo@gmail.com', 'Reject');

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `Id` bigint(20) NOT NULL,
  `rule` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`Id`, `rule`) VALUES
(1, 'Voters should Complete voting in 5 minutes.'),
(2, 'Do not refresh the page while voting.'),
(3, 'Do not share your OTP with others.');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `Id` int(11) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`Id`, `time`, `date`) VALUES
(1, '43:12:06', '2018-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `Id` bigint(20) NOT NULL,
  `usn` varchar(10) NOT NULL,
  `s_name` varchar(200) NOT NULL,
  `gender` enum('Female','Male') NOT NULL,
  `dob` date NOT NULL,
  `department` varchar(200) NOT NULL,
  `semester` enum('Eighth','Seventh','Sixth','Fifth','Fourth','Third','Second','First') NOT NULL,
  `email` varchar(100) NOT NULL,
  `OTP` varchar(200) NOT NULL,
  `MobileNo` varchar(10) NOT NULL,
  `OTPStatus` int(1) NOT NULL,
  `VoteStatus` int(1) NOT NULL,
  `OTPYear` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`Id`, `usn`, `s_name`, `gender`, `dob`, `department`, `semester`, `email`, `OTP`, `MobileNo`, `OTPStatus`, `VoteStatus`, `OTPYear`) VALUES
(22, '4PA15CS004', 'aaaa', 'Female', '1995-02-02', 'Electrical', 'Seventh', 'qwert@ymail.com', '', '4545454545', 0, 0, ''),
(23, '4PA15CS005', 'bbbbbb', 'Male', '2020-01-31', 'Mechanical', 'Fourth', 'bb@gmail.com', '', '4545454545', 0, 0, ''),
(24, '4PA15CS010', 'yyoo', 'Male', '2017-02-02', 'EC', 'Second', 'wew@gmail.com', '', '8787787878', 0, 0, ''),
(25, 'KSD15CS102', 'Sulaiman K C', 'Male', '1997-01-04', 'CS', 'Seventh', 'sulaimankc9@gmail.com', '', '0907283021', 0, 0, ''),
(26, '4PA15CS008', 'Ahmed Saifulla N S', 'Male', '1997-08-08', 'CS', 'Seventh', 'ahsaifulla@gmail.com', '', '8129318510', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `usertype` enum('Admin','User') NOT NULL DEFAULT 'User',
  `email` varchar(30) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `status`, `usertype`, `email`, `gender`, `password`) VALUES
(1, 'ahmed', 'Active', 'Admin', 'ahmed@gmail.com', 'Male', '123456'),
(2, 'azeem', 'Active', 'User', 'azeem@gmail.com', 'Male', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `nominees`
--
ALTER TABLE `nominees`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nominees`
--
ALTER TABLE `nominees`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
