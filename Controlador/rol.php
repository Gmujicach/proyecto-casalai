<?php
ob_start();
require_once 'Modelo/rol.php';
require_once 'Modelo/Permisos.php';
require_once 'Modelo/Bitacora.php';
define('MODULO_ROLES', 18); // Define el ID del módulo de roles

$id_rol = $_SESSION['id_rol'];

$permisosObj = new Permisos();
$bitacoraModel = new Bitacora();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, 'Roles');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
                case 'permisos_tiempo_real':
            header('Content-Type: application/json; charset=utf-8');
            $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, 'Roles');
            echo json_encode($permisosActualizados);
            exit;
        case 'registrar':
            $rol = new Rol();
            $rol->setNombreRol($_POST['nombre_rol']);

            if ($rol->existeNombreRol($_POST['nombre_rol'])) {

                

                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre del rol ya existe'
                ]);
                exit;
            }

            if ($rol->registrarRol()) {
                $rolRegistrado = $rol->obtenerUltimoRol();
                $bitacoraModel->registrarAccion('Registro de rol: ' . $_POST['nombre_rol'],
                MODULO_ROLES, $_SESSION['id_usuario']);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Rol registrado correctamente',
                    'rol' => $rolRegistrado
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al registrar el rol'
                ]);
            }
            exit;
        
        case 'consultar_roles':
            $rol = new Rol();
            $roles_obt = $rol->consultarRoles();

            echo json_encode($roles_obt);
            exit;
        
        case 'obtener_rol':
            $id_rol = $_POST['id_rol'];

            if ($id_rol !== null) {
                $rol = new Rol();
                $rol_obt = $rol->obtenerRolPorId($id_rol);

                if ($rol_obt !== null) {
                    echo json_encode($rol_obt);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Rol no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de rol no proporcionado']);
            }
            exit;

        case 'modificar':
            $id_rol  = $_POST['id_rol'];
            $rol = new Rol();
            $rol->setIdRol($id_rol);
            $rol->setNombreRol($_POST['nombre_rol']);
            
            if ($rol->existeNombreRol($_POST['nombre_rol'], $id_rol)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El nombre del rol ya existe'
                ]);
                exit;
            }
            
            if ($rol->modificarRol($id_rol)) {
                $rolActualizado = $rol->obtenerRolPorId($id_rol);
                $bitacoraModel->registrarAccion('Modificación de rol: ' . $_POST['nombre_rol'],
                MODULO_ROLES, $_SESSION['id_usuario']);

                echo json_encode([
                    'status' => 'success',
                    'rol' => $rolActualizado
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el rol']);
            }
            exit;

        case 'eliminar':
            $id_rol = $_POST['id_rol'];
            $rol = new Rol();

            if ($rol->eliminarRol($id_rol)) {
                $rolEliminado = $rol->obtenerRolPorId($id_rol);
                $bitacoraModel->registrarAccion('Eliminación de rol: (ID: ' . $id_rol . ')',
                MODULO_ROLES, $_SESSION['id_usuario']);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el rol']);
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        exit;
    }
}

function consultarRoles() {
    $rol = new Rol();
    return $rol->consultarRoles();
}

$pagina = "rol";
if (is_file("Vista/" . $pagina . ".php")) {
    if (isset($_SESSION['id_usuario'])) {
    $bitacoraModel->registrarAccion('Acceso al módulo de Roles', MODULO_ROLES, $_SESSION['id_usuario']);
}
    $roles = consultarRoles();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>