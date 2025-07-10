<?php
require_once '../Modelo/producto.php';

$productoModel = new Productos();
$datos = $productoModel->obtenerReporteCategorias();

if (!$datos || !is_array($datos)) {
    die("No hay datos para el reporte.");
}

$total = array_sum(array_column($datos, 'cantidad'));
foreach ($datos as &$cat) {
    $cat['porcentaje'] = $total > 0 ? round(($cat['cantidad'] / $total) * 100, 2) : 0;
}
unset($cat);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos por Categoría</title>
<script src="Public/js/chart.js"></script>
<script src="Public/js/html2canvas.min.js"></script>
<script src="Public/js/jspdf.umd.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f8fb;
            margin: 0;
            padding: 0;
        }
        .reporte-container {
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 32px 24px 24px 24px;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 24px;
        }
        table {
            margin: 0 auto 32px auto;
            border-collapse: collapse;
            width: 90%;
            background: #fafbfc;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #e1e4e8;
            padding: 10px 18px;
            text-align: center;
        }
        th {
            background: #2980b9;
            color: #fff;
            font-weight: 600;
        }
        tr:nth-child(even) td {
            background: #f0f6fa;
        }
        tfoot th {
            background: #eaf6ff;
            color: #222;
        }
        .grafica-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
        }
        @media (max-width: 600px) {
            .reporte-container { padding: 10px; }
            table { width: 100%; font-size: 13px; }
        }
    </style>
</head>
<body>
    <div class="reporte-container">
        <h2>Reporte de Productos por Categoría</h2>
        <div class="grafica-container">
            <canvas id="graficoPastel" width="350" height="350"></canvas>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Cantidad de Productos</th>
                    <th>Porcentaje (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos as $cat): ?>
                <tr>
                    <td><?= htmlspecialchars($cat['nombre_categoria']) ?></td>
                    <td><?= $cat['cantidad'] ?></td>
                    <td><?= $cat['porcentaje'] ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th><?= $total ?></th>
                    <th>100%</th>
                </tr>
            </tfoot>
    
        </table>
        <div style="text-align:center; margin-top:20px;">
            <button id="descargarPDF" class="btn btn-success" style="padding:10px 24px; font-size:16px; border-radius:6px; background:#27ae60; color:#fff; border:none; cursor:pointer;">
                Descargar PDF
            </button>
        </div>
    </div>
<script>
    // Datos para la gráfica de pastel
    const labels = <?= json_encode(array_column($datos, 'nombre_categoria')) ?>;
    const data = <?= json_encode(array_column($datos, 'cantidad')) ?>;

    function generarColores(n) {
        const colores = [];
        for (let i = 0; i < n; i++) {
            const hue = Math.round((360 / n) * i);
            colores.push(`hsl(${hue}, 70%, 60%)`);
        }
        return colores;
    }

    const colores = generarColores(labels.length);

    const ctx = document.getElementById('graficoPastel').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colores,
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Distribución de Productos por Categoría'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.chart._metasets[0].total || 1;
                            const porcentaje = ((value / total) * 100).toFixed(2);
                            return `${label}: ${value} (${porcentaje}%)`;
                        }
                    }
                }
            }
        }
    });

    // Descargar PDF al hacer clic en el botón
    document.getElementById('descargarPDF').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait',
            unit: 'pt',
            format: 'a4'
        });

        const reporte = document.querySelector('.reporte-container');
        html2canvas(reporte).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pageWidth = doc.internal.pageSize.getWidth();
            const imgWidth = pageWidth - 40;
            const imgHeight = canvas.height * imgWidth / canvas.width;

            doc.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
            doc.save('Reporte_Productos_Categorias.pdf');
        });
    });
</script>
</body>
</html>