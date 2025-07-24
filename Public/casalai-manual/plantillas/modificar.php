<?php require_once "utils.php"; ?>

<h3 class="text-primary-emphasis" id="modificar-<?= $nombre_singular ?>">
    Modificar <?= $nombre_singular ?>
</h3>

<p>En la <strong><?= $modificar_ubicacion ?></strong> de <strong><?= $nombre_singular ?></strong> encontrara
    el
    boton
    <strong>Modificar</strong>:
</p>

<p><?= renderImagen($id, "modificar-boton.png") ?></p>

<p>Dar <strong>clic</strong> en el boton <strong>Modificar</strong> lo llevara a la <strong>siguiente
        vista</strong>:</p>

<p><?= renderImagen($id, "modificar-modal.png") ?></p>

<p>Modifique los campos que desee.</p>
<?php if (isset($modificar_extra)): ?>
    <p><?= $modificar_extra ?></p>
<?php endif ?>
<p>Una vez terminado podra:</p>

<ul>
    <li>Presionar <strong>Guardar Cambios</strong> para aplicar sus cambios.</li>
    <li>Presionar <strong>Cancelar</strong> o presionar la <strong>X</strong> en la <strong>parte superior</strong> para
        <strong>NO</strong> aplicar sus cambios.
    </li>
</ul>

<p><strong>Todos los campos deben ser llenados, de lo contrario se emitira un mensaje de error y no se
        completara el
        registro.</strong></p>