<?php
ob_start(); // Iniciar buffer de salida
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 7, 'MULTISERVICIOS CASA LAI, C.A.', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'CARRERA 32 ENTRE CALLES 32 Y 33 No 32-42 BARQUISIMETO ESTADO LARA', 0, 1, 'C');
        $this->Cell(0, 5, '04245483493, 04123661369, 04245483493, 04123661369.', 0, 1, 'C');
        $this->Cell(0, 5, 'SERVICIO TECNICO A IMPRESORAS GARANTIZADO', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 5, 'No se garantiza la disponibilidad de los productos una vez pasadolos dias despues de ser creada la prefactura', 0, 1, 'C');
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Datos del cliente (solo se imprime una vez)
if (!empty($res)) {
    $cliente = $res[0]; // Tomamos los datos del primer resultado (son iguales para toda la factura)
    $pdf->Cell(50, 5, 'CODIGO DE FACTURA: ' . $cliente['facturas'], 0, 1);
    $pdf->Cell(50, 5, 'NOMBRE: ' . $cliente['tbl_clientes'], 0, 1);
    $pdf->Cell(50, 5, 'R.I.F.: V' . $cliente['rif'], 0, 1);
    $pdf->Cell(50, 5, 'DIRECCION: ' . $cliente['direccion'], 0, 1);
    $pdf->Cell(50, 5, 'TELEFONO: ' . $cliente['telefono'], 0, 1);
    $pdf->Cell(50, 5, 'TELEFONO 2: ' . $cliente['telefono_secundario'], 0, 1);
    $pdf->Ln(5);
    $pdf->Cell(50, 5, 'FECHA DOCUMENTO: ' . $cliente["fecha"], 0, 1);
    $pdf->Ln(5);
}

// Definir las cabeceras de la tabla de productos
$header = ['DESCRIPCION','CANTIDAD', 'PRECIO', 'TOTAL'];

// Calcular el ancho de las celdas para cada columna según el contenido más largo
$widths = [];
foreach ($header as $col) {
    $widths[] = $pdf->GetStringWidth($col) + 10; // Sumar 10 para margen adicional
}

// Encabezado de la tabla de productos
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(130, 7, $header[0], 1);
$pdf->Cell(20, 7, $header[1], 1, 0, 'C');
$pdf->Cell(20, 7, $header[2], 1, 0, 'C');
$pdf->Cell(20, 7, $header[3], 1, 0, 'C');
$pdf->Ln();

// Datos de los productos
$pdf->SetFont('Arial', '', 10);
$total_documento = 0;
foreach ($res as $producto) {
    $descripcion = $producto['tbl_producto'].' '.$producto['tbl_modelos'].' '.$producto['tbl_marcas'];
    $cantidad = $producto['cantidad'];
    $precio = number_format($producto['precio'], 2) . ' $';
    $subtotal = number_format($producto['cantidad'] * $producto['precio'], 2) . ' $';
    
    // Calcular el ancho de las celdas según el contenido
    $desc_width = max($pdf->GetStringWidth($descripcion) + 10, $widths[0]); // Asegurarse de que el ancho no sea menor
    $cantidad_width = max($pdf->GetStringWidth($cantidad) + 10, $widths[1]);
    $precio_width = max($pdf->GetStringWidth($precio) + 10, $widths[2]);
    $total_width = max($pdf->GetStringWidth($subtotal) + 10, $widths[3]);

    // Imprimir los datos de cada producto
    $pdf->Cell(130, 7, $descripcion, 1);
    $pdf->Cell(20, 7, $cantidad, 1, 0, 'C');
    $pdf->Cell(20, 7, $precio, 1, 0, 'C');
    $pdf->Cell(20, 7, $subtotal, 1, 0, 'C');
    $pdf->Ln();

    // Acumulando el total del documento
    $total_documento += $producto['cantidad'] * $producto['precio'];
}

// Totales
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(130, 7, 'SUB-TOTAL', 1);
$pdf->Cell(60, 7, number_format($total_documento, 2) . '$', 1);
$pdf->Ln();
$pdf->Cell(130, 7, 'DESCUENTO', 1);
$pdf->Cell(60, 7, '0$', 1);
$pdf->Ln();
$pdf->Cell(130, 7, 'DESCUENTO 2', 1);
$pdf->Cell(60, 7, '0$', 1);
$pdf->Ln();
$pdf->Cell(130, 7, 'DELIVERY', 1);
$pdf->Cell(60, 7, '0$', 1);
$pdf->Ln();
$pdf->Cell(130, 7, 'I.V.A 16%', 1);
$pdf->Cell(60, 7, number_format($total_documento * 0.16, 2) . '$', 1);
$pdf->Ln();
$pdf->Cell(130, 7, 'TOTAL DOCUMENTO', 1);
$pdf->Cell(60, 7, number_format($total_documento * 1.16, 2) . '$', 1);
$pdf->Ln(10);

// Limpia salida previa antes de generar PDF
ob_end_clean(); 

// Crear nombre de archivo dinámico con el nombre del cliente, su cédula, el número de la factura y la fecha de emisión
$nombre_archivo = $cliente['tbl_clientes'] . '_' . $cliente['rif'] . '_factura_' . $cliente['facturas'] . '_' . date('Y-m-d', strtotime($cliente['fecha'])) . '.pdf';

// Generar el PDF con el nombre dinámico
$pdf->Output('D', $nombre_archivo);
exit;
?>
