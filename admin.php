<?php
/*
Administrator's page - Process creating new user account
Melonie Park
*/

require_once "includes/header.php";
require_once "login-access-check.php";
require_once "includes/db.php";
require_once "includes/function.php";

if (!$_SESSION["is-admin"]){
    // If the user tries to access this page without an admin right
    // Redirect without display an error message.
    header("Location: index.php");
}
?>
<main id="pg-main-content" style="min-height: 40em">
    <div class="py-5 text-center container">
        <div class="row">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Jedi Tweep: Admin page</h1>
                <p class="lead text-muted">Create and delete accounts here.</p>
                <p class="lead text-muted">Sith, keep away!</p>
                <?php
                    // If the page has been reloaded after inserting the new user, print the updating status.
                    if (isset($_GET['update'])){
                        if ($_GET['update']){
                            echo "<p class='lead text-primary text-center'>New user created successfully!</p>";
                        }
                        else{
                            echo "<p class='lead text-danger text-center'>Error creating new user!</p>";
                        }
                    }
                ?>

            </div>
        </div>
    </div>
    <!-- display all the account and its information -->
    <div class="py-5 container text-center">
        <h2 class='fw-light pt-4'>All accounts</h2>
        <hr>
        <form method="post" action="includes/process-account.php">
            <table class="table table-striped table-dark table-hover table-sm">
                <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Admin</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Check for database connection
                if (isset($dbconnection)){
                    // Select all posts from jeditweeps
                    $sql = "SELECT * FROM jediuser";
                    $result = $dbconnection->query($sql);

                    // Check if there is any error in executing the query.
                    if ($result){

                        // Check if there is any result from the search
                        if ($result->num_rows !== 0){
                            displayDbUsers($result);
                        }
                        // error message.
                        else{
                            echo "<p>There are no accounts in the database</p>";
                        }
                    }
                    else{
                        die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
                    }
                }
                ?>
                </tbody>
            </table>
        <!-- form gets user input necessary for creating new user account. --> 
        </form>
        <h2 class='fw-light pt-4'>Add a new account</h2>
        <hr>
        <form method="post" action="includes/process-account.php">
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-10">
                    <label for="admin-username">Username<input type="text" id="admin-username" class="form-control" name="username" placeholder="Enter username" required></label>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-10">
                    <label for="admin-password">Password<input type="password" id="admin-password" class="form-control" name="password" placeholder="Enter password" required></label>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-10">
                    <label for="admin-firstname">First name<input type="text" id="admin-firstname" class="form-control" name="firstname" placeholder="Enter the first name" required></label>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-10">
                    <label for="admin-lastname">Last name<input type="text" id="admin-lastname" class="form-control" name="lastname" placeholder="Enter the last name" required></label>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-10">
                    <label for="admin-email">Email address<input type="text" id="admin-email" class="form-control" name="email" placeholder="Enter the email" required></label>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-10">
                    <label for="admin-right">Admin</label>
                    <input class="form-check-input" type="checkbox" id ="admin-right" name="admin-right" value="yes">
                </div>
            </div>
            <div class="row my-3">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <button type="submit" name="admin-account" class="btn btn-primary" style="min-width: 4em">Add</button>
                </div>
            </div>
        </form>

    </div>
</main>
<?php
require_once "includes/footer.php";
?>