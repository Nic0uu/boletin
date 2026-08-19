<?php
$host = 'localhost';
$db = 'boletin';
$username = 'root';
$password = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>