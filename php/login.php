<?php
// Simple script to test if login.php is working
echo "El archivo login.php está funcionando.";

require_once __DIR__ . '/../vendor/autoload.php'; // Asegúrate de que esta ruta es correcta

use Dotenv\Dotenv;
use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Configuración del cliente de Google
$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
$client->addScope('email');
$client->addScope('profile');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener las credenciales del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Conectar a la base de datos
    $servername = "localhost";
    $db_username = "kradmin";
    $db_password = "452.Krapu";
    $dbname = "bdd_usuarios";
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Buscar al usuario en la base de datos
    $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE correo_electronico = ?");
    if (!$stmt) {
        die("Error en la preparación de la declaración: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verificar la contraseña
    if (password_verify($password, $hashed_password)) {
        // Contraseña correcta
        $_SESSION['loggedin'] = true; // Indicar que el usuario está autenticado
        $_SESSION['user_email'] = $email;

        //Obtener el nombre de usuario
        $stmt = $conn->prepare("SELECT nombre_usuario FROM usuarios WHERE correo_electronico = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
        }

        header('Location: http://garrasytuercas.cl/index.html'); // Redirige al usuario a la página principal
        exit;
    } else {
        // Contraseña incorrecta
        echo 'Credenciales inválidas';
    }

    $stmt->close();
    $conn->close();
} else if (isset($_GET['code'])) {
    // El usuario ha sido redirigido desde Google después de la autenticación
    try {
        $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $oauth2 = new Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();

        // Manejar la información del usuario
        $_SESSION['loggedin'] = true; // Indicar que el usuario está autenticado
        $_SESSION['user_email'] = $userInfo->email;
        $_SESSION['nombre_usuario'] = $userInfo->name; //Google proporciona el nombre

        // Guarda la informacion de usuario de Google en la BDD
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo_electrónico) VALUES (?, ?) ON DUPLICATE KEY UPDATE nombre_usuario = VALUES(nombre_usuario)");
        $stmt->bind_param("ss", $userInfo->name, $userInfo->email);
        $stmt->execute();
        
        header('Location: index.html'); // Redirige al usuario a la página principal
        exit;
    } catch (Exception $e) {
        // Manejo de errores de Google OAuth
        echo 'Error en la autenticación de Google: ' . $e->getMessage();
    }
} else {
    // El usuario no ha sido autenticado, redirigir a Google para la autenticación
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit;
}
?>
