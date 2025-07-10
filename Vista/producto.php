<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Almacenista' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')) { ?>

  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    </style>
    
  </head>

  <body class="fondo"
    style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <?php include 'newnavbar.php'; ?>

    <div class="modal fade modal-registrar" id="registrarProductoModal" tabindex="-1" role="dialog"
      aria-labelledby="registrarProductoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <?php if (!$mostrarFormulario): ?>
            <div class="alert alert-warning mt-4">
              Debe registrar una categoría antes de crear un producto.
            </div>
          <?php else: ?>
            <!-- Formulario de registro de producto -->
            <form id="incluirProductoForm" method="POST" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="titulo-form" id="registrarProductoModalLabel">Incluir Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="accion" value="ingresar">
                <div class="envolver-form">
                  <label for="nombre_producto">Nombre del producto</label>
                  <input type="text" placeholder="Ej: Impresora Epson L3150" maxlength="15" class="form-control"
                    id="nombre_producto" name="nombre_producto" required>
                  <small class="form-text text-muted">Debe tener al menos 3 caracteres.</small>
                </div>

                <div class="envolver-form">
                  <label for="imagen">Imagen del producto</label>
                  <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*" required>
                  <small class="form-text text-muted">Seleccione una imagen clara del producto (JPG, PNG, etc.).</small>
                  <div id="previewImagen" style="margin-top: 10px;">
                    <img id="imagenPreview" src="#" alt="Vista previa"
                      style="display: none; max-height: 150px; border-radius: 8px; border: 1px solid #ccc; padding: 5px;">
                  </div>
                </div>
                <br>
                <!-- Descripción -->
                <div class="envolver-form">
                  <label for="descripcion_producto">Descripción del producto</label>
                  <textarea maxlength="50" class="form-control" id="descripcion_producto" name="descripcion_producto"
                    rows="2" placeholder="Ej: Impresora multifuncional a color con WiFi"></textarea>
                  <small class="form-text text-muted">Breve descripción (máx. 50 caracteres).</small>
                </div>
                <br>
                <!-- modelo -->
                <div class="envolver-form">
                  <label for="modelo">modelo</label>
                  <select class="form-select" id="modelo" name="modelo" required>
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
                    <input type="number" class="form-control" id="Stock_Actual" name="Stock_Actual" min="1" required
                      placeholder="Ej: 10">
                    <small class="form-text text-muted">Cantidad actualmente disponible.</small>
                  </div>
                  <div style="flex: 1;">
                    <label for="Stock_Maximo">Stock Máximo</label>
                    <input type="number" class="form-control" id="Stock_Maximo" name="Stock_Maximo" min="1" required
                      placeholder="Ej: 100">
                    <small class="form-text text-muted">Capacidad máxima en inventario.</small>
                  </div>
                  <div style="flex: 1;">
                    <label for="Stock_Minimo">Stock Mínimo</label>
                    <input type="number" class="form-control" id="Stock_Minimo" name="Stock_Minimo" min="1" required
                      placeholder="Ej: 5">
                    <small class="form-text text-muted">Cantidad mínima antes de alertar reposición.</small>
                  </div>
                </div>
                <br>
                <!-- Garantía -->
                <div class="envolver-form">
                  <label for="Clausula_garantia">Cláusula de garantía</label>
                  <textarea class="form-control" maxlength="50" id="Clausula_garantia" name="Clausula_garantia" rows="2"
                    placeholder="Ej: Garantía válida por 6 meses en defectos de fábrica."></textarea>
                  <small class="form-text text-muted">Opcional. Especificar condiciones de garantía.</small>
                </div>
                <br>
                <!-- Categoría -->
                <div class="envolver-form">
                  <label for="Categoria">Categoría</label>
                  <select class="form-select" id="Categoria" name="Categoria" required>
                    <option value="">Seleccione una categoría</option>
                    <?php foreach ($categoriasDinamicas as $cat): ?>
                      
                      <option value="<?= $cat['tabla'] ?>" data-tabla="<?= $cat['tabla'] ?>">
                        <?= htmlspecialchars($cat['nombre_categoria']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <input type="hidden" id="tabla_categoria" name="tabla_categoria">
                <div id="caracteristicasCategoria"></div>
                <br>
                <!-- Serial y Precio -->
                <div class="envolver-form" style="display: flex; gap: 1rem;">
                  <div style="flex: 2;">
                    <label for="Seriales">Código Serial</label>
                    <input type="text" class="form-control" id="Seriales" name="Seriales" maxlength="10"
                      placeholder="Ej: EPSON1234" required>
                    <small class="form-text text-muted">Debe ser único y válido.</small>
                  </div>
                  <div style="flex: 1;">
                    <label for="Precio">Precio ($)</label>
                    <input class="form-control" id="Precio" name="Precio" min="1" step="1" placeholder="Ej: 100" required>
                    <small class="form-text text-muted">Precio unitario del producto.</small>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="boton-form" type="submit">Registrar</button>
                <button class="boton-reset" type="reset">Reset</button>
              </div>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="contenedor-tabla">
      <div class="space-btn-incluir">
        <button id="btnIncluirProducto" class="btn-incluir">
          Incluir Producto
        </button>
      </div>

      <h3>Listado de Productos</h3>

      <table class="tablaConsultas" id="tablaConsultas">
        <thead>
          <tr>
            <th>Acciones</th>
            <th>ID</th>
            <th>Foto del producto</th>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Stock Actual</th>
            <th>Stock Max
              <hr>Min
            </th>
            <th>Serial</th>
            <th>Cláusula de Garantía</th>
            <th>Categoría</th> <!-- CAMBIO: antes decía id_categoria -->
            <th>Precio</th>
            <th>Estado</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($productos as $producto): ?>
                            <?php
                $id = $producto['id_producto'];
                $ruta_base = 'IMG/Productos/';
                $extensiones = ['png', 'jpg', 'jpeg', 'webp'];

                $ruta_imagen = '';
                foreach ($extensiones as $ext) {
                  if (file_exists($ruta_base . 'producto_' . $id . '.' . $ext)) {
                    $ruta_imagen = $ruta_base . 'producto_' . $id . '.' . $ext;
                    break;
                  }
                }
                ?>
            <tr>
              <td>
                <ul>
                  <div>
<?php
$caracteristicas = $producto['caracteristicas'] ?? [];
$atributosExtra = '';
foreach ($caracteristicas as $clave => $valor) {
    if ($clave === 'id' || $clave === 'id_producto') continue; // omitir claves técnicas
    // camelCase para JS
    $claveCamel = preg_replace_callback('/_([a-z])/', function ($m) { return strtoupper($m[1]); }, strtolower($clave));
    $atributosExtra .= ' data-' . $claveCamel . '="' . htmlspecialchars($valor) . '"';
}
?>
<button type="button" class="btn-modificar"
    data-id="<?= htmlspecialchars($producto['id_producto']); ?>"
    data-nombre="<?= htmlspecialchars($producto['nombre_producto']); ?>"
    data-descripcion="<?= htmlspecialchars($producto['descripcion_producto']); ?>"
    data-modelo="<?= htmlspecialchars($producto['id_modelo']); ?>"
    data-stockactual="<?= htmlspecialchars($producto['stock']); ?>"
    data-stockmaximo="<?= htmlspecialchars($producto['stock_maximo']); ?>"
    data-stockminimo="<?= htmlspecialchars($producto['stock_minimo']); ?>"
    data-seriales="<?= htmlspecialchars($producto['serial']); ?>"
    data-clausula="<?= htmlspecialchars($producto['clausula_garantia']); ?>"
    data-categoria="<?= htmlspecialchars('cat_' . strtolower(str_replace(' ', '_', $producto['nombre_categoria']))); ?>"
    data-tabla_categoria="<?= htmlspecialchars('cat_' . strtolower(str_replace(' ', '_', $producto['nombre_categoria']))); ?>"
    data-precio="<?= htmlspecialchars($producto['precio']); ?>"
    data-imagen="<?= htmlspecialchars($ruta_imagen); ?>"
    <?= $atributosExtra; ?>
>Modificar</button>
                  </div>
                  <div>
                    <button data-id="<?php echo $producto['id_producto']; ?>" class="btn-eliminar eliminar">
                      Eliminar
                    </button>
                  </div>
                </ul>
              </td>
              <td>
                <?php echo htmlspecialchars($producto['id_producto']); ?>
              </td>
              <td>
<?php

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
                <span>
                  <hr>
                </span>
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
                <?php echo htmlspecialchars($producto['nombre_categoria']); ?>
              </td>

              <td>
                <span class="precio"><?php echo htmlspecialchars($producto['precio']); ?></span>
                </span>
                <span class="moneda">USD</span>

              </td>
              <td>
                <span
                  class="campo-estatus <?php echo ($producto['estado'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>"
                  onclick="cambiarEstatus(<?php echo $producto['id_producto']; ?>, '<?php echo $producto['estado']; ?>')"
                  style="cursor: pointer;">
                  <?php echo htmlspecialchars($producto['estado']); ?>
                </span>
              </td>

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>


    </div>


<div style="margin-top: 20px; text-align: right;">
  <form action="Controlador/reporteproducto.php" method="post" target="_blank" style="display:inline;">
    <button type="submit" class="btn btn-success">
      Descargar Reporte de Productos por Categoría
    </button>
  </form>
</div>

<div class="reporte-container" style="max-width: 1000px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
  <h3 style="text-align: center; margin-bottom: 20px; color:#1f66df;">Reporte de Productos por Categoría</h3>

  <div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: flex-start; gap: 40px;">
    <!-- Gráfica -->
    <div style="flex: 1; min-width: 300px; text-align: center;">
      <canvas id="graficoPastel" width="300" height="300"></canvas>
    </div>

    <!-- Tabla -->
    <div style="flex: 1; min-width: 300px;">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Categoría</th>
            <th>Cantidad</th>
            <th>Porcentaje (%)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($reporteCategorias)): ?>
            <?php foreach ($reporteCategorias as $cat): ?>
              <tr>
                <td><?= htmlspecialchars($cat['nombre_categoria']) ?></td>
                <td><?= $cat['cantidad'] ?></td>
                <td><?= $cat['porcentaje'] ?>%</td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="3" style="text-align:center;">No hay datos</td></tr>
          <?php endif; ?>
        </tbody>
        <tfoot>
          <tr>
            <th>Total</th>
            <th><?= $totalCategorias ?></th>
            <th>100%</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <div style="text-align:center; margin-top:30px;">
    <button id="descargarPDF" class="btn btn-success" style="padding:10px 24px; font-size:16px; border-radius:6px; background:#27ae60; color:#fff; border:none; cursor:pointer;">
      Descargar PDF
    </button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const labels = <?= json_encode(array_column($reporteCategorias ?? [], 'nombre_categoria')) ?>;
    const data = <?= json_encode(array_column($reporteCategorias ?? [], 'cantidad')) ?>;

    function generarColores(n) {
      const colores = [];
      for (let i = 0; i < n; i++) {
        const hue = Math.round((360 / n) * i);
        colores.push(`hsl(${hue}, 70%, 60%)`);
      }
      return colores;
    }

    const colores = generarColores(labels.length || 1);
    const ctx = document.getElementById('graficoPastel').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels.length ? labels : ['Sin datos'],
        datasets: [{
          data: data.length ? data : [1],
          backgroundColor: colores,
          borderColor: '#fff',
          borderWidth: 2
        }]
      },
      options: {
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          },
          title: {
            display: true,
            text: 'Distribución de Productos por Categoría'
          }
        }
      }
    });
  </script>
