<?php
include "menu.php";
?>
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
$sql = "SELECT id_categoria, nombre_categoria FROM categorias";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Cotiza 1.0</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body style="background-color: #FAFAFA;">
      <div class="container">

<h4>Registrar Producto</h4>
    <form action="insertar_producto.php" method="post">
      
        <div class="form-group row">
          <label for="id_categoria" class="col-4 col-form-label">Categoría</label> 
            <div class="col-8">
            
                <select  name="id_categoria" class="custom-select" required>
                    <option value="" disabled selected>Seleccione Categoría</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id_categoria"] .  "'>" . $row["nombre_categoria"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay clientes disponibles</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
       
        <div class="form-group row">
            <label for="nombre_producto" class="col-4 col-form-label">Producto</label> 
            <div class="col-8">
            <input  name="nombre_producto" type="text" class="form-control" required="required">
            </div>
        </div>
        <div class="form-group row">
            <label for="ancho" class="col-4 col-form-label">Ancho (cm)</label> 
            <div class="col-8">
            <input name="ancho" type="number" step="0.01" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="alto" class="col-4 col-form-label">Alto (cm)</label> 
            <div class="col-8">
            <input name="alto" type="number" step="0.01" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="grosor" class="col-4 col-form-label">Grosor (cm)</label> 
            <div class="col-8">
            <input name="grosor" type="number" step="0.01" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="color" class="col-4 col-form-label">Color</label> 
            <div class="col-8">
            <input name="color" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="precio_unitario" class="col-4 col-form-label">Precio Unitario</label> 
            <div class="col-8">
            <input name="precio_unitario" type="number" step="0.01" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-4 col-8">
            <button name="submit" type="submit" class="btn btn-success">Registrar Producto</button>
            </div>
        </div>
    </form>

        <div class="form-group row">
        <div class="container">
       
          <?php
          include "mostrar_productos.php";
          ?>
         
         
        </div>
        
      </div>
        
        
      
    
          </div>
