<?php
ob_start();
require_once 'Modelo/PasareladePago.php';
require_once 'Modelo/cuentas.php';
require_once 'Modelo/Factura.php';


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
                /* Obtiene el ID del producto y asigna los valores del formulario a las propiedades del producto
                $id = $_POST['id_producto'];
                $Producto = new Productos();
                $Producto->setId($id);
                $Producto->setNombreP($_POST['nombre_producto']);
                $Producto->setDescripcionP($_POST['descripcion_producto']);
                $Producto->setIdModelo($_POST['Modelo']);
                $Producto->setStockActual($_POST['Stock_Actual']);
                $Producto->setStockMax($_POST['Stock_Maximo']);
                $Producto->setStockMin($_POST['Stock_Minimo']);
                $Producto->setClausulaDeGarantia($_POST['Clausula_garantia']);
                $Producto->setCodigo($_POST['Seriales']);
                $Producto->setCategoria($_POST['Categoria']);
                $Producto->setPrecio($_POST['Precio']);
                
                // Intento de modificar el producto y devuelve una respuesta en formato JSON
                if ($Producto->modificarProducto($id)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al modificar el producto']);
                }*/
                break;
    
            case 'eliminar':
                /* Obtiene el ID del producto y llama al método para eliminarlo
                $id = $_POST['id'];
                $productoModel = new Productos();
                if ($productoModel->eliminarProducto($id)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto']);
                }*/
                break;
    
            default:
                // Respuesta de error si la acción no es válida
                echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
                break;
        }
        // Termina el script para evitar seguir procesando código innecesario
        exit;
    }






$pagina = "pasarela";
if (is_file("Vista/" . $pagina . ".php")) {
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();?>