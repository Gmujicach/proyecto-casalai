<?php if ($_SESSION['rango'] == 'Administrador' || $_SESSION['rango'] == 'Almacenista' ) { ?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <title>Gestionar Despacho</title>
</head>

<?php include 'NewNavBar.php'; ?>

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<div class="modal fade modal-registrar" id="registrarDespachoModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarDespachoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="f" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarDespachoModalLabel">Incluir Despacho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
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
                        <label for="cliente">Cliente</label>
                        <select class="form-select" name="cliente" id="cliente">
                            <option value='disabled' disabled selected>Seleccione el Cliente</option>
                            <?php
                            foreach ($proveedores  as $proveedor) {
                                echo "<option value='" . $proveedor['id_clientes'] . "'>" . $proveedor['nombre'] . "</option>";
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
                                    <th>Modelo</th>
                                    <th>Marca</th>
                                    <th>Serial</th>
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
                        <button type="button" class="close-2" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <table class="tablaConsultas">
                        <thead class="text-center">
                            <tr>
                            <th style="display:none">Id</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Modelo</th>
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
        <button id="btnIncluirDespacho" class="btn-incluir">
            Incluir Despacho
        </button>
    </div>


<h3>Lista de Despachos</h3>
<table class="tablaConsultas" id="tablaConsultas">
    <thead>
        <tr>
            <th>FECHA</th>
            <th>CORRELATIVO</th>
            <th>CLIENTE</th>
            <th>PRODUCTO</th>
            <th>CANTIDAD</th>
            <th>ACCIÓN</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Agrupar productos por despacho
        $productosPorDespacho = [];
        foreach ($despachos as $fila) {
            $id = $fila['id_despachos'];
            if (!isset($productosPorDespacho[$id])) {
                $productosPorDespacho[$id] = [];
            }
            $productosPorDespacho[$id][] = [
                'id_producto' => $fila['id_producto'],
                'cantidad' => $fila['cantidad'],
                'id_detalle' => $fila['id_detalle'] ?? '',
                // agrega más campos si necesitas
            ];
        }

        if (empty($despachos)): ?>
            <tr>
                <td colspan="6" style="text-align:center;">No se han despachado productos.</td>
            </tr>
        <?php
        else:
            usort($despachos, function($a, $b) {
                if ($a['fecha_despacho'] == $b['fecha_despacho']) {
                    if ($a['correlativo'] == $b['correlativo']) {
                        if ($a['nombre_cliente'] == $b['nombre_cliente']) {
                            return strcmp($a['nombre_producto'], $b['nombre_producto']);
                        }
                        return strcmp($a['nombre_cliente'], $b['nombre_cliente']);
                    }
                    return strcmp($a['correlativo'], $b['correlativo']);
                }
                return strcmp($a['fecha_despacho'], $b['fecha_despacho']);
            });

            // Agrupar para rowspan
            $rowspans = [];
            foreach ($despachos as $despacho) {
                $key = $despacho['fecha_despacho'] . '|' . $despacho['correlativo'] . '|' . $despacho['nombre_cliente'];
                if (!isset($rowspans[$key])) {
                    $rowspans[$key] = 1;
                } else {
                    $rowspans[$key]++;
                }
            }
            $rendered = [];
            foreach ($despachos as $despacho):
                $key = $despacho['fecha_despacho'] . '|' . $despacho['correlativo'] . '|' . $despacho['nombre_cliente'];
                $id = $despacho['id_despachos'];
        ?>
        <tr>
            <?php if (!in_array($key, $rendered)): ?>
                <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($despacho['fecha_despacho']) ?></td>
                <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($despacho['correlativo']) ?></td>
                <td rowspan="<?= $rowspans[$key] ?>"><?= htmlspecialchars($despacho['nombre_cliente']) ?></td>
            <?php endif; ?>

            <td><?= htmlspecialchars($despacho['nombre_producto']) ?></td>
            <td><?= htmlspecialchars($despacho['cantidad']) ?></td>

            <?php if (!in_array($key, $rendered)): ?>
                <td rowspan="<?= $rowspans[$key] ?>">
                    <ul>
                        <button class="btn-modificar"
                            data-bs-toggle="modal"
                            data-bs-target="#modalModificar"
                            data-iddespacho="<?= htmlspecialchars($despacho['id_despachos']) ?>"
                            data-correlativo="<?= htmlspecialchars($despacho['correlativo']) ?>"
                            data-fecha="<?= htmlspecialchars($despacho['fecha_despacho']) ?>"
                            data-cliente="<?= htmlspecialchars($despacho['id_clientes']) ?>"
                            data-productos='<?= json_encode($productosPorDespacho[$id], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
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
<?php
// Calcula totales y agrupación para el reporte
$totalDespachos = count($despachos);

// Agrupa productos y suma cantidades
$productosDespachados = [];
foreach ($despachos as $d) {
    $nombre = $d['nombre_producto'];
    $cantidad = (int)$d['cantidad'];
    if (!isset($productosDespachados[$nombre])) {
        $productosDespachados[$nombre] = 0;
    }
    $productosDespachados[$nombre] += $cantidad;
}
$totalProductosDespachados = array_sum($productosDespachados);
?>

<!-- Reporte estadístico de Despachos -->
<div class="reporte-container" style="max-width:900px; margin:40px auto; background:#fff; padding:32px 24px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.08);">
    <h3 style="text-align:center; color:#1f66df;">Reporte de Despachos</h3>
    <p><b>Total de Despachos:</b> <?= $totalDespachos ?></p>
    <p><b>Total de Productos Despachados:</b> <?= $totalProductosDespachados ?></p>
    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:center;">
        <div style="flex:1; min-width:220px; text-align:center;">
            <div class="grafica-container" style="max-width:220px; margin:0 auto 24px auto;">
                <canvas id="graficoProductosDespachados" width="220" height="220"></canvas>
            </div>
        </div>
        <div style="flex:2; min-width:320px;">
            <table class="table table-bordered table-striped" style="margin:0 auto 32px auto; width:100%;">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad Despachada</th>
                        <th>Porcentaje (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productosDespachados as $nombre => $cantidad): 
                        $porcentaje = $totalProductosDespachados > 0 ? round(($cantidad / $totalProductosDespachados) * 100, 2) : 0;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($nombre) ?></td>
                            <td><?= $cantidad ?></td>
                            <td><?= $porcentaje ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th><?= $totalProductosDespachados ?></th>
                        <th>100%</th>
                    </tr>
                </tfoot>
            </table>
            <div style="text-align:center; margin-top:20px;">
                <button id="descargarPDFDespacho" class="btn btn-success" style="padding:10px 24px; font-size:16px; border-radius:6px; background:#27ae60; color:#fff; border:none; cursor:pointer;">
                    Descargar Reporte de Despachos
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para gráfica y PDF -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
const labelsDespacho = <?= json_encode(array_keys($productosDespachados)) ?>;
const dataDespacho = <?= json_encode(array_values($productosDespachados)) ?>;
function generarColores(n) {
    const colores = [];
    for (let i = 0; i < n; i++) {
        const hue = Math.round((360 / n) * i);
        colores.push(`hsl(${hue}, 70%, 60%)`);
    }
    return colores;
}
const coloresDespacho = generarColores(labelsDespacho.length || 1);
const ctxDespacho = document.getElementById('graficoProductosDespachados').getContext('2d');
new Chart(ctxDespacho, {
    type: 'pie',
    data: {
        labels: labelsDespacho.length ? labelsDespacho : ['Sin datos'],
        datasets: [{
            data: dataDespacho.length ? dataDespacho : [1],
            backgroundColor: coloresDespacho,
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        plugins: {
            legend: { display: true, position: 'bottom' },
            title: { display: true, text: 'Productos más despachados' }
        }
    }
});

document.getElementById('descargarPDFDespacho').addEventListener('click', function () {
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
        doc.save('Reporte_Despachos.pdf');
    });
});
</script>
		<?php include 'footer.php'; ?>
	
<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="titulo-form" id="modalModificarLabel">Modificar Recepción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
<form id="formularioEdicion">

			<input type="hidden" name="accion" id="accion" value="modificarRecepcion">
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
        <!-- Opciones dinámicas -->
    </select>
</div>

<h5>Productos</h5>
<div id="contenedorDetalles"></div>
<div class="row mt-3">
    <div class="col-12">
        <button type="button" id="btnAgregarProducto" class="btn btn-success w-100">
            <i class="fas fa-plus-circle"></i> Agregar Producto
        </button>
    </div>
</div>


      <div>

      	<div class="modal-footer"></div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
      </div>
        </form>
    </div>
  </div>
</div>

	<script>
const productosDisponibles = <?= json_encode($productos) ?>;

$(document).on('click', '.btn-modificar', function (e) {
    e.preventDefault();

    let idDespacho = $(this).data('iddespacho');
    let correlativo = $(this).data('correlativo');
    let fecha = $(this).data('fecha');
    let cliente = $(this).data('cliente');
    let productos = $(this).data('productos');

    // Si productos viene como string, conviértelo a objeto
    if (typeof productos === "string") {
        try {
            productos = JSON.parse(productos);
        } catch(e) {
            productos = [];
        }
    }

    // Llenar campos básicos
    $('#modalIdRecepcion').val(idDespacho);
    $('#modalCorrelativo').val(correlativo);
    $('#modalFecha').val(fecha);

    // Llenar select de cliente
    let selectCliente = $('#modalProveedor');
    selectCliente.empty();
    selectCliente.append('<option value="disabled" disabled>Seleccione el Cliente</option>');
    <?php foreach ($proveedores as $prov): ?>
        selectCliente.append('<option value="<?= $prov['id_clientes'] ?>"><?= addslashes($prov['nombre']) ?></option>');
    <?php endforeach; ?>
    selectCliente.val(cliente);

    // Generar HTML de productos existentes
    let html = '';
    if (productos && Array.isArray(productos)) {
        productos.forEach((item, index) => {
            html += `
                <div class="row mb-2 grupo-producto">
                    <div class="col-md-5">
                        <label>Producto</label>
                        <select class="form-control" name="productos[]">
                            ${productosDisponibles.map(prod => `
                                <option value="${prod.id_producto}" ${item.id_producto == prod.id_producto ? 'selected' : ''}>
                                    ${prod.nombre_producto}
                                </option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Cantidad</label>
                        <input type="number" class="form-control" name="cantidades[]" value="${item.cantidad}">
                    </div>
                    <div class="col-md-2">
                        
                        <input type="hidden" name="iddetalles[]" value="${item.id_detalle || ''}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-eliminar-producto">Eliminar Producto</button>
                    </div>
                </div>
            `;
        });
    } else {
        html = '<p>No se encontraron productos.</p>';
    }

    $('#contenedorDetalles').html(html);

    // Mostrar modal
    $('#modalModificar').modal('show');
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

    <script src="Javascript/despacho.js"></script>
    <script src="Javascript/validaciones.js"></script>
    <script>
function mostrarDatosFormulario(formId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    const datos = {};

    for (let [clave, valor] of formData.entries()) {
        // Si el nombre termina en [], guárdalo como array
        if (clave.endsWith('[]')) {
            const key = clave.slice(0, -2); // quita los corchetes
            if (!datos[key]) {
                datos[key] = [];
            }
            datos[key].push(valor);
        } else {
            // Si ya existe la clave, conviértelo en array
            if (datos[clave]) {
                if (!Array.isArray(datos[clave])) {
                    datos[clave] = [datos[clave]];
                }
                datos[clave].push(valor);
            } else {
                datos[clave] = valor;
            }
        }
    }

    console.log("Datos del formulario:", datos);
    alert(JSON.stringify(datos, null, 2));
}

// Ejecutar cuando se hace clic en "Registrar Recepción"
document.getElementById('registrar').addEventListener('click', function () {
    mostrarDatosFormulario('f');
});
</script>

</body>



<?php include 'footer.php'; ?>


<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>