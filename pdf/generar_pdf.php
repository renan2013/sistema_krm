<?php
require('fpdf.php');


// Datos de conexión a la base de datos
$servername = "localhost"; 
$username = "u400283574_krm"; 
$password = "Krm2024!"; 
$dbname = "u400283574_krm"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID de la factura desde la URL
$factura_id = $_GET['factura_id'];

// Consultar datos de la factura
$sql = "SELECT * FROM facturas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$factura_result = $stmt->get_result();
$factura = $factura_result->fetch_assoc();
$stmt->close();

// Consultar el nombre del cliente y la empresa
$sql = "SELECT c.nombre AS cliente_nombre, c.empresa AS cliente_empresa
        FROM facturas f
        JOIN clientes c ON f.cliente_id = c.id_cliente
        WHERE f.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$cliente_result = $stmt->get_result();
$cliente = $cliente_result->fetch_assoc();
$stmt->close();

$cliente_nombre = utf8_decode($cliente['cliente_nombre']);
$cliente_empresa = utf8_decode($cliente['cliente_empresa']);



// Consultar productos de la factura
$sql = "SELECT * FROM productos_factura WHERE factura_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $factura_id);
$stmt->execute();
$productos_result = $stmt->get_result();
$productos = $productos_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Crear instancia de FPDF en formato vertical
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Establecer la fuente
$pdf->SetFont('Arial', 'B', 16);

// Establecer color y grosor de las líneas de la tabla
$pdf->SetDrawColor(176, 178, 178);  // Color azul para las líneas
$pdf->SetLineWidth(0.1);  // Grosor de 0.5 mm

// Agregar logo centrado
$logoFile = 'logo_largo.png'; // Ruta a tu archivo de logo
$logoWidth = 190; // Ancho del logo en mm
$logoHeight = 25; // Alto del logo en mm

// Posicionar el logo centrado
$pdf->Image($logoFile, (210 - $logoWidth) / 2, 10, $logoWidth, $logoHeight);
$pdf->Ln(27); // Espacio debajo del logo

// Agregar información de la empresa centrada
$pdf->SetFont('Arial', '', 10); // Establecer la fuente y el tamaño

$pdf->Cell(0, 5, utf8_decode('CEDULA JURIDICA: 3-102-581093 - Curridabat, San José, Costa Rica - Telf.(506) 2271-2694'), 0, 1, 'C'); // Teléfono
$pdf->Cell(0, 5, utf8_decode('Sinpe: +506 8413 4388 - Plásticos KRM Limitada'), 0, 1, 'C'); // Teléfono
$pdf->Cell(0, 5, utf8_decode('Correo: info@plasticoskrm.com  -  www.plasticoskrm.com'), 0, 1, 'C'); // Correo electrónico
$pdf->Cell(0, 5, utf8_decode('Cuenta Corriente Banco Nacional:'), 0, 1, 'C'); // Título de cuentas bancarias
$pdf->Cell(0, 5, utf8_decode('Plásticos KRM, Limitada 100-01-078-001504-0 CC 15107810010015048'), 0, 1, 'C'); // Cuenta bancaria 1

$pdf->Ln(4); // Espacio después de la información de la empresa

// Dibujar primera línea horizontal antes del título "Cotizacion"
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Línea de margen izquierdo (10) a derecho (200)
$pdf->Ln(5); // Espacio debajo de la línea

$pdf->SetFont('Arial', 'B', 12);

// Agregar título
$pdf->Cell(0, 10, 'ORDEN DE COMPRA', 0, 1, 'C');
$pdf->Ln(5);

// Agregar información de la factura
$pdf->SetFont('Arial', 'B', 10); // Establecer fuente más grande y en negrita para el cliente
$pdf->Cell(0, 5, 'Cliente: ' . $cliente_nombre, 0, 1);
$pdf->Cell(0, 5, 'Empresa: ' . $cliente_empresa, 0, 1); // Mostrar el nombre de la empresa
$pdf->SetFont('Arial', '', 10); // Volver a la fuente normal para el resto de los detalles de la factura
$pdf->Cell(0, 5, 'Nro de orden: ' . $factura['id'], 0, 1);
$pdf->Cell(0, 5, 'Fecha: ' . $factura['fecha'], 0, 1);
$pdf->Ln(5);

