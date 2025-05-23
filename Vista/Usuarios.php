<?php



if (!isset($_SESSION['name'])) {

 	header('Location: .');
 	exit();
 }
?>

  <title>Gestionar Usuarios</title>
  <?php include 'header.php'; ?>
</head>
<body>

<?php include 'NewNavBar.php'; ?>


<div class="formulario-responsivo">
    <div class="fondo-form">
    <form id="incluirusuario" action="" method="POST" action="">
        <input type="hidden" name="accion" value="ingresar">
        <h3 class="titulo-form">INCLUIR USUARIO</h3>

        <div class="grupo-form">
            <input type="text" placeholder="Nombre" class="control-form" id="nombre" name="nombre" required>
            <span id="snombre"></span>

            <input type="text" placeholder="Apellido" class="control-form" id="apellido_usuario" name="apellido_usuario" required>
            <span id="sapellido"></span>
        </div>
        <div class="envolver-form">
            <input type="text" placeholder="Nombre de Usuario" class="control-form" id="nombre_usuario" name="nombre_usuario" required>
            <span id="snombre_usuario"></span>
        </div>
        <div class="envolver-form">
            <input type="text" placeholder="Telefono" class="control-form" id="telefono_usuario" name="telefono_usuario" required>
            <span id="stelefono_usuario"></span>
        </div>
        <div class="envolver-form">
            <input type="text" placeholder="CorreoEjemplo@gmail.com" class="control-form" id="correo_usuario" name="correo_usuario" required>
            <span id="scorreo_usuario"></span>
        </div>

        <div class="envolver-form">
            <input type="password" placeholder="contraseña" class="control-form" id="clave_usuario" name="clave_usuario" required>
            <span id="sclave_usuario"></span>
        </div>
        <div class="envolver-form">
            <input type="password" placeholder="Confirmar Contraseña" class="control-form" id="clave_confirmar" name="clave_confirmar" required>
            <span id="sclave_confirmar"></span>
        </div>
        <!-- <div class="envolver-form">
            <select name="" id="" class="control-form">
                <option value="" disabled selected>Seleccionar</option>
                <option value=""></option>
                <option value=""></option>
                <option value=""></option>
            </select>
        </div> -->

        <button class="boton-form" type="submit">Registrar</button>
    </form>
    </div>
</div>


<div class="contenedor-tabla">
    <h3>LISTA DE USUARIOS</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Rango</th>
                <th>Estatus</th>
                <!-- <th></th> -->
                <th><i class="vertical">
                        <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                    </i>
                </th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><input type="checkbox"></td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($usuario['nombres']); ?> <?php echo htmlspecialchars($usuario['apellidos']); ?>
                    </span>
                    <span class="campo-correo">
                    <?php echo htmlspecialchars($usuario['correo']); ?>
                    </span>
                </td>
                
                <td>
                    <span class="campo-telefono">
                    <?php echo htmlspecialchars($usuario['telefono']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-rango">
                    <?php echo htmlspecialchars($usuario['rango']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-estatus <?php echo ($usuario['estatus'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                        onclick="cambiarEstatus(<?php echo $usuario['id_usuario']; ?>, '<?php echo $usuario['estatus']; ?>')"
                        style="cursor: pointer;">
                        <?php echo htmlspecialchars($usuario['estatus']); ?>
                    </span>
                </td>
                <!-- <td>
                    <span class="precio">200
                     <//?php //echo htmlspecialchars($usuario['precio']); ?> -->
                    <!-- </span>
                    <span class="moneda">USD</span>
                </td> -->
                <!-- <td>
                    <span>
                        <a href="#"class="">Ver Mas</a>
                    </span>
                </td> -->
                <td>
                    <span>
                        <div class="acciones-boton">
                        <i class="vertical">
                            <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                        </i>
                            <div class="desplegable">
                                <ul>
                                    <li><a href="#">Ver</a></li>
                                    <li><a href="#" class="modificar" data-toggle="modal" data-target="#modificar_usuario_modal" onclick="obtenerUsuario(<?php echo $usuario['id_usuario']; ?>)">Modificar</a></li>
                                    <li><a href="#" class="eliminar" onclick="eliminarUsuario(<?php echo $usuario['id_usuario']; ?>)">Eliminar</a></li>
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
                        <label for="modificarnombre_usuario">Nombre del Usuario</label>
                        <input type="text" class="form-control" id="modificarnombre_usuario" name="nombre_usuario" maxlength="15" required>
                        <span id="smodificarnombre_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarclave_usuario">Contraseña del Usuario</label>
                        <input type="text" class="form-control" id="modificarclave_usuario" name="clave_usuario" required>
                        <span id="smodificarclave_usuario"></span>
                    </div>
                    <div class="form-group col-md-4">
                                    <label for="rango">Categorias</label>
                                    <select class="custom-select" id="rango" name="rango">
                                    <option value="USUARIO">Usuario</option>
                                                        <option value="admin">Administrador</option>
                                                        <option value="almacen">Almacen</option>    
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


<!-- Modal de eliminación -->
<?php include 'footer.php'; ?>
<script src="public/bootstrap/js/sidebar.js"></script>
  <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="public/js/jquery-3.7.1.min.js"></script>
  <script src="public/js/jquery.dataTables.min.js"></script>
  <script src="public/js/dataTables.bootstrap5.min.js"></script>
  <script src="public/js/datatable.js"></script>
  <script src="Javascript/sweetalert2.all.min.js"></script>
<script src="Javascript/usuario.js"></script>
<script src="Javascript/validaciones.js"></script>
</body>


</html>
