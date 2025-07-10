<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'SuperUsuario' ) { ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Roles</title>
    <?php include 'header.php'; ?>
</head>
<body class="fondo" style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'newnavbar.php'; ?>

<div class="modal fade modal-registrar" id="registrarRolModal" tabindex="-1" role="dialog" aria-labelledby="registrarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="registrarRol" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarRolModalLabel">Incluir Rol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="envolver-form">
                        <label for="nombre_rol">Nombre del Rol</label>
                        <input type="text" placeholder="Nombre" class="control-form" id="nombre_rol" name="nombre_rol" maxlength="15" required>
                        <span class="span-value" id="snombre_rol"></span>
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
        <button id="btnIncluirRol" class="btn-incluir">
            Incluir Rol
        </button>
    </div>

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
                    <?php if (strtolower($rol['nombre_rol']) !== 'superusuario'): ?>
                        <div>
                            <button class="btn-modificar"
                                id="btnModificarRol"
                                data-id="<?php echo $rol['id_rol']; ?>"
                                data-nombre="<?php echo htmlspecialchars($rol['nombre_rol']); ?>"
                            >Modificar</button>
                        </div>
                        <div>
                            <button class="btn-eliminar"
                                data-id="<?php echo $rol['id_rol']; ?>"
                            >Eliminar</button>
                        </div>
                    <?php endif; ?>
                </ul>
            </td>
            <td>
                <span class="campo-numeros">
                    <?php echo htmlspecialchars($rol['id_rol']); ?>
                </span>
            </td>
            <td>
                <span class="campo-nombres">
                    <?php echo htmlspecialchars($rol['nombre_rol']); ?>
                </span>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
    </table> 
</div>

<div class="modal fade modal-modificar" id="modificarRolModal" tabindex="-1" role="dialog" aria-labelledby="modificarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="modificarRol" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="modificarRolModalLabel">Modificar Rol</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_rol" name="id_rol">
                    <div class="form-group">
                        <label for="modificar_nombre_rol">Nombre del Rol</label>
                        <input type="text" class="form-control" id="modificar_nombre_rol" name="nombre_rol" maxlength="15" required>
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
<script src="javascript/rol.js"></script>
<script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="public/bootstrap/js/sidebar.js"></script>
<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>
<script>
$(document).ready(function() {
    $('#tablaConsultas').DataTable({
        language: {
            url: 'public/js/es-ES.json'
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