<?php if ($_SESSION['rango'] == 'Administrador') {?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Ingresos y Egresos</title>
    <?php include 'header.php'; ?>
</head>

<body  class="fondo" style=" height: 100vh; background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat;">
<?php include 'NewNavBar.php'; ?>

<div class="contenedor-tabla">
    <h3>Ingresos de la Empresa</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($finanzas['ingresos'] as $ing): ?>
            <tr>
                <td><?= $ing['fecha'] ?></td>
                <td><?= number_format($ing['monto'],2) ?></td>
                <td><?= $ing['descripcion'] ?></td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="contenedor-tabla">
    <h3>Egresos de la Empresa</h3>
    <table class="tablaConsultas" id="tablaConsultas">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($finanzas['egresos'] as $eg): ?>
            <tr>
                <td><?= $eg['fecha'] ?></td>
                <td><?= number_format($eg['monto'],2) ?></td>
                <td><?= $eg['descripcion'] ?></td>

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

<?php
} else {
    header("Location: ?pagina=acceso-denegado"); 
    exit;
}
?>