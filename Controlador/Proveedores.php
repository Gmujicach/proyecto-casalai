<?php
ob_start();

require_once 'Modelo/Proveedores.php';


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
                if ($proveedor->ingresarProveedor()) {
                    echo json_encode(['status' => 'success']);
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
            $proveedor->setNombre($_POST['nombre_proveedor']);
            $proveedor->setRif1($_POST['rif_proveedor']);
            $proveedor->setRepresentante($_POST['nombre_representante']);
            $proveedor->setRif2($_POST['rif_representante']);
            $proveedor->setCorreo($_POST['correo_proveedor']);
            $proveedor->setObservacion($_POST['observacion']);
            $proveedor->setTelefono1($_POST['telefono_1']);
            $proveedor->setTelefono2($_POST['telefono_2']);
            $proveedor->setDireccion($_POST['direccion_proveedor']);
            
            if ($proveedor->modificarProveedor($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el Proveedor']);
            }
            break;

        case 'eliminar':
            $id = $_POST['id'];
            $proveedorModel = new Proveedores();
            if ($proveedorModel->eliminarProveedor($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el Proveedor']);
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

$pagina = "Proveedores";
if (is_file("Vista/" . $pagina . ".php")) {

    $proveedores = getproveedores();

    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>
