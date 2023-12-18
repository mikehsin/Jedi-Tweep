<?php

/*
This code to implement the access control feature has been used with some modification from the submission
for Assignment 3 by Student Nhi Ly in CSCI 2170 (Winter 2021).
Nhi Ly, Assignment 3: CSCI 2170 (Winter 2021), Faculty of Computer Science,
Dalhousie University. Available online on Gitlab at [URL]:
https://git.cs.dal.ca/courses/2021-winter/csci-2170/a3/nly.
Date accessed: 21 Mar 2021.
*/


// Access control
session_start();
// If the user access this page through the folder structure '/includes' but not through the method POST, redirect the user depending on their login status.
$illegalAccess = strpos($_SERVER['REQUEST_URI'], "/includes/");

if ($illegalAccess !== false && !($_SERVER["REQUEST_METHOD"] == "POST")){
    if (!isset($_SESSION["username"])){
        // Redirect to the login page and display error message
        header("Location: ../jedi-login.php?noaccess=1");
        die;
    }
    else{
        // Redirect without display an error message.
        header("Location: ../index.php");
        die;
    }
}
