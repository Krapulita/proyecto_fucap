<?php

// Database connection
$host = 'localhost';
$dbname = 'reservations';
$user = 'root';
$password = '';

// Connect to the database
$conn = mysqli_connect("localhost", "username", "password", "appointments");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Function to register a new user
function register_user($name, $email, $password) {
  $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
  if (mysqli_query($conn, $sql)) {
    return true;
  } else {
    return false;
  }
}

// Function to login a user
function login_user($email, $password) {
  $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    return true;
  } else {
    return false;
  }
}

// Close the database connection
mysqli_close($conn);
?>