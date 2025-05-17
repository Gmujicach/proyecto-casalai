<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'Modelo/Productos.php';
$productosModel = new Productos();

// Manejar solicitudes AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion'])) {
    try {
        header('Content-Type: application/json');
        $accion = $_POST['accion'];

        if ($accion == 'filtrar_por_marca') {
            $id_marca = $_POST['id_marca'] ?? null;
            $productos = $id_marca ? $productosModel->obtenerProductosPorMarca($id_marca) : $productosModel->obtenerProductosConMarca();

            if (!empty($productos)) {
                $html = '';
                foreach ($productos as $producto) {
                    $html .= '<tr>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm btn-agregar-carrito" 
                                            data-id-producto="' . htmlspecialchars($producto['id_producto']) . '">
                                        <i class="bi bi-cart-plus"></i> Agregar
                                    </button>
                                </td>
                                <td>' . htmlspecialchars($producto['nombre_producto']) . '</td>
                                <td><span class="badge bg-' . ($producto['stock'] > 0 ? 'success' : 'danger') . '">' . htmlspecialchars($producto['stock']) . '</span></td>
                                <td>' . htmlspecialchars($producto['descripcion_producto']) . '</td>
                                <td>' . htmlspecialchars($producto['marca']) . '</td>
                                <td>' . htmlspecialchars($producto['serial']) . '</td>
                            </tr>';
                }
                echo json_encode(['status' => 'success', 'html' => $html]);
            } else {
                echo json_encode([
                    'status' => 'info',
                    'message' => 'No hay productos disponibles',
                    'html' => '<tr><td colspan="6" class="text-center py-4"><i class="bi bi-exclamation-circle"></i> No hay productos disponibles para esta selección</td></tr>'
                ]);
            }
            exit;
        }

        if ($accion == 'agregar_al_carrito') {
            if (!isset($_SESSION['id_usuario'])) {
                throw new Exception('Debe iniciar sesión para agregar productos al carrito');
            }

            $id_producto = $_POST['id_producto'] ?? null;
            $cantidad = $_POST['cantidad'] ?? 1;

            if (!$id_producto) {
                throw new Exception('Producto no especificado');
            }

            $result = $productosModel->agregarProductoAlCarrito($_SESSION['id_usuario'], $id_producto, $cantidad);

            if ($result) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Producto agregado al carrito'
                ]);
            } else {
                throw new Exception('Error al agregar producto al carrito');
            }
            exit;
        }

        if ($accion == 'agregar_combo_al_carrito') {
            try {
                if (!isset($_SESSION['id_usuario'])) {
                    throw new Exception('Debe iniciar sesión para agregar combos');
                }

                $id_combo = $_POST['id_combo'] ?? null;
                if (!$id_combo) {
                    throw new Exception('No se especificó el combo');
                }

                $result = $productosModel->agregarComboAlCarrito(3, $id_combo);
                $detalles = $productosModel->obtenerDetallesCombo($id_combo);

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Combo agregado correctamente al carrito',
                    'productos_agregados' => count($detalles)
                ]);
            } catch (Exception $e) {
                error_log("Error en agregar_combo_al_carrito: " . $e->getMessage());
                echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
            exit;
        }
    } catch (Exception $e) {
        error_log("Error en la solicitud AJAX: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}

// Obtener datos para la vista
try {
    $productos = $productosModel->obtenerProductosConMarca();
    $marcas = $productosModel->obtenerMarcas();
    $combos = $productosModel->obtenerCombosDisponibles();
} catch (PDOException $e) {
    error_log("Error al cargar datos del catálogo: " . $e->getMessage());
    $productos = [];
    $marcas = [];
    $combos = [];
}

// Asignar la página y cargar la vista
$pagina = "catalogo";
if (is_file("Vista/" . $pagina . ".php")) {
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();