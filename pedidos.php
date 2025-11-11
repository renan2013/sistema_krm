<?php
require('fpdf/fpdf.php');

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'u400283574_krm', 'Krm2024!', 'u400283574_krm');

// Obtener el ID del cliente desde la URL
$cliente_id = $_GET['id_cliente'];

// Obtener los datos del cliente
$consulta_cliente = "SELECT * FROM clientes WHERE id_cliente = $cliente_id";
$resultado_cliente = $conexion->query($consulta_cliente);
$cliente = $resultado_cliente->fetch_assoc();

// Obtener los pedidos del cliente
$consulta_pedidos = "SELECT * FROM productos_factura WHERE id_cliente = $cliente_id";
$resultado_pedidos = $conexion->query($consulta_pedidos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos del Cliente</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Pedidos de <?php echo $cliente['nombre']; ?></h2>

        <!-- Mostrar los pedidos -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID del Pedido</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $resultado_pedidos->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo $pedido['fecha']; ?></td>
                        <td>₡ <?php echo number_format($pedido['total'], 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Botón para generar PDF -->
        <a href="generar_pdfs.php?cliente_id=<?php echo $cliente_id; ?>" class="btn btn-success">Generar PDF de Pedidos</a>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
