<?php
#propiedades de host
$pass='';
$user = 'root';
$namedb = 'tuercas';

try {
    $db = new PDO(
        'mysql:host=localhost;dbname='.$namedb, $user, $pass
    );
   # echo 'Exito';
} catch (Exception $error) {
    echo 'error conexion'.$error->getMessage();
    die();
}