// Establecer color para el encabezado de la tabla (gris claro)
$pdf->SetFillColor(231, 232, 232);

// Encabezados de la tabla con color de fondo
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(42, 8, 'Descripcion', 1, 0, 'L', true);
$pdf->Cell(22, 8, 'Ancho(cm.)', 1, 0, 'R', true); // Alineación a la derecha
$pdf->Cell(20, 8, 'Alto(cm.)', 1, 0, 'R', true);  // Alineación a la derecha
$pdf->Cell(17, 8, 'Grosor(in)', 1, 0, 'R', true); // Alineación a la derecha
$pdf->Cell(17, 8, 'Cantidad', 1, 0, 'R', true);   // Alineación a la derecha
$pdf->Cell(18, 8, 'Color', 1, 0, 'R', true);   // Alineación a la derecha
$pdf->Cell(22, 8, 'Precio Unit.', 1, 0, 'R', true); // Alineación a la derecha
$pdf->Cell(32, 8, 'Total', 1, 0, 'R', true);      // Alineación a la derecha
$pdf->Ln();

// Inicializar variable para el total general
$total_general = 0;
$fill = false; // Variable para alternar el color de fondo

foreach ($productos as $producto) {
    // Alternar color de fondo
    $pdf->SetFillColor(246, 245, 245); // Color de fondo para filas alternas
    $pdf->Cell(42, 9, $producto['descripcion'], 1, 0, 'L', $fill);
    $pdf->Cell(22, 9, number_format($producto['ancho'], 2), 1, 0, 'R', $fill);    // Alineación a la derecha
    $pdf->Cell(20, 9, number_format($producto['alto'], 2), 1, 0, 'R', $fill);     // Alineación a la derecha
    $pdf->Cell(17, 9, number_format($producto['grosor'], 2), 1, 0, 'R', $fill);   // Alineación a la derecha
    $pdf->Cell(17, 9, $producto['cantidad'], 1, 0, 'R', $fill);                   // Alineación a la derecha
    $pdf->Cell(18, 9, $producto['color'], 1, 0, 'R', $fill);                   // Alineación a la derecha
    $pdf->Cell(22, 9, number_format($producto['precio_unitario'], 2), 1, 0, 'R', $fill); // Alineación a la derecha
    $pdf->Cell(32, 9, number_format($producto['total'], 2), 1, 0, 'R', $fill);    // Alineación a la derecha
    $pdf->Ln();
    
    // Sumar el total del producto al total general
    $total_general += $producto['total'];
}

// Espacio después de la tabla
$pdf->Ln(5);

// Agregar total general debajo de la tabla
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(158, 10, 'Total Productos (colones):', 1);
$pdf->Cell(32, 10, 'c/. ' . number_format($total_general, 2), 1, 1, 'R'); // Alineado a la derecha con 2 decimales

// Agregar créditos de emisión de la factura
$pdf->SetFont('Arial', 'I', 8); // Fuente en cursiva y tamaño más pequeño
$pdf->Ln(10);
$pdf->Cell(0, 3, utf8_decode('Régimen simplificado de la dirección de tributación directa No 4641000965544'), 0, 1, 'C');

$pdf->Cell(0, 5, utf8_decode('Developed by renangalvan.net - (506) 87777849 - San José, Costa Rica 2025'), 0, 1, 'C');

// Salida del PDF
// Crear el nombre del archivo
$nombre_archivo = 'Orden_Compra_KRM_' . $factura['id'] . '.pdf';

// Guardar el PDF en el servidor con el nombre personalizado
$pdf->Output($nombre_archivo, 'I');  // 'I' es para mostrar el archivo en el navegador
?>
