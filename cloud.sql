-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 16, 2017 at 05:54 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

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
-- Table structure for table `cluster`
--

CREATE TABLE `cluster` (
  `hadoop_name` varchar(25) NOT NULL DEFAULT '',
  `VM_name` varchar(25) NOT NULL DEFAULT '',
  `ip` varchar(17) NOT NULL,
  `role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `username` varchar(15) NOT NULL,
  `token` varchar(32) NOT NULL,
  `timestamp` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Storing user forgot password details';

--
-- Dumping data for table `forgot_password`
--

INSERT INTO `forgot_password` (`username`, `token`, `timestamp`) VALUES
('pankaj', 'fe35a5ed9d869ecc7ae49cdccde70bd2', 1509517534),
('pankaj', 'be63cf59b7940ad66d7b17cd8f3dca49', 1509764762),
('pankaj', '2e49ab10b0dc4bb14bb3fda548ae8fbf', 1509775284),
('rishabh', '4e07840bbc70749c4591695042e87ae7', 1510500870),
('rishabh', '3ad5eb02b188c5a1593d1f5f6c4ccd08', 1510500878);

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

--
-- Dumping data for table `hadoop`
--

INSERT INTO `hadoop` (`username`, `hadoop_name`, `number_slave`, `cpu`, `ram`, `storage`, `doe`, `status`) VALUES
('admin', 'test', 3, 1, '512', '8', '2017-11-27', 'pending'),
('admin', 'trying', 2, 2, '256', '8', '2017-11-20', 'created');

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

--
-- Dumping data for table `hypervisor`
--

INSERT INTO `hypervisor` (`name`, `ip`, `userid`, `password`) VALUES
('xenserver-trial', '172.31.131.229', 'root', 'root@123');

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
('172.31.131.224', 'allocated'),
('172.31.131.225', ''),
('172.31.131.226', ''),
('172.31.131.227', ' ');

-- --------------------------------------------------------

--
-- Table structure for table `name_description`
--

CREATE TABLE `name_description` (
  `name` varchar(15) NOT NULL,
  `description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `name_description`
--

INSERT INTO `name_description` (`name`, `description`) VALUES
('hello', 'virt'),
('qwerty', 'testrun'),
('test', 'newRecord'),
('sharma', 'testing please'),
('newTrial', 'xoner'),
('aks-vmbox', 'linux vm-box'),
('test', 'hello world'),
('test1', 'testing');

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
('rishabh', 'ff2f24f8b6d253bb5a8bc55728ca7372', 'RISHABH AGARWAL', 'sahilcool2605@gmail.com', 'CSED', 'a', '9648162058', 'Btech');

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

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `username`, `type`, `message`, `timestamp`, `status`) VALUES
(2, 'pankaj', 'xcuse', '', '', 'r'),
(4, 'aksingh', 'INFO', 'Testing admin generic notification !!!', '2017-11-06 17:44:03', 'o'),
(5, 'aksingh', 'INFO', 'testing twice !!', '2017-11-06 17:45:14', 'o'),
(6, 'aksingh', 'INFO', 'hello !', '2017-11-07 07:40:07', 'o'),
(7, 'aksingh', 'INFO', 'purpose testing', '2017-11-07 07:40:58', 'o'),
(8, 'admin', 'VM', 'aksingh requested Virtual Machine testier', '2017-11-07 13:30:07', 'o'),
(9, 'aksingh', 'VM', 'Your Request for Virtual Machine \'testier\' has been Rejected', '2017-11-07 13:35:45', 'o'),
(10, 'aksingh', 'VM', 'Your Request for Virtual Machine \'testier\' has been Rejected', '2017-11-07 13:36:45', 'o'),
(11, 'aksingh', 'VM', 'Your Request for Virtual Machine \'testier\' has been Rejected', '2017-11-07 13:37:16', 'o'),
(12, 'aksingh', 'VM', 'Your Request for Virtual Machine \'testier\' has been Rejected', '2017-11-07 13:38:15', 'o'),
(13, 'aksingh', 'VM', 'Your Request for Virtual Machine \'testier\' has been Rejected', '2017-11-07 13:38:38', 'o'),
(14, 'user', 'INFO', 'Tesing user notification by mail and general', '2017-11-07 13:58:18', 'o'),
(15, 'admin', 'SIGNUP', 'new user Requests pending : raj', '2017-11-12 10:43:32', 'o'),
(16, 'admin', 'VM', 'raj requested Virtual Machine firstVM', '2017-11-12 10:56:05', 'o'),
(17, 'raj', 'VM', 'Your Request for Virtual Machine \'firstVM\' has been Rejected', '2017-11-12 11:04:42', 'n'),
(18, 'raj', 'INFO', 'hello dear !', '2017-11-12 11:05:40', 'n'),
(19, 'raj', 'INFO', 'Hi raj !!', '2017-11-12 12:56:11', 'n'),
(20, 'raj', 'INFO', 'localhost', '2017-11-12 13:01:53', 'n'),
(21, 'pankaj', 'INFO', 'Hello Pankaj ! Kya chal raha hai ? The message is sent from MNNIT Private Cloud website', '2017-11-12 13:03:48', 'n'),
(22, 'admin', 'SIGNUP', 'new user Requests pending : rishabh', '2017-11-12 21:04:02', 'o'),
(23, 'admin', 'HADOOP', 'admin requested hadoop cluster rishabh', '2017-11-12 21:36:00', 'o'),
(24, 'raj', 'INFO', 'hi!', '2017-11-13 09:12:39', 'n'),
(25, 'admin', 'HADOOP', 'admin requested hadoop cluster tryingL', '2017-11-13 11:23:49', 'o'),
(26, 'admin', 'HADOOP', 'Your Request for hadoop cluster \'rishabh\' has been Rejected', '2017-11-13 11:36:12', 'o'),
(27, 'admin', 'HADOOP', 'Your Request for hadoop cluster \'tryingL\' has been Rejected', '2017-11-13 11:36:19', 'o'),
(28, 'admin', 'HADOOP', 'admin requested hadoop cluster tryingL', '2017-11-13 12:02:26', 'o'),
(29, 'admin', 'HADOOP', 'Your Request for hadoop cluster \'tryingL\' has been Rejected', '2017-11-13 12:04:22', 'o'),
(30, 'aksingh', 'VM', 'Your Request for Virtual Machine \'aks-vmbox\' has been Rejected', '2017-11-13 12:05:50', 'n'),
(31, 'admin', 'HADOOP', 'admin requested hadoop cluster just', '2017-11-13 12:18:30', 'o'),
(32, 'admin', 'HADOOP', 'admin requested hadoop cluster test', '2017-11-13 12:27:16', 'o'),
(33, 'admin', 'HADOOP', 'Your Request for hadoop cluster \'just\' has been Rejected', '2017-11-13 12:27:23', 'o'),
(34, 'admin', 'VM', 'admin requested Virtual Machine test1', '2017-11-13 13:41:08', 'o'),
(35, 'raj', 'INFO', 'hello !', '2017-11-14 07:16:31', 'n'),
(36, 'admin', 'STORGAE', 'admin requested storage extension by131072', '2017-11-14 18:42:41', 'o'),
(37, 'raj', 'INFO', 'hi Raj !!\r\n', '2017-11-15 09:48:55', 'n');

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

