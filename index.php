<?php
    /*
    This code to implement the database connection feature has been used with some modification from the submission
    for Assignment 3 by Student Nhi Ly in CSCI 2170 (Winter 2021).
    Nhi Ly, Assignment 3: CSCI 2170 (Winter 2021), Faculty of Computer Science,
    Dalhousie University. Available online on Gitlab at [URL]:
    https://git.cs.dal.ca/courses/2021-winter/csci-2170/a3/nly.
    Date accessed: 21 Mar 2021.
    */

    require_once "includes/header.php";
    require_once "includes/db.php";
    require_once "includes/function.php";

    // If the user has not logged in, redirect them to the login page.
    if (!isset($_SESSION["username"])){
        header("Location: jedi-login.php");
    }
    else {
?>
		<main id="pg-main-content">
			<div class="py-5 text-center container">
				<div class="row">
					<div class="col-lg-6 col-md-8 mx-auto">
						<h1 class="fw-light">Jedi Tweep</h1>
						<p class="lead text-muted">Share your Jedi knowledge through tweeps!</p>
						<p class="lead text-muted">Sith, keep away!</p>
					</div>
				</div>
			</div>

			<div class="container">
				<form class="col-lg-6 col-md-8 mx-auto" method="post" action="#">
                    <?php
                    // If the user has been redirected after submitting their blogs, print the submitting status.
                    if (isset($_GET['blog-submit'])){
                        if ($_GET['blog-submit']){
                            echo "<p class='lead text-primary text-center'>Your tweep was submitted successfully!</p>";
                        }
                        else{
                            echo "<p class='lead text-danger text-center'>Your tweep fails to be submitted!</p>";
                        }
                    }
                    ?>
					<!-- Postback and perform search here in this file -->
					<input class="form-control" type="text" placeholder="Search" aria-label="Search" name="search-keywords">
					<div class="space-above-below">
						<div>
							<input type="radio" class="form-check-input" name="search-type" id="search-type-name" value="username" checked>
							<label for="search-type-name" class="text-muted">Search by author's username</label>
						</div>
						<div>
							<input type="radio" class="form-check-input" name="search-type" id="search-type-blog" value="full_name">
							<label for="search-type-blog" class="text-muted">Search by author's name</label>
						</div>
					</div>
				</form>
                    <?php
                    /*
                    This code to implement blog data retrieval, display and search has been used with some
                    modification from my submission for Assignment 2 in CSCI 2170 (Winter 2021).
                    Nhi Ly, Assignment 2: CSCI 2170 (Winter 2021), Faculty of Computer Science,
                    Dalhousie University. Available online on Gitlab at [URL]:
                    https://git.cs.dal.ca/courses/2021-winter/csci-2170/a2/nly.git
                    Date accessed: Mar 13 2021.
                    */

                    // If the user enters anything in the search field, only display what is requested.
                    if (isset($_POST["search-keywords"])){
                        echo "<h2 class='fw-light pt-4'>Search Results</h2>";
                        echo "<hr>";

                        $searchType = $_POST["search-type"];
                        $searchKeyWords = $_POST["search-keywords"];

                        // Check for database connection
                        if (isset($dbconnection)){
                            // Sanitize the search keywords
                            $searchKeyWords = sanitizeDbInput($searchKeyWords, $dbconnection);
                            $searchKeyWords = escapeWildcards($searchKeyWords);

                            // Construct sql statement based on the the search type (jedi_author and jedi_post_title)
                            $sql = "SELECT * FROM tweep WHERE $searchType LIKE CONCAT('%',?,'%')";
                            // Prepare the sql statement.
                            $prepared = $dbconnection->prepare($sql);
                            $prepared->bind_param('s', $searchKeyWords);
                            $prepared->execute();
                            $result = $prepared->get_result();

                            // Check if there is any error in executing the query.
                            if ($result){

                                // Check if there is any result from the search
                                if ($result->num_rows !== 0){
                                    displayDbTweeps($result, "index");
                                }
                                // error message.
                                else{
                                    echo "<p>Sorry, no posts available for your search. Try searching with another keyword.</p>";
                                }
                                $prepared->close();
                            }
                            else{
                                die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
                            }
                        }
                    }
                    // Default: display the tweeps from the people the user follows when the user has not searched for anything.
                    // As currently we don't have the follow table, I just display the user's tweeps, not from the users they follow.
                    // To be implemented.
                    else{
                        echo "<h2 class='fw-light pt-4'>Tweeps from people you follow</h2>";
                        echo "<hr>";

                        $username = $_SESSION['username'];

                        // Check for database connection
                        if (isset($dbconnection)){
                            // Select all posts from jeditweeps from the authors the user follow.
                            $sql = "SELECT * FROM tweep WHERE username IN (SELECT username FROM jedifollowing WHERE follower_username = '{$username}')";
                            $result = $dbconnection->query($sql);

                            // Check if there is any error in executing the query.
                            if ($result){

                                // Check if there is any result from the search
                                if ($result->num_rows !== 0){
                                    displayDbTweeps($result, "index");
                                }
                                // error message.
                                else{
                                    echo "<p>There are no tweeps from the people you follow</p>";
                                }
                            }
                            else{
                                die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
                            }
                        }
                    }
                    ?>
            </div>
		</main>
<?php
    }//end of login else
	require_once "includes/footer.php";
?>