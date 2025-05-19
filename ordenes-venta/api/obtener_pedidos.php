<?php
include '../conexion.php';

$sql = "SELECT 
            p.PEDIDO_ID,
            p.FECHA,
            p.NOMBRE_CLIENTE,
            p.TOTAL,
            d.PRODUCTO_ID,
            pr.NOMBRE_PRODUCTO,
            pr.DESCRIPCION_PRODUCTO,
            d.CANTIDAD,
            d.SUBTOTAL
        FROM pedido p
        INNER JOIN pedido_detalle d ON p.PEDIDO_ID = d.PEDIDO_ID
        INNER JOIN producto pr ON d.PRODUCTO_ID = pr.PRODUCTO_ID
        ORDER BY p.PEDIDO_ID DESC";

$result = $conn->query($sql);

$pedidos = [];

while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

echo json_encode($pedidos);
?>