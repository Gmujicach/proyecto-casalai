<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="Styles/darckort.css">
    <link rel="stylesheet" href="Styles/catalogo.css">
    
</head>
<body>
    <?php include 'NavBar.php'; ?>
    <br>

    <section class="container mt-5">
        <br>
        <br>
        <br>
        <h1 class="text-center mb-4">Catálogo de Productos</h1>
        
        <!-- Contenido de Productos -->
        <div class="card mb-4" id="productos-content">
            <div class="card-body">
                <!-- Filtros y controles -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="filtroMarca" class="form-label">Filtrar por Marca:</label>
                        <select class="form-select" id="filtroMarca">
                            <option value="">Todas las marcas</option>
                            <?php foreach ($marcas as $marca): ?>
                                <option value="<?= htmlspecialchars($marca['id_marca']) ?>">
                                    <?= htmlspecialchars($marca['nombre_marca']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-end h-100">
                            <div class="input-group ms-auto" style="max-width: 300px;">
                                <input type="text" class="form-control" id="searchProduct" placeholder="Buscar producto...">
                                <button class="btn btn-outline-secondary" type="button" id="btnSearch">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <a href="?pagina=carrito" class="btn btn-primary ms-2">
                                <i class="bi bi-cart"></i> 
                                <span class="cart-count badge bg-danger d-none">0</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Tabla de Productos -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="120px">Acciones</th>
                                <th>Producto</th>
                                <th width="100px">Stock</th>
                                <th>Descripción</th>
                                <th width="150px">Marca</th>
                                <th width="120px">Precio</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProductos">
                            <?php if (!empty($productos)): ?>
                                <?php foreach ($productos as $producto): ?>
                                    <tr class="product-row" data-id="<?= $producto['id_producto'] ?>">
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm btn-agregar-carrito" 
                                                    data-id-producto="<?= htmlspecialchars($producto['id_producto']) ?>">
                                                <i class="bi bi-cart-plus"></i> <span class="btn-text">Agregar</span>
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                
                                                <div>
                                                    <strong><?= htmlspecialchars($producto['nombre_producto']) ?></strong>
                                                    <div class="text-muted small"><?= htmlspecialchars($producto['serial']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $producto['stock'] > 0 ? 'bg-success' : 'bg-danger' ?> stock-badge">
                                                <?= htmlspecialchars($producto['stock']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($producto['descripcion_producto']) ?></td>
                                        <td><?= htmlspecialchars($producto['marca']) ?></td>
                                        <td class="fw-bold">$<?= number_format($producto['precio'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-exclamation-circle" style="font-size: 2rem;"></i>
                                        <p class="mt-2">No hay productos disponibles en este momento.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Contenido de Combos -->
        <div class="card mb-4" id="combos-content" style="display: none;">
            <div class="card-body">
                <?php if (!empty($combos)): ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($combos as $combo): 
                            $detalles = $productosModel->obtenerDetallesCombo($combo['id_combo']);
                            $precioTotal = 0;
                            $todosDisponibles = true;
                            
                            foreach ($detalles as $detalle) {
                                $producto = $productosModel->obtenerProductoPorId($detalle['id_producto']);
                                $precioTotal += ($producto['precio'] * $detalle['cantidad']);
                                $todosDisponibles = $todosDisponibles && ($producto['stock'] >= $detalle['cantidad']);
                            }
                            
                            $ahorro = $precioTotal * 0.1; // 10% de ahorro estimado
                        ?>
                            <div class="col">
                                <div class="card h-100 combo-card">
                                    <div class="combo-header">
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($combo['nombre_combo']) ?></h5>
                                        <p class="text-muted small mb-2"><?= htmlspecialchars($combo['descripcion']) ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4 class="text-success mb-0">$<?= number_format($precioTotal - $ahorro, 2) ?></h4>
                                            <span class="badge bg-info">Ahorras <?= number_format($ahorro, 2) ?></span>
                                        </div>
                                        <div class="combo-savings">
                                            <del class="text-muted">$<?= number_format($precioTotal, 2) ?></del>
                                            <span class="ms-2">(<?= count($detalles) ?> productos)</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-3">Contenido del Combo:</h6>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($detalles as $detalle): 
                                                $producto = $productosModel->obtenerProductoPorId($detalle['id_producto']);
                                                $disponible = $producto['stock'] >= $detalle['cantidad'];
                                            ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                                    <div>
                                                        <?= htmlspecialchars($producto['nombre_producto']) ?>
                                                        <?php if (!$disponible): ?>
                                                            <i class="bi bi-exclamation-triangle-fill text-danger ms-1" 
                                                               title="Stock insuficiente"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <span class="text-end">
                                                        <span class="text-muted small">$<?= number_format($producto['precio'], 2) ?></span> × 
                                                        <span class="badge bg-<?= $disponible ? 'primary' : 'danger' ?> rounded-pill">
                                                            <?= $detalle['cantidad'] ?>
                                                        </span>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="card-footer bg-transparent border-top-0 pt-0">
                                        <button class="btn btn-<?= $todosDisponibles ? 'success' : 'secondary' ?> w-100 btn-add-combo btn-agregar-combo" 
                                                data-id-combo="<?= $combo['id_combo'] ?>"
                                                <?= !$todosDisponibles ? 'disabled' : '' ?>>
                                            <i class="bi bi-cart-plus"></i> 
                                            <?= $todosDisponibles ? 'Agregar Combo' : 'Productos no disponibles' ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle-fill"></i> No hay combos disponibles en este momento.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pestañas de navegación -->
        <div class="bottom-tabs">
            <ul class="nav nav-tabs" id="catalogoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="productos-tab" onclick="mostrarProductos()">
                        <i class="bi bi-box-seam"></i> Productos Individuales
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="combos-tab" onclick="mostrarCombos()">
                        <i class="bi bi-collection"></i> Combos Promocionales
                    </button>
                </li>
            </ul>
        </div>
    </section>

    <!-- Modal para cantidad -->
    <div class="modal fade" id="cantidadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar cantidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="productoCantidad" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="productoCantidad" min="1" value="1">
                    </div>
                    <div class="alert alert-info d-none" id="stockDisponible">
                        Stock disponible: <span id="stockActual">0</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmarCantidad">Agregar al carrito</button>
                </div>
            </div>
        </div>
    </div>

    <script src="Public/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Javascript/sweetalert2.all.min.js"></script>
    <script>
        // Funciones para mostrar/ocultar contenido
        function mostrarProductos() {
            document.getElementById('productos-content').style.display = 'block';
            document.getElementById('combos-content').style.display = 'none';
            document.getElementById('productos-tab').classList.add('active');
            document.getElementById('combos-tab').classList.remove('active');
            localStorage.setItem('catalogoTab', 'productos');
        }

        function mostrarCombos() {
            document.getElementById('productos-content').style.display = 'none';
            document.getElementById('combos-content').style.display = 'block';
            document.getElementById('productos-tab').classList.remove('active');
            document.getElementById('combos-tab').classList.add('active');
            localStorage.setItem('catalogoTab', 'combos');
        }

        // Inicializar pestaña guardada
        const tabPreference = localStorage.getItem('catalogoTab');
        if (tabPreference === 'combos') {
            mostrarCombos();
        } else {
            mostrarProductos();
        }

        // Actualizar contador del carrito al cargar la página
        $(document).ready(function() {
            updateCartCount();
        });
    </script>
    <script src="Javascript/catalogo.js"></script>
</body>
</html>