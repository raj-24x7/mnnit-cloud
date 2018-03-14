-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 14, 2018 at 11:26 AM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.25-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `username` varchar(15) NOT NULL,
  `token` varchar(32) NOT NULL,
  `timestamp` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Storing user forgot password details';

-- --------------------------------------------------------

--
-- Table structure for table `hadoop`
--

CREATE TABLE `hadoop` (
  `username` varchar(15) NOT NULL,
  `hadoop_name` varchar(25) NOT NULL,
  `number_slave` int(2) NOT NULL,
  `cpu` int(3) NOT NULL,
  `ram` varchar(10) NOT NULL,
  `storage` varchar(10) NOT NULL,
  `doe` date NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hypervisor`
--

CREATE TABLE `hypervisor` (
  `name` varchar(25) NOT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `userid` varchar(15) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip_pool`
--

CREATE TABLE `ip_pool` (
  `ip` varchar(16) NOT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_pool`
--

INSERT INTO `ip_pool` (`ip`, `status`) VALUES
('172.31.131.224', ' '),
('172.31.131.225', 'allocated'),
('172.31.131.226', 'allocated'),
('172.31.131.227', 'allocated');

-- --------------------------------------------------------

--
-- Table structure for table `name_description`
--

CREATE TABLE `name_description` (
  `name` varchar(15) NOT NULL,
  `description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `new_user`
--

CREATE TABLE `new_user` (
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `department` varchar(10) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `programme` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `new_user`
--

INSERT INTO `new_user` (`username`, `password`, `name`, `email`, `department`, `status`, `contact`, `programme`) VALUES
('pankaj', '95deb5011a8fe1ccf6552bb5bcda2ff0', 'Pankaj Kumar Gupta', 'gpankaj61@gmail.com', 'CSED', 'a', '789456123', 'Btech'),
('aksingh', '59bd9181903968548e1c61193f367431', 'Anil Kumar singh', 'ak@mnnit.ac.in', 'CSED', 'a', '9452613200', 'Faculty'),
('admin', NULL, 'Administrator', 'cloud.mnnit@gmail.com', 'CSED', NULL, '9559386262', 'BTec'),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 'gpankaj61@gmail.com', 'CSED', 'a', '', 'BTec'),
('raj', '03c017f682085142f3b60f56673e22dc', 'Raj Kumar', 'rajkumar_241096@yahoo.in', 'CSED', 'a', '9559386262', 'Btech'),
('rishabh', 'ff2f24f8b6d253bb5a8bc55728ca7372', 'RISHABH AGARWAL', 'sahilcool2605@gmail.com', 'CSED', 'a', '9648162058', 'Btech'),
('PemaRam', 'f4a818b2eab35375c96a7930f3a5001b', 'PemaRam', 'seervipema@gmail.com', 'CSED', 'a', '9565380292', 'Btech'),
('20144112', 'b5c6fc41320314e4a7b80f7575c1c663', 'manas bvss', 'manassarma1937@gmail.com', 'CSED', 'a', '8106747795', 'Btech'),
('20148097', 'e787d391a93e25a8c50fe04074548270', 'Saqib Javed', 'saqibjavedq09@gmail.com', 'CSED', 'a', '09648160992', 'Btech');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  `message` varchar(500) NOT NULL,
  `timestamp` varchar(30) NOT NULL,
  `status` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `storage_request`
--

CREATE TABLE `storage_request` (
  `username` varchar(15) DEFAULT NULL,
  `alloted_space` int(11) DEFAULT NULL,
  `new_demand` int(11) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `storage_servers`
--

CREATE TABLE `storage_servers` (
  `server_name` varchar(16) NOT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `login_name` varchar(16) DEFAULT NULL,
  `login_password` varchar(25) DEFAULT NULL,
  `total_space` int(20) DEFAULT NULL,
  `used_space` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(15) NOT NULL,
  `password` varchar(32) NOT NULL,
  `privilege` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `privilege`) VALUES
('20144112', 'b5c6fc41320314e4a7b80f7575c1c663', 'U'),
('20148097', 'e787d391a93e25a8c50fe04074548270', 'U'),
('admin', '21232f297a57a5a743894a0e4a801fc3', 'A'),
('aksingh', '59bd9181903968548e1c61193f367431', 'U'),
('pankaj', '95deb5011a8fe1ccf6552bb5bcda2ff0', 'U'),
('PemaRam', 'f4a818b2eab35375c96a7930f3a5001b', 'U'),
('raj', '03c017f682085142f3b60f56673e22dc', 'U'),
('rishabh', 'ff2f24f8b6d253bb5a8bc55728ca7372', 'U'),
('user', 'ee11cbb19052e40b07aac0ca060c23ee', 'U');

-- --------------------------------------------------------

--
-- Table structure for table `user_storage`
--

CREATE TABLE `user_storage` (
  `username` varchar(15) DEFAULT NULL,
  `storage_server` varchar(16) DEFAULT NULL,
  `alloted_space` int(11) DEFAULT NULL,
  `used_space` int(11) DEFAULT NULL,
  `login_password` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `VMdetails`
--

CREATE TABLE `VMdetails` (
  `username` varchar(15) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `hypervisor_name` varchar(25) DEFAULT NULL,
  `VM_name` varchar(15) NOT NULL,
  `os` varchar(15) DEFAULT NULL,
  `cpu` int(3) DEFAULT NULL,
  `ram` varchar(10) DEFAULT NULL,
  `storage` varchar(10) DEFAULT NULL,
  `doe` date DEFAULT NULL,
  `iscluster` varchar(10) DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `VMrequest`
--

CREATE TABLE `VMrequest` (
  `username` varchar(15) DEFAULT NULL,
  `VM_name` varchar(15) NOT NULL,
  `os` varchar(15) DEFAULT NULL,
  `cpu` int(3) DEFAULT NULL,
  `ram` varchar(10) DEFAULT NULL,
  `storage` varchar(10) DEFAULT NULL,
  `doe` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hadoop`
--
ALTER TABLE `hadoop`
  ADD PRIMARY KEY (`hadoop_name`);

--
-- Indexes for table `hypervisor`
--
ALTER TABLE `hypervisor`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `ip_pool`
--
ALTER TABLE `ip_pool`
  ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage_servers`
--
ALTER TABLE `storage_servers`
  ADD PRIMARY KEY (`server_name`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `VMdetails`
--
ALTER TABLE `VMdetails`
  ADD PRIMARY KEY (`VM_name`),
  ADD KEY `username` (`username`),
  ADD KEY `ip` (`ip`),
  ADD KEY `hypervisor_name` (`hypervisor_name`),
  ADD KEY `os` (`os`);

--
-- Indexes for table `VMrequest`
--
ALTER TABLE `VMrequest`
  ADD PRIMARY KEY (`VM_name`),
  ADD KEY `username` (`username`),
  ADD KEY `os` (`os`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `VMdetails`
--
ALTER TABLE `VMdetails`
  ADD CONSTRAINT `VMdetails_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `VMdetails_ibfk_2` FOREIGN KEY (`ip`) REFERENCES `ip_pool` (`ip`),
  ADD CONSTRAINT `VMdetails_ibfk_3` FOREIGN KEY (`hypervisor_name`) REFERENCES `hypervisor` (`name`),
  ADD CONSTRAINT `VMdetails_ibfk_4` FOREIGN KEY (`os`) REFERENCES `template` (`name`);

--
-- Constraints for table `VMrequest`
--
ALTER TABLE `VMrequest`
  ADD CONSTRAINT `VMrequest_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `VMrequest_ibfk_2` FOREIGN KEY (`os`) REFERENCES `template` (`name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
