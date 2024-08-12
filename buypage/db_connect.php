<?php
$servername = "localhost";
$username = "kradmin";
$password = "452.Krapu";
$dbname = "bdd_usuarios";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected to database successfully!";