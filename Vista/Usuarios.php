<?php if ($_SESSION['rango'] == 'Administrador') { ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestionar Usuarios</title>
        <?php include 'header.php'; ?>
    </head>

    <body class="fondo"
        style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

        <?php include 'NewNavBar.php'; ?>

        <div class="modal fade modal-registrar" id="registrarUsuarioModal" tabindex="-1" role="dialog"
            aria-labelledby="registrarUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <form id="incluirusuario" method="POST">
                        <div class="modal-header">
                            <h5 class="titulo-form" id="registrarUsuarioModalLabel">Incluir Usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="grupo-form">
                                <div class="grupo-interno">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" placeholder="Nombre" class="control-form" id="nombre" name="nombre"
                                        maxlength="30" required>
                                    <span class="span-value" id="snombre"></span>
                                </div>
                                <div class="grupo-interno">
                                    <label for="apellido_usuario">Apellido</label>
                                    <input type="text" placeholder="Apellido" class="control-form" id="apellido_usuario"
                                        name="apellido_usuario" maxlength="30" required>
                                    <span class="span-value" id="sapellido"></span>
                                </div>
                            </div>
                            <div class="envolver-form">
                                <label for="nombre">Nombre de Usuario</label>
                                <input type="text" placeholder="Nombre de Usuario" class="control-form" id="nombre_usuario"
                                    name="nombre_usuario" maxlength="20" required>
                                <span class="span-value" id="snombre_usuario"></span>
                            </div>
                            <div class="envolver-form">
                                <label for="telefono_usuario">Teléfono</label>
                                <input type="text" placeholder="Teléfono" class="control-form" id="telefono_usuario"
                                    name="telefono_usuario" maxlength="13" required>
                                <span class="span-value" id="stelefono_usuario"></span>
                            </div>
                            <div class="envolver-form">
                                <label for="correo_usuario">Correo Electrónico</label>
                                <input type="text" placeholder="CorreoEjemplo@gmail.com" class="control-form"
                                    id="correo_usuario" name="correo_usuario" maxlength="50" required>
                                <span class="span-value" id="scorreo_usuario"></span>
                            </div>
                            <div class="envolver-form">
                                <label for="rango">Rol de Usuario</label>
                                <select class="form-select form-select-lg mb-3" id="rango" name="rango">
                                    <option value="" hidden>Seleccione el tipo de usuario a crear</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Almacenista</option>
                                    <option value="3">Cliente</option>
                                    <option value="4">Desarrollador</option>
                                </select>
                            </div>
                            <div class="envolver-form">
                                <label for="clave_usuario">Contraseña</label>
                                <input type="password" placeholder="Contraseña" class="control-form" id="clave_usuario"
                                    name="clave_usuario" maxlength="15" required>
                                <span class="span-value" id="sclave_usuario"></span>
                            </div>
                            <div class="envolver-form">
                                <label for="clave_confirmar">Confirmar Contraseña</label>
                                <input type="password" placeholder="Confirmar Contraseña" class="control-form"
                                    id="clave_confirmar" name="clave_confirmar" maxlength="15" required>
                                <span class="span-value" id="sclave_confirmar"></span>
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
                <button id="btnIncluirUsuario" class="btn-incluir">
                    Incluir Usuario
                </button>
            </div>

            <h3>LISTA DE USUARIOS</h3>

            <table class="tablaConsultas" id="tablaConsultas">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Nombre y Apellido</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Telefono</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr data-id="<?php echo $usuario['id_usuario']; ?>">
                            <td>
                                <ul>
                                    <div>
                                        <button class="btn-modificar" data-id="<?php echo $usuario['id_usuario']; ?>"
                                            data-username="<?php echo htmlspecialchars($usuario['username']); ?>"
                                            data-nombres="<?php echo htmlspecialchars($usuario['nombres']); ?>"
                                            data-apellidos="<?php echo htmlspecialchars($usuario['apellidos']); ?>"
                                            data-correo="<?php echo htmlspecialchars($usuario['correo']); ?>"
                                            data-telefono="<?php echo htmlspecialchars($usuario['telefono']); ?>"
                                            data-clave="<?php echo htmlspecialchars($usuario['password']); ?>"
                                            data-rango="<?php echo htmlspecialchars($usuario['id_rol']); ?>">
                                            Modificar
                                        </button>
                                    </div>
                                    <div>
                                        <button class="btn-eliminar"
                                            data-id="<?php echo $usuario['id_usuario']; ?>">Eliminar</button>
                                    </div>
                                </ul>
                            </td>
                            <td>
                                <span class="campo-nombres">
                                    <?php echo htmlspecialchars($usuario['nombres']); ?>
                                    <?php echo htmlspecialchars($usuario['apellidos']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="campo-correo">
                                    <?php echo htmlspecialchars($usuario['correo']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="campo-usuario">
                                    <?php echo htmlspecialchars($usuario['username']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="campo-telefono">
                                    <?php echo htmlspecialchars($usuario['telefono']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="campo-rango">
                                    <?php echo htmlspecialchars($usuario['nombre_rol']); ?>
                                </span>
                            </td>
                            <td>
                                <span
                                    class="campo-estatus <?php echo ($usuario['estatus'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>"
                                    data-id="<?php echo $usuario['id_usuario']; ?>" style="cursor: pointer;">
                                    <?php echo htmlspecialchars($usuario['estatus']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="modal fade modal-modificar" id="modificar_usuario_modal" tabindex="-1" role="dialog"
            aria-labelledby="modificar_usuario_modal_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="modificarusuario" method="POST">
                        <div class="modal-header titulo-form">
                            <h5 class="modal-title" id="modificar_usuario_modal_label">Modificar Usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="modificar_id_usuario" name="id_usuario">
                            <div class="form-group">
                                <label for="modificarnombre">Nombres del Usuario</label>
                                <input type="text" class="form-control" id="modificarnombre" name="nombre" maxlength="30"
                                    required>
                                <span class="span-value-modal" id="smodificarnombre"></span>
                            </div>
                            <div class="form-group">
                                <label for="modificarapellido_usuario">Apellidos del Usuario</label>
                                <input type="text" class="form-control" id="modificarapellido_usuario"
                                    name="apellido_usuario" maxlength="30" required>
                                <span class="span-value-modal" id="smodificarapellido_usuario"></span>
                            </div>
                            <div class="form-group">
                                <label for="modificarnombre_usuario">Usuario</label>
                                <input type="text" class="form-control" id="modificarnombre_usuario" name="nombre_usuario"
                                    maxlength="20" required>
                                <span class="span-value-modal" id="smodificarnombre_usuario"></span>
                            </div>
                            <div class="form-group">
                                <label for="modificartelefono_usuario">Telefono</label>
                                <input type="text" class="form-control" id="modificartelefono_usuario"
                                    name="telefono_usuario" maxlength="13" required>
                                <span class="span-value-modal" id="smodificartelefono_usuario"></span>
                            </div>
                            <div class="form-group">
                                <label for="modificarcorreo_usuario">Correo</label>
                                <input type="text" class="form-control" id="modificarcorreo_usuario" name="correo_usuario"
                                    maxlength="50" required>
                                <span class="span-value-modal" id="smodificarcorreo_usuario"></span>
                            </div>
                            <div class="form-group">
                                <label for="rango">Rol de Usuario</label>
                                <select class="form-select form-select-lg mb-3" id="modificar_rango" name="rango">
                                    <option value="" hidden>Seleccione el tipo de usuario a crear</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Almacenista</option>
                                    <option value="3">Cliente</option>
                                    <option value="4">Desarrollador</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Modificar</button>
                        </div>
                </div>

                </form>
            </div>
        </div>
        </div>


        <!-- Modal de eliminación -->
        <?php include 'footer.php'; ?>
        <script src="Javascript/usuario.js"></script>
        <script src="public/bootstrap/js/sidebar.js"></script>
        <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="public/js/jquery-3.7.1.min.js"></script>
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
        </script>
    </body>

    </html>
    <?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>