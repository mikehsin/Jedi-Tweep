<?php
	/*
	* CSCI 2170: ONLINE EDITION, WINTER 2021
	* STARTER CODE FOR ASSIGNMENT 3
	* 
	* This code was developed by Dr. Raghav V. Sampangi (raghav@cs.dal.ca)
	*
	* Website homepage
	*/

    require_once "includes/header.php";
    require_once "login-access-check.php";
    require_once "includes/db.php";
    require_once "includes/function.php";
?>
		<main id="pg-main-content">
			<div class="py-5 text-center container">
				<div class="row">
					<div class="col-lg-6 col-md-8 mx-auto">
						<h1 class="fw-light">Jedi Blog</h1>
						<p class="lead text-muted">Your one stop shop for all Jedi knowledge.</p>
						<p class="lead text-muted">Sith, keep away!</p>
					</div>
				</div>
			</div>

			<div class="container">
				<article class="space-above-below my-4">

                    <?php
                    // If there is a request for a full article, find that article's ID in the database and display it.
                    if (isset($_POST["full-article"])){

                        if (isset($dbconnection)){
                            // Select the requested article from jediblog
                            $postID = $_POST["full-article"];
                            $sql = "SELECT * FROM `tweep` WHERE post_id = $postID";
                            $result = $dbconnection->query($sql);

                            // Check if there is any error in executing the query.
                            if ($result){

                                // Check if there is any result from the search
                                if ($result->num_rows !== 0){
                                    displayDbTweeps($result, "post");
                                }
                                // error message.
                                else{
                                    echo "<p>This blog does not exist.</p>";
                                }
                            }
                            else{
                                die("Error executing query: ($dbconnection->errno) $dbconnection->error<br>SQL = $sql");
                            }
                        }
                    }
                    // Mike
                    else if (isset($_POST["share"])) {
                        //retrieve the author name
                        $postAuthorUsername = $_SESSION["username"];
                        $postDate = date("Y-m-d"); //get current date
                        $post = $_POST["share"]; //retrieve the value

                        //separate the post title, category, and the content
                        $postTitle = explode("|", $post)[0];
                        $postCategory = explode("|", $post)[1];
                        $postContent = explode("|", $post)[2];
                        //explode function retrieved from the php.net

                        // Check for database connection
                        if (isset($dbconnection)) {
                            // Check if the post is already shared
                            // I will check for the post title and isShared mark to identify whether the post has already been shared.
                            $sql = "SELECT post_title, username from jeditweep WHERE username = '$postAuthorUsername' AND post_title = '$postTitle' AND isShared = 1";
                            $result = $dbconnection->query($sql);

                            // If there is no shared post with that title, insert it into the database.
                            if ($result->num_rows == 0) {
                                //insert data to the database
                                $sql = "INSERT INTO `jeditweep` (`username`, `post_date`, `post_category`, `post_title`, `post_content`, likeNum, isShared) 
                            VALUES ('$postAuthorUsername', '$postDate', '$postCategory', '$postTitle', '$postContent', 0, 1)";
                                //the post has not like number but it's shared
                                mysqli_query($dbconnection, $sql);
                            }

                            //display the post again --aka refresh the post display
                            $sql = "SELECT * FROM `tweep` where username = '$postAuthorUsername' and isShared = 0";
                            $result = $dbconnection->query($sql);
                            displayDbTweeps($result, "profile");

                            // Display the shared mark on the posts that are shared.
                            $sql = "SELECT * FROM `tweep` where username = '$postAuthorUsername' and isShared = 1";
                            $result = $dbconnection->query($sql);
                            displayDbTweeps($result, "shared");
                        }
                    }
                    else if(isset($_POST["like"])) {
                        //retrieve username
                        $postAuthorUsername = $_SESSION["username"];
                        //retrieve the value
                        $post = $_POST["like"];
                        //separate the like number and the post ID
                        $likeNum = explode("|", $post)[0]+1;
                        $postId = explode("|", $post)[1];
                        //explode function retrieved from the php.net
                        
                        //save data to the database
                        $sql = "UPDATE `jeditweep` SET `likeNum` = $likeNum WHERE `post_id`=$postId";
                        if (isset($dbconnection)){
                            mysqli_query($dbconnection, $sql);

                            // redirect to the index page.
                            $sql = "SELECT * FROM tweep WHERE username IN (SELECT username FROM jedifollowing WHERE follower_username = '{$postAuthorUsername}')";
                            $result = $dbconnection->query($sql);
                            displayDbTweeps($result, "index");
                        }
                    }
                    ?>
                </article>
			</div>
		</main>
<?php
	require_once "includes/footer.php";
?>