<?php if ($_SESSION['nombre_rol'] == 'Administrador' || $_SESSION['nombre_rol'] == 'SuperUsuario') { ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bitácora del Sistema</title>
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/js/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="Styles/tabla_consulta.css">
    <?php include 'header.php'; ?>
    <style>
        .contenedor-tabla {
            margin-top: 40px;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body class="fondo" style="background-image: url(IMG/FONDO.jpg); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh;">
<?php include 'newnavbar.php'; ?>

<div class="contenedor-tabla">
    <h3>Bitácora del Sistema</h3>
    <div class="table-responsive">
        <table class="tablaConsultas table table-striped table-hover align-middle" id="tablaBitacora">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Fecha y Hora</th>
                    <th>Acción</th>
                    <th>ID Módulo</th>
                    <th>ID Usuario</th>
                </tr>
            </thead>
            <tbody id="tbodyBitacora">
                <?php if (!empty($registros)): ?>
                    <?php foreach ($registros as $registro): ?>
                        <tr>
                            <td><?= htmlspecialchars($registro['id_bitacora']) ?></td>
                            <td><?= htmlspecialchars($registro['fecha_hora']) ?></td>
                            <td><?= htmlspecialchars($registro['accion']) ?></td>
                            <td><?= htmlspecialchars($registro['id_modulo']) ?></td>
                            <td><?= htmlspecialchars($registro['id_usuario']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay registros en la bitácora.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/js/jquery.dataTables.min.js"></script>
<script src="public/js/dataTables.bootstrap5.min.js"></script>
<script src="javascript/bitacora.js"></script>
</body>
</html>

</script>
</body>
</html>
<?php } else {
    header("Location: ?pagina=acceso-denegado");
    exit;
} ?>
