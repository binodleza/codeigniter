-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2020 at 05:56 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codeigniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admins`
--

CREATE TABLE `tbl_admins` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `sort_order` varchar(200) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admins`
--

INSERT INTO `tbl_admins` (`admin_id`, `name`, `email`, `sort_order`, `phone`, `image`, `create_date`, `update_date`, `is_active`, `is_deleted`, `password`) VALUES
(1, 'Stebin', 'admin@gmail.com', '1', '98908976', NULL, '2019-04-02 08:13:13', '2020-01-20 12:36:52', 1, 0, '$2y$10$.zuZ8tAbePwVRqaZpYqH3.i/p4vRyoPsCH9yyIsy9lj6z0qs0N8GG'),
(2, 'Hari Dash Gupta', 'dfbdsf@gmail.com', '', '6456456', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, '$2y$10$.zuZ8tAbePwVRqaZpYqH3.i/p4vRyoPsCH9yyIsy9lj6z0qs0N8GG'),
(3, 'Sumitra', 'sumitra@gmail.com', '', '56989078', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '$2y$10$.zuZ8tAbePwVRqaZpYqH3.i/p4vRyoPsCH9yyIsy9lj6z0qs0N8GG'),
(4, 'Apartment', 'Packejat@gmail.com', '', '87687687', NULL, '2020-01-20 06:25:23', '0000-00-00 00:00:00', 1, 0, ''),
(5, 'GanuThagun', 'gannuthegun2011gmail.com', '', '21212323', NULL, '2020-01-20 06:31:35', '0000-00-00 00:00:00', 1, 0, '$2y$10$MM6VhbaT5J827w0O00IO6uLca7o89LFSDcVOyAmoDpwn0Rr/GTOjq'),
(6, 'Apartment', 'Packe22jat@gmail.com', '', '111111', '1579498721-ADM0054-IndianEconomy.jpeg', '2020-01-20 06:38:41', '2020-01-20 07:32:49', 1, 0, '$2y$10$sA7ywFuhVSVAKfcygSla9uvXSD15sqlzv7EojqJ/f4yKsWCCIY/6.'),
(7, 'Apartment', 'pankajsahu2011@gmail.com', '', '111111', '1579501221-ruskin-bond.jpg', '0000-00-00 00:00:00', '2020-01-20 09:03:08', 0, 0, '$2y$10$mnKu1wPOD8slOdBWb2QTne.V9iKn4b9s5ZAzIugL3to8cCToAyA.u');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_assignment`
--

CREATE TABLE `tbl_auth_assignment` (
  `auth_assignment_id` int(11) NOT NULL,
  `auth_item_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL COMMENT 'trainer_id,listing_id, admin_id',
  `type` enum('A','T','D','G','SA') DEFAULT NULL COMMENT 'A:Admin,T:Trainer,D:Diet Center,G:Gym, SA: Sub Admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tbl_law_firm_admins_law_firm_admin_id';

--
-- Dumping data for table `tbl_auth_assignment`
--

