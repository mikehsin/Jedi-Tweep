<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- JQuery source from stackoverflow -->
<?php
// Access control
require_once "access-check.php";

// List of functions that are used in the assignment.
/**
 * @param mysqli_result $result
 * @param string $type
 * There are current four types: index (posts on the homepage), post (post on the more details page)
 * profile (user's own posts on the profile page), shared (shared posts to the user's profile page)
 * @description a function for displaying the blogs from a sql select statement.
 */
function displayDbTweeps(mysqli_result $result, string $type)
{
    $id = 0;
    $post_per_row = 3;
    while ($row = $result->fetch_assoc()) {
        //retrieve data from the database
        $postID = $row['post_id'];
        $postName = $row['post_title'];
        $authorName = $row['full_name'];
        $postDate = $row['post_date'];
        $postContent = $row['post_content'];
        $likeNum = $row['likeNum'];
        $postCategory = $row['post_category'];

        // If we need to display the blog content on the post page, include the blog's category.
        if ($type == "post"){

            // If there is a request for no buttons, do not include them.
            // This is for the user's own posts.
            if (isset($_POST["no-button"])){
                $buttonDisplay = "";
            }
            else{
                //user the id variable to make btn and span dynamic
                $buttonDisplay = <<<END
                    <button id="likeBtn$id" type="submit" class="btn btn-danger" name="like" value="$likeNum|$postID"> Like <span id="likeId$id" class="badge bg-white text-dark"> $likeNum </span>
                    </button>
                    <button type="submit" class="btn btn-warning" name="share" value="$postName|$postCategory|$postContent">Share</button>
                END;
            }
            // Assemble the html string
            $resultDisplay = <<<END
                <div class="card border-dark">
                    <h4 class="card-header bg-dark text-white">Featured</h4>
                    <div class="card-body">
                        <h2 class="fw-light card-title">$postName</h2>
                        <hr>
                        <h5 class="fw-light card-subtitle py-1">Posted by $authorName on $postDate</h5>
                        <h6 class="fw-light card-subtitle py-1">Under the categories: $postCategory</h6>
                        <p class="text-muted card-text">$postContent</p>
                    </div>
                    <div class="card-footer bg-dark text-white">
                        <form method="post" action="tweep.php">
                            $buttonDisplay
                        </form>
                    </div>
                </div>
            END;
        }
        // If we need to display the blog content on the index or profile page, limit the content and include a "more details" button.
        else{
            // Limit the post content. The maximum length for a tweep is 240.
            $postContent = limitContent($postContent);

            // Calculate the width of each column
            $col_width = 12/$post_per_row;

            // For every fixed number of blogs, close the previous row and create a new row:
            if ($id % $post_per_row == 0){
                // If it is the first row, don't close the previous row.
                if ($id != 0){
                    echo '</div>';
                }
                echo '<div class="row my-3">';
            }
            // Assemble the html string for the buttons
            // If this is for the posts on the home page (from the authors the user follow)
            // or the shared post on the profile page, keep the like and share buttons.
            if ($type == "index" || $type == "shared"){
                //user the id variable to make btn and span dynamic
                $buttonDisplay = <<<END
                    <form method="post" action="process-like-share.php">
                        <button id="likeBtn$id" type="submit" class="btn btn-danger" name="like" value="$likeNum|$postID"> Like <span id="likeId$id" class="badge bg-white text-dark"> $likeNum </span>
                        </button>
                        <button type="submit" class="btn btn-warning" name="share" value="$postName|$postCategory|$postContent">Share</button>
                        <button type="submit" class="btn btn-info" name="full-article" value="$postID">More details &raquo;</button>
                    </form>
                END;

            }
            // If this is for the user's own posts on the profile page, only display the more details button.
            else {
                $buttonDisplay = <<<END
                    <button type="submit" class="btn btn-info" name="full-article" value="$postID">More details &raquo;</button>
                    <input type="hidden" name="no-button" value=1>
                END;
            }

            // Add the shared mark if the post is shared
            if ($type == "shared"){
                $shared = "<span class='badge bg-primary text-white'> Shared </span>";
            }
            else{
                $shared = "";
            }

            // Assemble the html string for the whole post
            $resultDisplay = <<<END
                <section id="result$id" class="py-2 space-above-below col-sm-$col_width">
                    <div class="card border-dark" style="min-height: 20em">
                        <div class="card-body">
                            <h4 class="fw-light">$postName</h4> $shared
                            <hr>
                            <h6 class="fw-light">Posted by $authorName on $postDate</h6>
                            <p class="text-muted">$postContent</p>
                        </div>
                        <div class="card-footer bg-dark text-white">
                            <form method="post" action="tweep.php">
                                $buttonDisplay
                            </form>
                        </div>
                    </div>
                </section>
            END;
        }
        // Display the html string
        echo $resultDisplay;

        // Increase the id for each blog by 1.
        $id++;
    }

    // Close the row div.
    if (!isset($_POST["full-article"])){
        echo '</div>';
    }
}

