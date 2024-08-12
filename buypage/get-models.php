<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tuercas";
$conn = mysqli_connect("localhost", "root", "", "tuercas");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the brand ID from the GET request
$brand_id = $_GET["brand_id"];

// Retrieve the car models for the selected brand
$models_query = "SELECT * FROM models WHERE brand_id = $brand_id";
$models_result = mysqli_query($conn, $models_query);

// Generate the HTML options for the car models
$model_options = "<option value=''>Select a model</option>";
while ($model = mysqli_fetch_assoc($models_result)) {
  $model_options .= "<option value='" . $model["id"] . "'>" . $model["name"] . "</option>";
}

// Output the HTML options
echo $model_options;
?>