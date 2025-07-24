<?php

if (!is_file("modelo/factura.php")) {
    echo "Falta definir la clase Factura";
    exit;
}

require_once("modelo/factura.php");

if (is_file("vista/gestionarfactura.php")) {
    $factura = new Factura();
    
    if (isset($_POST['descargarFactura'])) {
    $id_factura = $_POST['descargarFactura'];
    $factura->setId($id_factura);
    $res = $factura->facturaTransaccion('DescargarFactura');
    require_once("vista/descargarfactura.php");
    exit; // para evitar que se ejecute el resto
}

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

            default:
            // Consultar facturas  
            if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Almacenista') {
              $respuesta = $factura->facturaTransaccion('ConsultarTodas');
            echo json_encode($respuesta);  
            }else {
            $factura->setCedula($_SESSION['cedula']); // Asegurarse de que cedula esté definida
            $respuesta = $factura->facturaTransaccion('Consultar');
            echo json_encode($respuesta);
            };

                break;
        }
        exit;
    }

    

    require_once("vista/gestionarfactura.php");

} else {
    echo "Página en construcción";
}

?>