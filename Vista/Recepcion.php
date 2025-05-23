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
				<h3 class="display-4 text-center">Gestionar Recepcion</h3>
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
										<th>Cantidad</th>
										<th>Costo</th>
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
			<h1 class="titulo-tabla display-5 text-center ">Lista de Recepciones</h1>
			<table class="tablaConsultas">
				<thead>
					<tr>
						<th>Fecha</th>
						<th>Correlativo</th>
						<th>Proveedor</th>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Costo de Inversion</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// Agrupar por correlativo para calcular cuántas filas debe ocupar rowspan
					$rowspans = [];

					foreach ($recepciones as $recepcion) {
						$key = $recepcion['correlativo']; // agrupamos por correlativo
						if (!isset($rowspans[$key])) {
							$rowspans[$key] = 1;
						} else {
							$rowspans[$key]++;
						}
					}

					$rendered = []; // Para evitar repetir la fecha/correlativo/proveedor

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
								<?php $rendered[] = $correlativo; ?>
							<?php endif; ?>
							<td><?= htmlspecialchars($recepcion['nombre_producto']); ?></td>
							<td><?= htmlspecialchars($recepcion['cantidad']); ?></td>
							<td><?= htmlspecialchars($recepcion['costo']); ?></td>
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

    <?php include 'footer.php'; ?>
	<script type="text/javascript" src="Javascript/recepcion.js"></script>

</body>
</html>