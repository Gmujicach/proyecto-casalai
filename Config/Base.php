<?php
// database.php

// Configuración de la base de datos
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'prueba';

// Conexión a la base de datos
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Verificar conexión
if ($mysqli->connect_errno) {
    die("Falló la conexión a MySQL: " . $mysqli->connect_error);
}
?>