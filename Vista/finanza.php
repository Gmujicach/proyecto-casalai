<?php
<!-- filepath: Vista/finanza.php -->
<h2>Ingresos</h2>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Monto</th>
            <th>Descripción</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($finanzas['ingresos'] as $ing): ?>
        <tr>
            <td><?= $ing['fecha'] ?></td>
            <td><?= number_format($ing['monto'],2) ?></td>
            <td><?= $ing['descripcion'] ?></td>
            <td>
                <?php if($ing['estado']): ?>
                <button class="anular-finanza" data-id="<?= $ing['id_finanzas'] ?>">Anular</button>
                <?php else: ?>
                <span style="color:red;">Anulado</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Egresos</h2>
<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Monto</th>
            <th>Descripción</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($finanzas['egresos'] as $eg): ?>
        <tr>
            <td><?= $eg['fecha'] ?></td>
            <td><?= number_format($eg['monto'],2) ?></td>
            <td><?= $eg['descripcion'] ?></td>
            <td>
                <?php if($eg['estado']): ?>
                <button class="anular-finanza" data-id="<?= $eg['id_finanzas'] ?>">Anular</button>
                <?php else: ?>
                <span style="color:red;">Anulado</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script src="Javascript/finanza.js"></script>