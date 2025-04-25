<?php

function getdespacho() {
    $despacho = new Despacho();
    return $despacho->getdespacho();
}

if (!is_file("modelo/" . $pagina . ".php")) {
 
    echo "Falta definir la clase " . $pagina;
    exit;
}
require_once("modelo/" . $pagina . ".php");
if (is_file("vista/" . $pagina . ".php")) {

    if (!empty($_POST)) {

        $o = new Despacho();
        $accion = $_POST['accion'];
        if ($accion == 'listadoproductos') {
            $respuesta = $o->listadoproductos();
            echo json_encode($respuesta);
        } elseif ($accion == 'registrar') {
            $respuesta = $o->registrar($_POST['cliente'], $_POST['idp'], $_POST['cant'], $_POST['correlativo']);
            echo json_encode($respuesta);
        }
        exit;
    }
    $o2 = new Despacho();
    $clientes = $o2->obtenercliente();
    $despachos = getdespacho();

    require_once("vista/" . $pagina . ".php");
} else {
    echo "pagina en construccion";
}
