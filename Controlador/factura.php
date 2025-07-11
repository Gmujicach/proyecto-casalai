<?php

if (!is_file("Modelo/factura.php")) {
 
    echo "Falta definir la clase " . $pagina;
    exit;
}

require_once("Modelo/factura.php");
if (is_file("Vista/factura.php")) {

    if (!empty($_POST)) {

        $o = new Producto();
        $accion = $_POST['accion'];
        if ($accion == 'listadoproductos') {
            $respuesta = $o->listadoproductos();
            echo json_encode($respuesta);
        } elseif ($accion == 'registrar') {
            /*$respuesta = $o->registrar($_POST['cliente'], $_POST['idp'], $_POST['cant'], $_POST['correlativo']);
            echo json_encode($respuesta);*/
        }
        exit;
    }

    require_once("Vista/factura.php");
} else {
    echo "pagina en construccion";
}
