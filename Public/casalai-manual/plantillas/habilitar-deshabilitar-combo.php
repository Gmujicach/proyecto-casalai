<?php require_once "utils.php"; ?>

<h3 class="text-primary-emphasis" id="modificar-<?= $nombre_singular ?>">
    Habilitar/Deshabilitar <?= $nombre_singular ?>
</h3>

<p>En la <strong>parte inferior derecha</strong> encontrara el boton <strong>Habilitar/Deshabilitar</strong> combo:</p>

<p><?= renderImagen($id, "btn-des-combo.png") ?></p>


<p>Dar <strong>clic</strong> en el boton para <strong>Habilitar o Deshabilitar</strong> lo llevara a la <strong>siguiente
        vista</strong>:</p>

<p><?= renderImagen($id, "btn-hab-combo.png") ?></p>


<p>En caso de que desea activar el combo presione el botón <strong>habilitar</strong>:</p>
<p><?= renderImagen($id, "modal-hab-combo.png") ?></p>

<p>En caso de que desea desactivar el combo presione el botón <strong>deshabilitar</strong>:</p>
<p><?= renderImagen($id, "modal-des-combo.png") ?></p>