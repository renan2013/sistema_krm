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

// Consulta SQL para obtener las cotizaciones
$sql = "SELECT c.id, cl.nombre AS cliente, c.grosor, c.largo, c.ancho, c.area, c.costo_total, c.fecha_insercion 
        FROM cotizacion c
        JOIN clientes cl ON c.cliente_id = cl.id_cliente
        ORDER BY c.fecha_insercion DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KRM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="background-color: #FAFAFA;">
    <div class="container ">
        <?php include "menu.php"; ?>
        <h4>Cotizaciones</h4>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Grosor</th>
                    <th>Largo (cm)</th>
                    <th>Ancho (cm)</th>
                    <th>Costo sin impuestos</th>
                    <th>Fecha </th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Mostrar cada fila de resultados
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['cliente']}</td>
                                <td>{$row['grosor']}</td>
                                <td>{$row['largo']}</td>
                                <td>{$row['ancho']}</td>
                                <td>{$row['costo_total']}</td>
                                <td>{$row['fecha_insercion']}</td>
                                <td>
                                    <a href='editar_cotizacion.php?id={$row['id']}' class='btn btn-warning btn-sm'>
                                        <i class='fa fa-pencil'></i>
                                    </a>
                                    <a href='eliminar_cotizacion.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que deseas eliminar esta cotización?\")'>
                                        <i class='fa fa-trash'></i>
                                    </a>
                                    <a href='ver_cotizacion.php?id={$row['id']}' class='btn btn-info btn-sm'>
                                        <i class='fa fa-eye'></i>
                                    </a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay cotizaciones disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
