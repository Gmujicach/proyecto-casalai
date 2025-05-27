<?php



if (!isset($_SESSION['name'])) {

 	header('Location: .');
 	exit();
 }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <title>Gestionar Proveedores</title>
</head>
<body>


    <?php include 'NewNavBar.php'; ?>


<div class="formulario-responsivo">
    <div class="fondo-form">
    <form id="incluirproveedor" action="" method="POST" action="">
        <input type="hidden" name="accion" value="ingresar">
        <h3 class="titulo-form">INCLUIR PROVEEDOR</h3>

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
            <textarea class="control-form" maxlength="50" id="observacion" name="observacion" rows="3" placeholder="Escriba alguna Observaciones que se deba tener en cuenta..."></textarea>
            <span id="sobservacion"></span>
        </div>

        <button class="boton-form" type="submit">Registrar</button>
    </form>
    </div>
</div>

    <!--== LISTADO DE CONSULTA ==-->
<div class="contenedor-tabla">
    <h3>LISTA DE USUARIOS</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>Nombre</th>
                <th>R.I.F</th>
                <th>Telefono</th>
                <th><i class="vertical">
                        <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                    </i>
                </th>
            </tr>
        </thead>


        <tbody>
        <?php foreach ($proveedores as $proveedor): ?>
            <tr>
                <td><input type="checkbox"></td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($proveedor['nombre']); ?>
                    </span>
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
                
                <td>
                    <span>
                        <div class="acciones-boton">
                        <i class="vertical">
                            <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                        </i>
                            <div class="desplegable">
                                <ul>
                                    <li><a href="#">Ver</a></li>
                                    <li>
                                        <a href="#" class="modificar" 
                                            data-id="<?php echo $proveedor['id_proveedor']; ?>"
                                            data-nombres="<?php echo htmlspecialchars($usuario['nombres']); ?>"
                                            data-apellidos="<?php echo htmlspecialchars($usuario['apellidos']); ?>"
                                            data-usuario="<?php echo htmlspecialchars($usuario['username']); ?>"
                                            data-telefono="<?php echo htmlspecialchars($usuario['telefono']); ?>"
                                            data-correo="<?php echo htmlspecialchars($usuario['correo']); ?>"
                                            data-clave="<?php echo htmlspecialchars($usuario['password']); ?>"
                                            data-rango="<?php echo htmlspecialchars($usuario['rango']); ?>"
                                            data-toggle="modal" 
                                            data-target="#modificar_usuario_modal">
                                            Modificar
                                        </a>
                                    </li>

                                    <li><a href="#" class="eliminar" onclick="eliminarUsuario(<?php echo $proveedor['id_usuario']; ?>)">Eliminar</a></li>
                                </ul>
                            </div>
                        </div>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

<div class="contenedor-tabla">
    <h3>Lista de Productos Con Bajo Stock</h3>
    <table class="tabla"class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Id Producto</th>
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
                                                class="btn btn-primary modificar" 
                                                id="modificarProductoBtn"
                                                data-toggle="modal" 
                                                data-target="#modificarProductoModal" 
                                                data-id="<?php echo htmlspecialchars($producto['id_producto']); ?>"
                                                data-nombre="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"
                                                data-modelo="<?php echo htmlspecialchars($producto['nombre_modelo']); ?>"
                                                data-stockactual="<?php echo htmlspecialchars($producto['stock']); ?>"
                                                data-stockminimo="<?php echo htmlspecialchars($producto['stock_minimo']); ?>"
                                            >
                                                Realizar Pedido
                                            </button>
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

<!-- Modal de modificación -->
<div class="modal fade" id="modificarProductoModal" tabindex="-1" role="dialog" aria-labelledby="modificarProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="modificarProductoForm" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modificarProductoModalLabel">Realizar Pedido</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Acciones ocultas -->
          <input type="hidden" name="accion" value="realizar_pedido">
          <input type="hidden" id="modificarIdProducto" name="id_producto">

          <!-- Campos -->
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


<!-- Modal de modificación -->
    <div class="modal fade" id="modificar_usuario_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_usuario_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarusuario" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificar_usuario_modal_label">Modificar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Campos del formulario de modificación -->
                    <input type="hidden" id="modificar_id_usuario" name="id_usuario">
                    <div class="form-group">
                        <label for="modificarnombre">Nombres del Usuario</label>
                        <input type="text" class="form-control" id="modificarnombre" name="nombre" maxlength="15" required>
                        <span id="smodificarnombre_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarapellido_usuario">Apellidos del Usuario</label>
                        <input type="text" class="form-control" id="modificarapellido_usuario" name="apellido_usuario" maxlength="15" required>
                        <span id="smodificarapellido_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarnombre_usuario">Usuario</label>
                        <input type="text" class="form-control" id="modificarnombre_usuario" name="nombre_usuario" maxlength="15" required>
                        <span id="smodificarnombre_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificartelefono_usuario">Telefono</label>
                        <input type="text" class="form-control" id="modificartelefono_usuario" name="telefono_usuario" maxlength="15" required>
                        <span id="smodificartelefono_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarcorreo_usuario">Correo</label>
                        <input type="text" class="form-control" id="modificarcorreo_usuario" name="correo_usuario" maxlength="15" required>
                        <span id="smodificarcorreo_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarclave_usuario">Contraseña del Usuario</label>
                        <input type="text" class="form-control" id="modificarclave_usuario" name="clave_usuario" required>
                        <span id="smodificarclave_usuario"></span>
                    </div>
                    <div class="form-group col-md-4">
                                    <label for="rango">Categorias</label>
                                    <select class="custom-select" id="rango" name="rango">
                                    <option value="usuario">Usuario</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Almacenista">Almacenista</option>
                                    <option value="Cliente">Cliente</option> 
                                    <option value="Desarrollador">Desarrollador</option>   
                                    </select>
                                </div>
                    
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-cerrar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

                
            

            
    </form>
</div>

  <?php include 'footer.php'; ?>
  <script src="Javascript/proveedor.js"></script>
  <script src="Javascript/validaciones.js"></script>
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


</body>
</html>