/**
 * @param $postContent
 * @return string
 * @description Limit the article content to a number of characters
 */
function limitContent($postContent): string
{
    // The maximum number of characters allowed on the index page
    $postLength = 150;

    // PHP substr: https://www.php.net/manual/en/function.substr
    // If the post is longer than the maximum number of characters allowed on the index page, cut it short.
    if (strlen($postContent) > $postLength) {
        $postContent = substr($postContent, 0, $postLength) . " ...";
    }
    return $postContent;
}

/**
 * @param $inputString
 * @param mysqli $dbconnection
 * @return string
 * @description sanitize the input before putting them into the database
 */
function sanitizeDbInput($inputString, mysqli $dbconnection): string
{
    $inputString = htmlspecialchars(stripslashes(trim($inputString)));
    $inputString = $dbconnection->real_escape_string($inputString);
    return $inputString;
}

/**
 * @param $string
 * @return string
 * @description escape the wildcard characters in sql. This function is used to sanitize data in search.
 */
function escapeWildcards($string): string
{
    // https://www.php.net/manual/en/function.str-replace.php
    $replace = str_replace('%', '[%]', $string);
    $replace = str_replace('_', '[_]', $replace);
    return $replace;
}

/*
* Session destroy functionality implemented based on the script available on PHP.net
* URL: https://www.php.net/manual/en/function.session-destroy.php
* Accessed on Mar 14, 2021
 */
function destroyCurrentSession()
{
    session_start();

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
}

// display database users for the admin page.
function displayDbUsers(mysqli_result $result)
{
    $id = 0;
    while ($row = $result->fetch_assoc()) {

        $username = $row['username'];
        $password = $row['password'];
        $full_name = $row['firstname'] . " " . $row['lastname'];
        $email = $row['email'];
        $checked = '';

        // Check if the user is an admin.
        if ($row['is_admin']){
            $checked = 'checked';
        }

        // Assemble the html string
        $resultDisplay = <<<END
            <tr id="result$id">
            <td>
            <input type="text" class="form-control" value = "$username" disabled>
            </td>
            <td>
            <input type="text" class="form-control" value = "$password" disabled>
            </td>
            <td>
            <input type="text" class="form-control" value = "$full_name" disabled>
            </td>
            <td>
            <input type="text" class="form-control" value = "$email" disabled>
            </td>
            <td>
            <input class="form-check-input" type="checkbox" $checked disabled>
            </td>
            </tr>
        END;
        echo $resultDisplay;

        $id++;
    }
}

// Display the followers from the database.
function displayFollowers(mysqli_result $result)
{
    // Assign id to each follower.
    $id = 0;

    // Fetch each row from the database and assemble the html code.
    while ($row = $result->fetch_assoc()) {

        $username = $row['follower_username'];

        // Assemble the html string
        $resultDisplay = <<<END
            <div class="row">
            <div class="col-sm-4 lead my-2">
                $username
            </div>
        </div>
        END;
        echo $resultDisplay;

        $id++;
    }
}

// Display the authors that the user follow
function displayFollowingUsers(mysqli_result $result)
{
    // Assign id to each follower.
    $id = 0;

    // Fetch each row from the database and assemble the html code.
    while ($row = $result->fetch_assoc()) {

        $username = $row['username'];

        // Assemble the html string
        $resultDisplay = <<<END
            <div class="row" id="following$id">
                <div class="col-sm-4 lead my-2">
                    $username
                </div>
                <div class="col-sm-8">
                <form method="post" action="includes/process-follow.php">
                    <button type="submit" class="btn btn-warning" name="submit-unfollow" value="$username">Unfollow</button>
                </form>
                </div>
            </div>
        END;
        echo $resultDisplay;

        $id++;
    }
}

function displayUsersYouCanFollow(mysqli_result $result)
{
    // Assign id to each follower.
    $id = 0;

    // Fetch each row from the database and assemble the html code.
    while ($row = $result->fetch_assoc()) {

        $username = $row['username'];

        // Assemble the html string
        $resultDisplay = <<<END
            <div class="row" id="userfollow$id">
            <div class="col-sm-4 lead my-2">
                $username
            </div>
            <div class="col-sm-8">
                <form method="post" action="includes/process-follow.php">
                    <button type="submit" class="btn btn-primary" name="submit-follow" value="$username">Follow</button>
                </form>
            </div>
        </div>
        END;
        echo $resultDisplay;

        $id++;
    }
}
?>

<script>
// Use JQuery to check the button click when the is ready
// jQuery(document).ready(function() {
//     $(function() {
//         $('button[type="button"]').click(function() { 
//             const msg = parseInt(document.getElementById(this.id).textContent.trim().replace("Like ", ""))+1
//             // get the current like number
//             const id = this.id.toString().replace("likeBtn", "") //find the id of the span
//             document.getElementById("likeId"+id).innerHTML = msg
//         });
//     });
// });
</script>
