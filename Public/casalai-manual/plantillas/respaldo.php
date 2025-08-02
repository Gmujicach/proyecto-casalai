<?php require_once "utils.php"; ?>

<h3 class="text-primary-emphasis" id="incluir-<?= $nombre_singular ?>">
    Gestionar <?= $nombre_singular ?>
</h3>

<p>
    En la <strong>parte superior</strong> encontrara los botones para generar el respaldo <strong>de la base de datos principal</strong>
    y <strong>de la base de datos de seguridad</strong>.
</p>

<p><?= renderImagen($id, "generar.png") ?></p>

<p>Al generar el respaldo de la <strong>base de datos</strong> este aparecerá <strong>listado</strong></p>

<p><?= renderImagen($id, "listar-respaldos.png") ?></p>

<p>En caso de que desee restaurar alguna base de datos anterior, solo presione el botón restaurar: <?= renderImagen($id, "boton-respaldo.png") ?></p>

<p>Y en caso de que desee descargar alguna de las bases de datos listadas presione el botón descargar</p>