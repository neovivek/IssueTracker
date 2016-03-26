-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2016 at 09:37 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `notepad`
--

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE IF NOT EXISTS `issues` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `tags` varchar(150) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `severity` int(5) NOT NULL,
  `is_resolved` int(2) NOT NULL DEFAULT '0',
  `creator` bigint(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `project_id`, `title`, `tags`, `description`, `severity`, `is_resolved`, `creator`, `created_on`) VALUES
(1, 1000000000, 'Refund is not returning auth code', 'pos-refund-prizm', 'On executing a refund transaction, Prizm is not responding with authorization code, due to which we can not fire a void transaction for a successful reversal.', 4, 0, 1, '2016-03-14 12:54:30'),
(2, 1000000000, 'Issue in Stan Update', 'pos-posSimulator', 'Stan Update is not working as of now.', 2, 0, 2, '2016-03-15 05:59:45'),
(3, 1000000000, 'System reversal not firing', 'pos-systemReversal', 'System reversal for sale transaction is not firing when we provide wrong track detail', 8, 0, 1, '2016-03-19 08:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(50) NOT NULL,
  `active` int(2) DEFAULT NULL,
  `created_by` bigint(11) DEFAULT '1',
  `project_description` varchar(512) DEFAULT NULL,
  `project_manager` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000000002 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `project`, `active`, `created_by`, `project_description`, `project_manager`) VALUES
(1000000000, 'pos', 1, NULL, NULL, NULL),
(1000000001, 'pos simulator', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(50) NOT NULL,
  `project_id` bigint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `designation` varchar(20) DEFAULT 'user',
  `createdon` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `created_on`, `designation`, `createdon`) VALUES
(1, 'Admin', '', '2016-03-14 13:21:54', 'user', '2016-03-24 15:19:29'),
(2, 'Dummy', '', '2016-03-21 06:57:04', 'user', '2016-03-24 15:19:29');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
