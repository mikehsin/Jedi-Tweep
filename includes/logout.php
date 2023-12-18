<?php

    /*
    This code to implement the database connection feature has been used with some modification from the submission
    for Assignment 3 by Student Nhi Ly in CSCI 2170 (Winter 2021).
    Nhi Ly, Assignment 3: CSCI 2170 (Winter 2021), Faculty of Computer Science,
    Dalhousie University. Available online on Gitlab at [URL]:
    https://git.cs.dal.ca/courses/2021-winter/csci-2170/a3/nly.
    Date accessed: 21 Mar 2021.
    */

	/*
	 * Logout script: session destroy functionality implemented based on 
	 * the script available on PHP.net
	 * URL: https://www.php.net/manual/en/function.session-destroy.php
	 * Date accessed: 17 Feb 2021
	 * Author: PHP.net contributors
	 */

    session_start();

    // access control
    if (!isset($_SESSION["username"])){
        // Redirect and display error message
        header("Location: ../index.php?noaccess=1");
        die;
    }

	// Unset all of the session variables.
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	// Finally, destroy the session.
	session_destroy();

	// Add your code here.
    // Redirect to the homepage after session is destroyed
    header("Location: ../index.php");
?>