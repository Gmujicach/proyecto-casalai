<?php require_once "utils.php"; ?>

<h2 class="text-primary-emphasis" id="estado-<?= $nombre_singular ?>">
    Cambiar estado de <?= $nombre_singular ?>
</h2>

<p>En la columna <strong>Estatus</strong> se encuentra el estado de <strong><?= $nombre_singular ?></strong>.</p>

<?= renderImagen($id, "estado-boton.png") ?>

<p>Dar clic alternara entre los estados <strong>Habilitado / Deshabilitado</strong> mostrara una
    confirmación.</p>

<?= renderImagen($id, "estado-modal.png") ?>