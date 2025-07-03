<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'Modelo/Usuarios.php';
require_once 'Modelo/Permisos.php';
require_once 'Modelo/Bitacora.php';
$id_rol = $_SESSION['id_rol']; // Asegúrate de tener este dato en sesión

// Definir constantes para IDs de módulo
define('MODULO_USUARIO', 1);

$permisosObj = new Permisos();
$bitacoraModel = new Bitacora();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('usuario'));


// Registrar acceso al módulo
if (isset($_SESSION['id_usuario'])) {
    $bitacoraModel->registrarAccion('Acceso al módulo de usuario', MODULO_USUARIO, $_SESSION['id_usuario']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'permisos_tiempo_real':
    header('Content-Type: application/json; charset=utf-8');
    $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('usuario'));
    echo json_encode($permisosActualizados);
    exit;
        case 'registrar':
            $usuario = new Usuarios();
            $usuario->setUsername($_POST['nombre_usuario']);
            $usuario->setClave($_POST['clave_usuario']);
            $usuario->setNombre($_POST['nombre']);
            $usuario->setApellido($_POST['apellido_usuario']);
            $usuario->setCorreo($_POST['correo_usuario']);
            $usuario->setTelefono($_POST['telefono_usuario']);
            $usuario->setRango($_POST['rango']);

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
                    'usuario' => $usuarioRegistrada
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
    // Obtener el usuario actualizado con el nombre del rol
    $usuarioActualizado = $usuario->obtenerUsuarioPorId($id_usuario);
    // Si tu método obtenerUsuarioPorId no hace el JOIN con tbl_rol, cámbialo para que lo haga
    echo json_encode([
        'status' => 'success',
        'usuario' => $usuarioActualizado
    ]);
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
$usuarioModel = new Usuarios();
$reporteRoles = $usuarioModel->obtenerReporteRoles();
$totalRoles = array_sum(array_column($reporteRoles, 'cantidad'));
foreach ($reporteRoles as &$rol) {
    $rol['porcentaje'] = $totalRoles > 0 ? round(($rol['cantidad'] / $totalRoles) * 100, 2) : 0;
}
unset($rol);

$pagina = "Usuarios";
if (is_file("Vista/" . $pagina . ".php")) {

    $usuarios = getusuarios();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>