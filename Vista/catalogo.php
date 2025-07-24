<?php 
$esAdmin = ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'SuperUsuario');

if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Cliente' || $_SESSION['nombre_rol'] == 'SuperUsuario') { ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php include 'header.php'; ?>
    <style>
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 4px;
            margin-right: 15px;
            border: 1px solid #dee2e6;
        }

        .combo-images-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 5px;
            margin-bottom: 15px;
        }

        .combo-image {
            width: 100%;
            height: 100px;
            object-fit: contain;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .combo-main-image {
            grid-column: span 2;
            height: 150px;
        }

        .img-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 12px;
        }

        .disabled-combo {
            opacity: 0.7;
            background-color: #f8f9fa;
        }

        .disabled-combo .card-footer {
            background-color: #e9ecef;
        }

        .chart-container {
            position: relative;
            height: 400px;
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .report-actions {
            margin-bottom: 20px;
            text-align: right;
        }

        .bottom-tabs {
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            font-weight: 600;
        }

        .combo-card {
            transition: all 0.3s ease;
        }

        .combo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .combo-savings {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .fondo {
            background-image: url(img/fondo.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
    </style>
</head>

<body class="fondo">
    <?php include 'newnavbar.php'; ?>
    <br>

    <section class="container mt-5">
        <br>
        <br>
        <br>
        <h1 class="text-center mb-4">Catálogo de Productos</h1>

        <!-- Pestañas de navegación -->
        <div class="bottom-tabs">
            <ul class="nav nav-tabs" id="catalogoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="productos-tab">
                        <i class="bi bi-box-seam"></i> Productos Individuales
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="combos-tab">
                        <i class="bi bi-collection"></i> Combos Promocionales
                    </button>
                </li>
                <?php if ($esAdmin): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reportes-tab">
                        <i class="bi bi-bar-chart"></i> Reportes Estadísticos
                    </button>
                </li>
                <?php endif; ?>
            </ul>
        </div>

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
                    <table class="table table-striped table-hover align-middle" id="tablaProductos">
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
                                                <?php if (!empty($producto['imagen'])): ?>
                                                    <img src="<?= htmlspecialchars($producto['imagen']) ?>" class="product-image"
                                                        alt="<?= htmlspecialchars($producto['nombre_producto']) ?>"
                                                        onerror="this.src='img/placeholder-product.png'">
                                                <?php else: ?>
                                                    <div class="product-image img-placeholder">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <strong><?= htmlspecialchars($producto['nombre_producto']) ?></strong>
                                                    <div class="text-muted small"><?= htmlspecialchars($producto['serial']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            
                                            $stockClass = 'bg-success';
                                            if ($producto['stock'] < 5) {
                                                $stockClass = 'bg-danger';
                                            } elseif ($producto['stock'] < 10) {
                                                $stockClass = 'bg-warning'; 
                                            }
                                            ?>
                                            <span class="badge <?= $stockClass ?> stock-badge">
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
                    <!-- Botón para agregar nuevo combo (solo para admin) -->
                    <?php if ($esAdmin): ?>
                        <div class="text-end mb-3">
                            <button type="button" class="btn btn-primary" id="nuevo_combo">
                                <i class="bi bi-plus-circle"></i> Nuevo Combo
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($combos as $combo):
                            // Omitir combos inactivos para usuarios no admin
                            if (!$esAdmin && !$combo['activo']) continue;

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
                                <div class="card h-100 combo-card <?= !$combo['activo'] ? 'disabled-combo' : '' ?>">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($combo['nombre_combo']) ?></h5>
                                        <?php if (!$combo['activo']): ?>
                                            <span class="badge bg-secondary mb-2">Deshabilitado</span>
                                        <?php endif; ?>

                                        <!-- Mostrar imágenes en grid 2x2 -->
                                        <div class="combo-images-grid">
                                            <?php
                                            $imagenesMostradas = 0;
                                            foreach ($detalles as $detalle):
                                                if ($imagenesMostradas >= 4) break;
                                                $producto = $productosModel->obtenerProductoPorId($detalle['id_producto']);
                                                if (!empty($producto['imagen'])):
                                                    $imagenesMostradas++;
                                            ?>
                                                    <img src="<?= htmlspecialchars($producto['imagen']) ?>" class="combo-image <?= $imagenesMostradas == 1 ? 'combo-main-image' : '' ?>"
                                                        alt="<?= htmlspecialchars($producto['nombre_producto']) ?>"
                                                        onerror="this.src='img/placeholder-product.png'">
                                            <?php
                                                endif;
                                            endforeach;

                                            // Rellenar con placeholders si no hay suficientes imágenes
                                            while ($imagenesMostradas < 4) {
                                                $imagenesMostradas++;
                                                echo '<div class="combo-image img-placeholder' . ($imagenesMostradas == 1 ? ' combo-main-image' : '') . '">';
                                                echo '<i class="bi bi-image"></i>';
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>

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
                                    <div class="card-body pt-0">
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
                                            <?= !$todosDisponibles || !$combo['activo'] ? 'disabled' : '' ?>>
                                            <i class="bi bi-cart-plus"></i>
                                            <?= !$combo['activo'] ? 'Combo no disponible' : ($todosDisponibles ? 'Agregar Combo' : 'Productos no disponibles') ?>
                                        </button>
                                    </div>

                                    <!-- Footer de acciones (solo para admin) -->
                                    <?php if ($esAdmin): ?>
                                        <div class="card-footer combo-actions-footer bg-light border-top-0 pt-0">
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-sm btn-outline-primary btn-editar-combo"
                                                    data-id-combo="<?= $combo['id_combo'] ?>">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </button>
                                                <button class="btn btn-sm <?= $combo['activo'] ? 'btn-outline-warning' : 'btn-outline-success' ?> btn-cambiar-estado"
                                                    data-id-combo="<?= $combo['id_combo'] ?>"
                                                    data-nombre-combo="<?= htmlspecialchars($combo['nombre_combo']) ?>"
                                                    data-estado-actual="<?= $combo['activo'] ? 1 : 0 ?>">
                                                    <i class="bi <?= $combo['activo'] ? 'bi-eye-slash' : 'bi-eye' ?>"></i>
                                                    <?= $combo['activo'] ? 'Deshabilitar' : 'Habilitar' ?>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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

        <!-- Contenido de Reportes (solo para admin) -->
        <?php if ($esAdmin): ?>
        <!-- En la sección de reportes de la vista catalogo.php: -->

<div class="card mb-4" id="reportes-content" style="display: none;">
    <div class="card-body">
        <div class="report-actions mb-4">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0"><i class="bi bi-bar-chart"></i> Reportes Estadísticos</h4>
                <div>
                    <a href="?pagina=catalogo&reporte=accesos_semanales" class="btn btn-danger me-2">
                        <i class="bi bi-file-pdf"></i> Descargar PDF Accesos
                    </a>
                    <a href="?pagina=catalogo&reporte=usuarios_activos" class="btn btn-danger">
                        <i class="bi bi-file-pdf"></i> Descargar PDF Usuarios
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="mb-3">Accesos semanales al catálogo</h5>
                    <canvas id="accesosSemanalesChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="mb-3">Top 10 usuarios con más accesos</h5>
                    <canvas id="usuariosActivosChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-table"></i> Datos Estadísticos Detallados</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="tablaEstadisticas">
                        <thead class="table-dark">
                            <tr>
                                <th>Semana</th>
                                <th>Promedio Diario</th>
                                <th>Total Accesos</th>
                                <th>Usuarios Únicos</th>
                            </tr>
                        </thead>
                        <tbody id="datosEstadisticas">
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
        <?php endif; ?>

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

        <!-- Modal para habilitar/deshabilitar combo -->
        <div class="modal fade" id="estadoComboModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="estadoComboModalLabel">Cambiar Estado del Combo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="estadoComboMensaje">¿Estás seguro de que deseas <span id="accionEstado">habilitar</span> este combo?</p>
                        <input type="hidden" id="comboIdEstado">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="confirmarCambioEstado">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para gestión de combos -->
        <div class="modal fade" id="comboModal" tabindex="-1" aria-labelledby="comboModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="comboModalLabel">Gestionar Combo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="comboForm">
                            <input type="hidden" id="id_combo" name="id_combo" value="">
                            <div class="mb-3">
                                <label for="nombre_combo" class="form-label">Nombre del Combo</label>
                                <input type="text" class="form-control" id="nombre_combo" name="nombre_combo" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Productos del Combo</label>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <select class="form-select" id="producto_select">
                                            <option value="">Seleccionar producto</option>
                                            <?php
                                            $productosCombo = $productosModel->obtenerTodosProductosParaCombos();
                                            foreach ($productosCombo as $producto): ?>
                                                <option value="<?= $producto['id_producto'] ?>"
                                                    data-precio="<?= $producto['precio'] ?>"
                                                    data-stock="<?= $producto['stock'] ?>">
                                                    <?= htmlspecialchars($producto['nombre_producto']) ?> (<?= htmlspecialchars($producto['marca']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" id="producto_cantidad" min="1" value="1">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-primary w-100" id="agregar_producto">
                                            <i class="bi bi-plus-circle"></i> Agregar
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm" id="productos_combo_table">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th width="100px">Cantidad</th>
                                                <th width="100px">Precio</th>
                                                <th width="50px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Los productos se agregarán dinámicamente aquí -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" id="guardar_combo">
                            <i class="bi bi-save"></i> Guardar Combo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="public/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="javascript/sweetalert2.all.min.js"></script>
    <script src="javascript/catalogo.js"></script>
    <script src="public/js/jquery.dataTables.min.js"></script>
    <script src="public/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>
<?php } else {
    header("Location: ?pagina=acceso-denegado");
    exit;
} ?>
