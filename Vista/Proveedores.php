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
        <!-- <tfoot>
            <tr>
                <td>Filas por Página: 
                    <select id="filasPorPagina" onchange="cambiarFilasPorPagina(this.value)">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </td>
                <td><?php //echo "$inicio-$fin de $totalUsuarios"; ?></td>
                <td>
                    <a href="?pagina=<?php //echo max(1, $paginaActual - 1); ?>">
                        <i class="flecha-izquierda"><img src="IMG/flecha_izquierda.svg" alt="Anterior" width="16" height="16"></i>
                    </a>
                </td>
                <td>
                    <a href="?pagina<?php //echo min(ceil($totalUsuarios / $filasPorPagina), $paginaActual + 1); ?>">
                        <i class="flecha-derecha"><img src="IMG/flecha_derecha.svg" alt="Siguiente" width="16" height="16"></i>
                    </a>
                </td>
            </tr>
        </tfoot> -->
    </table>

<div class="contenedor-tabla">
    <h3>Lista de Productos Con Bajo Stock</h3>
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
</body>
</html>
