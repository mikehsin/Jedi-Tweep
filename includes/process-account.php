<?php
/*
Melonie Park
Processing create new user request received from the admin.php.
*/ 

// Access control
require_once "access-check.php";
//Process the user account creating here.
require_once "db.php";
require_once "function.php";

// Melonie
if (isset($_POST["username"])){

    if (isset($dbconnection)){
        //sanitize the input first
        $username = sanitizeDbInput($_POST["username"], $dbconnection);
        $password = sanitizeDbInput($_POST["password"], $dbconnection);
        $firstname = sanitizeDbInput($_POST["firstname"], $dbconnection);
        $lastname = sanitizeDbInput($_POST["lastname"], $dbconnection);
        $email = sanitizeDbInput($_POST["email"], $dbconnection);
        
        //check if admin radio button was checked. 
        $adminOrNot = $_POST["admin-right"];
        $admin = 0;
        
        //admin radio button was checked. 
        if ($adminOrNot == "yes"){
            $admin = 1;
        }
        
        //insert new user in the database. 
        $querySQL = "INSERT INTO `jediuser` (`username`, `password`, `firstname`, `lastname`, `email`, `is_admin`) VALUES
        ('$username', '$password', '$firstname', '$lastname', '$email', $admin) ";

        $result = $dbconnection->query($querySQL);

        //get back to admin.php page with update set to 1 if the user creating was successfully done. 
        if ($result === true){
            header("location: ../admin.php?update=1");
        }
        //otherwise, get back to admin.php page with update set to 0 for further alert process. 
        else{
            header("location: ../admin.php?update=0");
        }
    }
}



?>