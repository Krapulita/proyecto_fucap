<?php
session_start();

// Verifica si el usuario está autenticado
$isLoggedIn = isset($_SESSION['user_email']);

// Puedes agregar más lógica aquí según sea necesario

// Configura la cabecera para JSON
header('Content-Type: application/json');

// Devuelve la información en formato JSON
echo json_encode(['isLoggedIn' => $isLoggedIn]);
?>
