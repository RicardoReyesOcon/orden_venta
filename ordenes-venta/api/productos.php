<?php
header('Content-Type: application/json');
include '../conexion.php';

$result = $conn->query("SELECT * FROM producto");

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos);
?>