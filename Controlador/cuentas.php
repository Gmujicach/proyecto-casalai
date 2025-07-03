<?php
ob_start();
require_once 'Modelo/cuentas.php';
require_once 'Modelo/Permisos.php';
require_once 'Modelo/Bitacora.php';

$id_rol = $_SESSION['id_rol'];

define('MODULO_CUENTA_BANCARIA', 1);
define('ACCION_CREAR', 1);
define('ACCION_LEER', 2);
define('ACCION_ACTUALIZAR', 3);
define('ACCION_ELIMINAR', 4);
define('ACCION_CAMBIAR_ESTATUS', 5);

$permisosObj = new Permisos();
$bitacoraModel = new Bitacora();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('Cuentas bancarias'));

if (isset($_SESSION['id_usuario'])) {
    $bitacoraModel->registrarAccion('Acceso al módulo de cuentas bancarias', MODULO_CUENTA_BANCARIA, $_SESSION['id_usuario']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario_accion = $_SESSION['id_usuario'] ?? null;
    
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        
        case 'permisos_tiempo_real':
            header('Content-Type: application/json; charset=utf-8');
            $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, strtolower('Cuentas bancarias'));
            echo json_encode($permisosActualizados);
            exit;
        case 'registrar':
            header('Content-Type: application/json; charset=utf-8');
            $cuentabanco = new Cuentabanco();
            $cuentabanco->setNombreBanco($_POST['nombre_banco']);
            $cuentabanco->setNumeroCuenta($_POST['numero_cuenta']);
            $cuentabanco->setRifCuenta($_POST['rif_cuenta']);
            $cuentabanco->setTelefonoCuenta($_POST['telefono_cuenta']);
            $cuentabanco->setCorreoCuenta($_POST['correo_cuenta']);

            if ($cuentabanco->existeNumeroCuenta($_POST['numero_cuenta'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El número de cuenta ya existe'
                ]);
                exit;
            }

            if ($cuentabanco->registrarCuentabanco()) {
                $cuentaRegistrada = $cuentabanco->obtenerUltimaCuenta();

                $bitacoraModel->registrarAccion(
                    'Creación de cuenta bancaria: ' . $_POST['nombre_banco'], 
                    MODULO_CUENTA_BANCARIA, 
                    $id_usuario_accion,
                    ACCION_CREAR,
                    $cuentaRegistrada['id_usuario']
                );

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Cuenta registrada correctamente',
                    'cuenta' => $cuentaRegistrada
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al registrar la cuenta'
                ]);
            }
            exit;
        
        case 'obtener_cuenta':
            $id_cuenta = $_POST['id_cuenta'];

            if ($id_cuenta !== null) {
                $cuentabanco = new Cuentabanco();
                $cuenta_obt = $cuentabanco->obtenerCuentaPorId($id_cuenta);

                if ($cuenta_obt !== null) {
                    echo json_encode($cuenta);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Cuenta no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de cuenta no proporcionado']);
            }
            exit;
        
        case 'consultar_cuentas':
            $cuentabanco = new Cuentabanco();
            $cuentas_obt = $cuentabanco->consultarCuentabanco();

            echo json_encode($cuentas_obt);
            exit;

        case 'modificar':
            ob_clean();
            header('Content-Type: application/json; charset=utf-8');
            $id_cuenta = $_POST['id_cuenta'];
            $cuentabanco = new Cuentabanco();
            $cuentabanco->setIdCuenta($id_cuenta);
            $cuentabanco->setNombreBanco($_POST['nombre_banco']);
            $cuentabanco->setNumeroCuenta($_POST['numero_cuenta']);
            $cuentabanco->setRifCuenta($_POST['rif_cuenta']);
            $cuentabanco->setTelefonoCuenta($_POST['telefono_cuenta']);
            $cuentabanco->setCorreoCuenta($_POST['correo_cuenta']);

            if ($cuentabanco->existeNumeroCuenta($_POST['numero_cuenta'], $id_cuenta)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'El número de cuenta ya existe'
                ]);
                exit;
            }

            if ($cuentabanco->modificarCuentabanco($id_cuenta)) {
                $cuentabancoActualizada = $cuentabanco->obtenerCuentaPorId($id_cuenta);

                $bitacoraModel->registrarAccion(
                    'Actualización de cuenta bancaria: ' . $_POST['nombre_banco'], 
                    MODULO_CUENTA_BANCARIA, 
                    $id_usuario_accion,
                    ACCION_CREAR,
                    $cuentabancoActualizada['id_usuario']
                );

                echo json_encode([
                    'status' => 'success',
                    'cuenta' => $cuentabancoActualizada
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar la cuenta']);
            }
            exit;

        case 'eliminar':
            $id_cuenta = $_POST['id_cuenta'];
            $cuentabanco = new Cuentabanco();

            if ($cuentabanco->eliminarCuentabanco($id_cuenta)) {

                $bitacoraModel->registrarAccion(
                    'Eliminación de cuenta: ' . $cuentabanco['nombre_banco'], 
                    MODULO_CUENTA_BANCARIA, 
                    $id_usuario_accion,
                    ACCION_ELIMINAR,
                    $id_cuenta
                );

                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la cuenta']);
            }
            exit;

        case 'cambiar_estado':
            $id_cuenta = $_POST['id_cuenta'];
            $nuevoEstado = $_POST['estado'];
            
            if (!in_array($nuevoEstado, ['habilitado', 'inhabilitado'])) {
                echo json_encode(['status' => 'error', 'message' => 'Estado no válido']);
                exit;
            }
            
            $cuentabanco = new Cuentabanco();
            $cuentabanco->setIdCuenta($id_cuenta);
            
            if ($cuentabanco->cambiarEstado($nuevoEstado)) {

                $bitacoraModel->registrarAccion(
                    'Cambio de estatus a ' . $nuevoEstado . ' para cuenta: ' . $id_cuenta, 
                    MODULO_CUENTA_BANCARIA, 
                    $id_usuario_accion,
                    ACCION_CAMBIAR_ESTATUS,
                    $id_cuenta
                );

                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estado']);
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        exit;
    }
}

function consultarCuentabanco() {
    $cuentabanco = new Cuentabanco();
    return $cuentabanco->consultarCuentabanco();
}

$pagina = "cuentas";
if (is_file("Vista/" . $pagina . ".php")) {

    $cuentabancos = consultarCuentabanco();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>