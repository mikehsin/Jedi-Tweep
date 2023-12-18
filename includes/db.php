<?php

    /*
    * CSCI 2170: ONLINE EDITION, WINTER 2021
    * STARTER CODE FOR ASSIGNMENT 3
    *
    * This code was developed by Dr. Raghav V. Sampangi (raghav@cs.dal.ca)
    *
    * DB connection script
    */

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

	$hostName = 'db.cs.dal.ca';
    // db.cs.dal.ca
	$username = 'hsin';
	$password = 'WGjo6ExZo8MVbhRzhwNTomw8K';
	$dbname = 'hsin';

	$dbconnection = new mysqli($hostName, $username, $password, $dbname);

	if ($dbconnection->connect_error) {
        echo 'Errno: '.$dbconnection->connect_errno;
        echo '<br>';
        echo 'Error: '.$dbconnection->connect_error;
        exit();
	}