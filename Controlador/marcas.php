<?php
ob_start();

require_once 'Modelo/marcas.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'ingresar':
            $marca = new marca();
            $marca->setnombre_marca($_POST['nombre_marca']);
            
            if (!$marca->validarmarca()) {
                echo json_encode(['status' => 'error', 'message' => 'Esta Marca ya existe']);
            }
            else {
                if ($marca->ingresarmarcas()) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar la Marca']);
                }
            }
            break;

        case 'obtener_marcas':
            $id = $_POST['id_marca'];
            if ($id !== null) {
                $marca = new marca();
                $marca = $marca->obtenermarcasPorId($id);
                if ($marca !== null) {
                    echo json_encode($marca);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Marca no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de Marca no proporcionado']);
            }
            break;

        case 'modificar':
            $id = $_POST['id_marca'];
            $marca = new marca();
            $marca->setId($id);
            $marca->setnombre_marca($_POST['nombre_marca']);
            
            if ($marca->modificarmarcas($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el producto']);
            }
            break;

        case 'eliminar':
            $id = $_POST['id'];
            $marcaModel = new marca();
            if ($marcaModel->eliminarmarcas($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto']);
            }
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            break;
    }
    exit;
}



function getmarcas() {
    $marca = new marca();
    return $marca->getmarcas();
}

$pagina = "Marcas";
if (is_file("Vista/" . $pagina . ".php")) {

    $marcas = getmarcas();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>