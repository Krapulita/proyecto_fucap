<?php
include("header.php");
include("navbar.php");
include "model/conexion.php";

// Iniciar sesión si aún no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];
$mensaje = $error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST["current_password"];
    $nueva_contrasena = $_POST["nueva_contrasena"];
    $confirmar_contrasena = $_POST["confirmar_contrasena"];

    // Verificar la contraseña actual
    $stmt = $db->prepare("SELECT contrasena FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $row = $stmt->fetch();
    $hashed_current_password = $row["contrasena"];

    if (password_verify($current_password, $hashed_current_password)) {
        // Validar la nueva contraseña (puedes agregar más validaciones según tus requisitos)
        if ($nueva_contrasena === $confirmar_contrasena && strlen($nueva_contrasena) >= 8) {
            // Hash de la nueva contraseña
            $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $stmt = $db->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
            if ($stmt->execute([$hashed_password, $usuario_id])) {
                $mensaje = "Contraseña actualizada con éxito.";
            } else {
                $error = "Error al actualizar la contraseña.";
            }
        } else {
            $error = "La nueva contraseña y la confirmación deben coincidir y tener al menos 8 caracteres.";
        }
    } else {
        $error = "La contraseña actual es incorrecta.";
    }
}
?>

<div class="container mt-5">
    <h1 class="mb-4">Cambiar Contraseña</h1>
    <?php if (!empty($mensaje)) : ?>
        <div class="alert alert-success">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="current_password">Contraseña Actual:</label>
            <input type="password" class="form-control" name="current_password" required>
        </div>
        <div class="form-group">
            <label for="nueva_contrasena">Nueva Contraseña:</label>
            <input type="password" class="form-control" name="nueva_contrasena" required>
        </div>
        <div class="form-group">
            <label for="confirmar_contrasena">Confirmar Nueva Contraseña:</label>
            <input type="password" class="form-control" name="confirmar_contrasena" required>
        </div>
        <a href="inicio.php" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
    </form>
</div>
</body>
</html>