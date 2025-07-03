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
require_once 'Modelo/Permisos.php';
require_once 'Modelo/Bitacora.php';

define('MODULO_RECEPCION', 1);

$id_rol = $_SESSION['id_rol']; // Asegúrate de tener este dato en sesión
$permisosObj = new Permisos();
$bitacoraModel = new Bitacora();

$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('recepcion'));
if (is_file("vista/" . $pagina . ".php")) {
    $accion = $_POST['accion'] ?? '';

    if (!empty($_POST)) {
        switch ($accion) {
            case 'listado':
                $respuesta = $k->listadoproductos();
                echo json_encode($respuesta);
                break;

    
case 'permisos_tiempo_real':
    header('Content-Type: application/json; charset=utf-8');
    $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('recepcion'));
    echo json_encode($permisosActualizados);
    exit;

            case 'registrar':
                $k->setidproveedor($_POST['proveedor']);
                $k->setcorrelativo($_POST['correlativo']);
                $respuesta = $k->registrar(
                    $_POST['producto'],
                    $_POST['cantidad'],
                    $_POST['costo']
                );

                $bitacoraModel->registrarAccion(
                    'Creación de despacho: ' . $_POST['correlativo'], 
                    MODULO_DESPACHO,
                    $_SESSION['id_usuario']
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
    $idRecepcion = $_POST['id_recepcion'] ?? null;
    $idproducto = $_POST['productos'] ?? [];
    $cantidad = $_POST['cantidades'] ?? [];
    $costo = $_POST['costos'] ?? [];   
    $iddetalle = $_POST['iddetalles'] ?? [];

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
    break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Acción no válida '.$accion.'']);
        }

        exit;
    }

    // Vista inicial
    $recepciones = getrecepcion();
    $proveedores = $k->obtenerproveedor();
    $productos = $k->consultarproductos();
    $totalRecepciones = count($recepciones);

// Total de productos recibidos y agrupados por producto
$productosRecibidos = [];
foreach ($recepciones as $r) {
    $nombre = $r['nombre_producto'];
    $cantidad = (int)$r['cantidad'];
    if (!isset($productosRecibidos[$nombre])) {
        $productosRecibidos[$nombre] = 0;
    }
    $productosRecibidos[$nombre] += $cantidad;
}
$totalProductosRecibidos = array_sum($productosRecibidos);
    require_once("vista/" . $pagina . ".php");

} else {
    echo "pagina en construccion";
}
?>
