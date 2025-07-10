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
		   <label for="nombre">Nombre</label>
		   <input class="form-control" type="text" id="nombre" name="nombre" />
		   <span id="snombre"></span>
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
		
		
		<a href="?pagina=Usuarios">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
				<path d="M15 18l-6-6 6-6" />
			</svg>
			<span>Volver</span>
		</a>
</div>
</form>
	
</div> <!-- fin de container -->

<script src="Javascript/sweetalert2.all.min.js"></script>
<script src="public/js/jquery.min.js"></script>
<script src="Javascript/js/jquery-3.5.1.min.js"></script>
<script src="Javascript/js/popper.min.js"></script>
<script src="Javascript/js/boostrap.min.js"></script>


</body>
</html>