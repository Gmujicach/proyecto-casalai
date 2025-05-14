<?php
ob_start();
require_once 'Modelo/cuentas.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'registrar':
            $cuentabanco = new Cuentabanco();
            $cuentabanco->setNombreBanco($_POST['nombre_banco']);
            $cuentabanco->setNumeroCuenta($_POST['numero_cuenta']);
            $cuentabanco->setRifCuenta($_POST['rif_cuenta']);
            $cuentabanco->setTelefonoCuenta($_POST['telefono_cuenta']);
            $cuentabanco->setCorreoCuenta($_POST['correo_cuenta']);

            if ($cuentabanco->registrarCuentabanco()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al registrar la cuenta']);
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
            break;
        
        case 'consultar_cuentas':
            $cuentabanco = new Cuentabanco();
            $cuentas_obt = $cuentabanco->consultarCuentabanco();

            echo json_encode($cuentas_obt);
            exit;

        case 'modificar':
            $id_cuenta = $_POST['id_cuenta'];
            $cuentabanco = new Cuentabanco();
            $cuentabanco->setIdCuenta($id_cuenta);
            $cuentabanco->setNombreBanco($_POST['nombre_banco']);
            $cuentabanco->setNumeroCuenta($_POST['numero_cuenta']);
            $cuentabanco->setRifCuenta($_POST['rif_cuenta']);
            $cuentabanco->setTelefonoCuenta($_POST['telefono_cuenta']);
            $cuentabanco->setCorreoCuenta($_POST['correo_cuenta']);
            
            if ($cuentabanco->modificarCuentabanco($id_cuenta)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar la cuenta']);
            }
            break;

        case 'eliminar':
            $id_cuenta = $_POST['id_cuenta'];
            $cuentabanco = new Cuentabanco();

            if ($cuentabanco->eliminarCuentabanco($id_cuenta)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la cuenta']);
            }
            exit;

        case 'cambiar_estado':
            $id_cuenta = $_POST['id_cuenta'];
            $nuevoEstado = $_POST['estado'];
            
            if (!in_array($nuevoEstado, ['Habilitado', 'Inhabilitado'])) {
                echo json_encode(['status' => 'error', 'message' => 'Estado no válido']);
                exit;
            }
            
            $cuentabanco = new Cuentabanco();
            $cuentabanco->setId($id_cuenta);
            
            if ($cuentabanco->estadoCuenta($nuevoEstado)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estado']);
            }
            break;

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

    $cunetabancos = consultarCuentabanco();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();
?>