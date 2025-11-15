<?php
include 'conexion.php';

// Habilitar el registro de errores para depuración
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log'); // Asegúrate de que este archivo sea escribible por el servidor web

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $id_categoria = $_POST['id_categoria'];
    $ancho = empty($_POST['ancho']) ? NULL : $_POST['ancho'];
    $alto = empty($_POST['alto']) ? NULL : $_POST['alto'];
    $grosor = empty($_POST['grosor']) ? NULL : $_POST['grosor'];
    $color = empty($_POST['color']) ? NULL : $_POST['color'];
    $precio_unitario = empty($_POST['precio_unitario']) ? NULL : $_POST['precio_unitario'];

    // Registrar los datos recibidos para depuración
    error_log("Datos POST recibidos en actualizar_producto.php: " . print_r($_POST, true));
    error_log("Valor de nombre_producto: " . $nombre_producto);

    $sql = "UPDATE productos SET nombre_producto = ?, id_categoria = ?, ancho = ?, alto = ?, grosor = ?, color = ?, precio_unitario = ? WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siddsdi", $nombre_producto, $id_categoria, $ancho, $alto, $grosor, $color, $precio_unitario, $id_producto);

    if ($stmt->execute()) {
        header("Location: producto.php");
        exit();
    } else {
        error_log("Error al actualizar datos: " . $stmt->error); // Registrar el error de la base de datos
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
