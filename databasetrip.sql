-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2019 at 08:00 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `databasetrip`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_details`
--

CREATE TABLE `group_details` (
  `group_id` varchar(30) NOT NULL,
  `group_name` varchar(30) NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_replies`
--

CREATE TABLE `query_replies` (
  `query_id` varchar(20) NOT NULL,
  `replier_email` varchar(30) NOT NULL,
  `reply_text` varchar(500) NOT NULL,
  `creation_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trip_details`
--

CREATE TABLE `trip_details` (
  `email` varchar(30) NOT NULL,
  `trip_id` varchar(20) NOT NULL,
  `trip_name` varchar(50) NOT NULL,
  `place_name` varchar(30) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trip_details`
--

INSERT INTO `trip_details` (`email`, `trip_id`, `trip_name`, `place_name`, `start_date`, `end_date`) VALUES
('juned@gmail.com', 'ahmedabaad1745239014', 'h', 'ahmedabaad', '2019-02-24', '2019-02-23'),
('jaydevdesai15@gmail.com', 'Ahmedabad730800141', 'Trip to Ahmedabad', 'Ahmedabad', '2019-02-19', '2019-02-27'),
('jaydevdesai15@gmail.com', 'Amritsar76442771', 'Trip to Amritsar', 'Amritsar', '2019-02-28', '2019-03-30'),
('jaydevdesai15@gmail.com', 'Manali1082030548', 'Trip to Manali', 'Manali', '2019-02-19', '2019-02-28'),
('juned@gmail.com', 'Manali273494041', 'Manali Trip', 'Manali', '2019-02-23', '2019-02-25');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `email` varchar(30) NOT NULL,
  `name` varchar(40) NOT NULL,
  `image` varchar(100) NOT NULL,
  `dob` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `email` varchar(30) NOT NULL,
  `document_id` varchar(20) NOT NULL,
  `document_name` varchar(25) NOT NULL,
  `doucment_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`email`, `password`, `creation_time`) VALUES
('jaydevdesai15@gmail.com', '8128908909', '2019-01-27 07:45:54'),
('jaydevdesai15@yahoo.com', '1234', '2019-01-27 07:56:19'),
('jaydevdesai786@gmail.com', 'hgjgjh', '2019-01-26 15:32:46'),
('juned@gmail.com', '1234', '2019-02-23 04:28:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_notes`
--

CREATE TABLE `user_notes` (
  `trip_id` varchar(20) NOT NULL,
  `note_id` varchar(30) NOT NULL,
  `note_text` text NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_query`
--

CREATE TABLE `user_query` (
  `email` varchar(30) NOT NULL,
  `query_id` varchar(20) NOT NULL,
  `query_text` varchar(500) NOT NULL,
  `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_reservations`
--

CREATE TABLE `user_reservations` (
  `trip_id` varchar(20) NOT NULL,
  `reservation_id` varchar(20) NOT NULL,
  `reservation_name` varchar(25) NOT NULL,
  `reservation_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_shopping`
--

CREATE TABLE `user_shopping` (
  `trip_id` varchar(20) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `bought` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_details`
--
ALTER TABLE `group_details`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `query_replies`
--
ALTER TABLE `query_replies`
  ADD KEY `fk_query` (`query_id`),
  ADD KEY `fk_emailReply` (`replier_email`);

--
-- Indexes for table `trip_details`
--
ALTER TABLE `trip_details`
  ADD PRIMARY KEY (`trip_id`) USING BTREE,
  ADD KEY `fk_emailTrip` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD KEY `fk_emailUser` (`email`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `fk_email` (`email`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `user_notes`
--
ALTER TABLE `user_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `fk_tripIdnotes` (`trip_id`);

--
-- Indexes for table `user_query`
--
ALTER TABLE `user_query`
  ADD PRIMARY KEY (`query_id`),
  ADD KEY `fk_emailQuery` (`email`);

--
-- Indexes for table `user_reservations`
--
ALTER TABLE `user_reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `fk_tripId` (`trip_id`);

--
-- Indexes for table `user_shopping`
--
ALTER TABLE `user_shopping`
  ADD KEY `fk_tripIdShop` (`trip_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `query_replies`
--
ALTER TABLE `query_replies`
  ADD CONSTRAINT `fk_emailReply` FOREIGN KEY (`replier_email`) REFERENCES `user_login` (`email`),
  ADD CONSTRAINT `fk_query` FOREIGN KEY (`query_id`) REFERENCES `user_query` (`query_id`);

--
-- Constraints for table `trip_details`
--
ALTER TABLE `trip_details`
  ADD CONSTRAINT `fk_emailTrip` FOREIGN KEY (`email`) REFERENCES `user_login` (`email`);

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `fk_emailUser` FOREIGN KEY (`email`) REFERENCES `user_login` (`email`);

--
-- Constraints for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `fk_email` FOREIGN KEY (`email`) REFERENCES `user_login` (`email`);

--
-- Constraints for table `user_notes`
--
ALTER TABLE `user_notes`
  ADD CONSTRAINT `fk_tripIdnotes` FOREIGN KEY (`trip_id`) REFERENCES `trip_details` (`trip_id`);

--
-- Constraints for table `user_query`
--
ALTER TABLE `user_query`
  ADD CONSTRAINT `fk_emailQuery` FOREIGN KEY (`email`) REFERENCES `user_login` (`email`);

--
-- Constraints for table `user_reservations`
--
ALTER TABLE `user_reservations`
  ADD CONSTRAINT `fk_tripId` FOREIGN KEY (`trip_id`) REFERENCES `trip_details` (`trip_id`);

--
-- Constraints for table `user_shopping`
--
ALTER TABLE `user_shopping`
  ADD CONSTRAINT `fk_tripIdShop` FOREIGN KEY (`trip_id`) REFERENCES `trip_details` (`trip_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
