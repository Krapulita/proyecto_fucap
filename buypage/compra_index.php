<?php
// Connect to the database
$servername = "localhost";
$username = "Sebadmin";
$password = "5(JrO6ddM!Qp]g[-";
$dbname = "tuercas";
$conn = mysqli_connect("localhost", "Sebadmin", "5(JrO6ddM!Qp]g[-", "tuercas");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the car brands
$brands_query = "SELECT * FROM brands";
$brands_result = mysqli_query($conn, $brands_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Repair Parts | Find the right parts for your vehicle</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Add styles for the image and banner */
    .header-image {
      width: 100px;
      height: 50px;
      margin: 10px;
    }
    .banner {
      width: 200px;
      height: 500px;
      position: fixed;
      top: 50px;
      right: 10px;
    }
  </style>
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </nav>
    <!-- Add space for the header image -->
    <img src="header-image.jpg" alt="Header Image" class="header-image">
  </header>

  <main>
    <section class="hero">
      <h1>Find the right repair parts for your vehicle</h1>
      <p>Enter your vehicle's brand and model to search for repair parts</p>
    </section>

    <section class="search-form">
      <form method="post">
        <div class="form-group">
          <label for="brand">Vehicle Brand:</label>
          <select id="brand" name="brand" onchange="getModelOptions(this.value)">
            <option value="">Select a brand</option>
            <?php while ($brand = mysqli_fetch_assoc($brands_result)) { ?>
              <option value="<?php echo $brand["id"]; ?>"><?php echo $brand["name"]; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="model">Vehicle Model:</label>
          <select id="model" name="model">
            <option value="">Select a model</option>
          </select>
        </div>
        <button type="submit">Search</button>
      </form>
    </section>

    <?php if (isset($_POST["brand"]) && isset($_POST["model"])) { ?>
    <section class="search-results">
      <h2>Search Results</h2>
      <table>
        <tr>
          <th>Part Name</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        <?php
        $brand_id = $_POST["brand"];
        $model_id = $_POST["model"];

        // Retrieve the repair parts for the selected car brand and model
        $brand_model_parts_query = "
          SELECT p.*
          FROM parts p
          JOIN brand_models_parts bmp ON p.id = bmp.part_id
          JOIN models m ON bmp.brand_model_id = m.id
          WHERE m.brand_id = $brand_id AND m.id = $model_id
        ";
        $brand_model_parts_result = mysqli_query($conn, $brand_model_parts_query);

        while ($part = mysqli_fetch_assoc($brand_model_parts_result)) { ?>
        <tr>
          <td><?php echo $part["name"]; ?></td>
          <td>$<?php echo $part["price"]; ?></td>
          <td><button type="button">Add to Cart</button></td>
        </tr>
        <?php } ?>
      </table>
    </section>
    <?php } ?>
  </main>

  <!-- Add space for the banner -->
  <img src="banner.jpg" alt="Banner" class="banner">

  <footer>
    <p>&copy; 2023 Repair Parts | All Rights Reserved</p>
  </footer>

  <script>
    function getModelOptions(brandId) {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'get-models.php?brand_id=' + brand
