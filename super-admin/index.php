<?php

// Check if user ID and email session variables are not set
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {



    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    // Redirect to login page
    header("Location: login.php");
    exit();

} else {
    if ($_SESSION['admin_rights'] != 1) {
        // Unset all of the session variables
        header("Location: ../access-denied.php");
        exit();
    } else {

        header("Location: academics/", true, 301);
        exit();

    }
}

?>