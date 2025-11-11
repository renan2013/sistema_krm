<?php

include "menu.php";
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'u400283574_krm', 'Krm2024!', 'u400283574_krm');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener el ID de la factura desde la URL
$factura_id = $_GET['factura_id'];

// Consulta para obtener los datos de la factura y el cliente
$sql_factura = "
    SELECT facturas.id, facturas.fecha, clientes.nombre, clientes.empresa
    FROM facturas
    INNER JOIN clientes ON facturas.cliente_id = clientes.id_cliente
    WHERE facturas.id = ?
";
$stmt_factura = $conexion->prepare($sql_factura);
$stmt_factura->bind_param("i", $factura_id);
$stmt_factura->execute();
$result_factura = $stmt_factura->get_result();
$factura = $result_factura->fetch_assoc();
$stmt_factura->close();

// Verificar si se encontró la factura
if (!$factura) {
    echo "Factura no encontrada.";
    exit();
}

// Consulta para obtener los productos asociados a la factura
$sql_productos = "SELECT * FROM productos_factura WHERE factura_id = ?";
$stmt_productos = $conexion->prepare($sql_productos);
$stmt_productos->bind_param("i", $factura_id);
$stmt_productos->execute();
$result_productos = $stmt_productos->get_result();
$productos = $result_productos->fetch_all(MYSQLI_ASSOC);
$stmt_productos->close();

// Calcular la suma total de los productos
$total_general = 0;
foreach ($productos as $producto) {
    $total_general += $producto['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Cotización</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
       .derecha { 
        float:right;
        padding-right: 12px; 
    }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h4>Detalles de la Orden de Compra</h4>
        <p><strong>ID Orden:</strong> <?php echo $factura['id']; ?></p>
        <p><strong>Fecha:</strong> <?php echo $factura['fecha']; ?></p>
        <p><strong>Cliente:</strong> <?php echo $factura['nombre']; ?></p>
        <p><strong>Empresa:</strong> <?php echo $factura['empresa']; ?></p>

        <h4>Productos de la Orden de Compra</h4>
        <table class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Ancho (cm)</th>
                    <th>Alto (cm)</th>
                    <th>Grosor (in)</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario (₡)</th>
                    <th>Total (₡)</th>
                </tr>
               
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) { ?>
                    <tr>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td><?php echo number_format($producto['ancho'], 2); ?></td>
                        <td><?php echo number_format($producto['alto'], 2); ?></td>
                        <td><?php echo number_format($producto['grosor'], 2); ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo number_format($producto['precio_unitario'], 2); ?></td>
                        <td ALIGN="right"><?php echo number_format($producto['total'], 2); ?></td>
                    </tr>
                  
                   
                    
                <?php } ?>
            </tbody>
            
        </table>

        <!-- Mostrar la suma total de los productos -->

        <table class="table table-bordered">
           <tr>
           &nbsp;&nbsp;Total General:
           
           

           <strong><span class="derecha"><?php echo number_format($total_general, 2); ?></span></strong>
          
           </tr>
           
            
        </table>
      

        <a href="pdf/generar_pdf.php?factura_id=<?php echo $factura_id; ?>" class="btn btn-primary">Generar PDF</a>
    </div>
    <?php
include "footer.php";
?>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>
