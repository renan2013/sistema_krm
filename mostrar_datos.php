<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mostrar Datos</title>
</head>
<body>
  <?php
   // Conexión a la base de datos (reemplaza con tus credenciales)
  $servername = "localhost"; // Reemplaza con el nombre de tu servidor (localhost si es local)
$username = "u400283574_krm"; // Reemplaza con el nombre de usuario de tu base de datos
$password = "Krm2024!"; // Reemplaza con la contraseña de tu base de datos
$dbname = "u400283574_krm";

  $conn = new mysqli($servername, $username, $password,   
 $dbname);

  // Verificar conexión
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);   

  }

  // Consulta SQL para obtener todos los datos
  $sql = "SELECT  * FROM tabla_datos";
  $result = $conn->query($sql);

  // Mostrar los datos en una tabla
  if ($result->num_rows > 0) {
    echo "<table class='table'>
            <thead>
              <tr>
                <th scope='col'>#</th>
                <th scope='col'>Grosor</th>
                <th scope='col'>Costo por cm²</th>
              </tr>
            </thead>
            <tbody>";
    while($row = $result->fetch_assoc()) {
      echo "<tr>
              <td>" . $row["id_tabla"] . "</td>
              <td>" . $row["grosor"] . "</td>
              <td>" . $row["costo_cm_cuadrado"] . "</td>
            </tr>";
    }
    echo "</tbody>
          </table>";
  } else {
    echo "0 results";
  }

  $conn->close();
  ?>
</body>
</html>