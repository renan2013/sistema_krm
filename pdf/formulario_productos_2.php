<?php
include "../menu.php";
?>
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
            const descripcion = document.getElementById('descripcion').value;
            const ancho = parseFloat(document.getElementById('ancho').value);
            const alto = parseFloat(document.getElementById('alto').value);
            const grosor = parseFloat(document.getElementById('grosor').value);
            const cantidad = parseFloat(document.getElementById('cantidad').value);
            const color = document.getElementById('color').value;
            const precioUnitario = parseFloat(document.getElementById('precio_unitario').value);
            const total = cantidad * precioUnitario;

            productos.push({ descripcion, ancho, alto, grosor, cantidad, color, precioUnitario, total });

            actualizarVistaPrevia();

            // Limpiar los campos del formulario
            limpiarCampos();
        }

    

        function limpiarCampos() {
            document.getElementById('descripcion').value = "";
            document.getElementById('ancho').value = "";
            document.getElementById('alto').value = "";
            document.getElementById('grosor').value = "";
            document.getElementById('cantidad').value = "";
            document.getElementById('color').value = "";
            document.getElementById('precio_unitario').value = "";
        }

        function actualizarVistaPrevia() {
            let tabla = document.getElementById('tabla_productos');
            tabla.innerHTML = ''; // Limpiar la tabla
            let subtotal = 0;

            productos.forEach((producto, index) => {
                const row = tabla.insertRow();
                row.insertCell(0).innerHTML = producto.descripcion;
                row.insertCell(1).innerHTML = producto.ancho.toFixed(2);
                row.insertCell(2).innerHTML = producto.alto.toFixed(2);
                row.insertCell(3).innerHTML = producto.grosor.toFixed(2);
                row.insertCell(4).innerHTML = producto.cantidad.toFixed(2);
                row.insertCell(5).innerHTML = producto.color;
                row.insertCell(6).innerHTML = producto.precioUnitario.toFixed(2);
                row.insertCell(7).innerHTML = producto.total.toFixed(2);

                const eliminarCelda = row.insertCell(8);
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
            tablaFoot.innerHTML = ''; // Limpiar footer
            const rowFooter = tablaFoot.insertRow();
            rowFooter.insertCell(0).innerHTML = "Total";
            rowFooter.insertCell(1).innerHTML = "";
            rowFooter.insertCell(2).innerHTML = "";
            rowFooter.insertCell(3).innerHTML = "";
            rowFooter.insertCell(4).innerHTML = "";
            rowFooter.insertCell(5).innerHTML = "";
            rowFooter.insertCell(6).innerHTML = "";
            rowFooter.insertCell(7).innerHTML = subtotal.toFixed(2);
        }

        function eliminarProducto(index) {
            productos.splice(index, 1); // Eliminar producto del array
            actualizarVistaPrevia(); // Actualizar la tabla
        }

        function guardarFactura() {
            const cliente_id = document.getElementById('cliente').value;  // El ID del cliente

            const datos = {
                cliente_id,  // Cambié el nombre de la variable para que sea más claro
                productos
            };

            // Imprimir los datos antes de enviarlos para asegurarse que estén correctos
            console.log(datos);

            fetch('guardar_factura.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirigir a la página de éxito, pasando el ID de la factura
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
        <h4 class="mt-4">Crear orden de compra</h4>
        <form>

        <div class="form-group row">
            <div class="col-md-4">
                <label for="cliente">Empresa (Cliente)</label> 
                <select id="cliente" name="cliente" class="custom-select" required>
                    <option value="" disabled selected>Seleccionar Empresa (Cliente)</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id_cliente"] . "' data-nombre='" . $row["nombre"] . "'>" . $row["empresa"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay clientes disponibles</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-4">
                <label for="cliente_nombre">Nombre del Cliente</label>
                <input id="cliente_nombre" name="cliente_nombre" type="text" class="form-control" readonly>
                <script>
                    document.getElementById('cliente').addEventListener('change', function() {
                        // Obtener el nombre del cliente desde el atributo 'data-nombre' del <option> seleccionado
                        const clienteNombre = this.options[this.selectedIndex].getAttribute('data-nombre');
                        // Asignar el nombre del cliente al campo de texto de solo lectura
                        document.getElementById('cliente_nombre').value = clienteNombre;
                    });
                    </script>
            </div>

            <div class="col-md-4">
                <label for="descripcion" >Producto:</label> 
                    <select id="descripcion" name="descripcion" class="custom-select">
                    <option value="" disabled selected>Producto</option>
                    <option value="Tabla">Tabla</option>
                    <option value="Escamador">Escamador</option>
                    <option value="Rayador">Rayador</option>
                    <option value="Empujador">Empujador</option>
                </select>
            </div>

        </div>

        
            <div class="form-group row">
                <div class="col-md-2">
                    <label for="ancho" >Ancho:</label> 
                    <input id="ancho" name="ancho" type="number" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="alto" >Alto:</label> 
                    <input id="alto" name="alto" type="number" class="form-control">    
                </div>
                <div class="col-md-2">
                    <label for="grosor" >Grosor:</label> 
                    <select id="grosor" name="grosor" class="custom-select">
                        <option value="" disabled selected>Grosor</option>
                        <option value="0.5">1/2</option>
                        <option value="0.75">3/4</option>
                        <option value="1">1</option>
                        <option value="1.5">1.5</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="cantidad" >Cantidad:</label> 
                    <input id="cantidad" name="cantidad" type="number" class="form-control" required>    
                </div>
                <div class="col-md-2">
                <label for="color" >Color:</label> 
                    <select id="color" name="color" class="custom-select">
                    <option value="" disabled selected>Color</option>
                    <option value="Blanco">Blanco</option>
                    <option value="Amarillo">Amarillo</option>
                    <option value="Azul">Azul</option>
                    <option value="Verde">Verde</option>
                    <option value="Color Especial">Color Especial</option>
                </select>
            </div>
                <div class="col-md-2">
                    <label for="precio_unitario" >Precio unitario:</label> 
                    <input id="precio_unitario" name="precio_unitario" type="number" step="0.01" class="form-control" required>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="agregarProducto()">Agregar Producto</button>
            <hr/>

            <h5>Vista Previa de Orden</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Ancho (cm.)</th>
                        <th>Alto (cm.)</th>
                        <th>Grosor (in)</th>
                        <th>Cantidad</th>
                        <th>Color</th>
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
          

            <button type="button" class="btn btn-success" onclick="guardarFactura()">Guardar Orden de Compra</button>
        </form>
    </div>
    <?php
include "footer.php";
?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
