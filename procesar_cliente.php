<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Obtiene los datos del formulario
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$empresa = $_POST['empresa'];
$direccion = $_POST['direccion'];


// Prepara la consulta SQL para insertar los datos
$sql = "INSERT INTO clientes (nombre, telefono, empresa, direccion)
        VALUES ('$nombre', '$telefono', '$empresa', '$direccion')";

// Ejecuta la consulta
if (mysqli_query($conn, $sql)) {
    // Redirige a otra página después de la inserción exitosa
    header("Location: cliente.php");
    exit(); // Asegúrate de usar exit() para detener el script
} else {
    echo "Error al insertar datos: " . mysqli_error($conn);
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
