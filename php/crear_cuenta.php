<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdd_usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables para errores
$nombre_usuario_error = "";
$correo_electronico_error = "";
$general_error = "";

// Recuperar datos del formulario
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$numero_contacto = $_POST["numero_contacto"];
$correo_electronico = $_POST["correo_electronico"];
$nombre_usuario = $_POST["nombre_usuario"];
$contrasena = $_POST["contrasena"];
$confirmar_contrasena = $_POST["confirmar_contrasena"];

// Sanitizar entradas
$nombre = mysqli_real_escape_string($conn, $nombre);
$apellidos = mysqli_real_escape_string($conn, $apellidos);
$numero_contacto = mysqli_real_escape_string($conn, $numero_contacto);
$correo_electronico = mysqli_real_escape_string($conn, $correo_electronico);
$nombre_usuario = mysqli_real_escape_string($conn, $nombre_usuario);
$contrasena = mysqli_real_escape_string($conn, $contrasena);
$confirmar_contrasena = mysqli_real_escape_string($conn, $confirmar_contrasena);

// Inicializar flag de errores
$errors = false;

// Verificar si las contraseñas coinciden
if ($contrasena !== $confirmar_contrasena) {
    $general_error = "Las contraseñas no coinciden.";
    $errors = true;
}

// Verificar si el correo electrónico ya existe
if (!$errors) {
    $query = "SELECT * FROM usuarios WHERE correo_electronico = '$correo_electronico'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $correo_electronico_error = "El correo electrónico ya existe.";
        $errors = true;
    }
}

// Verificar si el nombre de usuario ya existe
if (!$errors) {
    $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $nombre_usuario_error = "El nombre de usuario ya está en uso.";
        $errors = true;
    }
}

// Si no hay errores, proceder con la inserción
if (!$errors) {
    // Hash de la contraseña
    $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar datos en la base de datos
    $query = "INSERT INTO usuarios (nombre, apellidos, numero_contacto, correo_electronico, nombre_usuario, contrasena) VALUES ('$nombre', '$apellidos', '$numero_contacto', '$correo_electronico', '$nombre_usuario', '$contrasena')";

    if ($conn->query($query) === TRUE) {
        // Mensaje de éxito y redirección después de 5 segundos
        echo "Cuenta creada con éxito. Redirigiendo al Home en 5 segundos...";
        echo '<script>
                setTimeout(function() {
                    window.location.href = "../index.html";
                }, 5000);
              </script>';
    } else {
        // Manejo de errores en la inserción
        $general_error = "Error al crear la cuenta: " . $conn->error;
    }
} else {
    // Mostrar errores si existen
    if ($general_error) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($general_error) . '</div>';
    }
    if ($correo_electronico_error) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($correo_electronico_error) . '</div>';
    }
    if ($nombre_usuario_error) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($nombre_usuario_error) . '</div>';
    }
}

$conn->close();
?>
