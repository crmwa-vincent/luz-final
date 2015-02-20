-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2015 at 12:56 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `luz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`admin_id` int(11) NOT NULL,
  `user_type` int(11) DEFAULT NULL,
  `admin_username` varchar(20) DEFAULT NULL,
  `admin_password` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `user_type`, `admin_username`, `admin_password`) VALUES
(1, 1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `clerk`
--

CREATE TABLE IF NOT EXISTS `clerk` (
`clerk_id` int(11) NOT NULL,
  `user_type` int(11) DEFAULT NULL,
  `clerk_username` varchar(20) DEFAULT NULL,
  `clerk_password` varchar(20) DEFAULT NULL,
  `clerk_Fname` varchar(30) DEFAULT NULL,
  `clerk_Lname` varchar(30) DEFAULT NULL,
  `clerk_Email` varchar(50) DEFAULT NULL,
  `clerk_Contact` varchar(30) DEFAULT NULL,
  `cler_img` varchar(200) DEFAULT NULL,
  `clerk_Bdate` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clerk`
--

INSERT INTO `clerk` (`clerk_id`, `user_type`, `clerk_username`, `clerk_password`, `clerk_Fname`, `clerk_Lname`, `clerk_Email`, `clerk_Contact`, `cler_img`, `clerk_Bdate`) VALUES
(1, 2, 'jlo', 'jlo', 'Jan Lou', 'CabaÃ±ero', 'janloucabaero@gmail.com', '09225461314', '10801771_10204293893286405_1438520666905849498_n.jpg', '1990-08-18');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE IF NOT EXISTS `programs` (
`event_id` int(11) NOT NULL,
  `event_name` varchar(50) DEFAULT NULL,
  `event_startsched` datetime DEFAULT NULL,
  `event_endsched` datetime DEFAULT NULL,
  `event_venue` varchar(30) DEFAULT NULL,
  `event_organizer` varchar(50) DEFAULT NULL,
  `event_category` varchar(30) DEFAULT NULL,
  `event_part_cat` varchar(40) DEFAULT NULL,
  `event_desc` varchar(200) DEFAULT NULL,
  `event_budget` double(10,2) DEFAULT NULL,
  `event_status` int(1) DEFAULT NULL,
  `event_sponsors` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`event_id`, `event_name`, `event_startsched`, `event_endsched`, `event_venue`, `event_organizer`, `event_category`, `event_part_cat`, `event_desc`, `event_budget`, `event_status`, `event_sponsors`) VALUES
