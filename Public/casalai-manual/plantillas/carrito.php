<?php require_once "utils.php"; ?>

<h3 class="text-primary-emphasis" id="incluir-<?= $nombre_singular ?>">
    Incluir <?= $nombre_singular ?>
</h3>

<p>
    En la <strong>parte superior</strong> encontrara el boton <strong>Incluir <?= $nombre_singular ?>.</strong>
</p>

<p><?= renderImagen($id, "incluir-boton.png") ?></p>

<p>Al hacer <strong>clic</strong> lo llevara a la <strong>siguiente vista</strong>:</p>

<p><?= renderImagen($id, "incluir-modal.png") ?></p>

<p><strong>Deberá introducir los datos indicados:</strong></p>

<ul>
    <?php foreach ($instrucciones as $item): ?>
        <li><?= $item ?></li>
    <?php endforeach ?>
</ul>

<p><strong>Una vez ingresado todos los datos:</strong></p>

<ul>
    <li>Presione el boton <strong>Registrar</strong> para completar el registro.</li>
    <li>En caso de cometer un error puede presionar el boton <strong>Reset</strong> para vaciar todos los
        campos.
    </li>
</ul>

<p>
    <strong>Todos los campos deben ser llenados, de lo contrario se emitira un mensaje de error y no se
        completara el
        registro.</strong>
</p>