<?php require_once "utils.php"; ?>

<h3 class="text-primary-emphasis" id="incluir-<?= $nombre_singular ?>">
    Gestionar <?= $nombre_singular ?>
</h3>

<p>
    En la <strong>parte superior</strong> encontrara los botones para seleccionar el <strong>Rol.</strong>
</p>

<p><?= renderImagen($id, "rol.png") ?></p>

<p>Una vez seleccionado el <strong>rol</strong> deberá elegir los <strong>permisos</strong> correspondientes al usuario seleccionado:</p>

<p><?= renderImagen($id, "lista-permisos.png") ?></p>

<p>Una vez seleccionados los permisos deberá presionar el botón: <?= renderImagen($id, "boton-guardar.png") ?></p>

<p>Para guardar los permisos</p>