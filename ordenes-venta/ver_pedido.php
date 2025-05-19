<?php
include 'conexion.php';

$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$param = "%" . $buscar . "%";

$sql = "
    SELECT 
        p.PEDIDO_ID,
        p.FECHA,
        p.NOMBRE_CLIENTE,
        p.TOTAL,
        pd.CANTIDAD,
        pd.SUBTOTAL,
        d.NOMBRE_PRODUCTO,
        d.DESCRIPCION_PRODUCTO,
        d.PRECIO_PRODUCTO
    FROM pedido p
    JOIN pedido_detalle pd ON p.PEDIDO_ID = pd.PEDIDO_ID
    JOIN producto d ON pd.PRODUCTO_ID = d.PRODUCTO_ID
";

if (!empty($buscar)) {
    $sql .= " WHERE p.NOMBRE_CLIENTE LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $param);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    $sql .= " ORDER BY p.PEDIDO_ID DESC";
    $resultado = $conn->query($sql);
}

//$resultado = $conn->query($sql);

// Agrupar los pedidos por PEDIDO_ID
$pedidos = [];
while ($fila = $resultado->fetch_assoc()) {
    $id = $fila['PEDIDO_ID'];
    if (!isset($pedidos[$id])) {
        $pedidos[$id] = [
            'fecha' => $fila['FECHA'],
            'cliente' => $fila['NOMBRE_CLIENTE'],
            'total' => $fila['TOTAL'],
            'productos' => []
        ];
    }

    $pedidos[$id]['productos'][] = [
        'nombre' => $fila['NOMBRE_PRODUCTO'],
        'descripcion' => $fila['DESCRIPCION_PRODUCTO'],
        'precio' => $fila['PRECIO_PRODUCTO'],
        'cantidad' => $fila['CANTIDAD'],
        'subtotal' => $fila['SUBTOTAL']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>

    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background: #009879; color: #fff; }
        .total-row td { font-weight: bold; background-color: #f0f0f0; }
        .volver-btn { margin-bottom: 20px; display: inline-block; padding: 10px 15px; background: #007BFF; color: white; text-decoration: none; border-radius: 5px; }
        .volver-btn:hover { background: #0056b3; }
        .pedido-header { margin-top: 30px; font-size: 18px; font-weight: bold; color: #444; }
    </style>
     <form method="GET" style="margin-bottom: 20px;">
    <input type="text" name="buscar" placeholder="Buscar por nombre del cliente" value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>" style="padding: 8px; width: 300px; border-radius: 4px; border: 1px solid #ccc;">
    <button type="submit" style="padding: 8px 12px; background-color: #009879; color: white; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
    <a href="ver_pedido.php" style="margin-left:10px; color:#009879;">Reiniciar</a>
</form>

</head>
<body>

<h1>Lista de Pedidos</h1>
<a href="crear_pedido.php" class="volver-btn">← Crear nuevo pedido</a>

<?php if (isset($_GET['mensaje'])): ?>
    <script>
        <?php if ($_GET['mensaje'] == 'eliminado'): ?>
            alert('✅ Pedido eliminado correctamente.');
        <?php elseif ($_GET['mensaje'] == 'error'): ?>
            alert('❌ No se pudo eliminar el pedido.');
        <?php endif; ?>
    </script>
<?php endif; ?>

<?php if (count($pedidos) > 0): ?>
    <?php foreach ($pedidos as $id => $pedido): ?>
<div class="pedido-header">
    Pedido #<?= $id ?> | Cliente: <?= htmlspecialchars($pedido['cliente']) ?> | Fecha: <?= $pedido['fecha'] ?>
    <form action="eliminar_pedido.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este pedido?');">
        <input type="hidden" name="pedido_id" value="<?= $id ?>">
        <button type="submit" style="background:#dc3545; color:white; border:none; padding:5px 10px; margin-left:10px; border-radius:4px; cursor:pointer;">Eliminar pedido</button>
    </form>
</div>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedido['productos'] as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td><?= $producto['cantidad'] ?></td>
                        <td>$<?= number_format($producto['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="4">Total del pedido</td>
                    <td>$<?= number_format($pedido['total'], 2) ?></td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
<?php else: ?>
    <p>No hay pedidos registrados.</p>
<?php endif; ?>

</body>
</html>