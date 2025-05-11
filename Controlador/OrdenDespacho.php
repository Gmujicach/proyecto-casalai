<?php
ob_start();

require_once 'Modelo/OrdenDespacho.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'ingresar':
            $ordendespacho = new OrdenDespacho();
            $ordendespacho->setCorrelativo($_POST['correlativo']);
            $ordendespacho->setFecha($_POST['fecha']);
            $ordendespacho->setFactura($_POST['factura']);
            
            // Validar que el correlativo no exista
            if (!$ordendespacho->validarCorrelativo()) {

                echo json_encode(['status' => 'error', 'message' => 'Este correlativo ya existe']);
            } else {
                if ($ordendespacho->ingresarOrdenDespacho()) {
                    echo json_encode(['status' => 'success', 'message' => 'Orden ingresada correctamente']);

                    exit;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar la orden de despacho']);
                }
            }
            break;

            case 'obtenerOrden':
                $id = $_POST['id'] ?? null; // Usa 'id' para que coincida con el JS
            
                if ($id !== null) {
                    $ordenModel = new OrdenDespacho();
                    $orden = $ordenModel->obtenerOrdenPorId($id);
            
                    if ($orden !== null) {
                        echo json_encode([
                            'status' => 'success',
                            'datos' => $orden
                        ]);
                    } else {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Orden de despacho no encontrada'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'ID de la orden no proporcionado'
                    ]);
                }
                break;
            

        case 'modificar':
            $id = $_POST['id_despachos'];
            $ordendespacho = new OrdenDespacho();
            $ordendespacho->setId($id);
            $ordendespacho->setFecha($_POST['fecha_despacho']);
            $ordendespacho->setFactura($_POST['factura']);
            $ordendespacho->setCorrelativo($_POST['correlativo']);
            if ($ordendespacho->modificarOrdenDespacho($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el Usuario']);
            }
            break;

        case 'eliminar':
            $id = $_POST['id'];
            $ordendespachoModel = new OrdenDespacho();
            if ($ordendespachoModel->eliminarOrdenDespacho($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto']);
            }
            break;

        default:
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida', 'accion' => $accion]);
        break;


        // Cambiar estatus
        case 'cambiar_estatus':
            $id = $_POST['id_despachos'];
            $nuevoEstatus = $_POST['nuevo_estatus'];
            
            // Validación básica
            if (!in_array($nuevoEstatus, ['habilitado', 'inhabilitado'])) {
                echo json_encode(['status' => 'error', 'message' => 'Estatus no válido']);
                exit;
            }
            
            $ordendespacho = new OrdenDespacho();
            $ordendespacho->setId($id);
            
            if ($ordendespacho->cambiarEstatus($nuevoEstatus)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estatus']);
            }
            break;
    }
    exit;
}




function getordendespacho() {
    $ordendespacho = new OrdenDespacho();
    return $ordendespacho->getordendespacho();
}

$pagina = "OrdenDespacho";
if (is_file("Vista/" . $pagina . ".php")) {

    $ordendespacho = getordendespacho();
    
    // Obtener facturas disponibles
    $ordenModel = new OrdenDespacho();
    $facturas = $ordenModel->obtenerFacturasDisponibles();

    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();?>