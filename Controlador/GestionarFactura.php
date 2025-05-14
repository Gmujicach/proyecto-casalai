<?php

if (!is_file("modelo/Factura.php")) {
    echo "Falta definir la clase Factura";
    exit;
}

require_once("modelo/Factura.php");

if (is_file("vista/GestionarFactura.php")) {
    $factura = new Factura();
    


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtiene la acción enviada en la solicitud POST
        if (isset($_POST['accion'])) {
            $accion = $_POST['accion'];
        } else {
            $accion = 'consultar';
        }

        switch ($accion) {

            case 'registrar':
                // Llamada al método para registrar una factura
                $factura->setFecha($_POST['fecha']);
                $factura->setCliente($_POST['cliente']);
                $factura->setDescuento($_POST['descuento']);
                $factura->setEstatus($_POST['estatus']);
                $factura->setIdProducto($_POST['id_producto']);
                $factura->setCantidad($_POST['cantidad']);
                
                $respuesta = $factura->facturaTransaccion('Ingresar');
                echo json_encode($respuesta);
                break;


            case 'cancelar':
                // Cancelar factura por ID
                $factura->setId($_POST['id_factura']);
                if ($factura->facturaTransaccion('Cancelar')) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al modificar el Usuario']);
                }
                break;

            case 'procesar':
                // Procesar factura por ID
                $factura->setId($_POST['id_factura']);
                $respuesta = $factura->facturaTransaccion('Procesar');
                echo json_encode($respuesta);
                break;

            default:
            $respuesta = $factura->facturaTransaccion('Consultar');
            echo json_encode($respuesta);
                break;
        }
        exit;
    }

    require_once("vista/GestionarFactura.php");

} else {
    echo "Página en construcción";
}

?>