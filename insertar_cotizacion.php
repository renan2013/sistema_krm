<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "u400283574_krm";
$password = "Krm2024!";
$dbname = "u400283574_krm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los valores del formulario
$cliente_id = $_POST['cliente_id'];
$grosor = (float) $_POST['grosor'];
$largo = (float) $_POST['largo'];
$ancho = (float) $_POST['ancho'];
$costo_cm_cuadrado = (float) $_POST['costo_cm_cuadrado'];

// Calcular área y costo total
$area = $largo * $ancho;
$costo_total = $area * $costo_cm_cuadrado;
$impuesto = $_POST['impuesto'];
$costo_impuesto = $_POST['costo_impuesto'];

// Obtener la fecha y hora actual y restar 6 horas
$fecha = date("Y-m-d H:i:s", strtotime("-6 hours"));

// Depuración: Mostrar los valores antes de ejecutar la consulta
echo "Debugging: cliente_id: $cliente_id, grosor: $grosor, largo: $largo, ancho: $ancho, area: $area, costo_total: $costo_total, costo_cm_cuadrado: $costo_cm_cuadrado, impuesto:$impuesto,costo_impuesto:$costo_impuesto";

// Consulta preparada para insertar una nueva cotización
$sql = "INSERT INTO cotizacion (cliente_id, grosor, largo, ancho, area, costo_total,impuesto, costo_impuesto, costo_cm_cuadrado, fecha_insercion) 
        VALUES ('$cliente_id', '$grosor', '$largo', '$ancho', '$area', '$costo_total','$impuesto','$costo_impuesto', '$costo_cm_cuadrado','$fecha')";


$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}



// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Nueva cotización insertada correctamente";
    header("Location: mostrar_cotizaciones.php");
    exit();

} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
