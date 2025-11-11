<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

// Verificar si se ha enviado el formulario con el id_cliente por POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_cliente'])) {
    // Obtener el id del cliente a eliminar desde POST
    $id = $_POST['id_cliente'];

    // 1. Verificar si el cliente tiene facturas asociadas
    $stmt_check = $conn->prepare("SELECT COUNT(*) FROM facturas WHERE cliente_id = ?");
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $stmt_check->bind_result($count_facturas);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count_facturas > 0) {
        // Si hay facturas asociadas, no se puede eliminar el cliente
        header("Location: cliente.php?error=facturas_existentes");
        exit();
    }

    // 2. Si no hay facturas asociadas, proceder con la eliminación del cliente
    $stmt = $conn->prepare("DELETE FROM clientes WHERE id_cliente = ?");
    $stmt->bind_param("i", $id); // "i" indica que el parámetro es un entero

    if ($stmt->execute()) {
        // Registro eliminado correctamente
        header("Location: cliente.php?deleted=true");
        exit(); // Asegurarse de que el script termine después de la redirección
    } else {
        // En caso de otro error de eliminación
        header("Location: cliente.php?error=delete_failed");
        exit();
    }
} else {
    echo "No se proporcionó un ID de cliente válido.";
}

// Cerrar conexión
$conn->close();
?>
