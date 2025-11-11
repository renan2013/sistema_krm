<?php


include "menu.php";
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'u400283574_krm', 'Krm2024!', 'u400283574_krm');

// Obtener el ID de la factura desde la URL
$factura_id = $_GET['factura_id'];

// Eliminar productos asociados a la factura
$consulta_productos = "DELETE FROM productos_factura WHERE factura_id = ?";
$stmt_productos = $conexion->prepare($consulta_productos);
$stmt_productos->bind_param("i", $factura_id);
$stmt_productos->execute();
$stmt_productos->close();

// Eliminar la factura
$consulta_factura = "DELETE FROM facturas WHERE id = ?";
$stmt_factura = $conexion->prepare($consulta_factura);
$stmt_factura->bind_param("i", $factura_id);
$stmt_factura->execute();
$stmt_factura->close();

// Consulta con JOIN para obtener facturas y datos del cliente
$consulta_facturas = "
    SELECT facturas.id, facturas.fecha, clientes.nombre, clientes.empresa 
    FROM facturas
    INNER JOIN clientes ON facturas.cliente_id = clientes.id_cliente
";
$resultado_facturas = $conexion->query($consulta_facturas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cotizaciones</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3>Lista de órdenes de compra</h3>

        <!-- Tabla de cotizaciones -->
        <table class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th>ID Cotización</th>
                    <th>Contacto</th>
                    <th>Empresa</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($factura = $resultado_facturas->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $factura['id']; ?></td>
                        <td><?php echo $factura['nombre']; ?></td>
                        <td><?php echo $factura['empresa']; ?></td>
                        <td><?php echo $factura['fecha']; ?></td>
                        <td>
                            <a href="ver_cotizacion.php?factura_id=<?php echo $factura['id']; ?>" class="btn btn-primary">Ver Orden</a>
                            <a href="eliminar_factura.php?factura_id=<?php echo $factura['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta orden?');">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include "footer.php";
?>