<?php
ob_start();

require_once 'Modelo/clientes.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'registrar':
            $cliente = new cliente();
            $cliente->setnombre($_POST['nombre']);
            $cliente->setdireccion($_POST['direccion']);
            $cliente->settelefono($_POST['telefono']);
            $cliente->setcedula($_POST['cedula']);
            $cliente->setcorreo($_POST['correo']);
            
            if ($cliente->existeNumeroCedula($_POST['cedula'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El número de cedula/RIF ya existe'
                ]);
                exit;
            }

            if ($cliente->ingresarclientes()) {
                $clienteRegistrado = $cliente->obtenerUltimaCliente();
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cliente registrado correctamente',
                    'cliente' => $clienteRegistrado
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al registrar el cliente'
                ]);
            }
            exit;

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
            exit;

        case 'modificar':
            $id = $_POST['id_clientes'];
            $cliente = new cliente();
            $cliente->setId($id);
            $cliente->setnombre($_POST['nombre']);
            $cliente->setdireccion($_POST['direccion']);
            $cliente->settelefono($_POST['telefono']);
            $cliente->setcedula($_POST['cedula']);
            $cliente->setcorreo($_POST['correo']);
            
            if ($cliente->existeNumeroCedula($_POST['cedula'], $id)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El número de cedula/RIF ya existe'
                ]);
                exit;
            }

            if ($cliente->modificarclientes($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el cliente']);
            }
            exit;

        case 'eliminar':
            $id = $_POST['id'];
            $clientesModel = new cliente();
            if ($clientesModel->eliminar_l($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el Cliente']);
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        exit;
    }
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