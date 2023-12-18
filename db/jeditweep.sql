/*
Dummy database:
This code to implement the jeditweep database  with some modification from the stater code for Assignment 3 (CSCI 2170)
The starter code was developed by Dr. Raghav V. Sampangi (raghav@cs.dal.ca)
Date accessed: Mar 21 2021
*/

-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2021 at 12:15 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `JediTweeps`
--

-- --------------------------------------------------------

--
-- Table structure for table `jeditweep`
--
CREATE DATABASE IF NOT EXISTS `JediTweeps`;
USE `JediTweeps`;

DROP TABLE IF EXISTS `jeditweep`;

CREATE TABLE `jeditweep` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL ,
  `post_date` date NOT NULL,
  `post_category` varchar(64) NOT NULL,
  `post_title` varchar(256) NOT NULL,
  `post_content` varchar(240) NOT NULL,
  `likeNum` int(10) NOT NULL,
  `isShared` tinyInt(1) NOT NULL,
  PRIMARY KEY (`post_id`),
  FOREIGN KEY (`username`) REFERENCES `jediuser`(`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jeditweep`
--

INSERT INTO `jeditweep` (`username`, `post_date`, `post_category`, `post_title`, `post_content`, `likeNum`, `isShared`) VALUES
('rey', '2021-01-01', 'Introduction; The Force', 'I am Rey Skywalker', 'I know my past but my past does not define my path. I cannot avoid my Palpatine ancestry, but from now, I am Rey Skywalker. I am creating my own path using the Force to guide me.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vel varius sem. Vivamus vel erat et massa pretium condimentum quis eget quam. Suspendisse cursus mollis metus, quis sodales felis sodales ut. Praesent luctus eu augue at malesuada. \r\n\r\nInteger nec mauris enim. Morbi est risus, suscipit quis fringilla eget, commodo id diam. Suspendisse cursus urna vitae tempus consequat. Proin euismod felis nisi, a dictum arcu eleifend sit amet. Aliquam leo nisi, dapibus a odio sit amet, mollis vulputate nunc. Donec ex mi, pharetra ac urna nec, pretium malesuada metus. Etiam et tortor sagittis, facilisis purus eu, auctor ex.', 0, 0),
('luke', '2021-01-10', 'The Force', 'From beyond the physical dimension', 'I did not realize that this \"\"land\"\" beyond the physical dimension or realm was this astonishing. I get to hang out with Master Yoda, Obi-Wan, my dad in his Anakin form, my sister, Han and their kid. It is pretry cool!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vel varius sem. Vivamus vel erat et massa pretium condimentum quis eget quam. Suspendisse cursus mollis metus, quis sodales felis sodales ut. Praesent luctus eu augue at malesuada. Integer nec mauris enim. Morbi est risus, suscipit quis fringilla eget, commodo id diam. Suspendisse cursus urna vitae tempus consequat.\r\n\r\nProin euismod felis nisi, a dictum arcu eleifend sit amet. Aliquam leo nisi, dapibus a odio sit amet, mollis vulputate nunc. Donec ex mi, pharetra ac urna nec, pretium malesuada metus. Etiam et tortor sagittis, facilisis purus eu, auctor ex.', 0, 0),
('yoda', '2021-01-18', 'The Force; Resolve', 'Sharing thoughts, I am', 'Do or do not. There is no try.', 0, 0),
('yoda ', '2021-02-18', 'Test Category; The Force', 'Test post', 'This is a test post', 0, 0),
('yoda', '2021-02-18', 'The Force; Jedi; Sith', 'Destroyed, The Sith Are!', 'The Sith were finally destroyed in the end of &quot;The Rise of Skywalker&quot;', 0, 0);

-- Create index for username for faster search
CREATE INDEX idx_username ON `jeditweep` (`username`);