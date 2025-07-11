<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'SuperUsuario') { ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Respaldos</title>
    <?php include 'header.php'; ?>
</head>

<?php include 'newnavbar.php'; ?>

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/fondo.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">

<div class="contenedor-tabla">
    <h3>Gestión de Respaldos</h3>
    <div class="grupo-form" style="margin-bottom: 20px; display: flex; justify-content: center; gap: 15px;">
        <button id="btn-backup-principal" class="btn btn-success">Generar Respaldo Principal</button>
        <button id="btn-backup-seguridad" class="btn btn-primary">Generar Respaldo Seguridad</button>
    </div>
    <h3>Respaldos Disponibles</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Archivo</th>
                <th>Acción</th>
            </tr>
        </thead>

<tbody>
    <?php foreach ($backups as $respaldo): ?>
    <tr>
        <td><?= htmlspecialchars($respaldo) ?></td>
        <td>
            <button class="btn btn-info btn-descargar" data-archivo="<?= htmlspecialchars($respaldo) ?>">Descargar</button>
            <button class="btn btn-warning btn-restaurar" data-archivo="<?= htmlspecialchars($respaldo) ?>">Restaurar</button>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
<script src="Javascript/backup.js"></script>
<script src="Public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="Public/js/jquery-3.7.1.min.js"></script>
<script src="Public/js/jquery.dataTables.min.js"></script>
<script src="Public/js/dataTables.bootstrap5.min.js"></script>
<script src="Public/js/datatable.js"></script>
<script>
$(document).ready(function() {
    $('#tablaConsultas').DataTable({
        order: [[0, 'desc']], // Ordena la primera columna de forma descendente
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