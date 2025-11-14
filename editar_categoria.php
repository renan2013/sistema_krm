<?php
include "menu.php";
include 'conexion.php';

$id_categoria = $_GET['id_categoria'];

$sql = "SELECT nombre_categoria FROM categorias WHERE id_categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$nombre_categoria = $row['nombre_categoria'];

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoría</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body style="background-color: #FAFAFA;">
    <div class="container">
        <h4>Editar Categoría</h4>
        <form action="actualizar_categoria.php" method="post">
            <input type="hidden" name="id_categoria" value="<?php echo $id_categoria; ?>">
            <div class="form-group row">
                <label for="nombre_categoria" class="col-4 col-form-label">Nombre Categoría</label>
                <div class="col-8">
                    <input id="nombre_categoria" name="nombre_categoria" type="text" class="form-control" required="required" value="<?php echo htmlspecialchars($nombre_categoria); ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button name="submit" type="submit" class="btn btn-primary">Actualizar Categoría</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<?php
include "footer.php";
?>
