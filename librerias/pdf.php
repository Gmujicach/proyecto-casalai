<?php
require_once 'public/fpdf/fpdf.php';

class PDF extends FPDF {
    private $titulo;
    private $subtitulo;

    public function __construct($titulo = '', $subtitulo = '') {
        parent::__construct('P', 'mm', 'A4');
        $this->titulo = $titulo;
        $this->subtitulo = $subtitulo;
    }

    // Cabecera de pagina
    function Header() {
        // Logo
        $image_file = 'img/logo.jpg';
        if (file_exists($image_file)) {
            $this->Image($image_file, 10, 10, 30);
        }
        // Titulo
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 15, $this->titulo, 0, 1, 'C');
        // Subtitulo
        if (!empty($this->subtitulo)) {
            $this->SetFont('Arial', 'I', 12);
            $this->Cell(0, 10, $this->subtitulo, 0, 1, 'C');
        }
        // Fecha de generacion
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, 'Generado el: ' . date('d/m/Y H:i:s'), 0, 1, 'R');
        // Linea separadora
        $this->Line(10, $this->GetY(), $this->GetPageWidth()-10, $this->GetY());
        $this->Ln(2);
    }

    // Pie de pagina
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    /**
     * Genera reporte de accesos semanales
     */
    public function generarReporteAccesos($datos) {
        $this->SetTitle('Reporte de Accesos - Catalogo');
        $this->titulo = 'Reporte de Accesos al Catalogo';
        $this->subtitulo = 'Estadisticas semanales de visitas';
        $this->AliasNbPages();
        $this->AddPage();

        // Resumen estadistico
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Resumen Estadistico', 0, 1);
        $this->SetFont('Arial', '', 10);

        $this->Cell(60, 8, 'Total de accesos:', 0, 0);
        $this->Cell(0, 8, number_format($datos['total']), 0, 1);

        $this->Cell(60, 8, 'Usuarios unicos:', 0, 0);
        $this->Cell(0, 8, number_format($datos['unicos']), 0, 1);

        $this->Cell(60, 8, 'Promedio diario:', 0, 0);
        $this->Cell(0, 8, number_format($datos['promedio_diario'], 1), 0, 1);

        $this->Ln(8);

        // Tabla de datos semanales
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Detalle por Semana', 0, 1);

        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(220, 220, 220);
        $this->Cell(30, 8, 'Semana', 1, 0, 'C', 1);
        $this->Cell(40, 8, 'Total Accesos', 1, 0, 'C', 1);
        $this->Cell(40, 8, 'Usuarios Unicos', 1, 0, 'C', 1);
        $this->Cell(40, 8, 'Promedio Diario', 1, 1, 'C', 1);

        $this->SetFont('Arial', '', 9);
        foreach ($datos['semanas'] as $semana) {
            $semanaFormateada = substr($semana['semana'], 0, 4) . '-S' . substr($semana['semana'], 4);
            $this->Cell(30, 8, $semanaFormateada, 1, 0, 'C');
            $this->Cell(40, 8, number_format($semana['total_accesos']), 1, 0, 'R');
            $this->Cell(40, 8, number_format($semana['usuarios_unicos']), 1, 0, 'R');
            $this->Cell(40, 8, number_format($semana['promedio_diario'], 1), 1, 1, 'R');
        }

        $this->Output('I', 'reporte_accesos_catalogo.pdf');
    }

    /**
     * Genera reporte de usuarios mas activos
     */
    public function generarReporteUsuarios($usuarios) {
        $this->SetTitle('Reporte de Usuarios Activos - Catalogo');
        $this->titulo = 'Usuarios Mas Activos en el Catalogo';
        $this->subtitulo = 'Ranking de usuarios con mas accesos';
        $this->AliasNbPages();
        $this->AddPage();

        // Resumen
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Resumen', 0, 1);
        $this->SetFont('Arial', '', 10);

        $totalAccesos = array_sum(array_column($usuarios, 'total_accesos'));
        $this->Cell(60, 8, 'Total de accesos analizados:', 0, 0);
        $this->Cell(0, 8, number_format($totalAccesos), 0, 1);

        $this->Cell(60, 8, 'Numero de usuarios:', 0, 0);
        $this->Cell(0, 8, count($usuarios), 0, 1);

        $this->Ln(8);

        // Tabla de usuarios
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Detalle de Usuarios', 0, 1);

        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(220, 220, 220);
        $this->Cell(15, 8, 'ID', 1, 0, 'C', 1);
        $this->Cell(35, 8, 'Usuario', 1, 0, 'C', 1);
        $this->Cell(50, 8, 'Nombre', 1, 0, 'C', 1);
        $this->Cell(25, 8, 'Accesos', 1, 0, 'C', 1);
        $this->Cell(15, 8, '%', 1, 0, 'C', 1);
        $this->Cell(35, 8, 'Primer Acceso', 1, 1, 'C', 1);

        $this->SetFont('Arial', '', 9);
        foreach ($usuarios as $usuario) {
            $this->Cell(15, 8, $usuario['id_usuario'], 1, 0, 'C');
            $this->Cell(35, 8, $usuario['username'], 1, 0, 'L');
            $this->Cell(50, 8, $usuario['nombres'] . ' ' . $usuario['apellidos'], 1, 0, 'L');
            $this->Cell(25, 8, number_format($usuario['total_accesos']), 1, 0, 'R');
            $this->Cell(15, 8, $usuario['porcentaje'] . '%', 1, 0, 'R');
            $this->Cell(35, 8, date('d/m/Y', strtotime($usuario['primer_acceso'])), 1, 1, 'C');
        }

        $this->Output('I', 'reporte_usuarios_activos.pdf');
    }
}
?>