<?php
// Inicia el almacenamiento en búfer de salida
ob_start();

// Importa los modelos necesarios
require_once 'Modelo/Productos.php';
// Verifica si la solicitud se realizó mediante el método POST
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
    $Producto = new Productos();

    // Asignar valores generales del producto
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

    // Validación del nombre del producto
    if (!$Producto->validarNombreProducto()) {
        echo json_encode(['status' => 'error', 'message' => 'Este Producto ya existe']);
    }
    // Validación del código interno del producto
    elseif (!$Producto->validarCodigoProducto()) {
        echo json_encode(['status' => 'error', 'message' => 'Este Código Interno ya existe']);
    }
    // Si ambas validaciones pasan, se intenta ingresar el producto
    else {
        // Aquí pasamos todos los datos del formulario a ingresarProducto()
        $resultado = $Producto->ingresarProducto($_POST);

        if ($resultado) {
            echo json_encode(['status' => 'success', 'id_producto' => $resultado]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al ingresar el producto']);
        }
    }
    break;

        
        case 'obtener_producto':
            // Obtiene el ID del producto desde el formulario
            $id = $_POST['id_producto'];
            if ($id !== null) {
                // Crear una instancia del modelo Productos y obtener los detalles del producto
                $Producto = new Productos();
                $producto = $Producto->obtenerProductoPorId($id);
                // Respuesta JSON con los detalles del producto o un mensaje de error
                if ($producto !== null) {
                    echo json_encode($producto);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Producto no encontrado']);
                }
            } else {
                // Respuesta de error si no se proporciona ID del producto
                echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado']);
            }
            break;

case 'modificar':
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

    // Campos específicos por categoría
    $categoria = $_POST['Categoria'];

    switch ($categoria) {
        case '1': // IMPRESORA
            $Producto->setPeso($_POST['peso'] ?? null);
            $Producto->setAlto($_POST['alto'] ?? null);
            $Producto->setAncho($_POST['ancho'] ?? null);
            $Producto->setLargo($_POST['largo'] ?? null);
            break;

        case '2': // PROTECTOR DE VOLTAJE
            $Producto->setVoltajeEntrada($_POST['voltaje_entrada'] ?? null);
            $Producto->setVoltajeSalida($_POST['voltaje_salida'] ?? null);
            $Producto->setTomas($_POST['tomas'] ?? null);
            $Producto->setCapacidad($_POST['capacidad'] ?? null);
            break;

        case '3': // TINTA
            $Producto->setNumero($_POST['numero'] ?? null);
            $Producto->setColor($_POST['color'] ?? null);
            $Producto->setTipo($_POST['tipo'] ?? null);
            $Producto->setVolumen($_POST['volumen'] ?? null);
            break;

        case '4': // CARTUCHO DE TINTA
            $Producto->setNumero($_POST['numero'] ?? null);
            $Producto->setColor($_POST['color'] ?? null);
            $Producto->setCapacidad($_POST['capacidad'] ?? null);
            break;

        case '5': // OTROS
            $Producto->setDescripcionOtros($_POST['descripcion_otros'] ?? null);
            break;
    }

    // Guardar los cambios
    if ($Producto->modificarProducto($id)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al modificar el producto']);
    }
    break;


        case 'eliminar':
            $id_producto = $_POST['id_producto']; // Cambiado para coincidir con el nombre enviado
            if ($id_producto === null) {
                echo json_encode(['status' => 'error', 'message' => 'ID del Producto no proporcionado']);
                exit;
            }
            $producto = new Productos();
$response = $producto->eliminarProducto($id_producto);
if ($response['success']) {
    echo json_encode(['status' => 'success', 'message' => $response['message']]);
} else {
    echo json_encode(['status' => 'error', 'message' => $response['message']]);
}
            break;
            
            case 'cambiar_estatus':
            $id = $_POST['id_producto'];
            $nuevoEstatus = $_POST['nuevo_estatus'];
            
            // Validación básica
            if (!in_array($nuevoEstatus, ['habilitado', 'inhabilitado'])) {
                echo json_encode(['status' => 'error', 'message' => 'Estatus no válido']);
                exit;
            }
            
            $producto = new Productos();
            $producto->setId($id);
            
            if ($producto->cambiarEstatus($nuevoEstatus)) {
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

// Función para obtener modelos
function obtenerModelos() {
    $ModelosModel = new Productos();
    return $ModelosModel->obtenerModelos();
}

// Función para obtener productos
function obtenerProductos() {
    $producto = new Producto();
    return $producto->obtenerProductos();
}

// Asigna el nombre de la página
$pagina = "Productos";
// Verifica si el archivo de vista existe
if (is_file("Vista/" . $pagina . ".php")) {
    // Obtiene los modelos y productos
    $modelos = obtenerModelos();
    $productos = obtenerProductos();
    // Incluye el archivo de vista
    require_once("Vista/" . $pagina . ".php");
} else {
    // Muestra un mensaje si la página está en construcción
    echo "Página en construcción";
}

// Termina el almacenamiento en búfer de salida y envía la salida al navegador
ob_end_flush();