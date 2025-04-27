<?php
// Inicia el almacenamiento en búfer de salida
ob_start();

// Importa los modelos necesarios
require_once 'Modelo/Productos.php';
require_once 'Modelo/Carrito.php';

// Verifica si la solicitud se realizó mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene la acción enviada en la solicitud POST
    $accion = $_POST['accion'] ?? '';

    // Switch para manejar diferentes acciones
    switch ($accion) {
        case 'agregar_al_carrito':
            // Obtiene el ID del producto desde el formulario
            $id_producto = $_POST['id_producto'] ?? null;
            if ($id_producto !== null) {
                // Crear una instancia del modelo Carrito
                $carrito = new Carrito();

                // Obtener el carrito del cliente (asumimos que el cliente tiene ID 3 para este ejemplo)
                $id_cliente = 3; // Puedes obtener el ID del cliente de la sesión
                $carritoCliente = $carrito->obtenerCarritoPorCliente($id_cliente);

                // Si el cliente no tiene un carrito, crear uno nuevo
                if (!$carritoCliente) {
                    $carrito->crearCarrito($id_cliente);
                    $carritoCliente = $carrito->obtenerCarritoPorCliente($id_cliente);
                }

                // Agregar el producto al carrito
                $id_carrito = $carritoCliente['id_carrito'];
                $cantidad = 1; // Cantidad predeterminada
                if ($carrito->agregarProductoAlCarrito($id_carrito, $id_producto, $cantidad)) {
                    echo json_encode(['status' => 'success', 'message' => 'Producto agregado al carrito']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al agregar el producto al carrito']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de producto no proporcionado']);
            }
            break;

        case 'actualizar_cantidad':
            // Obtener el ID del detalle del carrito y la nueva cantidad
            $id_carrito_detalle = $_POST['id_carrito_detalle'] ?? null;
            $cantidad = $_POST['cantidad'] ?? null;

            if ($id_carrito_detalle !== null && $cantidad !== null) {
                // Crear una instancia del modelo Carrito
                $carrito = new Carrito();

                // Actualizar la cantidad en el carrito
                if ($carrito->actualizarCantidadProducto($id_carrito_detalle, $cantidad)) {
                    echo json_encode(['status' => 'success', 'message' => 'Cantidad actualizada correctamente']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la cantidad']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
            }
            break;

        case 'eliminar_del_carrito':
            // Obtener el ID del detalle del carrito desde el formulario
            $id_carrito_detalle = $_POST['id_carrito_detalle'] ?? null;

            if ($id_carrito_detalle !== null) {
                // Crear una instancia del modelo Carrito
                $carrito = new Carrito();

                // Eliminar el producto del carrito
                if ($carrito->eliminarProductoDelCarrito($id_carrito_detalle)) {
                    echo json_encode(['status' => 'success', 'message' => 'Producto eliminado del carrito']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto del carrito']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ID de detalle del carrito no proporcionado']);
            }
            break;

        case 'eliminar_todo_carrito':
            $id_cliente = 3; // Obtener el ID del cliente de la sesión
            $carrito = new Carrito();
            $carritoCliente = $carrito->obtenerCarritoPorCliente($id_cliente);

            if ($carritoCliente) {
                $id_carrito = $carritoCliente['id_carrito'];
                if ($carrito->eliminarTodoElCarrito($id_carrito)) {
                    echo json_encode(['status' => 'success', 'message' => 'Carrito vaciado correctamente']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al vaciar el carrito']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se encontró el carrito del cliente']);
            }
            break;

        case 'registrar_compra':
            $id_cliente = 3; // Obtener el ID del cliente de la sesión
            $carrito = new Carrito();
            $carritoCliente = $carrito->obtenerCarritoPorCliente($id_cliente);

            if ($carritoCliente) {
                $id_carrito = $carritoCliente['id_carrito'];
                if ($carrito->registrarCompra($id_carrito, $id_cliente)) {
                    echo json_encode(['status' => 'success', 'message' => 'Compra registrada correctamente']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al registrar la compra']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se encontró el carrito del cliente']);
            }
            break;

            // En la parte del case 'filtrar_por_marca':
case 'filtrar_por_marca':
    $id_marca = $_POST['id_marca'] ?? null;
    $producto = new Productos();
    $productos = $producto->ObtenerMarcas($id_marca);

    if (!empty($productos)) {
        $html = '';
        foreach ($productos as $producto) {
            $html .= '<tr>
                        <td>
                            <button type="button" class="btn btn-modificar btn-agregar-carrito" 
                                    data-id-producto="'.htmlspecialchars($producto['id_producto']).'">
                                Agregar al carrito
                            </button>
                        </td>
                        <td>'.htmlspecialchars($producto['nombre_p']).'</td>
                        <td>'.($producto['stock'] > 0 ? $producto['stock'] : '<p style="background: red; color:white; border-radius: 10px; opacity: 0.8;box-shadow: 2px 2px 5px red;">Agotado</p>').'</td>
                        <td>'.htmlspecialchars($producto['descripcion_p']).'</td>
                        <td>'.htmlspecialchars($producto['marca']).'</td>
                        <td>'.htmlspecialchars($producto['codigo']).'</td>
                    </tr>';
        }
        echo json_encode(['status' => 'success', 'html' => $html]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se encontraron productos para la marca seleccionada']);
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

// Función para obtener productos
function obtenerProductos() {
    $producto = new Productos();
    return $producto->obtenerTodos();
}



// Función para obtener las marcas
function obtenerMarcas() {
    $producto = new Productos();
    return $producto->obtenerMarcas();
}

// Asigna el nombre de la página
$pagina = "catalogo";
// Verifica si el archivo de vista existe
if (is_file("Vista/" . $pagina . ".php")) {
    // Obtiene los productos
    $productos = obtenerProductos();
    
    $marcas = obtenerMarcas();
    // Incluye el archivo de vista
    require_once("Vista/" . $pagina . ".php");
} else {
    // Muestra un mensaje si la página está en construcción
    echo "Página en construcción";
}

// Termina el almacenamiento en búfer de salida y envía la salida al navegador
ob_end_flush();