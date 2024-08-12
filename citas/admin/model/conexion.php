<?php
#propiedades de host
$pass='452.Krapu';
$user = 'kradmin';
$namedb = 'bdd_usuarios';

try {
    $db = new PDO(
        'mysql:host=localhost;dbname='.$namedb, $user, $pass
    );
   # echo 'Exito';
} catch (Exception $error) {
    echo 'error conexion'.$error->getMessage();
    die();
}