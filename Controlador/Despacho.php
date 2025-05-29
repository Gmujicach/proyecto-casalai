<?php  

function getdespacho() {
    $despacho = new Despacho();
    return $despacho->getdespacho();
}

if (!is_file("Modelo/" . $pagina . ".php")) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

require_once("Modelo/" . $pagina . ".php");
$k = new Despacho();

if (is_file("vista/" . $pagina . ".php")) {
    $accion = $_POST['accion'] ?? '';

    if (!empty($_POST)) {
        switch ($accion) {
            case 'listado':
                $respuesta = $k->listadoproductos();
                echo json_encode($respuesta);
                break;


case 'registrar':
    $k->setidcliente($_POST['cliente']);
    $k->setcorrelativo($_POST['correlativo']);
    // Recibe los arrays correctamente
    $productos = $_POST['producto'] ?? [];
    $cantidades = $_POST['cantidad'] ?? [];
    $respuesta = $k->registrar($productos, $cantidades);
    echo json_encode($respuesta);
    break;
            case 'buscar':
                $correlativo = $_POST['correlativo'] ?? null;
                $k->setcorrelativo($correlativo);
                $respuesta = $k->buscar();
                if (!$respuesta) {
                    echo json_encode([
                        "resultado" => "no_encontro",
                        "mensaje" => "No se encontró el correlativo: " . $correlativo
                    ]);
                } else {
                    echo json_encode($respuesta);
                }
                break;

            case 'obtener_detalles':
                // Para cargar los datos de productos antes de modificar
                $idDespacho = $_POST['id_despachos'] ?? null;
                if ($idDespacho) {
                    $respuesta = $k->obtenerDetallesPorDespacho($idDespacho);
                    echo json_encode($respuesta);
                } else {
                    echo json_encode(['error' => true, 'mensaje' => 'ID de recepción no recibido']);
                }
                break;


case 'modificarRecepcion':
    $idDespacho = $_POST['id_recepcion'] ?? null;
    $idproducto = $_POST['productos'] ?? [];
    $cantidad = $_POST['cantidades'] ?? [];
    $iddetalle = $_POST['iddetalles'] ?? [];

    $k->setidcliente($_POST['proveedor']);
    $k->setcorrelativo($_POST['correlativo']);
    $k->setfecha($_POST['fecha']);

    if ($idDespacho) {
        $respuesta = $k->modificarDespacho(
            $idDespacho,
            $idproducto,
            $cantidad,
             $iddetalle
        );
        if (isset($respuesta['resultado']) && $respuesta['resultado'] === 'modificarRecepcion') {
            echo json_encode([
                'status' => 'success',
                'message' => $respuesta['mensaje']
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $respuesta['mensaje'] ?? 'Error al modificar el despacho'
            ]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de despacho faltante']);
    }
    break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Acción no válida '.$accion.'']);
        }

        exit;
    }

    // Vista inicial
    $despachos = getdespacho();
    $proveedores = $k->obtenercliente();
    $productos = $k->consultarproductos();

    require_once("vista/" . $pagina . ".php");

} else {
    echo "pagina en construccion";
}
?>