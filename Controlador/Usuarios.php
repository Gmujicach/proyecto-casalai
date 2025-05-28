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
        case 'registrar':
            $usuario = new Usuarios();
            $usuario->setUsername($_POST['nombre_usuario']);
            $usuario->setClave($_POST['clave_usuario']);
            $usuario->setNombre($_POST['nombre']);
            $usuario->setApellido($_POST['apellido_usuario']);
            $usuario->setCorreo($_POST['correo_usuario']);
            $usuario->setTelefono($_POST['telefono_usuario']);

            if ($usuario->existeUsuario($_POST['nombre_usuario'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre de usuario ya existe'
                ]);
                exit;
            }

            if ($usuario->ingresarUsuario()) {
                $usuarioRegistrada = $usuario->obtenerUltimoUsuario();
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Usuario registrada correctamente',
                    'marca' => $usuarioRegistrada
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al registrar el usuario'
                ]);
            }
            exit;

        case 'obtener_usuario':
            $id_usuario = $_POST['id_usuario'];
            if ($id_usuario !== null) {
                $usuario = new Usuarios();
                $usuario = $usuario->obtenerUsuarioPorId($id_usuario);
                if ($usuario !== null) {
                    echo json_encode($usuario);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID del Usuario no proporcionado']);
            }
            exit;

case 'modificar':
    $id_usuario = $_POST['id_usuario'];
    $usuario = new Usuarios();
    $usuario->setId($id_usuario);
    $usuario->setUsername($_POST['nombre_usuario']);
    $usuario->setClave($_POST['clave_usuario']);
    $usuario->setNombre($_POST['nombre']);
    $usuario->setApellido($_POST['apellido_usuario']);
    $usuario->setCorreo($_POST['correo_usuario']);
    $usuario->setTelefono($_POST['telefono_usuario']);
    $usuario->setRango($_POST['rango']);
    
    // CORRIGE ESTA LÍNEA:
    if ($usuario->existeUsuario($_POST['nombre_usuario'], $id_usuario)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'El nombre de usuario ya existe'
        ]);
        exit;
    }

    if ($usuario->modificarUsuario($id_usuario)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al modificar el Usuario']);
    }
    exit;

        case 'eliminar':
            $id_usuario = $_POST['id_usuario'];
            $usuarioModel = new Usuarios();
            if ($usuarioModel->eliminarUsuario($id_usuario)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto']);
            }
            exit;

        // Cambiar estatus
        case 'cambiar_estatus':
            $id_usuario = $_POST['id_usuario'];
            $nuevoEstatus = $_POST['nuevo_estatus'];
            
            // Validación básica
            if (!in_array($nuevoEstatus, ['habilitado', 'inhabilitado'])) {
                echo json_encode(['status' => 'error', 'message' => 'Estatus no válido']);
                exit;
            }
            
            $usuario = new Usuarios();
            $usuario->setId($id_usuario);
            
            if ($usuario->cambiarEstatus($nuevoEstatus)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estatus']);
            }
            exit;
        
        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida'. $accion.'']);
        exit;
    }
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