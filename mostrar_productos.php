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





$sql= "SELECT productos.id_producto,nombre_producto, categorias.nombre_categoria 
FROM productos   
INNER JOIN categorias  
ON productos.id_categoria = categorias.id_categoria
ORDER BY nombre_categoria ASC";



$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Salida de los datos de cada fila
    echo "<table class='table table-striped table-bordered'><thead class='thead-dark'><tr>
        <th>Categoría</th>
        <th>Producto</th>
        
        <th>Editar</th>
        <th>Eliminar</th>
    </tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . ucfirst($row["nombre_categoria"]). "</td>
                <td>" . ucfirst($row["nombre_producto"]). "</td>
               
                <td>
                    <form method='get' action='editar_producto.php'>
                        <input type='hidden' name='id_producto' value='" . $row["id_producto"] . "'>
                        <input type='submit' class='btn btn-warning btn-sm' value='Editar'>
                    </form>
                </td>
                <td>
                    <form method='post' action='eliminar_producto.php'>
                        <input type='hidden' name='id_producto' value='" . $row["id_producto"] . "'>
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
