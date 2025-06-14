<?php if ($_SESSION['rango'] == 'Administrador') { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <title>Gestionar Proveedores</title>
</head>

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'NewNavBar.php'; ?>

<div class="modal fade modal-registrar" id="registrarProveedorModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarProveedorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="incluirproveedor" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarProveedorModalLabel">Incluir Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="grupo-form">
                        <input type="text" placeholder="Nombre Proveedor" class="control-form" id="nombre_proveedor" name="nombre_proveedor" required>
                        <span id="snombre_proveedor"></span>

                        <input type="text" placeholder="R.I.F del Proveedor" class="control-form" id="rif_proveedor" name="rif_proveedor" required>
                        <span id="srif_proveedor"></span>
                    </div>

                    <div class="grupo-form">
                        <input type="text" placeholder="Nombre Representante" class="control-form" id="nombre_representante" name="nombre_representante" required>
                        <span id="snombre_representante"></span>

                        <input type="text" placeholder="R.I.F del Representante" class="control-form" id="rif_representante" name="rif_representante" required>
                        <span id="srif_representante"></span>
                    </div>

                    <div class="envolver-form">
                        <input type="text" placeholder="Correo" class="control-form" id="correo_proveedor" name="correo_proveedor" required>
                        <span id="scorreo_proveedor"></span>
                    </div>

                    <div class="envolver-form">
                        <input type="text" placeholder="Direccion" class="control-form" id="direccion_proveedor" name="direccion_proveedor" required>
                        <span id="sdireccion_proveedor"></span>
                    </div>

                    <div class="grupo-form">
                        <input type="text" placeholder="Telefono Principal" class="control-form" id="telefono_1" name="telefono_1" required>
                        <span id="stelefono_1"></span>

                        <input type="text" placeholder="Telefono Secundario" class="control-form" id="telefono_2" name="telefono_2" required>
                        <span id="stelefono_2"></span>
                    </div>

                    <div class="envolver-form">
                        <textarea class="control-form" maxlength="50" id="observacion" name="observacion" rows="3" placeholder="Escriba alguna observación que se deba tener en cuenta"></textarea>
                        <span id="sobservacion"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="boton-form" type="submit">Registrar</button>
                    <button class="boton-reset" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="contenedor-tabla">
    <div class="space-btn-incluir">
        <button id="btnIncluirProveedor" class="btn-incluir">
            Incluir Proveedor
        </button>
    </div>
    <h3>LISTA DE PROVEEDORES</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                
                <th>Acciones</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>R.I.F</th>
                <th>Telefono</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($proveedores as $proveedor): ?>
            <tr data-id="<?php echo $proveedor['id_proveedor']; ?>">
                <td>
                    <ul>
                        <div>
                            <button class="btn-modificar" 
                                data-id="<?php echo $proveedor['id_proveedor']; ?>"
                                data-nombre="<?php echo htmlspecialchars($proveedor['nombre']); ?>"
                                data-persona-contacto="<?php echo htmlspecialchars($proveedor['presona_contacto']); ?>"
                                data-direccion="<?php echo htmlspecialchars($proveedor['direccion']); ?>"
                                data-telefono="<?php echo htmlspecialchars($proveedor['telefono']); ?>"
                                data-correo="<?php echo htmlspecialchars($proveedor['correo']); ?>"
                                data-telefono-secundario="<?php echo htmlspecialchars($proveedor['telefono_secundario']); ?>"
                                data-rif-proveedor="<?php echo htmlspecialchars($proveedor['rif_proveedor']); ?>"
                                data-rif-representante="<?php echo htmlspecialchars($proveedor['rif_representante']); ?>"
                                data-observaciones="<?php echo htmlspecialchars($proveedor['observaciones']); ?>"
                                >Modificar
                            </button>
                        </div>
                        <div>
                              <button class="btn-eliminar" 
                              data-id="<?php echo $proveedor['id_proveedor']; ?>">Eliminar</button>
                        </div>
                    </ul>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['nombre']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-correo">
                    <?php echo htmlspecialchars($proveedor['correo']); ?>
                    </span>
                </td> 
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['rif_proveedor']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-telefono">
                    <?php echo htmlspecialchars($proveedor['telefono']); ?>
                    </span>
                </td>
                <td class="campo-estado">
                    <span 
                      class="campo-estatus <?php echo ($proveedor['estado'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                      data-id="<?php echo $proveedor['id_proveedor']; ?>"
                      onclick="cambiarEstatus(<?php echo $proveedor['id_proveedor']; ?>, '<?php echo $proveedor['estado']; ?>')"
                      style="cursor: pointer;">
                      <?php echo htmlspecialchars($proveedor['estado']); ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="contenedor-tabla">
    <h3>Lista de Productos Con Bajo Stock</h3>
    <table class="tabla"class="tablaConsultas" id="">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Modelo</th>
                <th>Stock Actual</th>
                <th>Stock Mínimo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre_modelo']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                    <td><?php echo htmlspecialchars($producto['stock_minimo']); ?></td>            
                    <td>
                        <ul>
                            <div>
                                <button 
                                    type="button" 
                                    class="btn-modificar" 
                                    id="modificarProductoBtn"
                                    data-toggle="modal" 
                                    data-target="#modificarProductoModal" 
                                    data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>"
                                    data-nombre="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"
                                    data-modelo="<?php echo htmlspecialchars($producto['nombre_modelo']); ?>"
                                    data-stockactual="<?php echo htmlspecialchars($producto['stock']); ?>"
                                    data-stockminimo="<?php echo htmlspecialchars($producto['stock_minimo']); ?>"
                                >Realizar Pedido
                                </button>
                            </div>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modificarProductoModal" tabindex="-1" role="dialog" aria-labelledby="modificarProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="modificarProductoForm" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="titulo-form" id="modificarProductoModalLabel">Realizar Pedido</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="accion" value="realizar_pedido">
          <input type="hidden" id="modificarIdProducto" name="id_producto">

          <div class="form-group">
            <label for="modificarNombreProducto">Nombre del producto</label>
            <input type="text" maxlength="50" class="form-control" id="modificarNombreProducto" name="nombre_producto" readonly>
          </div>

          <div class="form-group">
            <label for="modificarModelo">Modelo</label>
            <input type="text" maxlength="50" class="form-control" id="modificarModelo" name="modelo" readonly>
          </div>

          <div class="form-group">
            <label for="Proveedor">Proveedor</label>
            <select class="form-select" id="Proveedor" name="proveedor" required>
              <option value="">Seleccionar Proveedor</option>
              <option value="<?php echo $proveedor['id_proveedor']; ?>">
                <?php echo $proveedor['nombre']; ?>
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="modificarStockMinimo">Cantidad a Pedir</label>
            <input type="number" min="1" class="form-control" id="modificarStockMinimo" name="cantidad_pedir" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modificar_usuario_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_usuario_modal_label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="modificarProveedorForm" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modificar_usuario_modal_label">Modificar Proveedor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="modificar_id_proveedor" name="id_proveedor">
          <input type="hidden" name="accion" value="modificar">

          <div class="form-group">
            <label for="modificar_nombre_proveedor">Nombre del Proveedor</label>
            <input type="text" class="form-control" id="modificar_nombre_proveedor" name="nombre" required>
          </div>

          <div class="form-group">
            <label for="modificar_persona_contacto">Persona de Contacto</label>
            <input type="text" class="form-control" id="modificar_persona_contacto" name="persona_contacto" required>
          </div>

          <div class="form-group">
            <label for="modificar_direccion">Dirección</label>
            <input type="text" class="form-control" id="modificar_direccion" name="direccion" required>
          </div>

          <div class="form-group">
            <label for="modificar_telefono">Teléfono</label>
            <input type="text" class="form-control" id="modificar_telefono" name="telefono" required>
          </div>

          <div class="form-group">
            <label for="modificar_correo">Correo</label>
            <input type="email" class="form-control" id="modificar_correo" name="correo" required>
          </div>

          <div class="form-group">
            <label for="modificar_telefono_secundario">Teléfono Secundario</label>
            <input type="text" class="form-control" id="modificar_telefono_secundario" name="telefono_secundario">
          </div>

          <div class="form-group">
            <label for="modificar_rif_proveedor">RIF del Proveedor</label>
            <input type="text" class="form-control" id="modificar_rif_proveedor" name="rif_proveedor">
          </div>

          <div class="form-group">
            <label for="modificar_rif_representante">RIF del Representante</label>
            <input type="text" class="form-control" id="modificar_rif_representante" name="rif_representante">
          </div>

          <div class="form-group">
            <label for="modificar_observaciones">Observaciones</label>
            <textarea class="form-control" id="modificar_observaciones" name="observaciones" rows="3"></textarea>
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


  <?php include 'footer.php'; ?>
  <script src="Javascript/proveedor.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Escuchar el clic en cualquier botón con clase "modificar"
    document.querySelectorAll('.modificar').forEach(button => {
        button.addEventListener('click', function () {
            // Obtener los datos del botón
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const modelo = this.dataset.modelo;
            const stockactual = this.dataset.stockactual;
            const stockminimo = this.dataset.stockminimo;

            // Llenar los campos del modal
            document.getElementById('modal-id').value = id;
            document.getElementById('modal-nombre').value = nombre;
            document.getElementById('modal-modelo').value = modelo;
            document.getElementById('modal-stockminimo').value = stockminimo;
        });
    });
});
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