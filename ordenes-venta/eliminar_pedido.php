<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedido_id = $_POST['pedido_id'];

    // Primero eliminamos los detalles
    $sql_detalle = "DELETE FROM pedido_detalle WHERE PEDIDO_ID = ?";
    $stmt_detalle = $conn->prepare($sql_detalle);
    $stmt_detalle->bind_param("i", $pedido_id);
    $stmt_detalle->execute();

    // Luego eliminamos el encabezado del pedido
    $sql_pedido = "DELETE FROM pedido WHERE PEDIDO_ID = ?";
    $stmt_pedido = $conn->prepare($sql_pedido);
    $stmt_pedido->bind_param("i", $pedido_id);
    $stmt_pedido->execute();

    if ($stmt_pedido->affected_rows > 0) {
        header("Location: ver_pedido.php?mensaje=eliminado");
    } else {
        header("Location: ver_pedido.php?mensaje=error");
    }
    exit;
}
?>