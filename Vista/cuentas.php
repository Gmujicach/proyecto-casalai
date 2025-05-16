<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Cuentas Bancarias</title>
    <?php include 'header.php'; ?>
</head>

<body>
<?php include 'NewNavBar.php'; ?>

<div class="formulario-responsivo">
    <div class="fondo-form">
        <h3 class="titulo-form">INCLUIR CUENTA BANCARIA</h3>
        <button class="boton-form" data-toggle="modal" data-target="#registrarCuentaModal">Registrar Cuenta</button>
    </div>
</div>

<div class="contenedor-tabla">
    <h3>LISTA DE CUENTAS BANCARIAS</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Banco</th>
                <th>Número de Cuenta</th>
                <th>RIF</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($cuentabancos as $cuenta): ?>
            <tr>
                <td><?php echo htmlspecialchars($cuenta['id_cuenta']); ?></td>
                <td><?php echo htmlspecialchars($cuenta['nombre_banco']); ?></td>
                <td><?php echo htmlspecialchars($cuenta['numero_cuenta']); ?></td>
                <td><?php echo htmlspecialchars($cuenta['rif_cuenta']); ?></td>
                <td><?php echo htmlspecialchars($cuenta['telefono_cuenta']); ?></td>
                <td><?php echo htmlspecialchars($cuenta['correo_cuenta']); ?></td>
                <td>
                    <span class="campo-estado <?php echo ($cuenta['estado'] == 'Habilitado') ? 'Habilitado' : 'inhabilitado'; ?>">
                        <?php echo htmlspecialchars($cuenta['estado']); ?>
                    </span>
                </td>
                <td>
                    <button class="btn btn-primary" onclick="obtenerCuenta(<?php echo $cuenta['id_cuenta']; ?>)">Modificar</button>
                    <button class="btn btn-danger" onclick="eliminarCuenta(<?php echo $cuenta['id_cuenta']; ?>)">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para registrar cuenta -->
<div class="modal fade" id="registrarCuentaModal" tabindex="-1" role="dialog" aria-labelledby="registrarCuentaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="registrarCuenta">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrarCuentaModalLabel">Registrar Cuenta Bancaria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="form-group">
                        <label for="nombre_banco">Nombre del Banco</label>
                        <input type="text" class="form-control" id="nombre_banco" name="nombre_banco" required>
                    </div>
                    <div class="form-group">
                        <label for="numero_cuenta">Número de Cuenta</label>
                        <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" required>
                    </div>
                    <div class="form-group">
                        <label for="rif_cuenta">RIF</label>
                        <input type="text" class="form-control" id="rif_cuenta" name="rif_cuenta" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono_cuenta">Teléfono</label>
                        <input type="text" class="form-control" id="telefono_cuenta" name="telefono_cuenta" required>
                    </div>
                    <div class="form-group">
                        <label for="correo_cuenta">Correo</label>
                        <input type="email" class="form-control" id="correo_cuenta" name="correo_cuenta" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para modificar cuenta -->
<div class="modal fade" id="modificarCuentaModal" tabindex="-1" role="dialog" aria-labelledby="modificarCuentaModalLabel" aria-hidden="true">
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
                        <input type="text" class="form-control" id="modificar_nombre_banco" name="nombre_banco" required>
                    </div>
                    <div class="form-group">
                        <label for="modificar_numero_cuenta">Número de Cuenta</label>
                        <input type="text" class="form-control" id="modificar_numero_cuenta" name="numero_cuenta" required>
                    </div>
                    <div class="form-group">
                        <label for="modificar_rif_cuenta">RIF</label>
                        <input type="text" class="form-control" id="modificar_rif_cuenta" name="rif_cuenta" required>
                    </div>
                    <div class="form-group">
                        <label for="modificar_telefono_cuenta">Teléfono</label>
                        <input type="text" class="form-control" id="modificar_telefono_cuenta" name="telefono_cuenta" required>
                    </div>
                    <div class="form-group">
                        <label for="modificar_correo_cuenta">Correo</label>
                        <input type="email" class="form-control" id="modificar_correo_cuenta" name="correo_cuenta" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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

</body>
</html>