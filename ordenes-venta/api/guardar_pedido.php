<?php
header('Content-Type: application/json');
include '../conexion.php';

// Leer los datos recibidos en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validación básica
if (!$data || !isset($data['cliente'], $data['fecha'], $data['productos']) || count($data['productos']) === 0) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos o vacíos']);
    exit;
}

$cliente = $data['cliente'];
$fecha = $data['fecha'];
$productos = $data['productos'];

// Calcular el total del pedido
$total = 0;
foreach ($productos as $p) {
    $total += $p['subtotal'];
}

// Insertar en tabla pedido
$stmt = $conn->prepare("INSERT INTO pedido (FECHA, NOMBRE_CLIENTE, TOTAL) VALUES (?, ?, ?)");
$stmt->bind_param("ssd", $fecha, $cliente, $total);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error al insertar pedido: ' . $stmt->error]);
    exit;
}

$pedido_id = $stmt->insert_id; // ID del nuevo pedido

// Insertar en pedido_detalle
$detalle_stmt = $conn->prepare("INSERT INTO pedido_detalle (PEDIDO_ID, PRODUCTO_ID, CANTIDAD, SUBTOTAL) VALUES (?, ?, ?, ?)");

foreach ($productos as $p) {
    $producto_id = $p['id'];
    $cantidad = $p['cantidad'];
    $subtotal = $p['subtotal'];

    $detalle_stmt->bind_param("iiid", $pedido_id, $producto_id, $cantidad, $subtotal);

    if (!$detalle_stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error al insertar detalle: ' . $detalle_stmt->error]);
        exit;
    }

    // También podrías descontar stock aquí si lo deseas
}

echo json_encode(['success' => true, 'message' => 'Pedido guardado exitosamente.']);
?>