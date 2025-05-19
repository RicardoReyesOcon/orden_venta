<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Pedido</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    background: #f5f7fa;
    margin: 0;
    padding: 20px;
  }
  h1 {
    color: #333;
  }
  a.button, button {
    background-color: #009879;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
  }
  a.button:hover, button:hover {
    background-color: #007f63;
  }
  .form-row {
  display: flex;
  gap: 20px; /* espacio entre los dos campos */
  margin-bottom: 20px;
  flex-wrap: wrap; /* para que en pantallas pequeñas puedan ir apilados */
}

.form-group {
  flex: 1 1 200px; 
  max-width: 300px; 
}

.form-group label {
  display: block;
  margin-bottom: 6px;
  font-weight: bold;
  color: #555;
}

.form-group input[type="date"],
.form-group select {
  width: 100%;
  padding: 8px 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 16px;
  box-sizing: border-box;
}
  label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
    color: #555;
  }
  select, input[type="date"], input[type="number"], input[type="text"] {
    width: 100%;
    padding: 8px 10px;
    margin-bottom: 20px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
  }
  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 20px;
  }
  th, td {
    text-align: left;
    padding: 12px 10px;
    border-bottom: 1px solid #ddd;
  }
  th {
    background-color: #009879;
    color: white;
    font-weight: bold;
  }
  tr:hover {
    background-color: #f1f9f7;
  }
  .total-row td {
    font-weight: bold;
    font-size: 1.1em;
    background-color: #e6f1ef;
  }
  #lista-productos {
    max-height: 350px;
    overflow-y: auto;
    margin-top: 20px;
  }
  /* Estilos para la lista de productos tipo tarjeta */
  #contenedor-productos > div {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
  }
  #contenedor-productos > div:hover {
    background-color: #f9fdfb;
  }
</style>
</head>
<body>

<h2>Crear Pedido</h2>

<div class="form-row">
  <div class="form-group">
    <label for="fecha">Fecha</label>
    <input type="date" id="fecha" name="fecha" required>
  </div>

  <div class="form-group">
    <label for="cliente">Seleccionar Cliente</label>
    <select id="cliente" name="cliente" required>
      <option value="">-- Seleccione un cliente --</option>
      <!-- Opciones -->
    </select>
  </div>
</div>

<button class="btn" onclick="mostrarListaProductos()">Agregar Producto</button>

<!-- Lista de productos disponibles -->
<div id="productosDisponibles">
  <h4>Productos disponibles</h4>
  <table id="listaProductos">
    <thead>
      <tr><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Agregar</th></tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<!-- Tabla de productos seleccionados -->
<h4>Productos seleccionados</h4>
<table id="tablaPedido">
  <thead>
    <tr><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Quitar</th></tr>
  </thead>
  <tbody></tbody>
  <tfoot>
    <tr><td colspan="4" style="text-align:right;"><strong>Total:</strong></td>
        <td colspan="2" id="total">$0.00</td>
    </tr>
  </tfoot>
</table>

<button class="btn" onclick="guardarPedido()" style="
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 15px;
    background-color: #009879;
    color: white;
    text-decoration: none;
    border-radius: 4px;">Guardar Pedido</button>

<a href="ver_pedido.php" style="
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 15px;
    background-color: #009879;
    color: white;
    text-decoration: none;
    border-radius: 4px;
">Ver Pedidos</a>

<div id="mensaje"></div>

<script>
let productosSeleccionados = [];

function cargarClientes() {
  fetch('api/clientes.php')
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('cliente');
      select.innerHTML = data.map(c => `<option value="${c.NOMBRE_CLIENTE}">${c.NOMBRE_CLIENTE}</option>`).join('');
    });
}

function mostrarListaProductos() {
  fetch('api/productos.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.querySelector('#listaProductos tbody');
      tbody.innerHTML = '';
      data.forEach(p => {
        const row = `<tr>
          <td>${p.NOMBRE_PRODUCTO}</td>
          <td>${p.DESCRIPCION_PRODUCTO}</td>
          <td>${p.PRECIO_PRODUCTO}</td>
          <td><button onclick='agregarProducto(${JSON.stringify(p)})'>Agregar</button></td>
        </tr>`;
        tbody.innerHTML += row;
      });
      document.getElementById('productosDisponibles').style.display = 'block';
    });
}

function agregarProducto(p) {
  const existe = productosSeleccionados.find(prod => prod.id === p.PRODUCTO_ID);
  if (existe) return alert('Ya está agregado');

  const nuevo = {
    id: p.PRODUCTO_ID,
    nombre: p.NOMBRE_PRODUCTO,
    descripcion: p.DESCRIPCION_PRODUCTO,
    precio: parseFloat(p.PRECIO_PRODUCTO),
    cantidad: 1,
    subtotal: parseFloat(p.PRECIO_PRODUCTO)
  };
  productosSeleccionados.push(nuevo);
  renderTabla();
}

function actualizarCantidad(index, nuevaCantidad) {
  productosSeleccionados[index].cantidad = parseInt(nuevaCantidad);
  productosSeleccionados[index].subtotal = productosSeleccionados[index].cantidad * productosSeleccionados[index].precio;
  renderTabla();
}

function quitarProducto(index) {
  productosSeleccionados.splice(index, 1);
  renderTabla();
}

function renderTabla() {
  const tbody = document.querySelector('#tablaPedido tbody');
  tbody.innerHTML = '';
  let total = 0;

  productosSeleccionados.forEach((p, i) => {
    total += p.subtotal;
    const row = `<tr>
      <td>${p.nombre}</td>
      <td>${p.descripcion}</td>
      <td>$${p.precio.toFixed(2)}</td>
      <td><input type="number" min="1" value="${p.cantidad}" onchange="actualizarCantidad(${i}, this.value)"></td>
      <td>$${p.subtotal.toFixed(2)}</td>
      <td><button onclick="quitarProducto(${i})">Quitar</button></td>
    </tr>`;
    tbody.innerHTML += row;
  });

  document.getElementById('total').innerText = `$${total.toFixed(2)}`;
}

function guardarPedido() {
  const fecha = document.getElementById('fecha').value;
  const cliente = document.getElementById('cliente').value;

  if (!fecha || !cliente || productosSeleccionados.length === 0) {
    alert('Completa todos los campos y agrega al menos un producto.');
    return;
  }

  fetch('api/guardar_pedido.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ fecha, cliente, productos: productosSeleccionados })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      document.getElementById('mensaje').innerText = '✅ Pedido guardado correctamente';
      productosSeleccionados = [];
      renderTabla();
      document.getElementById('fecha').value = '';
    } else {
      document.getElementById('mensaje').innerText = '❌ No se pudo guardar el pedido';
    }
  });
}

cargarClientes();
</script>

</body>
</html>