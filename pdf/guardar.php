<?php


$servername = "localhost"; // Reemplaza con el nombre de tu servidor (localhost si es local)
$username = "u400283574_krm"; // Reemplaza con el nombre de usuario de tu base de datos
$password = "Krm2024!"; // Reemplaza con la contraseña de tu base de datos
$dbname = "u400283574_krm"; // Reemplaza con el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Guardar datos en la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    $sql = "INSERT INTO usuarios (nombre, email, mensaje) VALUES ('$nombre', '$email', '$mensaje')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "Datos guardados con éxito. <a href='generar_pdf.php?id_usuario=$last_id'>Generar PDF</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
