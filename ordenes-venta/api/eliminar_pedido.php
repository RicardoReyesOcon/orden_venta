<?php
header('Content-Type: application/json');
include '../conexion.php';

$data = json_decode(file_get_contents('php://input'), true);
$pedido_id = $data['pedido_id'];

if (!$pedido_id) {
    echo json_encode(['success' => false, 'message' => 'ID no recibido.']);
    exit;
}

// Eliminar todas las filas que tengan el mismo PEDIDO_ID
$stmt = $conn->prepare("DELETE FROM pedido WHERE PEDIDO_ID = ?");
$stmt->bind_param("i", $pedido_id);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
?>