<?php require_once "utils.php"; ?>

<h2 class="text-primary" id="seccion-<?= $nombre_plural ?>">
    Gestión de <?= $nombre_plural ?>
</h2>

<section>
    <p>En la <strong>barra lateral</strong>, al hacer clic en <strong>Gestionar <?= $nombre_plural ?></strong> lo
        llevara a la <strong>Lista de <?= $nombre_plural ?></strong>.
    </p>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Barra lateral</th>
                <th>Lista de <?= $nombre_plural ?></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><?= renderImagen($id, "barra.png") ?></td>
                <td><?= renderImagen($id, "vista.png") ?></td>
            </tr>
        </tbody>
    </table>

    <p>En esta lista, podrá ajustar las cantidades de los articulos que desea comprar, así como
         eliminar individualmente los articulos del carrito:</p>

    
</section>