INSERT INTO `tbl_auth_assignment` (`auth_assignment_id`, `auth_item_id`, `admin_id`, `type`) VALUES
(11, 6, 7, 'A'),
(12, 8, 7, 'A'),
(13, 5, 7, 'A'),
(14, 7, 7, 'A'),
(15, 2, 7, 'A'),
(16, 1, 7, 'A'),
(23, 5, 1, 'A'),
(24, 2, 1, 'A'),
(25, 4, 1, 'A'),
(26, 1, 1, 'A'),
(27, 3, 1, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_item`
--

CREATE TABLE `tbl_auth_item` (
  `auth_item_id` int(11) NOT NULL,
  `auth_module_id` int(11) NOT NULL,
  `auth_item_url` varchar(200) NOT NULL,
  `auth_item_name` varchar(100) NOT NULL,
  `auth_item_description` varchar(100) DEFAULT NULL,
  `rule_name` enum('A','D','G','T') NOT NULL COMMENT 'A=Admin D=Diet G=Gym T=Trainer',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_auth_item`
--

INSERT INTO `tbl_auth_item` (`auth_item_id`, `auth_module_id`, `auth_item_url`, `auth_item_name`, `auth_item_description`, `rule_name`, `is_active`) VALUES
(1, 1, '/index', 'Manage Users', NULL, 'A', 1),
(2, 1, '/create', 'Create', NULL, 'A', 1),
(3, 1, '/update', 'Update', NULL, 'A', 1),
(4, 1, '/delete', 'Delete', NULL, 'A', 1),
(5, 2, '/index', 'Manage Admin', NULL, 'A', 1),
(6, 2, '/create', 'Create', NULL, 'A', 1),
(7, 2, '/update', 'Update', NULL, 'A', 1),
(8, 2, '/delete', 'Delete', NULL, 'A', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auth_module`
--

CREATE TABLE `tbl_auth_module` (
  `auth_module_id` int(11) NOT NULL,
  `auth_module_name` varchar(100) NOT NULL,
  `auth_module_url` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_auth_module`
--

INSERT INTO `tbl_auth_module` (`auth_module_id`, `auth_module_name`, `auth_module_url`, `is_active`) VALUES
(1, 'Users', '/users', 1),
(2, 'Admins', '/admins', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `device_token` varchar(200) DEFAULT NULL,
  `device_type` varchar(5) DEFAULT NULL,
  `device_model` varchar(50) DEFAULT NULL,
  `app_version` varchar(10) DEFAULT NULL,
  `os_version` varchar(10) DEFAULT NULL,
  `registered_date` datetime NOT NULL,
  `is_mobile_verified` tinyint(1) NOT NULL DEFAULT '0',
  `otp_code` varchar(10) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `enable_push` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` int(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `phone`, `image`, `device_token`, `device_type`, `device_model`, `app_version`, `os_version`, `registered_date`, `is_mobile_verified`, `otp_code`, `update_date`, `enable_push`, `is_active`, `is_deleted`) VALUES
(1, 'Harijit', 'Singh', 'binod.leza1@gmail.com', '$2y$13$5Y4Sq0o22nS.dmQ5MzZLyOxNN1e.PZl88FnIYONoNpfhg/zOAwiPK', '98980989', '15556736125cb9b20c687f36.19969347.png', '', 'I', '', '', '', '2019-04-18 11:48:33', 0, NULL, '2019-04-19 09:53:56', 0, 1, 0),
(2, 'Manoj', 'Yadav', 'manoj.leza@gmail.com', '$2y$13$vMpb1PveKEleziWkCC2kPux4IyCdviL9E8DVZjBk5PIGONFArXijK', '98980911', '1555580913.png', 'devicetoken001', 'A', 'devicemodel-samsung-k3', 'v-1.0', 'v-1.0', '2019-04-18 11:48:33', 0, NULL, '2019-04-19 09:53:56', 1, 1, 0),
(3, 'Harsh', 'Singh1', 'harsh.leza@gmail.com', '$2y$13$vMpb1PveKEleziWkCC2kPux4IyCdviL9E8DVZjBk5PIGONFArXijK', '878769090', '1555580913.png', 'devicetoken001', 'A', 'devicemodel-samsung-k3', 'v-1.0', 'v-1.0', '2019-04-18 11:48:33', 0, NULL, '2019-07-11 09:50:56', 1, 0, 0),
(4, 'Binod ji', 'Binod ji', 'binod.leza@gmail.com', '$2y$13$OUbJCi5FSlnmHrZQy0cQN.zCDu7SSJEfjmBWX1AAnmWV10DXMak5O', '90048090', NULL, 'devicetoken001', 'A', 'devicemodel-samsung-k3', 'v-1.0', '', '2019-07-11 10:00:06', 0, NULL, NULL, 1, 0, 0),
(5, 'Ganesh', 'Acharya', 'wvdsvdsvefef@gmail.com', '$2y$13$M5j7Eewprs/QPyNWSIR.FOK.aywRHN88N/EB7ZFMaVLXf7W3nXTNa', '900480900', NULL, 'devicetoken001', 'A', 'devicemodel-samsung-k3', 'v-1.0', '', '2019-07-11 11:03:20', 0, NULL, NULL, 1, 1, 0),
(6, 'Harsh', 'Ashtana', '56vefef@gmail.com', '$2y$13$M5j7Eewprs/QPyNWSIR.FOK.aywRHN88N/EB7ZFMaVLXf7W3nXTNa', '900480900', NULL, 'devicetoken001', 'A', 'devicemodel-samsung-k3', 'v-1.0', '', '2019-07-11 11:03:20', 0, NULL, NULL, 1, 1, 0),
(7, 'Sunil', 'Shetti', 'sunil_56vefef@gmail.com', '$2y$13$M5j7Eewprs/QPyNWSIR.FOK.aywRHN88N/EB7ZFMaVLXf7W3nXTNa', '900480900', NULL, 'devicetoken001', 'A', 'devicemodel-samsung-k3', 'v-1.0', '', '2019-07-11 11:03:20', 0, NULL, NULL, 1, 1, 0),
(8, 'Khushi', 'Khan', 'khushi_56vefef@gmail.com', '$2y$13$M5j7Eewprs/QPyNWSIR.FOK.aywRHN88N/EB7ZFMaVLXf7W3nXTNa', '900480900', NULL, 'devicetoken001', 'A', 'devicemodel-samsung-k3', 'v-1.0', '', '2019-07-11 11:03:20', 0, NULL, NULL, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `name`, `phone`) VALUES
(1, 'Sunil', 9879879),
(2, 'Champak', 907767),
(3, 'Hanuman', 8907878);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_auth_assignment`
--
ALTER TABLE `tbl_auth_assignment`
  ADD PRIMARY KEY (`auth_assignment_id`),
  ADD KEY `fk_tbl_auth_assignment_tbl_auth_item1_idx` (`auth_item_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `tbl_auth_item`
--
ALTER TABLE `tbl_auth_item`
  ADD PRIMARY KEY (`auth_item_id`),
  ADD KEY `fk_tbl_auth_item_tbl_auth_module1_idx` (`auth_module_id`);

--
-- Indexes for table `tbl_auth_module`
--
ALTER TABLE `tbl_auth_module`
  ADD PRIMARY KEY (`auth_module_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_auth_assignment`
--
ALTER TABLE `tbl_auth_assignment`
  MODIFY `auth_assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_auth_item`
--
ALTER TABLE `tbl_auth_item`
  MODIFY `auth_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_auth_module`
--
ALTER TABLE `tbl_auth_module`
  MODIFY `auth_module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
