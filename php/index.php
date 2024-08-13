<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php', true, 302);
    exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Conectar a la base de datos
$servername = "localhost";
$db_username = "kradmin";
$db_password = "452.Krapu";
$dbname = "bdd_usuarios";
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Get user profile information
$stmt = $conn->prepare("SELECT nombre, apellidos, correo_electronico FROM usuarios WHERE id = ?");
if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    echo "Error executing statement: " . $stmt->error;
    exit;
}

$stmt->bind_result($name, $lastname, $email);
$stmt->fetch();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <h1>Perfil de usuario</h1>
        </div>
        <div class="profile-content">
            <h2>Información de perfil</h2>
            <p>Nombre: <?php echo $name; ?></p>
            <p>Apellido: <?php echo $lastname; ?></p>
            <p>Correo electrónico: <?php echo $email; ?></p>
            <p>Username: <?php echo $username; ?></p>
            <p><a href="logout.php">Cerrar sesión</a></p>
        </div>
    </div>
</body>
</html>