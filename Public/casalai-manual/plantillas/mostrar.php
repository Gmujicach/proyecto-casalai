<?php require_once "utils.php"; ?>

<h3 class="text-primary-emphasis" id="incluir-<?= $nombre_singular ?>">
    Mostrar <?= $nombre_singular ?>
</h3>

<p>
    En la sección <strong>catalogo</strong> encontrará todos los productos disponibles en la tienda.
</p>

<p><?= renderImagen($id, "vista.png") ?></p>


<p>Al hacer <strong>clic</strong> en el botón <strong>Agregar</strong> se desplegara una ventana donde podrá seleccionar la contidad 
de productos que desea adquirir:</p>
<p><?= renderImagen($id, "cantidad.png") ?></p>

<p>Al presionar el botón <strong>Agregar al carrito</strong> el producto sera añadido al carrito de compras</p>
<p><?= renderImagen($id, "agregar-producto-carrito.png") ?></p>
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