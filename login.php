<?php
// login.php

// Check if the user has submitted the login form
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Validate the username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Assume this is your database connection
    $db = new mysqli('localhost', 'username', 'password', 'database');

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Prepare the query to retrieve the user's password hash
    $stmt = $db->prepare("SELECT password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password_hash = $row['password_hash'];

        // Verify the password using password_verify()
        if (password_verify($password, $password_hash)) {
            // Login successful, set the session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['user_email'] = $row['email'];

            // Redirect the user to the protected page
            header('Location: index.php');
            exit;
        } else {
            // Login failed, display an error message
            echo 'Invalid username or password';
        }
    } else {
        // Login failed, display an error message
        echo 'Invalid username or password';
    }

    $stmt->close();
    $db->close();
}
?>