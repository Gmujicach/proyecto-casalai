<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'Modelo/Productos.php';
require_once 'Modelo/Bitacora.php';
require_once 'Librerias/pdf.php'; // Para generación de PDFs

// Definir constantes para IDs de módulo
define('MODULO_CATALOGO', 1);

$productosModel = new Productos();
$bitacoraModel = new Bitacora();
$esAdmin = isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] == 'Administrador';

// Manejar generación de reportes PDF
if (isset($_GET['reporte']) && $esAdmin) {
    switch ($_GET['reporte']) {
        case 'accesos_semanales':
            $datosAccesos = $bitacoraModel->obtenerEstadisticasAccesos();
            $pdf = new PDF('Reporte de Accesos', 'Estadísticas semanales de visitas al catálogo');
            $pdf->generarReporteAccesos($datosAccesos);
            exit;
            
        case 'usuarios_activos':
            $usuariosActivos = $bitacoraModel->obtenerUsuariosMasActivos(10);
            $pdf = new PDF('Reporte de Usuarios Activos', 'Top 10 usuarios con más accesos al catálogo');
            $pdf->generarReporteUsuarios($usuariosActivos);
            exit;
    }
}

function generarReporteAccesosSemanales($bitacoraModel) {
    $datos = $bitacoraModel->obtenerEstadisticasAccesoSemanal();
    $pdf = new PDF();
    $pdf->generarReporteAccesos($datos);
}


