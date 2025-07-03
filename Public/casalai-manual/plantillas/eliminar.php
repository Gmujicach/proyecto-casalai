<?php require_once "utils.php"; ?>

<h3 class="text-primary-emphasis" id="eliminar-<?= $nombre_singular ?>">
    Eliminar <?= $nombre_singular ?>
</h3>

<p>En la <strong><?= $modificar_ubicacion ?></strong> de una <strong><?= $nombre_singular ?></strong> encontrara
    el
    boton
    <strong>Eliminar</strong>:
</p>

<p><?= renderImagen($id, "eliminar-boton.png") ?></p>

<p>Dar <strong>clic</strong> en <strong>Eliminar</strong> lo llevara a la <strong>siguiente vista</strong>:</p>

<p><?= renderImagen($id, "eliminar-modal.png") ?></p>

<p>Debera seleccionar una opción:</p>

<ul>
    <li>Presione <strong>"Si, eliminarlo!"</strong> para eliminarlo.</li>
    <li>Presionar <strong>Cancelar</strong> para <strong>NO</strong> eliminarlo.</li>
</ul>