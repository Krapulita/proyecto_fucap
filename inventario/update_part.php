<?php
// update_part.php

require_once 'db.php';

if (isset($_POST['id']) && isset($_POST['part_name']) && isset($_POST['part_number']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_POST['description'])) {
    $id = $_POST['id'];
    $part_name = $_POST['part_name'];
    $part_number = $_POST['part_number'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    $sql = "UPDATE car_parts SET part_name = '$part_name', part_number = '$part_number', price = $price, quantity = $quantity, description = '$description' WHERE id = $id";
    $result = $conn->query($sql);

    if ($result) {
        echo "Pieza de coche actualizada con éxito!";
    } else {
        echo "Error al actualizar pieza de coche: ". $conn->error;
    }
} else {
    echo "No se han proporcionado todos los campos necesarios!";
}
?>