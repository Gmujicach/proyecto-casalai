<?php
ob_start();

require_once 'Modelo/modelos.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'ingresar':
            $modelo = new modelo();
            $modelo->setdescripcion_mo($_POST['descripcion_mo']);
            $modelo->setid_marca($_POST['id_marca']);

            if (!$modelo->validarmodelo()) {
                echo json_encode(['status' => 'error', 'message' => 'Este Modelo ya existe']);
            }
            else {
                if ($modelo->ingresarmodelos()) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar el Modelo']);
                }
            }
            break;

        case 'obtener_modelo':
            $id = $_POST['id_modelo'] ;
            if ($id !== null) {
                $modelo = new modelo();
                $modelo = $modelo->obtenermodelosPorId($id);
                if ($modelo !== null) {
                    echo json_encode($modelo);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Modelo no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de modelo no proporcionado']);
            }
            break;

        case 'modificar':
            $id = $_POST['id_modelo'];
            $modelo = new modelo();
            $modelo->setId($id);
            $modelo->setdescripcion_mo($_POST['descripcion_mo']);
            
            if ($modelo->modificarmodelos($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el modelo']);
            }
            break;

        case 'eliminar':
            $id = $_POST['id'];
            $modeloModel = new modelo();
            if ($modeloModel->eliminarmodelos($id)) {
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



function getmodelos() {
    $modelo = new modelo();
    return $modelo->getmodelos();
}

function getmarcas() {
    $marcas = new modelo();
    return $marcas->getmarcas();
}

$pagina = "Modelos";
if (is_file("Vista/" . $pagina . ".php")) {

    $modelos = getmodelos();
    $marcas = getmarcas();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>