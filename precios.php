
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
      <?php
include "menu.php";
?>
<h4>Precios cm2</h4>
     
    <form action="procesar_datos.php" method="post">
      <div class="form-group row">
        <label for="select" class="col-4 col-form-label">Grosor</label> 
        <div class="col-8">
          <select id="select" name="grosor" class="custom-select" required="required">
            <option value="0.5">1/2 pulgada</option>
            <option value="1">1 pulgada</option>
            <option value="1.5">1 1/2 pulgada</option>
            <option value="2">2 pulgadas</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="text" class="col-4 col-form-label">Costo por cm2</label> 
        <div class="col-8">
          <input id="text" name="costo_cm_cuadrado" type="text" class="form-control" required="required">
         
        </div>
      </div> 
      <div class="form-group row">
        <div class="offset-4 col-8">
          <button name="submit" type="submit" class="btn btn-success">Registrar Precio</button>
         
        </div>
      </div>


      <div class="form-group row">
        <div class="container">
        <?php
          include "mostrar.php";
          ?>
          
         
        </div>
      </div>


    </form>
   
    </div>
    
          
          
  </body>
</html>
