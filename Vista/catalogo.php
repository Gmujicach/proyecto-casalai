<?php if ($_SESSION['rango'] == 'Administrador' || $_SESSION['rango'] == 'Cliente') { ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link href="Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Public/bootstrap/css/bootstrap-icons.css">
    <?php include 'header.php'; ?>
    <style>
        .disabled-combo {
            opacity: 0.7;
            background-color: #f8f9fa;
            border: 1px dashed #ccc;
        }

        .disabled-combo .card-title {
            text-decoration: line-through;
            color: #6c757d;
        }

        .combo-actions-footer {
            padding: 0.75rem 1.25rem;
        }

        .combo-card {
            transition: all 0.3s ease;
        }

        .combo-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <?php include 'NewNavBar.php'; ?>
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
                                    <div class="combo-header">
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($combo['nombre_combo']) ?></h5>
                                        <?php if (!$combo['activo']): ?>
                                            <span class="badge bg-secondary mb-2">Deshabilitado</span>
                                        <?php endif; ?>
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

    <script src="Public/js/jquery-3.7.1.min.js"></script>
    <script src="Public/js/bootstrap.bundle.min.js"></script>
    <script src="Javascript/sweetalert2.all.min.js"></script>
    <script src="Javascript/catalogo.js"></script>

</body>

</html>

<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>