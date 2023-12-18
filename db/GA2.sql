/*
Dummy database:
This code to implement the jediuser database  with some modification from the stater code for Assignment 3 (CSCI 2170)
The starter code was developed by Dr. Raghav V. Sampangi (raghav@cs.dal.ca)
Date accessed: Mar 21 2021
*/

-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2021 at 12:16 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `JediTweeps`
--

-- --------------------------------------------------------

--
-- Table structure for table `jediuser`
--

CREATE DATABASE IF NOT EXISTS `JediTweeps`;
USE `JediTweeps`;

DROP TABLE IF EXISTS `jeditweep`;
DROP TABLE IF EXISTS `jedifollowing`;
-- Please use the scripts for these tables to recreate them.

-- create the user table
DROP TABLE IF EXISTS `jediuser`;

CREATE TABLE `jediuser` (
  `username` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `email` varchar(320) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- create the tweep table
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

-- Create the following table
DROP TABLE IF EXISTS `jedifollowing`;

CREATE TABLE `jedifollowing` (
    username varchar(128) NOT NULL,
    -- If a follows b, b will be the username and a will be the follower.
    follower_username varchar(128) NOT NULL,
    PRIMARY KEY (username, follower_username),
    FOREIGN KEY (username) REFERENCES jediuser(username),
    FOREIGN KEY (follower_username) REFERENCES jediuser(username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jediuser`
--

INSERT INTO `jediuser` (`username`, `password`, `firstname`, `lastname`, `email`, `is_admin`) VALUES
('yoda', '1234', 'Yoda', '', 'yoda@theforce.org', 1),
('luke', '1234', 'Luke', 'Skywalker', 'luke@theforce.org', 0),
('rey', '1234', 'Rey', 'Skywalker', 'rey@theforce.org', 0);


--
-- Dumping data for table `jeditweep`
--

INSERT INTO `jeditweep` (`username`, `post_date`, `post_category`, `post_title`, `post_content`, `likeNum`, `isShared`) VALUES
('rey', '2021-01-01', 'Introduction; The Force', 'I am Rey Skywalker', 'I know my past but my past does not define my path.', 0, 0),
('luke', '2021-01-10', 'The Force', 'From beyond the physical dimension', 'I did not realize that this \"\"land\"\" beyond the physical dimension or realm was this astonishing.', 0, 0),
('yoda', '2021-01-18', 'The Force; Resolve', 'Sharing thoughts, I am', 'Do or do not. There is no try.', 0, 0),
('yoda ', '2021-02-18', 'Test Category; The Force', 'Test post', 'This is a test post', 0, 0),
('yoda', '2021-02-18', 'The Force; Jedi; Sith', 'Destroyed, The Sith Are!', 'The Sith were finally destroyed in the end of &quot;The Rise of Skywalker&quot;', 0, 0);

-- Create index for username for faster search
CREATE INDEX idx_username ON `jeditweep` (`username`);

--
-- Dumping data for table `jedifollowing`
--
INSERT INTO `jedifollowing`
VALUES
-- rey follows yoda
('yoda', 'rey'),
-- yoda follows rey and luke.
('rey','yoda'),
('luke','yoda');

-- Create index for username for faster search
CREATE INDEX idx_username ON `jedifollowing`(`username`);
CREATE INDEX idx_follower ON `jedifollowing`(`follower_username`);

-- Creating a view
DROP VIEW IF EXISTS `tweep`;

CREATE VIEW `tweep` AS
SELECT post_id, post_category, post_date, post_title, post_content, username,likeNum, isShared,
    (SELECT CONCAT(firstname,' ',lastname) FROM jediuser WHERE username = jeditweep.username) 
    AS full_name FROM `jeditweep` ORDER BY `post_date` DESC;


