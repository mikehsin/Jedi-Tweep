<?php
require_once "includes/header.php";
require_once "login-access-check.php";
require_once "includes/db.php";
require_once "includes/function.php";
?>
<main id="pg-main-content" style="min-height: 40em">
    <div class="py-5 container">
        <div class="row">
            <h2 class='fw-light pt-4'>List of users</h2>
            <hr>
        </div>
        <!-- To be implemented -->
        <div class="row" id="ls-followers">
            <h4 class='fw-light mt-4 py-1 bg-primary text-white'>List of followers</h4>
        </div>
        <?php
        $username = $_SESSION['username'];
        if (isset($dbconnection)){
            // Select all followers of username.
            $sql = "SELECT * FROM jedifollowing WHERE username = '$username'";
            $result = $dbconnection->query($sql);

            // Check if there is any error in executing the query.
            if ($result){
                // Check if there is any result from the search
                if ($result->num_rows !== 0){
                    displayFollowers($result);
                }
                // error message.
                else{
                    echo "<p>You have no followers. How unfortunate!</p>";
                }
            }
            else{
                die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
            }
        }
        ?>

        <div class="row" id="ls-following">
            <h4 class='fw-light mt-4 py-1 bg-success text-white'>List of users I follow</h4>
        </div>
        <?php
        $username = $_SESSION['username'];
        if (isset($dbconnection)){
            // Select all followers of username.
            $sql = "SELECT * FROM jedifollowing WHERE follower_username = '$username'";
            $result = $dbconnection->query($sql);

            // Check if there is any error in executing the query.
            if ($result){
                // Check if there is any result from the search
                if ($result->num_rows !== 0){
                    displayFollowingUsers($result);
                }
                // error message.
                else{
                    echo "<p>You have no authors that you follow.</p>";
                }
            }
            else{
                die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
            }
        }
        ?>
        <!-- Not implemented features. This is just an interface.  -->
        <!--
        <div class="row">
            <h4 class='fw-light mt-4 py-1 bg-danger text-white'>List of users I block</h4>
        </div>
        <div class="row">
            <div class="col-sm-4 lead my-2">
                Luke
            </div>
            <div class="col-sm-8">
                <button type="button" class="btn btn-success">Unblock</button>
            </div>
        </div>
        -->
        <div class="row">
            <h4 class='fw-light mt-4 py-1 bg-dark text-white'>Users you can follow</h4>
        </div>
        <?php
        $username = $_SESSION['username'];
        if (isset($dbconnection)){
            // Select all followers of username.
            $sql = "SELECT username FROM jediuser WHERE username NOT IN (SELECT username FROM jedifollowing WHERE follower_username = '{$username}') AND username != '$username'";
            $result = $dbconnection->query($sql);

            // Check if there is any error in executing the query.
            if ($result){
                // Check if there is any result from the search
                if ($result->num_rows !== 0){
                    displayUsersYouCanFollow($result);
                }
                // error message.
                else{
                    echo "<p class='lead my-2'>No users you can follow.</p>";
                }
            }
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
