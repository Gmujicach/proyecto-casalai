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
				<h3 class="titulo-form">Gestionar Recepcion</h3>
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
			
				<div class="row">
					<div class="col">
						<hr />
					</div>
				</div>
				

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

	<div class="contenedor-tabla">
  <h1 class="titulo-tabla display-5 text-center">LISTA DE RECEPCIONES</h1>
  <table class="tablaConsultas">
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
                data-correlativo="<?= htmlspecialchars($recepcion['correlativo']) ?>"
                data-producto="<?= htmlspecialchars($recepcion['nombre_producto']) ?>"
                data-cantidad="<?= htmlspecialchars($recepcion['cantidad']) ?>"
                data-costo="<?= htmlspecialchars($recepcion['costo']) ?>">
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

<<<<<<< HEAD
	
<!-- Modal para modificación -->
<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg para más espacio -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalModificarLabel">Modificar Recepción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formularioEdicion">
          <div class="mb-3">
            <label for="modalFecha" class="form-label">Fecha:</label>
            <input type="date" class="form-control" name="fecha" id="modalFecha">
          </div>
          <div class="mb-3">
            <label for="modalCorrelativo" class="form-label">Correlativo:</label>
            <input type="text" class="form-control" name="correlativo" id="modalCorrelativo" readonly>
          </div>

          <div id="productosContainer">
            <!-- Aquí se agregarán los productos dinámicamente con JS -->
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


=======
>>>>>>> 8adf8e6ac0efa63ecf6d285db9560d2f17100de1
    <?php include 'footer.php'; ?>
	<script type="text/javascript" src="Javascript/recepcion.js"></script>
	<script>
  const recepciones = <?= json_encode($recepciones); ?>;
  const modal = document.getElementById('modalEdicion');
  const cerrar = document.querySelector('.cerrar');
  const productosContainer = document.getElementById('productosContainer');

  document.querySelectorAll('.modificar').forEach((btn, index) => {
    btn.addEventListener('click', () => {
      const correlativo = recepciones[index].correlativo;
      const grupo = recepciones.filter(r => r.correlativo === correlativo);

      document.getElementById('modalFecha').value = grupo[0].fecha;
      document.getElementById('modalCorrelativo').value = grupo[0].correlativo;

      productosContainer.innerHTML = ''; // limpiar antes de agregar

grupo.forEach((item, i) => {
  productosContainer.innerHTML += `
    <fieldset style="margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 8px;">
      <legend style="font-weight: bold; padding: 0 10px;">Producto ${i + 1}</legend>

      <div style="margin-bottom: 10px;">
        <label style="display: block; margin-bottom: 4px;">Producto:</label>
        <input type="text" name="producto[]" value="${item.nombre_producto}" required
          style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
      </div>

      <div style="margin-bottom: 10px;">
        <label style="display: block; margin-bottom: 4px;">Cantidad:</label>
        <input type="number" name="cantidad[]" value="${item.cantidad}" required
          style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
      </div>

      <div>
        <label style="display: block; margin-bottom: 4px;">Costo:</label>
        <input type="number" step="0.01" name="costo[]" value="${item.costo}" required
          style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
      </div>
    </fieldset>
  `;
});


      modal.style.display = 'block';
    });
  });

  cerrar.onclick = function () {
    modal.style.display = 'none';
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  };
</script>




</body>
</html>