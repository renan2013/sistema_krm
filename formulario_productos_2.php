<?php
include "menu.php";
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
$sql = "SELECT id_cliente, empresa FROM clientes";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cotización</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            padding: 10px;
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
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoriaSelect = document.getElementById('categoria');
            const productoSelect = document.getElementById('descripcion');
            const anchoInput = document.getElementById('ancho');
            const altoInput = document.getElementById('alto');
            const grosorSelect = document.getElementById('grosor');
            const colorSelect = document.getElementById('color'); // Cambiado a colorSelect
            const precioUnitarioInput = document.getElementById('precio_unitario');

            let productsData = {}; // Para almacenar los detalles completos de los productos

            // Cargar categorías al iniciar
            fetch('api_obtener_categorias.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id_categoria;
                        option.textContent = categoria.nombre_categoria;
                        categoriaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar categorías:', error));

            // Cargar productos cuando se selecciona una categoría
            categoriaSelect.addEventListener('change', function() {
                const categoriaId = this.value;
                productoSelect.innerHTML = '<option value="" disabled selected>Seleccione un producto</option>';
                productoSelect.disabled = true;
                // Limpiar campos de detalles del producto al cambiar de categoría
                anchoInput.value = "";
                altoInput.value = "";
                grosorSelect.selectedIndex = 0;
                colorSelect.selectedIndex = 0; // Cambiado a colorSelect
                precioUnitarioInput.value = "";
                productsData = {}; // Limpiar datos de productos anteriores

                if (categoriaId) {
                    fetch(`api_obtener_productos.php?id_categoria=${categoriaId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(producto => {
                                    productsData[producto.id_producto] = producto; // Almacenar el objeto completo
                                    const option = document.createElement('option');
                                    option.value = producto.id_producto; // Usar id_producto como valor
                                    option.textContent = producto.nombre_producto;
                                    productoSelect.appendChild(option);
                                });
                                productoSelect.disabled = false;
                            } else {
                                productoSelect.innerHTML = '<option value="" disabled selected>No hay productos en esta categoría</option>';
                            }
                        })
                        .catch(error => console.error('Error al cargar productos:', error));
                }
            });

            // Rellenar campos al seleccionar un producto
            productoSelect.addEventListener('change', function() {
                const selectedProductId = this.value;
                const selectedProduct = productsData[selectedProductId];

                if (selectedProduct) {
                    anchoInput.value = selectedProduct.ancho !== null ? selectedProduct.ancho : "";
                    altoInput.value = selectedProduct.alto !== null ? selectedProduct.alto : "";
                    // Para el grosor, buscar la opción que coincida con el valor
                    if (selectedProduct.grosor !== null) {
                        let grosorFound = false;
                        for (let i = 0; i < grosorSelect.options.length; i++) {
                            if (parseFloat(grosorSelect.options[i].value) === parseFloat(selectedProduct.grosor)) {
                                grosorSelect.selectedIndex = i;
                                grosorFound = true;
                                break;
                            }
                        }
                        if (!grosorFound) {
                            grosorSelect.selectedIndex = 0; // Seleccionar la opción por defecto si no se encuentra
                        }
                    } else {
                        grosorSelect.selectedIndex = 0; // Seleccionar la opción por defecto si es null
                    }
                    // Para el color, buscar la opción que coincida con el valor
                    if (selectedProduct.color !== null) {
                        let colorFound = false;
                        for (let i = 0; i < colorSelect.options.length; i++) {
                            if (colorSelect.options[i].value === selectedProduct.color) {
                                colorSelect.selectedIndex = i;
                                colorFound = true;
                                break;
                            }
                        }
                        if (!colorFound) {
                            colorSelect.selectedIndex = 0; // Seleccionar la opción por defecto si no se encuentra
                        }
                    } else {
                        colorSelect.selectedIndex = 0; // Seleccionar la opción por defecto si es null
                    }
                    precioUnitarioInput.value = selectedProduct.precio_unitario !== null ? selectedProduct.precio_unitario : "";
                } else {
                    // Limpiar si no se encuentra el producto (ej. opción por defecto)
                    anchoInput.value = "";
                    altoInput.value = "";
                    grosorSelect.selectedIndex = 0;
                    colorSelect.selectedIndex = 0; // Cambiado a colorSelect
                    precioUnitarioInput.value = "";
                }
            });
        });

        let productos = [];

        function agregarProducto() {
            const productoSelect = document.getElementById('descripcion');
            const descripcion = productoSelect.options[productoSelect.selectedIndex].textContent; // Obtener el texto visible
            const ancho = parseFloat(document.getElementById('ancho').value) || 0;
            const alto = parseFloat(document.getElementById('alto').value) || 0;
            const grosor = parseFloat(document.getElementById('grosor').value) || 0;
            const color = document.getElementById('color').value;
            const cantidad = parseFloat(document.getElementById('cantidad').value);
            const precioUnitario = parseFloat(document.getElementById('precio_unitario').value);
            const total = cantidad * precioUnitario;

            if (!descripcion || isNaN(cantidad) || isNaN(precioUnitario)) {
                alert('Por favor, complete todos los campos requeridos (Producto, Cantidad, Precio Unitario).');
                return;
            }

            productos.push({ descripcion, ancho, alto, grosor, color, cantidad, precioUnitario, total });
            actualizarVistaPrevia();
            limpiarCampos();
        }

        function limpiarCampos() {
            document.getElementById('categoria').selectedIndex = 0;
            document.getElementById('descripcion').innerHTML = '<option value="" disabled selected>Seleccione una categoría primero</option>';
            document.getElementById('descripcion').disabled = true;
            document.getElementById('ancho').value = "";
            document.getElementById('alto').value = "";
            document.getElementById('grosor').selectedIndex = 0;
            document.getElementById('color').selectedIndex = 0; // Resetear el select de color
            document.getElementById('cantidad').value = "";
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
                row.insertCell(4).innerHTML = producto.cantidad;
                row.insertCell(5).innerHTML = producto.precioUnitario.toFixed(2);
                row.insertCell(6).innerHTML = producto.total.toFixed(2);

                const eliminarCelda = row.insertCell(7);
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
            rowFooter.insertCell(6).innerHTML = subtotal.toFixed(2);
        }

        function eliminarProducto(index) {
            productos.splice(index, 1); // Eliminar producto del array
            actualizarVistaPrevia(); // Actualizar la tabla
        }

        function guardarFactura() {
            const cliente_id = document.getElementById('cliente').value;

            if (!cliente_id || productos.length === 0) {
                alert('Debe seleccionar un cliente y agregar al menos un producto.');
                return;
            }

            const datos = {
                cliente_id,
                productos
            };

            fetch('pdf/guardar_factura.php', {
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
        <h4 class="mt-4">Crear orden de compra</h4>
        <form>
            <div class="form-group row">
                <label for="cliente" class="col-md-4 col-form-label">Empresa (Cliente)</label> 
                <div class="col-md-8">
                    <select id="cliente" name="cliente" class="custom-select" required>
                        <option value="" disabled selected>Seleccionar Empresa (Cliente)</option>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["id_cliente"] . "'>" . $row["empresa"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay clientes disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="categoria" class="col-md-4 col-form-label">Categoría:</label>
                <div class="col-md-8">
                    <select id="categoria" name="categoria" class="custom-select" required>
                        <option value="" disabled selected>Seleccione una categoría</option>
                        <!-- Las categorías se cargarán aquí dinámicamente -->
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="descripcion" class="col-md-4 col-form-label">Producto:</label>
                <div class="col-md-8">
                    <select id="descripcion" name="descripcion" class="custom-select" required disabled>
                        <option value="" disabled selected>Seleccione una categoría primero</option>
                        <!-- Los productos se cargarán aquí dinámicamente -->
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="ancho" class="col-md-4 col-form-label">Ancho:</label> 
                <div class="col-md-8">
                    <input id="ancho" name="ancho" type="number" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="alto" class="col-md-4 col-form-label">Alto:</label> 
                <div class="col-md-8">
                    <input id="alto" name="alto" type="number" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="grosor" class="col-md-4 col-form-label">Grosor:</label> 
                <div class="col-md-8">
                    
                    <select id="grosor" name="grosor" class="custom-select">
                    <option value="" disabled selected>Seleccione el grosor</option>
                    <option value="0.5">1/2</option>
                    <option value="1">1</option>
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="cantidad" class="col-md-4 col-form-label">Cantidad:</label> 
                <div class="col-md-8">
                    <input id="cantidad" name="cantidad" type="number" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="color" class="col-md-4 col-form-label">Color:</label> 
                <div class="col-md-8">
                    <select id="color" name="color" class="custom-select">
                        <option value="" disabled selected>Seleccione un color</option>
                        <option value="Blanco">Blanco</option>
                        <option value="Rojo">Rojo</option>
                        <option value="Azul">Azul</option>
                        <option value="Verde">Verde</option>
                        <option value="Amarillo">Amarillo</option>
                        <option value="Transparente">Especial</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="precio_unitario" class="col-md-4 col-form-label">Precio unitario:</label> 
                <div class="col-md-8">
                    <input id="precio_unitario" name="precio_unitario" type="number" step="0.01" class="form-control" required>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="agregarProducto()">Agregar Producto</button>
            <hr/>

            <h4>Vista Previa de Factura</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Ancho</th>
                        <th>Alto</th>
                        <th>Grosor</th>
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
          

            <button type="button" class="btn btn-success" onclick="guardarFactura()">Guardar Factura</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include "footer.php";
?>
<?php
$conn->close();
?>
