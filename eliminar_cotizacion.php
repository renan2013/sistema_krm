<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Cambia esto por tu servidor
$username = "u400283574_krm"; // Cambia esto por tu nombre de usuario
$password = "Krm2024!"; // Cambia esto por tu contraseña
$dbname = "u400283574_krm"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha pasado el ID de la cotización para eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para eliminar la cotización
    $sql = "DELETE FROM cotizacion WHERE id = ?";

    // Preparar la consulta
    if ($stmt = $conn->prepare($sql)) {
        // Vincular el parámetro ID
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro eliminado correctamente";
    // Redirigir a la página anterior o a la página principal
    header("Location: mostrar_cotizaciones.php");
    exit();
        } else {
            echo "<script>alert('Error al eliminar la cotización.');</script>";
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "<script>alert('Error al preparar la consulta.');</script>";
    }
} else {
    echo "<script>alert('No se proporcionó un ID válido para la cotización.');</script>";
}

// Cerrar conexión
$conn->close();

// Redireccionar a la página de cotizaciones después de eliminar
echo "<script>window.location.href = 'mostrar_cotizaciones.php';</script>";
?>
