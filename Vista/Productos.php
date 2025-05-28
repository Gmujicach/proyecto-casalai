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

      <div class="envolver-form">
        <input type="text" placeholder="Nombre del producto" maxlength="15" class="control-form" id="nombre_producto" name="nombre_producto" required>
        <span id="snombre_producto"></span>
      </div>
    <br>
      <div class="envolver-form">
        <label for="Descripcion_producto">Descripción del producto</label>
        <textarea maxlength="50" class="form-control" id="descripcion_producto" name="descripcion_producto" rows="3"></textarea>
        <span id="sdescripcion_producto"></span>
      </div>
    <br>
    <div class="grupo-form">
      <select class="form-select" id="Modelo" name="Modelo" required>
        <option value="">Seleccionar Modelo</option>
        <?php foreach ($modelos as $modelo): ?>
          <option value="<?php echo $modelo['tbl_modelos']; ?>"><?php echo ''.$modelo['nombre_modelo'].' ('.$modelo['tbl_marcas'].')'; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
      <div class="grupo-form">
        <input type="number" placeholder="Stock Actual" maxlength="10" class="control-form" value="0" id="Stock_Actual" name="Stock_Actual" required>
        <span id="sStock_Actual"></span>

        <input type="number" placeholder="Stock Máximo" maxlength="10" class="control-form" id="Stock_Maximo" name="Stock_Maximo" required>
        <span id="sStock_Maximo"></span>

        <input type="number" placeholder="Stock Mínimo" maxlength="10" class="control-form" min="0" id="Stock_Minimo" name="Stock_Minimo" required>
        <span id="sStock_Minimo"></span>
      </div>
    <br>
      <div class="envolver-form">
        <label for="Clausula_garantia">Cláusula de garantía</label>
        <textarea class="form-control" maxlength="50" id="Clausula_garantia" name="Clausula_garantia" rows="3"></textarea>
        <span id="sClausula_garantia"></span>
      </div>
    <br>
      <div class="grupo-form">
        <select class="form-select" id="Categoria" name="Categoria" required onchange="mostrarCamposCategoria(this.value)">
          <option value="">Seleccionar Categoría</option>
          <option value="1">IMPRESORA</option>
          <option value="3">TINTA</option>
          <option value="4">CARTUCHO DE TINTA</option>
          <option value="2">PROTECTOR DE VOLTAJE</option>
          <option value="5">OTROS</option>
        </select>
      </div>

      <!-- Campos adicionales dinámicos por categoría -->
      <div id="caracteristicasCategoria" class="grupo-form"></div>
    <br>
      <div class="grupo-form">
        <input type="text" placeholder="Código Serial" maxlength="10" class="control-form" id="Seriales" name="Seriales" required>
        <span id="sSeriales"></span>

        <input type="number" placeholder="Precio" maxlength="10" class="form-control" id="Precio" name="Precio" required>
        <span class="input-group-text">$</span>
        <span id="sPrecio"></span>
      </div>
      
      <button class="boton-form" type="submit">Registrar</button>
      <button class="boton-reset" type="reset">Reset</button>
    </form>
  </div>
</div>

<div class="contenedor-tabla">
    <h3>Lista de Productos</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>ID</th>
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
                <th>Estado</th>
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
                    <span class="campo-estatus <?php echo ($producto['estado'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                        onclick="cambiarEstatus(<?php echo $producto['id_producto']; ?>, '<?php echo $producto['estado']; ?>')"
                        style="cursor: pointer;">
                        <?php echo htmlspecialchars($producto['estado']); ?>
                    </span>
                </td>
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
<?php
$caracteristicas = $producto['caracteristicas'] ?? [];

