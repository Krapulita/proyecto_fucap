<?php
require_once 'db.php';

$sql = "SELECT * FROM car_parts";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: ". $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventario de Piezas de Coche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
      .container {
            width: 80%;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
      .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
      .header h2 {
            margin: 0;
        }
      .table-container {
            overflow-x: auto;
        }
        #inventory-table {
            width: 100%;
            border-collapse: collapse;
        }
        #inventory-table th, #inventory-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        #inventory-table th {
            background-color: #f0f0f0;
        }
      .button-container {
            text-align: center;
            margin-top: 20px;
        }
      .btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
      .btn:hover {
            background-color: #3e8e41;
        }
      .dropdown {
            position: relative;
            display: inline-block;
        }
      .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
      .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
      .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
      .dropdown:hover.dropdown-content {
            display: block;
        }
      .dropdown:hover.btn {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Inventario de Piezas de Coche</h2>
        </div>
        <div class="table-container">
            <table id="inventory-table">
                <tr>
                    <th>Nombre de la Pieza</th>
                    <th>Numero de la Pieza</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                </tr>
                <?php if ($result->num_rows > 0) {?>
                    <?php while($row = $result->fetch_assoc()) {?>
                        <tr>
                            <td><?php echo $row["part_name"];?></td>
                            <td><?php echo $row["part_number"];?></td>
                            <td><?php echo $row["price"];?></td>
                            <td><?php echo $row["quantity"];?></td>
                            <td><?php echo $row["description"];?></td>
                            <td>
                                <a href="edit_part.php?id=<?php echo $row["id"];?>">Editar</a>
                            </td>
                        </tr>
                    <?php }?>
                <?php } else {?>
                    <tr><td colspan='6'>No car parts in the inventory!</td></tr>
                <?php }?>
            </table>
        </div>
        <div class="button-container">
    <a href="add_part.html" class="btn">Agregar Pieza de Coche</a>
    <a href="index.html" class="btn">Volver al Inicio</a>
</div>
    </div>
</body>
</html>