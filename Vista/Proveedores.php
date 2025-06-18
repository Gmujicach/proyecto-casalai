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
                        <input type="text" placeholder="Nombre Proveedor" class="control-form" id="nombre_proveedor" name="nombre_proveedor" maxlength="50" required>
                        <span class="span-value" id="snombre_proveedor"></span>

                        <input type="text" placeholder="RIF del Proveedor" class="control-form" id="rif_proveedor" name="rif_proveedor" maxlength="12" required>
                        <span class="span-value" id="srif_proveedor"></span>
                    </div>

                    <div class="grupo-form">
                        <input type="text" placeholder="Nombre Representante" class="control-form" id="nombre_representante" name="nombre_representante" maxlength="50" required>
                        <span class="span-value" id="snombre_representante"></span>

                        <input type="text" placeholder="RIF del Representante" class="control-form" id="rif_representante" name="rif_representante" maxlength="12" required>
                        <span class="span-value" id="srif_representante"></span>
                    </div>

                    <div class="envolver-form">
                        <input type="text" placeholder="Correo" class="control-form" id="correo_proveedor" name="correo_proveedor" maxlength="50" required>
                        <span class="span-value" id="scorreo_proveedor"></span>
                    </div>

                    <div class="envolver-form">
                        <input type="text" placeholder="Direccion" class="control-form" id="direccion_proveedor" name="direccion_proveedor" maxlength="100" required>
                        <span class="span-value" id="sdireccion_proveedor"></span>
                    </div>

                    <div class="grupo-form">
                        <input type="text" placeholder="Telefono Principal" class="control-form" id="telefono_1" name="telefono_1" maxlength="13" required>
                        <span class="span-value" id="stelefono_1"></span>

                        <input type="text" placeholder="Telefono Secundario" class="control-form" id="telefono_2" name="telefono_2" maxlength="13" required>
                        <span class="span-value" id="stelefono_2"></span>
                    </div>

                    <div class="envolver-form">
                        <textarea class="control-form" id="observacion" name="observacion" maxlength="100" rows="3" placeholder="Escriba alguna observación que se deba tener en cuenta"></textarea>
                        <span class="span-value" id="sobservacion"></span>
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
                <th>Nombre del Proveedor</th>
                <th>RIF del Proveedor</th>
                <th>Nombre del Proveedor</th>
                <th>RIF del Representante</th>
                <th>Correo del Proveedor</th>
                <th>Dirección del Proveedor</th>
                <th>Teléfono Principal</th>
                <th>Teléfono Secundario</th>
                <th>Observación</th>
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
                                id="ModificarProveedor"
                                data-id="<?php echo $proveedor['id_proveedor']; ?>"
                                data-nombre-proveedor="<?php echo htmlspecialchars($proveedor['nombre_proveedor']); ?>"
                                data-rif-proveedor="<?php echo htmlspecialchars($proveedor['rif_proveedor']); ?>"
                                data-nombre-representante="<?php echo htmlspecialchars($proveedor['nombre_representante']); ?>"
                                data-rif-representante="<?php echo htmlspecialchars($proveedor['rif_representante']); ?>"
                                data-correo-proveedor="<?php echo htmlspecialchars($proveedor['correo_proveedor']); ?>"
                                data-direccion-proveedor="<?php echo htmlspecialchars($proveedor['direccion_proveedor']); ?>"
                                data-telefono-1="<?php echo htmlspecialchars($proveedor['telefono_1']); ?>"
                                data-telefono-2="<?php echo htmlspecialchars($proveedor['telefono_2']); ?>"
                                data-observacion="<?php echo htmlspecialchars($proveedor['observacion']); ?>"
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
                    <?php echo htmlspecialchars($proveedor['nombre_proveedor']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['rif_proveedor']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['nombre_representante']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['rif_representante']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-correo">
                    <?php echo htmlspecialchars($proveedor['correo_proveedor']); ?>
                    </span>
                </td> 
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['direccion_proveedor']); ?>
                    </span>
                </td> 
                <td>
                    <span class="campo-telefono">
                    <?php echo htmlspecialchars($proveedor['telefono_1']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-telefono">
                    <?php echo htmlspecialchars($proveedor['telefono_2']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['observacion']); ?>
                    </span>
                </td> 
                <td class="campo-estado">
                    <span 
                      class="campo-estatus <?php echo ($proveedor['estado'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                      data-id="<?php echo $proveedor['id_proveedor']; ?>"
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
                                    id="btnModificarProducto"
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

<div class="modal fade modal-modificar" id="modificarProveedorModal" tabindex="-1" role="dialog"
aria-labelledby="modificarProveedorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="btnModificarProveedor" method="POST">
        <div class="modal-header">
          
          <h5 class="titulo-form" id="modificarProveedorModalLabel">Modificar Proveedor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="modificar_id_proveedor" name="id_proveedor">
          <input type="hidden" name="accion" value="modificar">

          <div class="form-group">
            <label for="modificar_nombre_proveedor">Nombre del Proveedor</label>
            <input type="text" class="form-control" id="modificar_nombre_proveedor" name="nombre_proveedor" maxlength="50" required>
            <span class="span-value-modal" id="smnombre_proveedor"></span>
          </div>

          <div class="form-group">
            <label for="modificar_rif_proveedor">RIF del Proveedor</label>
            <input type="text" class="form-control" id="modificar_rif_proveedor" name="rif_proveedor" maxlength="12" required>
            <span class="span-value-modal" id="smrif_proveedor"></span>
          </div>

          <div class="form-group">
            <label for="modificar_nombre_representante">Nombre del Representante</label>
            <input type="text" class="form-control" id="modificar_nombre_representante" name="nombre_representante" maxlength="50" required>
            <span class="span-value-modal" id="smnombre_representante"></span>
          </div>

          <div class="form-group">
            <label for="modificar_rif_representante">RIF del Representante</label>
            <input type="text" class="form-control" id="modificar_rif_representante" name="rif_representante" maxlength="12" required>
            <span class="span-value-modal" id="smrif_representante"></span>
          </div>

          <div class="form-group">
            <label for="modificar_correo_proveedor">Correo</label>
            <input type="email" class="form-control" id="modificar_correo_proveedor" name="correo_proveedor" maxlength="50" required>
            <span class="span-value-modal" id="smcorreo_proveedor"></span>
          </div>

          <div class="form-group">
            <label for="modificar_direccion_proveedor">Dirección</label>
            <input type="text" class="form-control" id="modificar_direccion_proveedor" name="direccion_proveedor" maxlength="100" required>
            <span class="span-value-modal" id="smdireccion_proveedor"></span>
          </div>

          <div class="form-group">
            <label for="modificar_telefono_1">Teléfono Principal</label>
            <input type="text" class="form-control" id="modificar_telefono_1" name="telefono_1" maxlength="13" required>
            <span class="span-value-modal" id="smtelefono_1"></span>
          </div>

          <div class="form-group">
            <label for="modificar_telefono_2">Teléfono Secundario</label>
            <input type="text" class="form-control" id="modificar_telefono_2" name="telefono_2" maxlength="13" required>
            <span class="span-value-modal" id="smtelefono_2"></span>
          </div>

          <div class="form-group">
            <label for="modificar_observacion">Observación</label>
            <textarea class="form-control" id="modificar_observacion" name="observacion" maxlength="100" rows="3"></textarea>
            <span class="span-value-modal" id="smobservacion"></span>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modificarProductoModal" tabindex="-1" role="dialog" 
aria-labelledby="modificarProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="modificarProductoForm" method="POST">
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
                <?php echo $proveedor['nombre_proveedor']; ?>
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

<?php include 'footer.php'; ?>
<script src="Javascript/proveedor.js"></script>
<script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>
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