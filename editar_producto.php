<?php
include "menu.php";
include 'conexion.php';

// Obtener el ID del producto de la URL
$id_producto = $_GET['id_producto'];

// --- Obtener datos del producto actual ---
$sql_producto = "SELECT nombre_producto, id_categoria FROM productos WHERE id_producto = ?";
$stmt_producto = $conn->prepare($sql_producto);
$stmt_producto->bind_param("i", $id_producto);
$stmt_producto->execute();
$result_producto = $stmt_producto->get_result();
$producto = $result_producto->fetch_assoc();
$nombre_producto = $producto['nombre_producto'];
$id_categoria_actual = $producto['id_categoria'];
$stmt_producto->close();

// --- Obtener todas las categorías ---
$sql_categorias = "SELECT id_categoria, nombre_categoria FROM categorias";
$result_categorias = $conn->query($sql_categorias);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body style="background-color: #FAFAFA;">
    <div class="container">
        <h4>Editar Producto</h4>
        <form action="actualizar_producto.php" method="post">
            <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
            
            <div class="form-group row">
                <label for="nombre_producto" class="col-4 col-form-label">Nombre Producto</label> 
                <div class="col-8">
                    <input id="nombre_producto" name="nombre_producto" type="text" class="form-control" required="required" value="<?php echo htmlspecialchars($nombre_producto); ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="id_categoria" class="col-4 col-form-label">Categoría</label> 
                <div class="col-8">
                    <select id="id_categoria" name="id_categoria" class="custom-select" required>
                        <option value="" disabled>Seleccione Categoría</option>
                        <?php
                        if ($result_categorias->num_rows > 0) {
                            while($row = $result_categorias->fetch_assoc()) {
                                $selected = ($row["id_categoria"] == $id_categoria_actual) ? "selected" : "";
                                echo "<option value='" . $row["id_categoria"] . "' " . $selected . ">" . htmlspecialchars($row["nombre_categoria"]) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button name="submit" type="submit" class="btn btn-primary">Actualizar Producto</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
include "footer.php";
?>
