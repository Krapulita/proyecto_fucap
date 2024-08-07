<?php
// add_part.php

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $part_name = $_POST["part_name"];
    $part_number = $_POST["part_number"];
    $price = floatval($_POST["price"]); // Convert input value to a float
    $quantity = intval($_POST["quantity"]); // Convert input value to an integer
    $description = $_POST["description"];

    $sql = "INSERT INTO car_parts (part_name, part_number, price, quantity, description) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $part_name, $part_number, $price, $quantity, $description);
    $stmt->execute();

    header("Location: inventory.php");
    exit;
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="part_name">Part Name:</label>
    <input type="text" id="part_name" name="part_name"><br><br>
    <label for="part_number">Part Number:</label>
    <input type="text" id="part_number" name="part_number"><br><br>
    <label for="price">Price:</label>
    <input type="text" id="price" name="price" placeholder="e.g. 10.99 or 500.00"><br><br>
    <label for="quantity">Quantity:</label>
    <input type="text" id="quantity" name="quantity"><br><br>
    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea><br><br>
    <input type="submit" value="Add Part">
</form>