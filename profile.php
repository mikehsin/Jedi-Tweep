<?php
	/*
	* CSCI 2170: ONLINE EDITION, WINTER 2021
	* STARTER CODE FOR ASSIGNMENT 3
	* 
	* This code was developed by Dr. Raghav V. Sampangi (raghav@cs.dal.ca)
	*
	* User profile page
	*/

	require_once "includes/header.php";
    require_once "login-access-check.php";
	require_once "includes/db.php";
    require_once "includes/function.php";

// Melonie Park
// when user submits the form to change the password.
if (isset($_POST["change-password"])){

    if (isset($dbconnection)){
        //sanitize the input first
        $password = sanitizeDbInput($_POST["jedi-pswd"], $dbconnection);
        $username = $_SESSION["username"];

        //update password
        $querySQL = "UPDATE jediuser SET password = '$password' WHERE username = '$username' ";

        $result = $dbconnection->query($querySQL);

        //display confirm or error message on password update.
        if ($result === true){
            $_SESSION["password"] = $password;
            header("location: profile.php?update=1");
        }
        else{
            header("location: profile.php?update=0");
        }
    }
}
?>
        <main id="pg-main-content" style="min-height: 40em">
			<div class="py-5 text-center container">
				<div class="row">
					<div class="col-lg-6 col-md-8 mx-auto">
						<h1 class="fw-light">Jedi Blog: Your Profile</h1>
					</div>
				</div>
			</div>

            <?php
            //if login successful and welcome was set, display welcome message to the user. 
                if (isset($_GET["welcome"]) && isset($_SESSION["full-name"])){
                    $full_name = $_SESSION["full-name"];
                    echo "<h4 class='text-success text-center'>Hi $full_name, welcome back!</h4>";
                }
            ?>
			<div class="py-5 text-center container">
				<div class="row">
					<div class="col-lg-6 col-md-8 mx-auto">
						<p class="lead">Full Name: <span class="text-muted"><?php
                            // Set the full name in the disabled form.
                            if (isset($_SESSION["full-name"])){
                                echo $_SESSION["full-name"];
                            }
                            ?></span>
                    </div>
				</div>
                <div class="row">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <p class="lead">Email address: <span class="text-muted"><?php
                            // Set the full name in the disabled form.
                            if (isset($_SESSION["email"])){
                                echo $_SESSION["email"];
                            }
                            ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <p class="lead">Followed by: <a href ="users.php#ls-followers" class="text-info"><?php
                            // Number of followers
                                $username = $_SESSION['username'];
                                if (isset($dbconnection)){
                                    // Select the number of folloers.
                                    $sql = "SELECT COUNT('follower_username') as count FROM jedifollowing WHERE username = '$username'";
                                    $result = $dbconnection->query($sql);

                                    // Check if there is any error in executing the query.
                                    if ($result){
                                        $row = $result->fetch_assoc();
                                        $follower_count = $row['count'];
                                        echo $follower_count;
                                    }
                                    else{
                                        die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
                                    }
                                }
                            ?> people</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <p class="lead">Following: <a href ="users.php#ls-following" class="text-info"><?php
                                // Number of followers
                                $username = $_SESSION['username'];
                                if (isset($dbconnection)){
                                    // Select the number of authors the user follows.
                                    $sql = "SELECT COUNT('username') as count FROM jedifollowing WHERE follower_username = '$username'";
                                    $result = $dbconnection->query($sql);

                                    // Check if there is any error in executing the query.
                                    if ($result){
                                        $row = $result->fetch_assoc();
                                        $follower_count = $row['count'];
                                        echo $follower_count;
                                    }
                                    else{
                                        die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
                                    }
                                }
                                ?> people</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mx-auto">
                        <!-- Bootstrap disabled form available here: https://getbootstrap.com/docs/4.0/components/forms/#disabled-forms
                        Date accessed: 14 March 2021 -->
                        <!-- Display the disabled form with the user's username and password -->
                        <form class="form-horizontal form-container" method="post" action="#">
                            <fieldset disabled>
                                <div class="form-group lead row justify-content-md-center">
                                    <label for="username" class="col-sm-4">Username:</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="username" class="form-control" placeholder="username" value="<?php
                                        // Set the username in the disabled form.
                                        if (isset($_SESSION["username"])){
                                            echo $_SESSION["username"];
                                        }
                                        ?>">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group lead row justify-content-md-center">
                                    <label for="password" class="col-sm-4">Password:</label>
                                    <div class="col-sm-8">
                                        <input type="password" id="password" name="jedi-pswd" class="form-control" placeholder="password" value="<?php
                                        // Set the password in the disabled form.
                                        if (isset($_SESSION["password"])){
                                            echo $_SESSION["password"];
                                        }
                                        ?>">
                                    </div>
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-primary my-4" name="change-password">Change password</button>
                        </form>
                    </div>
                </div>
                <?php
                // If the page has been reloaded after updating the password, print the updating status.
                if (isset($_GET['update'])){
                    if ($_GET['update']){
                        echo "<p class='lead text-primary text-center'>Password updated successfully!</p>";
                    }
                    else{
                        echo "<p class='lead text-danger text-center'>Error updating password!</p>";
                    }
                }
                ?>
			</div>

            <div class="container">
                <h2 class='fw-light pt-4'>Your tweeps</h2>
                <hr>
                <?php
                // Display all the tweeps from the user.
                $username = $_SESSION['username'];
                // Check for database connection
                if (isset($dbconnection)){
                    // Select all posts from jeditweeps where the posts are not shared.
                    $sql = "SELECT * FROM tweep WHERE username = '$username' and isShared = 0";
                    $result = $dbconnection->query($sql);

                    // Check if there is any error in executing the query.
                    if ($result){

                        // Check if there is any result from the search
                        if ($result->num_rows !== 0){
                            displayDbTweeps($result, "profile");
                        }
                        // error message.
                        else{
                            echo "<p>There are no tweeps from you. Please post a new tweep.</p>";
                        }
                    }
                    // If $result is false, return the error when executing the query.
                    else{
                        die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
                    }

                    // select all posts from jeditweeps where the posts are shared.
                    $sql = "SELECT * FROM tweep WHERE username = '$username' and isShared = 1";
                    $result = $dbconnection->query($sql);

                    // Check if there is any error in executing the query.
                    if ($result){

                        // Check if there is any result from the search
                        if ($result->num_rows !== 0){
                            displayDbTweeps($result, "shared");
                        }
                    }
                    // If $result is false, return the error when executing the query.
                    else{
                        die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
                    }
                }
                ?>
            </div>
		</main>

<?php
	require_once "includes/footer.php";
?>