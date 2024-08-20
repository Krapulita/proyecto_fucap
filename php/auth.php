<?php
session_start();

// Verifica si el usuario está autenticado
$isLoggedIn = isset($_SESSION['user_email']);

if ($isLoggedIn) {
    $userData = [
        'email' => $_SESSION['user_email'],
        'name' => $_SESSION['nombre_usuario'] ?? $_SESSION['user_email'] ?? 'Usuario', // Asume que tienes un nombre de usuario guardado, si no, usa 'Usuario'
        'picture' => $_SESSION['user_picture'] ?? '../assets/images/usuario.jpg' // Asume que tienes una imagen de perfil guardada, si no, usa una por defecto
    ];
} else {
    $userData = null;
}

// Configura la cabecera para JSON
header('Content-Type: application/json');

// Devuelve la información en formato JSON
echo json_encode([
    'isLoggedIn' => $isLoggedIn,
    'userData' => $userData
]);
?>