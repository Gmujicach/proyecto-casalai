<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Almacenista' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')) { ?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <title>Gestionar Compra Fisica</title>
</head>

<?php include 'newnavbar.php'; ?>

<body class="fondo" style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<!-- ...código anterior... -->
<div class="modal fade modal-registrar" id="registrarCompraFisicaModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarCompraFisicaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="f" method="POST" enctype="multipart/form-data" onsubmit="return validarFormularioCompra()">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarCompraFisicaModalLabel">Incluir Compra</h5>
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
                        <label for="cliente">Cliente (Buscar por nombre o cédula)</label>
                        <input type="text" id="buscarCliente" placeholder="Escriba para buscar..." class="control-form">
                        <select class="form-select" name="cliente" id="cliente" style="width: 100%;" size="5">
                            <option value='disabled' disabled selected>Seleccione el Cliente</option>
                            <?php
                            foreach ($proveedores as $proveedor) {
                                echo "<option value='" . $proveedor['id_clientes'] . "' data-cedula='" . $proveedor['cedula'] . "'>" . 
                                    htmlspecialchars($proveedor['nombre'] . " - C.I. " . $proveedor['cedula']) . "</option>";
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
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    
                                </tr>
                            </thead>
                            <tbody class="" id="recepcion1">
                            </tbody>
                        </table>
                    </div>
                    <hr>
<!-- Monto total y cambio -->
<div class="row mb-3">
    <div class="col-md-6">
        <label for="monto_total" class="form-label">Monto total a cancelar</label>
        <input type="text" id="monto_total" name="monto_total" class="form-control" value="0.00" disabled>
    </div>
    <div class="col-md-6">
        <label for="cambio_efectivo" class="form-label">Cambio</label>
        <input type="text" id="cambio_efectivo" name="cambio_efectivo" class="form-control" value="0.00" disabled>
    </div>
</div>
                    <!-- PAGOS DINÁMICOS -->
                    <div id="pagos-container">
                        <!-- Aquí se agregarán los bloques de pago dinámicamente -->
                    </div>
                    <button type="button" id="agregarPago" class="btn btn-secondary" style="margin-top: 10px;">Agregar otro pago</button>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="envolver-form">
                            <label><strong>TOTAL DE LA COMPRA:</strong></label>
                            <input type="text" class="control-form" id="totalCompra" name="totalCompra" readonly style="font-weight: bold; font-size: 1.2rem;">
                        </div>
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
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>modelo</th>
                            <th>Marca</th>
                            <th>Serial</th>
                            <th>Precio</th>
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

        </div>
    </div>
</div>

<div class="contenedor-tabla">
    <div class="space-btn-incluir">
        <button id="btnIncluirDespacho" class="btn-incluir">
            Incluir Despacho
        </button>
    </div>


<h3>Lista de Compras Físicas en Local</h3>
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

<!-- Scripts para gráfica y PDF -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<script>
const productosDisponibles = <?= json_encode(array_map(function($prod) {
    return [
        'id_producto' => $prod['id_producto'],
        'nombre_producto' => $prod['nombre_producto'],
        'precio' => $prod['precio'],
        ];
}, $productos)) ?>;

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



</body>



<?php include 'footer.php'; ?>

<!-- jQuery primero -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="javascript/comprafisica.js"></script>
<script src="javascript/validaciones.js"></script>


<script>
const cuentas = <?php echo json_encode($listadocuentas); ?>;
const todosMetodos = ['Pago Movil', 'Transferencia', 'Efectivo']; // Lista de todos los métodos posibles

// Función para filtrar cuentas por método de pago
function filtrarCuentasPorMetodo(metodo) {
    return cuentas.filter(cuenta => {
        const metodosCuenta = cuenta.metodos ? cuenta.metodos.split(',') : [];
        return metodosCuenta.includes(metodo);
    });
}

// Función para crear un bloque de pago
function crearBloquePago(idx) {
    return `
    <div class="bloque-pago" style="border:1px solid #ccc; padding:15px; margin-bottom:15px; border-radius:8px; position:relative;">
        <button type="button" class="btn btn-danger btn-sm btn-quitar-pago" style="position:absolute;top:8px;right:8px;display:${idx==0?'none':'inline-block'};">Quitar</button>
        
        <!-- Primero seleccionar el tipo de pago -->
        <div class="envolver-form">
            <label for="tipo_${idx}">Tipo de pago</label>
            <select class="control-form tipo-pago" name="pagos[${idx}][tipo]" id="tipo_${idx}" required>
                <option value="" disabled selected>Seleccione</option>
                ${todosMetodos.map(m => `<option value="${m}">${m}</option>`).join('')}
            </select>
        </div>
        
        <!-- Luego seleccionar la cuenta (se llena dinámicamente según el tipo) -->
        <div class="envolver-form">
            <label for="cuenta_${idx}">Cuenta</label>
            <select class="control-form cuenta-pago" name="pagos[${idx}][cuenta]" id="cuenta_${idx}" required disabled>
                <option value="" disabled selected>Primero seleccione un tipo de pago</option>
            </select>
        </div>
        
        <!-- Campos específicos del pago -->
        <div class="campos-pago" id="campos_pago_${idx}">
            <!-- Aquí se insertan los campos según el tipo -->
        </div>
    </div>
    `;
}

// Función para campos según tipo de pago (igual que antes)
function camposPorTipo(tipo, idx) {
    let montoField = `
        <input type="number" step="0.01" class="control-form" min="0" 
        name="pagos[${idx}][monto]" id="monto_${idx}" required
        onkeydown="return validarTeclaMonto(event)">
    `;

    if (tipo === "Pago Movil") {
        return `
        <div class="envolver-form">
            <label for="referencia_${idx}">Referencia</label>
            <input type="text" class="control-form" name="pagos[${idx}][referencia]" id="referencia_${idx}" required>
        </div>
        <div class="envolver-form">
            <label for="fecha_${idx}">Fecha</label>
            <input type="date" class="control-form" name="pagos[${idx}][fecha]" id="fecha_${idx}" required>
        </div>
        <div class="envolver-form">
            <label for="comprobante_${idx}">Comprobante (imagen)</label>
            <input type="file" class="control-form" name="pagos[${idx}][comprobante]" id="comprobante_${idx}" accept="image/*" required>
        </div>
        <div class="envolver-form">
            <label for="monto_${idx}">Monto Recibido</label>
            ${montoField}
        </div>
        `;
    } else if (tipo === "Transferencia") {
        return `
        <div class="envolver-form">
            <label for="referencia_${idx}">Referencia</label>
            <input type="text" class="control-form" name="pagos[${idx}][referencia]" id="referencia_${idx}" required>
        </div>
        <div class="envolver-form">
            <label for="fecha_${idx}">Fecha</label>
            <input type="date" class="control-form" name="pagos[${idx}][fecha]" id="fecha_${idx}" required>
        </div>
        <div class="envolver-form">
            <label for="monto_${idx}">Monto Recibido</label>
            ${montoField}
        </div>
        `;
    } else if (tipo === "Efectivo") {
        return `
        <div class="envolver-form">
            <label for="monto_${idx}">Monto Recibido</label>
            ${montoField}
        </div>
        `;
    } else {
        return '';
    }
}

// 🔹 Función para bloquear signos + y - en montos
function validarTeclaMonto(e) {
    // Códigos de teclas para + y -
    if (e.key === '+' || e.key === '-' || e.keyCode === 187 || e.keyCode === 189) {
        return false; // Bloquea la entrada
    }
    return true; // Permite las demás teclas
}


// Inicializar el formulario con un pago
let pagosCount = 0;
function agregarPagoBloque() {
    $('#pagos-container').append(crearBloquePago(pagosCount));
    pagosCount++;
}
agregarPagoBloque();

// Evento para agregar otro pago
$('#agregarPago').on('click', function() {
    agregarPagoBloque();
});

// Evento para quitar un bloque de pago
$(document).on('click', '.btn-quitar-pago', function() {
    $(this).closest('.bloque-pago').remove();
});

// Evento al cambiar el tipo de pago: actualizar cuentas disponibles y mostrar campos
$(document).on('change', '.tipo-pago', function() {
    const idx = $(this).attr('id').split('_')[1];
    const tipoSeleccionado = $(this).val();
    const $cuentaSelect = $(`#cuenta_${idx}`);
    
    if (tipoSeleccionado) {
        // Filtrar cuentas que tienen este método de pago
        const cuentasFiltradas = filtrarCuentasPorMetodo(tipoSeleccionado);
        
        // Actualizar el select de cuentas
        $cuentaSelect.empty().prop('disabled', false);
        $cuentaSelect.append('<option value="" disabled selected>Seleccione una cuenta</option>');
        
        cuentasFiltradas.forEach(cuenta => {
            $cuentaSelect.append(
                `<option value="${cuenta.id_cuenta}">
                    ${cuenta.nombre_banco} - ${cuenta.numero_cuenta}
                </option>`
            );
        });
        
        // Mostrar campos específicos para este tipo de pago
        $(`#campos_pago_${idx}`).html(camposPorTipo(tipoSeleccionado, idx));
    } else {
        $cuentaSelect.empty().prop('disabled', true);
        $cuentaSelect.append('<option value="" disabled selected>Primero seleccione un tipo de pago</option>');
        $(`#campos_pago_${idx}`).empty();
    }
});

// Evento al cambiar la cuenta (si necesitas hacer algo cuando se selecciona una cuenta)
$(document).on('change', '.cuenta-pago', function() {
    // Aquí puedes agregar lógica adicional si necesitas hacer algo cuando se selecciona una cuenta
});
</script>
<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>