// Manejar solicitudes AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion'])) {
    
    try {
        header('Content-Type: application/json');
        $accion = $_POST['accion'];

        if ($accion == 'obtener_datos_reportes') {
    try {
        // Obtener estadísticas de accesos
        $estadisticas = $bitacoraModel->obtenerEstadisticasAccesos();
        
        // Obtener usuarios más activos
        $usuariosActivos = $bitacoraModel->obtenerUsuariosMasActivos(10);
        
        echo json_encode([
            'status' => 'success',
            'estadisticas' => $estadisticas,
            'usuarios' => $usuariosActivos
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

        if ($accion == 'filtrar_por_marca') {
            $id_marca = $_POST['id_marca'] ?? null;
            $productos = $id_marca ? $productosModel->obtenerProductosPorMarca($id_marca) : $productosModel->obtenerProductosConMarca();

            // Registrar filtrado
            if (isset($_SESSION['id_usuario'])) {
                $marcaFiltro = $id_marca ? " (Marca ID: $id_marca)" : "";
                $bitacoraModel->registrarAccion('Filtrado de productos por marca'.$marcaFiltro, MODULO_CATALOGO, $_SESSION['id_usuario']);
            }

            if (!empty($productos)) {
                $html = '';
                foreach ($productos as $producto) {
                    $html .= '<tr class="product-row" data-id="' . htmlspecialchars($producto['id_producto']) . '">
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm btn-agregar-carrito" 
                                            data-id-producto="' . htmlspecialchars($producto['id_producto']) . '">
                                        <i class="bi bi-cart-plus"></i> <span class="btn-text">Agregar</span>
                                    </button>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">';
                    if (!empty($producto['imagen'])) {
                        $html .= '<img src="' . htmlspecialchars($producto['imagen']) . '" class="product-image"
                                    alt="' . htmlspecialchars($producto['nombre_producto']) . '"
                                    onerror="this.src=\'IMG/placeholder-product.png\'">';
                    } else {
                        $html .= '<div class="product-image img-placeholder">
                                    <i class="bi bi-image"></i>
                                  </div>';
                    }
                    $html .= '<div>
                                <strong>' . htmlspecialchars($producto['nombre_producto']) . '</strong>
                                <div class="text-muted small">' . htmlspecialchars($producto['serial']) . '</div>
                              </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge ' . ($producto['stock'] > 0 ? 'bg-success' : 'bg-danger') . ' stock-badge">
                                ' . htmlspecialchars($producto['stock']) . '
                            </span>
                        </td>
                        <td>' . htmlspecialchars($producto['descripcion_producto']) . '</td>
                        <td>' . htmlspecialchars($producto['marca']) . '</td>
                        <td class="fw-bold">$' . number_format($producto['precio'], 2) . '</td>
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
            try {
                if (!isset($_SESSION['id_usuario'])) {
                    throw new Exception('Debe iniciar sesión para agregar productos al carrito');
                }

                $id_producto = $_POST['id_producto'] ?? null;
                $cantidad = $_POST['cantidad'] ?? 1;

                if (!$id_producto) {
                    throw new Exception('Producto no especificado');
                }

                // Obtener info del producto para el registro
                $producto = $productosModel->obtenerProductoPorId($id_producto);
                $nombreProducto = $producto ? $producto['nombre_producto'] : 'ID: '.$id_producto;

                $result = $productosModel->agregarProductoAlCarrito($_SESSION['id_usuario'], $id_producto, $cantidad);

                if ($result) {
                    // Registrar en bitácora
                    $bitacoraModel->registrarAccion(
                        "Agregó producto al carrito: $nombreProducto (Cantidad: $cantidad)", 
                        MODULO_CATALOGO, 
                        $_SESSION['id_usuario']
                    );

                    // Respuesta limpia en JSON
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Producto agregado correctamente al carrito',
                        'cart_count' => $productosModel->obtenerCantidadCarrito($_SESSION['id_usuario'])
                    ]);
                } else {
                    throw new Exception('Error al agregar producto al carrito');
                }
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error', 
                    'message' => $e->getMessage()
                ]);
            }
            exit;
        }

        if ($accion == 'crear_combo') {
            try {
                $nombre = $_POST['nombre_combo'] ?? '';
                $descripcion = $_POST['descripcion'] ?? '';
                $productos = $_POST['productos'] ?? [];
                $cantidades = $_POST['cantidades'] ?? [];

                if (empty($nombre)) {
                    throw new Exception('El nombre del combo es requerido');
                }

                if (empty($productos)) {
                    throw new Exception('Debe seleccionar al menos un producto para el combo');
                }

                $id_combo = $productosModel->crearCombo($nombre, $descripcion, $productos);

                // Registrar creación de combo
                if (isset($_SESSION['id_usuario'])) {
                    $bitacoraModel->registrarAccion(
                        "Creó nuevo combo: $nombre (ID: $id_combo)", 
                        MODULO_CATALOGO, 
                        $_SESSION['id_usuario']
                    );
                }

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Combo creado exitosamente',
                    'id_combo' => $id_combo
                ]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
            exit;
        }

        if ($accion == 'cambiar_estado_combo') {
            try {
                header('Content-Type: application/json');
                
                $id_combo = $_POST['id_combo'] ?? 0;
                
                if (empty($id_combo)) {
                    throw new Exception('ID de combo no especificado');
                }
                
                // Obtener info del combo para registro
                $combo = $productosModel->obtenerComboPorId($id_combo);
                
                // Cambiar el estado usando el modelo
                $resultado = $productosModel->cambiarEstadoCombo($id_combo);
                
                // Registrar cambio de estado
                if ($resultado && isset($_SESSION['id_usuario'])) {
                    $nuevoEstado = $productosModel->obtenerComboPorId($id_combo)['activo'];
                    $accionEstado = $nuevoEstado ? 'habilitó' : 'deshabilitó';
                    $bitacoraModel->registrarAccion(
                        "$accionEstado el combo: {$combo['nombre_combo']} (ID: $id_combo)",
                        MODULO_CATALOGO,
                        $_SESSION['id_usuario']
                    );
                }
                
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Estado del combo actualizado correctamente',
                    'nuevo_estado' => $productosModel->obtenerComboPorId($id_combo)['activo']
                ]);
                
            } catch (Exception $e) {
                    echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
            exit;
        }

        if ($accion == 'actualizar_combo') {
            try {
                $id_combo = $_POST['id_combo'] ?? 0;
                $nombre = $_POST['nombre_combo'] ?? '';
                $descripcion = $_POST['descripcion'] ?? '';
                $productos = $_POST['productos'] ?? [];

                if (empty($id_combo)) {
                    throw new Exception('ID de combo no especificado');
                }

                // Obtener info del combo antes de actualizar
                $comboAntes = $productosModel->obtenerComboPorId($id_combo);

                $result = $productosModel->actualizarCombo($id_combo, $nombre, $descripcion, $productos);

                // Registrar actualización
                if ($result && isset($_SESSION['id_usuario'])) {
                    $bitacoraModel->registrarAccion(
                        "Actualizó combo: {$comboAntes['nombre_combo']} (ID: $id_combo)",
                        MODULO_CATALOGO,
                        $_SESSION['id_usuario']
                    );
                }

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Combo actualizado exitosamente'
                ]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
            exit;
        }

        if ($accion == 'eliminar_combo') {
            try {
                $id_combo = $_POST['id_combo'] ?? 0;

                if (empty($id_combo)) {
                    throw new Exception('ID de combo no especificado');
                }

                // Obtener info del combo antes de eliminar
                $combo = $productosModel->obtenerComboPorId($id_combo);

                $result = $productosModel->eliminarCombo($id_combo);

                // Registrar eliminación
                if ($result && isset($_SESSION['id_usuario'])) {
                    $bitacoraModel->registrarAccion(
                        "Eliminó combo: {$combo['nombre_combo']} (ID: $id_combo)",
                        MODULO_CATALOGO,
                        $_SESSION['id_usuario']
                    );
                }

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Combo eliminado exitosamente'
                ]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
            exit;
        }

        if ($accion == 'obtener_detalles_combo') {
            try {
                $id_combo = $_POST['id_combo'] ?? 0;

                if (empty($id_combo)) {
                    throw new Exception('ID de combo no especificado');
                }

                $combo = $productosModel->obtenerComboPorId($id_combo);
                $detalles = $productosModel->obtenerDetallesCombo($id_combo);

                echo json_encode([
                    'status' => 'success',
                    'combo' => $combo,
                    'detalles' => $detalles
                ]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
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

                // Obtener info del combo
                $combo = $productosModel->obtenerComboPorId($id_combo);

                $result = $productosModel->agregarComboAlCarrito($_SESSION['id_usuario'], $id_combo);
                $detalles = $productosModel->obtenerDetallesCombo($id_combo);

                // Registrar en bitácora
                $bitacoraModel->registrarAccion(
                    "Agregó combo al carrito: {$combo['nombre_combo']} (ID: $id_combo, Productos: ".count($detalles).")",
                    MODULO_CATALOGO,
                    $_SESSION['id_usuario']
                );

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Combo agregado correctamente al carrito',
                    'productos_agregados' => count($detalles)
                ]);
            } catch (Exception $e) {
               echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
            exit;
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}

// Obtener datos para la vista
try {
    $productos = $productosModel->obtenerProductosConMarca();
    $marcas = $productosModel->obtenerMarcas();
    $esAdmin = isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] == 'Administrador';
    $combos = $productosModel->obtenerCombosDisponibles($esAdmin);
} catch (PDOException $e) {
    $productos = [];
    $marcas = [];
    $combos = [];
}

// Asignar la página y cargar la vista
$pagina = "catalogo";
if (is_file("Vista/" . $pagina . ".php")) {
    if (isset($_SESSION['id_usuario'])) {
        $bitacoraModel->registrarAccion('Acceso al módulo de catálogo', MODULO_CATALOGO, $_SESSION['id_usuario']);
    }
    require_once("Vista/" . $pagina . ".php");
} else {
    echo "Página en construcción";
}

ob_end_flush();