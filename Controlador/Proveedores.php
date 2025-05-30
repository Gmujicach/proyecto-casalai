<?php
ob_start();

require_once 'Modelo/Proveedores.php';
require_once 'Modelo/Productos.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'ingresar':
            $proveedor = new Proveedores();
            $proveedor->setNombre($_POST['nombre_proveedor']);
            $proveedor->setRif1($_POST['rif_proveedor']);
            $proveedor->setRepresentante($_POST['nombre_representante']);
            $proveedor->setRif2($_POST['rif_representante']);
            $proveedor->setCorreo($_POST['correo_proveedor']);
            $proveedor->setObservacion($_POST['observacion']);
            $proveedor->setTelefono1($_POST['telefono_1']);
            $proveedor->setTelefono2($_POST['telefono_2']);
            $proveedor->setDireccion($_POST['direccion_proveedor']);
            
            if (!$proveedor->validarProveedor()) {
                echo json_encode(['status' => 'error', 'message' => 'Este Proveedor ya existe']);
            }elseif(!$proveedor->validarProveedorRif()) {
                echo json_encode(['status' => 'error', 'message' => 'Este R.I.F ya esta registrador']);
            }
            else {
                $nuevoProveedor = $proveedor->ingresarProveedor();
if ($nuevoProveedor) {
    echo json_encode(['status' => 'success', 'proveedor' => $nuevoProveedor]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar el Usuario']);
}
            }
            break;

        case 'obtener_proveedor':
            $id = $_POST['id_proveedor'];
            if ($id !== null) {
                $proveedor = new Proveedores();
                $proveedor = $proveedor->obtenerProveedorPorId($id);
                if ($proveedor !== null) {
                    echo json_encode($proveedor);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Proveedor no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID del Proveedor no proporcionado']);
            }
            break;

        case 'modificar':
$id = $_POST['id_proveedor'];
$proveedor = new Proveedores();
$proveedor->setId($id);
$proveedor->setNombre($_POST['nombre']);
$proveedor->setRif1($_POST['rif_proveedor']);
$proveedor->setRepresentante($_POST['persona_contacto']);
$proveedor->setRif2($_POST['rif_representante']);
$proveedor->setCorreo($_POST['correo']);
$proveedor->setObservacion($_POST['observaciones']);
$proveedor->setTelefono1($_POST['telefono']);
$proveedor->setTelefono2($_POST['telefono_secundario']);
$proveedor->setDireccion($_POST['direccion']);

            
            if ($proveedor->modificarProveedor($id)) {
    $proveedorActualizado = $proveedor->obtenerProveedorPorId($id);
    echo json_encode(['status' => 'success', 'proveedor' => $proveedorActualizado]);
}else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el Proveedor']);
            }
            break;

        case 'eliminar':
            $id_proveedor = $_POST['id_proveedor']; // Cambiado para coincidir con el nombre enviado
            if ($id_proveedor === null) {
                echo json_encode(['status' => 'error', 'message' => 'ID del Proveedor no proporcionado']);
                exit;
            }
            $proveedor = new Proveedores();
            if ($proveedor->eliminarProveedor($id_proveedor)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el Proveedor']);
            }
            break;
            case 'cambiar_estado':
            $id_proveedor = $_POST['id_proveedor'];
            $nuevoEstatus = $_POST['nuevo_estatus'];
            $proveedor = new Proveedores();
            $proveedor->setId($id_proveedor);
            if ($proveedor->cambiarEstatus($nuevoEstatus)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estatus del Proveedor']);
            }
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            break;
    }
    exit;
}



function getproveedores() {
    $proveedor = new Proveedores();
    return $proveedor->getproveedores();
}

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
