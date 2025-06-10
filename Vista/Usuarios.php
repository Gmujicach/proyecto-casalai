<?php if ($_SESSION['rango'] == 'Administrador') { ?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <?php include 'header.php'; ?>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'NewNavBar.php'; ?>


<div class="formulario-responsivo">
    <div class="fondo-form">
    <form id="incluirusuario" action="" method="POST" action="">
        <input type="hidden" name="accion" value="registrar">
        <h3 class="titulo-form">INCLUIR USUARIO</h3>

        <div class="grupo-form">
            <input type="text" placeholder="Nombre" class="control-form" id="nombre" name="nombre" maxlength="30" required>
            <span class="span-value" id="snombre"></span>

            <input type="text" placeholder="Apellido" class="control-form" id="apellido_usuario" name="apellido_usuario" maxlength="30" required>
            <span class="span-value" id="sapellido"></span>
        </div>
        <div class="envolver-form">
            <input type="text" placeholder="Nombre de Usuario" class="control-form" id="nombre_usuario" name="nombre_usuario" maxlength="20" required>
            <span class="span-value" id="snombre_usuario"></span>
        </div>
        <div class="envolver-form">
            <input type="text" placeholder="Telefono" class="control-form" id="telefono_usuario" name="telefono_usuario" maxlength="13" required>
            <span class="span-value" id="stelefono_usuario"></span>
        </div>
        <div class="envolver-form">
            <input type="text" placeholder="CorreoEjemplo@gmail.com" class="control-form" id="correo_usuario" name="correo_usuario" maxlength="50" required>
            <span class="span-value" id="scorreo_usuario"></span>
        </div>

        <div class="envolver-form">
            <input type="password" placeholder="Contraseña" class="control-form" id="clave_usuario" name="clave_usuario" maxlength="15" required>
            <span class="span-value" id="sclave_usuario"></span>
        </div>
        <div class="envolver-form">
            <input type="password" placeholder="Confirmar Contraseña" class="control-form" id="clave_confirmar" name="clave_confirmar" maxlength="15" required>
            <span class="span-value" id="sclave_confirmar"></span>
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
                    <span>
                        <div class="acciones-boton">

                                        <button class="btn btn-primary btn-modificar"
                                            data-id="<?php echo $usuario['id_usuario']; ?>"
                                            data-username="<?php echo htmlspecialchars($usuario['username']); ?>"
                                            data-nombres="<?php echo htmlspecialchars($usuario['nombres']); ?>"
                                            data-apellidos="<?php echo htmlspecialchars($usuario['apellidos']); ?>"
                                            data-correo="<?php echo htmlspecialchars($usuario['correo']); ?>"
                                            data-telefono="<?php echo htmlspecialchars($usuario['telefono']); ?>"
                                            data-clave="<?php echo htmlspecialchars($usuario['password']); ?>"
                                            data-rango="<?php echo htmlspecialchars($usuario['rango']); ?>">
                                            Modificar
                                        </button>

                                        <button class="btn btn-danger btn-eliminar" 
                                        data-id="<?php echo $usuario['id_usuario']; ?>"
                                        >Eliminar</button>

                        </div>
                    </span>
                </td>
                <td>
                    <span class="campo-nombres">
                    <?php echo htmlspecialchars($usuario['nombres']); ?> <?php echo htmlspecialchars($usuario['apellidos']); ?>
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
                    <?php echo htmlspecialchars($usuario['rango']); ?>
                    </span>
                </td>
                <td>
                    <span class="campo-estatus <?php echo ($usuario['estatus'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                        data-id="<?php echo $usuario['id_usuario']; ?>" 
                        style="cursor: pointer;">
                        <?php echo htmlspecialchars($usuario['estatus']); ?>
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
</div>



<!-- Modal de modificación -->
<div class="modal fade modal-modificar" id="modificar_usuario_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_usuario_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarusuario" method="POST">
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
                        <input type="text" class="form-control" id="modificarnombre" name="nombre" maxlength="30" required>
                        <span class="span-value-modal" id="smodificarnombre"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarapellido_usuario">Apellidos del Usuario</label>
                        <input type="text" class="form-control" id="modificarapellido_usuario" name="apellido_usuario" maxlength="30" required>
                        <span class="span-value-modal" id="smodificarapellido_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarnombre_usuario">Usuario</label>
                        <input type="text" class="form-control" id="modificarnombre_usuario" name="nombre_usuario" maxlength="20" required>
                        <span class="span-value-modal" id="smodificarnombre_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificartelefono_usuario">Telefono</label>
                        <input type="text" class="form-control" id="modificartelefono_usuario" name="telefono_usuario" maxlength="13" required>
                        <span class="span-value-modal" id="smodificartelefono_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarcorreo_usuario">Correo</label>
                        <input type="text" class="form-control" id="modificarcorreo_usuario" name="correo_usuario" maxlength="50" required>
                        <span class="span-value-modal" id="smodificarcorreo_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarclave_usuario">Contraseña del Usuario</label>
                        <input type="text" class="form-control" id="modificarclave_usuario" name="clave_usuario" maxlength="15" required>
                        <span class="span-value-modal" id="smodificarclave_usuario"></span>
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
<script src="Javascript/usuario.js"></script>
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