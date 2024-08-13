<?php
// Include the search.php file
include 'search.php';

// Create a form for searching
echo '<form action="search.php" method="get">
  <input type="text" name="q" placeholder="Search...">
  <select name="brand_id">
    <option value="">Select Brand</option>';
    // Retrieve brands from the database
    $brands_query = "SELECT * FROM brands";
    $brands_result = mysqli_query($conn, $brands_query);
    while ($brand = mysqli_fetch_assoc($brands_result)) {
      echo '<option value="' . $brand['id'] . '">' . $brand['name'] . '</option>';
    }
    echo '</select>
  <select name="model_id">
    <option value="">Select Model</option>';
    // Retrieve models from the database
    $models_query = "SELECT * FROM models";
    $models_result = mysqli_query($conn, $models_query);
    while ($model = mysqli_fetch_assoc($models_result)) {
      echo '<option value="' . $model['id'] . '">' . $model['name'] . '</option>';
    }
    echo '</select>
  <input type="submit" value="Search">
</form>';

// Display search results if search query is provided
if (isset($_GET['q'])) {
  $search_results = search($_GET['q'], $_GET['brand_id'], $_GET['model_id']);
  if (count($search_results) > 0) {
    echo '<h2>Search Results</h2>';
    echo '<ul>';
    foreach ($search_results as $result) {
      echo '<li>' . $result['name'] . ' - ' . $result['description'] . ' - ' . $result['price'] . '</li>';
    }
    echo '</ul>';
  } else {
    echo '<p>No results found.</p>';
  }
}
?>