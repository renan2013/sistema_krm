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
$sql = "SELECT id_categoria, nombre_categoria FROM categorias";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Salida de los datos de cada fila
    echo "<table class='table table-striped table-bordered'><thead class='thead-dark'><tr>
        <th>id_categoria</th>
        <th>Nombre Categoría</th>
        
        <th>Editar</th>
        <th>Eliminar</th>
    </tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id_categoria"]. "</td>
                <td>" . ucfirst($row["nombre_categoria"]). "</td>
               
                <td>
                    <form method='get' action='editar_categoria.php'>
                        <input type='hidden' name='id_categoria' value='" . $row["id_categoria"] . "'>
                        <input type='submit' class='btn btn-warning btn-sm' value='Editar'>
                    </form>
                </td>
                <td>
                    <form method='post' action='eliminar_categoria.php'>
                        <input type='hidden' name='id_categoria' value='" . $row["id_categoria"] . "'>
                        <input type='submit' class='btn btn-danger btn-sm' value='Eliminar'>
                    </form>
                    
                </td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "0 resultados";
}

// Cerrar conexión
$conn->close();
?>
