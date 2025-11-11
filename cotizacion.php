<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body style="background-color: #FAFAFA;">
      <div class="container">
      <?php
include "menu.php";
?>
<h4>Cotización</h4>

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

        // Consulta SQL para obtener los clientes
        $sql = "SELECT id_cliente, nombre FROM clientes";
        $result = $conn->query($sql);
        ?>

        <form action="procesar_datos.php" method="post">
          <div class="form-group row">
              <label for="cliente" class="col-4 col-form-label">Cliente</label> 
              <div class="col-8">
                <select id="cliente" name="cliente" class="custom-select" required="required">
                  <option value="" disabled selected>Seleccionar Cliente</option>
                  <?php
                  // Verificar si hay resultados
                  if ($result->num_rows > 0) {
                      // Salida de cada cliente como una opción en el select
                      while($row = $result->fetch_assoc()) {
                          echo "<option value='" . $row["id_cliente"] . "'>" . $row["nombre"] . "</option>";
                      }
                  } else {
                      echo "<option value=''>No hay clientes disponibles</option>";
                  }
                  ?>
                </select>
              </div>
          </div>

          <!-- Campo de selección de grosor -->
          <div class="form-group row">
              <label for="grosor" class="col-4 col-form-label">Grosor (pulgadas)</label> 
              <div class="col-8">
                <select id="grosor" name="grosor" class="custom-select" required="required">
                  <option value="" disabled selected>Seleccionar Grosor</option>
                  <option value="0.5">1/2 pulgada</option>
                  <option value="1">1 pulgada</option>
                  <option value="1.5">1 1/2 pulgada</option>
                  <option value="2">2 pulgadas</option>
                </select>
              </div>
          </div>

          <!-- Los demás campos del formulario -->
          <div class="form-group row">
              <label for="text" class="col-4 col-form-label">Largo (cm.)</label> 
              <div class="col-8">
                <input id="text" name="largo" type="number" class="form-control" required="required">
              </div>
          </div> 

          <div class="form-group row">
              <label for="text" class="col-4 col-form-label">Ancho (cm.)</label> 
              <div class="col-8">
                <input id="text" name="ancho" type="number" class="form-control" required="required">
              </div>
          </div> 

          <div class="form-group row">
              <div class="offset-4 col-8">
                <button name="submit" type="submit" class="btn btn-primary">Cotizar</button>
              </div>
          </div>
        </form>

        <?php
        // Cerrar conexión
        $conn->close();
        ?>
      </div>
  </body>
</html>
