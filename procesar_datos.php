<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Obtiene los datos del formulario
$grosor = $_POST['grosor'];
$costo_cm_cuadrado = $_POST['costo_cm_cuadrado'];
$color = $_POST['color'];
$observaciones = $_POST['observaciones'];

// Prepara la consulta SQL para insertar los datos
$sql = "INSERT INTO tabla_datos (grosor, costo_cm_cuadrado, color, observaciones)
        VALUES ('$grosor', '$costo_cm_cuadrado', '$color', '$observaciones')";

// Ejecuta la consulta
if (mysqli_query($conn, $sql)) {
    // Redirige a otra página después de la inserción exitosa
    header("Location: index.php");
    exit(); // Asegúrate de usar exit() para detener el script
} else {
    echo "Error al insertar datos: " . mysqli_error($conn);
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
