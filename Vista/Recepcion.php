<?php
if (!isset($_SESSION['name'])) {
	header('Location: .');
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">

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
			<form method="post" action="" id="f" class="formulario-1">
				<input type="text" name="accion" id="accion" style="display:none" />
				<h3 class="titulo-form">Incluir Recepción</h3>
				<div class="">
					<div class="row">
						<div class="col">
							<label class="form-label mt-4" for="correlativo">Correlativo del producto</label>
							<input class="form-control" maxlength="10" type="text" id="correlativo" name="correlativo" />
							<span id="scorrelativo"></span>
						</div>
						<div class="col">
							<label class="form-label mt-4" for="proveedor">Proveedor</label>
							<select class="form-select" name="proveedor" id="proveedor">
								<option value='disabled' disabled selected>Seleccione un Proveedor</option>
								<?php
								foreach ($proveedores  as $proveedor) {
									echo "<option value='" . $proveedor['id_proveedor'] . "'>" . $proveedor['nombre'] . "</option>";
								} ?>
							</select>
						</div>
					</div>
				</div>
		
                <div class="row">
                    <div class="col-md-8 input-group">
                    <input class="" type="text" id="codigoproducto" name="codigoproducto" style="display:none"/>
                    <input class="" type="text" id="idproducto" name="idproducto" style="display:none"/>
                    <button type="button" class="btn btn-primary" id="listado" name="listado">Lista de Productos</button>
                    </div>
                </div>
			
<<<<<<< HEAD
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
						<button type="button" class="boton-form" id="registrar" name="registrar">Registrar Recepcion</button>
					</div>
				</form>
=======
				<div class="row">
					<div class="col">
						<hr />
					</div>
				</div>
>>>>>>> 1cd78d79ec817127917216b4d11f7dcd9441cf0a
				

				<div class="table-responsive card shadow">

					<div class="row">
						<div class="">
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
					</div>
				</div>

				<div class="row">
					<div>
						<button type="button" class="btn btn-primary" id="registrar" name="registrar">Registrar Recepcion</button>
					</div>
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

				<?php if (!in_array($correlativo, $rendered)): ?>
					<td rowspan="<?= $rowspans[$correlativo] ?>">
					<button class="boton-form modificar"
    data-bs-toggle="modal"
    data-bs-target="#modalModificar"
    data-correlativo="<?= htmlspecialchars($recepcion['correlativo']) ?>">
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
	</div>
	
	<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg para más espacio -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalModificarLabel">Modificar Recepción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formularioEdicion">
		
        	<input type="hidden" name="id_detalles" id="modificarIdDetalles">
          <div class="mb-3">
            <label for="modalFecha" class="form-label">Fecha:</label>
            <input type="date" class="form-control" name="fecha" id="modalFecha" required>
          </div>
		  	<div class="mb-3">
			<label class="form-label mt-4" for="proveedor">Proveedor</label>
			<select class="form-select" name="proveedor" id="proveedor">
				<option value='disabled' disabled selected>Seleccione un Proveedor</option>
				<?php
				foreach ($proveedores  as $proveedor) {
					echo "<option value='" . $proveedor['id_proveedor'] . "'>" . $proveedor['nombre'] . "</option>";
				} ?>
			</select>
		</div>
          <div class="mb-3">
            <label for="modalCorrelativo" class="form-label">Correlativo:</label>
            <input type="text" class="form-control" name="correlativo" id="modalCorrelativo" readonly>
          </div>

          <hr>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Productos</h6>
            <button type="button" class="btn btn-success btn-sm" id="btnAgregarProducto">+ Incluir producto</button>
          </div>

          <div id="productosContainer">
            <!-- JS insertará aquí los productos -->
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" form="formularioEdicion" class="btn btn-primary">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

    <?php include 'footer.php'; ?>
	<script type="text/javascript" src="Javascript/recepcion.js">

	<script>
	document.getElementById('btnAgregarProducto').addEventListener('click', () => {
  const productosContainer = document.getElementById('productosContainer');
  const index = productosContainer.children.length + 1;

  const fieldset = document.createElement('fieldset');
  fieldset.classList.add('border', 'p-3', 'mb-2');
  fieldset.innerHTML = `
    <legend class="fs-6">Producto ${index}</legend>
    <div class="row g-2">
      <div class="col-md-5">
        <label class="form-label">Producto:</label>
        <select class="form-select select-producto" name="producto[]">
          <option value="">Seleccione...</option>
          <!-- Opciones serán insertadas dinámicamente si lo deseas -->
          <option value="Producto A">Producto A</option>
          <option value="Producto B">Producto B</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Cantidad:</label>
        <input type="number" class="form-control" name="cantidad[]" min="1" value="1" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Costo:</label>
        <input type="number" class="form-control" name="costo[]" min="0.01" step="0.01" value="0.00" required>
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button type="button" class="btn btn-danger btn-sm btnEliminarProducto">×</button>
      </div>
    </div>
  `;

  productosContainer.appendChild(fieldset);
});

// Delegación de evento para eliminar productos
document.getElementById('productosContainer').addEventListener('click', function (e) {
  if (e.target.classList.contains('btnEliminarProducto')) {
    e.target.closest('fieldset').remove();
  }
});

<script>
document.addEventListener('DOMContentLoaded', function () {
  const botonesModificar = document.querySelectorAll('.boton-form.modificar');

  botonesModificar.forEach(boton => {
    boton.addEventListener('click', function () {
      const correlativo = this.getAttribute('data-correlativo');
      const producto = this.getAttribute('data-producto');
      const cantidad = this.getAttribute('data-cantidad');
      const costo = this.getAttribute('data-costo');

      document.getElementById('modalCorrelativo').value = correlativo;

      // También podrías establecer la fecha si la incluyes como data-fecha
      // document.getElementById('modalFecha').value = this.getAttribute('data-fecha');

      // Limpiar el contenedor antes de agregar nuevos campos
      const contenedor = document.getElementById('productosContainer');
      contenedor.innerHTML = '';

      const fieldset = document.createElement('fieldset');
      fieldset.classList.add('border', 'p-3', 'mb-2');
      fieldset.innerHTML = `
        <legend class="fs-6">Producto 1</legend>
        <div class="row g-2">
          <div class="col-md-5">
            <label class="form-label">Producto:</label>
            <select class="form-select select-producto" name="producto[]">
              <option value="">Seleccione...</option>
              <option value="${producto}" selected>${producto}</option>
              <option value="Producto A">Producto A</option>
              <option value="Producto B">Producto B</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Cantidad:</label>
            <input type="number" class="form-control" name="cantidad[]" value="${cantidad}" min="1" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Costo:</label>
            <input type="number" class="form-control" name="costo[]" value="${costo}" min="0.01" step="0.01" required>
          </div>
          <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-sm btnEliminarProducto">×</button>
          </div>
        </div>
      `;

      contenedor.appendChild(fieldset);
    });
  });
});


</script>

<script>
  // Preparar datos agrupados por correlativo para JS
  const recepcionesPorCorrelativo = <?php 
    $data = [];
    foreach ($recepciones as $recepcion) {
        $key = $recepcion['correlativo'];
        if (!isset($data[$key])) $data[$key] = [];
        $data[$key][] = [
          'producto' => $recepcion['nombre_producto'],
          'cantidad' => $recepcion['cantidad'],
          'costo' => $recepcion['costo'],
          'fecha' => $recepcion['fecha'], // para mostrar fecha en el modal si quieres
        ];
    }
    echo json_encode($data);
  ?>;
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const botonesModificar = document.querySelectorAll('.boton-form.modificar');

  botonesModificar.forEach(boton => {
    boton.addEventListener('click', function () {
      const correlativo = this.getAttribute('data-correlativo');

      // Setear correlativo en el modal
      document.getElementById('modalCorrelativo').value = correlativo;

      // Limpiar contenedor de productos
      const contenedor = document.getElementById('productosContainer');
      contenedor.innerHTML = '';

      // Buscar productos para este correlativo en el objeto JS
      const productos = recepcionesPorCorrelativo[correlativo] || [];

      productos.forEach((producto, index) => {
        const fieldset = document.createElement('fieldset');
        fieldset.classList.add('border', 'p-3', 'mb-2');
        fieldset.innerHTML = `
          <legend class="fs-6">Producto ${index + 1}</legend>
          <div class="row g-2">
            <div class="col-md-5">
              <label class="form-label">Producto:</label>
              <select class="form-select select-producto" name="producto[]">
                <option value="">Seleccione...</option>
                <option value="${producto.producto}" selected>${producto.producto}</option>
                <option value="Producto A">Producto A</option>
                <option value="Producto B">Producto B</option>
                <!-- Añade más opciones si quieres -->
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Cantidad:</label>
              <input type="number" class="form-control" name="cantidad[]" value="${producto.cantidad}" min="1" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Costo:</label>
              <input type="number" class="form-control" name="costo[]" value="${producto.costo}" min="0.01" step="0.01" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
              <button type="button" class="btn btn-danger btn-sm btnEliminarProducto">×</button>
            </div>
          </div>
        `;

        contenedor.appendChild(fieldset);
      });
    });
  });
});

</script>


</body>
</html>