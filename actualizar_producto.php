<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $id_categoria = $_POST['id_categoria'];

    $sql = "UPDATE productos SET nombre_producto = ?, id_categoria = ? WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $nombre_producto, $id_categoria, $id_producto);

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
