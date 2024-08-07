<?php
// Asegúrate de que la ruta a autoload.php es correcta
require_once __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta según la estructura de tu proyecto

use Dotenv\Dotenv;
use Google_Client;
use Google_Service_Oauth2;

// Cargar las variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Ajusta la ruta según la estructura de tu proyecto
$dotenv->load();

$client_id = $_ENV['GOOGLE_CLIENT_ID'];
$client_secret = $_ENV['GOOGLE_CLIENT_SECRET'];
$redirect_uri = $_ENV['GOOGLE_REDIRECT_URI'];

// Configura el cliente de Google
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope('email');
$client->addScope('profile');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener las credenciales del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Aquí deberías validar las credenciales del usuario en tu base de datos
    // Ejemplo simple (reemplaza con tu lógica de autenticación)
    if ($email == 'usuario@ejemplo.com' && $password == 'contraseña') {
        // Guardar la información del usuario en la sesión
        $_SESSION['user_email'] = $email;
        header('Location: index.php');
        exit;
    } else {
        echo 'Credenciales inválidas';
    }
} else if (isset($_GET['code'])) {
    // El usuario ha sido redirigido desde Google después de la autenticación
    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $oauth2 = new Google_Service_Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    // Maneja la información del usuario aquí
    $_SESSION['user_email'] = $userInfo->email;

    // Redirigir al usuario a la página de inicio o donde desees
    header('Location: index.php');
    exit;
} else {
    // El usuario no ha sido autenticado, redirigir a Google para la autenticación
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit;
}
?>
