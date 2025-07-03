<?php
ob_start();
require_once 'Modelo/PasareladePago.php';
require_once 'Modelo/cuentas.php';
require_once 'Modelo/Factura.php';
require_once 'Modelo/Permisos.php';
require_once 'Modelo/Bitacora.php';
define('MODULO_PASARELA_PAGOS', 16); // Define el ID

$id_rol = $_SESSION['id_rol'];

if (isset($_SESSION['id_usuario'])) {
    $bitacoraModel->registrarAccion('Acceso al módulo de Pasarela de pagos', MODULO_PASARELA_PAGOS, $_SESSION['id_usuario']);
}

$permisosObj = new Permisos();
$permisosUsuario = $permisosObj->getPermisosUsuarioModulo($id_rol, 'Pasarela de pagos');

$pasarela = new PasareladePago();
$cuentaModel = new Cuentabanco();
$listadocuentas = $cuentaModel->consultarCuentabanco();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';

    switch ($accion) {
        case 'permisos_tiempo_real':
            header('Content-Type: application/json; charset=utf-8');
            $permisosActualizados = $permisosObj->getPermisosUsuarioModulo($id_rol, 'Pasarela de pagos');
            echo json_encode($permisosActualizados);
            exit;
            case 'ingresar':
                // Crear una nueva instancia del modelo Productos
                $pasarela = new PasareladePago();
                $cuenta = $_POST['cuenta'];
                $referencia = $_POST['referencia'];
                $fecha = $_POST['fecha'];
                $tipo = $_POST['tipo'];
                $factura = $_POST['id_factura'];
                $pasarela->setCuenta($cuenta);
                $pasarela->setReferencia($referencia);
                $pasarela->setFecha($fecha);
                $pasarela->setTipo($tipo);
                $pasarela->setFactura($factura);
                $pasarela->setObservaciones('');
                
                // Validación del nombre del producto

                // Validación del código interno del producto
                if (!$pasarela->validarCodigoReferencia()) {
                    echo json_encode(['status' => 'error', 'message' => 'Este Código Interno ya existe']);
                }
                // Si ambas validaciones pasan, se intenta ingresar el producto
                else {
                    if ($pasarela->pasarelaTransaccion('Ingresar')) {
                         $bitacoraModel->registrarAccion('Registro de referencia bancaria: ' . $pasarela['referencia'], MODULO_PASARELA_PAGOS, $_SESSION['id_usuario']);
                        echo json_encode(['status' => 'success']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error al ingresar el producto']);
                    }
                }
                break;
    
            case 'modificar':
    error_log("Acción recibida: " . $accion);

    $id = $_POST['id_detalles'];
    $pasarela->setIdDetalles($id);
    $pasarela->setReferencia($_POST['referencia']);
    $pasarela->setFecha($_POST['fecha']);
    $pasarela->setTipo($_POST['tipo']);
    $pasarela->setFactura($_POST['id_factura']);
    $pasarela->setCuenta($_POST['cuenta']);

    if ($pasarela->pasarelaTransaccion('Modificar')) {
        $pagoActualizado = $pasarela->obtenerPagoPorId($id);
        $bitacoraModel->registrarAccion('Modificación de referencia bancaria: ' . $pagoActualizado['referencia'], MODULO_PASARELA_PAGOS, $_SESSION['id_usuario']);
        echo json_encode(['status' => 'success', 'pago' => $pagoActualizado]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al modificar el producto']);
    }
    break;
    

                        // Cambiar estatus
        case 'modificar_estado':
    error_log("Acción recibida: " . $accion);
    $id = $_POST['id_detalles'];
    $nuevoEstatus = $_POST['estatus'];
    $observaciones = $_POST['observaciones'];
    $factura = $_POST['id_factura'];
    $pasarela->setIdDetalles($id);
    $pasarela->setObservaciones($observaciones);
    $pasarela->setEstatus($nuevoEstatus);
    $pasarela->setFactura($factura);

    if ($pasarela->pasarelaTransaccion('Procesar')) {
        $pagoActualizado = $pasarela->obtenerPagoPorId($id);
        $bitacoraModel->registrarAccion('Cambio de estatus de referencia bancaria: ' . $pagoActualizado['referencia'], MODULO_PASARELA_PAGOS, $_SESSION['id_usuario']);
        echo json_encode(['status' => 'success', 'pago' => $pagoActualizado]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estatus']);
    }
    break;
            case 'eliminar':
                $pasarela = new PasareladePago();
                $id = $_POST['id_detalles'];
                $pasarela->setIdDetalles($id);
                if ($pasarela->pasarelaTransaccion('Eliminar')) {
                    $pagoEliminado = $pasarela->obtenerPagoPorId($id);
                    $bitacoraModel->registrarAccion('Eliminación de referencia bancaria: ' . $pagoEliminado['referencia'], MODULO_PASARELA_PAGOS, $_SESSION['id_usuario']);
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto']);
                }
                break;
    
            default:
                // Respuesta de error si la acción no es válida
                echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
                break;
        }
        // Termina el script para evitar seguir procesando código innecesario
        exit;
    }




$datos = $pasarela->pasarelaTransaccion('Consultar');


$pagina = "pasarela";
if (is_file("Vista/" . $pagina . ".php")) {
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();?>