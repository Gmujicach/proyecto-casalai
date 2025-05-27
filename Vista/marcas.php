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
    <title>Gestionar Marcas</title>
    <?php include 'header.php'; ?>
</head>
<body>

<?php include 'NewNavBar.php'; ?>

<div class="formulario-responsivo">
    <div class="fondo-form">
        <form id="registrarMarca" action="" method="POST">
            <input type="hidden" name="accion" value="registrar">
            <h3 class="titulo-form">INCLUIR MARCA</h3>
            <div class="envolver-form">
                <input type="text" placeholder="Nombre de la Marca" class="control-form" id="nombre_marca" name="nombre_marca" maxlength="25" required>
                <span class="span-value" id="snombre_marca"></span>
            </div>

            <button class="boton-form" type="submit">Registrar</button>
            <button class="boton-reset" type="reset">Reset</button>
        </form>
    </div>
</div>

<div class="contenedor-tabla">
    <h3>Lista de Marcas</h3>
    
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th><i class="vertical">
                        <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                    </i>
                </th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($marcas as $marca): ?>
                <tr data-id="<?php echo $marca['id_marca']; ?>">
                    <td><?php echo htmlspecialchars($marca['id_marca']); ?></td>
                    <td><?php echo htmlspecialchars($marca['nombre_marca']); ?></td>
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
                                            data-id="<?php echo $marca['id_marca']; ?>"
                                            data-nombre="<?php echo htmlspecialchars($marca['nombre_marca']); ?>"
                                            >Modificar</button>
                                        </li>
                                        <li>
                                            <button class="btn btn-danger btn-eliminar"
                                            data-id="<?php echo $marca['id_marca']; ?>"
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

<!-- Modal para modificar marca -->
<div class="modal fade modal-modificar" id="modificarMarcaModal" tabindex="-1" role="dialog" aria-labelledby="modificarMarcaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarMarca" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarMarcaModalLabel">Modificar Marca</h5>
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
<script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="Javascript/marcas.js"></script>

<script src="public/bootstrap/js/sidebar.js"></script>

<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="public/js/datatable.js"></script>

</body>
</html>