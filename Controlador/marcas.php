<?php
ob_start();
require_once 'Modelo/marcas.php';
require_once 'Modelo/Permisos.php';

$id_rol = $_SESSION['id_rol']; // Asegúrate de tener este dato en sesión

$permisosObj = new Permisos();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('marcas'));
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'registrar':
            header('Content-Type: application/json; charset=utf-8');
            $marca = new marca();
            $marca->setnombre_marca($_POST['nombre_marca']);
            
            if ($marca->existeNombreMarca($_POST['nombre_marca'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre de la marca ya existe'
                ]);
                exit;
            }

            if ($marca->registrarMarca()) {
                $marcaRegistrada = $marca->obtenerUltimaMarca();
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Marca registrada correctamente',
                    'marca' => $marcaRegistrada
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al registrar la marca'
                ]);
            }
            exit;
            case 'permisos_tiempo_real':
    header('Content-Type: application/json; charset=utf-8');
    // Ejecuta SIEMPRE la consulta en tiempo real
    $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('marcas'));
    echo json_encode($permisosActualizados);
    exit;

        case 'obtener_marcas':
            $id_marca = $_POST['id_marca'];
            if ($id_marca !== null) {
                $marca = new marca();
                $marca = $marca->obtenermarcasPorId($id_marca);
                if ($marca !== null) {
                    echo json_encode($marca);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Marca no encontrada']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de Marca no proporcionado']);
            }
            exit;

        case 'modificar':
            ob_clean();
            header('Content-Type: application/json; charset=utf-8');
            $id_marca = $_POST['id_marca'];
            $marca = new marca();
            $marca->setIdMarca($id_marca);
            $marca->setnombre_marca($_POST['nombre_marca']);

            if ($marca->existeNombreMarca($_POST['nombre_marca'], $id_marca)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre de la marca ya existe'
                ]);
                exit;
            }
            
            if ($marca->modificarmarcas($id_marca)) {
                $marcaActualizada = $marca->obtenermarcasPorId($id_marca);

                echo json_encode([
                    'status' => 'success',
                    'marca' => $marcaActualizada
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar la marca']);
            }
            exit;

        case 'eliminar':
            $id_marca = $_POST['id_marca'];
            $marca = new marca();
            if ($marca->eliminarmarcas($id_marca)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la marca']);
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        break;
    }
}


function getmarcas() {
    $marca = new marca();
    return $marca->getmarcas();
}


$pagina = "marcas";
if (is_file("Vista/" . $pagina . ".php")) {
    $marcas = getmarcas();
    // Pasa $permisosUsuario a la vista
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>