
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

// Consulta SQL para obtener los campos grosor y costo_cm_cuadrado de la tabla tabla_datos
$sql = "SELECT id_tabla,grosor, costo_cm_cuadrado FROM tabla_datos";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Salida de los datos de cada fila
    echo "<table class='table table-striped table-bordered'><thead class='thead-dark'><tr><th>Grosor</th><th>Costo (cm²)</th><th>Eliminar</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["grosor"]. "</td><td>" . $row["costo_cm_cuadrado"]. "</td><td><form method='post' action='eliminar.php'>
                        <input type='hidden' name='id_tabla' value='" . $row["id_tabla"] . "'>
                        <input type='submit' class='btn btn-danger btn-sm' value='Eliminar'>
                    </form></td></tr>";
    }
    echo "</table>";
} else {
    echo "0 resultados";
}

// Cerrar conexión
$conn->close();
?>
