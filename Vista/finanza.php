<?php
if (!isset($_SESSION['name'])) {
    header('Location: .');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Ingresos y Egresos</title>
    <?php include 'header.php'; ?>
</head>

<body>
<?php include 'NewNavBar.php'; ?>

<div class="contenedor-tabla">
    <h3>INGRESOS DE LA EMPRESA</h3>
    <table class="tablaConsultas" id="tablaConsultas">
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
</div>

<div class="contenedor-tabla">
    <h3>EGRESOS DE LA EMPRESA</h3>
    <table class="tablaConsultas" id="tablaConsultas">
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
</div>

<?php include 'footer.php'; ?>
<script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="Javascript/finanza.js"></script>

</body>
</html>