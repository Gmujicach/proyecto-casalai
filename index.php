<?php 
$pagina = "Login"; 



 if (!empty($_GET['pagina'])){ 
   $pagina = $_GET['pagina'];  
 }

$rango = "";
if (is_file("modelo/validalogin.php")) {
   require_once("modelo/validalogin.php");
   $v = new validalogin();
   if ($pagina == 'cerrar') {
      $v->destruyesesion();
   } else {
      $name = $v->leesesion();
   }
}

 if(is_file("Controlador/".$pagina.".php")){ 
    require_once("Controlador/".$pagina.".php");
 }
 else{
    echo "Página en construcción";
 }
 
