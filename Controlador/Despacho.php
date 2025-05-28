<?php  

function getdespacho() {
    $recepcion = new Despacho();
    return $recepcion->getdespacho();
}

if (!is_file("Modelo/Despacho.php")) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

require_once("Modelo/Despacho.php");
$k = new Despacho();

if (is_file("vista/Despacho.php")) {
    $accion = $_POST['accion'] ?? '';

   if (!empty($_POST)) {
        switch ($accion) {
            case 'listado':
                $respuesta = $k->listadoproductos();
                echo json_encode($respuesta);
                break;

            case 'registrar':
                $k->setIdClientes($_POST['id_clientes']);
                $k->setCorrelativo($_POST['correlativo']);
                $respuesta = $k->registrarDespacho();
                echo json_encode(value: $respuesta);
                break;

            case 'buscar':

/*
case 'modificarDespacho':

    $k->setIdClientes($_POST['clientes']);
    $k->setcorrelativo($_POST['correlativo']);
    $k->setFechaDespacho($_POST['fecha']);

    if ($idRecepcion) {
        $respuesta = $k->modificarDespacho();
        if (isset($respuesta['resultado']) && $respuesta['resultado'] === 'modificarRecepcion') {
            echo json_encode([
                'status' => 'success',
                'message' => $respuesta['mensaje']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $respuesta['mensaje'] ?? 'Error al modificar la recepción'
            ]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de recepción faltante']);
    }
    break;*/

            default:
                echo json_encode(['status' => 'error', 'message' => 'Acción no válida '.$accion.'']);
        }

        exit;
    }

    // Vista inicial
    $recepciones = getdespacho();
    $proveedores = $k->obtenerfactura();
    $productos = $k->consultarproductos();

    require_once("vista/Despacho.php");

} else {
    echo "pagina en construccion";
}
?>
