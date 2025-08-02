<?php require_once "utils.php"; ?>

<h2 class="text-primary-emphasis" id="ingresos y egresos-<?= $nombre_singular ?>">
    Generar reporte de <?= $nombre_plural ?>
</h2>

<p>El la <strong>Parte central</strong> de la vista encontrara una grafica que le mostrará
 los <strong> ingresos y egresos</strong> que tuvo la compañia.</p>

<p><?= renderImagen($id, "vista.png") ?></p>


<p>Presionar el botón <strong>Generar Reporte de <?= $reporte_boton ?? $nombre_plural ?></strong> le otorgara
    un documento <strong>PDF</strong>
    que podra descargar.</p>
<p>El reporte se generara con los datos de la compañia y el periodo que usted haya seleccionado.</p>
<?= renderImagen($id, "reporte-boton.png") ?>