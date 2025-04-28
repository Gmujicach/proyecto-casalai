<?php
if (!isset($_SESSION['name'])) {

 	header('Location: .');
 	exit();
 }
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestionar Productos</title>
  
  <?php include 'header.php'; ?>
  
</head>
<body>

<?php include 'NewNavBar.php'; ?>

<section class="container"> 
<div class="">
        <button class="btn btn-primary btn-lg" style="width: 7cm;">Registrar Producto</button>
    <button class="btn btn-primary btn-lg" style="width: 7cm;">Listar Productos</button>
<button class="btn btn-primary btn-lg" style="width: 7cm;"><a href="?pagina=factura" style="text-decoration: none; color: inherit; /* Usa el color del texto del contenedor */
    background: none;">Generar Factura</a></button>
</div>

    <form id="incluirProductoForm" action="" method="POST" class="formulario-1" >
            <input type="hidden" name="accion" value="ingresar">
            <h3 class="display-4 text-center">INCLUIR PRODUCTOS</h3>
                <div class="row">
                    <div class="form-group col">
                        <label for="nombre_producto">Nombre del producto</label>
                        <input type="text" maxlength="15" class="form-control" id="nombre_producto" name="nombre_producto" required>
                        <span id="snombre_producto"></span>
                    </div>
                    <div class="form-group col">
                        <label for="descripcion_producto">Descripcion del producto</label>
                        <input type="text" maxlength="50" class="form-control" id="descripcion_producto" name="descripcion_producto" required>
                        <span id="sdescripcion_producto"></span>
                    </div>
                    <div class="col">
                        <label for="Modelo">Modelo</label>
                        <select class="form-select" id="Modelo" name="Modelo">
                        <option value="">Seleccionar Modelo</option>
                        <?php foreach ($modelos as $modelo): ?>
                            <option value="<?php echo $modelo['id_modelo']; ?>"><?php echo $modelo['nombre_modelo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

    <div class="row">
        
        <div class="row my-2">
            <div class="col" style="display:none">
                <label for="Stock_Actual">Stock Actual</label>
                <input type="text" class="form-control" value="0" id="Stock_Actual" name="Stock_Actual" required>
            </div>
            <div class="col">
                <label for="Stock_Maximo">Stock Maximo</label>
                <input type="text" maxlength="10" class="form-control" id="Stock_Maximo" name="Stock_Maximo" required>
                <span id="sStock_Maximo"></span>
            </div>
            <div class="col">
                <label for="Stock_Minimo">Stock Minimo</label>
                <input type="text" maxlength="10" class="form-control" id="Stock_Minimo" name="Stock_Minimo" required>
                <span id="sStock_Minimo"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="Clausula_de_garantia">Clausula de garantia</label>
        <textarea class="form-control" maxlength="50" id="Clausula_de_garantia" name="Clausula_de_garantia" rows="3"></textarea>
        <span id="sClausula_de_garantia"></span>
    </div>


    <div class="row">
        <div class="col-md-4">
            <label for="Seriales">Codigo Serial</label>
            <input type="text" maxlength="10" class="form-control" id="Seriales" name="Seriales" required>
            <span id="sSeriales"></span>
        </div>

        <div class="form-group col-md-4">
            <label for="Categoria">Categorias</label>
            <select class="custom-select" id="Categoria" name="Categoria">
                                <option value="impresora">IMPRESORA</option>
                                <option value="tinta">TINTA</option>
                                <option value="cartucho_tinta">CARTUCHO DE TINTA</option>
                                <option value="protector_voltaje">PROTECTOR DE VOLTAJE</option>
                                <option value="otros">OTROS</option>     
            </select>
        </div>
    </div>

        
    </div>
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
    </div>
</form>
    </div>


    <div class="table-container">
    <h1 class="titulo-tabla display-5 text-center">LISTA DE PRODUCTOS</h1>
    <table class="tabla">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Nombre del Producto</th>
                <th>Stock Actual</th>
                <th>Modelo</th>
                <th>Código</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td>
                        <!-- Botón Modificar que abre el modal -->
                        <button type="button" class="btn btn-modificar" data-toggle="modal" data-target="#modificarProductoModal" data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>">
    Modificar
</button>
                        <br>
                        <!-- Botón Eliminar -->
                        <a href="#" data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>" class="btn btn-eliminar">Eliminar</a>
                    </td>
                    <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre_modelo']); ?></td>
                    <td><?php echo htmlspecialchars($producto['serial']); ?></td>
                    
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
                    <div class="row">
                        <div class="col">
                            <button class="btn" name="" type="button" id="pdfproductos" name="pdfproductos"><a href="?pagina=pdfproductos">GENERAR REPORTE</a></button>
                        </div>
                    </div>
</div>

<!-- Modal de modificación -->
<div class="modal fade" id="modificarProductoModal" tabindex="-1" role="dialog" aria-labelledby="modificarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarProductoForm" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarProductoModalLabel">Modificar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campos del formulario de modificación -->
                    <input type="hidden" id="modificarIdProducto" name="id_producto">
                    <div class="form-group">
                        <label for="modificarNombreP">Nombre del producto</label>
                        <input type="text" class="form-control" id="modificarNombreP" name="Nombre_P" required>
                    </div>
                    <div class="form-group">
                        <label for="modificarDescripcionP">Descripción del producto</label>
                        <input type="text" class="form-control" id="modificarDescripcionP" name="Descripcion_P" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="modificarModelo">Modelo</label>
                            <select class="custom-select" id="modificarModelo" name="Modelo">
                                <option value="">Seleccionar Modelo</option>
                                <?php foreach ($modelos as $modelo): ?>
                                    <option value="<?php echo $modelo['id_modelo']; ?>"><?php echo $modelo['nombre_modelo']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="modificarStockActual">Stock Actual</label>
                            <input type="text" class="form-control" id="modificarStockActual" name="Stock_Actual" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="modificarStockMaximo">Stock Máximo</label>
                            <input type="text" class="form-control" id="modificarStockMaximo" name="Stock_Maximo" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="modificarStockMinimo">Stock Mínimo</label>
                            <input type="text" class="form-control" id="modificarStockMinimo" name="Stock_Minimo" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="modificarClausulaGarantia">Clausula de garantia</label>
                        <textarea class="form-control" id="modificarClausulaGarantia" name="Clausula_de_garantia" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="modificarCodigoInterno">Codigo Serial</label>
                            <input type="number" class="form-control" id="modificarCodigoInterno" name="Seriales" required>
                        </div>

                        <div class="form-group col-md-4">
                                    <label for="Categoria">Categorias</label>
                                    <select class="custom-select" id="Categoria" name="Categoria">
                                    <option value="impresora">IMPRESORA</option>
                                    <option value="tinta">TINTA</option>
                                    <option value="cartucho_tinta">CARTUCHO DE TINTA</option>
                                    <option value="protector_voltaje">PROTECTOR DE VOLTAJE</option>
                                    <option value="otros">OTROS</option>        
                                    </select>
                                </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="modificarSeriales">¿Tiene Seriales?</label>
                            <select class="custom-select" id="modificarSeriales" name="Seriales">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="modificarLote">¿Tiene Lote?</label>
                            <select class="custom-select" id="modificarLote" name="Lote">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="public/bootstrap/js/sidebar.js"></script>
  <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="public/js/jquery-3.7.1.min.js"></script>
  <script src="public/js/jquery.dataTables.min.js"></script>
  <script src="public/js/dataTables.bootstrap5.min.js"></script>
  <script src="public/js/datatable.js"></script>
  <script src="Javascript/sweetalert2.all.min.js"></script>
<script src="Javascript/Productos.js"></script>
<script src="Javascript/validaciones.js"></script>
</body>
</html>