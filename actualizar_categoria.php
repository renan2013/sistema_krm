<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_categoria = $_POST['id_categoria'];
    $nombre_categoria = $_POST['nombre_categoria'];

    $sql = "UPDATE categorias SET nombre_categoria = ? WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre_categoria, $id_categoria);

    if ($stmt->execute()) {
        header("Location: categoria.php");
        exit();
    } else {
        echo "Error al actualizar la categoría: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
