<?php
require('fpdf/fpdf.php'); // Asegúrate de que esta ruta sea correcta

// Crear instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 16); // Usa 'Helvetica' si el archivo de métricas está disponible
$pdf->Cell(40, 10, 'Hola Mundo');
$pdf->Output();
?>
