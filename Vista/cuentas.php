<?php
if (!isset($_SESSION['name'])) {
    header('Location: .');
    exit();
}
?>
    <title>Gestionar Cuentas Bancarias</title>
    <?php include 'header.php'; ?>
</head>

<body>
<?php include 'NewNavBar.php'; ?>

<div class="formulario-responsivo">
    <div class="fondo-form">
        <form id="registrarCuenta" action="" method="POST">
            <input type="hidden" name="accion" value="registrar">
            <h3 class="titulo-form">INCLUIR CUENTA BANCARIA</h3>
            
            <div class="envolver-form">
                <input type="text" placeholder="Nombre del banco" class="control-form" id="nombre_banco" name="nombre_banco" required>
                <span id="snombre_banco"></span>
            </div>
            <div class="envolver-form">
                <input type="text" placeholder="Número de cuenta" class="control-form" id="numero_cuenta" name="numero_cuenta" required>
                <span id="snumero_cuenta"></span>
            </div>
            <div class="envolver-form">
                <input type="text" placeholder="RIF" class="control-form" id="rif_cuenta" name="rif_cuenta" required>
                <span id="srif_cuenta"></span>
            </div>
            <div class="envolver-form">
                <input type="text" placeholder="Número de teléfono" class="control-form" id="telefono_cuenta" name="telefono_cuenta" required>
                <span id="stelefono_cuenta"></span>
            </div>
            <div class="envolver-form">
                <input type="email" placeholder="Correo electrónico" class="control-form" id="correo_cuenta" name="correo_cuenta" required>
                <span id="scorreo_cuenta"></span>
            </div>

            <button class="boton-form" type="submit">Registrar</button>

        </form>
    </div>
</div>

<div class="contenedor-tabla">
    <h3>LISTA DE CUENTAS BANCARIAS</h3>
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
                            class="campo-estado <?php echo ($cuenta['estado'] == 'Habilitado') ? 'Habilitado' : 'Inhabilitado'; ?>" 
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