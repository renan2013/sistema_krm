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

// Obtener el ID de la cotización desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $cliente_id = $_POST['cliente_id'];
    $grosor = $_POST['grosor'];
    $largo = $_POST['largo'];
    $ancho = $_POST['ancho'];
    $costo_cm_cuadrado = $_POST['costo_cm_cuadrado'];
    $area = $_POST['area'];
    $costo_total = $_POST['costo_total'];
    $impuesto = $_POST['impuesto'];
    $costo_impuesto = $_POST['costo_impuesto'];
    $fecha_insercion = date('Y-m-d H:i:s', strtotime($_POST['fecha_insercion'])); // Ajuste de la fecha si es necesario

    // Actualizar la cotización en la base de datos
    $sql = "UPDATE cotizacion SET 
                cliente_id = ?, 
                grosor = ?, 
                largo = ?, 
                ancho = ?, 
                costo_cm_cuadrado = ?, 
                area = ?, 
                costo_total = ?, 
                impuesto = ?, 
                costo_impuesto = ?, 
                fecha_insercion = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiddddddds', $cliente_id, $grosor, $largo, $ancho, $costo_cm_cuadrado, $area, $costo_total, $impuesto, $costo_impuesto, $fecha_insercion, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Cotización actualizada con éxito</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar la cotización: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Consultar la cotización a editar
$sql = "SELECT c.id, c.cliente_id, c.grosor, c.largo, c.ancho, c.costo_cm_cuadrado, c.area, c.costo_total, c.impuesto, c.costo_impuesto, c.fecha_insercion, cl.nombre 
        FROM cotizacion c
        JOIN clientes cl ON c.cliente_id = cl.id_cliente
        WHERE c.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cotizacion = $result->fetch_assoc();
} else {
    die("Cotización no encontrada");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cotización</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function updateCost() {
            var grosorSelect = document.getElementById('grosor');
            var selectedOption = grosorSelect.options[grosorSelect.selectedIndex];
            var costo_cm_cuadrado = selectedOption.getAttribute('data-costo');
            document.getElementById('costo_cm_cuadrado').value = costo_cm_cuadrado;
            calculateArea();
        }

        function calculateArea() {
            var largo = parseFloat(document.getElementById('largo').value) || 0;
            var ancho = parseFloat(document.getElementById('ancho').value) || 0;
            var area = largo * ancho;
            var costoPorCm2 = parseFloat(document.getElementById('costo_cm_cuadrado').value) || 0;
            var totalCost = area * costoPorCm2;
            var impuesto = totalCost * 0.13; // 13% de impuesto
            var costoImpuesto = totalCost + impuesto;
            document.getElementById('area').value = area.toFixed(2);
            document.getElementById('costo_total').value = totalCost.toFixed(2);
            document.getElementById('impuesto').value = impuesto.toFixed(2);
            document.getElementById('costo_impuesto').value = costoImpuesto.toFixed(2);
        }

        window.onload = updateCost;
    </script>
</head>
<body style="background-color: #FAFAFA;">
    <div class="container">
        <?php include "menu.php"; ?>
        <h4>Editar Cotización</h4>

        <form action="actualizar_cotizacion.php?id=<?php echo $id; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group row">
                <label for="cliente_id" class="col-4 col-form-label">Cliente</label>
                <div class="col-8">
                    <select id="cliente_id" name="cliente_id" class="custom-select" required="required">
                        <option value="">Seleccionar Cliente</option>
                        <?php
                        // Obtener la lista de clientes para el select
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        $sqlClientes = "SELECT id_cliente, nombre FROM clientes";
                        $resultClientes = $conn->query($sqlClientes);
                        if ($resultClientes->num_rows > 0) {
                            while ($row = $resultClientes->fetch_assoc()) {
                                $selected = $cotizacion['cliente_id'] == $row['id_cliente'] ? 'selected' : '';
                                echo "<option value='" . $row['id_cliente'] . "' $selected>" . $row['nombre'] . "</option>";
                            }
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="grosor" class="col-4 col-form-label">Grosor (pulgadas)</label>
                <div class="col-8">
                    <select id="grosor" name="grosor" class="custom-select" required="required" onchange="updateCost()">
                        <option value="" disabled>Seleccionar Grosor</option>
                        <?php
                        // Obtener la lista de grosores para el select
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        $sqlGrosor = "SELECT grosor, costo_cm_cuadrado FROM tabla_datos";
                        $resultGrosor = $conn->query($sqlGrosor);
                        if ($resultGrosor->num_rows > 0) {
                            while ($row = $resultGrosor->fetch_assoc()) {
                                $selected = $cotizacion['grosor'] == $row['grosor'] ? 'selected' : '';
                                echo "<option value='" . $row['grosor'] . "' data-costo='" . $row['costo_cm_cuadrado'] . "' $selected>" . $row['grosor'] . " pulgada(s)</option>";
                            }
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="costo_cm_cuadrado" class="col-4 col-form-label">Costo (¢)</label>
                <div class="col-8">
                    <input id="costo_cm_cuadrado" name="costo_cm_cuadrado" type="number" class="form-control" readonly value="<?php echo htmlspecialchars($cotizacion['costo_cm_cuadrado']); ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="largo" class="col-4 col-form-label">Largo (cm.)</label>
                <div class="col-8">
                    <input id="largo" name="largo" type="number" step="0.01" class="form-control" required="required" value="<?php echo htmlspecialchars($cotizacion['largo']); ?>" oninput="calculateArea()">
                </div>
            </div>

            <div class="form-group row">
                <label for="ancho" class="col-4 col-form-label">Ancho (cm.)</label>
                <div class="col-8">
                    <input id="ancho" name="ancho" type="number" step="0.01" class="form-control" required="required" value="<?php echo htmlspecialchars($cotizacion['ancho']); ?>" oninput="calculateArea()">
                </div>
            </div>

            <div class="form-group row">
                <label for="area" class="col-4 col-form-label">Área (cm²)</label>
                <div class="col-8">
                    <input id="area" name="area" type="number" class="form-control" readonly value="<?php echo htmlspecialchars($cotizacion['area']); ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="costo_total" class="col-4 col-form-label">Costo Total (¢)</label>
                <div class="col-8">
                    <input id="costo_total" name="costo_total" type="number" class="form-control" readonly value="<?php echo htmlspecialchars($cotizacion['costo_total']); ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="impuesto" class="col-4 col-form-label">Impuesto (¢)</label>
                <div class="col-8">
                    <input id="impuesto" name="impuesto" type="number" class="form-control" readonly value="<?php echo htmlspecialchars($cotizacion['impuesto']); ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="costo_impuesto" class="col-4 col-form-label">Costo con Impuesto (¢)</label>
                <div class="col-8">
                    <input id="costo_impuesto" name="costo_impuesto" type="number" class="form-control" readonly value="<?php echo htmlspecialchars($cotizacion['costo_impuesto']); ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="fecha_insercion" class="col-4 col-form-label">Fecha Inserción</label>
                <div class="col-8">
                    <input id="fecha_insercion" name="fecha_insercion" type="datetime-local" class="form-control" required="required" value="<?php echo date('Y-m-d\TH:i', strtotime($cotizacion['fecha_insercion'])); ?>">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-8 offset-4">
                    <button type="submit" class="btn btn-primary">Actualizar Cotización</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
