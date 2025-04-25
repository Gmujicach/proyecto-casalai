<?php
if (!is_file("Modelo/" . $pagina . ".php")) {
    echo "Falta el modelo";
    exit;
}
require_once("Modelo/" . $pagina . ".php");
if (is_file("Vista/" . $pagina . ".php")) {
    if (!empty($_POST)) {

        $o = new Login();
        $h= $_POST['accion'];
       // echo  $h;
        if ($_POST['accion'] == 'acceder') {
            $o->set_username($_POST['username']);
            $o->set_password($_POST['password']);
            $m = $o->existe();
            if ($m['resultado'] == 'existe') {
                session_destroy(); 	
                session_start(); 
                $_SESSION['name'] = $m['mensaje'];
                $_SESSION['rango']= $m['rango'];
                header('Location: ?pagina=Dashboard');
 
                die();
            } else{
                $mensaje = $m['mensaje'];
             
                /* echo "<script>alert('Error en username y/o password!!!');</script>"; */
               /*  echo  json_encode($o->existe()); */
            }
        }
    }

    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Falta la vista";
}