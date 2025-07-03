<?php
ob_start();

require_once 'Modelo/Proveedores.php';
require_once 'Modelo/Productos.php';
require_once 'Modelo/Permisos.php';
require_once 'Modelo/Bitacora.php';
define('MODULO_PROVEEDORES', 8); // Define el ID del módulo de proveedores

$id_rol = $_SESSION['id_rol']; // Asegúrate de tener este dato en sesión

if (isset($_SESSION['id_usuario'])) {
    $bitacoraModel->registrarAccion('Acceso al módulo de Proveedores', MODULO_PROVEEDORES, $_SESSION['id_usuario']);
}

$permisosObj = new Permisos();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('proveedores'));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
                case 'permisos_tiempo_real':
            header('Content-Type: application/json; charset=utf-8');
            $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('proveedores'));
            echo json_encode($permisosActualizados);
            exit;
            
        case 'registrar':
            $proveedor = new Proveedores();
            $proveedor->setNombre($_POST['nombre_proveedor']);
            $proveedor->setRif1($_POST['rif_proveedor']);
            $proveedor->setRepresentante($_POST['nombre_representante']);
            $proveedor->setRif2($_POST['rif_representante']);
            $proveedor->setCorreo($_POST['correo_proveedor']);
            $proveedor->setDireccion($_POST['direccion_proveedor']);
            $proveedor->setTelefono1($_POST['telefono_1']);
            $proveedor->setTelefono2($_POST['telefono_2']);
            $proveedor->setObservacion($_POST['observacion']);
            
            if ($proveedor->existeNombreProveedor($_POST['nombre_proveedor'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre del proveedor ya existe'
                ]);
                exit;
            }

            if ($proveedor->registrarProveedor()) {
                $proveedorRegistrado = $proveedor->obtenerUltimoProveedor();
                $bitacoraModel->registrarAccion('Registro de proveedor: ' . $proveedorRegistrado['nombre'], MODULO_PROVEEDORES, $_SESSION['id_usuario']);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Proveedor registrado correctamente',
                    'proveedor' => $proveedorRegistrado
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al registrar el proveedor'
                ]);
            }
            exit;

        case 'obtener_proveedor':
            $id_proveedor = $_POST['id_proveedor'];
            if ($id_proveedor !== null) {
                $proveedor = new Proveedores();
                $proveedor = $proveedor->obtenerProveedorPorId($id_proveedor);
                if ($proveedor !== null) {
                    echo json_encode($proveedor);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Proveedor no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID del Proveedor no proporcionado']);
            }
            exit;

        case 'modificar':
            ob_clean();
            header('Content-Type: application/json; charset=utf-8');
            $id_proveedor = $_POST['id_proveedor'];
            $proveedor = new Proveedores();
            $proveedor->setIdProveedor($id_proveedor);
            $proveedor->setNombre($_POST['nombre_proveedor']);
            $proveedor->setRif1($_POST['rif_proveedor']);
            $proveedor->setRepresentante($_POST['nombre_representante']);
            $proveedor->setRif2($_POST['rif_representante']);
            $proveedor->setCorreo($_POST['correo_proveedor']);
            $proveedor->setDireccion($_POST['direccion_proveedor']);
            $proveedor->setTelefono1($_POST['telefono_1']);
            $proveedor->setTelefono2($_POST['telefono_2']);
            $proveedor->setObservacion($_POST['observacion']);
            
            if ($proveedor->existeNombreProveedor($_POST['nombre_proveedor'], $id_proveedor)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre del proveedor ya existe'
                ]);
                exit;
            }
            
            if ($proveedor->modificarProveedor($id_proveedor)) {
                $proveedorActualizado = $proveedor->obtenerProveedorPorId($id_proveedor);
                $bitacoraModel->registrarAccion('Modificación de proveedor: ' . $proveedorActualizado['nombre'], MODULO_PROVEEDORES, $_SESSION['id_usuario']);

                echo json_encode([
                    'status' => 'success',
                    'proveedor' => $proveedorActualizado
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el proveedor']);
            }
            exit;

        case 'eliminar':
            $id_proveedor = $_POST['id_proveedor'];
            if ($id_proveedor === null) {
                echo json_encode(['status' => 'error', 'message' => 'ID del Proveedor no proporcionado']);
                exit;
            }
            $proveedor = new Proveedores();
            if ($proveedor->eliminarProveedor($id_proveedor)) {
                $bitacoraModel->registrarAccion('Eliminación de proveedor con ID: ' . $id_proveedor, MODULO_PROVEEDORES, $_SESSION['id_usuario']);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el Proveedor']);
            }
            exit;
        
        case 'cambiar_estado':
            $id_proveedor = $_POST['id_proveedor'];
            $nuevoEstatus = $_POST['nuevo_estatus'];

            if (!in_array($nuevoEstatus, ['habilitado', 'inhabilitado'])) {
                echo json_encode(['status' => 'error', 'message' => 'Estado no válido']);
                exit;
            }

            $proveedor = new Proveedores();
            $proveedor->setIdProveedor($id_proveedor);
            if ($proveedor->cambiarEstatus($nuevoEstatus)) {
                $proveedorActualizado = $proveedor->obtenerProveedorPorId($id_proveedor);
                $bitacoraModel->registrarAccion('Cambio de estatus del proveedor: ' . $proveedorActualizado['nombre'] . ' a ' . $nuevoEstatus, MODULO_PROVEEDORES, $_SESSION['id_usuario']);
                if ($nuevoEstatus === 'habilitado') {
                    $estatusMensaje = 'habilitado';
                } else {
                    $estatusMensaje = 'inhabilitado';
                }
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estatus del Proveedor']);
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        break;
    }
}

function getproveedores() {
    $proveedor = new Proveedores();
    return $proveedor->getproveedores();
}

$proveedorModel = new Proveedores();
$reporteSuministroProveedores = $proveedorModel->obtenerReporteSuministroProveedores();
$totalSuministrado = array_sum(array_column($reporteSuministroProveedores, 'cantidad'));

function obtenerProductosConBajoStock() {
    $producto = new Producto();
    return $producto->obtenerProductosConBajoStock();
}

$pagina = "Proveedores";
if (is_file("Vista/" . $pagina . ".php")) {

    $proveedores = getproveedores();
    $productos = obtenerProductosConBajoStock();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>