</div>
    <!-- Modal de modificación -->
    <div class="modal fade modal-modificar" id="modificarProductoModal" tabindex="-1" role="dialog"
      aria-labelledby="modificarProductoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <form id="modificarProductoForm" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="titulo-form" id="modificarProductoModalLabel">Modificar Producto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <input type="hidden" name="accion" value="modificar">
              <input type="hidden" id="modificarIdProducto" name="id_producto">
              <input type="hidden" id="modificar_tabla_categoria" name="tabla_categoria">

              <div class="form-group">
                <label for="modificarNombreProducto">Nombre del producto</label>
                <input type="text" maxlength="15" class="form-control" id="modificarNombreProducto" name="nombre_producto"
                  required>
              </div>
              <div class="form-group">
                <label>Imagen actual</label><br>
                <img id="modificarImagenPreview" src="#" alt="Imagen actual"
                  style="max-height: 120px; border-radius: 8px; border: 1px solid #ccc; padding: 5px;">
              </div>
              <div class="form-group">
                <label for="modificarImagen">Cambiar imagen</label>
                <input type="file" class="form-control" id="modificarImagen" name="imagen" accept="image/*">
                <small class="form-text text-muted">Seleccione una nueva imagen solo si desea reemplazar la
                  actual.</small>
              </div>
              <div class="form-group">
                <label for="modificarDescripcionProducto">Descripción del producto</label>
                <input type="text" maxlength="50" class="form-control" id="modificarDescripcionProducto"
                  name="descripcion_producto" required>
              </div>
              <div class="form-group">
                <label for="modificarModelo">modelo</label>
                <select class="form-select" id="modificarModelo" name="modelo" required>
                  <option value="">Seleccionar modelo</option>
                  <?php foreach ($modelos as $modelo): ?>
                    <option value="<?php echo $modelo['tbl_modelos']; ?>"><?php echo $modelo['nombre_modelo']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="modificarStockActual">Stock Actual</label>
                  <input type="number" min="0" class="form-control" id="modificarStockActual" name="Stock_Actual"
                    required>
                </div>
                <div class="form-group col-md-4">
                  <label for="modificarStockMaximo">Stock Máximo</label>
                  <input type="number" min="0" class="form-control" id="modificarStockMaximo" name="Stock_Maximo"
                    required>
                </div>
                <div class="form-group col-md-4">
                  <label for="modificarStockMinimo">Stock Mínimo</label>
                  <input type="number" min="0" class="form-control" id="modificarStockMinimo" name="Stock_Minimo"
                    required>
                </div>
              </div>
              <div class="form-group">
                <label for="modificarClausulaGarantia">Cláusula de Garantía</label>
                <textarea class="form-control" maxlength="50" id="modificarClausulaGarantia" name="Clausula_garantia"
                  rows="3"></textarea>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="modificarSeriales">Código Serial</label>
                  <input type="text" maxlength="10" class="form-control" id="modificarSeriales" name="Seriales" required>
                </div>
                <div class="form-group col-md-3">
                  <label for="modificarPrecio">Precio</label>
                  <input min="0" class="form-control" id="modificarPrecio" name="Precio" required>
                </div>
                <div class="form-group">
                  <label for="modificarCategoria">Categoría</label>
                  <select class="form-select" id="modificarCategoria" name="Categoria" required>
                    <option value="">Seleccionar Categoría</option>
                    <?php foreach ($categoriasDinamicas as $cat): ?>
