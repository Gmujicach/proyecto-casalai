<?php require_once "utils.php"; ?>

<h2 class="text-primary" id="seccion-<?= $nombre_plural ?>">
    Gestión de <?= $nombre_plural ?>
</h2>

<section>
    <p>En la <strong>barra lateral</strong>, al hacer clic en <strong>Gestionar <?= $nombre_singular ?></strong> lo
        llevara a
        la
        <strong>Lista de <?= $nombre_plural ?></strong>.
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

    <p>En esta lista, por cada <strong><?= $nombre_singular ?></strong> podra gestionar:</p>

    <ul>
        <?php foreach ($gestionable as $item): ?>
            <li><?= $item ?></li>
        <?php endforeach ?>
    </ul>
</section>