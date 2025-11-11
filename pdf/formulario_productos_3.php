<?php
include "../menu.php";
?>
<?php
// Datos de conexión a la base de datos
$servername = "localhost"; 
$username = "u400283574_krm"; 
$password = "Krm2024!"; 
$dbname = "u400283574_krm"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener todas las categorías
$sqlCategorias = "SELECT id_categoria, nombre_categoria FROM categorias";
$resultCategorias = $conn->query($sqlCategorias);

// Consulta SQL para obtener los clientes
$sql = "SELECT id_cliente, nombre, empresa FROM clientes";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cotización</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #f5f6f6;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
        }
        tfoot {
            font-weight: bold;
        }
        .table-striped>tbody>tr:nth-child(odd)>td, 
        .table-striped>tbody>tr:nth-child(odd)>th {
            background-color: #fff;
        }
        .table-striped>tbody>tr:nth-child(even)>td, 
        .table-striped>tbody>tr:nth-child(even)>th {
            background-color: #f5f6f6;
        }
        .table-striped>thead>tr>th {
            background-color: #eee;
        }
        table {
            width: 100%;
        }
        thead{
            font-size:13px;
        }
        @media (max-width: 768px) {
            .table thead {
                display: none;
            }
            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            .table tr {
                margin-bottom: 10px;
            }
            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
                text-align: left;
            }
        }
        label{
            font-size:13px;
        }
    </style>
   <script>
        let productos = [];

        function agregarProducto() {
            const nombre_producto = document.getElementById('nombre_producto').value;
            const cantidad = parseFloat(document.getElementById('cantidad').value);
            const precioUnitario = parseFloat(document.getElementById('precio_unitario').value);
            const total = cantidad * precioUnitario;

            productos.push({ nombre_producto, cantidad, precioUnitario, total });

            actualizarVistaPrevia();
            limpiarCampos();
        }

        function limpiarCampos() {
            document.getElementById('nombre_producto').value = "";
            document.getElementById('cantidad').value = "";
            document.getElementById('precio_unitario').value = "";
        }

        function actualizarVistaPrevia() {
            let tabla = document.getElementById('tabla_productos');
            tabla.innerHTML = '';
            let subtotal = 0;

            productos.forEach((producto, index) => {
                const row = tabla.insertRow();
                row.insertCell(0).innerHTML = producto.nombre_producto; // Mostrar nombre en lugar del ID
                row.insertCell(1).innerHTML = producto.cantidad;
                row.insertCell(2).innerHTML = producto.precioUnitario.toFixed(2);
                row.insertCell(3).innerHTML = producto.total.toFixed(2);

                const eliminarCelda = row.insertCell(4);
                const eliminarBtn = document.createElement('button');
                eliminarBtn.className = 'btn btn-danger btn-sm';
                eliminarBtn.innerHTML = 'Eliminar';
                eliminarBtn.onclick = function () {
                    eliminarProducto(index);
                };
                eliminarCelda.appendChild(eliminarBtn);
                subtotal += producto.total;
            });

            let tablaFoot = document.getElementById('tabla_footer');
            tablaFoot.innerHTML = '';
            const rowFooter = tablaFoot.insertRow();
            rowFooter.insertCell(0).innerHTML = "Total";
            rowFooter.insertCell(1).innerHTML = "";
            rowFooter.insertCell(2).innerHTML = "";
            rowFooter.insertCell(3).innerHTML = subtotal.toFixed(2);
        }

        function eliminarProducto(index) {
            productos.splice(index, 1);
            actualizarVistaPrevia();
        }

        function guardarFactura() {
            const cliente_id = document.getElementById('cliente').value;

            const datos = {
                cliente_id,
                productos
            };

            fetch('guardar_factura.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'factura_exito.php?factura_id=' + data.factura_id;
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    <div class="container">
        <h4 class="mt-4">Crear Cotización</h4>
        <form>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="cliente">Empresa (Cliente)</label>
                    <select id="cliente" name="cliente" class="custom-select" required>
                        <option value="" disabled selected>Seleccionar Empresa (Cliente)</option>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["id_cliente"] . "' data-nombre='" . $row["nombre"] . "'>" . $row["empresa"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay clientes disponibles</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="cliente_nombre">Nombre del Cliente</label>
                    <input id="cliente_nombre" name="cliente_nombre" type="text" class="form-control" readonly>
                    <script>
                        document.getElementById('cliente').addEventListener('change', function() {
                            const clienteNombre = this.options[this.selectedIndex].getAttribute('data-nombre');
                            document.getElementById('cliente_nombre').value = clienteNombre;
                        });
                    </script>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" class="custom-select">
                        <option value="" disabled selected>Seleccionar Categoría</option>
                        <?php
                        if ($resultCategorias->num_rows > 0) {
                            while ($row = $resultCategorias->fetch_assoc()) {
                                echo "<option value='" . $row['id_categoria'] . "'>" . $row['nombre_categoria'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay categorías disponibles</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="nombre_producto">Productos:</label>
                    <select id="nombre_producto" name="nombre_producto" class="custom-select">
                        <option value="" disabled selected>Seleccionar Producto</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="cantidad">Cantidad:</label>
                    <input id="cantidad" name="cantidad" type="number" class="form-control" required>
                </div>

                <div class="col-md-2">
                    <label for="precio_unitario">Precio unitario:</label>
                    <input id="precio_unitario" name="precio_unitario" type="number" step="0.01" class="form-control" required>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="agregarProducto()">Agregar Producto</button>
            <hr/>

            <h5>Vista Previa de Orden</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tabla_productos"></tbody>
                <tfoot id="tabla_footer"></tfoot>
            </table>
        </form>

        <button class="btn btn-success" onclick="guardarFactura()">Guardar Factura</button>
    </div>

    <script>
        document.getElementById('categoria').addEventListener('change', function() {
            const id_categoria = this.value;
            if (id_categoria) {
                fetch('obtener_productos.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id_categoria=' + id_categoria
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('nombre_producto').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>
