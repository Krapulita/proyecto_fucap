<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "kradmin";
$password = "MICONTRASEÑA";
$dbname = "bdd_usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


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

// Verificar si las contraseñas coinciden
if ($contrasena !== $confirmar_contrasena) {
    echo "Las contraseñas no coinciden.";
} else {
    // Verificar si el correo electrónico ya existe
    $query = "SELECT * FROM usuarios WHERE correo_electronico = '$correo_electronico'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya existe.";
    } else {
        // Hash de la contraseña
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar datos en la base de datos
        $query = "INSERT INTO usuarios (nombre, apellidos, numero_contacto, correo_electronico, nombre_usuario, contrasena) VALUES ('$nombre', '$apellidos', '$numero_contacto', '$correo_electronico', '$nombre_usuario', '$contrasena')";
        $conn->query($query);

        echo "Cuenta creada con éxito.";
    }
}

$conn->close();
?>