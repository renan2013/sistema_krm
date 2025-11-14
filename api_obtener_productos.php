<?php
header('Content-Type: application/json');
include 'conexion.php';

$id_categoria = isset($_GET['id_categoria']) ? (int)$_GET['id_categoria'] : 0;

if ($id_categoria > 0) {
    $sql = "SELECT id_producto, nombre_producto FROM productos WHERE id_categoria = ? ORDER BY nombre_producto ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = array();
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    $stmt->close();
} else {
    $productos = array(); // Devuelve un array vacío si no se proporciona una categoría válida
}

$conn->close();
echo json_encode($productos);
?>
