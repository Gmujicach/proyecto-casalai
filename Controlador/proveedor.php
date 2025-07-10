<?php
ob_start();

require_once 'modelo/proveedor.php';
require_once 'modelo/producto.php';
require_once 'modelo/permiso.php';
require_once 'modelo/bitacora.php';

$id_rol = $_SESSION['id_rol']; // Asegúrate de tener este dato en sesión

// Definir constantes para IDs de módulo y acciones
define('MODULO_PROVEEDORES', 8); // Cambiar según tu estructura de módulos

$permisosObj = new Permisos();
$bitacoraModel = new Bitacora();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('proveedores'));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario_accion = $_SESSION['id_usuario'] ?? null; // Usuario que realiza la acción
    
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
                
                // Registrar en bitácora
                $bitacoraModel->registrarAccion(
                    'Creación de proveedor: ' . $_POST['nombre_proveedor'], 
                    MODULO_PROVEEDORES, 
                    $_SESSION['id_usuario']
                );
                
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
                $proveedorData = $proveedor->obtenerProveedorPorId($id_proveedor);
                
                if ($proveedorData !== null) {
                    echo json_encode($proveedorData);
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
                
                // Registrar en bitácora
                $bitacoraModel->registrarAccion(
                    'Actualización de proveedor: ' . $_POST['nombre_proveedor'], 
                    MODULO_PROVEEDORES, 
                    $_SESSION['id_usuario']
                );

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
            // Obtener datos del proveedor antes de eliminarlo
            $proveedorAEliminar = $proveedor->obtenerProveedorPorId($id_proveedor);
            
            if ($proveedor->eliminarProveedor($id_proveedor)) {
                // Registrar en bitácora
                $bitacoraModel->registrarAccion(
                    'Eliminación de cuenta: (ID: ' . $id_proveedor . ')', 
                    MODULO_PROVEEDORES, 
                    $_SESSION['id_usuario']
                );
                
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
                // Registrar en bitácora
                $bitacoraModel->registrarAccion(
                    'Cambio de estado a ' . $nuevoEstatus . ' para proveedor ID: ' . $id_proveedor, 
                    MODULO_PROVEEDORES, 
                    $_SESSION['id_usuario']
                );
                
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

$pagina = "proveedor";
if (is_file("Vista/" . $pagina . ".php")) {
    if (isset($_SESSION['id_usuario'])) {
    $bitacoraModel->registrarAccion('Acceso al módulo de proveedores', MODULO_PROVEEDORES, $_SESSION['id_usuario']);
}
    $proveedores = getproveedores();
    $productos = obtenerProductosConBajoStock();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>
