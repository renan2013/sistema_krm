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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  <script>
    function confirmDelete(event, form) {
      event.preventDefault(); // Prevenir el envío inmediato del formulario
      Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit(); // Si se confirma, enviar el formulario
        }
      });
    }
  </script>
  <script>
    window.onload = function() {
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('deleted') && urlParams.get('deleted') === 'true') {
        if (document.activeElement) {
          document.activeElement.blur();
        }
        // Opcional: Limpiar el parámetro 'deleted' de la URL
        history.replaceState({}, document.title, window.location.pathname);
      }
    };
  </script>
</html>
<?php
include "footer.php";
?>
