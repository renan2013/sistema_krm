<?php
$servername = "localhost"; // Reemplaza con el nombre de tu servidor (localhost si es local)
$username = "u400283574_krm"; // Reemplaza con el nombre de usuario de tu base de datos
$password = "Krm2024!"; // Reemplaza con la contraseña de tu base de datos
$dbname = "u400283574_krm"; // Reemplaza con el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
//echo "Conexión exitosa"; // Puedes usar esta línea para verificar si la conexión se estableció correctamente
?>