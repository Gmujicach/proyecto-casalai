<?php require_once "utils.php"; ?>

<h2 class="text-primary-emphasis" id="reporte-<?= $nombre_singular ?>">
    Generar reporte de <?= $nombre_plural ?>
</h2>

<p>Presionar el botón <strong>Generar Reporte de <?= $reporte_boton ?? $nombre_plural ?></strong> le otorgara
    un documento <strong>PDF</strong>
    que podra descargar.</p>

<p>En la <strong>Parte inferior</strong> de la vista encontrara una grafica.</p>

<?= renderImagen($id, "reporte-boton.png") ?>
