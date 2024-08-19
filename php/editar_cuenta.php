<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aquí irá el código para procesar el formulario
    // Asegúrate de validar y sanitizar los datos antes de actualizarlos
    // Actualiza la base de datos y la sesión con los nuevos datos
    $_SESSION['user_name'] = $_POST['name']; // Asegúrate de sanitizar esto
    // Actualiza también la base de datos aquí
    header('Location: index.php');
    exit;
}
?>

<form action="editar-cuenta.php" method="post">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>">
    
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>" readonly>
    
    <input type="submit" value="Guardar cambios">
</form>