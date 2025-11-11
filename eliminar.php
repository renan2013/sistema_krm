<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "u400283574_krm";
$password = "Krm2024!";
$dbname = "u400283574_krm";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el id del registro a eliminar
$id = $_POST['id_tabla'];

// Consulta SQL para eliminar el registro
$sql = "DELETE FROM tabla_datos WHERE id_tabla='$id'";

if (mysqli_query($conn, $sql)) {
    echo "Registro eliminado correctamente";
    // Redirigir a la página anterior o a la página principal
    header("Location: index.php");
    exit();
} else {
    echo "Error al eliminar el registro: " . mysqli_error($conn);
}

// Cerrar conexión
mysqli_close($conn);
?>
