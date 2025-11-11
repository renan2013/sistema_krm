<?php
include "menu.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>KRM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body style="background-color: #FAFAFA;">
      <div class="container">

<h4>Registrar Cliente</h4>
    <form action="procesar_cliente.php" method="post">
      
        <div class="form-group row">
            <label for="text" class="col-4 col-form-label">Nombre (Contacto)</label> 
            <div class="col-8">
            <input id="text" name="nombre" type="text" class="form-control" required="required">
            </div>
        </div>
        <div class="form-group row">
            <label for="text" class="col-4 col-form-label">Telefono</label> 
            <div class="col-8">
            <input id="text" name="telefono" type="text" class="form-control" required="required">
            </div>
        </div>
        <div class="form-group row">
            <label for="text" class="col-4 col-form-label">Empresa</label> 
            <div class="col-8">
            <input id="text" name="empresa" type="text" class="form-control" >
            
            </div>
        </div>
        <div class="form-group row">
            <label for="text" class="col-4 col-form-label">Dirección</label> 
            <div class="col-8">
            <input id="text" name="direccion" type="text" class="form-control" >
            <br/>
            <button name="submit" type="submit" class="btn btn-success">Registrar Cliente</button>
            </div>
        </div>
        <div class="form-group row">
        <div class="container">
          
          <hr/>
          <?php
          include "mostrar_clientes.php";
          ?>
         
         
        </div>
        
      </div>
        
        
      
    </form>
          </div>
          
  </body>
</html>
<?php
include "footer.php";
?>
