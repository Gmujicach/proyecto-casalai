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
        <form id="incluirmarcas" action="" method="POST">
            <input type="hidden" name="accion" value="ingresar">
            <h3 class="titulo-form">INCLUIR MARCA</h3>
            <div class="envolver-form">
                <input type="text" placeholder="Nombre de la Marca" maxlength="15" class="control-form" id="nombre_marca" name="nombre_marca" required>
                <span id="snombre_marca"></span>
            </div>
            <div class="form-group d-flex justify-content-center">
                <button type="submit" class="boton-form">Registrar</button>
            </div>
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
        <?php foreach ($marcas as $marcas): ?>
            <tr>
                <td>
                    <span class="nombre-usuario">
                    <?php echo htmlspecialchars($marcas['nombre_marca']); ?>
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
                                    <li><a href="#" class="modificar" data-toggle="modal" data-target="#modificar_usuario_modal" onclick="obtenerUsuario(<?php echo $usuario['id_marca']; ?>)">Modificar</a></li>
                                    <li><a href="#" class="eliminar" onclick="eliminarUsuario(<?php echo $usuario['id_marca']; ?>)">Eliminar</a></li>
                                </ul>
                            </div>
                        </div>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
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
        </tbody>
    </table>




<!-- Modal de modificación -->
    <div class="modal fade" id="modificar_usuario_modal" tabindex="-1" role="dialog" aria-labelledby="modificar_usuario_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarusuario" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modificar_usuario_modal_label">Modificar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Campos del formulario de modificación -->
                    <input type="hidden" id="modificar_id_usuario" name="id_usuario">
                    <div class="form-group">
                        <label for="modificarnombre_usuario">Nombre del Usuario</label>
                        <input type="text" class="form-control" id="modificarnombre_usuario" name="nombre_usuario" maxlength="15" required>
                        <span id="smodificarnombre_usuario"></span>
                    </div>
                    <div class="form-group">
                        <label for="modificarclave_usuario">Contraseña del Usuario</label>
                        <input type="text" class="form-control" id="modificarclave_usuario" name="clave_usuario" required>
                        <span id="smodificarclave_usuario"></span>
                    </div>
                    <div class="form-group col-md-4">
                                    <label for="rango">Categorias</label>
                                    <select class="custom-select" id="rango" name="rango">
                                    <option value="USUARIO">Usuario</option>
                                                        <option value="admin">Administrador</option>
                                                        <option value="almacen">Almacen</option>    
                                    </select>
                                </div>
                    
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-cerrar" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

<script>
function cambiarFilasPorPagina(filas) {
    const url = new URL(window.location.href);
    url.searchParams.set('filas', filas);
    url.searchParams.set('pagina', 1); // Resetear a primera página
    window.location.href = url.toString();
}
</script>
<script src="public/bootstrap/js/sidebar.js"></script>
  <script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="public/js/jquery-3.7.1.min.js"></script>
  <script src="public/js/jquery.dataTables.min.js"></script>
  <script src="public/js/dataTables.bootstrap5.min.js"></script>
  <script src="public/js/datatable.js"></script>
  <script src="Javascript/sweetalert2.all.min.js"></script>
<script src="Javascript/marcas.js"></script>
<script src="Javascript/validaciones.js"></script>
</body>
</html>