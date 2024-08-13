<?php
include 'database.php';

$brandId = $_GET['brand_id'];
$modelId = $_GET['model_id'];

$query = "SELECT b.name AS brand_name, m.name AS model_name 
           FROM models m 
           INNER JOIN brands b ON m.brand_id = b.id 
           WHERE m.id = '$modelId' AND b.id = '$brandId'";
$result = mysqli_query($conn, $query);

$searchResults = array();
while ($row = mysqli_fetch_assoc($result)) {
  $searchResults[] = $row;
}

echo json_encode($searchResults);
?>