<?php
// Inicia el almacenamiento en búfer de salida
ob_start();

// Importa los modelos necesarios
require_once 'Modelo/Factura.php';

// Define los datos de la factura
$cliente = 3;
$fecha_hora = date("Y-m-d H:i:s");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["detalle_factura"])) {
        $detalle_factura = json_decode($_POST["detalle_factura"], true);

        if ($detalle_factura === null) {
            echo "Error: JSON inválido recibido.";
            exit;
        }

        $subtotal = 0;
        $productos = [];

        foreach ($detalle_factura as $detalles) {
            $producto = [
                "id_producto" => $detalles["id"], 
                "cantidad" => $detalles["cantidad"], 
                "precio" => $detalles["precio"],
            ];

            $subtotal += (float) $detalles["subtotal"];
            array_push($productos, $producto);
        }

    } else {
      //  echo "No se recibieron productos.";
    }
} else {
   // echo "Acceso denegado.";
}


// Calcular el subtotal correctamente



$factura = new Producto();

$res = $factura->ingresarFactura($cliente, $fecha_hora, $productos, $subtotal);

$res = $factura->consultarFacturaReciente();


// Asigna el nombre de la página
$pagina = "descargarFactura";

// Verifica si el archivo de vista existe
if (is_file("Vista/" . $pagina . ".php")) {
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

// Termina el almacenamiento en búfer de salida y envía la salida al navegador
ob_end_flush();
?>
