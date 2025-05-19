<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; // sin contraseña por defecto en XAMPP
$base_datos = "ordenes_venta";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificamos la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>