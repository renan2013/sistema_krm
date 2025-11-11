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

// Verificar si los datos han sido enviados por el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $cliente_id = $_POST['cliente_id'];
    $grosor = (float)$_POST['grosor'];
    $largo = (float)$_POST['largo'];
    $ancho = (float)$_POST['ancho'];
    $costo_cm_cuadrado = (float)$_POST['costo_cm_cuadrado'];
    $area = (float)$_POST['area'];
    $costo_total = (float)$_POST['costo_total'];
    $impuesto = (float)$_POST['impuesto'];
    $costo_impuesto = (float)$_POST['costo_impuesto'];
    $fecha_insercion = $_POST['fecha_insercion']; // Asegúrate de que el formato es 'Y-m-d H:i:s'

    // Imprimir para depuración
    echo "ID: $id<br>";
    echo "Cliente ID: $cliente_id<br>";
    echo "Grosor: $grosor<br>";
    echo "Largo: $largo<br>";
    echo "Ancho: $ancho<br>";
    echo "Costo cm²: $costo_cm_cuadrado<br>";
    echo "Área: $area<br>";
    echo "Costo Total: $costo_total<br>";
    echo "Impuesto: $impuesto<br>";
    echo "Costo con Impuesto: $costo_impuesto<br>";
    echo "Fecha de Inserción: $fecha_insercion<br>";

    // Preparar consulta
    $sql = "UPDATE cotizacion SET 
                cliente_id = ?, 
                grosor = ?, 
                largo = ?, 
                ancho = ?, 
                costo_cm_cuadrado = ?, 
                area = ?, 
                costo_total = ?, 
                impuesto = ?, 
                costo_impuesto = ?, 
                fecha_insercion = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Nota: el parámetro para la fecha debe ser 's' para string
    $stmt->bind_param('iddddddddsi', 
        $cliente_id, 
        $grosor, 
        $largo, 
        $ancho, 
        $costo_cm_cuadrado, 
        $area, 
        $costo_total, 
        $impuesto, 
        $costo_impuesto, 
        $fecha_insercion, 
        $id
    );

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Actualización exitosa.";
        } else {
            echo "Actualización exitosa, pero ninguna fila fue modificada.";
        }
        header("Location: mostrar_cotizaciones.php");
        exit;
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
