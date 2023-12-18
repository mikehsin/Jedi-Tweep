<?php
/*
This code to implement the database connection feature has been used with some modification from the submission
for Assignment 3 by Student Nhi Ly in CSCI 2170 (Winter 2021).
Nhi Ly, Assignment 3: CSCI 2170 (Winter 2021), Faculty of Computer Science,
Dalhousie University. Available online on Gitlab at [URL]:
https://git.cs.dal.ca/courses/2021-winter/csci-2170/a3/nly.
Date accessed: 21 Mar 2021.
*/
// Access control
require_once "access-check.php";
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jedi Tweep</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
<header id="pg-header">
    <nav class="navbar navbar-expand navbar-dark bg-dark px-3" aria-label="Second navbar example">
        <a class="navbar-brand text-info" href="index.php"><strong>Jedi Tweep</strong></a>
        <?php
        // If the user has logged in, display this part of the navigation bar.
        if (isset($_SESSION["username"])) {
        ?>
        <div class="collapse navbar-collapse" id="navbars">
            <ul class="nav nav-pills">
                <li class="nav-item active">
                    <a class="nav-link text-white" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link text-white" aria-current="page" href="profile.php">Profile</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link text-white" aria-current="page" href="submit-tweep.php">Post a tweep</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link text-white" aria-current="page" href="users.php">List of users</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link text-white" aria-current="page" href="includes/logout.php">Logout</a>
                </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
        if (isset($_SESSION["is-admin"])){
            if ($_SESSION["is-admin"]){
        ?>
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link text-warning" aria-current="page" href="admin.php">Administration</a>
            </li>
        </ul>
        <?php
            }
        }
        ?>
    </nav>
</header>
