<?php
  



//lo primero que se debe hacer es verificar al igual que en la vista es que exista el archivo
if (!is_file("modelo/".$pagina.".php")){
	//alli pregunte que si no es archivo se niega con !
	//si no existe envio mensaje y me salgo
	echo "Falta definir la clase ".$pagina;
	exit;
}
else{
//llamda al archivo que contiene la clase
//rusuarios, en ella estara el codigo que me premitira
//generar el reporte haciando uso de la libreria DOMPDF
require_once('modelo/pdfclientes.php');
}
  
  if(is_file("vista/".$pagina.".php")){
	  
	  //bien si estamos aca es porque existe la vista y la clase
	  //por lo que lo primero que debemos hace es realizar una instancia de la clase
	  //instanciar es crear una variable local, que contiene los metodos de la clase
	  //para poderlos usar
	  
	  $o = new rusuarios(); //ahora nuestro objeto se llama $o y es una copia en memoria de la
	  //clase rusuarios
	  
	  if(isset($_POST['generar'])){
		  $o = new rusuarios();
		  $o->set_rif($_POST['rif']);
		  $o->set_nombre($_POST['nombre']);
		  $o->generarPDF();
	  }
	  
	  require_once("vista/".$pagina.".php"); 
  }
  else{
	  echo "pagina en construccion";
  }
?>