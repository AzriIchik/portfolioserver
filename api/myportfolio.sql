-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2023 at 03:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myportfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `education_id` int(11) NOT NULL,
  `education_place` varchar(255) DEFAULT NULL,
  `education_position` varchar(255) DEFAULT NULL,
  `education_desc` varchar(500) DEFAULT NULL,
  `education_xtradesc` varchar(500) DEFAULT NULL,
  `education_certurl` varchar(500) DEFAULT NULL,
  `education_startdate` date DEFAULT NULL,
  `education_enddate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`education_id`, `education_place`, `education_position`, `education_desc`, `education_xtradesc`, `education_certurl`, `education_startdate`, `education_enddate`) VALUES
(1, 'Some Place', 'Student', 'asdasss', 'asdasd', 'asdasdas', '2023-09-13', '2023-09-21'),
(5, 'sdfsdfsd', 'sdfsdf', 'sdfsdfsd', 'fsdfsdf', 'sdfsd', '2023-09-15', '2023-09-26');

-- --------------------------------------------------------

--
-- Table structure for table `employment`
--

CREATE TABLE `employment` (
  `employment_id` int(11) NOT NULL,
  `employment_place` varchar(255) DEFAULT NULL,
  `employment_position` varchar(255) DEFAULT NULL,
  `employment_desc` varchar(500) DEFAULT NULL,
  `employment_xtradesc` varchar(500) DEFAULT NULL,
  `employment_certurl` varchar(500) DEFAULT NULL,
  `employment_startdate` date DEFAULT NULL,
  `employment_enddate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employment`
--

INSERT INTO `employment` (`employment_id`, `employment_place`, `employment_position`, `employment_desc`, `employment_xtradesc`, `employment_certurl`, `employment_startdate`, `employment_enddate`) VALUES
(4, 'KPTM Bangi', 'asdasd', 'asdasdas', 'dasdasda', 'sdasdsa', '2023-09-01', '2023-09-30');

-- --------------------------------------------------------

--
-- Table structure for table `myprofile`
--

CREATE TABLE `myprofile` (
  `myprofile_aboutme` varchar(500) DEFAULT NULL,
  `myprofile_aboutresume` varchar(500) DEFAULT NULL,
  `myprofile_address` varchar(255) DEFAULT NULL,
  `myprofile_age` smallint(6) DEFAULT NULL,
  `myprofile_email` varchar(50) DEFAULT NULL,
  `myprofile_imgurl` varchar(255) DEFAULT NULL,
  `myprofile_name` varchar(50) NOT NULL,
  `myprofile_phoneno` varchar(50) DEFAULT NULL,
  `myprofile_title` varchar(50) DEFAULT NULL,
  `myprofile_resumeurl` varchar(255) DEFAULT NULL,
  `myprofile_password` varchar(255) DEFAULT NULL,
  `myprofile_authkey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `myprofile`
--

INSERT INTO `myprofile` (`myprofile_aboutme`, `myprofile_aboutresume`, `myprofile_address`, `myprofile_age`, `myprofile_email`, `myprofile_imgurl`, `myprofile_name`, `myprofile_phoneno`, `myprofile_title`, `myprofile_resumeurl`, `myprofile_password`, `myprofile_authkey`) VALUES
('I am a Web Dev Enthusiast with interest in learning Web Development, I an able to develop web application from ground up, able to design web from concept, navigation, layout and programming. When it come to web tech I am a fast learner, and team player who is proficient in an array of web tech', 'I\'m a graduate of Software Engineering. With roughly 1 years of experience as a web designer, i\'ve worked with various web technology such as ReactJS, Laravel, PHP, Javascript, HTML/CSS5, NodeJS and MySQL. As a competent web programmer, I\'m also proficient in using Content management system like Joomla and Wordpress.', 'D-2, Tingkat 2, Pangsapuri Ria, Jalan Bukit Mewah 31, Taman Bukit Mewah, 43000 Kajang, Selangor', 27, 'azriperisiben96@gmail.com', NULL, 'MOHAMMAD AZRI BIN PERISIBENSS', '014-6511665', 'Web Programming Enthusiasist', 'https://drive.google.com/file/d/1H3Mo8y0G81Z4aJ4FXDyrog_8GqJU5KAO/view?usp=sharing', '1234', 'b731fa8af671ff9558992c0afc1511fa');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `project_techstack` varchar(1000) DEFAULT NULL,
  `project_imgurl1` varchar(500) DEFAULT NULL,
  `project_imgurl2` varchar(500) DEFAULT NULL,
  `project_imgurl3` varchar(500) DEFAULT NULL,
  `project_desc` varchar(500) DEFAULT NULL,
  `project_link` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_techstack`, `project_imgurl1`, `project_imgurl2`, `project_imgurl3`, `project_desc`, `project_link`) VALUES
(8, 'MAIPk', '[\"New Tech\",\"Javascript\"]', '/portfolioserver/index.php/projectimg/upload/image/485498wallpaperflare.com_wallpaper.jpg', '/portfolioserver/upload/image/840402wallpaperflare.com_wallpaper.jpg', '', 'Some extra Description', 'https://ahkohd.github.io/express-php/Extra');

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `skill_id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `skill_proficiency` smallint(6) DEFAULT NULL,
  `skill_category` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`skill_id`, `skill_name`, `skill_proficiency`, `skill_category`) VALUES
(7, 'HTML/CSS', 5, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`education_id`);

--
-- Indexes for table `employment`
--
ALTER TABLE `employment`
  ADD PRIMARY KEY (`employment_id`);

--
-- Indexes for table `myprofile`
--
ALTER TABLE `myprofile`
  ADD PRIMARY KEY (`myprofile_name`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employment`
--
ALTER TABLE `employment`
  MODIFY `employment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
