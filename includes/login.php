<?php
    // Access control
    require_once "access-check.php";
    require_once "db.php";
    require_once "function.php";

    // Include your login processing script here.
    // If we are sent to this form from jedi-login using the post method, verify the user.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submit-jedi-login'])){

            // If the username and password are not empty, start to verify them.
            // empty: https://www.php.net/manual/en/function.empty
            if (!empty ($_POST['jedi-uname']) && !empty ($_POST['jedi-pswd'])) {
                
                // Check the database connection
                if (isset($dbconnection)) {

                    // Melonie Park
                    // Verify username and password
                    $username = sanitizeDbInput($_POST["jedi-uname"], $dbconnection);
	                $password = sanitizeDbInput($_POST["jedi-pswd"], $dbconnection);

                    $querySQL="select * from jediuser where username = '$username' AND password = '$password'";
                    $result = $dbconnection->query($querySQL);
                    
                    // user login was successful.
                    if ($result->num_rows === 1){

                        // Destroy the old session.
                        destroyCurrentSession();
                        // Start a new session
                        session_start();
                        // Regenerate the session id.
                        session_regenerate_id(true);

                        // Set the session variable
                        $row = $result->fetch_assoc();
                        $_SESSION["username"] = $row['username'];
                        $_SESSION["password"] = $row['password'];
                        $_SESSION["is-admin"] = $row['is_admin'];
                        $_SESSION["full-name"] = $row['firstname']." ".$row['lastname'];
                        $_SESSION["email"] = $row['email'];

                        header("Location: ../profile.php?welcome=1");
                    }
                    //if user login was not successful
                    else{
                        echo "user not found!";
                        header("Location: ../jedi-login.php?login-success=0");
                    }
                
                    die;
                }
            }
        }
    }