<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Combos</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados existentes -->
    <link rel="stylesheet" href="Styles/darckort.css">
    <!-- Archivo CSS externo para esta vista -->
    <link rel="stylesheet" href="public/css/catalogo.css">
    <?php include 'NavBar.php'; ?>
</head>
<body>

<div class="container my-4">
    <h2 class="text-center mb-4">Gestión de Combos</h2>

    <!-- Tabla de Lista de Productos -->
    <div class="mb-4">
        <h4>Lista de Productos</h4>
        <table class="table table-hover" id="tablaProductos">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $productoModel = new Combo();
            $productos = $productoModel->obtenerProductos();
            //$productos = $productoModel->obtenerProductoPorId($producto);
            foreach ($productos as $producto): ?>
                <tr class="seleccionar-producto" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= $producto['nombre_producto'] ?>">
                    <td><?= $producto['id_producto'] ?></td>
                    <td><?= $producto['nombre_producto'] ?></td>
                    <td><?= $producto['precio'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<form action="" method="post" id="formCombo">
    <!-- Tabla Combos -->
    <div class="mb-4">
        <h4>Combos</h4>
        <table class="table table-bordered" id="tablaCombo">
            <thead>
            <tr>
                <th>ID Combo</th>
                <th>Productos</th>
                <th>Precio del Combo</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $comboModel = new Combo();
            $combos = $comboModel->obtenerCombos();
            foreach ($combos as $combo): ?>
                <tr>
                    <td><?= $combo['id_combo'] ?></td>
                    <td><?= $combo['productos'] ?></td>
                    <td><?= $combo['precio_total'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mb-4 d-flex gap-2">
        <button class="btn btn-success"  id="crear_combo">Incluir a Combo</button>
        <button class="btn btn-danger" id="btnCancelar">Cancelar</button>
    </div>

    <!-- Modal para Crear Combo -->
    <div class="modal fade" id="modalCrearCombo" tabindex="-1">
        <div class="modal-dialog">
            <form id="formCrearCombo" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Combo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="productosSeleccionados"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnAgregarProducto">Agregar Producto</button>
                    <button type="submit" class="btn btn-success">Guardar Combo</button>
                </div>
            </form>
        </div>
    </div>
    

    <!-- Modal para Combo -->
    <div class="modal fade" id="modalSeleccionarProducto" tabindex="-1" aria-labelledby="modalComboLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalComboLabel">Seleccionar productos para Combo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!--Lista de productos del modal-->
                    <div class="mb-3">
                        <h5>Lista de Productos</h5>
                        <table class="table table-hover" id="tablaModalProductos">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $productoModel = new Combo();
                            $productos = $productoModel->obtenerProductos();
                            foreach ($productos as $producto): ?>
                                <tr class="seleccionar-producto-modal" data-id="<?= $producto['id_producto'] ?>" data-nombre="<?= $producto['nombre_producto'] ?>">
                                    <td><?= $producto['id_producto'] ?></td>
                                    <td><?= $producto['nombre_producto'] ?></td>
                                    <td><?= $producto['precio'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <hr>

                    <div>
                        <h5>Productos Seleccionados</h5>
                        <div id="listaSeleccionCombo">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnCrearCombo">Crear Combo</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
        
    </div><!--Hasta aqui-->
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Javascript/combos.js"></script>
</body>
</html>