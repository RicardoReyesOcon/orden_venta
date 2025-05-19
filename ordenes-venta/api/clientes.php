<?php
header('Content-Type: application/json');
include '../conexion.php';

$result = $conn->query("SELECT * FROM cliente");

$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

echo json_encode($clientes);
?>