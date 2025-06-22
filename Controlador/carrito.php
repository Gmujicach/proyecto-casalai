<?php
ob_start();
require_once 'Modelo/Productos.php';
require_once 'Modelo/Carrito.php';
require_once 'Modelo/Factura.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'] ?? '';
    
    switch ($accion) {



            case 'agregar_al_carrito':
                $id_producto = $_POST['id_producto'] ?? null;
                if ($id_producto !== null) {
                    $carrito = new Carrito();
                    $id_cliente = $_SESSION['id_usuario'];; // Obtener de la sesión en producción
                    
                    try {
                        $carritoCliente = $carrito->obtenerCarritoPorCliente($id_cliente);
                        
                        if (!$carritoCliente) {
                            $carrito->crearCarrito($id_cliente);
                            $carritoCliente = $carrito->obtenerCarritoPorCliente($id_cliente);
                        }
                        
                        $id_carrito = $carritoCliente['id_carrito'];
                        $cantidad = 1; // Cantidad predeterminada
                        
                        if ($carrito->agregarProductoAlCarrito($id_carrito, $id_producto, $cantidad)) {
                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Producto agregado al carrito correctamente'
                            ]);
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'Error al agregar el producto al carrito'
                            ]);
                        }
                    } catch (Exception $e) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Error: ' . $e->getMessage()
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'ID de producto no válido'
                    ]);
                }
                
                break;

        case 'actualizar_cantidad':
            $id_carrito_detalle = $_POST['id_carrito_detalle'] ?? null;
            $cantidad = $_POST['cantidad'] ?? null;

            if ($id_carrito_detalle !== null && $cantidad !== null) {
                $carrito = new Carrito();
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
            $id_carrito_detalle = $_POST['id_carrito_detalle'] ?? null;
            if ($id_carrito_detalle !== null) {
                $carrito = new Carrito();
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
            $id_cliente = $_SESSION['id_usuario'];; // Obtener de la sesión
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
    $factura = new Factura();
    // Aquí se debe obtener el ID del cliente de la sesión
    $factura->setCliente(1); 
    $factura->setFecha(date('Y-m-d H:i:s'));
    $factura->setDescuento(0); // Descuento inicial
    $factura->setEstatus('Borrador'); // Estado inicial de la compra
    $productos = $_POST['productos'] ?? [];
    $cantidades = $_POST['cantidad'] ?? [];
    $factura->setIdProducto($productos);
    $factura->setCantidad($cantidades);
   /*
    $carrito = new Carrito();
    $carritoCliente = $carrito->obtenerCarritoPorCliente($id_cliente);
    $id_carrito = $carritoCliente['id_carrito'];
    if ($carritoCliente) {
        $id_carrito = $carritoCliente['id_carrito'];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se encontró un carrito para este cliente.']);
    }
    */
        try {
            $resultado = $factura->facturaTransaccion("Ingresar");

            if (is_array($resultado) && isset($resultado['error'])) {

                echo json_encode(['status' => 'error', 'message' => $resultado['error']]);
            } elseif ($resultado === true) {
                // Todo fue exitoso
                $obj_producto = new Productos();
                $productos = $factura->getIdProducto();
                $cantidades = $factura->getCantidad();

                // Actualizar el stock de cada producto
                foreach ($productos as $index => $id_producto) {
                    $cantidad = $cantidades[$index];
                    if (!$obj_producto->actualizarStockProducto($id_producto, $cantidad)) {
                        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el stock del producto']);
                        return;
                    }
                }
                $carrito = new Carrito();   
                $carritoCliente = $carrito->obtenerCarritoPorCliente($_SESSION['id_usuario']);
                $id_carrito = $carritoCliente['id_carrito'];
                $carrito->eliminarTodoElCarrito($id_carrito);
                echo json_encode(['status' => 'success', 'message' => 'Compra registrada correctamente']);
            } else {
                // Fallback genérico
                echo json_encode(['status' => 'error', 'message' => 'Error desconocido al registrar la compra']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Excepción: ' . $e->getMessage()]);
        }

    break;



        case 'filtrar_por_marca':
            $id_marca = $_POST['id_marca'] ?? null;
            $producto = new Productos();
            $productos = $producto->obtenerProductosPorMarca($id_marca);

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
                                <td>'.htmlspecialchars($producto['nombre_producto']).'</td>
                                <td>'.($producto['stock'] > 0 ? $producto['stock'] : '<p style="background: red; color:white; border-radius: 10px; opacity: 0.8;box-shadow: 2px 2px 5px red;">Agotado</p>').'</td>
                                <td>'.htmlspecialchars($producto['descripcion_producto']).'</td>
                                <td>'.htmlspecialchars($producto['marca']).'</td>
                                <td>'.htmlspecialchars($producto['serial']).'</td>
                            </tr>';
                }
                echo json_encode(['status' => 'success', 'html' => $html]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se encontraron productos para la marca seleccionada']);
            }
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            break;
    }
    exit;
}

// Funciones para la vista
function obtenerProductos() {
    $producto = new Productos();
    return $producto->obtenerProductoStock();
}

function obtenerProductosDelCarrito() {
    $carrito = new Carrito();
    $id_cliente = $_SESSION['id_usuario']; // Obtener de la sesión
    $carritoCliente = $carrito->obtenerCarritoPorCliente($id_cliente);

    if ($carritoCliente) {
        $id_carrito = $carritoCliente['id_carrito'];
        return $carrito->obtenerProductosDelCarrito($id_carrito);
    }
    return [];
}

function obtenerMarcas() {
    $producto = new Productos();
    return $producto->obtenerMarcas();
}

// Cargar vista
$pagina = "carrito";
if (is_file("Vista/" . $pagina . ".php")) {
    $productos = obtenerProductos();
    $carritos = obtenerProductosDelCarrito();
    $marcas = obtenerMarcas();
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();