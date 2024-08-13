<?php
session_start();

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

// Enable error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Iniciar sesión</h2>
            <?php if (isset($_SESSION['error_message'])) { ?>
                <p style="color: red;"><?php echo $_SESSION['error_message']; ?></p>
                <?php unset($_SESSION['error_message']); // remove the error message from the session ?>
            <?php } ?>
            <form action="" method="post">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Iniciar sesión">
            </form>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Obtener las credenciales del formulario
                $email = $_POST['email'];
                $password = $_POST['password'];

                // Validar la dirección de correo electrónico
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error_message'] = 'La dirección de correo electrónico es inválida.';
                    header('Location: login.php', true, 302);
                    exit;
                }

                // Buscar al usuario en la base de datos
                $stmt = $conn->prepare("SELECT contrasena, nombre_usuario, id FROM usuarios WHERE correo_electronico = ?");
                if (!$stmt) {
                    die("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($hashed_password, $username, $user_id);
                $stmt->fetch();

                // Verificar la contraseña
                if (password_verify($password, $hashed_password)) {
                    // Contraseña correcta
                    $_SESSION['user_email'] = $email;
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $user_id;
                    header('Location: index.php', true, 302);
                    exit;
                } else {
                    // Contraseña incorrecta
                    $_SESSION['error_message'] = 'La contraseña es incorrecta. Por favor, inténtelo de nuevo.';
                    header('Location: login.php', true, 302);
                    exit;
                }

                $stmt->close();
                $conn->close();
            } ?>
        </div>
    </div>
</body>
</html>