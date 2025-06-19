<?php



if (!isset($_SESSION['name'])) {

 	header('Location: .');
 	exit();
 }
?>




<html>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="Styles/PDF.css">
<body>


<div class="containera"> <!-- todo el contenido ira dentro de esta etiqueta-->

<form method="post" action="" id="f" target="_blank">
<div class="">
    <div class="row">
		<div class="col">
		   <label for="fecha_despacho">Fecha de Despacho</label>
		   <input class="form-control" type="text" id="fecha_despacho" name="fecha_despacho" />
		   <span id="sfecha_despacho"></span>
		</div>

		<div class="col">
		   <label for="correlativo">Correlativo</label>
		   <input class="form-control" type="text" id="correlativo" name="correlativo" />
		   <span id="scorrelativo"></span>
		</div>

		<div class="col">
		   <label for="cantidad">Cantidad</label>
		   <input class="form-control" type="text" id="cantidad" name="cantidad" />
		   <span id="scantidad"></span>
		</div>

		<div class="col">
		   <label for="id_clientes">ID del Cliente</label>
		   <input class="form-control" type="text" id="id_clientes" name="id_clientes" />
		   <span id="sid_clientes"></span>
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
		
		
		<a href="?pagina=Despacho">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
				<path d="M15 18l-6-6 6-6" />
			</svg>
			<span>Volver</span>
		</a>
</div>
</form>
	
</div> <!-- fin de container -->

<script src="Javascript/sweetalert2.all.min.js"></script>
<script src="Public/js/jquery.min.js"></script>
<script src="Javascript/js/jquery-3.5.1.min.js"></script>
<script src="Javascript/js/popper.min.js"></script>
<script src="Javascript/js/boostrap.min.js"></script>


</body>
</html>