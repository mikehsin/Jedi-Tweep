
/*
Dummy database:
This code to implement the jedifollowing database.
It tracks each's user followers and the authors they are following.
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
-- Table structure for table `jedifollowing`
--

CREATE DATABASE IF NOT EXISTS `JediTweeps`;
USE `JediTweeps`;
DROP TABLE IF EXISTS `jedifollowing`;

CREATE TABLE `jedifollowing` (
    username varchar(128) NOT NULL,
    -- If a follows b, b will be the username and a will be the follower.
    follower_username varchar(128) NOT NULL,
    PRIMARY KEY (username, follower_username),
    FOREIGN KEY (username) REFERENCES jediuser(username),
    FOREIGN KEY (follower_username) REFERENCES jediuser(username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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