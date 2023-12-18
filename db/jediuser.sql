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

--
-- Dumping data for table `jediuser`
--

INSERT INTO `jediuser` (`username`, `password`, `firstname`, `lastname`, `email`, `is_admin`) VALUES
('yoda', '1234', 'Yoda', '', 'yoda@theforce.org', 1),
('luke', '1234', 'Luke', 'Skywalker', 'luke@theforce.org', 0),
('rey', '1234', 'Rey', 'Skywalker', 'rey@theforce.org', 0);