$atributosExtra = '';
foreach ($caracteristicas as $clave => $valor) {
    $atributosExtra .= ' data-' . htmlspecialchars($clave) . '="' . htmlspecialchars($valor) . '"';
}
?>

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
    <?php echo $atributosExtra; ?>
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
<div class="modal fade modal-modificar" id="modificarProductoModal" tabindex="-1" role="dialog" aria-labelledby="modificarProductoModalLabel" aria-hidden="true">
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
                <option value="<?php echo $modelo['tbl_modelos']; ?>"><?php echo $modelo['nombre_modelo']; ?></option>
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
              <<select class="form-select" id="modificarCategoria" name="Categoria" required onchange="mostrarCamposCategoria(this.value, 'modificar')">
                <option value="">Seleccionar Categoría</option>
                <option value="1">IMPRESORA</option>
                <option value="3">TINTA</option>
                <option value="4">CARTUCHO DE TINTA</option>
                <option value="2">PROTECTOR DE VOLTAJE</option>
                <option value="5">OTROS</option>
              </select>
            </div>
          </div>
<div id="caracteristicasCategoriaModificar" class="form-row"></div>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="public/bootstrap/js/sidebar.js"></script>
  <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="public/js/jquery-3.7.1.min.js"></script>

  <script src="Javascript/sweetalert2.all.min.js"></script>
<script src="Javascript/Productos.js"></script>
<script src="Javascript/validaciones.js"></script>
<script>
function mostrarCamposCategoria(categoriaId, modo = 'crear', data = {}) {
  let contenedor;
  if (modo === 'crear') {
    contenedor = document.getElementById('caracteristicasCategoria');
  } else {
    contenedor = document.getElementById('caracteristicasCategoriaModificar');
  }

  contenedor.innerHTML = '';

  switch (categoriaId) {
    case '1': // IMPRESORA
      contenedor.innerHTML = `
        <input type="text" placeholder="Peso (kg)" class="control-form" name="peso" value="${data.peso || ''}">
        <input type="text" placeholder="Alto (cm)" class="control-form" name="alto" value="${data.alto || ''}">
        <input type="text" placeholder="Ancho (cm)" class="control-form" name="ancho" value="${data.ancho || ''}">
        <input type="text" placeholder="Largo (cm)" class="control-form" name="largo" value="${data.largo || ''}">
      `;
      break;

    case '2': // PROTECTOR DE VOLTAJE
      contenedor.innerHTML = `
        <input type="text" placeholder="Voltaje de entrada" class="control-form" name="voltaje_entrada" value="${data.voltaje_entrada || ''}">
        <input type="text" placeholder="Voltaje de salida" class="control-form" name="voltaje_salida" value="${data.voltaje_salida || ''}">
        <input type="number" placeholder="Cantidad de tomas" class="control-form" name="tomas" value="${data.tomas || ''}">
        <input type="number" placeholder="Capacidad (W)" class="control-form" name="capacidad" value="${data.capacidad_bateria || ''}">
      `;
      break;

    case '3': // TINTA
      contenedor.innerHTML = `
        <input type="number" placeholder="Número" class="control-form" name="numero" value="${data.numero || ''}">
        <input type="text" placeholder="Color" class="control-form" name="color" value="${data.color || ''}">
        <input type="text" placeholder="Tipo de tinta" class="control-form" name="tipo" value="${data.tipo || ''}">
        <input type="number" placeholder="Volumen (ml)" class="control-form" name="volumen" value="${data.volumen || ''}">
      `;
      break;

    case '4': // CARTUCHO DE TINTA
      contenedor.innerHTML = `
        <input type="number" placeholder="Número" class="control-form" name="numero" value="${data.numero || ''}">
        <input type="text" placeholder="Color" class="control-form" name="color" value="${data.color || ''}">
        <input type="number" placeholder="Capacidad (ml)" class="control-form" name="capacidad" value="${data.capacidad || ''}">
      `;
      break;

    case '5': // OTROS
      contenedor.innerHTML = `
        <input type="text" placeholder="Descripción adicional" class="control-form" name="descripcion_otros" value="${data.descripcion_otros || ''}">
      `;
      break;

    default:
      contenedor.innerHTML = '';
  }
}

</script>
<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>
<script>
$(document).ready(function() {
    $('#tablaConsultas').DataTable({
        language: {
            url: 'Public/js/es-ES.json'
        }
    });
});
</script>
</body>
</html>