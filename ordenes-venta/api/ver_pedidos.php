<?php
header('Content-Type: application/json');
include '../conexion.php';

$sql = "SELECT PEDIDO_ID, FECHA, NOMBRE_CLIENTE, PRODUCTO_ID, CANTIDAD, SUBTOTAL, TOTAL,
               p2.NOMBRE_PRODUCTO, p2.DESCRIPCION_PRODUCTO
        FROM pedido p
        JOIN producto p2 ON p.PRODUCTO_ID = p2.PRODUCTO_ID
        ORDER BY PEDIDO_ID DESC";

$result = $conn->query($sql);

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

echo json_encode($pedidos);
?>