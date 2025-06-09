<?php if ($_SESSION['rango'] == 'Administrador') { ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Roles</title>
    <?php include 'header.php'; ?>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'NewNavBar.php'; ?>

<div class="modal fade modal-registrar" id="registrarRolModal" tabindex="-1" role="dialog" aria-labelledby="registrarRolModalLabel" aria-hidden="true">
    <div class="formulario-responsivo">
        <div class="fondo-form">
            <form id="registrarMarca" action="" method="POST">
                <input type="hidden" name="accion" value="registrar">
                <h3 class="titulo-form">INCLUIR ROL</h3>
                <div class="envolver-form">
                    <input type="text" placeholder="Nombre de la Marca" class="control-form" id="nombre_marca" name="nombre_marca" maxlength="25" required>
                    <span class="span-value" id="snombre_marca"></span>
                </div>

                <button class="boton-form" type="submit">Registrar</button>
                <button class="boton-reset" type="reset">Reset</button>
            </form>
        </div>
    </div>
</div>

<div class="contenedor-tabla">
    <h3>Lista de Roles</h3>
    
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>ID</th>
                <th>Nombre</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr data-id="<?php echo $rol['id_rol']; ?>">
                    <td>
                        <ul>
                            <li>
                                <button class="btn btn-primary btn-modificar"
                                data-id="<?php echo $rol['id_marca']; ?>"
                                data-nombre="<?php echo htmlspecialchars($rol['nombre_rol']); ?>"
                                >Modificar</button>
                            </li>
                            <li>
                                <button class="btn btn-danger btn-eliminar"
                                data-id="<?php echo $rol['id_rol']; ?>"
                                >Eliminar</button>
                            </li>
                        </ul>
                    </td>
                    <td><?php echo htmlspecialchars($rol['id_rol']); ?></td>
                    <td><?php echo htmlspecialchars($rol['nombre_rol']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table> 
</div>

<div class="modal fade modal-modificar" id="modificarRolModal" tabindex="-1" role="dialog" aria-labelledby="modificarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarRol" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarRolModalLabel">Modificar Rol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_rol" name="id_rol">
                    <div class="form-group">
                        <label for="modificar_nombre_rol">Nombre del Rol</label>
                        <input type="text" class="form-control" id="modificar_nombre_rol" name="nombre_rol" maxlength="25" required>
                        <span class="span-value-modal" id="smnombre_rol"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="Javascript/rol.js"></script>

<script src="public/bootstrap/js/sidebar.js"></script>

<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>

</body>
</html>

<?php
} else {
    header("Location: ?pagina=acceso-denegado");
    exit;
}
?>