--
-- Dumping data for table `storage_request`
--

INSERT INTO `storage_request` (`username`, `alloted_space`, `new_demand`, `description`, `status`) VALUES
('admin', 307200, 131072, '', 'pending');

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

--
-- Dumping data for table `storage_servers`
--

INSERT INTO `storage_servers` (`server_name`, `ip`, `login_name`, `login_password`, `total_space`, `used_space`) VALUES
('storage-server-1', '172.31.131.228', 'root', 'user@mnnit', 52428800, 830464);

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`name`) VALUES
('centos7'),
('masterTemp');

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
('admin', '21232f297a57a5a743894a0e4a801fc3', 'A'),
('aksingh', '59bd9181903968548e1c61193f367431', 'U'),
('pankaj', '95deb5011a8fe1ccf6552bb5bcda2ff0', 'U'),
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

--
-- Dumping data for table `user_storage`
--

INSERT INTO `user_storage` (`username`, `storage_server`, `alloted_space`, `used_space`, `login_password`) VALUES
('admin', 'storage-server-1', 307200, 14244, 'I0r7bcih'),
('pankaj', 'storage-server-1', 11264, 20, 'vpUVGcqm'),
('aksingh', 'storage-server-1', 512000, 7204, 'X23f9dwE');

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
  `iscluster` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `VMdetails`
--

INSERT INTO `VMdetails` (`username`, `ip`, `hypervisor_name`, `VM_name`, `os`, `cpu`, `ram`, `storage`, `doe`, `iscluster`) VALUES
('admin', '172.31.131.224', 'xenserver-trial', 'newTrial', 'masterTemp', 1, '256', '10', '2017-11-27', NULL),
('admin', '172.31.131.226', 'xenserver-trial', 'tryingMaster', 'masterTemp', 1, '256', '10', '2017-11-27', 'trying'),
('admin', '172.31.131.227', 'xenserver-trial', 'tryingSlave1', 'masterTemp', 1, '256', '10', '2017-11-27', 'trying');

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
-- Dumping data for table `VMrequest`
--

INSERT INTO `VMrequest` (`username`, `VM_name`, `os`, `cpu`, `ram`, `storage`, `doe`, `status`) VALUES
('aksingh', 'aks-vmbox', 'masterTemp', 1, '256', '10', '2017-11-07', 'rejected'),
('admin', 'test1', 'centos7', 1, '256', '8', '2017-11-15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cluster`
--
ALTER TABLE `cluster`
  ADD PRIMARY KEY (`hadoop_name`,`VM_name`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cluster`
--
ALTER TABLE `cluster`
  ADD CONSTRAINT `cluster_ibfk_1` FOREIGN KEY (`hadoop_name`) REFERENCES `hadoop` (`hadoop_name`);

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
