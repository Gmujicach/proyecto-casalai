<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'SuperUsuario') {?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Ingresos y Egresos</title>
    <?php include 'header.php'; ?>
</head>

<body  class="fondo" style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">
<?php include 'newnavbar.php'; ?>


<div class="contenedor-tabla">
    <h3>Ingresos de la Empresa</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($finanzas['ingresos'])): ?>
                <tr>
                    <td colspan="3" style="text-align:center;">No hay ingresos registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach($finanzas['ingresos'] as $ing): ?>
                <tr>
                    <td><?= $ing['fecha'] ?></td>
                    <td><?= number_format($ing['monto'],2) ?></td>
                    <td><?= $ing['descripcion'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="contenedor-tabla">
    <h3>Egresos de la Empresa</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($finanzas['egresos'])): ?>
                <tr>
                    <td colspan="3" style="text-align:center;">No hay egresos registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach($finanzas['egresos'] as $eg): ?>
                <tr>
                    <td><?= $eg['fecha'] ?></td>
                    <td><?= number_format($eg['monto'],2) ?></td>
                    <td><?= $eg['descripcion'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<!-- Reporte Estadístico de Ingresos y Egresos -->
<div class="reporte-container" style="max-width:1100px; margin:40px auto; background:#fff; padding:32px 24px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.08);">
   <div style="flex:1; min-width:480px;">
    <h4 style="text-align:center; color:#2980b9;">Ingresos vs Egresos por Mes</h4>
    <canvas id="graficoFinanzas" width="480" height="320"></canvas>
    <table class="table table-bordered table-striped" style="margin:20px auto 0 auto; width:100%;">
        <thead>
            <tr>
                <th>Mes</th>
                <th>Ingresos</th>
                <th>Egresos</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($meses as $mes): ?>
                <tr>
                    <td><?= date('F Y', strtotime($mes.'-01')) ?></td>
                    <td><?= number_format($ingresosPorMes[$mes] ?? 0, 2) ?></td>
                    <td><?= number_format($egresosPorMes[$mes] ?? 0, 2) ?></td>
                    <td><?= number_format(($ingresosPorMes[$mes] ?? 0) - ($egresosPorMes[$mes] ?? 0), 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th><?= number_format($totalIngresos,2) ?></th>
                <th><?= number_format($totalEgresos,2) ?></th>
                <th><?= number_format($totalIngresos - $totalEgresos,2) ?></th>
            </tr>
        </tfoot>
    </table>
</div>
    </div>
    <div style="text-align:center; margin-top:30px;">
        <button id="descargarPDFFinanzas" class="btn btn-success" style="padding:10px 24px; font-size:16px; border-radius:6px; background:#27ae60; color:#fff; border:none; cursor:pointer;">
            Descargar Reporte de Finanzas
        </button>
    </div>
</div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="javascript/finanza.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
const labelsMeses = <?= json_encode(array_map(function($m){ return date('M Y', strtotime($m.'-01')); }, $meses)) ?>;
const dataIngresos = <?= json_encode(array_values(array_map(function($m) use ($ingresosPorMes){ return isset($ingresosPorMes[$m]) ? (float)$ingresosPorMes[$m] : 0; }, $meses))) ?>;
const dataEgresos = <?= json_encode(array_values(array_map(function($m) use ($egresosPorMes){ return isset($egresosPorMes[$m]) ? (float)$egresosPorMes[$m] : 0; }, $meses))) ?>;

const ctxFinanzas = document.getElementById('graficoFinanzas').getContext('2d');
new Chart(ctxFinanzas, {
    type: 'bar',
    data: {
        labels: labelsMeses,
        datasets: [
            {
                label: 'Ingresos',
                data: dataIngresos,
                backgroundColor: 'rgba(39, 174, 96, 0.7)',
                borderColor: 'rgba(39, 174, 96, 1)',
                borderWidth: 1
            },
            {
                label: 'Egresos',
                data: dataEgresos,
                backgroundColor: 'rgba(231, 76, 60, 0.7)',
                borderColor: 'rgba(231, 76, 60, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        plugins: {
            legend: { display: true, position: 'top' },
            title: { display: true, text: 'Ingresos vs Egresos por Mes' }
        },
        scales: {
            x: { beginAtZero: true },
            y: { beginAtZero: true }
        }
    }
});

// Botón PDF (igual que antes)
document.getElementById('descargarPDFFinanzas').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'landscape',
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
        doc.save('Reporte_Finanzas.pdf');
    });
});
</script>
</body>
</html>

<?php
} else {
    header("Location: ?pagina=acceso-denegado"); 
    exit;
}
?>