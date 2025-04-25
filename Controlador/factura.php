<?php

if (!is_file("modelo/Factura.php")) {
 
    echo "Falta definir la clase " . $pagina;
    exit;
}

require_once("modelo/Factura.php");
if (is_file("vista/factura.php")) {

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

    require_once("vista/factura.php");
} else {
    echo "pagina en construccion";
}
