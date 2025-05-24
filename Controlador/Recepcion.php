<?php  

function getrecepcion() {
    $recepcion = new Recepcion();
    return $recepcion->getrecepcion();
}
if (!is_file("Modelo/" . $pagina . ".php")) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

require_once("Modelo/" . $pagina . ".php");
$k = new Recepcion();
if (is_file("vista/" . $pagina . ".php")) {
    // Verificar si el formulario ha sido enviado con el campo 'accion'
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    if (!empty($_POST)) {
     
        if ($accion == 'listado') {
            $respuesta = $k->listadoproductos();
            echo json_encode($respuesta);
        } elseif ($accion == 'registrar') {
            $k->setidproveedor($_POST['proveedor']);
            $k->setcorrelativo( $_POST['correlativo']);
            $respuesta = $k->registrar(

                $_POST['producto'],
                
                $_POST['cantidad'],

                $_POST['costo']
               
            );
            echo json_encode($respuesta);
        } elseif ($accion == 'buscar') {
            $k->setcorrelativo( $_POST['correlativo']);
    $correlativo = isset($_POST['correlativo']) ? $_POST['correlativo'] : null;
    $respuesta = $k->buscar();
    
    if (!$respuesta) {
        echo json_encode(["resultado" => "no_encontro", "mensaje" => "No se encontró el correlativo: " . $correlativo]);
    } else {
        echo json_encode($respuesta);
    }
}

        exit;
    }
    $recepciones = getrecepcion();
    $proveedores = $k->obtenerproveedor();
    $productos = $k->consultarproductos();
    require_once("vista/" . $pagina . ".php");
} else {
    echo "pagina en construccion";
}

