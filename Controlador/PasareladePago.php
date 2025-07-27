<?php
ob_start();
require_once 'modelo/pasareladepago.php';
require_once 'modelo/cuenta.php';
require_once 'modelo/factura.php';

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
                $comprobante = null;
    if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] == 0) {
        $directorio = "img/pagos/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }
        $nombre_original = $_FILES['comprobante']['name'];
        $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
        $nombre_nuevo = "comprobante_" . time() . "_" . rand(1000,9999) . "." . $extension;
        $ruta_destino = $directorio . $nombre_nuevo;

        if (move_uploaded_file($_FILES['comprobante']['tmp_name'], $ruta_destino)) {
            $comprobante = $ruta_destino;
        }}
            $pasarela->setComprobante($comprobante);
            
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
    $pagina = "pasareladepago";
    if (is_file("vista/" . $pagina . ".php")) {
        require_once("vista/" . $pagina . ".php");
    } else {
        echo "Página en construcción";
    }
} else {
    // 🔁 Si no viene con POST id_factura (por ejemplo al retroceder), redirigir
    header("Location: ?pagina=gestionarfactura");
    exit;
}

ob_end_flush();
?>
