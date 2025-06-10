<?php if ($_SESSION['rango'] == 'Administrador' || $_SESSION['rango'] == 'Almacenista' ) { ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos</title>
    <?php include 'header.php'; ?>
    <style>
.foto-producto {
    max-width: 80px;
    max-height: 80px;
    border-radius: 6px;
    border: 1px solid #ccc;
    padding: 5px;
    object-fit: contain;
    background: #fff;
}
.btn-accion {
  min-width: 130px;           /* Un poco más ancho para textos largos */
  max-width: 130px;
  height: 38px;               /* Altura fija para todos */
  padding: 0 .75rem;          /* Relleno horizontal uniforme */
  font-size: .95rem;          /* Texto consistente */
  line-height: 1.25;
  display: inline-flex;       /* Alinea icono + texto */
  align-items: center;        /* Centra verticalmente */
  justify-content: center;    /* Centra horizontalmente */
  gap: .4rem;                 /* Espacio icono-texto */
  border-radius: 6px;
  box-sizing: border-box;
  vertical-align: middle;
  text-align: center;
}
</style>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'NewNavBar.php'; ?>

<div class="formulario-responsivo">
  <div class="fondo-form">
    <form id="incluirProductoForm" action="" method="POST">
      <input type="hidden" name="accion" value="ingresar">
      <h3 class="titulo-form">📦 Incluir Nuevo Producto</h3>

      <!-- Nombre del producto -->
      <div class="envolver-form">
        <label for="nombre_producto">Nombre del producto</label>
        <input type="text" placeholder="Ej: Impresora Epson L3150" maxlength="15" class="form-control" id="nombre_producto" name="nombre_producto" required>
        <small class="form-text text-muted">Debe tener al menos 3 caracteres.</small>
      </div>
<div class="envolver-form">
  <label for="imagen">Imagen del producto</label>
  <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" required>
  <small class="form-text text-muted">Seleccione una imagen clara del producto (JPG, PNG, etc.).</small>
  <div id="previewImagen" style="margin-top: 10px;">
    <img id="imagenPreview" src="#" alt="Vista previa" style="display: none; max-height: 150px; border-radius: 8px; border: 1px solid #ccc; padding: 5px;">
  </div>
</div>
      <br>

      <!-- Descripción -->
      <div class="envolver-form">
        <label for="descripcion_producto">Descripción del producto</label>
        <textarea maxlength="50" class="form-control" id="descripcion_producto" name="descripcion_producto" rows="2" placeholder="Ej: Impresora multifuncional a color con WiFi"></textarea>
        <small class="form-text text-muted">Breve descripción (máx. 50 caracteres).</small>
      </div>
      <br>

      <!-- Modelo -->
      <div class="envolver-form">
        <label for="Modelo">Modelo</label>
        <select class="form-select" id="Modelo" name="Modelo" required>
          <option value="">Seleccione un modelo</option>
          <?php foreach ($modelos as $modelo): ?>
            <option value="<?= $modelo['tbl_modelos']; ?>">
              <?= $modelo['nombre_modelo'] . ' (' . $modelo['tbl_marcas'] . ')' ?>
            </option>
          <?php endforeach; ?>
        </select>
        <small class="form-text text-muted">Seleccione el modelo asociado al producto.</small>
      </div>
      <br>

      <!-- Stock -->
      <div class="envolver-form" style="display: flex; flex-wrap: wrap; gap: 1rem;">
        <div style="flex: 1;">
          <label for="Stock_Actual">Stock Actual</label>
          <input type="number" class="form-control" id="Stock_Actual" name="Stock_Actual" min="1" required placeholder="Ej: 10">
          <small class="form-text text-muted">Cantidad actualmente disponible.</small>
        </div>
        <div style="flex: 1;">
          <label for="Stock_Maximo">Stock Máximo</label>
          <input type="number" class="form-control" id="Stock_Maximo" name="Stock_Maximo" min="1" required placeholder="Ej: 100">
          <small class="form-text text-muted">Capacidad máxima en inventario.</small>
        </div>
        <div style="flex: 1;">
          <label for="Stock_Minimo">Stock Mínimo</label>
          <input type="number" class="form-control" id="Stock_Minimo" name="Stock_Minimo" min="1" required placeholder="Ej: 5">
          <small class="form-text text-muted">Cantidad mínima antes de alertar reposición.</small>
        </div>
      </div>
      <br>

      <!-- Garantía -->
      <div class="envolver-form">
        <label for="Clausula_garantia">Cláusula de garantía</label>
        <textarea class="form-control" maxlength="50" id="Clausula_garantia" name="Clausula_garantia" rows="2" placeholder="Ej: Garantía válida por 6 meses en defectos de fábrica."></textarea>
        <small class="form-text text-muted">Opcional. Especificar condiciones de garantía.</small>
      </div>
      <br>  

      <!-- Categoría -->
      <div class="envolver-form">
        <label for="Categoria">Categoría</label>
        <select class="form-select" id="Categoria" name="Categoria" required onchange="mostrarCamposCategoria(this.value)">
          <option value="">Seleccione una categoría</option>
          <option value="1">IMPRESORA</option>
          <option value="3">TINTA</option>
          <option value="4">CARTUCHO DE TINTA</option>
          <option value="2">PROTECTOR DE VOLTAJE</option>
          <option value="5">OTROS</option>
        </select>
        <small class="form-text text-muted">Según la categoría, se mostrarán campos adicionales.</small>
      </div>

      <!-- Campos dinámicos por categoría -->
      <div id="caracteristicasCategoria" class="envolver-form"></div>
      <br>

      <!-- Serial y Precio -->
      <div class="envolver-form" style="display: flex; gap: 1rem;">
        <div style="flex: 2;">
          <label for="Seriales">Código Serial</label>
          <input type="text" class="form-control" id="Seriales" name="Seriales" maxlength="10" placeholder="Ej: EPSON1234" required>
          <small class="form-text text-muted">Debe ser único y válido.</small>
        </div>
        <div style="flex: 1;">
          <label for="Precio">Precio ($)</label>
          <input class="form-control" id="Precio" name="Precio" min="1" step="1" placeholder="Ej: 100" required>
          <small class="form-text text-muted">Precio unitario del producto.</small>
        </div>
      </div>

      <!-- Botones -->
      <div class="envolver-form">
      <button class="boton-form" type="submit">Registrar Producto</button>
      <button class="boton-reset" type="reset">Limpiar Formulario</button>
      </div>
    </form>
  </div>
</div>


<div class="contenedor-tabla">
    <h3>Lista de Productos</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto del producto</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Stock Actual</th>
                <th>Stock Max<hr>Min</th>
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
                    <td>
                      <?php echo htmlspecialchars($producto['id_producto']); ?>
                    </td>
<td>
  <?php
    $id = $producto['id_producto'];
    $ruta_base = 'IMG/Productos/';
    $extensiones = ['png', 'jpg', 'jpeg', 'webp'];

    $ruta_imagen = '';
    foreach ($extensiones as $ext) {
        if (file_exists($ruta_base .'producto_'. $id . '.' . $ext)) {
            $ruta_imagen = $ruta_base .'producto_' . $id . '.' . $ext;
            break;
        }
    }

    if (!empty($ruta_imagen)) {
        echo '<img src="' . htmlspecialchars($ruta_imagen) . '" alt="Foto del producto" class="foto-producto">';
    } else {
        echo '<img src="IMG/no-disponible.png" alt="No disponible" class="foto-producto">';
    }
  ?>
</td>

                    <td>
                      <span class="campo-nombres">
                      <?php echo htmlspecialchars($producto['nombre_producto']); ?>
                      </span>
                      <span class="campo-correo">
                        <?php echo htmlspecialchars($producto['nombre_modelo']); ?>
                      </span>
                    </td>
                    <td>
                      <span class="campo-nombres">
                      <?php echo htmlspecialchars($producto['descripcion_producto']); ?>
                      </span>
                    </td>

                    <td>
                      <?php echo htmlspecialchars($producto['stock']); ?>
                    </td>
                    <td>
                      <span class="campo-nombres">
                      <?php echo htmlspecialchars($producto['stock_maximo']); ?>
                      </span>
                      <span><hr></span>
                      <span class="campo-nombres">
                      <?php echo htmlspecialchars($producto['stock_minimo']); ?>
                      </span>
                    </td>
                    <td>
                      <?php echo htmlspecialchars($producto['serial']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($producto['clausula_garantia']); ?></td>

                    <!-- AQUÍ cambia: mostramos el nombre de la categoría -->
                    <td>
                        <?php echo htmlspecialchars($producto['nombre_caracteristicas']); ?>
                    </td>

                    <td>
                      <span class="precio"><?php echo htmlspecialchars($producto['precio']); ?></span>
                     </span>
                        <span class="moneda">USD</span>
                
                    </td>
                                    <td>
                    <span class="campo-estatus <?php echo ($producto['estado'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                      onclick="cambiarEstatus(<?php echo $producto['id_producto']; ?>, '<?php echo $producto['estado']; ?>')"
                        style="cursor: pointer;">
                        <?php echo htmlspecialchars($producto['estado']); ?>
                    </span>
                </td>
<td>
    <?php
    $caracteristicas = $producto['caracteristicas'] ?? [];

    $atributosExtra = '';
    foreach ($caracteristicas as $clave => $valor) {
        $atributosExtra .= ' data-' . htmlspecialchars($clave) . '="' . htmlspecialchars($valor) . '"';
    }
    ?>

    <!-- Botón Modificar -->
    <button 
        type="button" 
        class="btn btn-sm btn-accion btn-primary me-2 btn-modificar" 
        data-bs-toggle="modal" 
        data-bs-target="#modificarProductoModal" 
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
        <?php
            $id = $producto['id_producto'];
            $ruta_base = 'IMG/Productos/';
            $extensiones = ['png', 'jpg', 'jpeg', 'webp'];
            $ruta_imagen = '';
            foreach ($extensiones as $ext) {
                if (file_exists($ruta_base .'producto_'. $id . '.' . $ext)) {
                    $ruta_imagen = $ruta_base .'producto_' . $id . '.' . $ext;
                    break;
                }
            }
            $data_imagen = !empty($ruta_imagen) ? $ruta_imagen : 'IMG/no-disponible.png';
            echo 'data-imagen="' . htmlspecialchars($data_imagen) . '"';
            echo $atributosExtra;
        ?>
    >
        <i class="bi bi-pencil-square"></i> Modificar
    </button>

    <!-- Botón Eliminar -->
    <button 
        type="button" 
        class="btn btn-sm btn-accion btn-danger eliminar" 
        data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>"
    >
        <i class="bi bi-trash"></i> Eliminar
    </button>
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
          <!-- Imagen actual y nueva -->
<div class="form-group">
  <label>Imagen actual</label><br>
  <img id="modificarImagenPreview" src="#" alt="Imagen actual" style="max-height: 120px; border-radius: 8px; border: 1px solid #ccc; padding: 5px;">
</div>
<div class="form-group">
  <label for="modificarImagen">Cambiar imagen</label>
  <input type="file" class="form-control" id="modificarImagen" name="imagen" accept="image/*">
  <small class="form-text text-muted">Seleccione una nueva imagen solo si desea reemplazar la actual.</small>
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
            <input  min="0" class="form-control" id="modificarPrecio" name="Precio" required>
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
        <input type="number" placeholder="Peso en kilogramos (ej. 2.5)" step="0.01" min="0" class="control-form" name="peso" value="${data.peso || ''}" required>
        <input type="number" placeholder="Alto en cm" min="0" class="control-form" name="alto" value="${data.alto || ''}" required>
        <input type="number" placeholder="Ancho en cm" min="0" class="control-form" name="ancho" value="${data.ancho || ''}" required>
        <input type="number" placeholder="Largo en cm" min="0" class="control-form" name="largo" value="${data.largo || ''}" required>
      `;
      break;

    case '2': // PROTECTOR DE VOLTAJE
      contenedor.innerHTML = `
        <input type="text" placeholder="Voltaje de entrada (ej. 120V)" class="control-form" name="voltaje_entrada" pattern="^\\d+(V|v)$" title="Ejemplo: 120V" value="${data.voltaje_entrada || ''}" required>
        <input type="text" placeholder="Voltaje de salida (ej. 110V)" class="control-form" name="voltaje_salida" pattern="^\\d+(V|v)$" title="Ejemplo: 110V" value="${data.voltaje_salida || ''}" required>
        <input type="number" placeholder="Cantidad de tomas" class="control-form" name="tomas" min="1" max="20" value="${data.tomas || ''}" required>
        <input type="number" placeholder="Capacidad en vatios (W)" class="control-form" name="capacidad" min="1" value="${data.capacidad || data.capacidad_bateria || ''}" required>
      `;
      break;

    case '3': // TINTA
      contenedor.innerHTML = `
        <input type="number" placeholder="Número de tinta" class="control-form" name="numero" min="0" value="${data.numero || ''}" required>
        <input type="text" placeholder="Color (ej. Magenta)" class="control-form" name="color" maxlength="20" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" title="Solo letras y espacios" value="${data.color || ''}" required>
        <input type="text" placeholder="Tipo de tinta (ej. Pigmentada)" class="control-form" name="tipo" maxlength="30" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" title="Solo letras y espacios" value="${data.tipo || ''}" required>
        <input type="number" placeholder="Volumen (ml)" class="control-form" name="volumen" min="1" max="1000" step="1" value="${data.volumen || ''}" required>
      `;
      break;

    case '4': // CARTUCHO DE TINTA
      contenedor.innerHTML = `
        <input type="number" placeholder="Número de cartucho" class="control-form" name="numero" min="0" value="${data.numero || ''}" required>
        <input type="text" placeholder="Color del cartucho" class="control-form" name="color" maxlength="20" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" title="Solo letras y espacios" value="${data.color || ''}" required>
        <input type="number" placeholder="Capacidad en ml" class="control-form" name="capacidad" min="1" max="1000" value="${data.capacidad || ''}" required>
      `;
      break;

    case '5': // OTROS
      contenedor.innerHTML = `
        <input type="text" placeholder="Descripción adicional del producto" class="control-form" name="descripcion_otros" maxlength="100" value="${data.descripcion_otros || ''}" required>
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

<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>