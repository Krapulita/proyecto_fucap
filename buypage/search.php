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

// Retrieve the search query from the GET request
$search_query = $_GET["q"];

// Retrieve the brand and model IDs from the GET request
$brand_id = $_GET["brand_id"];
$model_id = $_GET["model_id"];

// Construct the search query
$query = "SELECT p.* FROM parts p
          LEFT JOIN brands b ON p.brand_id = b.id
          LEFT JOIN models m ON p.model_id = m.id
          WHERE 1=1";

// Add brand filter if brand ID is provided
if ($brand_id != "") {
  $query .= " AND p.brand_id = $brand_id";
}

// Add model filter if model ID is provided
if ($model_id != "") {
  $query .= " AND p.model_id = $model_id";
}

// Add search query filter
$query .= " AND (p.name LIKE '%$search_query%' OR p.description LIKE '%$search_query%')";

// Execute the search query
$result = mysqli_query($conn, $query);

// Generate the search results
$search_results = array();
while ($row = mysqli_fetch_assoc($result)) {
  $search_results[] = array(
    "id" => $row["id"],
    "name" => $row["name"],
    "description" => $row["description"],
    "price" => $row["price"]
  );
}

// Output the search results in JSON format
echo json_encode($search_results);
?>