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
try {
    $resultado = $Producto->ingresarProducto($_POST);
    if ($resultado) {
        $id_producto = $resultado;
        $respuesta = [
            'status' => 'success',
            'id_producto' => $id_producto
        ];
        echo json_encode($respuesta);
    }
} catch (Exception $e) {
    // Devuelve el error al frontend para verlo en la consola JS
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

    // Procesar imagen (si existe)
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $directorio = "IMG/Productos/";

        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true); // crea la carpeta si no existe
        }

        $nombre_original = $_FILES['imagen']['name'];
        $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);

        // Nombre único basado en ID del producto + timestamp para evitar sobrescritura
        $nombre_nuevo = "producto_" . $id_producto . "_" .$resultado;

        $ruta_destino = $directorio . $nombre_nuevo;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
            // Aquí podrías guardar la ruta en la base de datos si lo deseas
            $respuesta['imagen'] = $nombre_nuevo;
            $respuesta['mensaje'] = "Producto registrado e imagen guardada correctamente.";
        } else {
            $respuesta['imagen'] = null;
            $respuesta['mensaje'] = "Producto registrado, pero error al guardar la imagen.";
        }
    } else {
        $respuesta['mensaje'] = "Producto registrado correctamente.";
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

    // Asignar valores generales del producto
    $Producto->setId($id);
    $Producto->setNombreP($_POST['nombre_producto']);
    $Producto->setDescripcionP($_POST['descripcion_producto']);
    $Producto->setIdModelo($_POST['Modelo']);
    $Producto->setStockActual($_POST['Stock_Actual']);
    $Producto->setStockMax($_POST['Stock_Maximo']);
    $Producto->setStockMin($_POST['Stock_Minimo']);
    $Producto->setClausulaDeGarantia($_POST['Clausula_garantia']);
    $Producto->setCodigo($_POST['Seriales']);
    $Producto->setPrecio($_POST['Precio']);

    // El campo Categoria es el nombre de la tabla dinámica (ej: cat_herramientas)
    // El campo tabla_categoria también debe estar presente (igual que en registro)
    // El array carac[] contiene las características dinámicas

    // Guardar los cambios
    try {
        if ($Producto->modificarProducto($id, $_POST)) {
            // Procesar imagen (si existe)
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $directorio = "IMG/Productos/";
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0755, true);
                }
                // Eliminar imagen anterior si existe (buscando por extensiones)
                $extensiones = ['png', 'jpg', 'jpeg', 'webp'];
                foreach ($extensiones as $ext) {
                    $ruta_antigua = $directorio . 'producto_' . $id . '.' . $ext;
                    if (file_exists($ruta_antigua)) {
                        unlink($ruta_antigua);
                    }
                }
                // Guardar la nueva imagen con el mismo formato de nombre
                $nombre_original = $_FILES['imagen']['name'];
                $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
                $nombre_nuevo = "producto_" . $id . "." . $extension;
                $ruta_destino = $directorio . $nombre_nuevo;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al modificar la imagen del producto']);
                }
            } else {
                echo json_encode(['status' => 'success']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al modificar el producto']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
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
$productoModel = new Productos();
$categoriasDinamicas = $productoModel->obtenerCategoriasDinamicas();

if (empty($categoriasDinamicas)) {
    $mostrarFormulario = false;
} else {
    $mostrarFormulario = true;
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