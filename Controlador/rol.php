<?php
ob_start();
require_once 'Modelo/rol.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'registrar':
            $rol = new Rol();
            $rol->setNombreRol($_POST['nombre_rol']);

            if ($rol->registrarRol()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al registrar el rol']);
            }
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
            break;
        
        case 'consultar_cuentas':
            $rol = new Rol();
            $roles_obt = $rol->consultarRoles();

            echo json_encode($roles_obt);
            exit;

        case 'modificar':
            $id_rol = $_POST['id_rol'];
            $rol = new Rol();
            $rol->setIdRol($id_rol); // Establecer el ID de la rol
            $rol->setNombreRol($_POST['nombre_rol']);
            
            if ($rol->modificarRol($id_rol)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el rol']);
            }
            break;

        case 'eliminar':
            $id_rol = $_POST['id_rol'];
            $rol = new Rol();

            if ($rol->eliminarRol($id_rol)) {
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

$pagina = "rol";
if (is_file("Vista/" . $pagina . ".php")) {
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "La página no existe"; // Mensaje si la vista no existe
}

ob_end_flush();
?>