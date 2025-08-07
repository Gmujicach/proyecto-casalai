<?php require_once "utils.php"; ?>

<h3 class="text-primary-emphasis" id="modificar-<?= $nombre_singular ?>">
    Modificar <?= $nombre_singular ?>
</h3>

<p>En la <strong>parte central</strong> encontrará la sección para ajustar la cantidad de artículos
:</p>


<p>Ingresar la cantidad manualmente o <strong>usando el mouse</strong> puede
 aumentar o disminuir la cantidad</p>
<p><?= renderImagen($id, "modificar-carrito.png") ?></p>

<p>Seleccione la cantidad.</p>

<p>Si desea <strong>eliminar</strong> un artículo del carrito, presione el botón <strong>Eliminar</strong> que se
    encuentra a la derecha de cada artículo.</p>

<p><?= renderImagen($id, "eliminar-articulo.png") ?></p>

<p>En caso de eliminar todo el contenido del carrito, presione el botón <strong>Eliminar todo el carrito</strong>.</p>

<p><?= renderImagen($id, "eliminar-todo-carrito.png") ?></p>

<p>Para <strong>finalizar la compra</strong>, presione el botón <strong>Prefacturar</strong> que se encuentra en la
    parte derecha.</p>

<p><?= renderImagen($id, "boton-prefacturar.png") ?></p>
