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

<div class="formulario-responsivo">
  <div class="fondo-form">
    <form id="incluirProductoForm" action="" method="POST">
        <input type="hidden" name="accion" value="ingresar">
        <h3 class="titulo-form">INCLUIR PRODUCTOS</h3>

        <div class="grupo-form">
            <input type="text" placeholder="Nombre del producto" maxlength="15" class="control-form" id="nombre_producto" name="nombre_producto" required>
            <span id="snombre_producto"></span>

            <input type="text" placeholder="Descripción del producto" maxlength="50" class="control-form" id="descripcion_producto" name="descripcion_producto" required>
            <span id="sdescripcion_producto"></span>
        </div>
    <br>
        <select class="form-select" id="Modelo" name="Modelo" required>
            <option value="">Seleccionar Modelo</option>
            <?php foreach ($modelos as $modelo): ?>
                <option value="<?php echo $modelo['id_modelo']; ?>"><?php echo $modelo['nombre_modelo']; ?></option>
            <?php endforeach; ?>
        </select>
    <br>
        <div class="envolver-form">
            <label for="Stock_Actual">Stock Actual</label>
            <input type="text" class="form-control" value="0" id="Stock_Actual" name="Stock_Actual" required>
        </div>

        <div class="grupo-form">
            <input type="text" placeholder="Stock Máximo" maxlength="10" class="control-form" id="Stock_Maximo" name="Stock_Maximo" required>
            <span id="sStock_Maximo"></span>
        
            <input type="text" placeholder="Stock Mínimo" maxlength="10" class="control-form" id="Stock_Minimo" name="Stock_Minimo" required>
            <span id="sStock_Minimo"></span>
        </div>
    <br>
        <div class="form-group">
            <label for="Clausula_garantia">Cláusula de garantía</label>
            <textarea class="form-control" maxlength="50" id="Clausula_garantia" name="Clausula_garantia" rows="3"></textarea>
            <span id="sClausula_garantia"></span>
        </div>
    <br>
        <div class="grupo-form">
            <input type="text" placeholder="Código Serial" maxlength="10" class="control-form" id="Seriales" name="Seriales" required>
            <span id="sSeriales"></span>
        
            <select class="form-select" id="Categoria" name="Categoria" required>
                <option value="">Seleccionar Categoría</option>
                <option value="1">IMPRESORA</option>
                <option value="3">TINTA</option>
                <option value="4">CARTUCHO DE TINTA</option>
                <option value="2">PROTECTOR DE VOLTAJE</option>
                <option value="5">OTROS</option>     
            </select>
        </div>

        <!-- Campo faltante de PRECIO -->
        <div class="envolver-form">
            <input type="text" placeholder="Precio" maxlength="10" class="control-form" id="Precio" name="Precio" required>
            <span id="sPrecio"></span>
        </div>

        <button class="boton-form" type="submit">Registrar</button>
        <button class="boton-reset" type="reset">Reset</button>
    </form>
  </div>
</div>


