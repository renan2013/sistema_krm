<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Habilitar el registro de errores para depuración
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log'); // Asegúrate de que este archivo sea escribible por el servidor web

// Obtiene los datos del formulario
$id_categoria = $_POST['id_categoria'];
$nombre_producto = $_POST['nombre_producto'];
$ancho = empty($_POST['ancho']) ? NULL : $_POST['ancho'];
$alto = empty($_POST['alto']) ? NULL : $_POST['alto'];
$grosor = empty($_POST['grosor']) ? NULL : $_POST['grosor'];
$color = empty($_POST['color']) ? NULL : $_POST['color'];
$precio_unitario = empty($_POST['precio_unitario']) ? NULL : $_POST['precio_unitario'];

// Registrar los datos recibidos para depuración
error_log("Datos POST recibidos en insertar_producto.php: " . print_r($_POST, true));
error_log("Valor de nombre_producto: " . $nombre_producto);

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
    error_log("Error al insertar datos: " . $stmt->error); // Registrar el error de la base de datos
    echo "Error al insertar datos: " . $stmt->error;
}

// Cierra la conexión a la base de datos
$stmt->close();
mysqli_close($conn);
?>
