<div class="contenedor-backup">
    <h2>Gestión de Respaldos</h2>
    <button id="btn-backup-principal" class="btn btn-success">Generar Respaldo Principal</button>
    <button id="btn-backup-seguridad" class="btn btn-primary">Generar Respaldo Seguridad</button>
    <hr>
    <h4>Respaldos Disponibles</h4>
    <table class="table table-bordered" id="tablaRespaldos">
        <thead>
            <tr>
                <th>Archivo</th>
                <th>Acciones</th>
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
<script src="Javascript/backup.js"></script>