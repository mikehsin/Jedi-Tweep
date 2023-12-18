<?php
require_once "access-check.php";
require_once "db.php";

if (isset($_SESSION["username"])){
    // If the user wants to unfollow an author, delete that author-user from the jedifollowing table.
    if (isset($_POST['submit-unfollow'])){
        if (isset($dbconnection)){
            $username = $_SESSION["username"];
            $following_author = $_POST["submit-unfollow"];
            // delete the author the user follow from the database.
            $sql = "DELETE FROM `jedifollowing` WHERE follower_username = '$username' AND username = '$following_author'";
            $result = $dbconnection->query($sql);
            // Go back to the users page.
            header("Location: ../users.php");
        }
    }
    // If the user wants to unfollow an author, add that author-user to the jedifollowing table.
    if (isset($_POST['submit-follow'])){
        if (isset($dbconnection)){
            $username = $_SESSION["username"];
            $following_author = $_POST["submit-follow"];
            // delete the author the user follow from the database.
            $sql = "INSERT INTO `jedifollowing` (`username`, `follower_username`) VALUES ('$following_author', '$username')";
            $result = $dbconnection->query($sql);
            header("Location: ../users.php");
        }
    }
}
header("Location: ../users.php");