<option value="<?= $cat['tabla'] ?>" data-tabla="<?= $cat['tabla'] ?>">
    <?= htmlspecialchars($cat['nombre_categoria']) ?>
</option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <input type="hidden" id="modificar_tabla_categoria" name="tabla_categoria">
                <div id="caracteristicasCategoriaModificar"></div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Modificar</button>
              </div>
          </form>
        </div>
      </div>
    </div>


        <div style="text-align:center; margin-top:20px;">
            <button id="descargarPDF" class="btn btn-success" style="padding:10px 24px; font-size:16px; border-radius:6px; background:#27ae60; color:#fff; border:none; cursor:pointer;">
                Descargar PDF
            </button>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
  document.getElementById('descargarPDF').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
      orientation: 'portrait',
      unit: 'pt',
      format: 'a4'
    });

    const reporte = document.querySelector('.reporte-container');
    html2canvas(reporte).then(canvas => {
      const imgData = canvas.toDataURL('image/png');
      const pageWidth = doc.internal.pageSize.getWidth();
      const imgWidth = pageWidth - 40;
      const imgHeight = canvas.height * imgWidth / canvas.width;

      doc.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
      doc.save('Reporte_Productos_Categorias.pdf');
    });
  });
</script>



    <script src="public/bootstrap/js/sidebar.js"></script>
    <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/jquery-3.7.1.min.js"></script>
    <script src="Javascript/sweetalert2.all.min.js"></script>
    <script src="Javascript/Productos.js"></script>
    <script src="Javascript/validaciones.js"></script>
    <script src="public/js/jquery.dataTables.min.js"></script>
    <script src="public/js/dataTables.bootstrap5.min.js"></script>
    <script src="public/js/datatable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
      $(document).ready(function () {
        $('#tablaConsultas').DataTable({
          language: {
            url: 'Public/js/es-ES.json'
          }
        });
      });

      const categoriasDinamicas = <?php echo json_encode($categoriasDinamicas); ?>;

      $('#Categoria').on('change', function () {
        const tabla = $(this).find(':selected').data('tabla');
        $('#tabla_categoria').val(tabla)
        const categoria = categoriasDinamicas.find(cat => cat.tabla === tabla);
        const contenedor = $('#caracteristicasCategoria');
        contenedor.empty();

        if (categoria) {
          categoria.caracteristicas.forEach(carac => {
            let input = '';
           if (carac.tipo === 'int' || carac.tipo === 'float') {
    if (carac.tipo === 'int') {
        input = `<input type="number" min="1" step="1" class="form-control" name="carac[${carac.nombre}]" placeholder="${carac.nombre}" required>`;
    } else {
        input = `<input type="number" min="0.01" step="0.01" class="form-control" name="carac[${carac.nombre}]" placeholder="${carac.nombre}" required>`;
    }
} else {
    input = `<input type="text" class="form-control" name="carac[${carac.nombre}]" maxlength="${carac.max}" placeholder="${carac.nombre}" oninput="soloTextoPermitido(event)"> required>`;
}
            contenedor.append(`<div class="mb-2"><label>${carac.nombre}</label>${input}</div>`);
          });
        }
      });

      $('#modificarCategoria').on('change', function () {
    const tabla = $(this).val();
    $('#modificar_tabla_categoria').val(tabla);
    const categoria = categoriasDinamicas.find(cat => cat.tabla === tabla);
    const contenedor = $('#caracteristicasCategoriaModificar');
    contenedor.empty();

    if (categoria) {
        categoria.caracteristicas.forEach(carac => {
            let input = '';
            if (carac.tipo === 'int' || carac.tipo === 'float') {
                input = `<input type="number" class="form-control" name="carac[${carac.nombre}]" id="modificar_${carac.nombre}" placeholder="${carac.nombre}" ${carac.tipo === 'int' ? 'step="1"' : 'step="0.01"'} required>`;
            } else {
                input = `<input type="text" class="form-control" name="carac[${carac.nombre}]" id="modificar_${carac.nombre}" maxlength="${carac.max}" placeholder="${carac.nombre}" required>`;
            }
            contenedor.append(`<div class="mb-2 col-md-6"><label>${carac.nombre}</label>${input}</div>`);
        });
    }
});
    </script>
    
    <script>

