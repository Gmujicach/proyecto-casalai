<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'SuperUsuario') { ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Cuentas Bancarias</title>
    <?php include 'header.php'; ?>
</head>

<?php include 'newnavbar.php'; ?>

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<div class="modal fade modal-registrar" id="registrarCuentaModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarCuentaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="registrarCuenta" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarCuentaModalLabel">Incluir Cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="grupo-form">
                        <div class="grupo-interno">
                            <label for="nombre_banco">Nombre del Banco</label>
                            <input type="text" placeholder="Nombre" class="control-form" id="nombre_banco" name="nombre_banco" maxlength="20" required>
                            <span class="span-value" id="snombre_banco"></span>
                        </div>
                        <div class="grupo-interno">
                            <label for="numero_cuenta">Número de Cuenta</label>
                            <input type="text" placeholder="N° cuenta" class="control-form" id="numero_cuenta" name="numero_cuenta" maxlength="23" required>
                            <span class="span-value" id="snumero_cuenta"></span>
                        </div>
                    </div>
                    <div class="grupo-form">
                        <div class="grupo-interno">
                            <label for="rif_cuenta">RIF</label>
                            <input type="text" placeholder="RIF" class="control-form" id="rif_cuenta" name="rif_cuenta" maxlength="12" required>
                            <span class="span-value" id="srif_cuenta"></span>
                        </div>
                        <div class="grupo-interno">
                            <label for="telefono_cuenta">Número de Teléfono</label>
                            <input type="text" placeholder="Teléfono" class="control-form" id="telefono_cuenta" name="telefono_cuenta" maxlength="13" required>
                            <span class="span-value" id="stelefono_cuenta"></span>
                        </div>
                    </div>
                    <div class="envolver-form">
                        <label for="correo_cuenta">Correo Electrónico</label>
                        <input type="email" placeholder="Correo" class="control-form" id="correo_cuenta" name="correo_cuenta" maxlength="50" required>
                        <span class="span-value" id="scorreo_cuenta"></span>
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
        <button id="btnIncluirCuenta" class="btn-incluir">
            Incluir Cuenta Bancaria
        </button>
    </div>
    <h3>Lista de Cuentas Bancarias</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>ID</th>
                <th>Nombre del Banco</th>
                <th>Número de Cuenta</th>
                <th>RIF</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cuentabancos as $cuenta): ?>
                <tr data-id="<?php echo $cuenta['id_cuenta']; ?>">
                    <td>
                        <ul>
                            <div>
                                <button class="btn-modificar"
                                id="btnModificarCuenta"
                                data-id="<?php echo $cuenta['id_cuenta']; ?>"
                                data-nombre="<?php echo htmlspecialchars($cuenta['nombre_banco']); ?>"
                                data-numero="<?php echo htmlspecialchars($cuenta['numero_cuenta']); ?>"
                                data-rif="<?php echo htmlspecialchars($cuenta['rif_cuenta']); ?>"
                                data-telefono="<?php echo htmlspecialchars($cuenta['telefono_cuenta']); ?>"
                                data-correo="<?php echo htmlspecialchars($cuenta['correo_cuenta']); ?>"
                                >Modificar</button>
                            </div>
                            <div>
                                <button class="btn-eliminar"
                                data-id="<?php echo $cuenta['id_cuenta']; ?>"
                                >Eliminar</button>
                            </div>
                        </ul>
                    </td>
                    <td>
                        <span class="campo-numeros">
                            <?php echo htmlspecialchars($cuenta['id_cuenta']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-nombres">
                            <?php echo htmlspecialchars($cuenta['nombre_banco']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-numeros">
                            <?php echo htmlspecialchars($cuenta['numero_cuenta']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-rif-correo">
                            <?php echo htmlspecialchars($cuenta['rif_cuenta']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-numeros">
                            <?php echo htmlspecialchars($cuenta['telefono_cuenta']); ?>
                        </span>
                    </td>
                    <td>
                        <span class="campo-rif-correo">
                            <?php echo htmlspecialchars($cuenta['correo_cuenta']); ?>
                        </span>
                    </td>
                    <td>
                        <span 
                            class="campo-estatus <?php echo ($cuenta['estado'] == 'habilitado') ? 'habilitado' : 'inhabilitado'; ?>" 
                            data-id="<?php echo $cuenta['id_cuenta']; ?>" 
                            style="cursor: pointer;">
                            <?php echo htmlspecialchars($cuenta['estado']); ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade modal-modificar" id="modificarCuentaModal" tabindex="-1" role="dialog" 
aria-labelledby="modificarCuentaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="modificarCuenta" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="modificarCuentaModalLabel">Modificar Cuenta Bancaria</h5>
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