<?php
include "menu.php";
?>

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

// Obtener el ID del cliente desde la URL
$cliente_id = $_GET['id_cliente'];

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $empresa = $_POST['empresa'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    // Actualizar los datos del cliente en la base de datos
    $sql = "UPDATE clientes SET nombre = ?, empresa = ?, direccion = ?, telefono = ? WHERE id_cliente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $empresa, $direccion, $telefono, $cliente_id);

    if ($stmt->execute()) {
        // Redirigir a cliente.php después de actualizar
        header("Location: cliente.php");
        exit(); // Detener la ejecución después de redirigir
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar cliente: " . $conn->error . "</div>";
    }

    $stmt->close();
}

// Consultar los datos del cliente actual
$sql = "SELECT * FROM clientes WHERE id_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <!-- Agregar enlace a Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Cliente</h2>
        <form method="POST" class="border p-4 rounded shadow-sm bg-light">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" >
            </div>
            <div class="form-group">
                <label>Empresa:</label>
                <input type="text" name="empresa" class="form-control" value="<?php echo htmlspecialchars($cliente['empresa']); ?>" >
            </div>
            <div class="form-group">
                <label>direccion:</label>
                <input type="email" name="direccion" class="form-control" value="<?php echo htmlspecialchars($cliente['direccion']); ?>" >
            </div>
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($cliente['telefono']); ?>" >
            </div>
            <input type="submit" class="btn btn-primary btn-block" value="Actualizar">
        </form>
    </div>

    <!-- Agregar enlace a Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
