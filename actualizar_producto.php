<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $id_categoria = $_POST['id_categoria'];
    $ancho = empty($_POST['ancho']) ? NULL : $_POST['ancho'];
    $alto = empty($_POST['alto']) ? NULL : $_POST['alto'];
    $grosor = empty($_POST['grosor']) ? NULL : $_POST['grosor'];
    $color = empty($_POST['color']) ? NULL : $_POST['color'];
    $precio_unitario = empty($_POST['precio_unitario']) ? NULL : $_POST['precio_unitario'];

    $sql = "UPDATE productos SET nombre_producto = ?, id_categoria = ?, ancho = ?, alto = ?, grosor = ?, color = ?, precio_unitario = ? WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdddssi", $nombre_producto, $id_categoria, $ancho, $alto, $grosor, $color, $precio_unitario, $id_producto);

    if ($stmt->execute()) {
        header("Location: producto.php");
        exit();
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
