<?php if ($_SESSION['nombre_rol'] == 'Administrador' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')) { ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Modelos</title>
    <?php include 'header.php'; ?>
</head>
<body  class="fondo" style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'newnavbar.php'; ?>

<div class="modal fade modal-registrar" id="registrarModeloModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarModeloModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="registrarModelo" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarModeloModalLabel">Incluir modelo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="grupo-form">
                        <label for="id_marca"></label>
                        <select class="form-select" id="id_marca" name="id_marca" required>
                            <option value="" hidden>Selecciona una marca</option>
                            <?php foreach ($marcas as $marca): ?>
                                <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['nombre_marca']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="envolver-form">
                        <label for="nombre_marca">Nombre del modelo</label>
                        <input type="text" placeholder="Nombre" class="control-form" id="nombre_modelo" name="nombre_modelo" maxlength="25" required>
                        <span class="span-value" id="snombre_modelo"></span>
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
        <button id="btnIncluirModelo" class="btn-incluir">
            Incluir modelo
        </button>
    </div>

    <h3>Lista de los Modelos</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>ID</th>
                <th>Marca</th>
                <th>modelo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modelos as $modelo): ?>
                <tr data-id="<?php echo $modelo['id_modelo']; ?>">
                    <td>
                        <ul>
                            <div>
                                <button class="btn-modificar"
                                id="btnModificarModelo"
                                data-id="<?php echo $modelo['id_modelo']; ?>"
                                data-marcaid="<?php echo htmlspecialchars($modelo['id_marca']); ?>"
                                data-nombre="<?php echo htmlspecialchars($modelo['nombre_modelo']); ?>"
                                >Modificar</button>
                            </div>
                            <div>
                                <button class="btn-eliminar"
                                data-id="<?php echo $modelo['id_modelo']; ?>"
                                >Eliminar</button>
                            </div>
                        </ul>
                    </td>
                    <td>
                        <span class="campo-numeros">
                            <?php echo htmlspecialchars($modelo['id_modelo']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-nombres">
                            <?php echo htmlspecialchars($modelo['nombre_marca']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-nombres">
                            <?php echo htmlspecialchars($modelo['nombre_modelo']); ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade modal-modificar" id="modificarModeloModal" tabindex="-1" role="dialog" aria-labelledby="modificarModeloModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="modificarModelo" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="modificarModeloModalLabel">Modificar modelo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_modelo" name="id_modelo">
                    <div class="form-group">
                        <label for="modificar_marca_modelo">Marca</label>
                        <select class="form-select" id="modificar_marca_modelo" name="id_marca" required>
                            <script>
                                window.marcasDisponibles = <?php echo json_encode($marcas); ?>;
                            </script>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modificar_nombre_modelo">Nombre del modelo</label>
                        <input type="text" class="form-control" id="modificar_nombre_modelo" name="nombre_modelo" maxlength="25" required>
                        <span class="span-value-modal" id="smnombre_modelo"></span>
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

<script src="javascript/modelo.js"></script>
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