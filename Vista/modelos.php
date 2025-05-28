<?php
if (!isset($_SESSION['name'])) {
	header('Location: .');
	exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Modelos</title>
    <?php include 'header.php'; ?>
</head>
<body>

<?php include 'NewNavBar.php'; ?>

<div class="formulario-responsivo">
    <div class="fondo-form">
        <form id="registrarModelo" action="" method="POST">
            <input type="hidden" name="accion" value="registrar">
            <h3 class="titulo-form">Incluir Modelo</h3>
            
            <div class="envolver-form">
                <label for="id_marca"></label>
                <select class="form-select" id="id_marca" name="id_marca" required>
                    <option value="" hidden>Selecciona una marca</option>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['nombre_marca']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="envolver-form">
                <input type="text" placeholder="Nombre del modelo" class="control-form" id="nombre_modelo" name="nombre_modelo" maxlength="25" required>
                <span class="span-value" id="snombre_modelo"></span>
            </div>

            <button class="boton-form" type="submit">Registrar</button>
            <button class="boton-reset" type="reset">Reset</button>

        </form>
    </div>
</div>

<div class="contenedor-tabla">
    <h3>Lista de los Modelos</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modelos as $modelo): ?>
                <tr data-id="<?php echo $modelo['id_modelo']; ?>">
                    <td><?php echo htmlspecialchars($modelo['id_modelo']); ?></td>
                    <td><?php echo htmlspecialchars($modelo['nombre_marca']); ?></td>
                    <td><?php echo htmlspecialchars($modelo['nombre_modelo']); ?></td>
                    <td>
                        <span>
                            <div class="acciones-boton">
                                <i class="vertical">
                                    <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                                </i>
                                <div class="desplegable">
                                    <ul>
                                        <li>
                                            <button class="btn btn-primary btn-modificar"
                                            data-id="<?php echo $modelo['id_modelo']; ?>"
                                            data-marcaid="<?php echo htmlspecialchars($modelo['id_marca']); ?>"
                                            data-nombre="<?php echo htmlspecialchars($modelo['nombre_modelo']); ?>"
                                            >Modificar</button>
                                        </li>
                                        <li>
                                            <button class="btn btn-danger btn-eliminar"
                                            data-id="<?php echo $modelo['id_modelo']; ?>"
                                            >Eliminar</button>
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
<!--<div class="containera">
    <form method="post" action="" id="f" target="_blank">
        <div class="containera">
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-primary" id="pdfmodelos" name="pdfmodelos"><a href="?pagina=pdfmodelos">GENERAR REPORTE</button>
                </div>
            </div>
        </div>
        
    </form>
</div>-->

<!-- Modal de modificación -->
<div class="modal fade modal-modificar" id="modificarModeloModal" tabindex="-1" role="dialog" aria-labelledby="modificarModeloModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarModelo" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarModeloModalLabel">Modificar Modelo</h5>
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
                        <label for="modificar_nombre_modelo">Nombre del Modelo</label>
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
<script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="Javascript/modelos.js"></script>

<script src="public/bootstrap/js/sidebar.js"></script>
<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>
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