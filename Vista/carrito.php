<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'SuperUsuario' || $_SESSION['nombre_rol'] == 'Cliente') { ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <?php include 'header.php'; ?>
    
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <?php include 'newnavbar.php'; ?>
    <section class="container mt-4">        

        <!-- Tabla de Productos en el Carrito -->
        <div class="table-container mt-4">
            <h1 class="titulo-tabla display-5">PRODUCTOS EN EL CARRITO</h1>
            
            <div class="table-responsive">
                <table class="tabla table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre del Producto</th>
                            <th width="120px">Cantidad</th>
                            <th width="120px">Precio Unitario</th>
                            <th width="120px">Subtotal</th>
                            <th width="100px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($carritos)): ?>
                            <?php 
                            $total = 0;
                            foreach ($carritos as $carrito): 
                                $total += $carrito['subtotal'];
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($carrito['nombre']); ?></td>
                                    <td>
                                        <input type="number"
                                            class="form-control cantidad"
                                            value="<?php echo htmlspecialchars($carrito['cantidad']); ?>"
                                            min="1"
                                            data-id-carrito-detalle="<?php echo htmlspecialchars($carrito['id_carrito_detalle']); ?>"
                                            data-id-producto="<?php echo htmlspecialchars($carrito['id_producto']); ?>">
                                    </td>
                                    <td>$<?php echo number_format($carrito['precio'], 2); ?></td>
                                    <td class="subtotal">$<?php echo number_format($carrito['subtotal'], 2); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar" 
                                                data-id="<?php echo htmlspecialchars($carrito['id_carrito_detalle']); ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="table-active">
                                <td colspan="3" class="text-end fw-bold">TOTAL:</td>
                                <td class="fw-bold">$<?php echo number_format($total, 2); ?></td>
                                <td></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                                    <p class="mt-2">No hay productos en el carrito.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Botones de acción -->
            <div class="d-flex justify-content-between mt-3">
                <?php if (!empty($carritos)): ?>
                    <button type="button" class="btn btn-danger" id="eliminar-todo-carrito">
                        <i class="bi bi-trash"></i> Eliminar Todo el Carrito
                    </button>
                    <button type="button" class="btn btn-success" id="registrar-compra">
                        <i class="bi bi-check-circle"></i> Prefacturar
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script src="public/bootstrap/js/sidebar.js"></script>
    <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/jquery-3.7.1.min.js"></script>
    <script src="public/js/jquery.dataTables.min.js"></script>
    <script src="public/js/dataTables.bootstrap5.min.js"></script>
    <script src="public/js/datatable.js"></script>
    <script src="javascript/sweetalert2.all.min.js"></script>
    <script src="javascript/carrito.js"></script>
</body>
</html>

<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>