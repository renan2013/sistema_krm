<?php
// Incluir la conexión y el menú si es necesario
include "menu.php";

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'u400283574_krm', 'Krm2024!', 'u400283574_krm');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si el ID de la factura está presente
if (isset($_GET['factura_id']) && is_numeric($_GET['factura_id'])) {
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

    // Redirigir a la lista de facturas después de eliminar
    header("Location: lista_cotizaciones.php?eliminada=1");
    exit();
} else {
    // Si no hay un ID válido, redirigir a la lista con un mensaje de error
    header("Location: lista_cotizaciones.php?error=1");
    exit();
}
?>
