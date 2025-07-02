<?php
ob_start();

require_once 'Modelo/modelos.php';
require_once 'Modelo/Permisos.php';

$id_rol = $_SESSION['id_rol']; // Asegúrate de tener este dato en sesión

$permisosObj = new Permisos();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('modelos'));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'permisos_tiempo_real':
            header('Content-Type: application/json; charset=utf-8');
            $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('modelos'));
            echo json_encode($permisosActualizados);
            exit;
            
        case 'registrar':
            header('Content-Type: application/json; charset=utf-8');
            $modelo = new modelo();
            $modelo->setnombre_modelo($_POST['nombre_modelo']);
            $modelo->setid_marca($_POST['id_marca']);

            if ($modelo->existeNombreModelo($_POST['nombre_modelo'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El modelo ya existe'
                ]);
                exit;
            }

            if ($modelo->registrarModelo()) {
                $modeloRegistrado = $modelo->obtenerUltimoModelo();
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Modelo registrado correctamente',
                    'modelo' => $modeloRegistrado
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al registrar el modelo'
                ]);
            }
            exit;

        case 'obtener_modelo':
            $id_modelo = $_POST['id_modelo'] ;
            if ($id_modelo !== null) {
                $modelo = new modelo();
                $modelo = $modelo->obtenerModeloPorId($id);
                if ($modelo !== null) {
                    echo json_encode($modelo);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Modelo no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de modelo no proporcionado']);
            }
            exit;

        case 'modificar':
            $id_modelo= $_POST['id_modelo'];
            $modelo = new modelo();
            $modelo->setIdModelo($id_modelo);
            $modelo->setnombre_modelo($_POST['nombre_modelo']);
            $modelo->setid_marca($_POST['id_marca']);
            if ($modelo->existeNombreModelo($_POST['nombre_modelo'], $id_modelo)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El modelo ya existe'
                ]);
                exit;
            }

if ($modelo->modificarModelo($id_modelo)) {
    $modeloActualizado = $modelo->obtenerModeloConMarcaPorId($id_modelo);
    echo json_encode([
        'status' => 'success',
        'message' => 'Modelo modificado correctamente',
        'modelo' => $modeloActualizado
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al modificar el modelo'
    ]);
}
            exit;

        case 'eliminar':
            $id_modelo = $_POST['id_modelo'];
            $modelo = new modelo();
            if ($modelo->eliminarModelo($id_modelo)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el modelo']);
            }
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            break;
    }
    exit;
}



function getModelos() {
    $modelo = new modelo();
    return $modelo->getModelos();
}

function getmarcas() {
    $marcas = new modelo();
    return $marcas->getmarcas();
}

$pagina = "Modelos";
if (is_file("Vista/" . $pagina . ".php")) {

    $modelos = getModelos();
    $marcas = getmarcas();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>