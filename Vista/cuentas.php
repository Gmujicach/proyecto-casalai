<?php if ($_SESSION['rango'] == 'Administrador') { ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Cuentas Bancarias</title>
    <?php include 'header.php'; ?>
</head>

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">
<?php include 'NewNavBar.php'; ?>

<div class="formulario-responsivo">
    <div class="fondo-form">
        <form id="registrarCuenta" action="" method="POST">
            <input type="hidden" name="accion" value="registrar">
            <h3 class="titulo-form">Incluir Cuenta Bancaria</h3>
            
            <div class="envolver-form">
                <input type="text" placeholder="Nombre del banco" class="control-form" id="nombre_banco" name="nombre_banco" maxlength="20" required>
                <span class="span-value" id="snombre_banco"></span>
            </div>
            <div class="envolver-form">
                <input type="text" placeholder="Número de cuenta" class="control-form" id="numero_cuenta" name="numero_cuenta" maxlength="23" required>
                <span class="span-value" id="snumero_cuenta"></span>
            </div>
            <div class="envolver-form">
                <input type="text" placeholder="RIF" class="control-form" id="rif_cuenta" name="rif_cuenta" maxlength="12" required>
                <span class="span-value" id="srif_cuenta"></span>
            </div>
            <div class="envolver-form">
                <input type="text" placeholder="Número de teléfono" class="control-form" id="telefono_cuenta" name="telefono_cuenta" maxlength="13" required>
                <span class="span-value" id="stelefono_cuenta"></span>
            </div>
            <div class="envolver-form">
                <input type="email" placeholder="Correo electrónico" class="control-form" id="correo_cuenta" name="correo_cuenta" maxlength="50" required>
                <span class="span-value" id="scorreo_cuenta"></span>
            </div>

            <button class="boton-form" type="submit">Registrar</button>
            <button class="boton-reset" type="reset">Reset</button>

        </form>
    </div>
</div>

<div class="contenedor-tabla">
    <h3>Lista de Cuentas Bancarias</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Banco</th>
                <th>Número de Cuenta</th>
                <th>RIF</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuentabancos as $cuenta): ?>
                <tr data-id="<?php echo $cuenta['id_cuenta']; ?>">
                    <td><?php echo htmlspecialchars($cuenta['id_cuenta']); ?></td>
                    <td><?php echo htmlspecialchars($cuenta['nombre_banco']); ?></td>
                    <td><?php echo htmlspecialchars($cuenta['numero_cuenta']); ?></td>
                    <td><?php echo htmlspecialchars($cuenta['rif_cuenta']); ?></td>
                    <td><?php echo htmlspecialchars($cuenta['telefono_cuenta']); ?></td>
                    <td><?php echo htmlspecialchars($cuenta['correo_cuenta']); ?></td>
                    <td>
                        <span 
                            class="campo-estatus <?php echo ($cuenta['estado'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                            data-id="<?php echo $cuenta['id_cuenta']; ?>" 
                            style="cursor: pointer;">
                            <?php echo htmlspecialchars($cuenta['estado']); ?>
                        </span>
                    </td>
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
                                            data-id="<?php echo $cuenta['id_cuenta']; ?>"
                                            data-nombre="<?php echo htmlspecialchars($cuenta['nombre_banco']); ?>"
                                            data-numero="<?php echo htmlspecialchars($cuenta['numero_cuenta']); ?>"
                                            data-rif="<?php echo htmlspecialchars($cuenta['rif_cuenta']); ?>"
                                            data-telefono="<?php echo htmlspecialchars($cuenta['telefono_cuenta']); ?>"
                                            data-correo="<?php echo htmlspecialchars($cuenta['correo_cuenta']); ?>"
                                            >Modificar</button>
                                        </li>
                                        <li>
                                            <button class="btn btn-danger btn-eliminar"
                                            data-id="<?php echo $cuenta['id_cuenta']; ?>"
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

<!-- Modal para modificar cuenta -->
<div class="modal fade modal-modificar" id="modificarCuentaModal" tabindex="-1" role="dialog" aria-labelledby="modificarCuentaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarCuenta" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarCuentaModalLabel">Modificar Cuenta Bancaria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_cuenta" name="id_cuenta">
                    <input type="hidden" name="accion" value="modificar">
                    <div class="form-group">
                        <label for="modificar_nombre_banco">Nombre del Banco</label>
                        <input type="text" class="form-control" id="modificar_nombre_banco" name="nombre_banco" maxlength="20" required>
                        <span class="span-value-modal" id="smnombre_banco"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificar_numero_cuenta">Número de Cuenta</label>
                        <input type="text" class="form-control" id="modificar_numero_cuenta" name="numero_cuenta" maxlength="23" required>
                        <span class="span-value-modal" id="smnumero_cuenta"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificar_rif_cuenta">RIF</label>
                        <input type="text" class="form-control" id="modificar_rif_cuenta" name="rif_cuenta" maxlength="12" required>
                        <span class="span-value-modal" id="smrif_cuenta"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificar_telefono_cuenta">Teléfono</label>
                        <input type="text" class="form-control" id="modificar_telefono_cuenta" name="telefono_cuenta" maxlength="13" required>
                        <span class="span-value-modal" id="smtelefono_cuenta"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificar_correo_cuenta">Correo</label>
                        <input type="email" class="form-control" id="modificar_correo_cuenta" name="correo_cuenta" maxlength="50" required>
                        <span class="span-value-modal" id="smcorreo_cuenta"></span>
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
<script src="Javascript/cuentas.js"></script>
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