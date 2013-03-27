-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2013 at 01:49 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dalalstreett`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `userid` int(11) NOT NULL,
  `stockid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` float NOT NULL,
  `since` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank`
--


-- --------------------------------------------------------

--
-- Table structure for table `buy`
--

CREATE TABLE IF NOT EXISTS `buy` (
  `theid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `stockid` int(11) NOT NULL,
  `pricerendered` float(11,0) NOT NULL,
  `num` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`theid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `buy`
--

INSERT INTO `buy` (`theid`, `userid`, `stockid`, `pricerendered`, `num`, `timestamp`) VALUES
(32, 1, 1, 90, 3, 1358966888),
(33, 1, 1, 70, 4, 1359028972);

-- --------------------------------------------------------

--
-- Table structure for table `graph`
--

CREATE TABLE IF NOT EXISTS `graph` (
  `stockid` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `time` text NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `graph`
--


-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `event` int(11) NOT NULL AUTO_INCREMENT,
  `action` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `stockid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `log`
--


-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE IF NOT EXISTS `marks` (
  `markid` int(11) NOT NULL AUTO_INCREMENT,
  `markaction` int(11) NOT NULL,
  `stockid` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  `lower_set` int(11) NOT NULL,
  `upper_set` int(11) NOT NULL,
  `time_set` int(11) NOT NULL,
  PRIMARY KEY (`markid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `marks`
--


-- --------------------------------------------------------

--
-- Table structure for table `newsfeed`
--

CREATE TABLE IF NOT EXISTS `newsfeed` (
  `feedid` int(11) NOT NULL AUTO_INCREMENT,
  `feed` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`feedid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `newsfeed`
--

INSERT INTO `newsfeed` (`feedid`, `feed`, `time`) VALUES
(1, 'market to close at 1200hours', 1358662428),
(2, 'bank to close in 10minutes', 1358662468);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `notid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `notification` text NOT NULL,
  `seen` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`notid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notid`, `userid`, `timestamp`, `notification`, `seen`, `type`) VALUES
(58, 1, 1359025699, '2 number of reliance have been brought for 130 at 65 pershare', 0, 5),
(59, 2, 1359025699, '2 number of reliance have been sold for 120 at 60 pershare', 0, 5),
(60, 1, 1359026009, '2 number of reliance have been brought for 140 at 70 pershare', 0, 5),
(61, 2, 1359026009, '2 number of reliance have been sold for 120 at 60 pershare', 0, 5),
(62, 1, 1359026076, '1 number of reliance have been brought for 90 at 90 pershare', 0, 5),
(63, 2, 1359026076, '1 number of reliance have been sold for 60 at 60 pershare', 0, 5),
(64, 1, 1359026119, '1 number of reliance have been brought for 80 at 80 pershare', 0, 5),
(65, 2, 1359026119, '1 number of reliance have been sold for 40 at 40 pershare', 0, 5),
(66, 1, 1359029030, '1 number of reliance have been brought for 90 at 90 pershare', 0, 5),
(67, 2, 1359029030, '1 number of reliance have been sold for 50 at 50 pershare', 0, 5),
(68, 1, 1359029031, '1 number of reliance have been brought for 70 at 70 pershare', 0, 5),
(69, 2, 1359029031, '1 number of reliance have been sold for 60 at 60 pershare', 0, 5),
(70, 1, 1359029203, '2 number of apple share have been TRADED with EXCHANGE for 90 at Rs. 45 PER SHARE : total CASH in account 310', 0, 8),
(71, 1, 1359029522, '1 number of reliance share have been MORTGAGED for cash amount Rs. 48', 0, 1),
(72, 1, 1359029548, '2 number of reliance share have been PUT up for sale at Rs. 60', 0, 4),
(73, 1, 1359029703, '1 number of reliance share have been REDEEMED for 48 at Rs. 48 PER SHARE : total CASH in account 310', 0, 8),
(74, 1, 1359032142, '2 number of reliance share have been PUT up for sale at Rs. 60', 0, 4),
(75, 1, 1359634558, '4 number of lg share have been TRADED with EXCHANGE for 80 at Rs. 20 PER SHARE : total CASH in account 230', 0, 8),
(76, 1, 1359634589, '2 number of lg share have been PUT up for sale at Rs. 60', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sell`
--

CREATE TABLE IF NOT EXISTS `sell` (
  `theid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `stockid` int(11) NOT NULL,
  `priceexpected` float NOT NULL,
  `num` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`theid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `sell`
--

INSERT INTO `sell` (`theid`, `userid`, `stockid`, `priceexpected`, `num`, `timestamp`) VALUES
(29, 1, 1, 60, 2, 1359029548),
(30, 1, 3, 60, 2, 1359634589);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE IF NOT EXISTS `stocks` (
  `stockid` int(11) NOT NULL AUTO_INCREMENT,
  `stockname` text NOT NULL,
  `currentprice` float NOT NULL,
  `dayhigh` float NOT NULL,
  `daylow` float NOT NULL,
  `alltimehigh` float NOT NULL,
  `alltimelow` float NOT NULL,
  `stocksinexchange` int(11) NOT NULL,
  `stocksinmarket` int(11) NOT NULL,
  PRIMARY KEY (`stockid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stockid`, `stockname`, `currentprice`, `dayhigh`, `daylow`, `alltimehigh`, `alltimelow`, `stocksinexchange`, `stocksinmarket`) VALUES
(1, 'reliance', 40, 42, 38, 44, 36, 10, 10),
(2, 'apple', 46, 47, 34, 67, 35, 18, 22),
(3, 'lg', 20, 23, 21, 25, 19, 16, 44);

-- --------------------------------------------------------

--
-- Table structure for table `stocks_details`
--

CREATE TABLE IF NOT EXISTS `stocks_details` (
  `userid` int(11) NOT NULL,
  `stockid` int(11) NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocks_details`
--

INSERT INTO `stocks_details` (`userid`, `stockid`, `num`) VALUES
(1, 1, 15),
(2, 1, 2),
(1, 2, 2),
(1, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(7) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `verified` int(1) NOT NULL,
  `disabled` int(1) NOT NULL,
  `cash` float NOT NULL,
  `sessionid` text NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `email`, `password`, `verified`, `disabled`, `cash`, `sessionid`) VALUES
(1, 'rubul', 'rubul@haloi.com', 'rubulhaloi11', 1, 0, 230, '1kfcgn2pfe3bhkpiion15i3620'),
(2, 'dipankar', 'dipankar@gmail.com', 'rubulhaloi11', 1, 0, 1480, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_actions`
--

CREATE TABLE IF NOT EXISTS `user_actions` (
  `eventid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `stockid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`eventid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_actions`
--

