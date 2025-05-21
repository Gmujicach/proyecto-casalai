<?php
ob_start();
require_once 'Modelo/rango.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'registrar':
            $rango = new Rango();
            $rango->setNombreRango($_POST['nombre_rango']);

            if ($rango->registrarRango()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al registrar el rango']);
            }
            exit;
        
        case 'obtener_rango':
            $id_rango = $_POST['id_rango'];

            if ($id_rango !== null) {
                $rango = new Rango();
                $rango_obt = $rango->obtenerRangoPorId($id_rango);

                if ($rango_obt !== null) {
                    echo json_encode($rango_obt);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Rango no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de rango no proporcionado']);
            }
            break;
        
        case 'consultar_cuentas':
            $rango = new Rango();
            $rangos_obt = $rango->consultarRangos();

            echo json_encode($ranangos_obt);
            exit;

        case 'modificar':
            $id_rango = $_POST['id_rango'];
            $rango = new Rango();
            $rango->setIdRango($id_rango); // Establecer el ID de la rango
            $rango->setNombreRango($_POST['nombre_rango']);
            
            if ($rango->modificarRango($id_rango)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el rango']);
            }
            break;

        case 'eliminar':
            $id_rango = $_POST['id_rango'];
            $rango = new Rango();

            if ($rango->eliminarRango($id_rango)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el rango']);
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        exit;
    }
}

$pagina = "rango";
if (is_file("Vista/" . $pagina . ".php")) {
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "La página no existe"; // Mensaje si la vista no existe
}

ob_end_flush();
?>