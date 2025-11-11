<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "u400283574_krm";
$password = "Krm2024!";
$dbname = "u400283574_krm";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID de la categoría desde la solicitud POST
$categoria_id = $_POST['id_categoria'];

// Consulta para obtener los productos de la categoría seleccionada
$sqlProductos = "SELECT nombre_producto FROM productos WHERE id_categoria = $categoria_id";
$resultProductos = $conn->query($sqlProductos);

// Crear las opciones del select
if ($resultProductos->num_rows > 0) {
    while ($row = $resultProductos->fetch_assoc()) {
        // Mostrar el nombre del producto como el valor del option
        echo "<option value='" . $row['nombre_producto'] . "'>" . $row['nombre_producto'] . "</option>";
    }
} else {
    echo "<option value=''>No hay productos disponibles</option>";
}

$conn->close();
?>
