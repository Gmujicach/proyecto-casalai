<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="Public/bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/darckort.css">
</head>

<body>
    <?php include 'NavBar.php'; ?>
    <section class="container">

        <!-- Tabla de Productos Disponibles -->
        <div class="table-container">
            <h1 class="titulo-tabla display-5 text-center">LISTA DE PRODUCTOS</h1>
            <!-- Filtro por marcas -->
            <div class="mb-3">
                <label for="filtroMarca" class="form-label">Filtrar por Marca:</label>
                <select class="form-control" id="filtroMarca">
                    <option value="">Todas las marcas</option>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo htmlspecialchars($marca['id_marca']); ?>">
                            <?php echo htmlspecialchars($marca['descripcion_ma']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <table class="tabla">
    <thead>
        <tr>
            <th>Acciones</th>
            <th>Nombre del Producto</th>
            <th>Stock Actual</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Código</th>
        </tr>
    </thead>
    <tbody id="tablaProductos">
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td>
                    <button type="button" class="btn btn-modificar btn-agregar-carrito" 
                            data-id-producto="<?php echo htmlspecialchars($producto['id_producto']); ?>">
                        Agregar al carrito
                    </button>
                </td>
                <td><?php echo htmlspecialchars($producto['nombre_p']); ?></td>
                <td><?php echo $producto['stock'] > 0 ? $producto['stock'] : '<p style="background: red; color:white; border-radius: 10px; opacity: 0.8;box-shadow: 2px 2px 5px red;">Agotado</p>'; ?></td>
                <td><?php echo htmlspecialchars($producto['descripcion_p']); ?></td>
                <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                <td><?php echo htmlspecialchars($producto['codigo']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        </div>

        <!-- Tabla de Productos en el Carrito -->
        <div class="table-container mt-5">
            <h1 class="titulo-tabla display-5 text-center">PRODUCTOS EN EL CARRITO</h1>
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($carritos)): ?>
                        <?php foreach ($carritos as $carrito): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($carrito['nombre']); ?></td>
                                <td>
                                    <!-- Campo de entrada para editar la cantidad -->
                                    <input type="number"
                                        class="form-control cantidad"
                                        value="<?php echo htmlspecialchars($carrito['cantidad']); ?>"
                                        min="1"
                                        data-id-carrito-detalle="<?php echo htmlspecialchars($carrito['id_carrito_detalle']); ?>">
                                </td>
                                <td><?php echo htmlspecialchars($carrito['precio']); ?></td>
                                <td class="subtotal"><?php echo htmlspecialchars($carrito['subtotal']); ?></td>
                                <td>
                                    <!-- Botón Eliminar del Carrito -->
                                    <button type="button" class="btn btn-eliminar" data-id="<?php echo htmlspecialchars($carrito['id_carrito_detalle']); ?>">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay productos en el carrito.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- Botón para eliminar todo el carrito -->
            <div class="text-right mt-3">
                <button type="button" class="btn btn-danger" id="eliminar-todo-carrito">Eliminar Todo el Carrito</button>
                <button type="button" class="btn btn-success" id="registrar-compra">Registrar Compra</button>
            </div>
        </div>
    </section>
    <script src="Public/bootstrap/js/sidebar.js"></script>
    <script src="Public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="Public/js/jquery-3.7.1.min.js"></script>
    <script src="Public/js/jquery.dataTables.min.js"></script>
    <script src="Public/js/dataTables.bootstrap5.min.js"></script>
    <script src="Public/js/datatable.js"></script>
    <script src="Javascript/sweetalert2.all.min.js"></script>
    <script src="Javascript/carrito.js"></script> <!-- Archivo JavaScript separado -->
    
</body>

</html>