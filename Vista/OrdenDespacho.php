<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'Cliente' || (isset($_SESSION['nombre_rol']) && $_SESSION['nombre_rol'] === 'SuperUsuario')) { ?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'header.php'; ?>
    <title>Gestionar Orden de Despacho</title>
</head>

<<body class="fondo" style=" height: 100vh; background-image: url(img/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'newnavbar.php'; ?>

<!-- Modal para registrar orden de despacho -->
<div class="modal fade modal-registrar" id="registrarOrdenModal" tabindex="-1" role="dialog"
aria-labelledby="registrarOrdenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="incluirordendepacho" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarOrdenModalLabel">Incluir Orden de Despacho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="ingresar">
                    <div class="envolver-form">
                        <label for="correlativo">Correlativo</label>
                        <input type="text" class="control-form" id="correlativo" name="correlativo" maxlength="10" required>
                        <span class="span-value" id="scorrelativo"></span>
                    </div>
                    <div class="envolver-form">
                        <label for="fecha">Fecha</label>
                        <input type="date" class="control-form" id="fecha" name="fecha" required>
                        <span class="span-value" id="sfecha"></span>
                    </div>
                    <div class="envolver-form">
                        <label for="factura">Factura</label>
                        <select name="factura" id="factura" class="form-select" required>
                            <option value="" disabled selected>Seleccionar Factura</option>
                            <?php foreach ($facturas as $factura): ?>
                                <option value="<?php echo htmlspecialchars($factura['id_factura']); ?>">
                                    <?php echo htmlspecialchars('Factura #'.$factura['id_factura'].' Cliente: '.$factura['nombre'].' Fecha '.$factura['fecha']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="span-value" id="sfactura"></span>
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
        <button id="btnIncluirOrden" class="btn-incluir">
            Incluir Orden de Despacho
        </button>
    </div>

    <h3>LISTA DE ORDENES DE DESPACHO</h3>

    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Correlativo</th>
                <th>Fecha</th>
                <th>Factura</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($ordendespacho as $orden): ?>
            <tr>
                <td><span class="campo-correlativo"><?php echo htmlspecialchars($orden['correlativo']); ?></span></td>
                <td><span class="campo-fecha"><?php echo htmlspecialchars($orden['fecha_despacho']); ?></span></td>
                <td><span class="campo-factura"><?php echo htmlspecialchars($orden['activo']); ?></span></td>
                <td>
                    <ul>
                        <div>
                            <button class="btn-modificar"
                                data-id="<?php echo $orden['id_orden_despachos']; ?>" 
                                data-fecha="<?php echo $orden['fecha_despacho']; ?>"
                                data-correlativo="<?php echo $orden['correlativo']; ?>"
                                data-factura="<?php echo $orden['id_factura']; ?>"
                                >Modificar
                            </button>
                        </div>
                        <div>
                            <button class="btn-eliminar"
                            data-id="<?php echo $orden['id_orden_despachos']; ?>"
                            >Eliminar</button></li>
                        </div>
                    </ul>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal de modificación de orden de despacho -->
<div class="modal fade" id="modificar_orden_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_orden_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="modificarorden" method="POST">
        <input type="hidden" name="accion" value="modificar">
            <div class="modal-header">
            <h5 class="modal-title" id="modificar_orden_modal_label">Modificar Orden de Despacho</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modificar_id_orden" name="id_despachos">
                <div class="form-group">
                    <label for="modificar_fecha">Fecha</label>
                    <input type="date" class="form-control" id="modificar_fecha" name="fecha_despacho" required>
                </div>
                <div class="form-group">
                    <label for="modificar_correlativo">Correlativo</label>
                    <input type="text" class="form-control" id="modificar_correlativo" name="correlativo" required>
                </div>
                <div class="form-group">
                    <label for="modificar_factura">Factura</label>
                    <select name="factura" id="modificar_factura" class="form-control">
                    <?php foreach ($facturas as $factura): ?>
                        <option value="<?php echo htmlspecialchars($factura['id_factura']); ?>">
                        <?php echo htmlspecialchars($factura['fecha']); ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Modificar</button>
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
<script src="javascript/sweetalert2.all.min.js"></script>
<script src="javascript/usuario.js"></script>
<script src="javascript/validaciones.js"></script>
<script src="javascript/ordendespacho.js"></script>
<script>
$(document).ready(function() {
    $('#tablaConsultas').DataTable({
        language: {
            url: 'public/js/es-ES.json'
        }
    });
});
</script>
<!-- Botón para abrir el modal (puedes colocarlo donde prefieras) -->
<script>
$(document).ready(function() {
    $('#btnIncluirOrden').on('click', function() {
        $('#registrarOrdenModal').modal('show');
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