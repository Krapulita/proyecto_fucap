<?php
#propiedades de host
$pass='LS-*a]ehHCG5Co_-';
$user = 'mecanicoadmin';
$namedb = 'citas';

try {
    $db = new PDO(
        'mysql:host=localhost;dbname='.$namedb, $user, $pass
    );
   # echo 'Exito';
} catch (Exception $error) {
    echo 'error conexion'.$error->getMessage();
    die();
}