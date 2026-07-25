<?php
$host = '127.0.0.1';
$user = 'root';
$password = '';
$database = 'sistema_facturacion';

$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_errno) {
    die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
