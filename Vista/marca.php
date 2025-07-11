<?php 
if (
    (isset($permisosUsuario['consultar']) && $permisosUsuario['consultar']) 
    || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')
) { ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Marcas</title>
    <?php include 'header.php'; ?>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(IMG/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'newnavbar.php'; ?>

<div class="modal fade modal-registrar" id="registrarMarcaModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarMarcaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="registrarMarca" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarMarcaModalLabel">Incluir Marca</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="envolver-form">
                        <label for="nombre_marca">Nombre de la Marca</label>
                        <input type="text" placeholder="Nombre" class="control-form" id="nombre_marca" name="nombre_marca" maxlength="25" required>
                        <span class="span-value" id="snombre_marca"></span>
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


<div class="contenedor-tabla" style="width:100%; max-width:1200px; margin:0 auto;">
    <div class="space-btn-incluir">
        <?php if ($permisosUsuario['incluir']): ?>
        <button id="btnIncluirMarca" class="btn-incluir">
            Incluir Marca
        </button>
        <?php endif; ?>
    </div>

    <h3>Lista de Marcas</h3>

    <table class="tablaConsultas" id="tablaConsultas" style="width:100%;">
     
<thead>
    <tr>
        <th>Acciones</th>
        <th>ID</th>
        <th>Nombre</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($marcas as $marca): ?>
        <tr data-id="<?php echo $marca['id_marca']; ?>">
            <td>
                <ul>
                    <div>
                        <button class="btn-modificar" style="display:none"
                            id="btnModificarMarca"
                            data-id="<?php echo $marca['id_marca']; ?>"
                            data-nombre="<?php echo htmlspecialchars($marca['nombre_marca']); ?>">
                            Modificar
                        </button>
                    </div>
                    <div>
                        <button class="btn-eliminar" style="display:none"
                            data-id="<?php echo $marca['id_marca']; ?>">
                            Eliminar
                        </button>
                    </div>
                </ul>
            </td>
            <td>
                <span class="campo-numeros">
                    <?php echo htmlspecialchars($marca['id_marca']); ?>
                </span>
            </td>
            <td>
                <span class="campo-nombres">
                    <?php echo htmlspecialchars($marca['nombre_marca']); ?>
                </span>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
    </table>
</div>


<div class="modal fade modal-modificar" id="modificarMarcaModal" tabindex="-1" role="dialog" aria-labelledby="modificarMarcaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="modificarMarca" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="modificarMarcaModalLabel">Modificar Marca</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_marca" name="id_marca">
                    <div class="form-group">
                        <label for="modificar_nombre_marca">Nombre de la Marca</label>
                        <input type="text" class="form-control" id="modificar_nombre_marca" name="nombre_marca" maxlength="25" required>
                        <span class="span-value-modal" id="smnombre_marca"></span>
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
<script src="Public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="Public/js/jquery-3.7.1.min.js"></script>
<script src="Javascript/marca.js"></script>

<script src="Public/bootstrap/js/sidebar.js"></script>

<script src="Public/js/jquery.dataTables.min.js"></script>
<script src="Public/js/dataTables.bootstrap5.min.js"></script>
<script src="Public/js/datatable.js"></script>
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