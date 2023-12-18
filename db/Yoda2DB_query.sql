-- phpMyAdmin MySQL database
--
-- Host: http://localhost:8888/
-- Generation Time: Feb 20, 2021
-- PHP Version: 7.4.12
-- MySQL Version: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `CSCI2170Yoda2`
-- Author: Mike Hsin

-- --------------------------------------------------------

-- Create database CSCI2170Yoda2;

Use CSCI3170Yoda2;

--
-- Table structure for table `Appuser`
--

CREATE TABLE AppUser (
    Username varchar(128) UNIQUE NOT NULL,
    -- AUTO_INCREMENT missing
    UserPassword varchar(32) NOT NULL,
    FirstName varchar(128) NOT NULL,
    LastName varchar(128),
    EmailAddress varchar(128) NOT NULL,
    RegisterDate date NOT NULL,
    IsAdmin tinyint(1) NOT NULL,
    PRIMARY KEY(Username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE UserFollowing (
    UserUsername varchar(128) NOT NULL,
    FollowingUsername varchar(128) NOT NULL,
    PRIMARY KEY (UserUsername),
    FOREIGN KEY (UserUsername) REFERENCES AppUser(Username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE UserFollower (
    UserUsername varchar(128) NOT NULL,
    FollowerUsername varchar(128) NOT NULL,
    PRIMARY KEY (UserUsername),
    FOREIGN KEY (UserUsername) REFERENCES AppUser(Username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE BlogPost (
    BlogPostID Integer(10) UNIQUE NOT NULL AUTO_INCREMENT,
    PostingDate date NOT NULL,
    PostContent varchar(2048) NOT NULL,
    LikeByUser varchar(2048),
    Isshared tinyint(1) NOT NULL,
    SharedFrom varchar(128) NOT NULL,
    CommentedUser varchar(3200) NOT NULL,
    CommentedDate date NOT NULL,
    CommentContent varchar(8000) NOT NULL,
    UserUsername varchar(128) NOT NULL,
    PRIMARY KEY(BlogPostID),
    FOREIGN KEY (UserUsername) REFERENCES AppUser(Username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE SysAdmin (
    AdminNumber Integer(10) UNIQUE NOT NULL AUTO_INCREMENT,
    UserUsername varchar(128) NOT NULL,
    AdminPassword varchar(32) NOT NULL,
    PRIMARY KEY(AdminNumber),
    FOREIGN KEY (UserUsername) REFERENCES AppUser(Username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ALTER TABLE BlogPost
--   MODIFY BlogPostID int(10) NOT NULL AUTO_INCREMENT;


-- show tables;
-- select * from AppUser;
-- select * from UserFollowing;
-- select * from BlogPost;
-- select * from SysAdmin;


--
-- Insert Data into the table
--

-- INSERT INTO AppUser (Username, UserPassword, FirstName, LastName, EmailAddress, RegisterDate, IsAdmin) VALUES
--     ('mikehsin', '1234', 'Mike', 'Hsin', 'mike@dal.ca', '2021-01-01', 1),
--     ('tester', '1234', 'Tester', '', 'tester@dal.ca','2021-02-23',1),
--     ('user1', '1234', 'user1', '', 'user1@dal.ca','2021-01-23',0),
--     ('nhily', '1234', 'Nhi', 'Ly', 'Nhi@dal.ca','2021-01-23',1),
--     ('meloniepark', '1234', 'Melonie', 'Park', 'melonie@dal.ca','2021-01-23',1),
--     ('charchitsingh', '1234', 'Charchit', 'Singh', 'charchit@dal.ca','2021-01-23',1),
--     ('sameermohamed', '1234', 'Sameer', 'Mohamed', 'sameer@dal.ca','2021-01-23',1),
--     ('yoda2', '1234', 'Yoda2', 'The', 'yoda2@dal.ca','2021-01-23',0),
--     ('kingJames', '1234', 'LeBron', 'James', 'user1@dal.ca','2021-01-23',0);


    -- UserUsername varchar(128) NOT NULL,
    -- FollowingUsername varchar(128) NOT NULL,
    -- FollowerUsername varchar(128) NOT NULL
-- INSERT INTO UserFollowing(UserUsername, FollowingUsername) VALUES
--     ('mikehsin', 'nhily'),
--     ('mikehsin', 'meloniepark'),
--     ('mikehsin', 'charchitsingh'),
--     ('mikehsin', 'sameermohamed'),
--     ('mikehsin', 'kingJames'),
--     ('nhily', 'mikehsin'),
--     ('nhily', 'meloniepark'),
--     ('nhily', 'charchitsingh'),
--     ('nhily', 'sameermohamed'),
--     ('meloniepark', 'nhily'),
--     ('meloniepark', 'mikehsin'),
--     ('meloniepark', 'charchitsingh'),
--     ('meloniepark', 'sameermohamed'),
--     ('charchitsingh', 'nhily'),
--     ('charchitsingh', 'mikehsin'),
--     ('charchitsingh', 'meloniepark'),
--     ('charchitsingh', 'sameermohamed'),
--     ('sameermohamed', 'nhily'),
--     ('sameermohamed', 'mikehsin'),
--     ('sameermohamed', 'meloniepark'),
--     ('sameermohamed', 'charchitsingh');

-- INSERT INTO UserFollowing(UserUsername, FollowerUsername) VALUES
--     ('mikehsin', 'nhily'),
--     ('mikehsin', 'meloniepark'),
--     ('mikehsin', 'charchitsingh'),
--     ('mikehsin', 'sameermohamed'),
--     ('nhily', 'mikehsin'),
--     ('nhily', 'meloniepark'),
--     ('nhily', 'charchitsingh'),
--     ('nhily', 'sameermohamed'),
--     ('meloniepark', 'nhily'),
--     ('meloniepark', 'mikehsin'),
--     ('meloniepark', 'charchitsingh'),
--     ('meloniepark', 'sameermohamed'),
--     ('charchitsingh', 'nhily'),
--     ('charchitsingh', 'mikehsin'),
--     ('charchitsingh', 'meloniepark'),
--     ('charchitsingh', 'sameermohamed'),
--     ('sameermohamed', 'nhily'),
--     ('sameermohamed', 'mikehsin'),
--     ('sameermohamed', 'meloniepark'),
--     ('sameermohamed', 'charchitsingh')
--     ('kingJames', 'mikehsin');

-- INSERT INTO BlogPost(PostingDate, PostContent, LikeByUser, Isshared, SharedFrom, CommentedUser, CommentedDate, CommentContent, UserUsername) VALUES
--     ('2021-01-25', 'Cleveland! This is for you!!!', 'mikehsin', 0, '', '', '','','kingJames'),
--     ('2021-01-26', 'OMG, php is hard', '', 0, '', '','','mikehsin'),
--     ('2021-01-27', 'Cleveland! This is for you!!!', 'meloniepark', 1, 'kingJames','charchitsing','2021-01-27','Mike, you really are a basketball nerd.','mikehsin'),
--     ('2021-01-28', 'Php for Life!!!', '', 0, '', 'mikehsin', '2021-01-28','lol','nhily'),
--     ('2021-01-29', 'I love php!', '', 0, '', '', '','','sameermohamed');

    --     AdminNumber Integer(10) UNIQUE NOT NULL AUTO_INCREMENT,
    -- UserUsername varchar(128) NOT NULL,
    -- AdminPassword varchar(32) NOT NULL,

-- INSERT INTO SysAdmin(UserUsername, AdminPassword) VALUES
--     ('mikehsin', '1234'),
--     ('tester', '1234'),
--     ('nhily', '1234'),
--     ('meloniepark', '1234'),
--     ('charchitsingh', '1234'),
--     ('sameermohamed', '1234');