$(document).ready(function () {
    // Genera los campos dinámicos al cambiar la categoría en el modal de modificar
$('#modificarCategoria').on('change', function () {
    const tabla = $(this).val();
    $('#modificar_tabla_categoria').val(tabla);
    const categoria = categoriasDinamicas.find(cat => cat.tabla === tabla);
    const contenedor = $('#caracteristicasCategoriaModificar');
    contenedor.empty();

    if (categoria) {
categoria.caracteristicas.forEach(carac => {
    let input = '';
if (carac.tipo === 'int' || carac.tipo === 'float') {
    if (carac.tipo === 'int') {
        input = `<input type="number" min="1" step="1" class="form-control" name="carac[${carac.nombre}]" id="modificar_${carac.nombre}" placeholder="${carac.nombre}" required>`;
    } else {
        input = `<input type="number" min="0.01" step="0.01" class="form-control" name="carac[${carac.nombre}]" id="modificar_${carac.nombre}" placeholder="${carac.nombre}" required>`;
    }
} else {
    input = `<input type="text" class="form-control" name="carac[${carac.nombre}]" id="modificar_${carac.nombre}" maxlength="${carac.max}" placeholder="${carac.nombre}" required>`;
}
    contenedor.append(`<div class="mb-2 col-md-6"><label>${carac.nombre}</label>${input}</div>`);
});
    }
});
});

    </script>
