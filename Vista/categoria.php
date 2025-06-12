<?php if ($_SESSION['rango'] == 'Administrador') { ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Categoria</title>
    <?php include 'header.php'; ?>
</head>
<body class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<?php include 'NewNavBar.php'; ?>

<div class="modal fade modal-registrar" id="registrarCategoriaModal" tabindex="-1" role="dialog" 
aria-labelledby="registrarCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="registrarCategoria" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="registrarCategoriaModalLabel">Incluir Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" value="registrar">
                    <div class="envolver-form">
                        <label for="nombre_categoria">Nombre de la categoria</label>
                        <input type="text" placeholder="Categoria" class="control-form" id="nombre_categoria" name="nombre_categoria" maxlength="20" required>
                        <span class="span-value" id="snombre_categoria"></span>
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
        <button id="btnIncluirCategoria" class="btn-incluir">
            Incluir Categoria
        </button>
    </div>

    <h3>Lista de Categorias</h3>
    
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>ID</th>
                <th>Nombre</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr data-id="<?php echo $categoria['id_categoria']; ?>">
                    <td>
                        <ul>
                            <div>
                                <button class="btn-modificar"
                                data-id="<?php echo $categoria['id_categoria']; ?>"
                                data-nombre="<?php echo htmlspecialchars($categoria['nombre_categoria']); ?>"
                                >Modificar</button>
                            </div>
                            <div>
                                <button class="btn-eliminar"
                                data-id="<?php echo $categoria['id_categoria']; ?>"
                                >Eliminar</button>
                            </div>
                        </ul>
                    </td>
                    <td><?php echo htmlspecialchars($categoria['id_categoria']); ?></td>
                    <td><?php echo htmlspecialchars($categoria['nombre_categoria']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table> 
</div>

<div class="modal fade modal-modificar" id="modificarCategoriaModal" tabindex="-1" role="dialog" 
aria-labelledby="modificarCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="modificarCategoria" method="POST">
                <div class="modal-header">
                    <h5 class="titulo-form" id="modificarCategoriaModalLabel">Modificar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modificar_id_categoria" name="id_categoria">
                    <div class="form-group">
                        <label for="modificar_nombre_categoria">Nombre de la categoria</label>
                        <input type="text" class="form-control" id="modificar_nombre_categoria" name="nombre_categoria" maxlength="20" required>
                        <span class="span-value-modal" id="smnombre_categoria"></span>
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
<script src="Javascript/categoria.js"></script>
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