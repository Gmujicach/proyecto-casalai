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
    $accion = $_POST['accion'] ?? '';

    if (!empty($_POST)) {
        switch ($accion) {
            case 'listado':
                $respuesta = $k->listadoproductos();
                echo json_encode($respuesta);
                break;

            case 'registrar':
                $k->setidproveedor($_POST['proveedor']);
                $k->setcorrelativo($_POST['correlativo']);
                $respuesta = $k->registrar(
                    $_POST['producto'],
                    $_POST['cantidad'],
                    $_POST['costo']
                );
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
                $idRecepcion = $_POST['id_recepcion'] ?? null;
                if ($idRecepcion) {
                    $respuesta = $k->obtenerDetallesPorRecepcion($idRecepcion);
                    echo json_encode($respuesta);
                } else {
                    echo json_encode(['error' => true, 'mensaje' => 'ID de recepción no recibido']);
                }
                break;

            case 'modificarRecepcion':
                // Este es el que llama a la función modificar()
                $idRecepcion = $_POST['id_recepcion'] ?? null;
                $idproducto = $_POST['productos'] ?? [];
                $cantidad = $_POST['cantidades'] ?? [];
                $costo = $_POST['costos'] ?? [];
                $iddetalle = $_POST['iddetalle'] ?? [];

                $k->setidproveedor($_POST['proveedor']);
                $k->setcorrelativo($_POST['correlativo']);
                $k->setfecha($_POST['fecha']);

                if ($idRecepcion) {
                    $respuesta = $k->modificar(
                        $idRecepcion,
                        $idproducto,
                        $cantidad,
                        $costo,
                        $iddetalle
                    );
                    echo json_encode($respuesta);
                } else {
                    echo json_encode(['resultado' => 'error', 'mensaje' => 'ID de recepción faltante']);
                }
                break;

            default:
                echo json_encode(['resultado' => 'error', 'mensaje' => 'Acción no válida '.$accion.'']);
        }

        exit;
    }

    // Vista inicial
    $recepciones = getrecepcion();
    $proveedores = $k->obtenerproveedor();
    $productos = $k->consultarproductos();

    require_once("vista/" . $pagina . ".php");

} else {
    echo "pagina en construccion";
}
?>
