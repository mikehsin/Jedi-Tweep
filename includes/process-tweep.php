<?php
    // Access control
    require_once "access-check.php";
	//Process the submitted blog post here.
    require_once "db.php";
    require_once "function.php";

    /*
    This code to implement processing form submission has been used with some
    modification from my submission for Assignment 1 in CSCI 2170 (Winter 2021).
    Nhi Ly, Assignment 1: CSCI 2170 (Winter 2021), Faculty of Computer
    Science, Dalhousie University. Available online on Gitlab at [URL]:
    https://git.cs.dal.ca/courses/2021-winter/csci-2170/a1/nly.git
    Date accessed: Mar 13 2021.
    */
    if (isset($_SESSION["username"])){
        if (isset($_POST['submit-tweep'])){
            // If all text areas are not empty, insert a new blog into the database
            // empty: https://www.php.net/manual/en/function.empty
            if (!empty ($_POST['tweep-title']) && !empty ($_POST['tweep-category']) &&  !empty ($_POST['tweep-content'])){
                if (isset($dbconnection)){

                    // Sanitize the input before putting into the database.
                    $postName = sanitizeDbInput($_POST['tweep-title'], $dbconnection);
                    $postCategory = sanitizeDbInput($_POST['tweep-category'], $dbconnection);
                    $postContent = sanitizeDbInput($_POST['tweep-content'], $dbconnection);
                    $postDate = date("Y-m-d");
                    if (isset($_SESSION["username"])){
                        $postAuthorUsername = $_SESSION["username"];
                    }
                    else{
                        $postAuthorUsername = "";
                    }

                    // Insert a new row into the database
                    $sql = "INSERT INTO `jeditweep` 
    (username, post_date, post_category, post_title, post_content, likeNum, isShared)
    VALUES(?, ?, ?, ?, ?, 0, 0)"; //the new post initially has not like number and it's not shared

                    // Prepare the sql statement.
                    $prepared = $dbconnection->prepare($sql);
                    $prepared->bind_param('sssss', $postAuthorUsername, $postDate, $postCategory, $postName, $postContent);
                    $prepared->execute();
                    $affected_rows = $prepared->affected_rows;
                    $prepared->close();

                    // Check if there is any error in executing the query.
                    if ($affected_rows == 1){
                        // Redirect to index.php with a success code
                        header("Location: ../index.php?blog-submit=1");
                    }
                    else{
                        // Redirect to index.php with a failure code
                        header("Location: ../index.php?blog-submit=0");
                    }
                }
            }
        }
    }

