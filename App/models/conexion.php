<?php
try {
    /*$manejador = 'mysql'; //'pgsql';
$servidor = 'localhost';
$dbname = 'odindeve_dbestdirsapol;charset=utf8';
$usuario = 'odindeve_josue'; //postgres
$pass = 'hcYz;tpXNb%R'; //root */
    $manejador = 'mysql';
    $servidor = 'localhost';
    $usuario = 'root';
    $pass = '';
    $db = 'tarifario2024';
    //$usuario = 'odindeveloper_josue';
    //$pass = 'b(=-.[52yyfy';
    //$db = 'odindeveloper_dbcpms';
    $cadena = "$manejador:host=$servidor;dbname=$db;charset=UTF8";
    $cnx = new PDO($cadena, $usuario, $pass);
    date_default_timezone_set('America/Lima');
} catch (Exception $ex) {
    echo 'Error de acceso, informelo a la brevedad :' . $ex;
    exit();
}
