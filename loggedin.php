<?php
// loggedin.php

session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
    $loggedin = true;
    $username = $_SESSION['username'];
    $user_email = $_SESSION['user_email'];
} else {
    $loggedin = false;
}

// Function to display logged in user information
function display_loggedin_user() {
    if ($loggedin) {
        echo "Welcome, $username ($user_email)!";
    } else {
        echo "You are not logged in";
    }
}

// Function to check if user is logged in
function is_loggedin() {
    return $loggedin;
}
?>