<?php
ob_start();
require_once 'Modelo/conciliacion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    } else {
        $accion = '';
    }

    switch ($accion) {
        case 'registrar':
            $conciliacion = new Conciliacion();
            $conciliacion->setNombreBanco($_POST['nombre_banco']);
            $conciliacion->setNumeroCuenta($_POST['numero_cuenta']);
            $conciliacion->setRifCuenta($_POST['rif_cuenta']);
            $conciliacion->setTelefonoCuenta($_POST['telefono_cuenta']);
            $conciliacion->setCorreoCuenta($_POST['correo_cuenta']);

            if ($conciliacion->registrarConciliacion()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al registrar la cuenta']);
            }
            exit;
        
        case 'obtener_cuenta':
            $id_cuenta = $_POST['id_cuenta'];

            if ($id_cuenta !== null) {
                $conciliacion = new Conciliacion();
                $cuenta = $conciliacion->obtenerCuentaPorId($id_cuenta);

                if ($cuenta !== null) {
                    echo json_encode($cuenta);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Cuenta no encontrado']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de cuenta no proporcionado']);
            }
            break;
        
        case 'consultar_cuentas':
            $conciliacion = new Conciliacion();
            $cuentas = $conciliacion->consultarConciliacion();
            //var_dump($cuentas);
            echo json_encode($cuentas);
            exit;

        case 'modificar':
            $id_cuenta = $_POST['id_cuenta'];
            $conciliacion = new Conciliacion();
            $conciliacion->setIdCuenta($id_cuenta); // Establecer el ID de la cuenta
            $conciliacion->setNombreBanco($_POST['nombre_banco']);
            $conciliacion->setNumeroCuenta($_POST['numero_cuenta']);
            $conciliacion->setRifCuenta($_POST['rif_cuenta']);
            $conciliacion->setTelefonoCuenta($_POST['telefono_cuenta']);
            $conciliacion->setCorreoCuenta($_POST['correo_cuenta']);
            
            if ($conciliacion->modificarConciliacion($id_cuenta)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar la cuenta']);
            }
            break;

        case 'eliminar':
            $id_cuenta = $_POST['id_cuenta'];
            $conciliacion = new Conciliacion();

            if ($conciliacion->eliminarConciliacion($id_cuenta)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la cuenta']);
            }
            exit;

        case 'cambiar_estado':
            $id_cuenta = $_POST['id_cuenta'];
            $conciliacion = new Conciliacion();

            if ($conciliacion->estadoCuenta($id_cuenta)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estado de la cuenta']);
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
        exit;
    }
}

$pagina = "conciliacion";
if (is_file("Vista/" . $pagina . ".php")) {
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "La página no existe"; // Mensaje si la vista no existe
}

ob_end_flush();
?>