(1, 'Final Defense', '2015-02-21 08:00:00', '2015-02-21 17:00:00', 'TC', NULL, 'Education', 'Children', 'asd', 123123.00, 1, 'Coca Cola,San Miguel'),
(2, 'Valentines', '2015-02-14 12:00:00', '2015-02-14 11:59:00', 'Plaza', NULL, 'Health Services', 'Children', '                                                                                            sad\r\n                                              \r\n                                              ', 123.00, 1, '                                              zzz,Coca-Cola                                              '),
(3, 'Graduation', '2015-03-28 08:00:00', '2015-03-28 02:00:00', 'South campus', NULL, 'Education', 'Youth,Children', '                                              asd\r\n                                              ', 123123.00, 1, '                                              San Miguel,Coca Cola\r\n                                              '),
(4, 'Summer Class', '2015-04-14 08:00:00', '2015-04-15 05:00:00', 'Main Campus', NULL, 'Education', 'Children', '                                                                                            sdasda\r\n                                              \r\n                                              ', 12313.00, 2, '                                                                                            San Miguel,asd                                                                                          '),
(5, 'Job Fair', '2015-02-23 08:00:00', '2015-02-23 05:00:00', 'Basketball Court', NULL, 'Use of Barangay Facilities', 'Youth', '                                              asd\r\n                                              ', 10000.00, 1, '                                              LGU,NGO\r\n                                              ');

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE IF NOT EXISTS `resident` (
`res_id` int(11) NOT NULL,
  `res_fname` varchar(30) DEFAULT NULL,
  `res_mname` varchar(30) DEFAULT NULL,
  `res_lname` varchar(30) DEFAULT NULL,
  `res_gender` varchar(7) DEFAULT NULL,
  `res_email` varchar(30) DEFAULT NULL,
  `res_contact` varchar(30) DEFAULT NULL,
  `res_add_sitio` varchar(20) DEFAULT NULL,
  `res_bday` date DEFAULT NULL,
  `res_age` int(3) NOT NULL,
  `res_interest` varchar(110) DEFAULT NULL,
  `res_img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`res_id`, `res_fname`, `res_mname`, `res_lname`, `res_gender`, `res_email`, `res_contact`, `res_add_sitio`, `res_bday`, `res_age`, `res_interest`, `res_img`) VALUES
(1, 'Jan Lou', 'Flores', 'Cabanero', 'male', 'janloucabaero@gmail.com', '09225461314', 'Abellana', '1990-08-18', 0, 'Use of Barangay Facilities', 'no_photo.jpg'),
(2, 'Louella', 'Flores', 'Cabanero', 'female', 'mader_louie@yahoo.com.ph', '09223277934', 'Abellana', '1954-10-28', 0, 'Health Services', 'no_photo.jpg'),
(3, 'Andro Nicolo', 'Flores', 'Cabanero', 'male', 'baby_cake2k10@yahoo.com', '09236797841', 'Abellana', '1981-11-09', 0, 'Peace and Order', 'no_photo.jpg'),
(4, 'Noreen Ellie', 'Bertulfo', 'Cabanero', 'female', 'noreenellie@yahoo.com', '09225566337', 'Abellana', '1989-03-03', 0, 'Transportation', 'no_photo.jpg'),
(5, 'Fiona', 'Bertulfo', 'Cabanero', 'female', 'fifi@gmail.com', '09225566337', 'Abellana', '2012-09-18', 0, 'Education', 'no_photo.jpg'),
(6, 'Alejandro', 'dela Torre', 'Cabanero', 'male', 'alcaban@gmail.com', '09234147618', 'Abellana', '1955-12-12', 0, 'Solid Waste Management', 'no_photo.jpg'),
(7, 'Karen Jobee', 'Flores', 'Cabilao', 'female', 'witchbitchicequeen@yahoo.com', '09234791459', 'City Central', '1985-01-05', 0, 'Peace and Order, Health Services', 'no_photo.jpg'),
(8, 'Kristine', 'Ann', 'Avenido', 'female', 'kayeavenido@gmail.com', '09424941138', 'City Central', '1993-01-01', 0, 'Education', 'no_photo.jpg'),
(9, 'Sam', 'Nicole', 'Guerra', 'male', 'samguerra@gmail.com', '09321762728', 'City Central', '1993-02-02', 0, 'Transportation', 'no_photo.jpg'),
(10, 'Bryan', 'Oliver', 'Saavedra', 'male', 'bryan@gmail.com', '09989781963', 'Lubi', '1993-04-04', 0, 'Peace and Order', 'no_photo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `residents_programs`
--

CREATE TABLE IF NOT EXISTS `residents_programs` (
`id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `prog_id` int(11) NOT NULL,
  `checked` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `residents_programs`
--

INSERT INTO `residents_programs` (`id`, `res_id`, `prog_id`, `checked`) VALUES
(1, 8, 1, 0),
(2, 5, 1, 0),
(3, 2, 2, 1),
(4, 7, 2, 1),
(5, 8, 3, 1),
(6, 5, 3, 1),
(7, 8, 4, 1),
(8, 5, 4, 1),
(9, 1, 5, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `clerk`
--
ALTER TABLE `clerk`
 ADD PRIMARY KEY (`clerk_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
 ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
 ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `residents_programs`
--
ALTER TABLE `residents_programs`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clerk`
--
ALTER TABLE `clerk`
MODIFY `clerk_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `residents_programs`
--
ALTER TABLE `residents_programs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
