<?php
header('Content-Type: application/json');
include 'conexion.php';

$sql = "SELECT id_categoria, nombre_categoria FROM categorias ORDER BY nombre_categoria ASC";
$result = $conn->query($sql);

$categorias = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
}

$conn->close();
echo json_encode($categorias);
?>
