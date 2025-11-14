<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Obtiene los datos del formulario
$id_categoria = $_POST['id_categoria'];
$nombre_producto = $_POST['nombre_producto'];
$ancho = empty($_POST['ancho']) ? NULL : $_POST['ancho'];
$alto = empty($_POST['alto']) ? NULL : $_POST['alto'];
$grosor = empty($_POST['grosor']) ? NULL : $_POST['grosor'];
$color = empty($_POST['color']) ? NULL : $_POST['color'];
$precio_unitario = empty($_POST['precio_unitario']) ? NULL : $_POST['precio_unitario'];

// Prepara la consulta SQL para insertar los datos
$sql = "INSERT INTO productos (id_categoria, nombre_producto, ancho, alto, grosor, color, precio_unitario)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isdddss", $id_categoria, $nombre_producto, $ancho, $alto, $grosor, $color, $precio_unitario);

// Ejecuta la consulta
if ($stmt->execute()) {
    // Redirige a otra página después de la inserción exitosa
    header("Location: producto.php");
    exit(); // Asegúrate de usar exit() para detener el script
} else {
    echo "Error al insertar datos: " . $stmt->error;
}

// Cierra la conexión a la base de datos
$stmt->close();
mysqli_close($conn);
?>
