<?php 

//lo primero que se debe hacer es verificar al igual que en la vista es que exista el archivo
if (!is_file("Modelo/Productos.php")){
	//alli pregunte que si no es archivo se niega con !
	//si no existe envio mensaje y me salgo
	echo "Falta definir la clase ";
	exit;
}
else{
//llamda al archivo que contiene la clase
//rusuarios, en ella estara el codigo que me premitira
//generar el reporte haciando uso de la libreria DOMPDF
require_once('Modelo/Productos.php');
}
  
  if(is_file("vista/ReporteProductos.php")){
	  
	  //bien si estamos aca es porque existe la vista y la clase
	  //por lo que lo primero que debemos hace es realizar una instancia de la clase
	  //instanciar es crear una variable local, que contiene los metodos de la clase
	  //para poderlos usar
            $productos = new Productos();
            $datos = $productos->obtenerProductoStock();
	 		require_once("Vista/ReporteProductos.php"); 
  }
  else{
	  echo "pagina en construccion";
  }
?>
