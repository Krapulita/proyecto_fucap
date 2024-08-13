<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tuercas";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the brand ID from the GET request
$brand_id = $_GET["brand_id"];

// Retrieve models for the selected brand
$query = "SELECT * FROM models WHERE brand_id = $brand_id";
$result = mysqli_query($conn, $query);

// Generate the model options
$model_options = "";
while ($model = mysqli_fetch_assoc($result)) {
  $model_options .= "<option value='" . $model["id"] . "'>" . $model["name"] . "</option>";
}

// Output the model options
echo $model_options;

// Close the database connection
mysqli_close($conn);
?>