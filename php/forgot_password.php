<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que esta ruta sea correcta

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Verificar si el campo correo_electronico está presente
if (!isset($_POST["correo_electronico"]) || empty($_POST["correo_electronico"])) {
    die("Error: El campo 'correo_electronico' no está presente o está vacío.");
}

$correo_electronico = $_POST["correo_electronico"];

// Configuración de la base de datos
$servername = "localhost";
$username = "kradmin"; // Verifica que este sea el nombre de usuario correcto
$password = "452.Krapu"; // Verifica que esta sea la contraseña correcta
$dbname = "bdd_usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = "SELECT * FROM usuarios WHERE correo_electronico = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $correo_electronico);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El correo electrónico está registrado, enviar el correo
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME']; // Tu correo de Gmail
        $mail->Password = $_ENV['SMTP_PASSWORD']; // La contraseña de tu correo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom($_ENV['SMTP_USERNAME'], 'Garras Y Tuercas');
        $mail->addAddress($correo_electronico);

        // Generar un token único
        $token = bin2hex(random_bytes(32));

        // Enviar el token al correo
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de Contraseña';
        $mail->Body    = 'Aquí está el enlace para recuperar tu contraseña: <a href="http://localhost/MiSitioWeb/php/reset_password.php?token=' . $token . '">Recuperar Contraseña</a>';

        // Enviar el correo
        $mail->send();

        // Mostrar mensaje y redirigir después de unos segundos
        echo 'El mensaje de recuperación ha sido enviado. Redirigiendo a la página de inicio de sesión en 5 segundos...';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "/login.html";
                }, 5000);
              </script>';
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
} else {
    // El correo electrónico no está registrado
    echo 'El correo electrónico no está registrado.';
}

$conn->close();
?>
