<!-- index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Repair Parts | Find the right parts for your vehicle</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </nav>
    <form>
      <div class="form-group">
        <label for="brand">Vehicle Brand:</label>
        <select id="brand" name="brand">
          <option value="">Select a brand</option>
          <option value="Toyota">Toyota</option>
          <option value="Ford">Ford</option>
          <option value="Honda">Honda</option>
          <!-- add more brands here -->
        </select>
      </div>
      <div class="form-group">
        <label for="model">Vehicle Model:</label>
        <input type="text" id="model" name="model" placeholder="Enter your vehicle's model">
      </div>
      <button type="submit">Search</button>
    </form>
  </header>

  <section class="hero">
    <h1>Find the right repair parts for your vehicle</h1>
    <p>Enter your vehicle's brand and model to search for repair parts</p>
    <button>Learn More</button>
  </section>

  <section class="search-results">
    <h2>Search Results</h2>
    <table>
      <tr>
        <th>Part Name</th>
        <th>Price</th>
        <th>Availability</th>
        <th>Action</th>
      </tr>
      <tr>
        <td>Oil Filter</td>
        <td>$10.99</td>
        <td>In Stock</td>
        <td><button type="button">Add to Cart</button></td>
      </tr>
      <tr>
        <td>Air Filter</td>
        <td>$15.99</td>
        <td>Out of Stock</td>
        <td><button type="button">Notify Me</button></td>
      </tr>
      <!-- add more search results here -->
    </table>
  </section>

  <section class="cart-summary">
    <h2>Cart Summary</h2>
    <ul>
      <li>Oil Filter ($10.99)</li>
      <li>Air Filter ($15.99)</li>
      <!-- add more cart items here -->
    </ul>
    <p>Subtotal: $26.98</p>
    <button type="button">Checkout</button>
  </section>

  <footer>
    <p>&copy; 2023 Repair Parts | All Rights Reserved</p>
  </footer>

</body>
</html>