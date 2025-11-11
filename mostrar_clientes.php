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
$sql = "SELECT id_cliente, nombre, telefono, empresa, direccion FROM clientes";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Salida de los datos de cada fila
    ?>
    <table class='table table-striped table-bordered'><thead class='thead-dark'><tr>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Empresa</th>
        <th>Dirección</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr></thead><tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row["nombre"]; ?></td>
            <td><?php echo $row["telefono"]; ?></td>
            <td><?php echo $row["empresa"]; ?></td>
            <td><?php echo $row["direccion"]; ?></td>
            <td>
                <a href="editar_cliente.php?id_cliente=<?php echo $row["id_cliente"]; ?>" class="btn btn-warning btn-sm">Editar</a>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteClientAjax(<?php echo $row['id_cliente']; ?>, this.closest('tr'))">Eliminar</button>
            </td>
        </tr>
    <?php } ?>
    </tbody></table>
    <?php

} else {
    echo "0 resultados";
}

// Cerrar conexión
$conn->close();
?>
