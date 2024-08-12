<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que esta ruta sea correcta

use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Configuración de la base de datos
$servername = "localhost";
$username = "kradmin";
$password = "452.Krapu";
$dbname = "bdd_usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    // Buscar el token en la base de datos y verificar que sea válido
    $query = "SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token válido, mostrar el formulario para restablecer la contraseña
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nueva_contrasena = $_POST['nueva_contrasena'];
            $confirmar_contrasena = $_POST['confirmar_contrasena'];

            // Validar contraseñas
            if ($nueva_contrasena !== $confirmar_contrasena) {
                echo 'Las contraseñas no coinciden.';
            } else {
                // Hash de la nueva contraseña
                $nueva_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

                // Obtener el email asociado al token
                $row = $result->fetch_assoc();
                $correo_electronico = $row['correo_electronico'];

                // Actualizar la contraseña en la base de datos
                $query = "UPDATE usuarios SET contrasena = ? WHERE correo_electronico = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $nueva_contrasena, $correo_electronico);
                $stmt->execute();

                // Eliminar el token
                $query = "DELETE FROM password_resets WHERE token = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $token);
                $stmt->execute();

                echo 'La contraseña ha sido restablecida con éxito.';
            }
        } else {
            // Mostrar el formulario
            echo '
            <form action="" method="post">
                <div class="mb-3">
                    <label for="nueva_contrasena" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" required>
                </div>
                <div class="mb-3">
                    <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required>
                </div>
                <button type="submit" class="btn btn-primary">Restablecer Contraseña</button>
            </form>';
        }
    } else {
        echo 'Token no válido o ha expirado.';
    }
} else {
    echo 'Token no proporcionado.';
}

$conn->close();
?>
