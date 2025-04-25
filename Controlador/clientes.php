<?php
ob_start();

require_once 'Modelo/Clientes.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'ingresar':
            $cliente = new cliente();
            $cliente->setnombre($_POST['nombre']);
            $cliente->setpersona($_POST['persona']);
            $cliente->setdireccion($_POST['direccion']);
            $cliente->settelefono_1($_POST['telefono_1']);
            $cliente->settelefono_2($_POST['telefono_2']);
            $cliente->setrif($_POST['rif']);
            $cliente->setcorreo($_POST['correo']);
            $cliente->setobservacion($_POST['observacion']);
            
            // if ($cliente->ingresarclientes()) {
            //     echo json_encode(['status' => 'success']);
            // } else {
            //     echo json_encode(['status' => 'error', 'message' => 'Error al ingresar el Cliente']);
            // }

            if (!$cliente->validaRifCliente()) {
                echo json_encode(['status' => 'error', 'message' => 'Este Cliente ya existe']);
            }
            else {
                if ($cliente->ingresarclientes()) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar el Cliente']);
                }
            }
            break;

        case 'obtener_clientes':
            $id = $_POST['id_clientes'];
            if ($id !== null) {
                $cliente = new cliente();
                $cliente = $cliente->obtenerclientesPorId($id);
                if ($cliente !== null) {
                    echo json_encode($cliente);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Cliente no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de Cliente no proporcionado']);
            }
            break;

        case 'modificar':
            $id = $_POST['id_clientes'];
            $cliente = new cliente();
            $cliente->setId($id);
            $cliente->setnombre($_POST['nombre']);
            $cliente->setpersona($_POST['persona']);
            $cliente->setdireccion($_POST['direccion']);
            $cliente->settelefono_1($_POST['telefono_1']);
            $cliente->settelefono_2($_POST['telefono_2']);
            $cliente->setrif($_POST['rif']);
            $cliente->setcorreo($_POST['correo']);
            $cliente->setobservacion($_POST['observacion']);
            
            if ($cliente->modificarclientes($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el Cliente']);
            }
            break;

        case 'eliminar':
            $id = $_POST['id'];
            $clientesModel = new cliente();
            if ($clientesModel->eliminarclientes($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el Cliente']);
            }
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            break;
    }
    exit;
}



function getclientes() {
    $cliente = new cliente();
    return $cliente->getclientes();
}

$pagina = "Clientes";
if (is_file("Vista/" . $pagina . ".php")) {

    $clientes = getclientes();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>