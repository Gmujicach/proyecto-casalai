<?php
ob_start();
require_once 'Modelo/PasareladePago.php';
require_once 'Modelo/cuentas.php';
require_once 'Modelo/Factura.php';

$pasarela = new PasareladePago();
$cuentaModel = new Cuentabanco();
$listadocuentas = $cuentaModel->consultarCuentabanco();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtiene la acción enviada en la solicitud POST
        if (isset($_POST['accion'])) {
            $accion = $_POST['accion'];
        } else {
            $accion = '';
        }



        // Switch para manejar diferentes acciones
        switch ($accion) {
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

                
                
                // Intento de modificar el producto y devuelve una respuesta en formato JSON
                if ($pasarela->pasarelaTransaccion('Modificar')) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al modificar el producto']);
                }
                break;
    

                        // Cambiar estatus
        case 'modificar_estado':
            error_log("Acción recibida: " . $accion);
            $id = $_POST['id_pago'];
            $nuevoEstatus = $_POST['estatus'];
            $observaciones = $_POST['observaciones'];
            
            $pasarela->setIdDetalles($id);
            $pasarela->setObservaciones($observaciones);
            $pasarela->setEstatus($nuevoEstatus);

            if ($pasarela->pasarelaTransaccion('Procesar')) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al cambiar el estatus']);
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