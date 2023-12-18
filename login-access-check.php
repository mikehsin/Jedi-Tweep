<?php
// Eh, this file is different from the access check in the includes folder.
// This prevents the user from access other files like profile.php
// if they have not logged in.
if (!isset($_SESSION["username"])){
    header("Location: jedi-login.php?noaccess=1");
    die;
}