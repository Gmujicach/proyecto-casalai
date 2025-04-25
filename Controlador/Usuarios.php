<?php
ob_start();

require_once 'Modelo/Usuarios.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'ingresar':
            $usuario = new Usuarios();
            $usuario->setUsername($_POST['nombre_usuario']);
            $usuario->setClave($_POST['clave_usuario']);
            
            if (!$usuario->validarUsuario()) {
                echo json_encode(['status' => 'error', 'message' => 'Este Usuario ya existe']);
            }
            else {
                if ($usuario->ingresarUsuario()) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar el Usuario']);
                }
            }
            break;

        case 'obtener_usuario':
            $id = $_POST['id_usuario'];
            if ($id !== null) {
                $usuario = new Usuarios();
                $usuario = $usuario->obtenerUsuarioPorId($id);
                if ($usuario !== null) {
                    echo json_encode($usuario);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID del Usuario no proporcionado']);
            }
            break;

        case 'modificar':
            $id = $_POST['id_usuario'];
            $usuario = new Usuarios();
            $usuario->setId($id);
            $usuario->setUsername($_POST['nombre_usuario']);
            $usuario->setClave($_POST['clave_usuario']);
            $usuario->setRango($_POST['rango']);
            
            if ($usuario->modificarUsuario($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el Usuario']);
            }
            break;

        case 'eliminar':
            $id = $_POST['id'];
            $usuarioModel = new Usuarios();
            if ($usuarioModel->eliminarUsuario($id)) {
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



function getusuarios() {
    $usuario = new Usuarios();
    return $usuario->getusuarios();
}

$pagina = "Usuarios";
if (is_file("Vista/" . $pagina . ".php")) {

    $usuarios = getusuarios();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>