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
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($marcas as $marca): ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($marca['nombre_marca']); ?>
                    </td>
                    <td>
                        <span>
                            <div class="acciones-boton">
                            <i class="vertical">
                                <img src="IMG/more_opcion.svg" alt="Ícono" width="16" height="16">
                            </i>
                                <div class="desplegable">
                                    <ul>
                                        <li><a href="#" class="modificar" data-toggle="modal" data-target="#modificar_usuario_modal" onclick="obtenerUsuario(<?php echo $usuario['id_marca']; ?>)">Modificar</a></li>
                                        <li><a href="#" class="eliminar" onclick="eliminarUsuario(<?php echo $usuario['id_marca']; ?>)">Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Filas por Página: 
                    <select id="filasPorPagina" onchange="cambiarFilasPorPagina(this.value)">
                        <option value="10" <?= $filasPorPagina == 10 ? 'selected' : '' ?>>10</option>
                        <option value="20" <?= $filasPorPagina == 20 ? 'selected' : '' ?>>20</option>
                        <option value="50" <?= $filasPorPagina == 50 ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= $filasPorPagina == 100 ? 'selected' : '' ?>>100</option>
                    </select>
                </td>
                <td><?= "$inicio-$fin de $totalMarcas" ?></td>
                <td>
                    <a href="?pagina=<?= max(1, $paginaActual - 1) ?>&filas=<?= $filasPorPagina ?>">
                        <i class="flecha-izquierda"><img src="IMG/flecha_izquierda.svg" alt="Anterior" width="16" height="16"></i>
                    </a>
                </td>
                <td>
                    <a href="?pagina=<?= min(ceil($totalMarcas / $filasPorPagina), $paginaActual + 1) ?>&filas=<?= $filasPorPagina ?>">
                        <i class="flecha-derecha"><img src="IMG/flecha_derecha.svg" alt="Siguiente" width="16" height="16"></i>
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Modal para modificar marca -->
<div class="modal fade" id="modificarMarcaModal" tabindex="-1" role="dialog" aria-labelledby="modificarMarcaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarMarca" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificarMarcaModalLabel">Modificar Marca</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
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

<script>
function cambiarFilasPorPagina(filas) {
    const url = new URL(window.location.href);
    url.searchParams.set('filas', filas);
    url.searchParams.set('pagina', 1); // Resetear a primera página
    window.location.href = url.toString();
}
</script>
<script src="public/bootstrap/js/sidebar.js"></script>
  
  <script src="public/js/jquery.dataTables.min.js"></script>
  <script src="public/js/dataTables.bootstrap5.min.js"></script>
  <script src="public/js/datatable.js"></script>
  <script src="Javascript/sweetalert2.all.min.js"></script>

<script src="Javascript/validaciones.js"></script>
</body>
</html>