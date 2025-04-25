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
            // Asigna los valores del formulario a las propiedades del producto
            $Producto->setNombreP($_POST['Nombre_P']);
            $Producto->setDescripcionP($_POST['Descripcion_P']);
            $Producto->setIdModelo($_POST['Modelo']);
            $Producto->setStockActual($_POST['Stock_Actual']);
            $Producto->setStockMax($_POST['Stock_Maximo']);
            $Producto->setStockMin($_POST['Stock_Minimo']);
            $Producto->setPeso($_POST['Peso']);
            $Producto->setLargo($_POST['Largo']);
            $Producto->setAlto($_POST['Alto']);
            $Producto->setAncho($_POST['Ancho']);
            $Producto->setClausulaDeGarantia($_POST['Clausula_de_garantia']);
            $Producto->setServicio($_POST['Servicio']);
            $Producto->setCodigo($_POST['Codigo_Interno']);
            $Producto->setLlevaLote($_POST['Lote']);
            $Producto->setLlevaSerial($_POST['Seriales']);
            $Producto->setCategoria($_POST['Categoria']);
        
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
                if ($Producto->ingresarProducto()) {
                    echo json_encode(['status' => 'success']);
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
            // Obtiene el ID del producto y asigna los valores del formulario a las propiedades del producto
            $id = $_POST['id_producto'];
            $Producto = new Productos();
            $Producto->setId($id);
            $Producto->setNombreP($_POST['Nombre_P']);
            $Producto->setDescripcionP($_POST['Descripcion_P']);
            $Producto->setIdModelo($_POST['Modelo']);
            $Producto->setStockActual($_POST['Stock_Actual']);
            $Producto->setStockMax($_POST['Stock_Maximo']);
            $Producto->setStockMin($_POST['Stock_Minimo']);
            $Producto->setPeso($_POST['Peso']);
            $Producto->setLargo($_POST['Largo']);
            $Producto->setAlto($_POST['Alto']);
            $Producto->setAncho($_POST['Ancho']);
            $Producto->setClausulaDeGarantia($_POST['Clausula_de_garantia']);
            $Producto->setServicio($_POST['Servicio']);
            $Producto->setCodigo($_POST['Codigo_Interno']);
            $Producto->setLlevaLote($_POST['Lote']);
            $Producto->setLlevaSerial($_POST['Seriales']);
            $Producto->setCategoria($_POST['Categoria']);
            
            // Intento de modificar el producto y devuelve una respuesta en formato JSON
            if ($Producto->modificarProducto($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al modificar el producto']);
            }
            break;

        case 'eliminar':
            // Obtiene el ID del producto y llama al método para eliminarlo
            $id = $_POST['id'];
            $productoModel = new Productos();
            if ($productoModel->eliminarProducto($id)) {
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