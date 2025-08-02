<?php require_once "utils.php"; ?>

<h3 class="text-primary-emphasis" id="incluir-<?= $nombre_singular ?>">
    Mostrar <?= $nombre_singular ?>
</h3>

<p>
    En la sección <strong>Gestionar <?= $nombre_singular ?></strong> encontrará los registros de las acciones realizadas por los usuarios en el sistema.
</p>

<p><?= renderImagen($id, "listar.png") ?></p>