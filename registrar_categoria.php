<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Obtiene los datos del formulario
$nombre = $_POST['nombre_categoria'];



// Prepara la consulta SQL para insertar los datos
$sql = "INSERT INTO categorias (nombre_categoria)
        VALUES ('$nombre')";



// Ejecuta la consulta
if (mysqli_query($conn, $sql)) {
    // Redirige a otra página después de la inserción exitosa
    header("Location: categoria.php");
    exit(); // Asegúrate de usar exit() para detener el script
} else {
    echo "Error al insertar datos: " . mysqli_error($conn);
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
