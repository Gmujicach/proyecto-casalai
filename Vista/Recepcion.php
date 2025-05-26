<?php
if (!isset($_SESSION['name'])) {
	header('Location: .');
	exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <title>Gestionar Recepcion</title>
</head>

<body>
<?php include 'NewNavBar.php'; ?>

	<div class="formulario-responsivo">
    <div class="fondo-form">
		<section class="container">
			<form method="post" action="" id="f">
				<input type="hidden" name="accion" id="accion" style="display:none" />
				<h3 class="titulo-form">Incluir Recepción</h3>
						<div class="grupo-form">
							<input type="text" placeholder="Correlativo del producto" class="control-form" maxlength="10" id="correlativo" name="correlativo" />
							<span id="scorrelativo"></span>
						
							<select class="form-select" name="proveedor" id="proveedor">
								<option value='disabled' disabled selected>Seleccione un Proveedor</option>
								<?php
								foreach ($proveedores  as $proveedor) {
									echo "<option value='" . $proveedor['id_proveedor'] . "'>" . $proveedor['nombre'] . "</option>";
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
										<th>Costo</th>
										<th>Cantidad</th>
									</tr>
								</thead>
								<tbody class="" id="recepcion1">
								</tbody>
							</table>
						</div>

					<div>
						<button type="button" class="boton-form" id="registrar" name="registrar">Registrar Recepción</button>
					</div>
				</form>
			
			<div class="modal fade" tabindex="-1" role="dialog" id="modalp">
				<div class="modal-dialog " role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Listado de productos</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							</button>
						</div>
						<div class="modal-body">
							<table class="table table-striped table-hover">
								<thead class="text-center">
									<tr>
										<th style="display:none">Id</th>
										<th>Codigo</th>
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
		</section>
	</div>
	</div>					

	<div class="contenedor-tabla">
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
				<th>MODIFICACION</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$rowspans = [];
			foreach ($recepciones as $recepcion) {
				$key = $recepcion['correlativo'];
				if (!isset($rowspans[$key])) {
					$rowspans[$key] = 1;
				} else {
					$rowspans[$key]++;
				}
			}


			$rendered = [];

			foreach ($recepciones as $recepcion):
				$correlativo = $recepcion['correlativo'];
			?>
				<tr>
				<?php if (!in_array($correlativo, $rendered)): ?>
					<td rowspan="<?= $rowspans[$correlativo] ?>">
					<?= htmlspecialchars($recepcion['fecha']) ?>
					</td>
					<td rowspan="<?= $rowspans[$correlativo] ?>">
					<?= htmlspecialchars($recepcion['correlativo']) ?>
					</td>
					<td rowspan="<?= $rowspans[$correlativo] ?>">
					<?= htmlspecialchars($recepcion['nombre']) ?>
					</td>
				<?php endif; ?>

				<td><?= htmlspecialchars($recepcion['nombre_producto']); ?></td>
				<td><?= htmlspecialchars($recepcion['cantidad']); ?></td>
				<td><?= htmlspecialchars($recepcion['costo']); ?></td>
					<?php
					$productosDelCorrelativo = array_filter($recepciones, function($r) use ($correlativo) {
						return $r['correlativo'] === $correlativo;
					});
					$dataProductos = [];

					foreach ($productosDelCorrelativo as $item) {
						$dataProductos[] = [
							'id_producto' => $item['id_producto'],
							'nombre_producto' => $item['nombre_producto'],
							'cantidad' => $item['cantidad'],
							'costo' => $item['costo'],
							'iddetalles' => $item['id_detalle_recepcion_productos'] 
						];
					}
					?>

				<?php if (!in_array($correlativo, $rendered)): ?>
					<td rowspan="<?= $rowspans[$correlativo] ?>">
						<button class="btn-modificar"
							data-bs-toggle="modal"
							data-bs-target="#modalModificar"
							data-idrecepcion="<?= htmlspecialchars($recepcion['id_recepcion']) ?>"
							data-correlativo="<?= htmlspecialchars($recepcion['correlativo']) ?>"
							data-fecha="<?= htmlspecialchars($recepcion['fecha']) ?>"
							data-proveedor="<?= htmlspecialchars($recepcion['id_proveedor']) ?>"
							data-productos='<?= json_encode($dataProductos, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
							Modificar
						</button>



					</td>
					<?php $rendered[] = $correlativo; ?>
				<?php endif; ?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

		<div class="table-container">
						
						<div class="row">
							<div class="col">
								<button class="btn" name="" type="button" id="pdfrepecion" name="pdfrecepcion"><a href="?pagina=pdfrecepcion">GENERAR REPORTE</a></button>
							</div>
						</div>
		</div>
		<?php include 'footer.php'; ?>
	
<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg para más espacio -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalModificarLabel">Modificar Recepción</h5>
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

    let idRecepcion = $(this).data('idrecepcion');
    let correlativo = $(this).data('correlativo');
    let fecha = $(this).data('fecha');
    let proveedor = $(this).data('proveedor');
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
    $('#modalIdRecepcion').val(idRecepcion);
    $('#modalCorrelativo').val(correlativo);
    $('#modalFecha').val(fecha);

    // Llenar select de proveedor
    let selectProveedor = $('#modalProveedor');
    selectProveedor.empty();
    selectProveedor.append('<option value="disabled" disabled>Seleccione un Proveedor</option>');
    <?php foreach ($proveedores as $prov): ?>
        selectProveedor.append('<option value="<?= $prov['id_proveedor'] ?>"><?= addslashes($prov['nombre']) ?></option>');
    <?php endforeach; ?>
    selectProveedor.val(proveedor);

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
                        <label>Costo</label>
                        <input type="number" class="form-control" name="costos[]" value="${item.costo}">
                        <input type="hidden" name="iddetalles[]" value="${item.iddetalles || ''}">
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



	<script type="text/javascript" src="Javascript/recepcion.js"></script>

</body>
</html>