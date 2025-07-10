<?php



if (!isset($_SESSION['name'])) {

 	header('Location: .');
 	exit();
 }
?>



<html>
	<?php include 'header.php'; ?>
    <link rel="stylesheet" href="Styles/pdf.css">
<body>


<div class="containera"> <!-- todo el contenido ira dentro de esta etiqueta-->

<form method="post" action="" id="f" target="_blank">
<div class="">
    <div class="row">
		<div class="col">
		   <label for="fecha_recepcion">Fecha de Recepcion</label>
		   <input class="form-control" type="text" id="fecha_recepcion" name="fecha_recepcion" />
		   <span id="sfecha_recepcion"></span>
		</div>

		<div class="col">
		   <label for="correlativo">Correlativo</label>
		   <input class="form-control" type="text" id="correlativo" name="correlativo" />
		   <span id="scorrelativo"></span>
		</div>

		<div class="col">
		   <label for="id_proveedor">ID del Proveedor</label>
		   <input class="form-control" type="text" id="id_proveedor" name="id_proveedor" />
		   <span id="sid_proveedor"></span>
		</div>

	</div>

    
	<div class="row">
		<div class="col">
			<hr/>
		</div>
	</div>

	<div class="boton">
			   <button type="submit" class="btn btn-primary" id="generar" name="generar">GENERAR PDF</button>
		</div>
		
		
		<a href="?pagina=Recepcion">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
				<path d="M15 18l-6-6 6-6" />
			</svg>
			<span>Volver</span>
		</a>
</div>
</form>
	
</div> <!-- fin de container -->

<script src="javascript/sweetalert2.all.min.js"></script>
<script src="public/js/jquery.min.js"></script>
<script src="javascript/js/jquery-3.5.1.min.js"></script>
<script src="javascript/js/popper.min.js"></script>
<script src="javascript/js/boostrap.min.js"></script>


</body>
</html>