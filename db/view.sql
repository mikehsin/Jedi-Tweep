/*
Dummy database:
This code to implement the views for the jedisweeps database.
This code is written by Nhi Ly.
*/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*
First view
tweep: select everything from the jeditweep table combined with the author's full name from the jediuser table.
*/

CREATE DATABASE IF NOT EXISTS `JediTweeps`;
USE `JediTweeps`;

DROP VIEW IF EXISTS `tweep`;

CREATE VIEW `tweep` AS
SELECT post_id, post_category, post_date, post_title, post_content, username, (SELECT CONCAT(firstname,' ',lastname) FROM jediuser WHERE username = jeditweep.username) AS full_name FROM `jeditweep` ORDER BY `post_date` DESC;

