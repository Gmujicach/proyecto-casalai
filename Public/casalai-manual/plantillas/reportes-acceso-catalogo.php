<?php require_once "utils.php"; ?>

<h2 class="text-primary-emphasis" id="reporte-<?= $nombre_singular ?>">
    Generar reportes de accesos al catálogo
</h2>

<p>En esta sección podrá ver informacion detallada sobre el acceso de los
     usuarios al catalogo de productos.</p>
<?= renderImagen($id, "vista-reporte-catalogo.png") ?>


<p>Presionar el botón <strong>Descargar PDF accesos</strong> le otorgara
    un documento <strong>PDF</strong> que podra descargar.</p>

<p>Presionar el botón <strong>Descargar PDF usuarios</strong> le otorgara
    un documento <strong>PDF</strong> que podra descargar.</p>
<?= renderImagen($id, "botones-reporte-catalogo.png") ?>


<p>En la <strong>Parte inferior</strong> de la vista encontrara varias graficas con los
    accesos al catalogo de productos.</p>

<?= renderImagen($id, "reportes-graficos.png") ?>
