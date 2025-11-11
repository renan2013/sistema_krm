<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'u400283574_krm', 'Krm2024!', 'u400283574_krm');



// Obtener la lista de clientes
$consulta_clientes = "SELECT id_cliente, nombre FROM clientes";
$resultado_clientes = $conexion->query($consulta_clientes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Clientes</h2>

        <!-- Tabla de clientes -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Cliente</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cliente = $resultado_clientes->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $cliente['id_cliente']; ?></td>
                        <td><?php echo $cliente['nombre']; ?></td>
                        <td>
                            <a href="pedidos.php?cliente_id=<?php echo $cliente['id_cliente']; ?>" class="btn btn-primary">Ver Pedidos</a>
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