<div class="contenedor-tabla">
    <h3>Lista de Productos</h3>
    <table class="tabla"class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Id Producto</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Modelo</th> <!-- CAMBIO: antes decía id_modelo -->
                <th>Stock Actual</th>
                <th>Stock Máximo</th>
                <th>Stock Mínimo</th>
                <th>Serial</th>
                <th>Cláusula de Garantía</th>
                <th>Categoría</th> <!-- CAMBIO: antes decía id_categoria -->
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion_producto']); ?></td>

                    <!-- AQUÍ cambia: mostramos el nombre del modelo -->
                    <td>
                        <?php echo htmlspecialchars($producto['nombre_modelo']); ?>
                    </td>

                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock_maximo']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock_minimo']); ?></td>
                    <td><?php echo htmlspecialchars($producto['serial']); ?></td>
                    <td><?php echo htmlspecialchars($producto['clausula_garantia']); ?></td>

                    <!-- AQUÍ cambia: mostramos el nombre de la categoría -->
                    <td>
                        <?php echo htmlspecialchars($producto['nombre_caracteristicas']); ?>
                    </td>

                    <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                    
                    <td>
                        <span>
                            <div class="acciones-boton">
                                <i class="vertical">
                                    <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                                </i>
                                <div class="desplegable">
                                    <ul>
                                        <li>
                                            <!-- Botón Modificar -->
                                            <button 
                                                type="button" 
                                                class="btn btn-modificar" 
                                                data-toggle="modal" 
                                                data-target="#modificarProductoModal" 
                                                data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>"
                                                data-nombre="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"
                                                data-descripcion="<?php echo htmlspecialchars($producto['descripcion_producto']); ?>"
                                                data-modelo="<?php echo htmlspecialchars($producto['id_modelo']); ?>"
                                                data-stockactual="<?php echo htmlspecialchars($producto['stock']); ?>"
                                                data-stockmaximo="<?php echo htmlspecialchars($producto['stock_maximo']); ?>"
                                                data-stockminimo="<?php echo htmlspecialchars($producto['stock_minimo']); ?>"
                                                data-seriales="<?php echo htmlspecialchars($producto['serial']); ?>"
                                                data-clausula="<?php echo htmlspecialchars($producto['clausula_garantia']); ?>"
                                                data-categoria="<?php echo htmlspecialchars($producto['id_categoria']); ?>"
                                                data-precio="<?php echo htmlspecialchars($producto['precio']); ?>"
                                            >
                                                Modificar
                                            </button>
                                        </li>
                                        <li>
                                            <!-- Botón Eliminar -->
                                            <a href="#" 
                                                data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>" 
                                                class="btn btn-eliminar"
                                            >
                                                Eliminar
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

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

          <!-- Acciones ocultas -->
          <input type="hidden" name="accion" value="modificar">
          <input type="hidden" id="modificarIdProducto" name="id_producto">

          <!-- Campos -->
          <div class="form-group">
            <label for="modificarNombreProducto">Nombre del producto</label>
            <input type="text" maxlength="15" class="form-control" id="modificarNombreProducto" name="nombre_producto" required>
          </div>

          <div class="form-group">
            <label for="modificarDescripcionProducto">Descripción del producto</label>
            <input type="text" maxlength="50" class="form-control" id="modificarDescripcionProducto" name="descripcion_producto" required>
          </div>

          <div class="form-group">
            <label for="modificarModelo">Modelo</label>
            <select class="form-select" id="modificarModelo" name="Modelo" required>
              <option value="">Seleccionar Modelo</option>
              <?php foreach ($modelos as $modelo): ?>
                <option value="<?php echo $modelo['id_modelo']; ?>"><?php echo $modelo['nombre_modelo']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="modificarStockActual">Stock Actual</label>
              <input type="number" min="0" class="form-control" id="modificarStockActual" name="Stock_Actual" required>
            </div>
            <div class="form-group col-md-4">
              <label for="modificarStockMaximo">Stock Máximo</label>
              <input type="number" min="0" class="form-control" id="modificarStockMaximo" name="Stock_Maximo" required>
            </div>
            <div class="form-group col-md-4">
              <label for="modificarStockMinimo">Stock Mínimo</label>
              <input type="number" min="0" class="form-control" id="modificarStockMinimo" name="Stock_Minimo" required>
            </div>
          </div>

          <div class="form-group">
            <label for="modificarClausulaGarantia">Cláusula de Garantía</label>
            <textarea class="form-control" maxlength="50" id="modificarClausulaGarantia" name="Clausula_garantia" rows="3"></textarea>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="modificarSeriales">Código Serial</label>
              <input type="text" maxlength="10" class="form-control" id="modificarSeriales" name="Seriales" required>
            </div>
            <div class="form-group col-md-4">
            <label for="modificarPrecio">Precio</label>
            <input type="number" min="0" class="form-control" id="modificarPrecio" name="Precio" required>
            </div>

            <div class="form-group col-md-4">
              <label for="modificarCategoria">Categoría</label>
              <select class="form-select" id="modificarCategoria" name="Categoria" required>
                <option value="">Seleccionar Categoría</option>
                <option value="1">IMPRESORA</option>
                <option value="3">TINTA</option>
                <option value="4">CARTUCHO DE TINTA</option>
                <option value="2">PROTECTOR DE VOLTAJE</option>
                <option value="5">OTROS</option>
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
<script>
document.getElementById('incluirProductoForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe inmediatamente

    // Crear un objeto FormData para capturar los datos
    var formData = new FormData(this);

    // Preparar el mensaje
    var mensaje = "Datos enviados:\n\n";
    formData.forEach(function(valor, clave) {
        mensaje += clave + ": " + valor + "\n";
    });

    // Mostrar todos los datos en un alert
    alert(mensaje);

    // Opcional: después del alert, puedes enviar realmente el formulario
    // this.submit();
});
</script>

</body>
</html>