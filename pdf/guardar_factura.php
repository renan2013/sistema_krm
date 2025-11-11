<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Capturar la entrada JSON enviada desde fetch
$input = file_get_contents("php://input");

// Decodificar los datos JSON
$data = json_decode($input, true);

// Verificar si los datos se han decodificado correctamente
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["success" => false, "message" => "Error al decodificar JSON: " . json_last_error_msg()]);
    exit();
}


// Verificar que se estén enviando 'cliente_id' y 'productos'
if (isset($data['cliente_id']) && isset($data['productos']) && count($data['productos']) > 0) {
    $cliente_id = $data['cliente_id'];
    $productos = $data['productos'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Insertar la factura con 6 horas menos
    $stmt = $conn->prepare("INSERT INTO facturas (cliente_id, fecha) VALUES (?, DATE_SUB(NOW(), INTERVAL 6 HOUR))");
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $factura_id = $stmt->insert_id;
    $stmt->close();

        // Insertar los productos
        $stmt = $conn->prepare("INSERT INTO productos_factura (factura_id, descripcion, ancho, alto, grosor, cantidad, color, precio_unitario, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($productos as $producto) {
            $stmt->bind_param("isdidisdd", $factura_id, $producto['descripcion'], $producto['ancho'], $producto['alto'], $producto['grosor'], $producto['cantidad'],$producto['color'], $producto['precioUnitario'], $producto['total']);
            $stmt->execute();
        }
        $stmt->close();

      

        // Confirmar la transacción
$conn->commit();
echo json_encode(["success" => true, "message" => "Factura guardada exitosamente.", "factura_id" => $factura_id]);




    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Datos no válidos. Faltan cliente_id o productos."]);
}

// Cerrar la conexión
$conn->close();
?>
