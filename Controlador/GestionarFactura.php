<?php

if (!is_file("modelo/Factura.php")) {
    echo "Falta definir la clase Factura";
    exit;
}

require_once("modelo/Factura.php");

if (is_file("vista/GestionarFactura.php")) {
    $factura = new Factura();
    
    // Consultar todas las facturas al cargar la página
    $respuestaFacturas = $factura->facturaTransaccion('Consultar');

    if (!empty($_POST)) {
        $accion = 'consultar';

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

            case 'consultar':
                // Consultar factura por ID
                $factura->setId(1);
                $respuesta = $factura->facturaTransaccion('Consultar');
                echo json_encode($respuesta);
                break;

            case 'cancelar':
                // Cancelar factura por ID
                $factura->setId($_POST['id']);
                $respuesta = $factura->facturaTransaccion('Cancelar');
                echo json_encode($respuesta);
                break;

            case 'procesar':
                // Procesar factura por ID
                $factura->setId($_POST['id']);
                $respuesta = $factura->facturaTransaccion('Procesar');
                echo json_encode($respuesta);
                break;

            default:
                echo json_encode(['error' => 'Acción no válida']);
                break;
        }
        exit;
    }

    require_once("vista/GestionarFactura.php");

} else {
    echo "Página en construcción";
}

?>
