<?php
include "menu.php";
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
        <h4>Registrar Categoría</h4>
        <form action="registrar_categoria.php" method="post">
            <div class="form-group row">
                <label for="text" class="col-4 col-form-label">Nombre Categoría</label> 
                <div class="col-8">
                <input  name="nombre_categoria" type="text" class="form-control" required="required">
                <br/>
                <button name="submit" type="submit" class="btn btn-success">Registrar Categoria</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
    <hr/>
          <?php
          include "mostrar_categorias.php";
          ?>
        
    </div>
    
          
  </body>
</html>
<?php
include "footer.php";
?>
