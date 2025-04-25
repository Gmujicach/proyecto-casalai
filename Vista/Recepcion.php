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
    <link rel="stylesheet" href="Styles/darckort.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Gestionar Recepcion</title>
</head>

<body>

	<?php require_once("vista/NavBar.php"); ?>

	<div class="container">
		
	<section class="container">

		<div class="container"> 
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
						<div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="descripcion" class="form-label">Descripción:</label>
                                    <textarea class="form-control" maxlength="50" id="descripcion" name="descripcion" rows="3" required></textarea>
                                    <span id="sdescripcion"></span>
                                </div>
                            </div>

					</div>
				</div>

				
			

		
                <div class="row">
                    <div class="col-md-8 input-group">
                    <input class="" type="text" id="codigoproducto" name="codigoproducto" style="display:none"/>
                    <input class="" type="text" id="idproducto" name="idproducto" style="display:none"/>
                    <button type="button" class="btn btn-primary" id="listado" name="listado">LISTA DEPRODUCTOS</button>
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

	<div class="table-container">
    <h1 class="titulo-tabla display-5 text-center">LISTA DE RECEPCIONES</h1>
    <table class="tabla">
        <thead>
            <tr>
                <th>FECHA</th>
                <th>CORRELATIVO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recepciones as $recepcion): ?>
                <tr>
                    <td><?php echo htmlspecialchars($recepcion['fecha_recepcion']); ?></td>
                    <td><?php echo htmlspecialchars($recepcion['correlativo']); ?></td>
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