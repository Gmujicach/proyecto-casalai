<?php
ob_start();

require_once 'Modelo/OrdenDespacho.php';
require_once 'Modelo/Permisos.php';
require_once 'Modelo/Bitacora.php';
define('MODULO_ORDEN_DESPACHO', 14); // Define el ID del módulo de cuentas bancarias


$id_rol = $_SESSION['id_rol'];

if (isset($_SESSION['id_usuario'])) {
    $bitacoraModel->registrarAccion('Acceso al módulo de Orden de Despacho', MODULO_ORDEN_DESPACHO, $_SESSION['id_usuario']);
}
$permisosObj = new Permisos();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, 'Ordenes de despacho');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
                case 'permisos_tiempo_real':
            header('Content-Type: application/json; charset=utf-8');
            $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, 'Ordenes de despacho');
            echo json_encode($permisosActualizados);
            exit;

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
                    $bitacoraModel->registrarAccion('Registro de orden de despacho: ' . $_POST['correlativo'], MODULO_ORDEN_DESPACHO, $_SESSION['id_usuario']);
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
                $bitacoraModel->registrarAccion('Modificación de orden de despacho: ' . $_POST['correlativo'], MODULO_ORDEN_DESPACHO, $_SESSION['id_usuario']);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el Usuario']);
            }
            break;

        case 'eliminar':
            $id = $_POST['id'];
            $ordendespachoModel = new OrdenDespacho();
            if ($ordendespachoModel->eliminarOrdenDespacho($id)) {
                $bitacoraModel->registrarAccion('Eliminación de orden de despacho: ' . $id, MODULO_ORDEN_DESPACHO, $_SESSION['id_usuario']);
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
                $bitacoraModel->registrarAccion('Cambio de estatus de orden de despacho: ' . $id . ' a ' . $nuevoEstatus, MODULO_ORDEN_DESPACHO, $_SESSION['id_usuario']);
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