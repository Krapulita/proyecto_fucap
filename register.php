<?php
// register.php

// Check if the user has submitted the registration form
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    // Validate the username, password, and email
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Assume this is your database connection
    $db = new mysqli('localhost', 'username', 'password', 'database');

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Hash the password using password_hash()
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the query to insert the new user
    $stmt = $db->prepare("INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password_hash, $email);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        echo 'Registration successful!';
    } else {
        echo 'Registration failed!';
    }

    $stmt->close();
    $db->close();
}
?>