<script>
  document.getElementById('descargarPDF').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
      orientation: 'portrait',
      unit: 'pt',
      format: 'a4'
    });

    const reporte = document.querySelector('.reporte-container');
    html2canvas(reporte).then(canvas => {
      const imgData = canvas.toDataURL('image/png');
      const pageWidth = doc.internal.pageSize.getWidth();
      const pageHeight = doc.internal.pageSize.getHeight();
      const imgWidth = pageWidth - 40;
      const imgHeight = canvas.height * imgWidth / canvas.width;

      let y = 20;
      if (imgHeight > pageHeight) {
        const pages = Math.ceil(imgHeight / pageHeight);
        for (let i = 0; i < pages; i++) {
          if (i > 0) doc.addPage();
          doc.addImage(imgData, 'PNG', 20, y - i * pageHeight, imgWidth, imgHeight);
        }
      } else {
        doc.addImage(imgData, 'PNG', 20, y, imgWidth, imgHeight);
      }

      doc.save('Reporte_Productos_Categorias.pdf');
    });
  });
</script>

<!-- ...otros scripts... -->

<?php if (!empty($reporteCategorias) && $totalCategorias > 0): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const labels = <?= json_encode(array_column($reporteCategorias, 'nombre_categoria')) ?>;
    const data = <?= json_encode(array_column($reporteCategorias, 'cantidad')) ?>;
    function generarColores(n) {
      const colores = [];
      for (let i = 0; i < n; i++) {
        const hue = Math.round((360 / n) * i);
        colores.push(`hsl(${hue}, 70%, 60%)`);
      }
      return colores;
    }
    const colores = generarColores(labels.length);
    const ctx = document.getElementById('graficoPastel').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: colores,
          borderColor: '#fff',
          borderWidth: 2
        }]
      },
      options: {
        plugins: {
          legend: { display: true, position: 'bottom' },
          title: { display: true, text: 'Distribución de Productos por Categoría' }
        }
      }
    });
  });
</script>
<?php endif; ?>
  </body>

  </html>

  <?php
} else {
  header("Location: ?pagina=acceso-denegado");
  exit;
}
?>