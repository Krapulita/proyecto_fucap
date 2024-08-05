<?php
require_once 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM car_parts WHERE id = $id";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: ". $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
     ?>
        <h2>Editar Pieza de Coche</h2>
        <form action="update_part.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <label for="part_name">Nombre de la Pieza:</label>
            <input type="text" name="part_name" value="<?php echo $row["part_name"];?>"><br><br>
            <label for="part_number">Numero de la Pieza:</label>
            <input type="text" name="part_number" value="<?php echo $row["part_number"];?>"><br><br>
            <label for="price">Precio:</label>
            <input type="number" name="price" value="<?php echo $row["price"];?>"><br><br>
            <label for="quantity">Cantidad:</label>
            <input type="number" name="quantity" value="<?php echo $row["quantity"];?>"><br><br>
            <label for="description">Descripcion:</label>
            <textarea name="description"><?php echo $row["description"];?></textarea><br><br>
            <input type="submit" value="Actualizar Pieza">
        </form>
        <?php
    } else {
        echo "Pieza de coche no encontrada!";
    }
} else {
    echo "No se ha proporcionado un ID de pieza!";
}
?>