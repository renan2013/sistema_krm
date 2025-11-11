<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Obtiene los datos del formulario
$id_categoria = $_POST['id_categoria'];
$nombre_producto = $_POST['nombre_producto'];


// Prepara la consulta SQL para insertar los datos
$sql = "INSERT INTO productos (id_categoria, nombre_producto)
        VALUES ('$id_categoria', '$nombre_producto')";

// Ejecuta la consulta
if (mysqli_query($conn, $sql)) {
    // Redirige a otra página después de la inserción exitosa
    header("Location: producto.php");
    exit(); // Asegúrate de usar exit() para detener el script
} else {
    echo "Error al insertar datos: " . mysqli_error($conn);
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
