<?php if ($_SESSION['rango'] == 'Administrador' || $_SESSION['rango'] == 'Almacenista') { ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Clientes</title>
    <?php include 'header.php'; ?>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'NewNavBar.php'; ?>

<div class="modal fade modal-registrar" id="registrarClienteModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="ingresarclientes" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarClienteModalLabel">Incluir Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="envolver-form">
                        <label for="nombre">Nombre Completo</label>
                        <input class="control-form" placeholder="Nombres y apellidos" maxlength="100" type="text" id="nombre" name="nombre" required>
                        <span class="span-value" id="snombre"></span>
                    </div>

                    <div class="envolver-form">
                        <label for="cedula_o_rif">Cedula o RIF</label>
                        <input class="control-form" placeholder="Cedula/Rif" maxlength="12" type="text" id="cedula" name="cedula" required>
                        <span class="span-value" id="scedula"></span>
                    </div>

                    <div class="envolver-form">
                        <label for="telefono">Numero de Teléfono</label>
                        <input class="control-form" placeholder="Teléfono" maxlength="13" type="text" id="telefono" name="telefono" required>
                        <span class="span-value" id="stelefono"></span>
                    </div>
                    
                    <div class="envolver-form">
                        <label for="Direccion">Dirección</label>
                        <textarea class="form-control" maxlength="100" id="direccion" name="direccion" rows="3"></textarea>
                        <span class="span-value" id="sdireccion"></span>
                    </div>
                    
                    <div class="envolver-form">
                        <label for="correo">Correo Electrónico</label>
                        <input class="control-form" placeholder="Correo" type="text" id="correo" name="correo" maxlength="50" required>
                        <span class="span-value" id="scorreo"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="boton-form" type="submit">Registrar</button>
                    <button class="boton-reset" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="contenedor-tabla">
    <div class="space-btn-incluir">
        <button id="btnIncluirCliente" class="btn-incluir">
            Incluir Cliente
        </button>
    </div>

    <h3>Lista de Clientes</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Nombre del Cliente</th>
                <th>Cedula/RIF</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <?php if ($cliente['activo'] == 1) { ?>
                <tr data-id="<?php echo $cliente['id_clientes']; ?>">
                    <td>
                        <ul>
                            <div>
                                <button class="btn-modificar"
                                    id="btnModificarCliente"
                                    data-id="<?php echo htmlspecialchars($cliente['id_clientes']); ?>"
                                    data-nombre="<?php echo htmlspecialchars($cliente['nombre']); ?>"
                                    data-cedula="<?php echo htmlspecialchars($cliente['cedula']); ?>"
                                    data-direccion="<?php echo htmlspecialchars($cliente['direccion']); ?>"
                                    data-telefono="<?php echo htmlspecialchars($cliente['telefono']); ?>"
                                    data-correo="<?php echo htmlspecialchars($cliente['correo']); ?>">
                                    Modificar
                                </button>
                            </div>
                            <div>
                                <button class="btn-eliminar"
                                    data-id="<?php echo $cliente['id_clientes']; ?>">
                                    Eliminar
                                </button>
                            </div>
                        </ul>
                    </td>
                    <td>
                        <span class="campo-nombres">
                            <?php echo htmlspecialchars($cliente['nombre']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-rif-correo">
                            <?php echo htmlspecialchars($cliente['cedula']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-nombres">
                            <?php echo htmlspecialchars($cliente['direccion']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-numeros">
                            <?php echo htmlspecialchars($cliente['telefono']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-rif-correo">
                            <?php echo htmlspecialchars($cliente['correo']); ?>
                        </span>
                    </td>
                </tr>
                <?php } ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Reporte estadístico de compras por cliente -->
<div class="reporte-container" style="max-width:900px; margin:40px auto; background:#fff; padding:32px 24px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.08);">
    <h2 style="text-align:center;">Top 10 Clientes por Productos Comprados</h2>
    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:center;">
        <div style="flex:1; min-width:320px;">
            <canvas id="graficoComprasClientes" width="400" height="260"></canvas>
        </div>
        <div style="flex:1; min-width:320px;">
            <table class="table table-bordered table-striped" style="margin:0 auto 32px auto; width:100%;">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Cantidad de Productos Comprados</th>
                        <th>Porcentaje (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reporteComprasClientes as $cliente): 
                        $porcentaje = $totalComprasClientes > 0 ? round(($cliente['cantidad'] / $totalComprasClientes) * 100, 2) : 0;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                            <td><?= $cliente['cantidad'] ?></td>
                            <td><?= $porcentaje ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th><?= $totalComprasClientes ?></th>
                        <th>100%</th>
                    </tr>
                </tfoot>
            </table>
            <div style="text-align:center; margin-top:20px;">
                <button id="descargarPDFClientes" class="btn btn-success" style="padding:10px 24px; font-size:16px; border-radius:6px; background:#27ae60; color:#fff; border:none; cursor:pointer;">
                    Descargar Reporte de Compras
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-modificar" id="modificar_clientes_modal" tabindex="-1" role="dialog" 
aria-labelledby="modificar_clientes_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="modificarclientes" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="modificar_clientes_modal_label">Modificar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_clientes" name="id_clientes">
                    <div class="form-group">
                        <label for="modificarnombre">Nombre completo</label>
                        <input type="text" class="form-control" maxlength="100" id="modificarnombre" name="nombre" required>
                        <span class="span-value-modal" id="smodificarnombre"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarcedula">Cédula</label>
                        <input type="text" class="form-control" id="modificarcedula" name="cedula" maxlength="12" required>
                        <span class="span-value-modal" id="smodificarcedula"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificartelefono">Teléfono</label>
                        <input type="text" class="form-control" id="modificartelefono" name="telefono" maxlength="13" required>
                        <span class="span-value-modal" id="smodificartelefono"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificardireccion">Dirección</label>
                        <textarea class="form-control" maxlength="100" id="modificardireccion" name="direccion" rows="3"></textarea>
                        <span class="span-value-modal" id="smodificardireccion"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarcorreo">Correo electrónico</label>
                        <input type="text" class="form-control" id="modificarcorreo" name="correo" maxlength="50" required>
                        <span class="span-value-modal" id="smodificarcorreo"></span>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <?php include 'footer.php'; ?>


</div>

<script src="Javascript/js/jquery.min.js"></script>
<script src="Javascript/js/jquery-3.5.1.min.js"></script>
<script src="Public/js/popper.min.js"></script>
<script src="Javascript/js/bootstrap.min.js"></script>

<script src="Javascript/clientes.js"></script>
<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>
<script>
$(document).ready(function() {
    $('#tablaConsultas').DataTable({
        language: {
            url: 'Public/js/es-ES.json'
        },
        columnDefs: [
            { orderable: false, targets: 5 } // Deshabilitar ordenamiento para columna de acciones
        ]
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
const labelsClientes = <?= json_encode(array_column($reporteComprasClientes, 'nombre')) ?>;
const dataClientes = <?= json_encode(array_column($reporteComprasClientes, 'cantidad')) ?>;
const ctxClientes = document.getElementById('graficoComprasClientes').getContext('2d');
new Chart(ctxClientes, {
    type: 'bar',
    data: {
        labels: labelsClientes,
        datasets: [{
            label: 'Productos comprados',
            data: dataClientes,
            backgroundColor: 'rgba(39, 174, 96, 0.7)',
            borderColor: 'rgba(39, 174, 96, 1)',
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Top 10 Clientes por Productos Comprados' }
        },
        scales: {
            x: { beginAtZero: true }
        }
    }
});

document.getElementById('descargarPDFClientes').addEventListener('click', function () {
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
        doc.save('Reporte_Compras_Clientes.pdf');
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