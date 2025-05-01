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

            <input type="text" placeholder="Apellido" class="control-form" id="nombre" name="nombre" required>
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
    <h3 class="titulo-tabla">LISTA DE USUARIOS</h3>

    <table>
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Nombre de Usuario</th>
                <th>Correo</th>
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
                <td><?php echo htmlspecialchars($usuario['nombres']); ?></td>
                <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                <td><a href="#" data-id="<?php echo htmlspecialchars($usuario['id_usuario']); ?>" class="btn btn-eliminar">Ver Mas</a></td>
                <td>
                    <span>
                        <div class="acciones-boton">
                        <i class="vertical">
                        <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                    </i>
                            <div class="acciones">
                                <a href="#" data-id="<?php echo htmlspecialchars($usuario['id_usuario']); ?>" class="btn btn-modificar">Modificar</a>
                                <a href="#" data-id="<?php echo htmlspecialchars($usuario['id_usuario']); ?>" class="btn btn-eliminar">Eliminar</a>
                            </div>
                        </div>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
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

















    <div class="table-container">
    <h1 class="titulo-tabla display-5 text-center">LISTA DE USUARIOS</h1>
    <table class="tabla">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Usuarios</th>
                <th>Rango del Usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td>
                        <!-- Botón Modificar que abre el modal -->
                        <button type="button" class="btn btn-modificar" data-toggle="modal" data-target="#modificarProductoModal" data-id="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">
                        Modificar
                        </button>
                        <br>
                        <!-- Botón Eliminar -->
                        <a href="#" data-id="<?php echo htmlspecialchars($usuario['id_usuario']); ?>" class="btn btn-eliminar">Eliminar</a>
                    </td>
                    <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['rango']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
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
    <div class="containera"> <!-- todo el contenido ira dentro de esta etiqueta-->

<form method="post" action="" id="f" target="_blank">
<div class="containera">
    <div class="row">
        <div class="col">
               <button type="button" class="btn btn-primary" id="pdfusuarios" name="pdfusuarios"><a href="?pagina=pdfusuarios">GENERAR REPORTE</button>
        </div>
        
    </div>
</div>
</form>
    
</div> <!-- fin de container -->
</div>


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
