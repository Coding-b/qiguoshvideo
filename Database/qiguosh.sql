-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2014-09-29 06:52:01
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `qiguosh`
--

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
  `categoryType` int(11) NOT NULL,
  `categoryParent` int(11) NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- 表的结构 `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `reviewId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `reviewContent` text NOT NULL,
  `reviewParent` int(11) NOT NULL,
  `videoId` int(11) NOT NULL,
  `reviewTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reviewId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- 表的结构 `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `slideId` int(11) NOT NULL AUTO_INCREMENT,
  `slideImage` varchar(100) NOT NULL,
  `slideOrder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`slideId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(4) NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phoneNum` varchar(11) DEFAULT NULL,
  `emailAdd` varchar(50) DEFAULT NULL,
  `userKind` tinyint(4) NOT NULL,
  `userImage` varchar(100) NOT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `personalWords` tinytext,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `videoId` int(11) NOT NULL AUTO_INCREMENT,
  `videoName` varchar(100) NOT NULL,
  `owner` int(11) NOT NULL,
  `videoImage` varchar(100) NOT NULL,
  `videoLabel` varchar(50) DEFAULT NULL,
  `viewed` int(11) NOT NULL DEFAULT '0',
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `videoAdd` varchar(300) NOT NULL,
  `videoType` int(11) NOT NULL,
  `videoDesc` text NOT NULL,
  `videoStatus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`videoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
