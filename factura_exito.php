<?php
include "menu.php";

$factura_id = $_GET['factura_id']; // Obtener el ID de la factura desde la URL
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura Guardada</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Factura guardada con éxito...</h4>
        <p>La factura ha sido insertada correctamente en la base de datos.</p>
        <hr>
        <p class="mb-0">Haz clic en el botón para generar el PDF de la factura.</p>
    </div>
    
    <a href="generar_pdf.php?factura_id=<?php echo $factura_id; ?>" class="btn btn-primary">Generar PDF</a>
</div>
</body>
</html>
