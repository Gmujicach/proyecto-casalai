<?php if ($_SESSION['rango'] == 'Administrador' || $_SESSION['rango'] == 'Almacenista') { ?>

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
    </style>
  </head>

  <body class="fondo"
    style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <?php include 'NewNavBar.php'; ?>

    <div class="modal fade modal-registrar" id="registrarProductoModal" tabindex="-1" role="dialog"
      aria-labelledby="registrarProductoModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
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
                      $(document).ready(function() {
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

      <h3>Lista de Productos</h3>

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
            <tr>
              <td>
                <ul>
                  <div>
                    <?php
                    $caracteristicas = $producto['caracteristicas'] ?? [];

                    $atributosExtra = '';
                    foreach ($caracteristicas as $clave => $valor) {
                      $atributosExtra .= ' data-' . htmlspecialchars($clave) . '="' . htmlspecialchars($valor) . '"';
                    }
                    ?>
                    <button type="button" class="btn-modificar" data-toggle="modal" data-target="#modificarProductoModal"
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
                      data-precio="<?php echo htmlspecialchars($producto['precio']); ?>" <?php
                         // Lógica para la imagen igual que en la tabla
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
                         $data_imagen = !empty($ruta_imagen) ? $ruta_imagen : 'IMG/no-disponible.png';
                         echo 'data-imagen="' . htmlspecialchars($data_imagen) . '"';
                         echo $atributosExtra;
                         ?>>Modificar
                    </button>
                  </div>
                  <div>
                    <button data-id="<?php echo $producto['id_producto']; ?>" class="btn-eliminar">
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

    <div class="row">
      <div class="col">
        <button class="btn" name="" type="button" id="pdfproductos" name="pdfproductos"><a
            href="?pagina=pdfproductos">GENERAR REPORTE</a></button>
      </div>
    </div>
    </div>


    <!-- Modal de modificación -->
    <div class="modal fade modal-modificar" id="modificarProductoModal" tabindex="-1" role="dialog"
      aria-labelledby="modificarProductoModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
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

    <script src="public/bootstrap/js/sidebar.js"></script>
    <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/jquery-3.7.1.min.js"></script>
    <script src="Javascript/sweetalert2.all.min.js"></script>
    <script src="Javascript/Productos.js"></script>
    <script src="Javascript/validaciones.js"></script>
    <script src="public/js/jquery.dataTables.min.js"></script>
    <script src="public/js/dataTables.bootstrap5.min.js"></script>
    <script src="public/js/datatable.js"></script>
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
              input = `<input type="number" class="form-control" name="carac[${carac.nombre}]" placeholder="${carac.nombre}" ${carac.tipo === 'int' ? 'step="1"' : 'step="0.01"'} required>`;
            } else {
              input = `<input type="text" class="form-control" name="carac[${carac.nombre}]" maxlength="${carac.max}" placeholder="${carac.nombre}" required>`;
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
const categoriasDinamicas = <?php echo json_encode($categoriasDinamicas); ?>;
$(document).ready(function () {
    // Genera los campos dinámicos al cambiar la categoría en el modal de modificar
    $('#modificarCategoria').on('change', function () {
        const tabla = $(this).find(':selected').data('tabla');
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

    // Al abrir el modal de modificar, carga los datos del producto y sus características
$(document).on('click', '.btn-modificar', function () {
    // 1. Datos generales
    $('#modificarIdProducto').val($(this).data('id'));
    $('#modificarNombreProducto').val($(this).data('nombre'));
    $('#modificarDescripcionProducto').val($(this).data('descripcion'));
    $('#modificarModelo').val($(this).data('modelo'));
    $('#modificarStockActual').val($(this).data('stockactual'));
    $('#modificarStockMaximo').val($(this).data('stockmaximo'));
    $('#modificarStockMinimo').val($(this).data('stockminimo'));
    $('#modificarClausulaGarantia').val($(this).data('clausula'));
    $('#modificarSeriales').val($(this).data('seriales'));
    $('#modificarPrecio').val($(this).data('precio'));

    // 2. Categoría y tabla dinámica
    const tablaCategoria = $(this).data('tabla_categoria');
    $('#modificarCategoria').val(tablaCategoria).trigger('change');
    $('#modificar_tabla_categoria').val(tablaCategoria);

    // 3. Imagen
    const imagen = $(this).data('imagen');
    const preview = document.getElementById('modificarImagenPreview');
    preview.src = imagen;
    preview.style.display = 'block';
    document.getElementById('modificarImagen').value = '';
    document.getElementById('modificarImagen').onchange = function (event) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.src = imagen;
        }
    };

    // 4. Espera a que los campos dinámicos se generen y luego coloca los valores
    setTimeout(() => {
        const categoriaObj = categoriasDinamicas.find(cat => cat.tabla === tablaCategoria);
        if (categoriaObj) {
            categoriaObj.caracteristicas.forEach(carac => {
                const valor = $(this).data(carac.nombre);
                if (valor !== undefined) {
                    $(`#modificar_${carac.nombre}`).val(valor);
                }
            });
        }
    }, 200);

    $('#modificarProductoModal').modal('show');
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