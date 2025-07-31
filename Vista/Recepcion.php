<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Almacenista' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario') ) { ?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <title>Gestionar Recepcion</title>
</head>

<body  class="fondo" style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'newnavbar.php'; ?>

<div class="modal fade modal-registrar" id="registrarRecepcionModal" tabindex="-1" role="dialog" aria-labelledby="registrarRecepcionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="f" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarRecepcionModalLabel">Incluir Recepción</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="envolver-form">
                        <label for="correlativo">Correlativo del producto</label>
                        <input type="text" placeholder="Correlativo" class="control-form" maxlength="10" id="correlativo" name="correlativo" />
                        <span id="scorrelativo"></span>
                    </div>
                    <div class="envolver-form">
                        <label for="proveedor">Proveedor</label>
                        <select class="form-select" name="proveedor" id="proveedor">
                            <option value='disabled' disabled selected>Seleccione un Proveedor</option>
                            <?php
                            foreach ($proveedores  as $proveedor) {
                                echo "<option value='" . $proveedor['id_proveedor'] . "'>" . $proveedor['nombre_proveedor'] . "</option>";
                            } ?>
                        </select>
                    </div>
        
                    <div class="envolver-form">
                        <input class="" type="text" id="codigoproducto" name="codigoproducto" style="display:none"/>
                        <input class="" type="text" id="idproducto" name="idproducto" style="display:none"/>
                        <button type="button" class="boton-form" id="listado" name="listado">Lista de Productos</button>
                    </div>
                
                    <div class="row">
                        <div class="col">
                            <hr />
                        </div>
                    </div>
                
                    <div class="table-responsive card shadow">
                        <table class="tabla" id="tablarecepcion">
                            <thead class="">
                                <tr>
                                    <th>Acción</th>
                                    <th style="display:none">Cl</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>modelo</th>
                                    <th>Marca</th>
                                    <th>Serial</th>
                                    <th>Costo</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody class="" id="recepcion1">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="boton-form" id="registrar" name="registrar">Registrar</button>
                    <button class="boton-reset" type="reset">Reset</button>
                </div>
            </form>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalp">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="titulo-form">Listado de productos</h5>
							<button type="button" class="close-2" data-bs-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
						</div>
						<div class="modal-body">
							<table class="tablaConsultas">
								<thead class="text-center">
									<tr>
										<th style="display:none">Id</th>
										<th>Codigo</th>
										<th>Nombre</th>
										<th>modelo</th>
										<th>Marca</th>
										<th>Serial</th>
									</tr>
								</thead>
								<tbody class="text-center" id="listadop">

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<div class="contenedor-tabla">
    <div class="space-btn-incluir">
        <button id="btnIncluirRecepcion" class="btn-incluir">
            Incluir Recepción
        </button>
    </div>


<h3>Lista de Recepciones</h3>

<table class="tablaConsultas" id="tablaConsultas">
    <thead>
        <tr>
            <th>FECHA</th>
            <th>CORRELATIVO</th>
            <th>PROVEEDOR</th>
            <th>PRODUCTO</th>
            <th>CANTIDAD</th>
            <th>COSTOS DE INVERSION</th>
            <th>ACCIÓN</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (empty($recepciones)): ?>
            <tr>
                <td colspan="7" style="text-align:center;">No se han registrado recepciones.</td>
            </tr>
        <?php
        else:
            usort($recepciones, function($a, $b) {
                if ($a['fecha'] == $b['fecha']) {
                    if ($a['correlativo'] == $b['correlativo']) {
                        if ($a['nombre_proveedor'] == $b['nombre_proveedor']) {
                            return strcmp($a['nombre_producto'], $b['nombre_producto']);
                        }
                        return strcmp($a['nombre_proveedor'], $b['nombre_proveedor']);
                    }
                    return strcmp($a['correlativo'], $b['correlativo']);
                }
                return strcmp($a['fecha'], $b['fecha']);
            });

            $rowspans = [];
            $dataProductosPorRecepcion = [];
            foreach ($recepciones as $fila) {
                $id = $fila['id_recepcion'];
                if (!isset($dataProductosPorRecepcion[$id])) {
                    $dataProductosPorRecepcion[$id] = [];
                }
                $dataProductosPorRecepcion[$id][] = [
                    'id_producto' => $fila['id_producto'],
                    'cantidad' => $fila['cantidad'],
                    'costo' => $fila['costo'],
                    'iddetalles' => $fila['id_detalle_recepcion_productos'] ?? '',
                ];
            }
            foreach ($recepciones as $recepcion) {
                $key = $recepcion['fecha'] . '|' . $recepcion['correlativo'] . '|' . $recepcion['nombre_proveedor'];
                if (!isset($rowspans[$key])) {
                    $rowspans[$key] = 1;
                } else {
                    $rowspans[$key]++;
                }
            }
            $rendered = [];
            foreach ($recepciones as $recepcion):
                $key = $recepcion['fecha'] . '|' . $recepcion['correlativo'] . '|' . $recepcion['nombre_proveedor'];
        ?>
        <tr>
            <?php if (!in_array($key, $rendered)): ?>
                <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($recepcion['fecha']) ?></td>
                <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($recepcion['correlativo']) ?></td>
                <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($recepcion['nombre_proveedor']) ?></td>
            <?php endif; ?>

            <td><?= htmlspecialchars($recepcion['nombre_producto']) ?></td>
            <td><?= htmlspecialchars($recepcion['cantidad']) ?></td>
            <td><?= htmlspecialchars($recepcion['costo']) ?></td>

            <?php if (!in_array($key, $rendered)): ?>
                <td rowspan="<?= $rowspans[$key] ?>">
                    <ul>
                        <button class="btn-modificar"
                            data-bs-toggle="modal"
                            data-bs-target="#modalModificar"
                            data-idrecepcion="<?= htmlspecialchars($recepcion['id_recepcion']) ?>"
                            data-correlativo="<?= htmlspecialchars($recepcion['correlativo']) ?>"
                            data-fecha="<?= htmlspecialchars($recepcion['fecha']) ?>"
                            data-proveedor="<?= htmlspecialchars($recepcion['id_proveedor']) ?>"                
                            data-productos='<?= json_encode($dataProductosPorRecepcion[$recepcion['id_recepcion']], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                            Modificar
                        </button>
                    </ul>
                </td>
                <?php $rendered[] = $key; ?>
            <?php endif; ?>
        </tr>
        <?php endforeach;
        endif; ?>
    </tbody>
</table>
	</div>

<div style="max-width:900px; margin:40px auto; background:#fff; padding:32px 24px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.08);">

    <div class="reporte-parametros" style="margin-bottom: 30px; text-align:center;">
        <div class="form-inline" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
            <label for="fechaInicio">Fecha inicio:</label>
            <input type="date" id="fechaInicio" class="form-control" style="width:160px;">
            <label for="fechaFin">Fecha fin:</label>
            <input type="date" id="fechaFin" class="form-control" style="width:160px;">
            <label for="tipoGrafica">Tipo de gráfica:</label>
            <select id="tipoGrafica" class="form-select" style="width:200px;">
            <option value="bar">Barras</option>
            <option value="pie">Pastel</option>
            <option value="line">Líneas</option>
            <option value="doughnut">Donas</option>
            <option value="polarArea">Área Polar</option>
            </select>
            <button id="generarReporteBtn" class="btn btn-primary">Generar</button>
            <button id="descargarPDF" class="btn btn-success">Descargar PDF</button>
        </div>
    </div>

    <div class="reporte-container" style="max-width:900px; margin:40px auto; background:#fff; padding:32px 24px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.08);">
        
        <h3 style="text-align:center; color:#1f66df;">Reporte de Recepciones</h3>
        <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:center;">
            <div style="flex:1; min-width:220px; text-align:center;">
                <div class="grafica-container" style="max-width:220px; margin:0 auto 24px auto;">
                    <canvas id="graficoReporte" width="400" height="400"></canvas>
                </div>
            </div>
            <div style="flex:2; min-width:320px;">
                <div id="tablaReporte"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-modificar" id="modificarRecepcionModal" tabindex="-1" 
aria-labelledby="modificarRecepcionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="formularioEdicion" method="POST" novalidate>
            <input type="hidden" name="accion" id="accion" value="modificarRecepcion">
                <div class="modal-header">
                    <h5 class="titulo-form" id="modificarRecepcionModalLabel">Modificar Recepción</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modalIdRecepcion" name="id_recepcion">
                    <div class="form-group">
                        <label>Fecha</label>
                        <input type="date" id="modalFecha" name="fecha" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Correlativo</label>
                        <input type="text" id="modalCorrelativo" name="correlativo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Proveedor</label>
                            <select id="modalProveedor" name="proveedor" class="form-control">
                        </select>
                    </div>

                    <h5 class="titulo-form">Productos</h5>
                    <div id="contenedorDetalles"></div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="button" id="btnAgregarProducto" class="btn btn-success w-100">
                                    <i class="fas fa-plus-circle"></i> Agregar Producto
                                </button>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

<script>
const proveedoresDisponibles = <?= json_encode($proveedores) ?>;
</script>
	<script>
const productosDisponibles = <?= json_encode($productos) ?>;
console.log("Productos disponibles:", productosDisponibles);

$(document).on('click', '.btn-modificar', function(e) {
    e.preventDefault();
    e.stopPropagation();

    const btn = $(this);
    const idRecepcion = btn.data('idrecepcion');
    const correlativo = btn.data('correlativo');
    const fecha = btn.data('fecha');
    const proveedor = btn.data('proveedor');
    let productos = btn.data('productos');

    // Limpiar el modal
    $('#modalIdRecepcion').val('');
    $('#modalCorrelativo').val('');
    $('#modalFecha').val('');
    $('#modalProveedor').empty();
    $('#contenedorDetalles').empty();

    // Parsear productos si es necesario
    try {
        if (typeof productos === 'string') {
            productos = JSON.parse(productos);
        }
    } catch (e) {
        console.error('Error al parsear productos:', e);
        productos = [];
    }

    // Llenar campos básicos
    $('#modalIdRecepcion').val(idRecepcion);
    $('#modalCorrelativo').val(correlativo);
    $('#modalFecha').val(fecha);

    // Llenar select de proveedor
    const selectProveedor = $('#modalProveedor');
    selectProveedor.empty().append('<option value="">Seleccione un proveedor</option>');
    
    proveedoresDisponibles.forEach(prov => {
        selectProveedor.append(
            $(`<option value="${prov.id_proveedor}">${prov.nombre_proveedor}</option>`)
        );
    });
    
    selectProveedor.val(proveedor);

    // Generar HTML para productos - ESTA ES LA PARTE CLAVE QUE LLENA LOS SELECTS
    let html = '';
    if (Array.isArray(productos) && productos.length) {
        productos.forEach((item, index) => {
            html += `
                <div class="row mb-3 grupo-producto">
                    <div class="col-md-5">
                        <label class="form-label">Producto</label>
                        <select class="form-select" name="productos[]" required>
                            <option value="">Seleccione un producto</option>
                            ${productosDisponibles.map(prod => `
                                <option value="${prod.id_producto}" 
                                    ${item.id_producto == prod.id_producto ? 'selected' : ''}>
                                    ${prod.nombre_producto}
                                </option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" 
                               name="cantidades[]" value="${item.cantidad || 1}" 
                               min="1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Costo</label>
                        <input type="number" class="form-control" 
                               name="costos[]" value="${item.costo || 0}" 
                               min="0" step="0.01" required>
                        <input type="hidden" name="iddetalles[]" value="${item.iddetalles || ''}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-eliminar-producto">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            `;
        });
    } else {
        html = '<div class="alert alert-info">No se encontraron productos para esta recepción</div>';
    }

    $('#contenedorDetalles').html(html);
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalModificar'));
    modal.show();
        cerrarModales();
    
    setTimeout(() => {
        const modalElement = document.getElementById('modalModificar');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    }, 200);
});
// Función para crear un nuevo bloque vacío de producto
function crearBloqueProducto(productosDisponibles) {
    return `
        <div class="row mb-2 grupo-producto">
            <div class="col-md-5">
                <label>Producto</label>
                <select class="form-control" name="productos[]">
                    ${productosDisponibles.map(prod => `
                        <option value="${prod.id_producto}">${prod.nombre_producto}</option>
                    `).join('')}
                </select>
            </div>
            <div class="col-md-3">
                <label>Cantidad</label>
                <input type="number" class="form-control" name="cantidades[]" value="1" min="1">
            </div>
            <div class="col-md-2">
                <label>Costo</label>
                <input type="number" class="form-control" name="costos[]" value="0" min="0" step="0.01">
                <input type="hidden" name="iddetalles[]" value="">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-eliminar-producto">Eliminar Producto</button>
            </div>
        </div>
    `;
}

// Evento para agregar un nuevo producto al modal
$(document).on('click', '#btnAgregarProducto', function () {
    $('#contenedorDetalles').append(crearBloqueProducto(productosDisponibles));
});

// Evento para eliminar el bloque correspondiente
$(document).on('click', '.btn-eliminar-producto', function () {
    $(this).closest('.grupo-producto').remove();
});
</script>



	<script type="text/javascript" src="javascript/recepcion.js"></script>
<script src="public/js/chart.js"></script>
<script src="public/js/html2canvas.min.js"></script>
<script src="public/js/jspdf.umd.min.js"></script>
<script>
const datosOriginales = <?= json_encode($despachos ?? $recepciones) ?>; // Usa la variable PHP correcta
const tipo = "<?= isset($despachos) ? 'despacho' : 'recepcion' ?>";

function filtrarPorFechas(datos, inicio, fin) {
    return datos.filter(d => {
        const fecha = tipo === 'despacho' ? d.fecha_despacho : d.fecha;
        return (!inicio || fecha >= inicio) && (!fin || fecha <= fin);
    });
}

function generarColores(n) {
    return Array.from({length: n}, (_, i) => `hsl(${(360 / n) * i}, 70%, 60%)`);
}

function generarReporte() {
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    const tipoGrafica = document.getElementById('tipoGrafica').value;

    // Validación de fechas
    if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
        Swal.fire('Error', 'La fecha inicial no puede ser mayor que la fecha final', 'error');
        return;
    }

    // Filtrar datos
    const datosFiltrados = filtrarPorFechas(datosOriginales, fechaInicio, fechaFin);

    // Agrupar productos y sumar cantidades
    let productosAgrupados = {};
    let total = 0;
    if (tipo === 'despacho') {
        datosFiltrados.forEach(d => {
            const nombre = d.nombre_producto;
            const cantidad = parseInt(d.cantidad);
            productosAgrupados[nombre] = (productosAgrupados[nombre] || 0) + cantidad;
            total += cantidad;
        });
    } else {
        datosFiltrados.forEach(d => {
            const nombre = d.nombre_producto;
            const cantidad = parseInt(d.cantidad);
            productosAgrupados[nombre] = (productosAgrupados[nombre] || 0) + cantidad;
            total += cantidad;
        });
    }

    // Generar gráfica
    const labels = Object.keys(productosAgrupados);
    const data = Object.values(productosAgrupados);
    const colores = generarColores(labels.length || 1);

    // Actualizar tabla
    let tablaHtml = `
        <table class="table table-bordered table-striped" style="margin:0 auto 32px auto; width:100%;">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Porcentaje (%)</th>
                </tr>
            </thead>
            <tbody>
    `;
    labels.forEach((nombre, i) => {
        const porcentaje = total > 0 ? ((data[i] / total) * 100).toFixed(2) : 0;
        tablaHtml += `<tr>
            <td>${nombre}</td>
            <td>${data[i]}</td>
            <td>${porcentaje}%</td>
        </tr>`;
    });
    tablaHtml += `
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th>${total}</th>
                    <th>100%</th>
                </tr>
            </tfoot>
        </table>
    `;
    document.getElementById('tablaReporte').innerHTML = tablaHtml;

    // Actualizar gráfica
    const canvas = document.getElementById('graficoReporte');
    canvas.width = 400;
    canvas.height = 400;
    const ctx = canvas.getContext('2d');
    if (window.reporteChart) window.reporteChart.destroy();
    window.reporteChart = new Chart(ctx, {
        type: tipoGrafica,
        data: {
            labels: labels.length ? labels : ['Sin datos'],
            datasets: [{
                data: data.length ? data : [1],
                backgroundColor: colores,
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: { display: true, position: 'bottom' },
                title: { display: true, text: tipo === 'despacho' ? 'Productos más despachados' : 'Productos más recibidos' }
            }
        }
    });
}

// Botón generar
document.getElementById('generarReporteBtn').addEventListener('click', generarReporte);

// Botón descargar PDF
document.getElementById('descargarPDF').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'portrait',
        unit: 'pt',
        format: 'a4'
    });

    const reporte = document.querySelector('.reporte-container');
    html2canvas(reporte, { scale: 2 }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pageWidth = doc.internal.pageSize.getWidth();
        const imgWidth = pageWidth - 40;
        const imgHeight = canvas.height * imgWidth / canvas.width;

        doc.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
        doc.save(tipo === 'despacho' ? 'Reporte_Despachos.pdf' : 'Reporte_Recepciones.pdf');
    });
});

// Generar reporte inicial
document.addEventListener('DOMContentLoaded', generarReporte);
</script>

</body>
</html>

<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>