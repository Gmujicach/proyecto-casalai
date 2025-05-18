<?php
ob_start();
require_once 'Modelo/PasareladePago.php';
require_once 'Modelo/cuentas.php';
require_once 'Modelo/Factura.php';

// Si se recibe una acción (AJAX), procesarla primero
if (!empty($_POST['accion'])) {
    header('Content-Type: application/json'); // Asegura tipo JSON

    $accion = $_POST['accion'];

    switch ($accion) {
        case 'ingresar':
            $pasarela = new PasareladePago();
            $pasarela->setCuenta($_POST['cuenta']);
            $pasarela->setReferencia($_POST['referencia']);
            $pasarela->setFecha($_POST['fecha']);
            $pasarela->setTipo($_POST['tipo']);
            $pasarela->setFactura($_POST['id_factura']);
            $pasarela->setObservaciones('');

            if (!$pasarela->validarCodigoReferencia()) {
                echo json_encode(['status' => 'error', 'message' => 'Este Código Interno ya existe']);
            } else {
                if ($pasarela->pasarelaTransaccion('Ingresar')) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al ingresar el producto']);
                }
            }
            exit;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            exit;
    }
}


// Código para cargar datos si se accede a la vista normalmente
if (isset($_POST['id_factura'])) {
    $idFactura = $_POST['id_factura'];
    $facturaModel = new Factura();
    $cuentaModel = new Cuentabanco();
    $listadocuentas = $cuentaModel->consultarCuentabanco();
    $monto = $facturaModel->obtenerMontoTotalFactura($idFactura);

    // Cargar vista solo si no es AJAX
    $pagina = "PasareladePago";
    if (is_file("Vista/" . $pagina . ".php")) {
        require_once("Vista/" . $pagina . ".php");
    } else {
        echo "Página en construcción";
    }
} else {
    // 🔁 Si no viene con POST id_factura (por ejemplo al retroceder), redirigir
    header("Location: ?pagina=GestionarFactura");
    exit;
}

ob_end_flush();
?>
