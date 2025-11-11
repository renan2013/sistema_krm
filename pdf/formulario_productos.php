<?php
        // Datos de conexión a la base de datos
        $servername = "localhost"; // Cambia esto por tu servidor
        $username = "u400283574_krm"; // Cambia esto por tu nombre de usuario
        $password = "Krm2024!"; // Cambia esto por tu contraseña
        $dbname = "u400283574_krm"; // Cambia esto por el nombre de tu base de datos

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta SQL para obtener los clientes
        $sql = "SELECT id_cliente, nombre FROM clientes";
        $result = $conn->query($sql);
        ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de Recibo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
        }
        tfoot {
            font-weight: bold;
        }
    </style>
    <script>
        let productos = [];

        // Función para agregar productos
        function agregarProducto() {
            const descripcion = document.getElementById('descripcion').value;
            const cantidad = parseFloat(document.getElementById('cantidad').value);
            const precioUnitario = parseFloat(document.getElementById('precio_unitario').value);
            const total = cantidad * precioUnitario;

            // Añadir producto al array
            productos.push({ descripcion, cantidad, precioUnitario, total });

            // Actualizar la tabla de vista previa
            actualizarVistaPrevia();
        }

        // Función para actualizar la tabla de vista previa
        function actualizarVistaPrevia() {
            let tabla = document.getElementById('tabla_productos');
            tabla.innerHTML = ''; // Limpiar la tabla
            let subtotal = 0;

            productos.forEach((producto, index) => {
                const row = tabla.insertRow();
                row.insertCell(0).innerHTML = producto.descripcion;
                row.insertCell(1).innerHTML = producto.cantidad;
                row.insertCell(2).innerHTML = producto.precioUnitario.toFixed(2);
                row.insertCell(3).innerHTML = producto.total.toFixed(2);

                // Agregar botón de eliminar
                const eliminarCelda = row.insertCell(4);
                const eliminarBtn = document.createElement('button');
                eliminarBtn.innerHTML = 'Eliminar';
                eliminarBtn.onclick = function () {
                    eliminarProducto(index);
                };
                eliminarCelda.appendChild(eliminarBtn);

                subtotal += producto.total;
            });

            // Calcular subtotal y total con IVA
            document.getElementById('subtotal').innerHTML = subtotal.toFixed(2);
            document.getElementById('total').innerHTML = (subtotal * 1.21).toFixed(2); // Total con 21% de IVA

            // Actualizar la fila del total
            let tablaFoot = document.getElementById('tabla_footer');
            tablaFoot.innerHTML = ''; // Limpiar footer
            const rowFooter = tablaFoot.insertRow();
            rowFooter.insertCell(0).innerHTML = "Total";
            rowFooter.insertCell(1).innerHTML = "";
            rowFooter.insertCell(2).innerHTML = "";
            rowFooter.insertCell(3).innerHTML = subtotal.toFixed(2);
        }

        // Función para eliminar un producto
        function eliminarProducto(index) {
            productos.splice(index, 1); // Eliminar producto del array
            actualizarVistaPrevia(); // Actualizar la tabla
        }

        // Función para guardar la factura
        function guardarFactura() {
            const nombreCliente = document.getElementById('nombre_cliente').value;

            const datos = {
                nombreCliente,
                productos
            };

            // Enviar datos al servidor para guardarlos
            fetch('guardar_factura.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            })
            .then(response => response.text())
            .then(data => {
                alert('Factura guardada con éxito. ' + data);
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    <div class="container">

    <h3>Generar Recibo KRM</h3>
    <div class="form-group row">
              <label for="cliente" class="col-4 col-form-label">Cliente</label> 
              <div class="col-8">
                <select id="cliente" name="cliente" class="custom-select" required="required">
                  <option value="" disabled selected>Seleccionar Cliente</option>
                  <?php
                  // Verificar si hay resultados
                  if ($result->num_rows > 0) {
                      // Salida de cada cliente como una opción en el select
                      while($row = $result->fetch_assoc()) {
                          echo "<option value='" . $row["id_cliente"] . "'>" . $row["nombre"] . "</option>";
                      }
                  } else {
                      echo "<option value=''>No hay clientes disponibles</option>";
                  }
                  ?>
                </select>
              </div>
    </div>

    

    <div class="form-group row">
              <label for="text" class="col-4 col-form-label">Descripción:</label> 
              <div class="col-8">
                <input id="descripcion" name="descripcion" type="text" class="form-control" required="required">
              </div>
    </div> 

    <div class="form-group row">
              <label for="text" class="col-4 col-form-label">Cantidad:</label> 
              <div class="col-8">
    <input type="number" id="cantidad" step="1" class="form-control" required>
    </div>
    </div> 

    <div class="form-group row">
              <label for="text" class="col-4 col-form-label">Precio unitario:</label> 
              <div class="col-8">

    
    <input type="number" id="precio_unitario" step="0.01" class="form-control" required>
    </div>
    </div> 

    <button type="button" onclick="agregarProducto()">Agregar Producto</button>
    <hr/>

    <h4>Vista Previa de Factura</h4>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tabla_productos">
            <!-- Aquí se agregarán los productos dinámicamente -->
        </tbody>
        <tfoot id="tabla_footer">
            <!-- Aquí se mostrará el total -->
        </tfoot>
    </table>
    <p>Subtotal: $<span id="subtotal">0.00</span></p>
    <p>Total (con IVA 21%): $<span id="total">0.00</span></p>

    <button type="button" onclick="guardarFactura()">Guardar Factura</button>
    </div>

</body>
</html>
