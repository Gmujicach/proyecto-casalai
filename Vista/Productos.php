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
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="Public/bootstrap/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="Styles/darckort.css">
  
</head>
<body>

<?php include 'NavBar.php'; ?>

<section class="container"> 
<div class="d-flex justify-content-center">
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
                        <label for="Nombre_P">Nombre del producto</label>
                        <input type="text" maxlength="15" class="form-control" id="Nombre_P" name="Nombre_P" required>
                        <span id="sNombre_P"></span>
                    </div>
                    <div class="form-group col">
                        <label for="Descripcion_P">Descripcion del producto</label>
                        <input type="text" maxlength="50" class="form-control" id="Descripcion_P" name="Descripcion_P" required>
                        <span id="sDescripcion_P"></span>
                    </div>
                    <div class="col">
                        <label for="Modelo">Modelo</label>
                        <select class="form-select" id="Modelo" name="Modelo">
                        <option value="">Seleccionar Modelo</option>
                        <?php foreach ($modelos as $modelo): ?>
                            <option value="<?php echo $modelo['id_modelo']; ?>"><?php echo $modelo['descripcion_mo']; ?></option>
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
    <div class="row">
        <div class="col-md-3">
            <label for="Peso">Peso</label>
            <input type="text" maxlength="6" class="form-control" id="Peso" name="Peso" required>
            <span id="sPeso"></span>
        </div>
        <div class="col-md-3">
            <label for="Largo">Largo</label>
            <input type="text" maxlength="6" class="form-control" id="Largo" name="Largo" required>
            <span id="sLargo"></span>
        </div>
        <div class="col-md-3">
            <label for="Alto">Alto</label>
            <input type="text" maxlength="6" class="form-control" id="Alto" name="Alto" required>
            <span id="sAlto"></span>
        </div>
        <div class="col-md-3">
            <label for="Ancho">Ancho</label>
            <input type="text" maxlength="6" class="form-control" id="Ancho" name="Ancho" required>
            <span id="sAncho"></span>
        </div>
    </div>

    <div class="form-group">
        <label for="Clausula_de_garantia">Clausula de garantia</label>
        <textarea class="form-control" maxlength="50" id="Clausula_de_garantia" name="Clausula_de_garantia" rows="3"></textarea>
        <span id="sClausula_de_garantia"></span>
    </div>


    <div class="row">
        <div class="col-md-4">
            <label for="Codigo_Interno">Codigo Interno</label>
            <input type="number" maxlength="10" class="form-control" id="Codigo_Interno" name="Codigo_Interno" required>
            <span id="sCodigo_Interno"></span>
        </div>
        <div class="col-md-4">
            <label for="Servicio">¿Tiene Servicio?</label>
            <select class="form-select" id="Servicio" name="Servicio">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="Categoria">Categorias</label>
            <select class="custom-select" id="Categoria" name="Categoria">
            <option value="CARTUCHO">CARTUCHO</option>
                                <option value="CABEZAL">CABEZAL</option>
                                <option value="CHIP">CHIP</option>
                                <option value="MOTOR">MOTOR</option>
                                <option value="FIXING FILM">FIXING FILM</option>
                                <option value="FIRMWARE">FIRMWARE</option>
                                <option value="TONER">TONER</option>
                                <option value="IMPRESORA">IMPRESORA</option>
                                <option value="TINTA">TINTA</option>
                                <option value="ESCANER">ESCANER</option>
                                <option value="PAPEL">PAPEL</option>
                                <option value="PROTECTOR">PROTECTOR</option>
                                <option value="CINTA">CINTA</option>
                                <option value="UNIDAD DE IMAGEN">UNIDAD DE IMAGEN</option>     
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="Seriales">¿Tiene Seriales?</label>
            <select class="form-select" id="Seriales" name="Seriales">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="Lote">¿Tiene Lote?</label>
            <select class="form-select" id="Lote" name="Lote">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
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
                    <td><?php echo htmlspecialchars($producto['nombre_p']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion_mo']); ?></td>
                    <td><?php echo htmlspecialchars($producto['codigo']); ?></td>
                    
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
                                    <option value="<?php echo $modelo['id_modelo']; ?>"><?php echo $modelo['descripcion_mo']; ?></option>
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
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="modificarPeso">Peso</label>
                            <input type="text" class="form-control" id="modificarPeso" name="Peso" required>
                            <span id="sPeso"></span>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="modificarLargo">Largo</label>
                            <input type="text" class="form-control" id="modificarLargo" name="Largo" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="modificarAlto">Alto</label>
                            <input type="text" class="form-control" id="modificarAlto" name="Alto" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="modificarAncho">Ancho</label>
                            <input type="text" class="form-control" id="modificarAncho" name="Ancho" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modificarClausulaGarantia">Clausula de garantia</label>
                        <textarea class="form-control" id="modificarClausulaGarantia" name="Clausula_de_garantia" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="modificarCodigoInterno">Código Interno</label>
                            <input type="number" class="form-control" id="modificarCodigoInterno" name="Codigo_Interno" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="modificarServicio">¿Tiene Servicio?</label>
                            <select class="custom-select" id="modificarServicio" name="Servicio">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                                    <label for="Categoria">Categorias</label>
                                    <select class="custom-select" id="Categoria" name="Categoria">
                                    <option value="CARTUCHO">CARTUCHO</option>
                                                        <option value="CABEZAL">CABEZAL</option>
                                                        <option value="CHIP">CHIP</option>
                                                        <option value="MOTOR">MOTOR</option>
                                                        <option value="FIXING FILM">FIXING FILM</option>
                                                        <option value="FIRMWARE">FIRMWARE</option>
                                                        <option value="TONER">TONER</option>
                                                        <option value="IMPRESORA">IMPRESORA</option>
                                                        <option value="TINTA">TINTA</option>
                                                        <option value="ESCANER">ESCANER</option>
                                                        <option value="PAPEL">PAPEL</option>
                                                        <option value="PROTECTOR">PROTECTOR</option>
                                                        <option value="CINTA">CINTA</option>
                                                        <option value="UNIDAD DE IMAGEN">UNIDAD DE IMAGEN</option>     
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