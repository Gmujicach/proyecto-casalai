<?php
ob_start(); // Iniciar buffer de salida
require('public/fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 7, utf8_decode('MULTISERVICIOS CASA LAI, C.A.'), 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, utf8_decode('CARRERA 32 ENTRE CALLES 32 Y 33 Nº 32-42 BARQUISIMETO ESTADO LARA'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('04245483493, 04123661369, 04245483493, 04123661369.'), 0, 1, 'C');
        $this->Cell(0, 5, utf8_decode('SERVICIO TÉCNICO A IMPRESORAS GARANTIZADO'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 5, utf8_decode('No se garantiza la disponibilidad de los productos una vez pasados los días después de ser creada la prefactura'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Datos del cliente
if (!empty($res)) {
    $cliente = $res[0]; // Los datos del cliente se repiten por fila

    $pdf->Cell(50, 5, utf8_decode('CÓDIGO DE FACTURA: ' . $cliente['id_factura']), 0, 1);
    $pdf->Cell(50, 5, utf8_decode('NOMBRE: ' . $cliente['nombre']), 0, 1);
    $pdf->Cell(50, 5, utf8_decode('C.I.: V' . $cliente['cedula']), 0, 1);
    $pdf->Cell(50, 5, utf8_decode('DIRECCIÓN: ' . $cliente['direccion']), 0, 1);
    $pdf->Cell(50, 5, utf8_decode('TELÉFONO: ' . $cliente['telefono']), 0, 1);
    $pdf->Ln(5);
    $pdf->Cell(50, 5, utf8_decode('FECHA DOCUMENTO: ' . $cliente["fecha"]), 0, 1);
    $pdf->Ln(5);
}

// Encabezado tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(130, 7, utf8_decode('DESCRIPCIÓN'), 1);
$pdf->Cell(20, 7, utf8_decode('CANT.'), 1, 0, 'C');
$pdf->Cell(20, 7, utf8_decode('PRECIO'), 1, 0, 'C');
$pdf->Cell(20, 7, utf8_decode('TOTAL'), 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
$total_documento = 0;

foreach ($res as $item) {
    $descripcion = $item['producto'] . ' ' . $item['nombre_modelo'] . ' ' . $item['nombre_marca'];
    $cantidad = $item['cantidad'];
    $precio_unitario = $item['precio'];
    $subtotal = $cantidad * $precio_unitario;

    $pdf->Cell(130, 7, utf8_decode($descripcion), 1);
    $pdf->Cell(20, 7, utf8_decode($cantidad), 1, 0, 'C');
    $pdf->Cell(20, 7, utf8_decode(number_format($precio_unitario, 2) . ' $'), 1, 0, 'C');
    $pdf->Cell(20, 7, utf8_decode(number_format($subtotal, 2) . ' $'), 1, 0, 'C');
    $pdf->Ln();

    $total_documento += $subtotal;
}

// Totales
$pdf->Ln(5);
$descuento = floatval($cliente['descuento']);
$iva = ($total_documento - $descuento) * 0.16;
$total_final = ($total_documento - $descuento) + $iva;

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(130, 7, utf8_decode('SUB-TOTAL'), 1);
$pdf->Cell(60, 7, utf8_decode(number_format($total_documento, 2) . ' $'), 1);
$pdf->Ln();
$pdf->Cell(130, 7, utf8_decode('DESCUENTO'), 1);
$pdf->Cell(60, 7, utf8_decode(number_format($descuento, 2) . ' $'), 1);
$pdf->Ln();
$pdf->Cell(130, 7, utf8_decode('DELIVERY'), 1);
$pdf->Cell(60, 7, utf8_decode('0.00 $'), 1);
$pdf->Ln();
$pdf->Cell(130, 7, utf8_decode('I.V.A 16%'), 1);
$pdf->Cell(60, 7, utf8_decode(number_format($iva, 2) . ' $'), 1);
$pdf->Ln();
$pdf->Cell(130, 7, utf8_decode('TOTAL DOCUMENTO'), 1);
$pdf->Cell(60, 7, utf8_decode(number_format($total_final, 2) . ' $'), 1);
$pdf->Ln(10);

// Limpiar el buffer
ob_end_clean();

// Nombre del archivo
$nombre_archivo = $cliente['nombre'] . '_' . $cliente['cedula'] . '_factura_' . $cliente['id_factura'] . '_' . date('Y-m-d', strtotime($cliente['fecha'])) . '.pdf';

// Descargar el archivo
$pdf->Output('D', utf8_decode($nombre_archivo));
exit;
?>
